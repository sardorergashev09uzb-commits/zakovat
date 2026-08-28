<?php 

namespace backend\widgets;

use yii\base\Widget;

class AdminHeader extends Widget
{

    public function run()
    {
        return $this->render('admin-header');
    }
}