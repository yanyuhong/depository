<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \boss\models\LoginForm */

$this->title = '用户登录';
?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xl">
        <section class="m-b-lg">
            <header class="wrapper text-center"><h2>登录</h2></header>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="list-group">
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('登 录', ['class' => 'btn btn-lg btn-success btn-block', 'name' => 'login-button']) ?>
                <div class="text-center m-t m-b"><a href="/site/request-password-reset">忘记密码了?</a></div>
            </div>
            <?php ActiveForm::end(); ?>
        </section>
    </div>
</section>