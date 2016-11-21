<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \boss\models\SignupForm */

$this->title = '申请帐号';
?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xl panel">
        <section class="m-b-lg">
            <header class="panel-heading"><h2><?= Html::encode($this->title) ?></h2></header>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'mobile') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <div class="form-group">
                <?= Html::submitButton('申请帐号', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </section>
        <div class="line line-dashed"></div>
        <p class="text-muted text-center">
            <a href="/site/login">
                <small>返回登录</small>
            </a>
        </p>
    </div>
</section>
