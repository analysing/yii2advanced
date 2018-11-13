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

    // 未开 1000
    public function actionAnalysis($limit)
    {
        if (!is_int($limit) || $limit > 1000 || $limit <= 0) {
            $limit = 200;
        }
        $model = new ResultPC();
        // $data = $model->getItems(200);
        $data = $model->find()->orderBy('nu_id desc')->limit($limit)->asArray()->all();
        $res = [];
        foreach ($data as $k => $v) {
            if ($v['sum_big'] == '大' && !isset($res['big'])) {
                $res['big'] = $k;
            } elseif ($v['sum_big'] == '小' && !isset($res['small'])) {
                $res['small'] = $k;
            }

            if ($v['sum_even'] == '单' && !isset($res['even'])) {
                $res['even'] = $k;
            } elseif ($v['sum_even'] == '双' && !isset($res['odd'])) {
                $res['odd'] = $k;
            }

            if ($v['sum_bigeven'] == '小单' && !isset($res['small_even'])) {
                $res['small_even'] = $k;
            } elseif ($v['sum_bigeven'] == '大单' && !isset($res['big_even'])) {
                $res['big_even'] = $k;
            } elseif ($v['sum_bigeven'] == '小双' && !isset($res['small_odd'])) {
                $res['small_odd'] = $k;
            } elseif ($v['sum_bigeven'] == '大双' && !isset($res['big_odd'])) {
                $res['big_odd'] = $k;
            }

            if ($v['sum_limit'] == '极大' && !isset($res['big_limit'])) {
                $res['big_limit'] = $k;
            } elseif ($v['sum_limit'] == '极小' && !isset($res['small_limit'])) {
                $res['small_limit'] = $k;
            }

            for ($i=0; $i < 28; $i++) { 
                if ($v['number_sum'] == $i && !isset($res['c'. $i])) {
                    $res['c'. $i] = $k;
                }
            }
        }

        return $res;
    }
}