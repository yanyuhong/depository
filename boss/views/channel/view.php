<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */

$this->title = $model->channel_name;
$this->params['breadcrumbs'][] = ['label' => 'Channel Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-form-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        echo Html::a('修改', ['update', 'id' => $model->channel_id], ['class' => 'btn btn-primary']); ?>
        <?php
        if ($model->checkAlipay()) {
            echo Html::a('修改支付宝支付', ['alipay', 'id' => $model->channel_id], ['class' => 'btn btn-primary']);
        } else {
            echo Html::a('开通支付宝支付', ['alipay', 'id' => $model->channel_id], ['class' => 'btn btn-primary']);
        }
        ?>
        <?php
        if ($model->checkWechat()) {
            echo Html::a('修改微信支付', ['wechat', 'id' => $model->channel_id], ['class' => 'btn btn-primary']);
        } else {
            echo Html::a('开通微信支付', ['wechat', 'id' => $model->channel_id], ['class' => 'btn btn-primary']);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'channel_name',
            'channel_key',
            'channel_secret',
            'channel_created_at',
            'channel_updated_at',
        ],
    ]) ?>

</div>
