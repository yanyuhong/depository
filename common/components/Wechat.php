<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/11/29
 * Time: 下午2:22
 */

namespace common\components;

use common\models\WechatRefund;

include_once "SDK_WECHAT/lib/WxPay.Api.php";

class Wechat
{
    /**
     * @var \WxPayConfig
     */
    public $config;

    /**
     * @var \WxPayApi
     */
    public $api;

    /**
     * Wechat constructor.
     * @param $channel \common\models\Channel
     */
    public function __construct($channel)
    {
        $this->config = new \WxPayConfig();
        $this->config->APPID = $channel->channel_wechat_appid;
        $this->config->MCHID = $channel->channel_wechat_mchid;
        $this->config->KEY = $channel->channel_wechat_key;
        $this->config->SSLCERT = $channel->channel_wechat_sslcert;
        $this->config->SSLKEY = $channel->channel_wechat_sslkey;

        $this->api = new \WxPayApi($this->config);

    }

    /**
     * @param $wechat \common\models\Wechat
     * @return bool
     */
    public function getOrderMap($wechat)
    {
        $input = new \WxPayUnifiedOrder($this->config);
        $input->SetBody($wechat->wechat_body);
        $input->SetDetail($wechat->wechat_detail);
        $input->SetOut_trade_no($wechat->wechat_out_trade_no);
        $input->SetTotal_fee($wechat->wechat_total_fee);
        $input->SetSpbill_create_ip($wechat->wechat_spbill_create_ip);
        $input->SetTime_start($wechat->wechat_time_start);
        $input->SetTime_expire($wechat->wechat_time_expire);
        $input->SetTrade_type($wechat->wechat_trade_type);

        if (isset(\Yii::$app->params['url']['api_other']) && \Yii::$app->params['url']['api_other']) {
            $input->SetNotify_url(\Yii::$app->params['url']['api_other'] . '/v1/wechat/trade-status');
        }

        $result = $this->api->unifiedOrder($input);

        if (!isset($result['prepay_id']) || !$result['prepay_id']) {
            return false;
        }

        $input = new \WxPayAppPay($input->config);
        $input->SetPrepayid($result['prepay_id']);
        $input->SetPackage("Sign=WXPay");

        $result = $this->api->appPay($input);

        return $result;
    }

    /**
     * @param $wechat \common\models\Wechat
     */
    public function queryTrade($wechat)
    {
        $input = new \WxPayOrderQuery($this->config);
        $input->SetOut_trade_no($wechat->wechat_out_trade_no);

        $result = $this->api->orderQuery($input);

        if (isset($result['return_code']) && $result['return_code'] == "SUCCESS" && isset($result['result_code']) && $result['result_code'] == "SUCCESS") {
            $wechat->updateStatus($result);
        }
    }

    /**
     * @param $wechat \common\models\Wechat
     */
    public function close($wechat){
        $input = new \WxPayCloseOrder($this->config);
        $input->SetOut_trade_no($wechat->wechat_out_trade_no);

        $result = $this->api->closeOrder($input);

        if (isset($result['return_code']) && $result['return_code'] == "SUCCESS" && isset($result['result_code']) && $result['result_code'] == "SUCCESS") {
            $this->queryTrade($wechat);
            return true;
        }

        return false;
    }

    /**
     * @param $model WechatRefund
     */
    public function refund($model){
        $input = new \WxPayRefund($this->config);
        $input->SetOut_trade_no($model->wechatRefundWechat->wechat_out_trade_no);
        $input->SetOut_refund_no($model->wechat_refund_out_refund_no);
        $input->SetTotal_fee($model->wechatRefundWechat->wechat_total_fee);
        $input->SetRefund_fee($model->wechat_refund_refund_fee);
        $input->SetOp_user_id($model->wechatRefundRefund->refundOperation->operationChannel->channel_wechat_mchid);

        $result = $this->api->refund($input);

        if (isset($result['return_code']) && $result['return_code'] == "SUCCESS") {
            return $result;
        }

        return false;
    }

    /**
     * @param $model WechatRefund
     */
    public function refundQuery($model){
        $input = new \WxPayRefundQuery($this->config);
        $input->SetOut_refund_no($model->wechat_refund_out_refund_no);

        $result = $this->api->refundQuery($input);

        if (isset($result['return_code']) && $result['return_code'] == "SUCCESS" && isset($result['result_code']) && $result['result_code'] == "SUCCESS") {
            $model->updateStatus($result);
            return true;
        }

        return false;
    }
}