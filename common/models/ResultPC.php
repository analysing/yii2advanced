<?php

namespace common\models;

/**
 * 北京PC28
 */
class ResultPC extends \yii\db\ActiveRecord
{
    const IDNAME = 'nu_id';
    const LOTTERYID = 1;

    public static function tableName()
    {
        return '{{%result_pc}}';
    }
}