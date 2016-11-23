<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/23
 * Time: 上午11:00
 */

namespace api_biz\versions\v1\controllers;


use api_biz\components\ApiController;
use api_biz\models\OperationForm;

use Yii;

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
        $operationForm = new OperationForm();
        $operationForm->load(['OperationForm' => Yii::$app->request->get()]);

        if (!$operationForm->validate($operationForm->operationQueryRules())) {
            return $this->renderJsonFailed('40001', $operationForm->getErrors());
        }

        $operationForm = $operationForm->searchByNum();

        if(!$operationForm){
            return $this->renderJsonFailed('43001');
        }

        $data = $operationForm->queryFields();

        return $this->renderJsonSuccess($data);
    }

    public function actionCharge()
    {
        $operationForm = new OperationForm();
        $operationForm->load(['OperationForm' => Yii::$app->request->post()]);

        if (!$operationForm->validate($operationForm->operationChargeRules())) {
            return $this->renderJsonFailed('40001', $operationForm->getErrors());
        }

        if($operationForm->operationModel){
            return $this->renderJsonFailed('40002');
        }

        if(!$operationForm->accountModel){
            return $this->renderJsonFailed('40003');
        }

        $operationForm->doCharge();
        $data = $operationForm->chargeFields();

        return $this->renderJsonSuccess($data);
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