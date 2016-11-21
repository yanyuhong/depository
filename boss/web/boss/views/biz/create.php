<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Biz */

$this->title = 'Create Biz';
$this->params['breadcrumbs'][] = ['label' => 'Bizs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
