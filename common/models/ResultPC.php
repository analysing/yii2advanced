<?php

namespace common\models;

/**
 * 北京PC28
 */
class ResultPC extends \yii\db\ActiveRecord
{
    const IDNAME = 'nu_id';
    const BJPC28 = 1; // lottery_id

    public static function tableName()
    {
        return '{{%result_pc}}';
    }
}