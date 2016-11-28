<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */

$this->title = '修改渠道: ' . $model->channel_name;
$this->params['breadcrumbs'][] = ['label' => 'Channel Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->channel_id, 'url' => ['view', 'id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="channel-form-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
