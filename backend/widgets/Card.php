<?php

declare(strict_types=1);

namespace backend\widgets;

use common\models\User;
use yii\base\Widget;

class Card extends Widget
{
    public function run(): string
    {
        $recentUsers = User::find()->orderBy(['id' => SORT_DESC])->limit(5)->all();

        return $this->render('card', [
            'recentUsers' => $recentUsers,
        ]);
    }
}
