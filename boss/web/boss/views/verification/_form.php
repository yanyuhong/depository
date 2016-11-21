<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Verification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="verification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'verification_type')->textInput() ?>

    <?= $form->field($model, 'verification_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verification_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verification_status')->textInput() ?>

    <?= $form->field($model, 'verification_created_at')->textInput() ?>

    <?= $form->field($model, 'verification_used_at')->textInput() ?>

    <?= $form->field($model, 'verification_updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
