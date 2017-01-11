<?php


class OperationTransferRequest extends Request
{
    private $num;
    private $accountOut;
    private $accountInto;
    private $amount;

    public function setParam($param)
    {
        if (isset($param['num'])) {
            $this->num = $param['num'];
        }
        if (isset($param['accountOut'])) {
            $this->accountOut = $param['accountOut'];
        }
        if (isset($param['accountInto'])) {
            $this->accountInto = $param['accountInto'];
        }
        if (isset($param['amount'])) {
            $this->amount = $param['amount'];
        }
    }

    public function checkParam()
    {
        if (!$this->num || !$this->accountOut || !$this->accountInto || !$this->amount) {
            return false;
        }

        return true;
    }

    public function getMethodName()
    {
        return "operation/transfer/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return [
            'num' => $this->num,
            'accountOut' => $this->accountOut,
            'accountInto' => $this->accountInto,
            'amount' => $this->amount,
        ];
    }
}