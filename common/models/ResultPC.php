<?php

namespace common/models;

/**
 * 北京PC28
 */
class ResultPC extends \yii\db\ActiveRecord
{
    public static $idKey = 'nu_id';

    public static function tableName()
    {
        return '{{%result_pc}}';
    }
}