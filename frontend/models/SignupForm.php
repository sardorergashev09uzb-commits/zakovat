<?php

declare(strict_types=1);

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirm = '';

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'email', 'password', 'password_confirm'], 'required', 'message' => '{attribute} maydoni to\'ldirilishi shart.'],
            [['username', 'email'], 'trim'],

            ['username', 'string', 'min' => 2, 'max' => 255, 'message' => 'Foydalanuvchi nomi 2 dan 255 tagacha belgidan iborat bo\'lishi kerak.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Ushbu foydalanuvchi nomi band.'],

            ['email', 'email', 'message' => 'To\'g\'ri email manzil kiriting.'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Ushbu email manzil allaqachon ro\'yxatdan o\'tgan.'],

            ['password', 'string', 'min' => 6, 'message' => 'Parol kamida 6 ta belgidan iborat bo\'lishi kerak.'],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Kiritilgan parollar bir-biriga mos kelmadi.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'username' => 'Foydalanuvchi nomi',
            'email' => 'Email manzil',
            'password' => 'Parol',
            'password_confirm' => 'Parolni tasdiqlang',
        ];
    }

    /**
     * Foydalanuvchini ro'yxatdan o'tkazadi va User obyektini qaytaradi.
     */
    public function signup(): User|null
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = User::STATUS_ACTIVE;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
