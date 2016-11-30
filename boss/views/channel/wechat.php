<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = '微信支付:' . $model->channel_name;
$this->params['breadcrumbs'][] = ['label' => 'Channel Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->channel_id, 'url' => ['view', 'id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Wechat';
?>
<div class="channel-form-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="channel-form-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'channel_wechat_appid')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'channel_wechat_mchid')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'channel_wechat_key')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'channel_wechat_sslcert')->textarea(['rows' => '8']) ?>

        <?= $form->field($model, 'channel_wechat_sslkey')->textarea(['rows' => '8']) ?>

        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
