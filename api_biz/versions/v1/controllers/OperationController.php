<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/23
 * Time: 上午11:00
 */

namespace api_biz\versions\v1\controllers;


use api_biz\components\ApiController;

class OperationController extends ApiController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'] = ['query', 'charge', 'withdraw', 'refund', 'transfer', 'allowance'];
        $behaviors['access']['rules'] = [
            [
                'actions' => ['query', 'charge', 'withdraw', 'refund', 'transfer', 'allowance'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }

    public function actionQuery()
    {
        return $this->renderJsonSuccess();
    }

    public function actionCharge()
    {
        return $this->renderJsonSuccess();
    }

    public function actionWithdraw()
    {
        return $this->renderJsonSuccess();
    }

    public function actionRefund()
    {
        return $this->renderJsonSuccess();
    }

    public function actionTransfer()
    {
        return $this->renderJsonSuccess();
    }

    public function actionAllowance()
    {
        return $this->renderJsonSuccess();
    }
}