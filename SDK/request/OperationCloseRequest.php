<?php


class OperationCloseRequest extends Request
{
    private $num;


    public function setParam($param)
    {
        if (isset($param['num'])) {
            $this->num = $param['num'];
        }
    }

    public function checkParam()
    {
        if (!$this->num) {
            return false;
        }

        return true;
    }

    public function getMethodName()
    {
        return "operation/close/";
    }

    public function getParam()
    {
        return "";
    }

    public function getPost()
    {
        return [
            "num" => $this->num
        ];
    }

}