<?php


class AccountCardBindRequest extends Request
{
    private $account;
    private $card;
    private $name;
    private $bank;

    public function setParam($param)
    {
        if (isset($param['account'])) {
            $this->account = $param['account'];
        }
        if (isset($param['card'])) {
            $this->card = $param['card'];
        }
        if (isset($param['name'])) {
            $this->name = $param['name'];
        }
        if (isset($param['bank'])) {
            $this->bank = $param['bank'];
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
        return "account/card-bind/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return [
            "account" => $this->account,
            "card" => $this->card,
            "name" => $this->name,
            "bank" => $this->bank,
        ];
    }
}