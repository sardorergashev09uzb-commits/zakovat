<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\User[] $recentUsers */

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- So'nggi faoliyat -->
<div class="card">
  <div class="card-pad d-flex justify-content-between align-items-center" style="padding-bottom: 12px;">
    <h2 style="font-size: 1.1rem; margin: 0;">👥 So'nggi ro'yxatdan o'tgan foydalanuvchilar</h2>
    <a href="<?= Url::to(['/user/index']) ?>" class="btn btn-outline btn-sm">Barchasini ko'rish →</a>
  </div>
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead>
        <tr>
          <th>Foydalanuvchi</th>
          <th>Email</th>
          <th>Ro'yxatdan o'tgan sana</th>
          <th style="text-align: center;">Holat</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($recentUsers)): ?>
          <?php foreach ($recentUsers as $u): ?>
            <tr>
              <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span class="nav-user__avatar" style="width: 28px; height: 28px; font-size: 0.75rem;">
                    <?= Html::encode(mb_strtoupper(mb_substr($u->username, 0, 1))) ?>
                  </span>
                  <strong><?= Html::encode($u->username) ?></strong>
                </div>
              </td>
              <td><?= Html::encode($u->email) ?></td>
              <td><?= date('d.m.Y H:i', (int)$u->created_at) ?></td>
              <td style="text-align: center;">
                <?php if ($u->status === User::STATUS_ACTIVE): ?>
                  <span class="badge badge--success">Faol</span>
                <?php elseif ($u->status === User::STATUS_INACTIVE): ?>
                  <span class="badge badge--warning">Kutilmoqda</span>
                <?php else: ?>
                  <span class="badge badge--error">Bloklangan</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center text-muted" style="padding: 24px;">Hozircha foydalanuvchilar mavjud emas</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>