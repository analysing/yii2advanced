<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property string $title 标题
 * @property string $content 内容
 * @property string $tags 标签
 * @property int $status 状态
 * @property int $created 创建时间
 * @property int $creater 创建人
 * @property int $updated 更新时间
 * @property int $updater 更新人
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'tags', 'created', 'creater'], 'required'],
            [['content'], 'string'],
            [['status', 'created', 'creater', 'updated', 'updater'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'content' => Yii::t('app', '内容'),
            'tags' => Yii::t('app', '标签'),
            'status' => Yii::t('app', '状态'),
            'created' => Yii::t('app', '创建时间'),
            'creater' => Yii::t('app', '创建人'),
            'updated' => Yii::t('app', '更新时间'),
            'updater' => Yii::t('app', '更新人'),
        ];
    }
}
