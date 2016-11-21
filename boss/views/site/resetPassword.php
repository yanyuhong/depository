<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \boss\models\ResetPasswordForm */

$this->title = '重置密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="site-reset-password container aside-xl">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>设置新密码</p>
        <div class="row">
            <div class="col-lg-10">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

