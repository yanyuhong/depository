<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel boss\models\WithdrawSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '提现列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-form-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => '状态',
                'attribute' => 'withdraw_status',
                'value' => function ($model) {
                    return $model->getStatusText();
                }
            ],
            [
                'label' => '流水号',
                'attribute' => 'withdrawOperation.operation_serial_num',
            ],
            [
                'label' => '打款金额',
                'attribute' => 'withdraw_amount',
            ],
            [
                'label' => '收款银行',
                'attribute' => 'withdrawCard.cardBank.bank_name',
            ],
            [
                'label' => '收款人',
                'attribute' => 'withdrawCard.card_name',
            ],
            [
                'label' => '收款银行卡号',
                'attribute' => 'withdrawCard.card_num',
            ],
            [
                'label' => '提交时间',
                'attribute' => 'withdrawOperation.operation_created_at',
            ],
            [
                'label' => '完成时间',
                'attribute' => 'withdrawOperation.operation_finished_at',
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'options' => ['width' => '100px;'],
                'template' => '{operation}  {success}  {fail}',
                'buttons' => [
                    'operation' => function ($url) {
                        $params = '&' . http_build_query($_REQUEST);
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>',
                            $url . $params,
                            ['title' => \Yii::t('app', '已提交到银行'),]);
                    },
                    'success' => function ($url) {
                        $params = '&' . http_build_query($_REQUEST);
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>',
                            $url . $params,
                            ['title' => \Yii::t('app', '已到账'),]);
                    },
                    'fail' => function ($url) {
                        $params = '&' . http_build_query($_REQUEST);
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>',
                            $url . $params,
                            ['title' => \Yii::t('app', '转账失败'),]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
