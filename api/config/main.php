<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\Jsonparser',
                '*',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
            // 'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        /*'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'member'],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'lottery',
                    'except' => ['delete', 'update', 'create', 'view'],
                    // 'pluralize' => false, // 路由不使用复数形式
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'bjpc28',
                    'except' => ['delete', 'update', 'create', 'view'],
                    // 'pluralize' => false,
                    'extraPatterns' => [
                        'GET latest-and-countdown' => 'latest-and-countdown',
                        'GET latest' => 'latest',
                        'GET countdown' => 'countdown',
                        'GET analysis/<limit>' => 'analysis',
                    ],
                ],
            ],
        ],
        
    ],
    'params' => $params,
];
