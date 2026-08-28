<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$user = Yii::$app->user->identity;
$username = $user ? $user->username : 'Admin';
$avatarLetter = mb_strtoupper(mb_substr($username, 0, 1));
?>

<!-- HEADER BOSHLANISHI -->
<header class="navbar">
  <div class="container navbar__inner">
    <a href="<?= Url::to(['/site/index']) ?>" class="logo">
      <span class="logo__mark">Z</span>
      Zakovat <span class="text-muted" style="font-weight:500;font-size:0.85rem;">/ Admin</span>
    </a>
    <div class="nav-actions">
      <div class="nav-actions--user" style="display:flex; align-items: center; gap: 12px;">
        <div class="nav-user">
          <span class="nav-user__avatar"><?= Html::encode($avatarLetter) ?></span>
          <span><?= Html::encode($username) ?></span>
        </div>
        <a href="/frontend/web/" target="_blank" class="btn btn-outline btn-sm">Saytga o'tish</a>
        <?= Html::a(
            'Chiqish',
            ['/site/logout'],
            [
                'class' => 'btn btn-ghost btn-sm',
                'data-method' => 'post',
            ]
        ) ?>
      </div>
    </div>
  </div>
</header>
<!-- HEADER TUGASHI -->
