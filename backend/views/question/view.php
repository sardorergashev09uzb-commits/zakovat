<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Question $model */

$this->title = 'Savol #' . $model->id;
?>
<div class="question-view">
    <div class="admin-header">
        <div>
            <h1>📝 <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Savol va javobning to'liq tafsilotlari
            </p>
        </div>
        <div class="d-flex gap-2">
            <?= Html::a('← Orqaga', ['index'], ['class' => 'btn btn-outline btn-sm']) ?>
            <?= Html::a('✏️ Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
            <?= Html::a('🗑️ O\'chirish', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                    'confirm' => 'Haqiqatan ham ushbu savolni o\'chirmoqchimisiz?',
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
                        'attribute' => 'category_id',
                        'label' => 'Kategoriya',
                        'format' => 'raw',
                        'value' => function ($m) {
                            if (!$m->category) {
                                return '<span class="text-muted">—</span>';
                            }
                            $icon = $m->category->icon ?: '📁';
                            return '<span class="badge badge--info">' . $icon . ' ' . Html::encode($m->category->name) . '</span>';
                        },
                    ],
                    [
                        'attribute' => 'type',
                        'label' => 'Savol turi',
                        'format' => 'raw',
                        'value' => fn($m) => $m->type === 'choice'
                            ? '<span class="badge" style="background-color: #6366f1; color: #fff;">📝 Variantli test (A, B, C, D)</span>'
                            : '<span class="badge badge--info">💡 Zakovat (Ochiq savol)</span>',
                    ],
                    [
                        'attribute' => 'question_text',
                        'label' => 'Savol matni',
                        'format' => 'ntext',
                    ],
                    [
                        'attribute' => 'option_a',
                        'label' => 'A varianti',
                        'visible' => $model->type === 'choice',
                    ],
                    [
                        'attribute' => 'option_b',
                        'label' => 'B varianti',
                        'visible' => $model->type === 'choice',
                    ],
                    [
                        'attribute' => 'option_c',
                        'label' => 'C varianti',
                        'visible' => $model->type === 'choice',
                    ],
                    [
                        'attribute' => 'option_d',
                        'label' => 'D varianti',
                        'visible' => $model->type === 'choice',
                    ],
                    [
                        'attribute' => 'correct_option',
                        'label' => 'To\'g\'ri variant',
                        'format' => 'raw',
                        'visible' => $model->type === 'choice',
                        'value' => fn($m) => !empty($m->correct_option)
                            ? '<span class="badge badge--success" style="font-size: 0.95rem;">' . Html::encode($m->correct_option) . ' varianti</span>'
                            : '<span class="text-muted">—</span>',
                    ],
                    [
                        'attribute' => 'answer',
                        'label' => 'Zakovat javobi / Izoh',
                        'format' => 'raw',
                        'value' => fn($m) => !empty($m->answer)
                            ? '<strong class="text-success" style="font-size: 1rem;">' . Html::encode($m->answer) . '</strong>'
                            : '<span class="text-muted">—</span>',
                    ],
                    [
                        'attribute' => 'difficulty',
                        'label' => 'Qiyinlik darajasi',
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
                    [
                        'attribute' => 'created_at',
                        'label' => 'Yaratilgan vaqt',
                    ],
                    [
                        'attribute' => 'updated_at',
                        'label' => 'O\'zgartirilgan vaqt',
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
