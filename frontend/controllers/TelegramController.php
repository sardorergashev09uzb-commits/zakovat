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
            $name = $msg['from']['first_name'] ?? 'Foydalanuvchi';

            if ($text === '/start') {
                $welcome = "👋 <b>Assalomu alaykum, {$name}! Zakovat intellektual platformasiga xush kelibsiz!</b>\n\n"
                    . "🧠 Bu bot orqali siz intellektual salohiyatingizni sinashingiz va turli sohalar bo'yicha savollarga javob berishingiz mumkin.\n\n"
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
                $this->sendZakovatQuestion($bot, $chatId);
            } elseif ($text === '/test' || $text === '📝 Variantli Test') {
                $this->sendTestPoll($bot, $chatId);
            } elseif ($text === '/kategoriyalar' || $text === '📂 Kategoriyalar') {
                $this->sendCategoriesMenu($bot, $chatId);
            } elseif ($text === '/kun_savoli' || $text === '🌟 Kun savoli') {
                $this->sendDailyQuestion($bot, $chatId);
            }
        }

        // 2. Callback query (Inline tugmalar)
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
                    $bot->sendMessage($chatId, $ansText, [
                        'inline_keyboard' => [
                            [
                                ['text' => '➡️ Keyingi savol', 'callback_data' => 'next_q'],
                                ['text' => '📂 Kategoriyalar', 'callback_data' => 'show_cats']
                            ]
                        ]
                    ]);
                    $bot->answerCallbackQuery($cqId, 'Javob ochildi!');
                }
            } elseif (str_starts_with($data, 'cat_')) {
                $catId = (int)str_replace('cat_', '', $data);
                $this->sendZakovatQuestion($bot, $chatId, $catId);
                $bot->answerCallbackQuery($cqId);
            } elseif ($data === 'next_q') {
                $this->sendZakovatQuestion($bot, $chatId);
                $bot->answerCallbackQuery($cqId);
            } elseif ($data === 'show_cats') {
                $this->sendCategoriesMenu($bot, $chatId);
                $bot->answerCallbackQuery($cqId);
            }
        }

        return $this->asJson(['ok' => true]);
    }

    /**
     * Kategoriyalar menyusini chiqarish
     */
    private function sendCategoriesMenu(TelegramBot $bot, int|string $chatId): void
    {
        $categories = Category::find()->where(['status' => 1])->all();
        if (empty($categories)) {
            $bot->sendMessage($chatId, "Hozircha faol kategoriyalar mavjud emas.");
            return;
        }

        $buttons = [];
        $row = [];
        foreach ($categories as $cat) {
            $count = $cat->getQuestions()->count();
            $icon = $cat->icon ?: '📁';
            $row[] = ['text' => "{$icon} {$cat->name} ({$count})", 'callback_data' => 'cat_' . $cat->id];
            if (count($row) === 2) {
                $buttons[] = $row;
                $row = [];
            }
        }
        if (!empty($row)) {
            $buttons[] = $row;
        }

        $text = "📚 <b>O'zingizga qiziq bo'lgan kategoriyani tanlang:</b>\n"
            . "<i>Har bir bo'limda miyani charxlovchi maxsus savollar jamlangan:</i>";

        $bot->sendMessage($chatId, $text, ['inline_keyboard' => $buttons]);
    }

    /**
     * Zakovat ochiq savoli
     */
    private function sendZakovatQuestion(TelegramBot $bot, int|string $chatId, ?int $categoryId = null): void
    {
        $query = Question::find()->where(['status' => 1]);
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        /** @var Question|null $q */
        $q = $query->orderBy(new \yii\db\Expression('RAND()'))->one();

        if (!$q) {
            $bot->sendMessage($chatId, "Ushbu bo'limda hozircha savollar kam. Boshqa bo'limni tanlab ko'ring.");
            return;
        }

        $categoryName = $q->category ? (($q->category->icon ? $q->category->icon . ' ' : '') . $q->category->name) : 'Umumiy';
        $diff = $q->getDifficultyLabel();

        $text = "📁 <b>Kategoriya:</b> {$categoryName} | <b>Daraja:</b> {$diff}\n\n"
            . "❓ <b>Savol:</b>\n"
            . htmlspecialchars($q->question_text) . "\n\n"
            . "⏳ <i>O'ylab ko'ring va tayyor bo'lsangiz quyidagi tugmani bosing:</i>";

        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '👁️ Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id],
                    ['text' => '➡️ Boshqa savol', 'callback_data' => $categoryId ? 'cat_' . $categoryId : 'next_q']
                ],
                [
                    ['text' => '📂 Kategoriyalar', 'callback_data' => 'show_cats']
                ]
            ]
        ];

        $bot->sendMessage($chatId, $text, $keyboard);
    }

    /**
     * Variantli Test Poll
     */
    private function sendTestPoll(TelegramBot $bot, int|string $chatId, ?int $categoryId = null): void
    {
        $query = Question::find()
            ->where(['status' => 1, 'type' => 'choice'])
            ->andWhere(['not', ['option_a' => null]]);

        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        /** @var Question|null $q */
        $q = $query->orderBy(new \yii\db\Expression('RAND()'))->one();

        if (!$q) {
            $this->sendZakovatQuestion($bot, $chatId, $categoryId);
            return;
        }

        $options = array_filter([
            $q->option_a,
            $q->option_b,
            $q->option_c,
            $q->option_d,
        ]);

        $corr = strtoupper((string)$q->correct_option);
        $idx = match ($corr) { 'B' => 1, 'C' => 2, 'D' => 3, default => 0 };

        $bot->sendQuizPoll(
            $chatId,
            $q->question_text,
            array_values($options),
            $idx,
            $q->answer ?: ''
        );
    }

    /**
     * Kun savoli
     */
    private function sendDailyQuestion(TelegramBot $bot, int|string $chatId): void
    {
        $q = Question::find()->where(['status' => 1])->orderBy(new \yii\db\Expression('RAND()'))->one();
        if ($q) {
            $catName = $q->category ? (($q->category->icon ? $q->category->icon . ' ' : '') . $q->category->name) : 'Umumiy';
            $text = "🌟 <b>Bugungi kun savoli:</b>\n"
                . "📁 {$catName}\n\n"
                . htmlspecialchars($q->question_text);

            $keyboard = [
                'inline_keyboard' => [
                    [['text' => '💡 Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]],
                    [['text' => '📂 Barcha kategoriyalar', 'callback_data' => 'show_cats']]
                ]
            ];

            $bot->sendMessage($chatId, $text, $keyboard);
        } else {
            $bot->sendMessage($chatId, "Hozircha savollar bazasi bo'sh.");
        }
    }
}
