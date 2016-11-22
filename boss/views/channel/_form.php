<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-form-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'channel_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
