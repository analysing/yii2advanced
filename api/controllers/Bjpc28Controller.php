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
            $model->addItemsToRedis($data);
        }
        return $data;
    }

    public function actionLatest()
    {
        $model = new ResultPC();
        $issues = $model->getRedisIssues();
        $latest = $model->getRedisLatest();
        $diff = array_diff($issues, $latest);
        if (count($diff) >= 1) {
            $latest = end($diff);
            sort($issues);
            if ($latest > end($issues)) {
                $info = $model->getItemByIssueViaRedis($latest);
                $model->addLatestToRedis($latest);
                return $info;
            }
        }
        return [];
    }

    public function actionAnalysis()
    {
        $model = new ResultPC();
        $data = $model->getItems(200);
        
    }
}