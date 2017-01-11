<?php


abstract class Request
{
    private $code;
    private $date;

    /**
     * @param $param array
     */
    public abstract function setParam($param);

    public abstract function checkParam();

    public abstract function getMethodName();

    public abstract function getParam();

    public abstract function getPost();

    public function response($response)
    {
        if (isset($response->code)) {
            $this->code = $response->code;
        }
        if (isset($response->data)) {
            $this->date = $response->data;
        }
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->date;
    }
}