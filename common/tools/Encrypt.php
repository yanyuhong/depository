<?php
/**
 * Created by PhpStorm.
 * User: QSQ-YYH
 * Date: 16/4/20
 * Time: 上午10:37
 */

namespace common\tools;


class Encrypt
{

    public static function md5Str($key, $class)
    {
        $string = $key . time() . rand() . $class;
        return md5($string);
    }

    public static function getNum($char)
    {
        $sum = '';
        $array = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $len = strlen($char);
        for ($i = 0; $i < $len; $i++) {
            $index = array_search($char[$i], $array);
            $sum = $sum . $index;
        }
        return $sum;
    }

    public static function getRandom($num)
    {
        $min = pow(10, $num - 1);
        $max = pow(10, $num) - 1;
        return rand($min, $max);
    }

    public static function getOrderNo()
    {
        $orderSn = intval(date('Y')) - 2015 . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

}