<?php
/**
 * Created by PhpStorm.
 * User: yanyuhong
 * Date: 16/9/23
 * Time: 上午11:52
 */

namespace common\tools;

use yii\db\ActiveQuery;

class Sql
{
    const PAGE_LIMIT = 20;

    /**
     * @param $query ActiveQuery
     * @param $page int
     */
    public static function setPage($query, $page = 0)
    {
        $query->offset($page * self::PAGE_LIMIT)->limit(self::PAGE_LIMIT);
    }

    /**
     * @param $query ActiveQuery
     * @param $attribute string
     * @param $date string
     */
    public static function setMonth($query, $attribute, $date = null)
    {
        if (!$date) {
            $date = Time::now();
        }

        $year = Time::getYear($date);
        $month = Time::getMonth($date);

        $begin = $year . '-' . $month . '-1 00:00:00';
        $end = (($month + 1 > 12) ? $year + 1 : $year) . '-' . (($month + 1 > 12) ? 1 : $month + 1) . '-1 00:00:00';

        $query->andFilterWhere(['>=', $attribute, $begin])
            ->andFilterWhere(['<', $attribute, $end]);
    }

}