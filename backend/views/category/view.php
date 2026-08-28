<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Category $model */

$this->title = $model->name;
?>
<div class="category-view">
    <div class="admin-header">
        <div>
            <h1>🗂️ <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Kategoriya tafsilotlari
            </p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('← Orqaga', ['index'], ['class' => 'btn btn-outline btn-sm']) ?>
            <?= Html::a('✏️ Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('🗑️ O\'chirish', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Haqiqatan ham ushbu kategoriyani o\'chirmoqchimisiz?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card" style="max-width: 860px;">
        <div class="card-pad">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'detail-view mb-0'],
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'icon',
                        'label' => 'Belgi',
                        'format' => 'raw',
                        'value' => fn($m) => '<span style="font-size: 1.8rem;">' . ($m->icon ?: '📚') . '</span>',
                    ],
                    'name',
                    'slug',
                    'description:ntext',
                    [
                        'attribute' => 'difficulty',
                        'label' => 'Qiyinlik',
                        'format' => 'raw',
                        'value' => function ($m) {
                            $diff = strtolower((string)$m->difficulty);
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
                        'value' => fn($m) => (int)$m->status === 1
                            ? '<span class="badge badge--success">Faol</span>'
                            : '<span class="badge badge--error">Nofaol</span>',
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
