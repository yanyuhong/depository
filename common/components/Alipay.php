<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/23
 * Time: 下午6:50
 */
namespace common\components;

include_once "SDK_ALIPAY/AopSdk.php";

class Alipay
{
    /**
     * @var \AopClient
     */
    public $aop;

    /**
     * Alipay constructor.
     * @param $channel \common\models\Channel
     */
    public function __construct($channel)
    {
        $this->aop = new \AopClient();
        $this->aop->appId = $channel->channel_alipay_appId;
        $this->aop->rsaPrivateKey = $channel->channel_alipay_rsaPrivateKey;
        $this->aop->alipayrsaPublicKey = $channel->channel_alipay_rsaPublicKey;
        $this->aop->alipayPublicKey = $channel->channel_alipay_publicKey;
    }

    /**
     * @param $model \common\models\Alipay
     * @return string
     */
    public function getOrderString($model)
    {

        $request = new \AlipayTradeAppPayRequest();

        $biz_content = [
            "body" => (string)$model->alipay_body,
            "subject" => (string)$model->alipay_subject,
            "out_trade_no" => (string)$model->alipay_out_trade_no,
            "timeout_express" => (string)$model->alipay_timeout_express,
            "total_amount" => (string)$model->alipay_total_amount,
            "produce_code" => "QUICK_MSECURITY_PAY",
            "goods_type" => (string)$model->alipay_goods_type,

        ];
        $request->setBizContent(json_encode($biz_content));
        $request->setNotifyUrl("");
        $orderString = $this->aop->sdkExecute($request);
        return $orderString;
    }

}