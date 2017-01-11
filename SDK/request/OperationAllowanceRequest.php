<?php


class OperationAllowanceRequest extends Request
{
    private $num;
    private $account;
    private $amount;

    public function setParam($param)
    {
        if (isset($param['num'])) {
            $this->num = $param['num'];
        }
        if (isset($param['account'])) {
            $this->account = $param['account'];
        }
        if (isset($param['amount'])) {
            $this->amount = $param['amount'];
        }
    }

    public function checkParam()
    {
        if (!$this->num || !$this->account || !$this->amount) {
            return false;
        }

        return true;
    }

    public function getMethodName()
    {
        return "operation/allowance/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return [
            'num' => $this->num,
            'account' => $this->account,
            'amount' => $this->amount,
        ];
    }
}