<?php

namespace common\models;

/**
 * 露珠走势
 */
class Dewdrop extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%dewdrop}}';
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $now = time();
        if ($insert) {
            if (isset($this->created)) $this->created = $now; // 更新创建时间
        }
        if (isset($this->updated)) $this->updated = $now; // 更新修改时间
        return true;
    }
}