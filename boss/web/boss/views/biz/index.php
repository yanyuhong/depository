<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel boss\models\BizSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bizs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biz-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Biz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'biz_id',
            'biz_hash_id',
            'biz_user_id',
            'biz_status',
            'biz_name',
            // 'biz_license',
            // 'biz_corporation_name',
            // 'biz_corporation_idno',
            // 'biz_account_no',
            // 'biz_account_bank',
            // 'biz_created_at',
            // 'biz_updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
