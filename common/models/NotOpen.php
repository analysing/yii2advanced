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

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $now = time();
        if ($insert) {
            $this->created = $now;
        }
        $this->updated = $now;
        return true;
    }
}