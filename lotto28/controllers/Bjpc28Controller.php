<?php

namespace lotto28\controllers;

use Yii;
use common\components\helpers\CustomHelper;
use common\models\NotOpen;
use common\models\Dewdrop;
use common\models\ResultPC;

/**
 * 北京PC28
 */
class Bjpc28Controller extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\ResultPC';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        // $lottery_id = $request->get('lottery_id', 1);
        $num = $request->get('num', 15);
        $not_open_num = $request->get('not_open_num', 50);
        $redis = Yii::$app->redis;
        // if ($lottery_id == ResultPC::LOTTERYID) {
            // 开奖结果
            // $latest = $redis->zrevrange('res'. ResultPC::LOTTERYID, 0, 0);
            if (!($res = $redis->zrevrange('res'. ResultPC::LOTTERYID, 0, $num))) {
                $res = ResultPC::find()->orderBy(ResultPC::IDNAME .' desc')->limit($num)->asArray()->all();
                $latest = current($res);
                foreach ($res as $k => $v) {
                    $redis->zadd('res'. ResultPC::LOTTERYID, $v[ResultPC::IDNAME], json_encode($v));
                }
            } else {
                foreach ($res as $k => &$v) {
                    $v['data'] = json_decode($v['data'], true);
                }
                reset($res); // 重置数组指针，有没有必要呢
                $latest = current($res);
            }
            $latest_key = 'latest'. ResultPC::LOTTERYID;
            if (!$redis->exists($latest_key) || $redis->get($latest_key) != $latest[ResultPC::IDNAME]) {
                // 加入新奖期开奖结果
                $redis->zadd('res'. ResultPC::LOTTERYID, $latest[ResultPC::IDNAME], json_encode($latest));
                $redis->zremrangebyrank('res'. ResultPC::LOTTERYID, 0, 0); // redis移除最早一期数据
                // 加入新奖期未开统计
                $not_open_data = NotOpen::findAll(['lottery_id' => ResultPC::LOTTERYID]);
                foreach ($not_open_data as $k => $v) {
                    if ($v) {
                        $not_open_hdl = CustomHelper::pc28NotOpenSingleHdl($latest, json_decode($v->data, true), $v->issue_num);
                        $v->data = json_encode($not_open_hdl);
                        $v->save(false);
                    }
                }
                // 加入新奖期露珠走势
                $today = date('Y-m-d');
                $dewdrop_data = Dewdrop::findOne(['lottery_id' => ResultPC::LOTTERYID, 'belong_date' => $today]);
                if ($dewdrop_data) {
                    $dt = json_decode($dewdrop_data->data, true);
                    $dt_hdl = [
                        'daxiao' => CustomHelper::addDewdrop($dt['daxiao'], $latest['sum_big']),
                        'danshuang' => CustomHelper::addDewdrop($dt['danshuang'], $latest['sum_even']),
                    ];
                    $dewdrop_data->data = json_encode($dt_hdl);
                    $dewdrop_data->save(false);
                } else {
                    $data = ResultPC::find()->where(['between', 'add_time', strtotime($today), strtotime($today .' 23:59:59')])->orderBy(ResultPC::IDNAME .' asc')->asArray()->all();
                    $dt = ['daxiao' => [], 'danshuang' => []];
                    foreach ($data as $k => $v) {
                        $dt['daxiao'][$k] = $v['sum_big'];
                        $dt['danshuang'][$k] = $v['sum_even'];
                    }
                    $model = new Dewdrop();
                    $model->lottery_id = ResultPC::LOTTERYID;
                    $model->belong_date = $today;
                    $model->data = json_encode([
                        'daxiao' => CustomHelper::dewdropHandle($dt['daxiao']),
                        'danshuang' => CustomHelper::dewdropHandle($dt['danshuang']),
                    ]);
                    $model->save(false);
                }
                // 设置redis key为最新奖期
                $redis->set($latest_key, $latest[ResultPC::IDNAME]);
            }
            // 未开统计
            $not_open = NotOpen::findOne(['lottery_id' => ResultPC::LOTTERYID, 'issue_num' => $not_open_num]);
            $not_open = $not_open ? json_decode($not_open->data, true) : [];
            // 露珠走势
            $dewdrop = Dewdrop::findOne(['lottery_id' => ResultPC::LOTTERYID, 'belong_date' => date('Y-m-d')]);
            $dewdrop = $dewdrop ? json_decode($dewdrop->data, true) : [];
            $count_down = CustomHelper::getCountdown(ResultPC::LOTTERYID, $latest['add_time']);
        /*} else {
            return ['errno' => 1, 'errstr' => '找不到相关彩种'];
        }*/
        return ['latest' => $latest, 'count_down' => $count_down, 'res' => $res, 'statistics', 'not_open' => $not_open, 'dewdrop' => $dewdrop, 'trend'];
    }

    public function actionLoad($issue_id = '', $limit = 15)
    {
        if (!$issue_id) return [];
        if (!is_numeric($limit) || $limit <= 0 || $limit > 100) $limit = 15;
        $data = ResultPC::find()->where(['<', ResultPC::IDNAME, $issue_id])->orderBy(ResultPC::IDNAME .' desc')->limit($limit)->asArray()->all();
        return $data;
    }
}