<?php

namespace frontend\widgets;

use common\models\Category;
use common\models\Question;
use common\models\SiteSetting;
use yii\base\Widget;

class Hero extends Widget
{
    public function run()
    {
        $setting = SiteSetting::getSettings();
        $questionsCount = (int)Question::find()->where(['status' => 1])->count();
        $categoriesCount = (int)Category::find()->where(['status' => 1])->count();

        return $this->render('hero', [
            'setting' => $setting,
            'questionsCount' => $questionsCount,
            'categoriesCount' => $categoriesCount,
        ]);
    }
}