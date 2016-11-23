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
        return $this->renderJsonSuccess("查询账户");
    }

    public function actionCreate()
    {
        return $this->renderJsonSuccess("新建账户");
    }

    public function actionCardBind()
    {
        return $this->renderJsonSuccess("绑定银行卡");
    }
}