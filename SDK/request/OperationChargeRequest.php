<?php


class OperationChargeRequest extends Request
{
    private $num;
    private $account;
    private $amount;
    private $payment;
    private $title;
    private $detail;
    private $goodsType;
    private $express;
    private $spbillIp;

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
        if (isset($param['payment'])) {
            $this->payment = $param['payment'];
        }
        if (isset($param['title'])) {
            $this->title = $param['title'];
        }
        if (isset($param['detail'])) {
            $this->detail = $param['detail'];
        }
        if (isset($param['goodsType'])) {
            $this->goodsType = $param['goodsType'];
        }
        if (isset($param['express'])) {
            $this->express = $param['express'];
        }
        if (isset($param['spbillIp'])) {
            $this->spbillIp = $param['spbillIp'];
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
        return "operation/charge/";
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
            'payment' => $this->payment,
            'title' => $this->title,
            'detail' => $this->detail,
            'goodsType' => $this->goodsType,
            'express' => $this->express,
            'spbillIp' => $this->spbillIp,
        ];
    }
}