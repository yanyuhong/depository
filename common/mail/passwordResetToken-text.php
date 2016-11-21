<?php

/* @var $this yii\web\View */
/* @var $manage common\models\Manage */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset', 'token' => $manage->password_reset_token]);
?>
你好 <?= $manage->username ?>,

点击下面链接修改您在 hotfitness后台 的登录密码
安全提示：以下链接请勿告诉任何人，密码修改成功后请立即删除

<?= $resetLink ?>
