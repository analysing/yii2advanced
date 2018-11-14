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
}