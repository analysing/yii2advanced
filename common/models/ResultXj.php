<?php

namespace common\models;

/**
 * 新疆时时彩
 */
class ResultXj extends \yii\db\ActiveRecord
{
    const IDNAME = 'periodnumber';
    const LOTTERYID = 4;

    public static function tableName()
    {
        return '{{%result_xj_10}}';
    }
}