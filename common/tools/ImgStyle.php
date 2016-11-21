<?php
/**
 * Created by PhpStorm.
 * User: yyh
 * Date: 2016/8/23
 * Time: 15:59
 */

namespace common\tools;


class ImgStyle
{

    public static function avatar()
    {
        return "?imageView2/5/w/80/h/80";
    }

    public static function gymAlbum()
    {
        return "?imageView2/1/w/375/h/280";
    }

    public static function gymCourse()
    {
        return "?imageView2/1/w/375/h/180";
    }

    public static function train()
    {
        return "?imageView2/1/w/375/h/210";
    }

    public static function square($long)
    {
        return "?imageView2/5/w/" . $long . "/h/" . $long;
    }

    public static function maxLong($long, $short)
    {
        return "?imageView2/0/w/" . $long . "/h/" . $short;
    }
}