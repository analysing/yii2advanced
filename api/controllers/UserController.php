<?php

namespace api\controllers;

/**
 * User
 */
class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\User';
    
    public function actions()
    {
        // GET查 POST增 PUT改 PATCH改 DELETE删 OPTIONS列出可用的方法 HEAD
        // return parent::actions();
        $actions = parent::actions();
        unset($actions['create'], $actions['update']);
        return $actions;
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();
        $model = new \common\models\User();
        // $model->load($data); // 为啥用这个不行呢？
        $model->username = $data['username'];
        $model->email = $data['email'];
        $model->password = $data['password'];
        $model->setPassword($data['password']);
        $model->generateAuthKey();
        if ($model->save()) {
            return true;
        } else {
            return $model;
        }
    }

    public function actionUpdate()
    {
        return 'hahaha...';
    }


}