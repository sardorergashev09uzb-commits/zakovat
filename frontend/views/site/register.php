<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var frontend\models\SignupForm $model */

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Ro'yxatdan o'tish";
?>

<div class="container">
  <div class="card form-card" style="max-width: 460px;">
    <span class="form-card__eyebrow">Z</span>
    <h1>Hisob yarating</h1>
    <p class="form-card__subtitle">Bilim sinovlarini boshlash uchun ro'yxatdan o'ting</p>

    <?= Alert::widget() ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-3'],
            'labelOptions' => ['class' => 'form-label fw-semibold mb-1', 'style' => 'font-size: 0.88rem;'],
            'inputOptions' => ['class' => 'form-control'],
            'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput([
        'placeholder' => 'masalan: sardor_dev',
        'autofocus' => true,
        'autocomplete' => 'username',
    ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'placeholder' => 'masalan: sardor@example.com',
        'autocomplete' => 'email',
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput([
        'placeholder' => 'Kamida 6 ta belgi',
        'autocomplete' => 'new-password',
    ]) ?>

    <?= $form->field($model, 'password_confirm')->passwordInput([
        'placeholder' => 'Parolni qayta kiriting',
        'autocomplete' => 'new-password',
    ]) ?>

    <div class="mt-4">
      <?= Html::submitButton('Ro\'yxatdan o\'tish', ['class' => 'btn btn-primary btn-block w-100', 'name' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p class="form-footer-link">
      Hisobingiz bormi? <a href="<?= Url::to(['site/login']) ?>">Kiring</a>
    </p>
  </div>
</div>