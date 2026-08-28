<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\models\Category;
use common\models\LoginForm;
use frontend\models\SignupForm;
use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'register', 'login', 'profil'],
                'rules' => [
                    [
                        'actions' => ['register', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'profil'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Bosh sahifa (index.php)
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Kategoriyalar sahifasi (categories.php)
     */
    public function actionCategories(): string
    {
        $categories = Category::find()->where(['status' => 1])->all();

        return $this->render('categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Tizimga kirish (login.php)
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Tizimdan chiqish
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Ro'yxatdan o'tish (register.php)
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user && Yii::$app->user->login($user, 3600 * 24 * 30)) {
                Yii::$app->session->setFlash('success', 'Muvaffaqiyatli ro\'yxatdan o\'tdingiz! Xush kelibsiz!');
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Foydalanuvchi profili (profil.php)
     */
    /**
     * Foydalanuvchi profili (profil.php)
     */
    public function actionProfil()
    {
        /** @var \common\models\User $user */
        $user = Yii::$app->user->identity;

        if ($this->request->isPost) {
            $post = $this->request->post('User');
            if (isset($post['username'])) {
                $user->username = trim((string)$post['username']);
            }
            if (isset($post['email'])) {
                $user->email = trim((string)$post['email']);
            }
            if (!empty($post['password'])) {
                $user->password = (string)$post['password'];
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Profilingiz muvaffaqiyatli yangilandi.');
                return $this->refresh();
            } else {
                $firstError = reset($user->firstErrors);
                Yii::$app->session->setFlash('error', $firstError ?: 'Ma\'lumotlarni saqlashda xatolik yuz berdi.');
            }
        }

        return $this->render('profil', [
            'user' => $user,
        ]);
    }

    /**
     * Test / Quiz sahifasi (quiz.php)
     */
    public function actionQuiz($category = null, $type = null): string
    {
        $query = \common\models\Question::find()->where(['status' => 1]);

        $categoryModel = null;
        if (!empty($category)) {
            $categoryModel = Category::findOne(['slug' => $category, 'status' => 1]);
            if ($categoryModel) {
                $query->andWhere(['category_id' => $categoryModel->id]);
            }
        }

        if (!empty($type) && in_array($type, ['open', 'choice'])) {
            $query->andWhere(['type' => $type]);
        }

        $questions = $query->with('category')->orderBy(['id' => SORT_ASC])->all();

        $questionsData = [];
        foreach ($questions as $q) {
            $diff = strtolower((string)$q->difficulty);
            if ($diff === 'easy' || $diff === 'oson') {
                $diffLabel = 'Oson';
                $diffClass = 'difficulty--easy';
            } elseif ($diff === 'hard' || $diff === 'qiyin') {
                $diffLabel = 'Qiyin';
                $diffClass = 'difficulty--hard';
            } else {
                $diffLabel = 'O\'rta';
                $diffClass = 'difficulty--medium';
            }

            $questionsData[] = [
                'id' => $q->id,
                'type' => $q->type ?: 'open',
                'category_name' => $q->category ? (($q->category->icon ? $q->category->icon . ' ' : '📁 ') . $q->category->name) : 'Umumiy savol',
                'difficulty_label' => $diffLabel,
                'difficulty_class' => $diffClass,
                'question_text' => $q->question_text,
                'answer' => $q->answer ?: 'Javob kiritilmagan',
                'option_a' => $q->option_a ?: '',
                'option_b' => $q->option_b ?: '',
                'option_c' => $q->option_c ?: '',
                'option_d' => $q->option_d ?: '',
                'correct_option' => strtoupper((string)$q->correct_option),
            ];
        }

        return $this->render('quiz', [
            'categoryModel' => $categoryModel,
            'questionsData' => $questionsData,
            'activeType' => $type,
        ]);
    }

    /**
     * Natijalar sahifasi (results.php)
     */
    public function actionResults(): string
    {
        return $this->render('results');
    }

    /**
     * Maxfiylik siyosati va Foydalanish shartlari (privacy.php)
     */
    public function actionPrivacy(): string
    {
        return $this->render('privacy');
    }
}