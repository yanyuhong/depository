<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/30/15
 * Time: 12:48 PM
 */

namespace api_biz\components;

use yii\base\Behavior;

use Yii;

class AuthClientAndUser extends Behavior
{

    public function init()
    {
        \Yii::$app->state = $this->authLogin();
    }

    /**
     * 使用渠道号和密钥登录
     */
    private function authLogin(){

        $appId = \Yii::$app->request->getHeaders()['appId'];
        $secret = \Yii::$app->request->getHeaders()['secret'];

        if ($appId !== null && $secret != null) {
            \Yii::$app->user->loginByAccessToken($appId . ' ' . $secret);
        }
    }
}