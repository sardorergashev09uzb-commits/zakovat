<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var common\models\Category|null $categoryModel */
/** @var array $questionsData */

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = $categoryModel ? $categoryModel->name . ' - Zakovat Quiz' : 'Zakovat Savol-Javob';

$this->registerJsFile('@web/js/quizJs.js?v=2', [
    'depends' => [\frontend\assets\AppAsset::class]
]);

$firstQuestion = !empty($questionsData) ? $questionsData[0] : null;
?>

<script>
  window.quizQuestions = <?= Json::encode($questionsData) ?>;
</script>

<div class="quiz-shell">

  <?php if (empty($questionsData)): ?>
    <div class="card text-center" style="padding: 48px 24px; margin-top: 32px; box-shadow: var(--shadow-sm);">
      <div style="font-size: 3rem; margin-bottom: 16px;">📝</div>
      <h2>Savollar topilmadi</h2>
      <p class="text-muted" style="margin-bottom: 24px; max-width: 460px; margin-left: auto; margin-right: auto;">
        <?= $categoryModel ? '<strong>' . Html::encode($categoryModel->name) . '</strong> kategoriyasi bo\'yicha' : 'Tizimda' ?> hozircha faol savollar kiritilmagan.
      </p>
      <div>
        <a href="<?= Url::to(['/site/categories']) ?>" class="btn btn-primary">← Boshqa kategoriyalarni tanlash</a>
      </div>
    </div>
  <?php else: ?>

    <!-- Header navigatsiya va Rejim tanlash -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <div>
        <a href="<?= Url::to(['/site/categories']) ?>" class="text-muted" style="font-size: 0.9rem;">
          ← Kategoriyalarga qaytish
        </a>
        <h1 style="font-size: 1.5rem; margin-top: 4px; margin-bottom: 0;">
          <?= $categoryModel ? Html::encode($categoryModel->name) : 'Zakovat Savol-Javob va Test' ?>
        </h1>
      </div>
      <div class="d-flex gap-2 align-items-center">
        <span class="badge badge--info" id="topCategoryBadge" style="font-size: 0.85rem; padding: 6px 12px;">
          <?= $categoryModel ? Html::encode($categoryModel->name) : 'Barcha savollar' ?>
        </span>
      </div>
    </div>

    <!-- Active Quiz konteyneri -->
    <div id="quizContainer">
      <!-- Progress bar va aylanma taymer -->
      <div class="quiz-topbar">
        <div style="flex:1;">
          <div class="progress-track">
            <div class="progress-fill" id="progressFill" style="width: <?= round(1 / count($questionsData) * 100) ?>%;"></div>
          </div>
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 8px;">
            <div class="progress-label" id="progressLabel">Savol 1 / <?= count($questionsData) ?></div>
            <div class="d-flex gap-2 align-items-center">
              <span class="badge" id="questionTypeBadge" style="font-size: 0.75rem; background: var(--color-primary); color: #fff;">
                <?= $firstQuestion['type'] === 'choice' ? '📝 Variantli test' : '💡 Zakovat' ?>
              </span>
              <span class="difficulty <?= $firstQuestion['difficulty_class'] ?>" id="questionDifficulty">
                <?= Html::encode($firstQuestion['difficulty_label']) ?>
              </span>
            </div>
          </div>
        </div>

        <!-- "Bilim halqasi" — aylanma taymer komponenti (Zakovat savollarida ko'rinadi) -->
        <div class="knowledge-ring" id="timerRing" title="Zakovat muhokama vaqti">
          <svg viewBox="0 0 64 64">
            <circle class="knowledge-ring__track" cx="32" cy="32" r="26"></circle>
            <circle class="knowledge-ring__fill" id="timerRingFill" cx="32" cy="32" r="26"
              stroke-dasharray="163" stroke-dashoffset="0"></circle>
          </svg>
          <div class="knowledge-ring__value" id="timerValue">60</div>
        </div>
      </div>

      <!-- Taymer boshqaruv tugmalari (Zakovat savollari uchun) -->
      <div class="d-flex align-items-center gap-2 mb-4" id="timerControlsRow">
        <button type="button" class="btn btn-outline btn-sm" id="timerControlBtn" style="font-weight: 600;">
          ▶️ Vaqtni boshlash (60s)
        </button>
        <button type="button" class="btn btn-ghost btn-sm" id="timerResetBtn" style="display: none;">
          🔄 Qayta boshlash
        </button>
      </div>

      <!-- Savol kartasi -->
      <div class="card question-card" id="questionCard" style="box-shadow: var(--shadow-md);">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="question-card__category" id="questionCategory">
            <?= Html::encode($firstQuestion['category_name']) ?>
          </span>
          <span class="text-muted" style="font-size: 0.8rem;" id="qNumberTag">#1</span>
        </div>
        <h2 id="questionText" style="font-size: 1.35rem; line-height: 1.55; color: var(--color-text); margin: 8px 0 0;">
          <?= nl2br(Html::encode($firstQuestion['question_text'])) ?>
        </h2>
      </div>

      <!-- Variantli Test tanlash bloki (A, B, C, D variantlari) -->
      <div id="choiceOptionsBox" class="mt-4" style="display: none;">
        <div class="d-flex flex-column gap-2" id="optionsList">
          <button type="button" class="btn btn-outline text-start p-3 option-btn" data-option="A" id="btnOptionA">
            <span class="fw-bold me-2 badge bg-secondary">A</span> <span class="option-text" id="textOptionA"></span>
          </button>
          <button type="button" class="btn btn-outline text-start p-3 option-btn" data-option="B" id="btnOptionB">
            <span class="fw-bold me-2 badge bg-secondary">B</span> <span class="option-text" id="textOptionB"></span>
          </button>
          <button type="button" class="btn btn-outline text-start p-3 option-btn" data-option="C" id="btnOptionC">
            <span class="fw-bold me-2 badge bg-secondary">C</span> <span class="option-text" id="textOptionC"></span>
          </button>
          <button type="button" class="btn btn-outline text-start p-3 option-btn" data-option="D" id="btnOptionD">
            <span class="fw-bold me-2 badge bg-secondary">D</span> <span class="option-text" id="textOptionD"></span>
          </button>
        </div>
      </div>

      <!-- Zakovat rejimi uchun: Javobni ko'rish va boshqaruv harakatlari -->
      <div class="d-flex flex-column gap-3 mt-4" id="zakovatControlsBox">
        <button type="button" class="btn btn-primary" id="showAnswerBtn" style="padding: 13px 24px; font-size: 1rem;">
          👁️ Javobni ko'rsatish
        </button>

        <!-- Javob qutisi (boshida yopiq bo'ladi) -->
        <div id="answerBox" class="card" style="display: none; background-color: var(--color-success-bg); border-color: var(--color-success); border-width: 1.5px;">
          <div class="card-pad">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 700; color: var(--color-success); margin-bottom: 8px; font-size: 1rem;">
              <span>💡 To'g'ri javob / Izoh:</span>
            </div>
            <p id="answerText" style="font-size: 1.2rem; font-weight: 600; color: var(--color-text); line-height: 1.5; margin: 0;">
              <?= nl2br(Html::encode($firstQuestion['answer'])) ?>
            </p>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <div id="currentScoreDisplay" class="text-muted" style="font-size: 0.9rem; font-weight: 600;">
          To'plangan ball: <span id="correctScoreCount" class="text-success">0</span> ta to'g'ri
        </div>
        <button type="button" class="btn btn-primary" id="nextQuestionBtn" style="display: none; padding: 11px 24px;">
          Keyingi savol ➡️
        </button>
      </div>
    </div>

    <!-- Quiz yakunlanganda ko'rinadigan natijalar bloki -->
    <div class="card text-center" id="quizFinishedCard" style="display: none; padding: 48px 24px; margin-top: 32px; box-shadow: var(--shadow-md);">
      <div style="font-size: 3.5rem; margin-bottom: 16px;">🏆</div>
      <h2 style="font-size: 1.8rem; margin-bottom: 8px;">Sinov yakunlandi!</h2>
      <p class="text-muted" style="margin-bottom: 20px; font-size: 1.05rem;">
        Siz barcha <strong><span id="totalFinishedCount"><?= count($questionsData) ?></span> ta</strong> savolni ko'rib chiqdingiz.
      </p>

      <div class="card p-3 my-3 mx-auto" style="max-width: 380px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <div class="d-flex justify-content-around align-items-center">
          <div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--color-success);" id="finalCorrectCount">0</div>
            <div class="text-muted" style="font-size: 0.82rem;">To'g'ri javoblar</div>
          </div>
          <div style="height: 36px; width: 1px; background: #cbd5e1;"></div>
          <div>
            <div style="font-size: 1.8rem; font-weight: 700; color: var(--color-primary);" id="finalScorePercent">0%</div>
            <div class="text-muted" style="font-size: 0.82rem;">Aniqlik ko'rsatkichi</div>
          </div>
        </div>
      </div>

      <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
        <button type="button" class="btn btn-outline" id="restartQuizBtn">🔄 Qaytadan boshlash</button>
        <a href="<?= Url::to(['/site/categories']) ?>" class="btn btn-primary">🗂️ Boshqa kategoriyalar</a>
      </div>
    </div>

  <?php endif; ?>

</div>