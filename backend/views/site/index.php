<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use backend\widgets\AdminHeader;
use backend\widgets\Card;
use backend\widgets\Grid;

$this->title = 'Dashboard';
?>

<?= AdminHeader::widget([
    'title' => 'Boshqaruv paneli',
]) ?>

<?= Grid::widget() ?>

<?= Card::widget() ?>
