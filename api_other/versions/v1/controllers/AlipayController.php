<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/28
 * Time: 下午6:54
 */

namespace api_other\versions\v1\controllers;


use api_other\components\ApiController;
use common\models\Alipay;

class AlipayController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actionTradeStatus(){
        $out_trade_no = isset($_POST['out_trade_no'])?$_POST['out_trade_no']:null;
        $out_biz_no = isset($_POST['out_biz_no'])?$_POST['out_biz_no']:null;

        if($out_trade_no){
            $alipay = Alipay::findByOutTradeNo($out_trade_no);
            if($alipay){
                $alipay->query();
            }
        }

        echo "success";
    }
}