<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/30/15
 * Time: 12:39 PM
 */

namespace api_other\components;


use yii\rest\Controller;
use yii\filters\AccessControl;
use yii;

class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function renderJsonSuccess($obj = array())
    {
        $response = Yii::$app->response;
        $data = array();
        $data['code'] = "0";
        $data['data'] = $obj;
        $response->data = $data;
        return $response;
    }

    public function renderJsonFailed($code, $reason = null)
    {
        $response = Yii::$app->response;
        if ($code !== null && isset($this->errorMessage[$code])) {
            $data = [
                'code' => $code,
                'message' => $this->errorMessage[$code],
            ];
            if ($code == '40001' && is_array($reason)) {
                $data['message'] = $reason[array_keys($reason)[0]][0];
            }
            if ($reason != null) {
                $data['data'] = $reason;
            }
            $response->data = $data;
            return $response;
        } else {
            return $this->renderJsonFailed('40000');
        }
    }
}