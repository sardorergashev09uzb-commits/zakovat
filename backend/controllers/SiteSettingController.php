<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\SiteSetting;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * SiteSettingController faqat sayt sozlamalarini tahrirlash (update) uchun xizmat qiladi.
 */
class SiteSettingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            /** @var \common\models\User|null $identity */
                            $identity = Yii::$app->user->identity;
                            return $identity && $identity->isAdmin();
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                    'update' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * Sayt sozlamalarini ko'rish va yangilash sahifasi.
     *
     * @return string|Response
     */
    public function actionIndex(): string|Response
    {
        $model = SiteSetting::getSettings();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Sayt sozlamalari muvaffaqiyatli saqlandi!');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Update harakati index sahifasiga yo'naltiradi.
     */
    public function actionUpdate(): Response
    {
        return $this->redirect(['index']);
    }
}
