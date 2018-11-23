<?php

namespace common\components;

class ExitCode
{
    const OK = 0; // success

    const UNSPECIFIED_ERROR = 1; // 未指定错误
    const REQUEST_PARAM_ERR = 1000; // 请求参数错误
    
    const DB_NO_DATA = 2000; // 未找到数据

    public static $reasons = [
        self::OK => 'success',
        self::UNSPECIFIED_ERROR => '未知错误',
        self::REQUEST_PARAM_ERR => '请求参数错误',
        self::DB_NO_DATA => '未找到数据',
    ];
    
    public static function getReason($exitCode)
    {
        return isset(static::$reasons[$exitCode]) ? static::$reasons[$exitCode] : 'Unknown exit code.';
    }

    public static function exitDataHdl($data, $exitCode, $exitMsg = '')
    {
        $arr = [
            'code' => $exitCode,
            'msg'  => $exitMsg ? $exitMsg : static::getReason($exitCode),
        ];
        if ($data) {
            if (is_array($data))
                $arr = array_merge($arr, $data);
            else $arr['data'] = $data;
        }
        return $arr;
    }
}