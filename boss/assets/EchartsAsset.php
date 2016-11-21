<?php
/**
 * Created by PhpStorm.
 * User: Allen
 * Date: 11/24/15
 * Time: 3:59 PM
 */

namespace boss\assets;

use yii\web\AssetBundle;

class EchartsAsset extends AssetBundle
{
    public $sourcePath = '@bower/echarts/build/dist/';
    public $js = [
        'echarts-all.js',
    ];
}