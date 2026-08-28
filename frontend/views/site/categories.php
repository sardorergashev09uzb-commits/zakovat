<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\Category[] $categories */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Kategoriyalar';
?>
<div class="container page-header">
  <h1>Kategoriyalar</h1>
  <p class="text-muted">O'zingizga qiziq bo'lgan mavzuni tanlang va bilim sinovini boshlang</p>
</div>

<div class="container">
  <!-- Qiyinlik darajasi bo'yicha filtr -->
  <div class="filter-bar" id="filterBar">
    <button class="filter-chip is-active" data-filter="all">Barchasi</button>
    <button class="filter-chip" data-filter="easy">Oson</button>
    <button class="filter-chip" data-filter="medium">O'rta</button>
    <button class="filter-chip" data-filter="hard">Qiyin</button>
  </div>

  <div class="grid category-grid" id="categoryGrid">
    <?php if (!empty($categories)): ?>
      <?php foreach ($categories as $cat): ?>
        <?php
          $diff = strtolower((string)$cat->difficulty);
          if ($diff === 'easy' || $diff === 'oson') {
              $diffClass = 'difficulty--easy';
              $diffLabel = 'Oson';
              $diffData = 'easy';
          } elseif ($diff === 'hard' || $diff === 'qiyin') {
              $diffClass = 'difficulty--hard';
              $diffLabel = 'Qiyin';
              $diffData = 'hard';
          } else {
              $diffClass = 'difficulty--medium';
              $diffLabel = 'O\'rta';
              $diffData = 'medium';
          }
          $questionsCount = $cat->getQuestions()->count();
        ?>
        <a href="<?= Url::to(['site/quiz', 'category' => $cat->slug]) ?>" class="card quiz-card" data-difficulty="<?= $diffData ?>">
          <span class="quiz-card__icon"><?= $cat->icon ?: '📚' ?></span>
          <h3><?= Html::encode($cat->name) ?></h3>
          <p class="text-muted" style="font-size:0.9rem;"><?= Html::encode($cat->description ?: "Ushbu kategoriya bo'yicha zakovat savollari") ?></p>
          <div class="quiz-card__meta">
            <span><?= $questionsCount ?> ta savol</span>
            <span class="difficulty <?= $diffClass ?>"><?= $diffLabel ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="text-muted text-center col-12 py-5" style="grid-column: 1 / -1; padding: 48px 0;">
        Hozircha faol kategoriyalar mavjud emas. Admin panel orqali yangi kategoriyalar qo'shishingiz mumkin.
      </div>
    <?php endif; ?>
  </div>
</div>