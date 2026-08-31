<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$actionId = Yii::$app->controller->action->id;
$isGuest = Yii::$app->user->isGuest;
$user = !$isGuest ? Yii::$app->user->identity : null;
$username = $user ? $user->username : '';
$isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
$avatarLetter = $username ? mb_strtoupper(mb_substr($username, 0, 1)) : 'U';
?>

<!-- HEADER BOSHLANISHI -->
<header class="navbar">
  <div class="container navbar__inner">
    <a href="<?= Url::to(['/site/index']) ?>" class="logo">
      <span class="logo__mark">Z</span>
      Zakovat
    </a>
    <nav class="nav-links" id="navLinks">
      <a href="<?= Url::to(['/site/index']) ?>" class="<?= $actionId === 'index' ? 'is-active' : '' ?>">Bosh sahifa</a>
      <a href="<?= Url::to(['/site/categories']) ?>" class="<?= $actionId === 'categories' ? 'is-active' : '' ?>">Kategoriyalar</a>
      <a href="<?= Url::to(['/site/quiz']) ?>" class="<?= $actionId === 'quiz' ? 'is-active' : '' ?>">Savollar & Testlar</a>
      <?php if (!$isGuest): ?>
        <a href="<?= Url::to(['/site/profil']) ?>" class="<?= $actionId === 'profil' ? 'is-active' : '' ?>">Profil</a>
      <?php endif; ?>
    </nav>
    <div class="nav-actions">
      <?php if ($isGuest): ?>
        <div class="nav-actions--guest" style="display: flex; align-items: center; gap: 8px;">
          <a href="<?= Url::to(['/site/login']) ?>" class="btn btn-ghost">Kirish</a>
          <a href="<?= Url::to(['/site/register']) ?>" class="btn btn-primary">Ro'yxatdan o'tish</a>
        </div>
      <?php else: ?>
        <div class="nav-actions--user" style="display: flex; align-items: center; gap: 12px;">
          <?php if ($isAdmin): ?>
            <a href="/admin" class="btn btn-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 8px; font-size: 0.82rem; font-weight: 600; padding: 6px 12px; text-decoration: none;">
              👑 Admin Panel
            </a>
          <?php endif; ?>
          <a href="<?= Url::to(['/site/profil']) ?>" class="nav-user" style="text-decoration: none; color: inherit;">
            <span class="nav-user__avatar"><?= Html::encode($avatarLetter) ?></span>
            <span><?= Html::encode($username) ?></span>
          </a>
          <?= Html::a('Chiqish', ['/site/logout'], [
              'class' => 'btn btn-outline btn-sm',
              'data-method' => 'post',
          ]) ?>
        </div>
      <?php endif; ?>
    </div>
    <button class="nav-toggle" id="navToggle" aria-label="Menyuni ochish" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
</header>
<!-- HEADER TUGASHI -->
