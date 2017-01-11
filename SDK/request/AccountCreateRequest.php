<?php


class AccountCreateRequest extends Request
{
    private $account;

    public function setParam($param)
    {
        if (isset($param['account'])) {
            $this->account = $param['account'];
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
        return "account/create/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return ["account" => $this->account];
    }
}