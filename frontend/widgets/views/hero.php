<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\SiteSetting $setting */
/** @var int $questionsCount */
/** @var int $categoriesCount */
?>
<!-- HERO QISMI -->
<section class="hero">
  <div class="container hero__inner">
    <div class="hero__content">
      <span class="hero__eyebrow">🎓 Bilimlar musobaqasi</span>
      <h1><?= Html::encode($setting->banner_title ?: "Bilimingizni sinang, zakovatingizni ko'rsating") ?></h1>
      <p><?= Html::encode($setting->about ?: "O'nlab kategoriyalarda minglab savollar orqali bilimingizni mustahkamlang, reytingda ko'tariling va do'stlaringiz bilan raqobatlashing.") ?></p>
      <div class="hero__actions">
        <a href="<?= Url::to(['site/categories']) ?>" class="btn btn-primary">Boshlash</a>
        <a href="#qanday-ishlaydi" class="btn btn-outline">Qanday ishlaydi?</a>
      </div>
    </div>
    <div class="hero__visual">
      <!-- Signature "bilim halqasi" — hero'dagi vizual urg'u -->
      <div class="knowledge-ring" style="width:220px;height:220px;">
        <svg viewBox="0 0 220 220">
          <circle class="knowledge-ring__track" cx="110" cy="110" r="96"></circle>
          <circle class="knowledge-ring__fill" cx="110" cy="110" r="96"
            stroke-dasharray="603" stroke-dashoffset="140"></circle>
        </svg>
        <div class="knowledge-ring__value" style="flex-direction:column;">
          <span style="font-size:2.4rem; font-weight: 700; color: var(--color-primary);"><?= $questionsCount ?>+</span>
          <span style="font-size:0.85rem;color:var(--color-text-muted);font-weight:600;">intellektual savol</span>
        </div>
      </div>
    </div>
  </div>
</section>