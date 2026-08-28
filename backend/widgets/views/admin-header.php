<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $title */
/** @var string $date */
/** @var string|null $subtitle */

use yii\helpers\Html;
?>
<div class="admin-header">
    <h1><?= Html::encode($title) ?></h1>
    <span class="text-muted" style="font-size:0.9rem;">
        Bugun, <?= Html::encode($date) ?>
        <?php if (!empty($subtitle)): ?>
            - <?= Html::encode($subtitle) ?>
        <?php endif; ?>
    </span>
</div>