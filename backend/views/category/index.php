<?php

declare(strict_types=1);

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kategoriyalar';
?>
<div class="category-index">
    <div class="admin-header">
        <div>
            <h1>🗂️ <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Zakovat savollari guruhlangan kategoriyalarni boshqarish
            </p>
        </div>
        <div>
            <?= Html::a('➕ Yangi kategoriya', ['create'], ['class' => 'btn btn-primary']) ?>
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
                        'headerOptions' => ['style' => 'width: 70px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center; font-weight: 600; color: var(--color-text-muted);'],
                    ],
                    [
                        'attribute' => 'icon',
                        'label' => 'Belgi',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 80px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center; font-size: 1.4rem;'],
                        'value' => fn($model) => $model->icon ?: '📚',
                    ],
                    [
                        'attribute' => 'name',
                        'label' => 'Nomi',
                        'format' => 'raw',
                        'value' => fn($model) => '<strong>' . Html::encode($model->name) . '</strong>' . 
                            ($model->description ? '<div class="text-muted" style="font-size: 0.8rem;">' . Html::encode(mb_substr($model->description, 0, 60)) . '...</div>' : ''),
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => 'Slug (URL)',
                        'format' => 'raw',
                        'value' => fn($model) => '<code style="background: var(--color-primary-light); color: var(--color-primary-dark); padding: 2px 6px; border-radius: 4px; font-size: 0.82rem;">' . Html::encode($model->slug) . '</code>',
                    ],
                    [
                        'attribute' => 'difficulty',
                        'label' => 'Qiyinlik',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $diff = strtolower((string)$model->difficulty);
                            if ($diff === 'easy' || $diff === 'oson') {
                                return '<span class="difficulty difficulty--easy">Oson</span>';
                            } elseif ($diff === 'hard' || $diff === 'qiyin') {
                                return '<span class="difficulty difficulty--hard">Qiyin</span>';
                            }
                            return '<span class="difficulty difficulty--medium">O\'rta</span>';
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Holati',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 110px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'value' => fn($model) => (int)$model->status === 1
                            ? '<span class="badge badge--success">Faol</span>'
                            : '<span class="badge badge--error">Nofaol</span>',
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
                                'data-confirm' => 'Haqiqatan ham ushbu kategoriyani o\'chirmoqchimisiz?',
                                'data-method' => 'post',
                            ]),
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
