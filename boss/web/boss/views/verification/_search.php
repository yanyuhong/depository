<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\VerificationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'verification_id') ?>

    <?= $form->field($model, 'verification_type') ?>

    <?= $form->field($model, 'verification_mobile') ?>

    <?= $form->field($model, 'verification_code') ?>

    <?= $form->field($model, 'verification_status') ?>

    <?php // echo $form->field($model, 'verification_created_at') ?>

    <?php // echo $form->field($model, 'verification_used_at') ?>

    <?php // echo $form->field($model, 'verification_updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
