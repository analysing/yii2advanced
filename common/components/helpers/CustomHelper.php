<?php

namespace lotto28\components\helpers;

/**
 * 自定义助手类
 */
class CustomHelper
{
    public static function sayHello($msg = 'hello ivy')
    {
        return $msg;
    }

    /**
     * 将数据转换成露珠形式
     * $data = ['a', 'a', 'a', 'a', 'b', 'b', 'a', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'b', 'a', 'a'];
     * ->
     * $arr = [
     *     0 => [0 => 'a', 1 => 'b', 2 => 'a', 3 => 'b', 4 => 'a'],
     *     1 => [0 => 'a', 1 => 'b', 3 => 'b', 4 => 'a'],
     *     2 => [0 => 'a', 3 => 'b'],
     *     3 => [0 => 'a', 3 => 'b'],
     *     4 => [3 => 'b'],
     *     5 => [3 => 'b'],
     *     6 => [3 => 'b'],
     *     7 => [3 => 'b'],
     *     8 => [3 => 'b'],
     * ];
     * @param  array $data 原始数据
     * @return array       处理后的数据
     */
    public static function dewdropHandle($data)
    {
        $arr = [];
        $i = $j = 0;
        $z = $data[0];
        unset($data[0]);
        $arr[$i][$j] = $z;

        foreach ($data as $k => $v) {
            if ($v == $z) {
                $arr[++$i][$j] = $v;
            } else {
                $i = 0;
                $arr[$i][++$j] = $v;
                $z = $v;
            }
        }
        return $arr;
    }

    /**
     * 获取最后一个露珠
     * @param  array $data 露珠数据
     * @return array       0露珠，1数组下标，2数组下标
     */
    public static function getLastDewdrop($data)
    {
        $c = count($data);
        $cc = count(current($data));
        $s = '';
        $x = $y = '';
        for ($i=0; $i < $c; $i++) { 
            $k = array_keys($data[$i]);
            if (end($k) == ($cc - 1)) {
                $x = $i;
                $y = $cc - 1;
                $s = $data[$x][$y];
            }
        }
        return [$s, $x, $y];
    }

    /**
     * 新增露珠
     * @param array $data 露珠数据
     * @param string $e    露珠
     */
    public static function addDewdrop($data, $e)
    {
        list($dewdrop, $x, $y) = get_last_dewdrop($data);
        if ($e == $dewdrop) {
            $data[($x + 1)][$y] = $e;
        } else {
            $data[0][($y + 1)] = $e;
        }
        return $data;
    }
}