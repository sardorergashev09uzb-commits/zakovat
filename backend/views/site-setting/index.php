<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\SiteSetting $model */

use common\widgets\Alert;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Sayt sozlamalari';
?>

<div class="site-setting-update">
    <div class="admin-header">
        <div>
            <h1>⚙️ <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Bosh sahifa banneri, matnlar va asosiy sayt ma'lumotlarini boshqarish
            </p>
        </div>
    </div>

    <?= Alert::widget() ?>

    <div class="card" style="max-width: 860px;">
        <div class="card-pad">
            <?php $form = ActiveForm::begin([
                'id' => 'site-settings-form',
                'options' => ['class' => 'settings-form'],
                'fieldConfig' => [
                    'options' => ['class' => 'form-group mb-4'],
                    'labelOptions' => ['class' => 'form-label fw-bold mb-2', 'style' => 'color: var(--color-text); font-size: 0.9rem;'],
                    'inputOptions' => ['class' => 'form-control', 'style' => 'border-radius: var(--radius-sm); padding: 11px 14px;'],
                    'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
                ],
            ]); ?>

            <div class="row g-3">
                <div class="col-12">
                    <?= $form->field($model, 'banner_title')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Masalan: Bilimingizni sinang, Zakovatda g\'olib bo\'ling!',
                    ])->hint('Bosh sahifadagi asosiy katta sarlavha', ['class' => 'form-hint text-muted mt-1', 'style' => 'font-size: 0.8rem;']) ?>
                </div>

                <div class="col-12">
                    <?= $form->field($model, 'card_title')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Masalan: Kun savollari va qiziqarli testlar',
                    ])->hint('Karta yoki bo\'lim uchun ikkilamchi sarlavha', ['class' => 'form-hint text-muted mt-1', 'style' => 'font-size: 0.8rem;']) ?>
                </div>

                <div class="col-12">
                    <?= $form->field($model, 'about')->textarea([
                        'rows' => 3,
                        'maxlength' => true,
                        'placeholder' => 'Sayt haqida qisqacha ma\'lumot...',
                    ])->hint('Loyihaning qisqacha ta\'rifi', ['class' => 'form-hint text-muted mt-1', 'style' => 'font-size: 0.8rem;']) ?>
                </div>

                <div class="col-12">
                    <?= $form->field($model, 'description')->textarea([
                        'rows' => 4,
                        'maxlength' => true,
                        'placeholder' => 'Saytning to\'liq tavsifi va foydalanuvchilarga xabari...',
                    ])->hint('Sayt bo\'ylab yoki footer qismida chiqadigan umumiy tavsif', ['class' => 'form-hint text-muted mt-1', 'style' => 'font-size: 0.8rem;']) ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                <?= Html::submitButton('💾 Sozlamalarni saqlash', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
