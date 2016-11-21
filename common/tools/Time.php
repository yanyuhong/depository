<?php
/**
 * Created by PhpStorm.
 * User: QSQ-YYH
 * Date: 16/3/24
 * Time: 上午10:46
 */

namespace common\tools;

class Time
{
    public static function now($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function format($datetime, $format = 'Y-m-d H:i:s')
    {
        return date($format, strtotime($datetime));
    }

    public static function formatTime($datetime, $format = 'Y-m-d H:i:s')
    {
        return date($format, $datetime);
    }

    public static function getYear($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('Y', strtotime($datetime));
    }

    public static function getMonth($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('m', strtotime($datetime));
    }

    public static function getWeek($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('w', strtotime($datetime));
    }

    public static function getDay($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('d', strtotime($datetime));
    }

    public static function getHour($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('H', strtotime($datetime));
    }

    public static function getMinute($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('i', strtotime($datetime));
    }

    public static function getSecond($datetime = null)
    {
        if (!$datetime) $datetime = self::now();
        return date('s', strtotime($datetime));
    }

    public static function microtime()
    {
        return microtime(true);
    }

    public static function time()
    {
        return time();
    }

    public static function ago($second, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time - $second);
    }

    public static function agoHour($hour, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time - $hour * 60 * 60);
    }

    public static function agoDay($day, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time - $day * 24 * 60 * 60);
    }

    public static function after($second, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time + $second);
    }

    public static function afterHour($hour, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time + $hour * 60 * 60);
    }

    public static function afterDay($day, $format = 'Y-m-d H:i:s', $time = null)
    {
        if ($time === null) {
            $time = time();
        }
        return date($format, $time + $day * 24 * 60 * 60);
    }

    public static function span($day1, $day2)
    {
        return abs(intval(strtotime($day1) - strtotime($day2)));
    }

    public static function spanHour($day1, $day2)
    {
        return abs(intval((strtotime($day1) - strtotime($day2)) / 3600));
    }

    public static function spanDay($day1, $day2)
    {
        return abs(intval((strtotime($day1) - strtotime($day2)) / 3600 / 24));
    }

    public static function spanMouth($day1, $day2)
    {
        return abs(intval((strtotime($day1) - strtotime($day2)) / 3600 / 24 / 30));
    }

    public static function spanYear($day1, $day2)
    {
        return abs(intval((strtotime($day1) - strtotime($day2)) / 3600 / 24 / 365));
    }

    public static function starSign($date = null)
    {
        if (!$date) $date = self::now();
        $month = self::getMonth($date);
        $day = self::getDay($date);
        $zodiac = "";
        if (($month == 1 || $month == 2) && ($day > 22 || $day < 20)) {
            $zodiac = "水瓶座";
        } elseif (($month == 2 || $month == 3) && ($day > 21 || $day < 21)) {
            $zodiac = "双鱼座";
        } elseif (($month == 3 || $month == 4) && ($day > 22 || $day < 21)) {
            $zodiac = "白羊座";
        } elseif (($month == 4 || $month == 5) && ($day > 22 || $day < 22)) {
            $zodiac = "金牛座";
        } elseif (($month == 5 || $month == 6) && ($day > 23 || $day < 22)) {
            $zodiac = "双子座";
        } elseif (($month == 6 || $month == 7) && ($day > 23 || $day < 23)) {
            $zodiac = "巨蟹座";
        } elseif (($month == 7 || $month == 8) && ($day > 24 || $day < 22)) {
            $zodiac = "狮子座";
        } elseif (($month == 8 || $month == 9) && ($day > 23 || $day < 24)) {
            $zodiac = "处女座";
        } elseif (($month == 9 || $month == 10) && ($day > 25 || $day < 24)) {
            $zodiac = "天秤座";
        } elseif (($month == 10 || $month == 11) && ($day > 25 || $day < 23)) {
            $zodiac = "天蝎座";
        } elseif (($month == 11 || $month == 12) && ($day > 24 || $day < 23)) {
            $zodiac = "射手座";
        } elseif (($month == 12 || $month == 1) && ($day > 24 || $day < 21)) {
            $zodiac = "摩羯座";
        }
        return $zodiac;
    }

    public static function ignoreYearMonth($date)
    {
        $year = self::getYear($date);
        $month = self::getMonth($date);
        $day = self::getDay($date);

        $format = '';

        if ($year != self::getYear()) {
            $format = 'Y-m-d H:i';
        } elseif ($month != self::getMonth()) {
            $format = 'm-d H:i';
        } elseif ($day != self::getDay()) {
            $format = 'm-d H:i';
        } else {
            $format = 'H:i';
        }

        return self::format($date, $format);
    }

}