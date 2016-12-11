<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model boss\models\WithdrawForm */

$this->title = $model->withdraw_id;
$this->params['breadcrumbs'][] = ['label' => 'Withdraw Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-form-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->withdraw_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->withdraw_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'withdraw_id',
            'withdraw_operation_id',
            'withdraw_account_id',
            'withdraw_card_id',
            'withdraw_amount',
            'withdraw_status',
        ],
    ]) ?>

</div>
