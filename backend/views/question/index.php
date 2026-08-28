<?php

declare(strict_types=1);

use common\models\Question;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Savollar';
?>
<div class="question-index">
    <div class="admin-header">
        <div>
            <h1>📝 <?= Html::encode($this->title) ?></h1>
            <p class="text-muted" style="margin-top: 4px; font-size: 0.9rem;">
                Barcha intellektual zakovat savollari va variantli testlar bazasi
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                📥 CSV Import
            </button>
            <?= Html::a('📤 CSV Eksport', ['export'], ['class' => 'btn btn-outline']) ?>
            <?= Html::a('➕ Yangi savol', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <!-- CSV Import Modal -->
    <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= Url::to(['question/import']) ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">📥 Savollarni CSV fayldan yuklash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted" style="font-size: 0.88rem;">
                            Siz bir vaqtning o'zida o'nlab/yuzlab savollarni CSV fayli orqali yuklashingiz mumkin.
                        </p>
                        <div class="mb-3">
                            <label class="form-label fw-bold">CSV faylni tanlang:</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv,text/csv" required>
                        </div>
                        <div class="p-3 bg-light rounded" style="font-size: 0.85rem;">
                            <strong>💡 Maslahat:</strong> To'g'ri formatda CSV tayyorlash uchun namunani yuklab oling:
                            <div class="mt-2">
                                <?= Html::a('📄 Namuna CSV shablonini yuklab olish', ['template'], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="submit" class="btn btn-primary">🚀 Yuklash va Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-pad">
            <?php
            $categoryFilter = \yii\helpers\ArrayHelper::map(\common\models\Category::find()->all(), 'id', function($c) {
                return ($c->icon ? $c->icon . ' ' : '') . $c->name;
            });
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'data-table table-hover mb-0'],
                'layout' => "<div class='d-flex justify-content-between align-items-center mb-3'>{summary}" . Html::a('🔄 Filtrlarni tozalash', ['index'], ['class' => 'btn btn-sm btn-ghost']) . "</div>\n{items}\n<div class='d-flex justify-content-between align-items-center mt-4'>{summary}{pager}</div>",
                'columns' => [
                    [
                        'attribute' => 'id',
                        'headerOptions' => ['style' => 'width: 70px; text-align: center;'],
                        'contentOptions' => ['style' => 'text-align: center; font-weight: 600; color: var(--color-text-muted);'],
                    ],
                    [
                        'attribute' => 'category_id',
                        'label' => 'Kategoriya',
                        'filter' => $categoryFilter,
                        'filterInputOptions' => ['class' => 'form-select form-select-sm', 'prompt' => 'Barchasi'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!$model->category) {
                                return '<span class="text-muted">—</span>';
                            }
                            $icon = $model->category->icon ?: '📁';
                            return '<span class="badge badge--info">' . $icon . ' ' . Html::encode($model->category->name) . '</span>';
                        },
                    ],
                    [
                        'attribute' => 'type',
                        'label' => 'Turi',
                        'filter' => ['open' => '💡 Zakovat', 'choice' => '📝 Test (A,B,C,D)'],
                        'filterInputOptions' => ['class' => 'form-select form-select-sm', 'prompt' => 'Barchasi'],
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 140px;'],
                        'value' => function ($model) {
                            return $model->type === 'choice'
                                ? '<span class="badge" style="background-color: #6366f1; color: #fff;">📝 Test (A,B,C,D)</span>'
                                : '<span class="badge badge--info">💡 Zakovat</span>';
                        },
                    ],
                    [
                        'attribute' => 'question_text',
                        'label' => 'Savol matni',
                        'filterInputOptions' => ['class' => 'form-control form-control-sm', 'placeholder' => 'Savol matni bo\'yicha...'],
                        'format' => 'raw',
                        'value' => fn($model) => '<div style="font-weight: 500; max-width: 450px; line-height: 1.4;">' . 
                            Html::encode(mb_substr($model->question_text, 0, 100)) . 
                            (mb_strlen($model->question_text) > 100 ? '...' : '') . 
                            '</div>',
                    ],
                    [
                        'attribute' => 'answer',
                        'label' => 'To\'g\'ri javob',
                        'filterInputOptions' => ['class' => 'form-control form-control-sm', 'placeholder' => 'Javob bo\'yicha...'],
                        'format' => 'raw',
                        'value' => fn($model) => !empty($model->answer)
                            ? '<strong class="text-success" style="font-size: 0.88rem;">' . Html::encode($model->answer) . '</strong>'
                            : '<span class="text-muted">—</span>',
                    ],
                    [
                        'attribute' => 'difficulty',
                        'label' => 'Qiyinlik',
                        'filter' => ['easy' => 'Oson', 'medium' => 'O\'rta', 'hard' => 'Qiyin'],
                        'filterInputOptions' => ['class' => 'form-select form-select-sm', 'prompt' => 'Barchasi'],
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
                        'filter' => [1 => 'Faol', 0 => 'Nofaol'],
                        'filterInputOptions' => ['class' => 'form-select form-select-sm', 'prompt' => 'Barchasi'],
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width: 100px; text-align: center;'],
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
                                'data-confirm' => 'Haqiqatan ham ushbu savolni o\'chirmoqchimisiz?',
                                'data-method' => 'post',
                            ]),
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
