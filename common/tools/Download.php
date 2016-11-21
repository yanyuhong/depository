<?php
/**
 * Created by PhpStorm.
 * User: QSQ-YYH
 * Date: 16/6/17
 * Time: 下午6:50
 */
namespace common\tools;

use Yii;

class Download
{
    /**
     * Download Csv File
     * @param string $filename
     * @param ActiveDataProvider $query
     * @param Array $line 该数组每项为一个两项数组，label为列名称，value为该项内容的回调函数
     *
     * @return null
     */
    public static function downloadCsv($filename, $query, $line)
    {
        header("Content-Type: application/csv");
        header("Charset=UTF-8");
        header("Content-Disposition: attachment; filename=$filename");
        $output = fopen('php://output', 'w') or die("Can't open php://output");

        $title = array();
        foreach ($line as $line_item) {
            if (isset($line_item['value'])) {
                $string = iconv('utf-8', 'GBK//TRANSLIT', isset($line_item['label']) ? $line_item['label'] : '');
                $title = array_merge($title, explode('/', $string));
            }
        }
        fputcsv($output, $title);

        foreach ($query->each(200) as $query_item) {
            $row = array();
            foreach ($line as $line_item) {
                if (isset($line_item['value'])) {
                    $rule = $line_item['value'];
                    $string = iconv('utf-8', 'GBK//TRANSLIT', $rule($query_item));
                    $row = array_merge($row, explode('/', $string));
                }
            }
            fputcsv($output, $row);
        }

        fclose($output);
    }
}
