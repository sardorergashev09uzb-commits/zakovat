<?php

declare(strict_types=1);

namespace backend\widgets;

use common\models\Category;
use common\models\Question;
use common\models\User;
use yii\base\Widget;

class Grid extends Widget
{
    public function run(): string
    {
        $usersCount = (int)User::find()->count();
        $questionsCount = (int)Question::find()->count();
        $categoriesCount = (int)Category::find()->count();

        return $this->render('grid', [
            'usersCount' => $usersCount,
            'questionsCount' => $questionsCount,
            'categoriesCount' => $categoriesCount,
        ]);
    }
}
