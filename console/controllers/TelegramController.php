<?php

declare(strict_types=1);

namespace console\controllers;

use common\components\TelegramBot;
use common\models\Category;
use common\models\Question;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * TelegramController - Console orqali botni boshqarish va Polling rejimida ishlatish
 */
class TelegramController extends Controller
{
    /**
     * Webhook manzilini o'rnatish
     */
    public function actionSetWebhook(string $url): int
    {
        $bot = new TelegramBot();
        $this->stdout("Webhook o'rnatilmoqda: {$url}...\n", Console::FG_YELLOW);
        $res = $bot->setWebhook($url);

        if (!empty($res['ok'])) {
            $this->stdout("✅ Webhook muvaffaqiyatli o'rnatildi!\n", Console::FG_GREEN);
            return ExitCode::OK;
        }

        $this->stdout("❌ Xatolik: " . ($res['description'] ?? 'Noma\'lum xatolik') . "\n", Console::FG_RED);
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Test xabari yuborish
     */
    public function actionTest(string|int $chatId): int
    {
        $bot = new TelegramBot();
        $this->stdout("Test xabari yuborilmoqda...\n", Console::FG_YELLOW);
        $res = $bot->sendMessage($chatId, "🔔 <b>Zakovat tizimi:</b> Test xabari muvaffaqiyatli yetib bordi!");

        if (!empty($res['ok'])) {
            $this->stdout("✅ Xabar yuborildi!\n", Console::FG_GREEN);
            return ExitCode::OK;
        }

        $this->stdout("❌ Xatolik: " . ($res['description'] ?? 'Noma\'lum xatolik') . "\n", Console::FG_RED);
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Kun savolini belgilangan chat/kanalga yuborish
     */
    public function actionDailyQuestion(string|int $chatId): int
    {
        $q = Question::find()->where(['status' => 1])->orderBy(new \yii\db\Expression('RAND()'))->one();
        if (!$q) {
            $this->stdout("Savollar topilmadi.\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $bot = new TelegramBot();
        $text = "🌟 <b>Kun savoli:</b>\n\n"
            . htmlspecialchars($q->question_text) . "\n\n"
            . "💡 <i>Javobni bilish uchun quyidagi tugmani bosing:</i>";

        $keyboard = [
            'inline_keyboard' => [
                [['text' => '💡 Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]]
            ]
        ];

        $res = $bot->sendMessage($chatId, $text, $keyboard);
        if (!empty($res['ok'])) {
            $this->stdout("✅ Kun savoli {$chatId} ga yuborildi!\n", Console::FG_GREEN);
            return ExitCode::OK;
        }

        $this->stdout("❌ Xatolik: " . ($res['description'] ?? 'Noma\'lum xatolik') . "\n", Console::FG_RED);
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * Lokal muhitda botni sinash uchun Polling rejimi
     * Misol: php yii telegram/poll
     */
    public function actionPoll(): int
    {
        $bot = new TelegramBot();
        $this->stdout("🤖 Zakovat Telegram Boti Polling rejimida ishga tushdi...\n", Console::FG_GREEN);
        $this->stdout("To'xtatish uchun Ctrl+C bosing.\n\n", Console::FG_YELLOW);

        // Webhookni tozalash
        $bot->apiRequest('deleteWebhook');

        $offset = 0;
        while (true) {
            $res = $bot->getUpdates($offset, 50);
            if (!empty($res['ok']) && !empty($res['result'])) {
                foreach ($res['result'] as $upd) {
                    $offset = $upd['update_id'] + 1;

                    // 1. Matnli xabarlar
                    if (isset($upd['message'])) {
                        $msg = $upd['message'];
                        $chatId = $msg['chat']['id'];
                        $text = trim($msg['text'] ?? '');
                        $name = $msg['from']['first_name'] ?? 'Foydalanuvchi';

                        $this->stdout("Xabar [{$name}]: {$text}\n", Console::FG_CYAN);

                        if ($text === '/start') {
                            $welcome = "👋 <b>Assalomu alaykum, {$name}! Zakovat intellektual platformasiga xush kelibsiz!</b>\n\n"
                                . "🧠 Bu yerda siz zang bosgan miyani sayqallovchi haqiqiy intellektual savollar va 4 variantli testlarni yechishingiz mumkin.\n\n"
                                . "👇 <b>Quyidagi menyudan kerakli bo'limni tanlang:</b>";

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

                    // 2. Inline tugmalar (Callback Queries)
                    if (isset($upd['callback_query'])) {
                        $cq = $upd['callback_query'];
                        $cqId = $cq['id'];
                        $chatId = $cq['message']['chat']['id'];
                        $data = $cq['data'] ?? '';

                        if (str_starts_with($data, 'answer_')) {
                            // Javobni ko'rish
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
                            // Kategoriya tanlandi
                            $catId = (int)str_replace('cat_', '', $data);
                            $this->sendZakovatQuestion($bot, $chatId, $catId);
                            $bot->answerCallbackQuery($cqId);
                        } elseif (str_starts_with($data, 'cattest_')) {
                            // Kategoriya bo'yicha test
                            $catId = (int)str_replace('cattest_', '', $data);
                            $this->sendTestPoll($bot, $chatId, $catId);
                            $bot->answerCallbackQuery($cqId);
                        } elseif ($data === 'next_q') {
                            $this->sendZakovatQuestion($bot, $chatId);
                            $bot->answerCallbackQuery($cqId);
                        } elseif ($data === 'show_cats') {
                            $this->sendCategoriesMenu($bot, $chatId);
                            $bot->answerCallbackQuery($cqId);
                        }
                    }
                }
            }
            sleep(1);
        }

        return ExitCode::OK;
    }

    /**
     * Kategoriyalar menyusini chiroyli Inline Buttons qilib chiqarish
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
            $btnText = "{$icon} {$cat->name} ({$count})";

            $row[] = ['text' => $btnText, 'callback_data' => 'cat_' . $cat->id];

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
     * 4 Variantli Test (Quiz Poll)
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
            // Agar choice topilmasa, ochiq savol jo'natamiz
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
