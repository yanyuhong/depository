<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/12/22
 * Time: 下午12:07
 */

namespace console\models;


use common\models\WechatRefund;

class WechatRefundForm extends WechatRefund
{

    //======
    //model function
    public function refresh()
    {
        $wechatRefund = $this->getModel();
        $new = $wechatRefund ? new self($wechatRefund) : null;
        if ($new) {
            $new->load(['WechatRefundForm' => (array)$this]);
        }
        return $new;
    }

    //======
    //search
    public function searchByStatusRefunding()
    {
        return $this->find()
            ->where(['is', 'wechat_refund_status', null])
            ->orWhere(['wechat_refund_status' => [self::WECHAT_REFUND_STATUS_REPORT, self::WECHAT_REFUND_STATUS_PROCESSING]]);
    }

    //=======
    //private
    private function getModel()
    {
        return WechatRefund::findOne($this->wechat_refund_id);
    }
}