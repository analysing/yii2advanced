<?php

namespace api\controllers;

use yii\rest\ActiveController;
use api\models\ResultPC;

/**
* 北京PC28
*/
class Bjpc28Controller extends ActiveController
{
    public $modelClass = 'api\models\ResultPC';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $model = new ResultPC();
        $data = $model->getItemsViaRedis();
        if (!$data) {
            $data = $model->getItems();
            $model->addItemsToRedis($data); // 转换为数组
        }
        return $data;
    }
}