<?php
/**
 * Created by PhpStorm.
 * User: QSQ-YYH
 * Date: 16/4/20
 * Time: 上午10:37
 */

namespace common\tools;


class Money
{

    /**
     * 价格格式A,两位小数,无千位分隔符
     * @param $number
     * @return string
     */
    public static function priceA($number)
    {
        return number_format($number, 2, ".", "");
    }

    /**
     * 价格格式B,无小数位,无千位分隔符
     * @param $number
     * @return string
     */
    public static function priceB($number)
    {
        return number_format($number, 0, "", "");
    }

    /**
     * 金额格式A,两位小数,千位分隔符
     * @param $number
     * @return string
     */
    public static function amountA($number)
    {
        return number_format($number, 2, ".", ",");
    }

}