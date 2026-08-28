<?php

declare(strict_types=1);

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$initial = mb_strtoupper(mb_substr($model->username, 0, 1));
?>
<div class="user-view">
    <div class="admin-header">
        <div>
            <h1>👤 <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Foydalanuvchi hisobi haqida batafsil ma'lumot
            </p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('← Orqaga', ['index'], ['class' => 'btn btn-outline btn-sm']) ?>
            <?= Html::a('✏️ Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('🗑️ O\'chirish', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Haqiqatan ham ushbu foydalanuvchini o\'chirmoqchimisiz?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card" style="max-width: 860px;">
        <div class="card-pad">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div class="nav-user__avatar" style="width: 56px; height: 56px; font-size: 1.4rem; font-weight: 700;">
                    <?= Html::encode($initial) ?>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.3rem;"><?= Html::encode($model->username) ?></h3>
                    <div class="text-muted" style="font-size: 0.88rem;"><?= Html::encode($model->email) ?></div>
                </div>
            </div>

            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'detail-view mb-0'],
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    [
                        'attribute' => 'status',
                        'label' => 'Holati',
                        'format' => 'raw',
                        'value' => function ($m) {
                            if ($m->status === User::STATUS_ACTIVE) {
                                return '<span class="badge badge--success">Faol</span>';
                            } elseif ($m->status === User::STATUS_INACTIVE) {
                                return '<span class="badge badge--warning">Kutilmoqda</span>';
                            }
                            return '<span class="badge badge--error">Bloklangan</span>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Ro\'yxatdan o\'tgan sana',
                        'value' => fn($m) => date('d.m.Y H:i:s', (int)$m->created_at),
                    ],
                    [
                        'attribute' => 'updated_at',
                        'label' => 'So\'nggi yangilanish',
                        'value' => fn($m) => date('d.m.Y H:i:s', (int)$m->updated_at),
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
