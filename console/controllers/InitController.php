<?php

namespace lotto28\console\controllers;

use common\models\NotOpen;
use common\models\ResultPC;

/**
* 初始化数据
*/
class InitController extends \yii\console\Controller
{
    public $lottery = 1; // 1北京PC28,2加拿大PC28,3重庆时时彩,4新疆时时彩,5香港六合彩

    public function options($actionID)
    {
        return ['lottery'];
    }

    public function optionAliases()
    {
        return ['l' => 'lottery'];
    }
    
    public function actionNotOpen($num = 50)
    {
        if (!($model = NotOpen::findOne(['lottery_id' => $this->lottery, 'issue_num' => $num]))) {
            $model = new NotOpen();
        }
        $res = ['big' => '--', 'small' => '--', 'even' => '--', 'odd' => '--', 'small_even' => '--', 'small_odd' => '--', 'big_even' => '--', 'big_odd' => '--', 'small_limit' => '--', 'big_limit' => '--'];
        for ($i=0; $i < 28; $i++) { 
            $res['c'. $i] = '--';
        }
        if ($this->lottery == 1) {
            $data = ResultPC::find()->orderBy(ResultPC::$idKey .' desc')->limit($num)->asArray()->all();
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
        }
    }
}