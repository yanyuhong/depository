<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model boss\models\ChannelForm */

$this->title = '新建渠道';
$this->params['breadcrumbs'][] = ['label' => 'Channel Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-form-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
