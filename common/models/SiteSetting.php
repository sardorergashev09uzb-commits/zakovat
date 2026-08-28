<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "site_setting".
 *
 * @property int $id
 * @property string|null $banner_title
 * @property string|null $about
 * @property string|null $card_title
 * @property string|null $description
 */
class SiteSetting extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%site_setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['banner_title', 'about', 'card_title', 'description'], 'default', 'value' => null],
            [['banner_title', 'about', 'card_title', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'banner_title' => 'Banner sarlavhasi',
            'about' => 'Biz haqimizda qisqacha',
            'card_title' => 'Karta / Bo\'lim sarlavhasi',
            'description' => 'Sayt tavsifi',
        ];
    }

    /**
     * Sayt sozlamalarining yagona yozuvini oladi.
     * Agar DB da hali yozuv mavjud bo'lmasa, birlamchi qiymatlar bilan yangi yozuv yaratadi.
     */
    public static function getSettings(): static
    {
        $setting = static::find()->one();
        if (!$setting) {
            $setting = new static([
                'banner_title' => 'Bilimingizni sinang, Zakovatda g\'olib bo\'ling!',
                'about' => 'Zakovat — har qanday sohada o\'z intellektual salohiyatini sinash va rivojlantirish platformasi.',
                'card_title' => 'Kun savollari va qiziqarli testlar',
                'description' => 'O\'zbekiston bo\'ylab minglab bilimdonlar bilan bellashing va reytingda yuqori o\'rinlarni egallang.',
            ]);
            $setting->save(false);
        }

        return $setting;
    }
}
