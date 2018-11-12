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
        file_put_contents('d:/1.txt', 'ivy100:'. var_export($data, 1));
        if (!$data) {
            $data = $model->getItems();
            file_put_contents('d:/1.txt', 'data');
            $model->addItemsToRedis($data->getModels()); // 转换为数组
            // file_put_contents('d:/1.txt', 'ivyvivy');
        }
        return $data;
    }
}