<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Biz */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biz-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'biz_hash_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_user_id')->textInput() ?>

    <?= $form->field($model, 'biz_status')->textInput() ?>

    <?= $form->field($model, 'biz_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_license')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_corporation_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_corporation_idno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_account_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_account_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biz_created_at')->textInput() ?>

    <?= $form->field($model, 'biz_updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
