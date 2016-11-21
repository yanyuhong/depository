<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Biz */

$this->title = $model->biz_id;
$this->params['breadcrumbs'][] = ['label' => 'Bizs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->biz_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->biz_id], [
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
            'biz_id',
            'biz_hash_id',
            'biz_user_id',
            'biz_status',
            'biz_name',
            'biz_license',
            'biz_corporation_name',
            'biz_corporation_idno',
            'biz_account_no',
            'biz_account_bank',
            'biz_created_at',
            'biz_updated_at',
        ],
    ]) ?>

</div>
