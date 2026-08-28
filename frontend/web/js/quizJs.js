/* =======================================================================
   ZAKOVAT — quizJs.js
   Intellektual zakovat va Variantli test mexanizmi:
   1) Zakovat rejimi (Ochiq savol): 60 soniyalik aylanma taymer, javobni ko'rish.
   2) Variantli test rejimi: 4 ta variant (A, B, C, D), darhol to'g'ri/noto'g'ri
      tekshirish, ballarni hisoblash va yakuniy statistika.
   ======================================================================= */

function initZakovatQuiz() {
  var questions = window.quizQuestions || [];
  if (!questions || questions.length === 0) {
    return;
  }

  var TIMER_SECONDS = 60;
  var currentIndex = 0;
  var timeLeft = TIMER_SECONDS;
  var timerInterval = null;
  var isRunning = false;
  var correctScore = 0;
  var answeredThisQuestion = false;

  var RING_CIRCUMFERENCE = 163; // 2 * PI * 26
  var ringFill = document.getElementById('timerRingFill');
  var timerValueEl = document.getElementById('timerValue');
  var timerRing = document.getElementById('timerRing');
  var timerControlBtn = document.getElementById('timerControlBtn');
  var timerResetBtn = document.getElementById('timerResetBtn');
  var timerControlsRow = document.getElementById('timerControlsRow');

  var questionCategoryEl = document.getElementById('questionCategory');
  var questionTypeBadge = document.getElementById('questionTypeBadge');
  var questionDifficultyEl = document.getElementById('questionDifficulty');
  var questionTextEl = document.getElementById('questionText');
  var qNumberTagEl = document.getElementById('qNumberTag');

  var choiceOptionsBox = document.getElementById('choiceOptionsBox');
  var zakovatControlsBox = document.getElementById('zakovatControlsBox');
  var showAnswerBtn = document.getElementById('showAnswerBtn');
  var answerBoxEl = document.getElementById('answerBox');
  var answerTextEl = document.getElementById('answerText');
  var nextQuestionBtn = document.getElementById('nextQuestionBtn');

  var progressFill = document.getElementById('progressFill');
  var progressLabel = document.getElementById('progressLabel');
  var correctScoreCountEl = document.getElementById('correctScoreCount');

  var quizContainer = document.getElementById('quizContainer');
  var quizFinishedCard = document.getElementById('quizFinishedCard');
  var finalCorrectCountEl = document.getElementById('finalCorrectCount');
  var finalScorePercentEl = document.getElementById('finalScorePercent');
  var restartQuizBtn = document.getElementById('restartQuizBtn');

  var optionButtons = {
    'A': document.getElementById('btnOptionA'),
    'B': document.getElementById('btnOptionB'),
    'C': document.getElementById('btnOptionC'),
    'D': document.getElementById('btnOptionD')
  };

  var optionTexts = {
    'A': document.getElementById('textOptionA'),
    'B': document.getElementById('textOptionB'),
    'C': document.getElementById('textOptionC'),
    'D': document.getElementById('textOptionD')
  };

  // Taymer doirasini yangilash
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

  // Taymerni to'xtatish
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

  // Taymerni boshlash
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

  // Taymerni qayta tiklash
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

  // Variant tanlanganda tekshirish
  function handleOptionClick(selectedOpt) {
    if (answeredThisQuestion) return;
    answeredThisQuestion = true;

    var currentQ = questions[currentIndex];
    var correctOpt = (currentQ.correct_option || '').toUpperCase();

    // Tugmalar holatini yangilash
    ['A', 'B', 'C', 'D'].forEach(function(optKey) {
      var btn = optionButtons[optKey];
      if (!btn) return;
      btn.disabled = true;

      if (optKey === correctOpt) {
        btn.classList.remove('btn-outline');
        btn.classList.add('btn-success');
        btn.style.backgroundColor = '#10b981';
        btn.style.color = '#ffffff';
        btn.style.borderColor = '#10b981';
      } else if (optKey === selectedOpt && selectedOpt !== correctOpt) {
        btn.classList.remove('btn-outline');
        btn.classList.add('btn-danger');
        btn.style.backgroundColor = '#ef4444';
        btn.style.color = '#ffffff';
        btn.style.borderColor = '#ef4444';
      }
    });

    if (selectedOpt === correctOpt) {
      correctScore++;
      if (correctScoreCountEl) {
        correctScoreCountEl.textContent = correctScore;
      }
    }

    // Agar savol uchun izoh bo'lsa uni ko'rsatish
    if (currentQ.answer && currentQ.answer.trim() !== '') {
      if (answerTextEl) answerTextEl.textContent = currentQ.answer;
      if (answerBoxEl) answerBoxEl.style.display = 'block';
    }

    if (nextQuestionBtn) {
      nextQuestionBtn.style.display = 'inline-flex';
    }
  }

  // Joriy savolni ekranga chiqarish
  function renderQuestion(index) {
    if (index >= questions.length) {
      // Quiz tugadi
      if (quizContainer) quizContainer.style.display = 'none';
      if (quizFinishedCard) quizFinishedCard.style.display = 'block';

      if (finalCorrectCountEl) finalCorrectCountEl.textContent = correctScore;
      if (finalScorePercentEl) {
        var pct = Math.round((correctScore / questions.length) * 100);
        finalScorePercentEl.textContent = pct + '%';
      }
      return;
    }

    answeredThisQuestion = false;
    var q = questions[index];

    if (questionCategoryEl) questionCategoryEl.textContent = q.category_name || 'Savol';
    if (qNumberTagEl) qNumberTagEl.textContent = '#' + (index + 1);

    if (questionTypeBadge) {
      if (q.type === 'choice') {
        questionTypeBadge.textContent = '📝 Variantli test';
        questionTypeBadge.style.background = '#6366f1';
      } else {
        questionTypeBadge.textContent = '💡 Zakovat';
        questionTypeBadge.style.background = 'var(--color-primary)';
      }
    }

    if (questionDifficultyEl) {
      questionDifficultyEl.className = 'difficulty ' + (q.difficulty_class || 'difficulty--medium');
      questionDifficultyEl.textContent = q.difficulty_label || 'O\'rta';
    }

    if (questionTextEl) questionTextEl.textContent = q.question_text || '';
    if (answerTextEl) answerTextEl.textContent = q.answer || '';

    // Barcha javob bloklarini dastlab yashirish
    if (answerBoxEl) answerBoxEl.style.display = 'none';
    if (nextQuestionBtn) nextQuestionBtn.style.display = 'none';

    // Savol turi bo'yicha moslashtirish
    if (q.type === 'choice') {
      // Variantli test rejimi
      if (timerRing) timerRing.style.display = 'none';
      if (timerControlsRow) timerControlsRow.style.display = 'none';
      if (zakovatControlsBox) zakovatControlsBox.style.display = 'none';
      if (choiceOptionsBox) choiceOptionsBox.style.display = 'block';

      // Variantlarni to'ldirish va tugmalarni qayta tiklash
      var options = {
        'A': q.option_a,
        'B': q.option_b,
        'C': q.option_c,
        'D': q.option_d
      };

      ['A', 'B', 'C', 'D'].forEach(function(optKey) {
        var btn = optionButtons[optKey];
        var txt = optionTexts[optKey];
        if (btn && txt) {
          btn.disabled = false;
          btn.className = 'btn btn-outline text-start p-3 option-btn';
          btn.style.backgroundColor = '';
          btn.style.color = '';
          btn.style.borderColor = '';

          if (options[optKey] && options[optKey].trim() !== '') {
            txt.textContent = options[optKey];
            btn.style.display = 'block';
          } else {
            btn.style.display = 'none';
          }
        }
      });

    } else {
      // Zakovat (Ochiq savol) rejimi
      if (choiceOptionsBox) choiceOptionsBox.style.display = 'none';
      if (timerRing) timerRing.style.display = 'block';
      if (timerControlsRow) timerControlsRow.style.display = 'flex';
      if (zakovatControlsBox) zakovatControlsBox.style.display = 'flex';

      if (showAnswerBtn) {
        showAnswerBtn.style.display = 'block';
        showAnswerBtn.disabled = false;
      }

      resetTimer();
    }

    // Progress bar yangilash
    var progressPercent = Math.round(((index + 1) / questions.length) * 100);
    if (progressFill) progressFill.style.width = progressPercent + '%';
    if (progressLabel) progressLabel.textContent = 'Savol ' + (index + 1) + ' / ' + questions.length;
  }

  // Variantli test tugmalariga hodisa ulash
  ['A', 'B', 'C', 'D'].forEach(function(optKey) {
    var btn = optionButtons[optKey];
    if (btn) {
      btn.onclick = function () {
        handleOptionClick(optKey);
      };
    }
  });

  // "Javobni ko'rsatish" tugmasi (Zakovat)
  if (showAnswerBtn) {
    showAnswerBtn.addEventListener('click', function () {
      if (answerBoxEl) {
        answerBoxEl.style.display = 'block';
      }
      if (nextQuestionBtn) {
        nextQuestionBtn.style.display = 'inline-flex';
      }
      showAnswerBtn.style.display = 'none';
    });
  }

  // "Keyingi savol" tugmasi
  if (nextQuestionBtn) {
    nextQuestionBtn.addEventListener('click', function () {
      currentIndex++;
      renderQuestion(currentIndex);
    });
  }

  // Taymer boshqaruv tugmalari
  if (timerControlBtn) {
    timerControlBtn.addEventListener('click', startTimer);
  }
  if (timerResetBtn) {
    timerResetBtn.addEventListener('click', resetTimer);
  }

  // Qaytadan boshlash tugmasi
  if (restartQuizBtn) {
    restartQuizBtn.addEventListener('click', function () {
      currentIndex = 0;
      correctScore = 0;
      if (correctScoreCountEl) correctScoreCountEl.textContent = '0';
      if (quizFinishedCard) quizFinishedCard.style.display = 'none';
      if (quizContainer) quizContainer.style.display = 'block';
      renderQuestion(0);
    });
  }

  // Boshlang'ich birinchi savolni yuklash
  renderQuestion(0);
}

// Skript yuklanganda darhol yoki DOM tayyor bo'lganda ishga tushirish
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initZakovatQuiz);
} else {
  initZakovatQuiz();
}