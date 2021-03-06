<?php

namespace api\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
* 北京PC28
*/
class ResultPC extends \yii\db\ActiveRecord
{
    public $redisKey = 'bj_pc28';
    public $redisLatestKey = 'bj_pc28_latest';
    private $_issueCol = 'nu_id';

    public static function tableName()
    {
        return '{{%result_pc}}';
    }

    // 获取数据
    public function getItems($limit = 0)
    {
        $limit == 0 && $limit = Yii::$app->params['pageSize'];
        $query = static::find()->orderBy('nu_id desc')->limit($limit)->asArray()->all();

        /*$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'], // 默认取20条
            ],
            'sort' => [
                'defaultOrder' => [
                    'nu_id' => SORT_DESC,
                ],
            ],
        ]);*/

        // 打印sql
        // echo $query->createCommand()->getRawSql();
        // echo $query->createCommand()->sql;
        // return $dataProvider;
        return $query;
    }

    /**
     * 根据奖期获取信息
     * @param  string $issue 奖期
     * @return array
     */
    public function getItemByIssue($issue)
    {
        $info = static::findOne([$this->_issueCol => $issue]);
        return $info;
    }

    // 从redis获取数据
    public function getItemsViaRedis()
    {
        $redis = Yii::$app->redis;
        $data = $redis->hvals($this->redisKey);
        $res = [];
        foreach ($data as $k => $v) {
            $info = json_decode($v, true);
            $res[$info[$this->_issueCol]] = $info;
        }
        return $res;
    }

    /**
     * 获取单个奖期信息
     * @param  string $issue 奖期
     * @return array
     */
    public function getItemByIssueViaRedis($issue)
    {
        $info = Yii::$app->redis->hget($this->redisKey, $this->_issueCol);
        $info = json_decode($info, true);
        return $info;
    }

    /**
     * 将数据写入redis，单行
     * @todo 加入防重复数据
     * @param array $data 要放入redis的数据
     * @return boolean
     */
    public function addItemToRedis($data)
    {
        if (!$data || !is_array($data)) {
            return false;
        }
        $redis = Yii::$app->redis;
        if (!in_array($data[$this->_issueCol], $this->getRedisIssues())) {
            $redis->hset($this->redisKey, $data[$this->_issueCol], json_encode($data));
        }
        return true;
    }

    /**
     * 将数据写入redis，多行
     * @todo 加入防重复数据
     * @param array $data 要放入redis的数据
     * @return boolean
     */
    public function addItemsToRedis($data)
    {
        if (!$data || !is_array($data)) {
            return false;
        }
        $redis = Yii::$app->redis;
        // $data = array_reverse($data); // 翻转数据
        $issues = $this->getRedisIssues();
        foreach ($data as $k => $v) {
            if (!in_array($v[$this->_issueCol], $issues)) {
                $redis->hset($this->redisKey, $v[$this->_issueCol], json_encode($v));
            }
        }
        return true;
    }

    /**
     * 获取redis所有奖期
     * @return array
     */
    public function getRedisIssues()
    {
        $data = Yii::$app->redis->hkeys($this->redisKey);
        return $data;
    }

    public function addLatestToRedis($issue)
    {
        return Yii::$app->redis->hset($this->redisLatestKey, $issue, 0);
    }

    public function getRedisLatest()
    {
        $data = Yii::$app->redis->hkeys($this->redisLatestKey);
        return $data;
    }
}