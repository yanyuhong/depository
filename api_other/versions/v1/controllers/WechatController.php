<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/28
 * Time: 下午6:54
 */

namespace api_other\versions\v1\controllers;


use api_other\components\ApiController;
use common\models\Wechat;

class WechatController extends ApiController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actionTradeStatus()
    {
        $xml = file_get_contents("php://input");
        $result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $out_trade_no = isset($result['out_trade_no']) ? $result['out_trade_no'] : null;

        if ($out_trade_no) {
            $wechat = Wechat::findByOutTradeNo($out_trade_no);
            if ($wechat) {
                $wechat->query();
            }
        }

        $reply = "<xml>
  <return_code><![CDATA[SUCCESS]]></return_code>
  <return_msg><![CDATA[OK]]></return_msg>
</xml>";
        echo $reply;
    }
}