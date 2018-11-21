<?php

namespace common\models;

/**
 * 香港六合彩
 */
class Re11Six extends \yii\db\ActiveRecord
{
    const IDNAME = 'periodnumber';
    const LOTTERYID = 5;

    public static function tableName()
    {
        return '{{%re11_six}}';
    }
}