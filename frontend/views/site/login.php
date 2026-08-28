<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\LoginForm $model */

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Tizimga kirish';
?>

<div class="container">
  <div class="card form-card" style="max-width: 460px;">
    <span class="form-card__eyebrow">Z</span>
    <h1>Hisobingizga kiring</h1>
    <p class="form-card__subtitle">Testlarni davom ettirish uchun tizimga kiring</p>

    <?= Alert::widget() ?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-3'],
            'labelOptions' => ['class' => 'form-label fw-semibold mb-1', 'style' => 'font-size: 0.88rem;'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput([
        'placeholder' => 'Email yoki foydalanuvchi nomi',
        'autofocus' => true,
        'autocomplete' => 'username',
    ])->label('Email yoki foydalanuvchi nomi') ?>

    <?= $form->field($model, 'password')->passwordInput([
        'placeholder' => 'Parolingiz',
        'autocomplete' => 'current-password',
    ])->label('Parol') ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"form-check mb-3\">{input} {label}</div>\n{error}",
    ])->label('Meni eslab qol') ?>

    <div class="mt-4">
      <?= Html::submitButton('Kirish', ['class' => 'btn btn-primary btn-block w-100', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p class="form-footer-link">
      Hisobingiz yo'qmi? <a href="<?= Url::to(['site/register']) ?>">Ro'yxatdan o'ting</a>
    </p>
  </div>
</div>