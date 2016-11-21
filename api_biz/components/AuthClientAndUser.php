<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/30/15
 * Time: 12:48 PM
 */

namespace api_biz\components;

use common\models\Gym;
use common\models\User;
use yii\base\Behavior;

use Yii;
use yii\web\HttpException;

class AuthClientAndUser extends Behavior
{

    public function init()
    {
        \Yii::$app->state = $this->authLogin();
    }

    private function authLogin()
    {
        $appId = \Yii::$app->request->getHeaders()['appId'];
        $token = \Yii::$app->request->getHeaders()['token'];
        $gym = \Yii::$app->request->getHeaders()['gym'];

        if ($appId == null) {
            $appId = \Yii::$app->request->get('appId');
            $token = \Yii::$app->request->get('token');
            $gym = \Yii::$app->request->get('gym');
            if ($appId == null) {
                throw new HttpException("401", 'This app is not allowed to use', "401");
            }
        }

        if ($token !== null) {
            \Yii::$app->user->loginByAccessToken($token);
            if (Yii::$app->user->identity) {
                if (Yii::$app->user->identity->user_type == User::USER_TYPE_BIZ) {
                    Yii::$app->params['gym'] = Gym::findByHashId($gym);
                    if (!Yii::$app->params['gym'] || Yii::$app->params['gym']->gymBiz->biz_user_id != Yii::$app->user->identity->user_id) {
                        Yii::$app->params['gym'] = null;
                    }
                } elseif (Yii::$app->user->identity->user_type == User::USER_TYPE_GYM) {
                    Yii::$app->params['gym'] = Yii::$app->user->identity->gym;
                }
            }
        }
    }
}