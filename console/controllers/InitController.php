<?php

namespace console\controllers;

use Yii;
use yii\console\ExitCode;
use common\models\NotOpen;
use common\models\ResultPC;
use common\components\helpers\CustomHelper;

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

    public function actionSetCache($num = 15)
    {
        if (!is_numeric($num) || $num < 0 || $num > 1000) {
            $num = 50;
        }
        $redis = Yii::$app->redis;
        if ($this->lottery == ResultPC::BJPC28) {
            $redis->del('res'. ResultPC::BJPC28); // 删除原来的数据
            $data = ResultPC::find()->orderBy(ResultPC::ID .' desc')->limit($num)->asArray()->all();
            foreach ($data as $k => $v) {
                $redis->zadd('res'. ResultPC::BJPC28, $v[ResultPC::ID], json_encode($v));
            }
        } else {
            echo '找不到相关彩种';
            return ExitCode::UNSPECIFIED_ERROR;
        }
        return ExitCode::OK;
    }
    
    public function actionNotOpen($num = 50)
    {
        if (!is_numeric($num) || $num < 0 || $num > 1000) {
            $num = 50;
        }
        if ($this->lottery == ResultPC::BJPC28) {
            $data = ResultPC::find()->orderBy(ResultPC::ID .' desc')->limit($num)->asArray()->all();
            $res = CustomHelper::pc28NotOpenHandle($data);
        } else {
            echo '找不到相关彩种';
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!($model = NotOpen::findOne(['lottery_id' => $this->lottery, 'issue_num' => $num]))) {
            $model = new NotOpen();
        }
        $model->lottery_id = $this->lottery;
        $model->issue_num = $num;
        $model->data = json_encode($res);
        if (!$model->save(false)) {
            echo 'failure';
            return ExitCode::UNSPECIFIED_ERROR;
        }
        echo 'success';
        return ExitCode::OK;
    }
}