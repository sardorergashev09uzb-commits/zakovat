<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SiteSetting $model */

$this->title = 'Create Site Setting';
$this->params['breadcrumbs'][] = ['label' => 'Site Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
