<?php

namespace api\controllers;

use yii\rest\Controller;

/**
* 彩种
*/
class LotteryController extends Controller
{
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    // 返回彩种信息
    public function actionIndex()
    {
        $lotteries = [
            'bj_pc28' => [
                'title' => '北京PC28',
                // 'name' => 'bj_pc28',
                'icon' => '',
            ],
            'jnd_pc28' => [
                'title' => '加拿大PC28',
                // 'name' => 'jnd_pc28',
                'icon' => '',
            ],
            'cq_pc28' => [
                'title' => '重庆PC28',
                // 'name' => 'cq_pc28',
                'icon' => '',
            ],
            'xj_pc28' => [
                'title' => '新疆PC28',
                // 'name' => 'xj_pc28',
                'icon' => '',
            ],
            'lhc' => [
                'title' => '六合彩',
                // 'name' => 'lhc',
                'icon' => '',
            ],
        ];
        return $lotteries;
    }
}