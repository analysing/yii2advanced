<?php

namespace lotto28\controllers;

use lotto28\components\helpers\CustomHelper;
use lotto28\models\ResultPC;

/**
 * 北京PC28
 */
class Bjpc28Controller extends \yii\rest\ActiveController
{
    public $modelClass = 'lotto28\models\ResultPC';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $model = new ResultPC();
        return [CustomHelper::sayHello()];
    }
}