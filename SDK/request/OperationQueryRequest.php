<?php


class OperationQueryRequest extends Request
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
        return "operation/query/";
    }

    public function getParam()
    {
        return "num=$this->num";
    }

    public function getPost()
    {
        return [];
    }

}