<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SiteSetting $model */

$this->title = 'Update Site Setting: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Site Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="site-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
