<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<!-- FOOTER BOSHLANISHI -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <a href="<?= Url::to(['/site/index']) ?>" class="logo" style="margin-bottom: 12px;">
          <span class="logo__mark">Z</span>
          Zakovat
        </a>
        <p style="font-size: 0.88rem; line-height: 1.5; color: var(--color-text-muted);">
          Intellektual salohiyatni oshirish, bilimlarni sinash va qiziqarli savol-javoblar uchun yaratilgan zamonaviy ta'limiy platforma.
        </p>
      </div>

      <div class="footer-col">
        <h4>Platforma</h4>
        <a href="<?= Url::to(['/site/categories']) ?>">📚 Kategoriyalar</a>
        <a href="<?= Url::to(['/site/quiz']) ?>">💡 Zakovat Savollari</a>
        <a href="<?= Url::to(['/site/profil']) ?>">👤 Mening profilim</a>
      </div>

      <div class="footer-col">
        <h4>Integratsiyalar</h4>
        <a href="https://t.me/zakovat_savol_007_bot" target="_blank" rel="noopener noreferrer">🤖 Telegram Bot</a>
        <a href="<?= Url::to(['/site/privacy']) ?>">🛡️ Maxfiylik siyosati</a>
        <a href="<?= Url::to(['/site/privacy']) ?>#shartlar">📋 Foydalanish shartlari</a>
      </div>

      <div class="footer-col">
        <h4>Hisob</h4>
        <?php if (Yii::$app->user->isGuest): ?>
          <a href="<?= Url::to(['/site/login']) ?>">🔑 Tizimga kirish</a>
          <a href="<?= Url::to(['/site/register']) ?>">✨ Ro'yxatdan o'tish</a>
        <?php else: ?>
          <a href="<?= Url::to(['/site/profil']) ?>">⚙️ Sozlamalar</a>
          <?= Html::a('🚪 Chiqish (' . Html::encode(Yii::$app->user->identity->username) . ')', ['/site/logout'], ['data-method' => 'post']) ?>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3 border-top mt-4" style="font-size: 0.85rem; color: var(--color-text-muted);">
      <div>
        <span>&copy; <?= date('Y') ?> Zakovat Intellektual Platformasi. Portfolio & Ta'lim loyihasi.</span>
      </div>
      <div>
        <a href="<?= Url::to(['/site/privacy']) ?>" style="color: inherit; text-decoration: underline;">Privacy Policy & Terms</a> &middot; <span>O'zbekiston</span>
      </div>
    </div>
  </div>
</footer>
<!-- FOOTER TUGASHI -->
