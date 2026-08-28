/* =======================================================================
   ZAKOVAT — quizJs.js
   Intellektual zakovat savol-javob mexanizmi
   ======================================================================= */

document.addEventListener('DOMContentLoaded', function () {
  var questions = window.quizQuestions || [];
  if (!questions || questions.length === 0) {
    return;
  }

  var TIMER_SECONDS = 60;
  var currentIndex = 0;
  var timeLeft = TIMER_SECONDS;
  var timerInterval = null;
  var isRunning = false;

  var RING_CIRCUMFERENCE = 163;
  var ringFill = document.getElementById('timerRingFill');
  var timerValueEl = document.getElementById('timerValue');
  var timerControlBtn = document.getElementById('timerControlBtn');
  var timerResetBtn = document.getElementById('timerResetBtn');

  var questionCategoryEl = document.getElementById('questionCategory');
  var questionDifficultyEl = document.getElementById('questionDifficulty');
  var questionTextEl = document.getElementById('questionText');
  var qNumberTagEl = document.getElementById('qNumberTag');

  var showAnswerBtn = document.getElementById('showAnswerBtn');
  var answerBoxEl = document.getElementById('answerBox');
  var answerTextEl = document.getElementById('answerText');
  var nextQuestionBtn = document.getElementById('nextQuestionBtn');

  var progressFill = document.getElementById('progressFill');
  var progressLabel = document.getElementById('progressLabel');

  var quizContainer = document.getElementById('quizContainer');
  var quizFinishedCard = document.getElementById('quizFinishedCard');
  var restartQuizBtn = document.getElementById('restartQuizBtn');

  function updateRing() {
    if (!ringFill || !timerValueEl) return;
    var fraction = timeLeft / TIMER_SECONDS;
    var offset = RING_CIRCUMFERENCE * (1 - fraction);
    ringFill.style.strokeDashoffset = offset;
    timerValueEl.textContent = timeLeft;

    if (timeLeft <= 10) {
      ringFill.classList.add('is-urgent');
      timerValueEl.style.color = 'var(--color-error)';
    } else {
      ringFill.classList.remove('is-urgent');
      timerValueEl.style.color = 'var(--color-text)';
    }
  }

  function pauseTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    isRunning = false;
    if (timerControlBtn) {
      timerControlBtn.textContent = '▶️ Davom ettirish';
      timerControlBtn.classList.remove('btn-danger');
      timerControlBtn.classList.add('btn-outline');
    }
  }

  function startTimer() {
    if (isRunning) {
      pauseTimer();
      return;
    }

    isRunning = true;
    if (timerControlBtn) {
      timerControlBtn.textContent = '⏸️ Vaqtni to\'xtatish';
      timerControlBtn.classList.remove('btn-outline');
      timerControlBtn.classList.add('btn-danger');
    }
    if (timerResetBtn) {
      timerResetBtn.style.display = 'inline-flex';
    }

    clearInterval(timerInterval);
    timerInterval = setInterval(function () {
      timeLeft--;
      updateRing();

      if (timeLeft <= 0) {
        clearInterval(timerInterval);
        isRunning = false;
        if (timerControlBtn) {
          timerControlBtn.textContent = '⏰ Vaqt tugadi!';
          timerControlBtn.classList.remove('btn-danger');
          timerControlBtn.classList.add('btn-outline');
        }
      }
    }, 1000);
  }

  function resetTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    isRunning = false;
    timeLeft = TIMER_SECONDS;
    updateRing();

    if (timerControlBtn) {
      timerControlBtn.textContent = '▶️ Vaqtni boshlash (60s)';
      timerControlBtn.classList.remove('btn-danger');
      timerControlBtn.classList.add('btn-outline');
    }
    if (timerResetBtn) {
      timerResetBtn.style.display = 'none';
    }
  }

  function renderQuestion(index) {
    if (index >= questions.length) {
      if (quizContainer) quizContainer.style.display = 'none';
      if (quizFinishedCard) quizFinishedCard.style.display = 'block';
      return;
    }

    var q = questions[index];

    if (questionCategoryEl) questionCategoryEl.textContent = q.category_name || 'Savol';
    if (qNumberTagEl) qNumberTagEl.textContent = '#' + (index + 1);

    if (questionDifficultyEl) {
      questionDifficultyEl.className = 'difficulty ' + (q.difficulty_class || 'difficulty--medium');
      questionDifficultyEl.textContent = q.difficulty_label || 'O\'rta';
    }

    if (questionTextEl) questionTextEl.textContent = q.question_text || '';
    if (answerTextEl) answerTextEl.textContent = q.answer || '';

    if (answerBoxEl) answerBoxEl.style.display = 'none';
    if (nextQuestionBtn) nextQuestionBtn.style.display = 'none';
    if (showAnswerBtn) {
      showAnswerBtn.style.display = 'block';
      showAnswerBtn.disabled = false;
    }

    var progressPercent = Math.round(((index + 1) / questions.length) * 100);
    if (progressFill) progressFill.style.width = progressPercent + '%';
    if (progressLabel) progressLabel.textContent = 'Savol ' + (index + 1) + ' / ' + questions.length;

    resetTimer();
  }

  if (showAnswerBtn) {
    showAnswerBtn.addEventListener('click', function () {
      if (answerBoxEl) answerBoxEl.style.display = 'block';
      if (nextQuestionBtn) nextQuestionBtn.style.display = 'inline-flex';
      showAnswerBtn.style.display = 'none';
    });
  }

  if (nextQuestionBtn) {
    nextQuestionBtn.addEventListener('click', function () {
      currentIndex++;
      renderQuestion(currentIndex);
    });
  }

  if (timerControlBtn) {
    timerControlBtn.addEventListener('click', startTimer);
  }
  if (timerResetBtn) {
    timerResetBtn.addEventListener('click', resetTimer);
  }

  if (restartQuizBtn) {
    restartQuizBtn.addEventListener('click', function () {
      currentIndex = 0;
      if (quizFinishedCard) quizFinishedCard.style.display = 'none';
      if (quizContainer) quizContainer.style.display = 'block';
      renderQuestion(0);
    });
  }

  renderQuestion(0);
});