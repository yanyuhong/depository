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

use common\components\Alipay;
use common\models\Operation;
use Yii;

class OperationController extends ApiController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'] = ['query', 'charge', 'withdraw', 'refund', 'transfer', 'allowance', 'close'];
        $behaviors['access']['rules'] = [
            [
                'actions' => ['query', 'charge', 'withdraw', 'refund', 'transfer', 'allowance', 'close'],
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

        $operationForm->searchByNum();

        if (!$operationForm->operationModel) {
            return $this->renderJsonFailed('43001');
        }

        $operationForm->queryStatus();

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

        $operationForm->check();

        if ($operationForm->operationModel) {
            return $this->renderJsonFailed('43002');
        }

        if (!$operationForm->accountModel) {
            return $this->renderJsonFailed('43003');
        }

        if (!$operationForm->doCharge()) {
            return $this->renderJsonFailed('40000');
        }

        $data = $operationForm->chargeFields();

        return $this->renderJsonSuccess($data);
    }

    public function actionWithdraw()
    {
        return $this->renderJsonSuccess();
    }

    public function actionRefund()
    {
        $operationForm = new OperationForm();
        $operationForm->load(['OperationForm' => Yii::$app->request->post()]);

        if (!$operationForm->validate($operationForm->operationRefundRules())) {
            return $this->renderJsonFailed('40001', $operationForm->getErrors());
        }

        $operationForm->check();

        if ($operationForm->operationModel) {
            return $this->renderJsonFailed('43002');
        }

        if (!$operationForm->chargeOperationModel
            || $operationForm->chargeOperationModel->operation_type != Operation::OPERATION_TYPE_CHARGE
            || $operationForm->chargeOperationModel->operation_status != Operation::OPERATION_STATUS_SUCCESS
        ) {
            return $this->renderJsonFailed('43401');
        }

        if ($operationForm->amount > ($operationForm->chargeOperationModel->charge->chargeAccount->account_amount - $operationForm->chargeOperationModel->charge->chargeAccount->account_freeze_amount)
            || $operationForm->amount > $operationForm->chargeOperationModel->charge->charge_amount - $operationForm->chargeOperationModel->charge->getRefundAmount()
        ) {
            return $this->renderJsonFailed('43004');
        }

        $operationForm->doRefund();

        return $this->renderJsonSuccess($operationForm->ststusFields());
    }

    public function actionTransfer()
    {
        $operationForm = new OperationForm();
        $operationForm->load(['OperationForm' => Yii::$app->request->post()]);

        if (!$operationForm->validate($operationForm->operationTransferRules())) {
            return $this->renderJsonFailed('40001', $operationForm->getErrors());
        }

        $operationForm->check();

        if ($operationForm->operationModel) {
            return $this->renderJsonFailed('43002');
        }

        if (!$operationForm->accountOutModel) {
            return $this->renderJsonFailed('43003');
        }

        if (!$operationForm->accountIntoModel) {
            return $this->renderJsonFailed('43003');
        }

        if ($operationForm->amount > ($operationForm->accountOutModel->account_amount - $operationForm->accountOutModel->account_freeze_amount)) {
            return $this->renderJsonFailed('43004');
        }

        $operationForm->doTransfer();

        return $this->renderJsonSuccess($operationForm->ststusFields());
    }

    public function actionAllowance()
    {
        return $this->renderJsonSuccess();
    }

    public function actionClose()
    {
        $operationForm = new OperationForm();
        $operationForm->load(['OperationForm' => Yii::$app->request->post()]);

        if (!$operationForm->validate($operationForm->operationCloseRules())) {
            return $this->renderJsonFailed('40001', $operationForm->getErrors());
        }

        $operationForm->searchByNum();

        if (!$operationForm->operationModel) {
            return $this->renderJsonFailed('43001');
        }

        $result = $operationForm->doClose();

        if (!$result) {
            return $this->renderJsonFailed('43701');
        }

        return $this->renderJsonSuccess();
    }
}