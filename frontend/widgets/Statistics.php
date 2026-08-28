<?php

declare(strict_types=1);

namespace frontend\widgets;

use common\models\Category;
use common\models\Question;
use common\models\User;
use yii\base\Widget;

class Statistics extends Widget
{
    public function run(): string
    {
        $questionsCount = (int)Question::find()->where(['status' => 1])->count();
        $usersCount = (int)User::find()->where(['status' => User::STATUS_ACTIVE])->count();
        $categoriesCount = (int)Category::find()->where(['status' => 1])->count();

        return $this->render('statistics', [
            'questionsCount' => $questionsCount,
            'usersCount' => $usersCount,
            'categoriesCount' => $categoriesCount,
        ]);
    }
}