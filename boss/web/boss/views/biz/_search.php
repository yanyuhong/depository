<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\BizSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biz-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'biz_id') ?>

    <?= $form->field($model, 'biz_hash_id') ?>

    <?= $form->field($model, 'biz_user_id') ?>

    <?= $form->field($model, 'biz_status') ?>

    <?= $form->field($model, 'biz_name') ?>

    <?php // echo $form->field($model, 'biz_license') ?>

    <?php // echo $form->field($model, 'biz_corporation_name') ?>

    <?php // echo $form->field($model, 'biz_corporation_idno') ?>

    <?php // echo $form->field($model, 'biz_account_no') ?>

    <?php // echo $form->field($model, 'biz_account_bank') ?>

    <?php // echo $form->field($model, 'biz_created_at') ?>

    <?php // echo $form->field($model, 'biz_updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
