<?php

namespace lotto28\controllers;

use Yii;
use common\models\CmsContent;

/**
 * CMS
 */
class CmsController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\CmsContent';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $limit = $request->get('limit', 10);
        $type = CmsContent::CMSTYPE;
        $type_count = count($type);
        $field = 'id, cms_type_id, cms_title, addtime';
        foreach ($type as $k => $v) {
            if (!isset($query)) {
                $query = CmsContent::find()->select($field)->where(['cms_type_id' => $k])->orderBy(CmsContent::IDNAME .' desc')->limit($limit);
            } else {
                $q = CmsContent::find()->select($field)->where(['cms_type_id' => $k])->orderBy(CmsContent::IDNAME .' desc')->limit($limit);
                $query->union($q, true); // union all
            }
        }
        $data = $query->asArray()->all();
        $res = [];
        foreach ($data as $k => $v) {
            $v['cms_type'] = $type[$v['cms_type_id']];
            $v['addtime'] = date('Y-m-d', $v['addtime']);
            $res[$v['cms_type_id']][] = $v;
        }
        return $res;
    }

    public function actionType()
    {
        return CmsContent::CMSTYPE;
    }

    public function actionMore()
    {
        $request = Yii::$app->request;
        $type_id = $request->get('type', 1);
        $limit = $request->get('limit', 100);
        if (!is_numeric($type_id) || $type_id < 0) $type_id = 1;
        if (!is_numeric($limit) || $limit < 0 || $limit > 2000) $limit = 100;

        $data = CmsContent::find()->select('id, cms_type_id, cms_title, addtime')->where(['cms_type_id' => $type_id])->orderBy(CmsContent::IDNAME .' desc')->limit($limit)->asArray()->all();
        $type = CmsContent::CMSTYPE;
        $res = [];
        foreach ($data as $k => $v) {
            $res[$k] = $v;
            $res[$k]['cms_type'] = $type[$v['cms_type_id']];
            $res[$k]['addtime'] = date('Y-m-d', $v['addtime']);
        }
        return $res;
    }

    public function actionContent($id)
    {
        $res = CmsContent::findOne(['id' => $id]);
        if (!$res) {
            return [];
        }
        return $res->cms_content;
    }
}