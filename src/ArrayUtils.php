<?php

namespace Larams\Cms;

class ArrayUtils
{
    public static function orderBy(array &$arr, $order)     // $order = column1 ASC, column2 DESC, column3 ASC
    {
        if (empty($arr) || empty($order)) {
            return $arr;
        }

        $orders = explode(',', $order);
        usort($arr, function ($a, $b) use ($orders) {
            $result = array();
            foreach ($orders as $value) {
                list($field, $sort) = array_map('trim', explode(' ', trim($value)));
                if (!(isset($a[$field]) && isset($b[$field]))) {
                    continue;
                }
                if (strcasecmp($sort, 'desc') === 0) {
                    $tmp = $a;
                    $a = $b;
                    $b = $tmp;
                }
                if (is_numeric($a[$field]) && is_numeric($b[$field])) {
                    $result[] = ($a[$field] - $b[$field]) * 10000;
                } else {
                    $result[] = strcmp($a[$field], $b[$field]);
                }
            }
            return implode('', $result);
        });
        return $arr;
    }

}
