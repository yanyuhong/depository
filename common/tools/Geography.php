<?php
/**
 * Created by PhpStorm.
 * User: yyh
 * Date: 2016/8/23
 * Time: 15:59
 */

namespace common\tools;


class Geography
{
    /**
     * @desc 根据两点的经纬度计算距离
     *
     * @param float $lat1 纬度值
     * @param float $lng1 经度值
     * @param float $lat2 纬度值
     * @param float $lng2 经度值
     *
     * @return float
     */
    public static function distanceByLonLat($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6367000; //approximate radius of earth in meters

        $lat1 = ($lat1 * pi()) / 180;
        $lng1 = ($lng1 * pi()) / 180;

        $lat2 = ($lat2 * pi()) / 180;
        $lng2 = ($lng2 * pi()) / 180;

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance);
    }

    /**
     * @desc 距离(m)格式化
     *
     * @param int $distance 距离(m)
     *
     * @return string
     */
    public static function distanceStyle($distance){
        if($distance<1000){
            return (string)((int)($distance/10))*10 . 'm';
        }elseif($distance<10000){
            return (string)(((int)($distance/100))*100)/1000 . 'km';
        }else{
            return (string)((int)($distance/1000)) . 'km';
        }
    }
}