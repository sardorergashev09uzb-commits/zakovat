<?php

declare(strict_types=1);

namespace console\controllers;

use common\components\TelegramBot;
use common\models\Question;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * TelegramController - Console orqali botni boshqarish va xabarlar yuborish
 */
class TelegramController extends Controller
{
    /**
     * Webhook manzilini o'rnatish
     * Misol: php yii telegram/set-webhook https://mysite.uz/telegram/webhook
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
     * Misol: php yii telegram/test 123456789
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
     * Kun savolini belgilangan chat/kanalga yuborish (Cron job orqali ishlatish mumkin)
     * Misol: php yii telegram/daily-question @zakovat_kanali
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
                [['text' => '👁️ Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]]
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

        // Avvalgi webhookni o'chirish
        $bot->apiRequest('deleteWebhook');

        $offset = 0;
        while (true) {
            $res = $bot->getUpdates($offset, 50);
            if (!empty($res['ok']) && !empty($res['result'])) {
                foreach ($res['result'] as $upd) {
                    $offset = $upd['update_id'] + 1;

                    if (isset($upd['message'])) {
                        $msg = $upd['message'];
                        $chatId = $msg['chat']['id'];
                        $text = trim($msg['text'] ?? '');
                        $name = $msg['from']['first_name'] ?? 'Foydalanuvchi';

                        $this->stdout("Xabar [{$name}]: {$text}\n", Console::FG_CYAN);

                        if ($text === '/start') {
                            $welcome = "👋 <b>Assalomu alaykum, {$name}! Zakovat platformasiga xush kelibsiz!</b>\n\n"
                                . "💡 Bu bot orqali siz zakovat savollarini o'qishingiz, variantli testlarni yechishingiz mumkin.\n\n"
                                . "Quyidagi tugmalardan birini tanlang:";

                            $keyboard = [
                                'keyboard' => [
                                    [['text' => '💡 Tasodifiy Zakovat savoli'], ['text' => '📝 Variantli Test']],
                                    [['text' => '📂 Kategoriyalar'], ['text' => '🌟 Kun savoli']],
                                ],
                                'resize_keyboard' => true,
                            ];

                            $bot->sendMessage($chatId, $welcome, $keyboard);
                        } elseif ($text === '/savol' || $text === '💡 Tasodifiy Zakovat savoli') {
                            $q = Question::find()->where(['status' => 1])->orderBy(new \yii\db\Expression('RAND()'))->one();
                            if ($q) {
                                $catName = $q->category ? $q->category->name : 'Umumiy';
                                $diff = $q->getDifficultyLabel();
                                $t = "📁 <b>Kategoriya:</b> {$catName} | <b>Daraja:</b> {$diff}\n\n"
                                    . "❓ <b>Savol:</b>\n" . htmlspecialchars($q->question_text) . "\n\n"
                                    . "⏳ <i>O'ylab ko'ring va tayyor bo'lsangiz quyidagi tugmani bosing:</i>";

                                $bot->sendMessage($chatId, $t, [
                                    'inline_keyboard' => [
                                        [['text' => '👁️ Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]]
                                    ]
                                ]);
                            }
                        } elseif ($text === '/test' || $text === '📝 Variantli Test') {
                            $q = Question::find()
                                ->where(['status' => 1, 'type' => 'choice'])
                                ->andWhere(['not', ['option_a' => null]])
                                ->orderBy(new \yii\db\Expression('RAND()'))
                                ->one();

                            if ($q) {
                                $options = array_filter([$q->option_a, $q->option_b, $q->option_c, $q->option_d]);
                                $corr = strtoupper((string)$q->correct_option);
                                $idx = match ($corr) { 'B' => 1, 'C' => 2, 'D' => 3, default => 0 };
                                $bot->sendQuizPoll($chatId, $q->question_text, array_values($options), $idx, $q->answer ?: '');
                            } else {
                                $bot->sendMessage($chatId, "Hozircha variantli test savollari kam, tez orada qo'shiladi!");
                            }
                        } elseif ($text === '/kategoriyalar' || $text === '📂 Kategoriyalar') {
                            $cats = \common\models\Category::find()->where(['status' => 1])->all();
                            $t = "📚 <b>Mavjud kategoriyalar:</b>\n\n";
                            foreach ($cats as $cat) {
                                $count = $cat->getQuestions()->count();
                                $icon = $cat->icon ?: '📁';
                                $t .= "{$icon} <b>{$cat->name}</b> — {$count} ta savol\n";
                            }
                            $bot->sendMessage($chatId, $t);
                        } elseif ($text === '/kun_savoli' || $text === '🌟 Kun savoli') {
                            $q = Question::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->one();
                            if ($q) {
                                $t = "🌟 <b>Bugungi kun savoli:</b>\n\n" . htmlspecialchars($q->question_text);
                                $bot->sendMessage($chatId, $t, [
                                    'inline_keyboard' => [
                                        [['text' => '💡 Javobni ko\'rish', 'callback_data' => 'answer_' . $q->id]]
                                    ]
                                ]);
                            }
                        }
                    }

                    if (isset($upd['callback_query'])) {
                        $cq = $upd['callback_query'];
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
                }
            }
            sleep(1);
        }

        return ExitCode::OK;
    }
}
