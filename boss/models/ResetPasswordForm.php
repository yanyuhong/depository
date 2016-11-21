<?php
namespace boss\models;

use common\models\Manage;
use yii\base\Model;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \common\models\Manage
     */
    private $_manage;


    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\web\ForbiddenHttpException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new ForbiddenHttpException('Password reset token cannot be blank.');
        }
        $this->_manage = Manage::findByPasswordResetToken($token);
        if (!$this->_manage) {
            throw new ForbiddenHttpException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_manage;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save();
    }
}
