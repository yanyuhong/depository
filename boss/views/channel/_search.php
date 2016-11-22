<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        "options" => ['class' => 'form-inline'],
    ]); ?>

    <?= $form->field($model, 'channel_name') ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
