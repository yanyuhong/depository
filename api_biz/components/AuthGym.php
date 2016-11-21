<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/30/15
 * Time: 12:48 PM
 */

namespace api_biz\components;

use common\models\User;
use yii\base\Behavior;

use Yii;
use yii\web\HttpException;

class AuthGym extends Behavior
{

    public function init()
    {
        \Yii::$app->state = $this->authLogin();
    }

    private function authLogin()
    {
        if(Yii::$app->user->identity && Yii::$app->user->identity->user_type == User::USER_TYPE_BIZ) {

            $gym = isset(Yii::$app->params['gym']) ? Yii::$app->params['gym'] : null;

            if ($gym == null) {
                throw new HttpException("200", '分店操作失败', "40002");
            }
        }
    }
}