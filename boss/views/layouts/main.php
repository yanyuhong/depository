<?php
use boss\assets\AppAsset;
use yii\helpers\Html;

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
        <?php $this->head() ?>
    </head>
    <body class="">
    <?php $this->beginBody() ?>
    <section class="vbox">
        <header class="bg-dark header header-md navbar navbar-fixed-top-xs box-shadow">
            <div class="navbar-header aside dk">
                <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                    <i class="fa fa-bars"></i>
                </a>
                <a href="/" class="navbar-brand">
                    <img src="/images/logo.png" class="m-r-sm" alt="logo">
                </a>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
                    <i class="fa fa-cog"></i>
                </a>
            </div>
            <form class="navbar-form navbar-left input-s-lg m-t m-l-n-xs hidden-xs" role="search">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-sm bg-white b-white btn-icon"><i
                                  class="fa fa-search"></i></button>
                        </span>
                        <input type="text" class="form-control input-sm no-border" placeholder="搜索...">
                    </div>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
<!--                <li class="hidden-xs">-->
<!--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
<!--                        <i class="i i-chat3"></i>-->
<!--                        <!--
<!--                        <span class="badge badge-sm up bg-danger count">2</span>-->
<!--                        -->
<!--                    </a>-->
<!--                    <section class="dropdown-menu aside-xl animated flipInY">-->
<!--                        <section class="panel bg-white">-->
<!--                            <div class="panel-heading b-light bg-light">-->
<!--                                <strong>你有 <span class="count">2</span> 条提醒</strong>-->
<!--                            </div>-->
<!--                            <div class="list-group list-group-alt">-->
<!--                                <a href="#" class="media list-group-item">-->
<!--                                  <span class="pull-left thumb-sm">-->
<!--                                    <img src="/images/a0.png" alt="..." class="img-circle">-->
<!--                                  </span>-->
<!--                                  <span class="media-body block m-b-none">-->
<!--                                    Use awesome animate.css<br>-->
<!--                                    <small class="text-muted">10 minutes ago</small>-->
<!--                                  </span>-->
<!--                                </a>-->
<!--                                <a href="#" class="media list-group-item">-->
<!--                                  <span class="media-body block m-b-none">-->
<!--                                    1.0 initial released<br>-->
<!--                                    <small class="text-muted">1 hour ago</small>-->
<!--                                  </span>-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="panel-footer text-sm">-->
<!--                                <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>-->
<!--                                <a href="#notes" data-toggle="class:show animated fadeInRight">查看所有提醒</a>-->
<!--                            </div>-->
<!--                        </section>-->
<!--                    </section>-->
<!--                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                          <img src="/images/avatar.png" alt="...">
                        </span>
<!--                        --><?//= Yii::$app->user->identity->username ?><!--<b class="caret"></b>-->
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
<!--                        <li>-->
<!--                            <span class="arrow top"></span>-->
<!--                            <a href="/admin">系统管理</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="/profiles">个人信息</a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="#">-->
<!--                                <span class="badge bg-danger pull-right">3</span>-->
<!--                                提醒-->
<!--                            </a>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="/docs">帮助</a>-->
<!--                        </li>-->
<!--                        <li class="divider"></li>-->
                        <li>
                            <a href="/site/logout" data-method="post">退出登录</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <section>
            <section class="hbox stretch">
                <!-- .aside -->
                <?php echo $this->render('_menus'); ?>
                <!-- /.aside -->
                <section id="content">
                    <section class="vbox">
                        <section class="scrollable padder">
                            <?= $content ?>
                        </section>
                    </section>
                    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
                       data-target="#nav,html"></a>
                </section>
            </section>
        </section>
    </section>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>