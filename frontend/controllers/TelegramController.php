<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\components\TelegramBot;
use common\models\Category;
use common\models\Question;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

/**
 * TelegramController - Telegram bot webhook va so'rovlarini qabul qilish
 */
class TelegramController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function beforeAction($action): bool
    {
        if ($action->id === 'webhook') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Bot haqida ma'lumot sahifasi
     */
    public function actionIndex(): string
    {
        return $this->renderContent('
            <div class="container py-5 text-center">
                <h1>🤖 Zakovat Telegram Boti</h1>
                <p class="lead text-muted">Telegram orqali intellektual zakovat savollari va testlarni yechish imkoniyati.</p>
                <div class="card p-4 mx-auto mt-4" style="max-width: 500px; box-shadow: var(--shadow-md);">
                    <h5>Bot buyruqlari:</h5>
                    <ul class="text-start mb-0">
                        <li><code>/start</code> — Botni ishga tushirish</li>
                        <li><code>/savol</code> — Tasodifiy Zakovat savolini olish</li>
                        <li><code>/test</code> — 4 variantli test olish</li>
                        <li><code>/kategoriyalar</code> — Mavjud kategoriyalar</li>
                        <li><code>/kun_savoli</code> — Kun savoli</li>
                    </ul>
                </div>
            </div>
        ');
    }

    /**
     * Telegram Webhook qabul qiluvchi action
     */
    public function actionWebhook(): Response
    {
        $raw = file_get_contents('php://input');
        if (empty($raw)) {
            return $this->asJson(['status' => 'empty']);
        }

        $update = Json::decode($raw);
        $bot = new TelegramBot();

        // 1. Matnli xabarlar
        if (isset($update['message'])) {
            $msg = $update['message'];
            $chatId = $msg['chat']['id'];
            $text = trim($msg['text'] ?? '');

            if ($text === '/start') {
                $welcome = "👋 <b>Assalomu alaykum, Zakovat intellektual platformasiga xush kelibsiz!</b>\n\n"
                    . "Bu bot orqali siz intellektual salohiyatingizni sinashingiz va turli sohalar bo'yicha savollarga javob berishingiz mumkin.\n\n"
                    . "👇 <b>Quyidagi menyudan birini tanlang:</b>";

                $keyboard = [
                    'keyboard' => [
                        [['text' => '💡 Tasodifiy Zakovat savoli'], ['text' => '📝 Variantli Test']],
                        [['text' => '📂 Kategoriyalar'], ['text' => '🌟 Kun savoli']],
                    ],
                    'resize_keyboard' => true,
                ];

                $bot->sendMessage($chatId, $welcome, $keyboard);
            } elseif ($text === '/savol' || $text === '💡 Tasodifiy Zakovat savoli') {
                $this->sendRandomZakovatQuestion($bot, $chatId);
            } elseif ($text === '/test' || $text === '📝 Variantli Test') {
                $this->sendRandomTestPoll($bot, $chatId);
            } elseif ($text === '/kategoriyalar' || $text === '📂 Kategoriyalar') {
                $this->sendCategoriesList($bot, $chatId);
            } elseif ($text === '/kun_savoli' || $text === '🌟 Kun savoli') {
                $this->sendDailyQuestion($bot, $chatId);
            } else {
                $bot->sendMessage($chatId, "Quyidagi tugmalardan birini bosing yoki /savol deb yozing.");
            }
        }

        // 2. Callback query (Inline tugmalar bosilganda)
        if (isset($update['callback_query'])) {
            $cq = $update['callback_query'];
            $cqId = $cq['id'];
            $chatId = $cq['message']['chat']['id'];
            $data = $cq['data'] ?? '';

            if (str_starts_with($data, 'answer_')) {
                $qId = (int)str_replace('answer_', '', $data);
                $q = Question::findOne($qId);
                if ($q) {
                    $ansText = "💡 <b>To'g'ri javob:</b>\n" . htmlspecialchars($q->answer ?: 'Javob kiritilmagan');
                    $bot->sendMessage($chatId, $ansText);
                    $bot->answerCallbackQuery($cqId, 'Javob ochildi!');
                }
            }
        }

        return $this->asJson(['ok' => true]);
    }

    /**
     * Tasodifiy Zakovat ochiq savolini jo'natish
     */
    private function sendRandomZakovatQuestion(TelegramBot $bot, int|string $chatId): void
    {
        /** @var Question|null $q */
        $q = Question::find()
            ->where(['status' => 1])
            ->orderBy(new \yii\db\Expression('RAND()'))
            ->one();

        if (!$q) {
            $bot->sendMessage($chatId, "Hozircha bazada savollar mavjud emas.");
            return;
        }

        $categoryName = $q->category ? $q->category->name : 'Umumiy';
        $diff = $q->getDifficultyLabel();

        $text = "📁 <b>Kategoriya:</b> {$categoryName} | <b>Daraja:</b> {$diff}\n\n"
            . "❓ <b>Savol:</b>\n"
            . htmlspecialchars($q->question_text) . "\n\n"
            . "⏳ <i>O'ylab ko'ring va tayyor bo'lsangiz quyidagi tugmani bosing:</i>";

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '👁️ Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id],
                    ['text' => '➡️ Keyingi savol', 'callback_data' => 'next_question']
                ]
            ]
        ];

        $bot->sendMessage($chatId, $text, $keyboard);
    }

    /**
     * Variantli Test Poll jo'natish
     */
    private function sendRandomTestPoll(TelegramBot $bot, int|string $chatId): void
    {
        /** @var Question|null $q */
        $q = Question::find()
            ->where(['status' => 1, 'type' => 'choice'])
            ->andWhere(['not', ['option_a' => null]])
            ->orderBy(new \yii\db\Expression('RAND()'))
            ->one();

        if (!$q) {
            // Agar choice savoli yo'q bo'lsa, zakovat savoli jo'natiladi
            $this->sendRandomZakovatQuestion($bot, $chatId);
            return;
        }

        $options = array_filter([
            $q->option_a,
            $q->option_b,
            $q->option_c,
            $q->option_d,
        ]);

        $correctIndex = 0;
        $corr = strtoupper((string)$q->correct_option);
        if ($corr === 'B') $correctIndex = 1;
        elseif ($corr === 'C') $correctIndex = 2;
        elseif ($corr === 'D') $correctIndex = 3;

        $bot->sendQuizPoll(
            $chatId,
            $q->question_text,
            array_values($options),
            $correctIndex,
            $q->answer ?: ''
        );
    }

    /**
     * Kategoriyalar ro'yxatini chiqarish
     */
    private function sendCategoriesList(TelegramBot $bot, int|string $chatId): void
    {
        $categories = Category::find()->where(['status' => 1])->all();
        if (empty($categories)) {
            $bot->sendMessage($chatId, "Hozircha faol kategoriyalar mavjud emas.");
            return;
        }

        $text = "📚 <b>Mavjud kategoriyalar:</b>\n\n";
        foreach ($categories as $cat) {
            $count = $cat->getQuestions()->count();
            $icon = $cat->icon ?: '📁';
            $text .= "{$icon} <b>{$cat->name}</b> — {$count} ta savol\n";
        }

        $bot->sendMessage($chatId, $text);
    }

    /**
     * Kun savoli
     */
    private function sendDailyQuestion(TelegramBot $bot, int|string $chatId): void
    {
        $q = Question::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->one();
        if ($q) {
            $text = "🌟 <b>Bugungi kun savoli:</b>\n\n"
                . htmlspecialchars($q->question_text);

            $keyboard = [
                'inline_keyboard' => [
                    [['text' => '💡 Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]]
                ]
            ];

            $bot->sendMessage($chatId, $text, $keyboard);
        } else {
            $bot->sendMessage($chatId, "Hozircha kun savoli belgilanmagan.");
        }
    }
}
