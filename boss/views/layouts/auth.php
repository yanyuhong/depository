<?php
use boss\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <!--[if lt IE 9]>
    <script src="/js/ie/html5shiv.js"></script>
    <script src="/js/ie/respond.min.js"></script>
    <script src="/js/ie/excanvas.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <?php $this->head() ?>
</head>
<body class="auth">
<?php $this->beginBody() ?>
<?=$content?>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder">
        <p>
            <small>&copy;<?=date('Y')?> 上海练爱网络科技有限公司</small>
        </p>
    </div>
</footer>
<!-- / footer -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>