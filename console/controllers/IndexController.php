<?php

namespace console\controllers;

use yii\db\Query;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * test
 */
class IndexController extends \yii\console\Controller
{
    public $name;
    public $message = [];

    /**
     * 设置选项
     * .\yii index/test --message='hello world'
     * @param  string $actionID 方法ID
     * @return array           公共属性
     */
    public function options($actionID)
    {
        return ['message', 'name'];
    }

    /**
     * 选项别名
     * .\yii index/test -msg='hello world'
     * @return array ['alias' => 'option']
     */
    public function optionAliases()
    {
        return ['n' => 'name', 'msg' => 'message'];
    }

    /**
     * 参数
     * .\yii index/say-hello 'hello bill'
     * @param  string $msg 
     * @return string
     */
    public function actionSayHello($msg = 'hello ivy')
    {
        echo $msg;
        return 1; // 退出代码
    }

    public function actionTest()
    {
        if (is_array($this->message)) { // 使用默认值类型
            print_r($this->message);
        } else echo $this->message;
        return 1;
    }

    public function actionTest1()
    {
        echo $this->name;
        return ExitCode::UNSPECIFIED_ERROR;
    }

    /**
     * 数据库操作是一样的
     * @return [type] [description]
     */
    public function actionTest2()
    {
        $rows = (new Query())->from('result_pc')->orderBy('nu_id desc')->limit(2)->all();
        $this->stdout("Hello\r\n", Console::BOLD);
        echo $this->ansiFormat('bill', Console::FG_YELLOW);
        print_r($rows);
        return ExitCode::OK;
    }
}