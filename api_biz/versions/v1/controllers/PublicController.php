<?php
/**
 * Created by PhpStorm.
 * User: zhangzhen
 * Date: 2016/11/23
 * Time: 上午11:02
 */

namespace api_biz\versions\v1\controllers;


use api_biz\components\ApiController;

class PublicController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'] = ['banks', 'payments'];
        $behaviors['access']['rules'] = [
            [
                'actions' => ['banks', 'payments'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }

    public function actionBanks()
    {
        return $this->renderJsonSuccess();
    }

    public function actionPayments()
    {
        return $this->renderJsonSuccess();
    }

}

