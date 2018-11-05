<?php

namespace api\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use api\models\Member;
use yii\helpers\ArrayHelper;

/**
* 会员表
*/
class MemberController extends ActiveController
{
    public $modelClass = 'api\models\Member';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create']);
        return $actions;
    }

    public function behaviors()
    {
        /*return ArrayHelper::merge([
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Access-Control-Request-Method' => ['POST'],
                ],
            ],
        ], parent::behaviors());*/
        /*return ArrayHelper::merge([
            [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['http://www.myserver.net'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], parent::behaviors());*/
        return parent::behaviors();
    }

    public function actionIndex()
    {
        $data = \Yii::$app->request->get();
        return new ActiveDataProvider([
            'query' => Member::find(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Member();
        // $data = \Yii::$app->getRequest()->getBodyParams();
        // $data = \Yii::$app->request->bodyParams;
        // $data = \Yii::$app->request->post();
        $data = \Yii::$app->request->bodyParams;
        $model->load($data, '');
        return $model->save();
        // return $data;
    }
}