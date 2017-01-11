<?php


class AccountSelectRequest extends Request
{
    private $account;

    /**
     * @param $param array
     */
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
        return "account/select/";
    }

    public function getParam()
    {
        return "account=$this->account";
    }

    public function getPost()
    {
        return [];
    }
}