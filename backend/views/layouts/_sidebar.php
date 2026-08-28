<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\helpers\Url;

$controllerId = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;
?>

<!-- Admin sidebar navigatsiyasi -->
<aside class="admin-sidebar">
    <div class="admin-sidebar__title">Asosiy</div>
    <a href="<?= Url::to(['/site/index']) ?>" class="admin-nav-link <?= ($controllerId === 'site' && $actionId === 'index') ? 'is-active' : '' ?>">
        <span>📊</span> Statistika
    </a>

    <div class="admin-sidebar__title" style="margin-top: 20px;">Boshqaruv</div>
    <a href="<?= Url::to(['/category/index']) ?>" class="admin-nav-link <?= ($controllerId === 'category') ? 'is-active' : '' ?>">
        <span>🗂️</span> Kategoriyalar
    </a>
    <a href="<?= Url::to(['/question/index']) ?>" class="admin-nav-link <?= ($controllerId === 'question') ? 'is-active' : '' ?>">
        <span>📝</span> Savollar
    </a>
    <a href="<?= Url::to(['/user/index']) ?>" class="admin-nav-link <?= ($controllerId === 'user') ? 'is-active' : '' ?>">
        <span>👥</span> Foydalanuvchilar
    </a>

    <div class="admin-sidebar__title" style="margin-top: 20px;">Sozlamalar</div>
    <a href="<?= Url::to(['/site-setting/index']) ?>" class="admin-nav-link <?= ($controllerId === 'site-setting') ? 'is-active' : '' ?>">
        <span>⚙️</span> Sayt sozlamalari
    </a>

    <div class="admin-sidebar__title" style="margin-top: 20px;">Boshqa</div>
    <a href="/frontend/web/" target="_blank" class="admin-nav-link">
        <span>🌐</span> Saytni ko'rish
    </a>
    <?= Html::a(
        '<span>🚪</span> Chiqish',
        ['/site/logout'],
        [
            'class' => 'admin-nav-link text-danger',
            'data-method' => 'post',
        ]
    ) ?>
</aside>