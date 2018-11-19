<?php

namespace common\models;

/**
* 未开统计
*/
class NotOpen extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%not_open}}';
    }
}