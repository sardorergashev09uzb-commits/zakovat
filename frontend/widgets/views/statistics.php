<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var int $questionsCount */
/** @var int $usersCount */
/** @var int $categoriesCount */
?>

<!-- STATISTIKA BLOKI -->
<section class="stats-band section">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-item__num"><?= number_format($questionsCount, 0, '', ' ') ?>+</div>
        <div class="stat-item__label">Savollar bazasi</div>
      </div>
      <div class="stat-item">
        <div class="stat-item__num"><?= number_format($usersCount, 0, '', ' ') ?>+</div>
        <div class="stat-item__label">Faol bilimdonlar</div>
      </div>
      <div class="stat-item">
        <div class="stat-item__num"><?= $categoriesCount ?></div>
        <div class="stat-item__label">Mavzular / Kategoriyalar</div>
      </div>
      <div class="stat-item">
        <div class="stat-item__num">100%</div>
        <div class="stat-item__label">Bepul va qulay</div>
      </div>
    </div>
  </div>
</section>