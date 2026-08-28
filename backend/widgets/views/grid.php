<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var int $usersCount */
/** @var int $questionsCount */
/** @var int $categoriesCount */
?>
<!-- Asosiy ko'rsatkichlar -->
<div class="grid admin-kpi-grid">
  <div class="card kpi-card">
    <div class="kpi-card__label">👥 Jami foydalanuvchilar</div>
    <div class="kpi-card__num"><?= number_format($usersCount, 0, '', ' ') ?></div>
  </div>
  <div class="card kpi-card">
    <div class="kpi-card__label">📝 Jami savollar</div>
    <div class="kpi-card__num"><?= number_format($questionsCount, 0, '', ' ') ?></div>
  </div>
  <div class="card kpi-card">
    <div class="kpi-card__label">🗂️ Kategoriyalar soni</div>
    <div class="kpi-card__num"><?= number_format($categoriesCount, 0, '', ' ') ?></div>
  </div>
  <div class="card kpi-card">
    <div class="kpi-card__label">✨ Tizim holati</div>
    <div class="kpi-card__num" style="color: var(--color-success); font-size: 1.35rem;">Online</div>
  </div>
</div>