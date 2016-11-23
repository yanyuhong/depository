<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/22
 * Time: 下午5:26
 */

namespace api_biz\versions\v1\controllers;


use api_biz\components\ApiController;
use api_biz\models\AccountForm;
use Yii;

class AccountController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['only'] = ['select', 'create', 'card-bind'];
        $behaviors['access']['rules'] = [
            [
                'actions' => ['select', 'create', 'card-bind'],
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
        return $behaviors;
    }

    public function actionSelect()
    {

        $accountForm = new AccountForm();
        $accountForm->load(['AccountForm' => Yii::$app->request->get()]);

        if (!$accountForm->validate($accountForm->accountCreateRules())) {
            return $this->renderJsonFailed('40001', $accountForm->getErrors());
        }

        $orderList = array();
        $search_query = $accountForm->searchByKey();


        return $this->renderJsonSuccess($orderList);

    }

    public function actionCreate()
    {
        $accountForm = new AccountForm();
        $accountForm->load(['AccountForm' => Yii::$app->request->post()]);

        if (!$accountForm->validate($accountForm->accountCreateRules())) {
            return $this->renderJsonFailed('40001', $accountForm->getErrors());
        }

        if (!$accountForm->addAccount()) {
            return $this->renderJsonFailed('42001', $accountForm->getErrors());
        }
        return $this->renderJsonSuccess();
    }

    public function actionCardBind()
    {
        return $this->renderJsonSuccess("绑定银行卡");
    }
}