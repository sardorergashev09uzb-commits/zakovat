<?php

declare(strict_types=1);

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Foydalanuvchilar';
?>
<div class="user-index">
    <div class="admin-header">
        <div>
            <h1>👥 <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Tizimda ro'yxatdan o'tgan barcha foydalanuvchilarni boshqarish
            </p>
        </div>
        <div>
            <?= Html::a('➕ Yangi foydalanuvchi', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-pad">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'data-table table-hover mb-0'],
                'layout' => "{items}\n<div class='d-flex justify-content-between align-items-center mt-4'>{summary}{pager}</div>",
                'columns' => [
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width: 60px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center; font-weight: 600; color: var(--color-text-muted);'],
                    ],
                    [
                        'attribute' => 'username',
                        'label' => 'Foydalanuvchi',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $initial = mb_strtoupper(mb_substr($model->username, 0, 1));
                            return '<div style="display: flex; align-items: center; gap: 10px;">' .
                                '<span class="nav-user__avatar" style="width: 34px; height: 34px; font-size: 0.85rem;">' . Html::encode($initial) . '</span>' .
                                '<div><strong>' . Html::encode($model->username) . '</strong></div>' .
                                '</div>';
                        },
                    ],
                    [
                        'attribute' => 'email',
                        'label' => 'Email',
                        'format' => 'email',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Holati',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 120px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model) {
                            if ($model->status === User::STATUS_ACTIVE) {
                                return '<span class="badge badge--success">Faol</span>';
                            } elseif ($model->status === User::STATUS_INACTIVE) {
                                return '<span class="badge badge--warning">Kutilmoqda</span>';
                            }
                            return '<span class="badge badge--error">Bloklangan</span>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Ro\'yxatdan o\'tgan',
                        'format' => 'raw',
                        'value' => fn($model) => date('d.m.Y H:i', (int)$model->created_at),
                    ],
                    [
                        'class' => ActionColumn::class,
                        'header' => 'Amallar',
                        'headerOptions' => ['style' => 'width: 140px; text-align: right;'],
                        'contentOptions' => ['style' => 'text-align: right; white-space: nowrap;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => fn($url) => Html::a('👁️', $url, [
                                'class' => 'icon-btn',
                                'title' => 'Ko\'rish',
                            ]),
                            'update' => fn($url) => Html::a('✏️', $url, [
                                'class' => 'icon-btn',
                                'title' => 'Tahrirlash',
                            ]),
                            'delete' => fn($url) => Html::a('🗑️', $url, [
                                'class' => 'icon-btn icon-btn--danger',
                                'title' => 'O\'chirish',
                                'data-confirm' => 'Haqiqatan ham ushbu foydalanuvchini o\'chirmoqchimisiz?',
                                'data-method' => 'post',
                            ]),
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
