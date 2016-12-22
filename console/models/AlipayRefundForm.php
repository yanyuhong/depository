<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/12/22
 * Time: 下午1:07
 */

namespace console\models;


use common\models\AlipayRefund;

class AlipayRefundForm extends AlipayRefund
{
    //======
    //model function
    public function refresh()
    {
        $alipayRefund = $this->getModel();
        $new = $alipayRefund ? new self($alipayRefund) : null;
        if ($new) {
            $new->load(['AlipayRefundForm' => (array)$this]);
        }
        return $new;
    }

    //======
    //search


    //=======
    //private
    private function getModel()
    {
        return AlipayRefund::findOne($this->alipay_refund_id);
    }
}