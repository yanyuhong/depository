<?php

use boss\models\WithdrawForm;
use boss\models\WithdrawSearch;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model boss\models\WithdrawSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="withdraw-form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        "options" => ['class' => 'form-inline'],
    ]); ?>

    <?php echo $form->field($model, 'withdraw_status')->dropDownList(WithdrawForm::$statusTextList, ['prompt' => '']) ?>

    <?php echo $form->field($model, 'serial_num') ?>

    <?php echo $form->field($model, 'amount_min')->input('number') ?>

    <?php echo $form->field($model, 'amount_max')->input('number') ?>

    <?php echo $form->field($model, 'bank_num')->dropDownList(WithdrawSearch::getBankList(), ['prompt' => '']) ?>

    <?php echo $form->field($model, 'card_name') ?>

    <?php echo $form->field($model, 'card_num') ?>

    <?php echo $form->field($model, 'created_at_start')->input('text', ['class' => 'datepicker-input form-control', 'data-date-format' => 'yyyy-mm-dd HH:ii']) ?>

    <?php echo $form->field($model, 'created_at_end')->input('text', ['class' => 'datepicker-input form-control', 'data-date-format' => 'yyyy-mm-dd HH:ii']) ?>

    <?php echo $form->field($model, 'finished_at_start')->input('text', ['class' => 'datepicker-input form-control', 'data-date-format' => 'yyyy-mm-dd HH:ii']) ?>

    <?php echo $form->field($model, 'finished_at_end')->input('text', ['class' => 'datepicker-input form-control', 'data-date-format' => 'yyyy-mm-dd HH:ii']) ?>

    <div class="form-group">
        <?= Html::submitButton('查找', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
