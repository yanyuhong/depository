<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */

$this->title = $model->channel_id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-form-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<!--        --><?//= Html::a('Update', ['update', 'id' => $model->channel_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'channel_id',
            'channel_key',
            'channel_secret',
            'channel_name',
            'channel_created_at',
            'channel_updated_at',
        ],
    ]) ?>

</div>
