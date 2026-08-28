<?php

namespace backend\controllers;

use common\models\Category;
use common\models\Question;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * QuestionController implements the CRUD actions and CSV Import/Export for Question model.
 */
class QuestionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            /** @var User|null $identity */
                            $identity = Yii::$app->user->identity;
                            return $identity && $identity->isAdmin();
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'import' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Question models with search and filters.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new \backend\models\QuestionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Question();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Barcha savollarni CSV formatida eksport qilish
     */
    public function actionExport(): Response
    {
        $questions = Question::find()->with('category')->orderBy(['id' => SORT_ASC])->all();

        $filename = 'zakovat_savollar_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Microsoft Excel compatibility
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header
        fputcsv($output, [
            'ID',
            'Kategoriya',
            'Turi (open/choice)',
            'Savol matni',
            'Zakovat javobi',
            'A varianti',
            'B varianti',
            'C varianti',
            'D varianti',
            'To\'g\'ri variant (A/B/C/D)',
            'Qiyinlik (easy/medium/hard)',
            'Holati (1=Faol, 0=Nofaol)'
        ]);

        foreach ($questions as $q) {
            fputcsv($output, [
                $q->id,
                $q->category ? $q->category->name : '',
                $q->type ?: 'open',
                $q->question_text,
                $q->answer,
                $q->option_a,
                $q->option_b,
                $q->option_c,
                $q->option_d,
                $q->correct_option,
                $q->difficulty ?: 'medium',
                $q->status,
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Namuna CSV shablonini yuklab olish
     */
    public function actionTemplate(): Response
    {
        $filename = 'zakovat_savollar_namuna.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, [
            'Kategoriya',
            'Turi (open/choice)',
            'Savol matni',
            'Zakovat javobi',
            'A varianti',
            'B varianti',
            'C varianti',
            'D varianti',
            'To\'g\'ri variant (A/B/C/D)',
            'Qiyinlik (easy/medium/hard)'
        ]);

        // Namuna qatorlar
        fputcsv($output, [
            'Tarix',
            'open',
            'Amir Temur nechanchi yilda tavallud topgan?',
            '1336-yil 9-aprelda',
            '',
            '',
            '',
            '',
            '',
            'easy'
        ]);

        fputcsv($output, [
            'Adabiyot',
            'choice',
            'O\'tkan kunlar romani muallifi kim?',
            'Abdulla Qodiriy',
            'Abdulla Qahhor',
            'Abdulla Qodiriy',
            'Cho\'lpon',
            'Fitrat',
            'B',
            'easy'
        ]);

        fclose($output);
        exit;
    }

    /**
     * CSV fayldan savollarni import qilish
     */
    public function actionImport(): Response
    {
        $file = UploadedFile::getInstanceByName('csv_file');
        if (!$file) {
            Yii::$app->session->setFlash('error', 'Iltimos, CSV faylni tanlang.');
            return $this->redirect(['index']);
        }

        if (!in_array(strtolower($file->extension), ['csv', 'txt'])) {
            Yii::$app->session->setFlash('error', 'Faqat .csv formatdagi fayllar qabul qilinadi.');
            return $this->redirect(['index']);
        }

        $handle = fopen($file->tempName, 'r');
        if ($handle === false) {
            Yii::$app->session->setFlash('error', 'Faylni ochishda xatolik yuz berdi.');
            return $this->redirect(['index']);
        }

        // BOM ni olib tashlash
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle);
        if (!$header) {
            Yii::$app->session->setFlash('error', 'CSV fayl bo\'sh.');
            fclose($handle);
            return $this->redirect(['index']);
        }

        $imported = 0;
        $errors = 0;

        // Kategoriyalar keshini tayyorlash
        $categories = Category::find()->all();
        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[mb_strtolower(trim($cat->name))] = $cat->id;
            $categoryMap[mb_strtolower(trim($cat->slug))] = $cat->id;
        }

        $defaultCategory = !empty($categories) ? $categories[0]->id : null;
        if (!$defaultCategory) {
            $newCat = new Category(['name' => 'Umumiy', 'slug' => 'umumiy', 'status' => 1]);
            $newCat->save(false);
            $defaultCategory = $newCat->id;
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row) || (count($row) === 1 && empty($row[0]))) {
                continue;
            }

            // Agar ID ustuni bilan eksport qilingan CSV bo'lsa (12 ta ustun) yoki namuna CSV bo'lsa (10 ta ustun)
            if (count($row) >= 12) {
                // ID bilan
                $catName = trim($row[1]);
                $type = trim($row[2]) ?: 'open';
                $questionText = trim($row[3]);
                $answer = trim($row[4]);
                $optA = trim($row[5]);
                $optB = trim($row[6]);
                $optC = trim($row[7]);
                $optD = trim($row[8]);
                $correctOpt = strtoupper(trim($row[9]));
                $difficulty = trim($row[10]) ?: 'medium';
            } elseif (count($row) >= 10) {
                // Namuna CSV
                $catName = trim($row[0]);
                $type = trim($row[1]) ?: 'open';
                $questionText = trim($row[2]);
                $answer = trim($row[3]);
                $optA = trim($row[4]);
                $optB = trim($row[5]);
                $optC = trim($row[6]);
                $optD = trim($row[7]);
                $correctOpt = strtoupper(trim($row[8]));
                $difficulty = trim($row[9]) ?: 'medium';
            } else {
                // Minimal format (Category, Question, Answer)
                $catName = trim($row[0]);
                $type = 'open';
                $questionText = isset($row[1]) ? trim($row[1]) : '';
                $answer = isset($row[2]) ? trim($row[2]) : '';
                $optA = $optB = $optC = $optD = $correctOpt = null;
                $difficulty = isset($row[3]) ? trim($row[3]) : 'medium';
            }

            if (empty($questionText)) {
                continue;
            }

            // Kategoriyani aniqlash yoki yangisini yaratish
            $catKey = mb_strtolower($catName);
            if (!empty($catName) && isset($categoryMap[$catKey])) {
                $catId = $categoryMap[$catKey];
            } elseif (!empty($catName)) {
                $newCat = new Category([
                    'name' => $catName,
                    'slug' => \yii\helpers\Inflector::slug($catName) . '-' . time() . '-' . rand(10, 99),
                    'status' => 1
                ]);
                if ($newCat->save(false)) {
                    $catId = $newCat->id;
                    $categoryMap[$catKey] = $catId;
                } else {
                    $catId = $defaultCategory;
                }
            } else {
                $catId = $defaultCategory;
            }

            $question = new Question([
                'category_id' => $catId,
                'type' => in_array($type, ['open', 'choice']) ? $type : 'open',
                'question_text' => $questionText,
                'answer' => $answer,
                'option_a' => $optA ?: null,
                'option_b' => $optB ?: null,
                'option_c' => $optC ?: null,
                'option_d' => $optD ?: null,
                'correct_option' => in_array($correctOpt, ['A', 'B', 'C', 'D']) ? $correctOpt : null,
                'difficulty' => in_array(strtolower($difficulty), ['easy', 'medium', 'hard']) ? strtolower($difficulty) : 'medium',
                'status' => 1,
            ]);

            if ($question->save(false)) {
                $imported++;
            } else {
                $errors++;
            }
        }

        fclose($handle);

        Yii::$app->session->setFlash('success', "Muvaffaqiyatli import qilindi: {$imported} ta savol bazaga qo'shildi." . ($errors > 0 ? " ({$errors} ta qatorda xatolik)" : ''));

        return $this->redirect(['index']);
    }
}

