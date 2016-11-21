<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace boss\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.css',
        'css/animate.css',
        'css/font-awesome.min.css',
        'css/icon.css',
        'css/app.css',
        'js/datepicker/css/bootstrap-datetimepicker.min.css',
        'js/chosen/chosen.css',
    ];
    public $js = [
        'js/bootstrap.js',
        'js/app.js',
        'js/slimscroll/jquery.slimscroll.min.js',
        'js/app.plugin.js',
        'js/datepicker/js/bootstrap-datetimepicker.min.js',
        'js/datepicker/js/locales/bootstrap-datetimepicker.zh-CN.js',
        'js/chosen/chosen.jquery.min.js',
        'js/slider/bootstrap-slider.js',
        'js/spinner/jquery.bootstrap-touchspin.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
