<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel boss\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '渠道列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-form-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'channel_id',
            'channel_key',
            'channel_secret',
            'channel_name',
            'channel_created_at',
            // 'channel_updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
