<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/22
 * Time: 下午5:26
 */

namespace api_biz\versions\v1\controllers;


use api_biz\components\ApiController;
use Yii;

class AccountController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'] = ['find'];
        $behaviors['access']['rules'] = [
            [
                'actions' => ['find'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }

    public function actionFind(){
        $id = Yii::$app->request->get('id');

        $channel = Yii::$app->user->identity;

        $data = [
            "channel" => $channel,
            "id" => $id,
        ];

        return $this->renderJsonSuccess($data);
    }
}