<?php

namespace common\components\helpers;

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
        if (!$data || !is_array($data)) return [];
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
        list($dewdrop, $x, $y) = self::getLastDewdrop($data);
        if ($e == $dewdrop) {
            $data[($x + 1)][$y] = $e;
        } else {
            $data[0][($y + 1)] = $e;
        }
        return $data;
    }

    /**
     * PC28未开统计
     * @param  array $data 原始数据
     * @return array       处理后的数据
     */
    public static function pc28NotOpenHandle($data)
    {
        if (!$data || !is_array($data)) {
            return [];
        }
        $res = ['big' => '--', 'small' => '--', 'even' => '--', 'odd' => '--', 'small_even' => '--', 'small_odd' => '--', 'big_even' => '--', 'big_odd' => '--', 'small_limit' => '--', 'big_limit' => '--'];
        for ($i=0; $i < 28; $i++) { 
            $res['c'. $i] = '--';
        }
        foreach ($data as $k => $v) {
            if ($v['sum_big'] == '大' && (!isset($res['big']) || $res['big'] == '--')) {
                $res['big'] = $k;
            } elseif ($v['sum_big'] == '小' && (!isset($res['small']) || $res['small'] == '--')) {
                $res['small'] = $k;
            }

            if ($v['sum_even'] == '单' && (!isset($res['even']) || $res['even'] == '--')) {
                $res['even'] = $k;
            } elseif ($v['sum_even'] == '双' && (!isset($res['odd']) || $res['odd'] == '--')) {
                $res['odd'] = $k;
            }

            if ($v['sum_bigeven'] == '小单' && (!isset($res['small_even']) || $res['small_even'] == '--')) {
                $res['small_even'] = $k;
            } elseif ($v['sum_bigeven'] == '大单' && (!isset($res['big_even']) || $res['big_even'] == '--')) {
                $res['big_even'] = $k;
            } elseif ($v['sum_bigeven'] == '小双' && (!isset($res['small_odd']) || $res['small_odd'] == '--')) {
                $res['small_odd'] = $k;
            } elseif ($v['sum_bigeven'] == '大双' && (!isset($res['big_odd']) || $res['big_odd'] == '--')) {
                $res['big_odd'] = $k;
            }

            if ($v['sum_limit'] == '极大' && (!isset($res['big_limit']) || $res['big_limit'] == '--')) {
                $res['big_limit'] = $k;
            } elseif ($v['sum_limit'] == '极小' && (!isset($res['small_limit']) || $res['small_limit'] == '--')) {
                $res['small_limit'] = $k;
            }

            for ($i=0; $i < 28; $i++) { 
                if ($v['number_sum'] == $i && (!isset($res['c'. $i]) || $res['c'. $i] == '--')) {
                    $res['c'. $i] = $k;
                }
            }
        }

        return $res;
    }

    /**
     * PC28未开单期加入统计
     * @param  array  $issue 奖期信息
     * @param  array  $data  未开统计数据
     * @param  integer $num   未开期数
     * @return array         处理后的未开统计数据
     */
    public static function pc28NotOpenSingleHdl($issue, $data, $num = 50)
    {
        if (!$issue || !$data || !is_array($issue) || !is_array($data)) {
            return false;
        }

        // 如果等于未开期数的就设置成--，否则如果为数字则+1，不为数字，也就是依然为--则不处理
        foreach ($data as $k => $v) {
            if ($v == $num) {
                $data[$k] = '--';
            } elseif (is_numeric($v)) {
                $data[$k]++;
            }
        }
        
        if ($issue['sum_big'] == '大') {
            $data['big'] = 0;
        } elseif ($issue['sum_big'] == '小') {
            $data['small'] = 0;
        }

        if ($issue['sum_even'] == '单') {
            $data['even'] = 0;
        } elseif ($issue['sum_even'] == '双') {
            $data['odd'] = 0;
        }

        if ($issue['sum_bigeven'] == '小单') {
            $data['small_even'] = 0;
        } elseif ($issue['sum_bigeven'] == '大单') {
            $data['big_even'] = 0;
        } elseif ($issue['sum_bigeven'] == '小双') {
            $data['small_odd'] = 0;
        } elseif ($issue['sum_bigeven'] == '大双') {
            $data['big_odd'] = 0;
        }

        if ($issue['sum_limit'] == '极大') {
            $data['big_limit'] = 0;
        } elseif ($issue['sum_limit'] == '极小') {
            $data['small_limit'] = 0;
        }

        for ($i=0; $i < 28; $i++) { 
            if ($issue['number_sum'] == $i) {
                $data['c'. $i] = 0;
            }
        }

        return $data;
    }

    public static function getCountdown($lottery, $lt) {
        //$lt = isset($one['addtime']) ? $one['addtime'] : $one['add_time'];
        $nt = time();
        $ddd = date("H:i:s");
        switch ($lottery) {
            case 'result_gd_10':
                $st = 590 + $lt - $nt;
                if ($st < 0) {
                    $st = 590;
                }
                if ($ddd < '09:10:20') {
                    $st = strtotime(date("Y-m-d") . ' 09:10:00') - time();
                }
                if ($ddd > '23:00:20') {
                    $st = strtotime(date("Y-m-d", strtotime("+1 day")) . ' 09:10:00') - time();
                }
                break;
            case 'result_cq_10':
                $st = 590 + $lt - $nt;
                if ($st < 0) {
                    $st = 590;
                }
                if ($ddd > '22:00:00' || $ddd < '10:00:00') {
                    $st = 290 + $lt - $nt;
                    if ($st < 0) {
                        $st = 290;
                    }
                }
                if ($ddd > '01:55:20' && $ddd < '10:00:0') {
                    $st = strtotime(date("Y-m-d") . ' 10:00:00') - time();
                }
                break;
            case 'result_gx_10':
                break;
            case 'result_pk_10':
                $st = 290 + $lt - $nt;
                if ($st < 0) {
                    $st = 290;
                }
                if ($ddd < '09:06:00') {
                    $st = strtotime(date("Y-m-d") . ' 09:06:00') - time();
                }
                if ($ddd > '23:56:00') {
                    $st = strtotime(date("Y-m-d", strtotime("+1 day")) . ' 09:06:00') - time();
                }
                break;
            case 'result_nc_10':
                $st = 590 + $lt - $nt;
                if ($st < 0) {
                    $st = 590;
                }
                if ($ddd > '02:04:50' && $ddd < '10:00:00') {
                    $st = strtotime(date("Y-m-d") . ' 10:00:00') - time();
                }
                break;
            case 'result_xj_10':
                $st = 590 + $lt - $nt;
                if ($st < 0) {
                    $st = 590;
                }
                if ($ddd > '02:00:50' && $ddd < '10:10:00') {
                    $st = strtotime(date("Y-m-d") . ' 10:10:00') - time();
                }
                break;
            case 1:
                $st = 290 - $nt + $lt;
                $st = $st > 290 ? 290 : $st;
                if ($ddd < '09:05:00') {
                    $st = strtotime(date("Y-m-d") . ' 09:05:00') - time();
                }
                if ($ddd >= '23:56:00') {
                    $st = strtotime(date("Y-m-d", strtotime("+1 day")) . ' 09:05:00') - time();
                }
                break;
            case 2:
                $st = 200 - $nt + $lt;
                $st = $st > 200 ? 200 : $st;
                $st = $st < 0 ? 0 : $st;
                break;
            case 'result_six_10':
                if ($ddd > '21:30:00' || $ddd < '20:59:00') {
                    $st = 999999999;
                } else {
                    $lt = strtotime(date("Y-m-d") . ' 21:00:00');
                    $st = $lt - $nt;
                }
                if ($st < 0) {
                    $st = 0;
                }
                break;
            case 're11_six':
                if ($ddd > '21:35:00' || $ddd < '20:59:00') {
                    $st = 999999999;
                } else {
                    $st = $lt - $nt;
                }
                if ($st < 0) {
                    $st = 0;
                }
                break;
            default:
                break;
        }
        return $st;
    }
}