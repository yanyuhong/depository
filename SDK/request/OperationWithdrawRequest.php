<?php


class OperationWithdrawRequest extends Request
{
    private $num;
    private $account;
    private $amount;
    private $card;

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
        if (isset($param['card'])) {
            $this->card = $param['card'];
        }
    }

    public function checkParam()
    {
        if (!$this->account) {
            return false;
        }

        return true;
    }

    public function getMethodName()
    {
        return "operation/withdraw/";
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
            'card' => $this->card,
        ];
    }
}