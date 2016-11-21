<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $manage common\models\Manage */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $manage->password_reset_token]);
?>
<div class="password-reset">
    <p>你好 <?= Html::encode($manage->username) ?>,</p>

    <p>点击下面链接修改您在 hotfitness后台 的登录密码</p>

    <p>安全提示：以下链接请勿告诉任何人，密码修改成功后请立即删除</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
