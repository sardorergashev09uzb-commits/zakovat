<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="category-form">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-4'],
            'labelOptions' => ['class' => 'form-label fw-bold mb-2', 'style' => 'color: var(--color-text); font-size: 0.9rem;'],
            'inputOptions' => ['class' => 'form-control', 'style' => 'border-radius: var(--radius-sm); padding: 11px 14px;'],
            'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
        ],
    ]); ?>

    <div class="row g-3">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                'placeholder' => 'Masalan: Tarix, Adabiyot, Mantiq...',
            ]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput([
                'maxlength' => true,
                'placeholder' => 'Masalan: tarix, adabiyot, mantiq...',
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'icon')->textInput([
                'maxlength' => true,
                'placeholder' => 'Emoji yoki icon (masalan: 📜, 🧠, 🌍)',
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'difficulty')->dropDownList([
                'easy' => 'Oson (Easy)',
                'medium' => 'O\'rta (Medium)',
                'hard' => 'Qiyin (Hard)',
            ], [
                'prompt' => 'Qiyinlik darajasini tanlang',
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList([
                1 => 'Faol',
                0 => 'Nofaol',
            ]) ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'description')->textarea([
                'rows' => 4,
                'placeholder' => 'Kategoriya haqida qisqacha ma\'lumot...',
            ]) ?>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
        <?= Html::a('Bekor qilish', ['index'], ['class' => 'btn btn-ghost']) ?>
        <?= Html::submitButton('💾 Saqlash', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
