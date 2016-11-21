<?php
use mdm\admin\components\MenuHelper;
use common\widgets\Menu;
use common\models\User;

?>
<aside class="bg-dark lt b-r b-light aside hidden-print hidden-xs" id="nav">
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px"
                 data-railOpacity="0.2">

                <div class="clearfix wrapper nav-user hidden-xs">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <span class="thumb avatar pull-left m-r">
                        <img src="/images/avatar.png" class="dker" alt="...">
                      </span>
                      <span class="hidden-nav-xs clear">
                        <span class="block m-t-xs">
                          <strong class="font-bold text-lt"><?= Yii::$app->user->identity->username ?></strong>
                          <b class="caret"></b>
                        </span>
                        <span class="text-muted text-xs block">
                            <?php
//                            $role = Yii::$app->user->identity->role;
//                            echo User::getRoleText($role);
                            ?>
                        </span>
                      </span>
                        </a>
<!--                        <ul class="dropdown-menu animated fadeInUp m-t-xs">-->
                            <?php
//                            $roles = Yii::$app->authmanager->getRoles();
//                            foreach($roles as $role){
//                                echo '<li><a href="/?r='.$role->name.'">'.$role->description.'</a></li>';
//                            }
                            ?>
<!--                        </ul>-->
                    </div>
                </div>
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                    <?php
                    $callback = function ($menu) {
                        $return = [
                            'label' => $menu['name'],
                            'url'   => [$menu['route']],
                            'icon'  => isset($menu['data']) ? $menu['data'] : 'i i-dot icon',
                            'items' => $menu['children']
                        ];

                        return $return;
                    };
                    $menus = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback, !YII_ENV_PROD); //非正式环境不缓存
                    echo Menu::widget(
                        [
                            'options' => ['class' => 'nav nav-main', 'data-ride' => 'collapse'],
                            'items'   => $menus,
                        ]
                    );
                    ?>
                </nav>
                <!-- / nav -->
            </div>
        </section>
        <footer class="footer hidden-xs no-padder text-center-nav-xs">
            <a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
                <i class="i i-circleleft text"></i>
                <i class="i i-circleright text-active"></i>
            </a>
        </footer>
    </section>
</aside>