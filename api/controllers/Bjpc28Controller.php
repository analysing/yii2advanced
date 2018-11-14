<?php

namespace api\controllers;

use yii\rest\ActiveController;
use api\models\ResultPC;
use api\components\helpers\CustomHelper;

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
    public function actionAnalysis($limit = 200)
    {
        if (!is_numeric($limit) || $limit > 1000 || $limit <= 0) {
            $limit = 200;
        }
        $model = new ResultPC();
        // $data = $model->getItems(200);
        $data = $model->find()->orderBy('nu_id desc')->limit($limit)->asArray()->all();
        $res = ['big' => '--', 'small' => '--', 'even' => '--', 'odd' => '--', 'small_even' => '--', 'small_odd' => '--', 'big_even' => '--', 'big_odd' => '--', 'small_limit' => '--', 'big_limit' => '--'];
        for ($i=0; $i < 28; $i++) { 
            $res['c'. $i] = '--';
        }
        foreach ($data as $k => $v) {
            if ($v['sum_big'] == '大' && (!isset($res['big']) || $res['big'] == '--')) {
                $res['big'] = ['num' => $k, 'is_color' => ($k > 6 ? 1 : 0)];
            } elseif ($v['sum_big'] == '小' && (!isset($res['small']) || $res['small'] == '--')) {
                $res['small'] = ['num' => $k, 'is_color' => ($k > 6 ? 1 : 0)];
            }

            if ($v['sum_even'] == '单' && (!isset($res['even']) || $res['even'] == '--')) {
                $res['even'] = ['num' => $k, 'is_color' => ($k > 6 ? 1 : 0)];
            } elseif ($v['sum_even'] == '双' && (!isset($res['odd']) || $res['odd'] == '--')) {
                $res['odd'] = ['num' => $k, 'is_color' => ($k > 6 ? 1 : 0)];
            }

            if ($v['sum_bigeven'] == '小单' && (!isset($res['small_even']) || $res['small_even'] == '--')) {
                $res['small_even'] = ['num' => $k, 'is_color' => ($k > 10 ? 1 : 0)];
            } elseif ($v['sum_bigeven'] == '大单' && (!isset($res['big_even']) || $res['big_even'] == '--')) {
                $res['big_even'] = ['num' => $k, 'is_color' => ($k > 10 ? 1 : 0)];
            } elseif ($v['sum_bigeven'] == '小双' && (!isset($res['small_odd']) || $res['small_odd'] == '--')) {
                $res['small_odd'] = ['num' => $k, 'is_color' => ($k > 10 ? 1 : 0)];
            } elseif ($v['sum_bigeven'] == '大双' && (!isset($res['big_odd']) || $res['big_odd'] == '--')) {
                $res['big_odd'] = ['num' => $k, 'is_color' => ($k > 10 ? 1 : 0)];
            }

            if ($v['sum_limit'] == '极大' && (!isset($res['big_limit']) || $res['big_limit'] == '--')) {
                $res['big_limit'] = ['num' => $k, 'is_color' => ($k > 20 ? 1 : 0)];
            } elseif ($v['sum_limit'] == '极小' && (!isset($res['small_limit']) || $res['small_limit'] == '--')) {
                $res['small_limit'] = ['num' => $k, 'is_color' => ($k > 20 ? 1 : 0)];
            }

            for ($i=0; $i < 28; $i++) { 
                if ($v['number_sum'] == $i && (!isset($res['c'. $i]) || $res['c'. $i] == '--')) {
                    $res['c'. $i] = ['num' => $k, 'is_color' => CustomHelper::getWkLimit($i, $k)];
                }
            }
        }

        return $res;
    }
}