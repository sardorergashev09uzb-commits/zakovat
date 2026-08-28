<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\User $user */

use common\models\Category;
use common\models\Question;
use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Mening profilim';
$initial = mb_strtoupper(mb_substr($user->username, 0, 1));
$totalQuestions = Question::find()->count();
$totalCategories = Category::find()->count();
?>

<div class="container" style="padding-top: 32px; padding-bottom: 64px;">

  <?= Alert::widget() ?>

  <!-- Foydalanuvchi ma'lumotlari -->
  <div class="card profile-header d-flex align-items-center gap-4">
    <div class="profile-avatar">
      <?= Html::encode($initial) ?>
    </div>
    <div class="flex-grow-1">
      <h1 style="margin: 0 0 6px; font-size: 1.6rem;"><?= Html::encode($user->username) ?></h1>
      <p class="text-muted" style="margin: 0; font-size: 0.95rem;">
        ✉️ <?= Html::encode($user->email) ?> &middot; 
        📅 A'zo bo'lgan sana: <?= date('d.m.Y', (int)$user->created_at) ?>
      </p>
    </div>
  </div>

  <!-- Umumiy statistika -->
  <div class="grid profile-stats-grid" style="margin-top: 24px;">
    <div class="card profile-stat-card">
      <div class="profile-stat-card__num"><?= $totalCategories ?></div>
      <div class="profile-stat-card__label">Mavjud kategoriyalar</div>
    </div>
    <div class="card profile-stat-card">
      <div class="profile-stat-card__num"><?= $totalQuestions ?></div>
      <div class="profile-stat-card__label">Jami savollar bazasi</div>
    </div>
    <div class="card profile-stat-card">
      <div class="profile-stat-card__num" style="color: var(--color-success);">Faol</div>
      <div class="profile-stat-card__label">Hisob holati</div>
    </div>
    <div class="card profile-stat-card">
      <div class="profile-stat-card__num">VIP</div>
      <div class="profile-stat-card__label">Foydalanuvchi darajasi</div>
    </div>
  </div>

  <!-- Profil ma'lumotlarini tahrirlash -->
  <div class="card" style="margin-top: 24px;">
    <div class="card-pad">
      <h2 style="font-size: 1.25rem; margin-bottom: 8px;">⚙️ Profil ma'lumotlarini yangilash</h2>
      <p class="text-muted" style="font-size: 0.88rem; margin-bottom: 20px;">
        Foydalanuvchi nomi, email yoki yangi parol o'rnatishingiz mumkin
      </p>

      <?php $form = ActiveForm::begin([
          'id' => 'profile-edit-form',
          'fieldConfig' => [
              'options' => ['class' => 'form-group mb-3'],
              'labelOptions' => ['class' => 'form-label fw-semibold mb-1', 'style' => 'font-size: 0.88rem;'],
              'inputOptions' => ['class' => 'form-control'],
              'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
          ],
      ]); ?>

      <div class="row g-3">
        <div class="col-md-6">
          <?= $form->field($user, 'username')->textInput([
              'placeholder' => 'Foydalanuvchi nomini kiriting',
              'required' => true,
          ])->label('Foydalanuvchi nomi') ?>
        </div>

        <div class="col-md-6">
          <?= $form->field($user, 'email')->textInput([
              'placeholder' => 'Elektron pochta manzilini kiriting',
              'type' => 'email',
              'required' => true,
          ])->label('Email manzil') ?>
        </div>

        <div class="col-12">
          <?= $form->field($user, 'password')->passwordInput([
              'value' => '',
              'placeholder' => 'Parolni o\'zgartirishni istamasangiz, bo\'sh qoldiring (kamida 6 ta belgi)',
          ])->label('Yangi parol (ixtiyoriy)')->hint('Parolni yangilash uchun yangi parolni kiriting, aks holda bo\'sh qoldiring.') ?>
        </div>
      </div>

      <div class="d-flex justify-content-end pt-3 border-top mt-4">
        <?= Html::submitButton('💾 O\'zgarishlarni saqlash', ['class' => 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>

</div>