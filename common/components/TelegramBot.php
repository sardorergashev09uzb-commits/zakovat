<?php

declare(strict_types=1);

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;

/**
 * TelegramBot - Telegram Bot API bilan ishlash uchun komponent
 */
class TelegramBot extends Component
{
    public string $token = '';

    public function init()
    {
        parent::init();
        if (empty($this->token)) {
            $this->token = Yii::$app->params['telegramBotToken'] ?? '';
        }
    }

    /**
     * API so'rov yuborish
     */
    public function apiRequest(string $method, array $params = []): array
    {
        if (empty($this->token)) {
            return ['ok' => false, 'description' => 'Telegram Bot Token belgilanmagan'];
        }

        $url = "https://api.telegram.org/bot{$this->token}/{$method}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['ok' => false, 'description' => $error];
        }

        return Json::decode((string)$response);
    }

    /**
     * Matnli xabar yuborish
     */
    public function sendMessage(string|int $chatId, string $text, array $keyboard = [], string $parseMode = 'HTML'): array
    {
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => $parseMode,
        ];

        if (!empty($keyboard)) {
            $params['reply_markup'] = Json::encode($keyboard);
        }

        return $this->apiRequest('sendMessage', $params);
    }

    /**
     * Test / Quiz so'rovi (Poll) yuborish
     */
    public function sendQuizPoll(string|int $chatId, string $question, array $options, int $correctOptionId, string $explanation = ''): array
    {
        $params = [
            'chat_id' => $chatId,
            'question' => mb_substr($question, 0, 300),
            'options' => Json::encode($options),
            'type' => 'quiz',
            'correct_option_id' => $correctOptionId,
            'is_anonymous' => false,
        ];

        if (!empty($explanation)) {
            $params['explanation'] = mb_substr($explanation, 0, 200);
        }

        return $this->apiRequest('sendPoll', $params);
    }

    /**
     * Callback query ga javob berish
     */
    public function answerCallbackQuery(string $callbackQueryId, string $text = '', bool $showAlert = false): array
    {
        return $this->apiRequest('answerCallbackQuery', [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => $showAlert,
        ]);
    }

    /**
     * Webhook URL o'rnatish
     */
    public function setWebhook(string $url): array
    {
        return $this->apiRequest('setWebhook', ['url' => $url]);
    }

    /**
     * Yangilanishlarni (updates) olish (Polling uchun)
     */
    public function getUpdates(int $offset = 0, int $limit = 100): array
    {
        return $this->apiRequest('getUpdates', [
            'offset' => $offset,
            'limit' => $limit,
            'timeout' => 10,
        ]);
    }
}
