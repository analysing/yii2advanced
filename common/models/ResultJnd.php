<?php

namespace common\models;

/**
 * 加拿大PC28
 */
class ResultJnd extends \yii\db\ActiveRecord
{
    const IDNAME = 'nu_id';
    const LOTTERYID = 2;

    public static function tableName()
    {
        return '{{%result_jnd}}';
    }
}