<?php

declare(strict_types=1);

use common\models\Category;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Question $model */
/** @var yii\bootstrap5\ActiveForm $form */

$categories = ArrayHelper::map(Category::find()->all(), 'id', function ($category) {
    return ($category->icon ? $category->icon . ' ' : '') . $category->name;
});
?>

<div class="question-form">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => ['class' => 'form-group mb-4'],
            'labelOptions' => ['class' => 'form-label fw-bold mb-2', 'style' => 'color: var(--color-text); font-size: 0.9rem;'],
            'inputOptions' => ['class' => 'form-control', 'style' => 'border-radius: var(--radius-sm); padding: 11px 14px;'],
            'errorOptions' => ['class' => 'form-error is-visible text-danger mt-1', 'style' => 'font-size: 0.82rem;'],
        ],
    ]); ?>

    <div class="row g-3">
        <div class="col-md-4">
            <?= $form->field($model, 'category_id')->dropDownList($categories, [
                'prompt' => '— Kategoriyani tanlang —',
            ])->label('Kategoriya') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'type')->dropDownList([
                'open' => '💡 Zakovat (Ochiq savol)',
                'choice' => '📝 Variantli test (A, B, C, D)',
            ], [
                'id' => 'question-type-select',
            ])->label('Savol turi') ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'difficulty')->dropDownList([
                'easy' => 'Oson (Easy)',
                'medium' => 'O\'rta (Medium)',
                'hard' => 'Qiyin (Hard)',
            ], [
                'prompt' => '— Qiyinlik darajasi —',
            ])->label('Qiyinlik darajasi') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList([
                1 => 'Faol',
                0 => 'Nofaol',
            ])->label('Holati') ?>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'question_text')->textarea([
                'rows' => 4,
                'placeholder' => 'Savol matnini to\'liq kiriting...',
            ])->label('Savol matni') ?>
        </div>

        <!-- Variantli test maydonlari (Faqat type = choice bo'lganda ko'rinadi) -->
        <div class="col-12" id="choiceOptionsContainer" style="<?= $model->type === 'choice' ? '' : 'display: none;' ?>">
            <div class="card p-3" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <h5 class="mb-3 text-primary">📝 Test variantlari (A, B, C, D)</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'option_a')->textInput(['placeholder' => 'A varianti matni'])->label('A varianti') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'option_b')->textInput(['placeholder' => 'B varianti matni'])->label('B varianti') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'option_c')->textInput(['placeholder' => 'C varianti matni'])->label('C varianti') ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'option_d')->textInput(['placeholder' => 'D varianti matni'])->label('D varianti') ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'correct_option')->dropDownList([
                            'A' => 'A varianti',
                            'B' => 'B varianti',
                            'C' => 'C varianti',
                            'D' => 'D varianti',
                        ], ['prompt' => '— To\'g\'ri variantni tanlang —'])->label('To\'g\'ri variant') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <?= $form->field($model, 'answer')->textarea([
                'rows' => 3,
                'placeholder' => 'Zakovat javobi yoki test varianti uchun batafsil izoh...',
            ])->label('Javob / Izoh') ?>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
        <?= Html::a('Bekor qilish', ['index'], ['class' => 'btn btn-ghost']) ?>
        <?= Html::submitButton('💾 Saqlash', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<<JS
document.getElementById('question-type-select').addEventListener('change', function() {
    var choiceBox = document.getElementById('choiceOptionsContainer');
    if (this.value === 'choice') {
        choiceBox.style.display = 'block';
    } else {
        choiceBox.style.display = 'none';
    }
});
JS;
$this->registerJs($js);
?>
