<?php
namespace boss\models;

use common\models\Manage;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\Manage',
                'message' => '您输入的邮箱还未注册'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $manage Manage */
        $manage = Manage::findByEmail($this->email);

        if ($manage) {
            if (!Manage::isPasswordResetTokenValid($manage->password_reset_token)) {
                $manage->generatePasswordResetToken();
            }

            if ($manage->save()) {
                return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['manage' => $manage])
                    ->setTo($this->email)
                    ->setSubject('［密］密码重置')
                    ->send();
            }
        }

        return false;
    }
}
