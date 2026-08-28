<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\SiteSetting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="site-setting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'setting_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'setting_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
