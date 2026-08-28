<?php

declare(strict_types=1);

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Yangi foydalanuvchi yaratish';
?>
<div class="user-create">
    <div class="admin-header">
        <div>
            <h1>➕ <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Tizimga yangi foydalanuvchi profilini qo'shish
            </p>
        </div>
        <div>
            <?= Html::a('← Foydalanuvchilar ro\'yxati', ['index'], ['class' => 'btn btn-outline btn-sm']) ?>
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
