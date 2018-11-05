<?php

namespace api\controllers;

use yii\rest\ActiveController;
use api\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'api\models\User';
    
    public function actions()
    {
        $actions = parent::actions(); // index view create update delete options
        unset($actions['create'], $actions['update']);
        return $actions;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $data['User'] = \Yii::$app->request->post(); // 要加上模型类名称（User）才能使用load方法
        $model = new User();
        /*if ($model->load($data) === false) {
            return $model->getErrors();
        }*/
        $model->load($data);
        // return $model->validate(['username', 'email', 'password']) ? true : $model->getErrors();
        $model->setPassword($model->password);
        $model->generateAuthKey();
        return $model->save() ? true : $model->getErrors();
    }

    public function actionUpdate($id)
    {
        $data['User'] = \Yii::$app->request->post();
        $model = User::findOne($id);
        $model->load($data);
        if ($model->validate(['username', 'email'])) {
            return $model->save(false, ['username', 'email']);
        }
        return $model->getErrors();
    }

}
