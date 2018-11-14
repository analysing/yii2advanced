<?php

namespace api\components\helpers;

/**
* 自定义助手类
*/
class CustomHelper
{
    public static function sayHello($msg = 'hello world')
    {
        return $msg;
    }

    public static function getWkLimit($i,$wk){
        $class = 0;
        switch ($i){
            case 0:
            case 27:
                if($wk > 800){
                    $class = 1;
                }
                break;
            case 1:
            case 26:
                if($wk > 300){
                    $class = 1;
                }
                break; 
            case 2:
            case 25:
                if($wk > 150){
                    $class = 1;
                }
                break;
            case 3:
            case 24:
                if($wk > 80){
                    $class = 1;
                }
                break;
            case 4:
            case 23:
                if($wk > 50){
                    $class = 1;
                }
                break;
            case 5:
            case 22:
                if($wk > 35){
                    $class = 1;
                }
                break;
            case 6:
            case 21:
                if($wk > 25){
                    $class = 1;
                }
                break;
            case 7:
            case 20:
                if($wk > 20){
                    $class = 1;
                }
                break;
            case 8:
            case 19:
                if($wk > 15){
                    $class = 1;
                }
                break;
            case 9:
            case 10:
            case 17:
            case 18:
                if($wk > 10){
                    $class = 1;
                }
                break;
            default :
                if($wk > 0){
                    $class = 1;
                }
                break;
        }
        return $class;
    }

    public static function getCountdown($table, $lt) {
        //$lt = isset($one['addtime']) ? $one['addtime'] : $one['add_time'];
        $nt = time();
        $ddd = date("H:i:s");
        switch ($table) {
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
            case 'result_pc':
                $st = 290 - $nt + $lt;
                $st = $st > 290 ? 290 : $st;
                if ($ddd < '09:05:00') {
                    $st = strtotime(date("Y-m-d") . ' 09:05:00') - time();
                }
                if ($ddd >= '23:56:00') {
                    $st = strtotime(date("Y-m-d", strtotime("+1 day")) . ' 09:05:00') - time();
                }
                break;
            case 'result_jnd':
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