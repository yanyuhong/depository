<?php


class OperationRefundRequest extends Request
{
    private $num;
    private $charge;
    private $amount;

    public function setParam($param)
    {
        if (isset($param['num'])) {
            $this->num = $param['num'];
        }
        if (isset($param['charge'])) {
            $this->charge = $param['charge'];
        }
        if (isset($param['amount'])) {
            $this->amount = $param['amount'];
        }
    }

    public function checkParam()
    {
        if (!$this->num || !$this->charge || !$this->amount) {
            return false;
        }

        return true;
    }

    public function getMethodName()
    {
        return "operation/refund/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return [
            'num' => $this->num,
            'charge' => $this->charge,
            'amount' => $this->amount,
        ];
    }
}