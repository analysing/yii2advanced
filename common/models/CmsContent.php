<?php

namespace common\models;

/**
 * CMS
 */
class CmsContent extends \yii\db\ActiveRecord
{
    const IDNAME = 'id';
    const CMSTYPE = [
        1 => '购彩策略',
        2 => '预测咨询',
        3 => '最新新闻',
        4 => '奇闻怪谈',
        5 => '最新公告',
        6 => '人气排行',
        7 => '幸运28技巧',
        8 => '帮助中心',
    ];
    
    public static function tableName()
    {
        return '{{%cms_content}}';
    }
}