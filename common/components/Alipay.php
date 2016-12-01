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
    }

    /**
     * @param $model \common\models\Alipay
     * @return string
     */
    public function getOrderString($model)
    {
        $biz_content = [
            "body" => (string)$model->alipay_body,
            "subject" => (string)$model->alipay_subject,
            "out_trade_no" => (string)$model->alipay_out_trade_no,
            "timeout_express" => (string)$model->alipay_timeout_express,
            "total_amount" => (string)$model->alipay_total_amount,
            "produce_code" => "QUICK_MSECURITY_PAY",
            "goods_type" => (string)$model->alipay_goods_type,
        ];

        $request = new \AlipayTradeAppPayRequest();
        $request->setBizContent(json_encode($biz_content));
        if (isset(\Yii::$app->params['url']['api_other']) && \Yii::$app->params['url']['api_other']) {
            $request->setNotifyUrl(\Yii::$app->params['url']['api_other'] . '/v1/alipay/trade-status');
        }
        $orderString = $this->aop->sdkExecute($request);
        return $orderString;
    }

    /**
     * @param $model \common\models\Alipay
     */
    public function queryTrade($model)
    {
        $request = new \AlipayTradeQueryRequest();

        $biz_content = [
            "out_trade_no" => (string)$model->alipay_out_trade_no,
        ];

        $request->setBizContent(json_encode($biz_content));

        $response = $this->aop->execute($request);

        $response = isset($response->alipay_trade_query_response) ? $response->alipay_trade_query_response : null;

        if ($response && isset($response->code)) {
            $model->updateStatus($response);
        }
    }

    /**
     * @param $model \common\models\Alipay
     */
    public function close($model)
    {
        $request = new \AlipayTradeCloseRequest();

        $biz_content = [
            "out_trade_no" => (string)$model->alipay_out_trade_no,
        ];

        $request->setBizContent(json_encode($biz_content));

        $response = $this->aop->execute($request);

        $response = isset($response->alipay_trade_close_response) ? $response->alipay_trade_close_response : null;

        if ($response && isset($response->code)) {
            return $response;
        }

        return false;
    }

}