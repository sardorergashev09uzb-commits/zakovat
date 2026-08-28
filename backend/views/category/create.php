<?php

declare(strict_types=1);

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Category $model */

$this->title = 'Yangi kategoriya qo\'shish';
?>
<div class="category-create">
    <div class="admin-header">
        <div>
            <h1>➕ <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Savollar uchun yangi mavzu va bo'lim yaratish
            </p>
        </div>
        <div>
            <?= Html::a('← Kategoriyalar ro\'yxati', ['index'], ['class' => 'btn btn-outline btn-sm']) ?>
        </div>
    </div>

    <div class="card" style="max-width: 860px;">
        <div class="card-pad">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
