<?php

namespace common\models;

/**
 * 重庆时时彩
 */
class ResultCq extends \yii\db\ActiveRecord
{
    const IDNAME = 'periodnumber';
    const LOTTERYID = 3;

    public static function tableName()
    {
        return '{{%result_cq_10}}';
    }
}