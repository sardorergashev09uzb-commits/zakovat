<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Admin Panelga Kirish — Zakovat';
?>

<div class="login-wrapper" style="width: 100%; max-width: 440px; margin: 0 auto; padding: 20px;">
    
    <!-- Login Karta -->
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="background: #ffffff; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);">
        
        <!-- Header qismi (Gradient fon) -->
        <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
            <div style="width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 12px; backdrop-filter: blur(8px);">
                🧠
            </div>
            <h3 class="fw-bold mb-1" style="font-size: 1.45rem; letter-spacing: -0.5px;">Zakovat Admin</h3>
            <p class="mb-0 opacity-80" style="font-size: 0.88rem;">Boshqaruv paneliga xush kelibsiz</p>
        </div>

        <!-- Form qismi -->
        <div class="p-4 p-md-5">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label fw-bold text-secondary small mb-1'],
                    'inputOptions' => ['class' => 'form-control form-control-lg fs-6 rounded-3 py-2 px-3'],
                    'errorOptions' => ['class' => 'invalid-feedback d-block small mt-1'],
                ],
            ]); ?>

            <div class="mb-3">
                <?= $form->field($model, 'username')->textInput([
                    'placeholder' => 'Foydalanuvchi nomi',
                    'autofocus' => true,
                    'autocomplete' => 'username',
                ])->label('👤 Foydalanuvchi nomi') ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Parolingizni kiriting',
                    'autocomplete' => 'current-password',
                ])->label('🔒 Parol') ?>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <?= Html::activeCheckbox($model, 'rememberMe', [
                        'class' => 'form-check-input',
                        'label' => false,
                        'id' => 'rememberMeCheck',
                    ]) ?>
                    <label class="form-check-label small text-muted user-select-none" for="rememberMeCheck">
                        Meni eslab qol
                    </label>
                </div>
            </div>

            <div class="d-grid mb-3">
                <?= Html::submitButton('🚀 Tizimga kirish', [
                    'class' => 'btn btn-primary btn-lg rounded-3 fw-bold shadow-sm',
                    'style' => 'background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none; padding: 12px; font-size: 1rem;',
                    'name' => 'login-button',
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <!-- Default login/parol eslatmasi -->
            <div class="p-2 px-3 rounded-3 mt-3 text-center" style="background: #f8fafc; border: 1px dashed #cbd5e1; font-size: 0.82rem; color: #64748b;">
                🔑 Standart login: <strong>admin</strong> | Parol: <strong>admin123</strong>
            </div>

            <!-- Bosh sahifaga qaytish -->
            <div class="text-center mt-4">
                <a href="/" class="text-decoration-none text-muted small" style="transition: color 0.2s;">
                    ← Asosiy saytga qaytish
                </a>
            </div>
        </div>

    </div>

    <!-- Footer mualliflik -->
    <div class="text-center mt-3 text-muted small">
        &copy; <?= date('Y') ?> Zakovat Boshqaruv Tizimi
    </div>

</div>
