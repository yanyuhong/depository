<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Biz */

$this->title = 'Update Biz: ' . $model->biz_id;
$this->params['breadcrumbs'][] = ['label' => 'Bizs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->biz_id, 'url' => ['view', 'id' => $model->biz_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="biz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
