<?php
namespace boss\models;

use common\models\Manage;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_manage = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'trim'],
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $manage = $this->getUser();
            if (!$manage || !$manage->validatePassword($this->password)) {
                $this->addError($attribute, '帐号或密码错误');
            } elseif ($manage->status == 2) {
                $this->addError($attribute, '帐号冻结,请联系管理员');
            } elseif ($manage->status == 3) {
                $this->addError($attribute, '帐号已经关闭');
            } elseif ($manage->status != 1) {
                $this->addError($attribute, '帐号异常,请联系管理员');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Manage|null
     */
    public function getUser()
    {
        if ($this->_manage === false) {
            $this->_manage = Manage::findByEmail($this->email);
        }
        return $this->_manage;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => '邮箱',
            'password' => '密码',
            'rememberMe' => '记住密码',
        ];
    }
}
