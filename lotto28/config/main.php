<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-lotto28',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'lotto28\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-lotto28',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
            // 'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        /*'session' => [
            // this is the name of the session cookie used for login on the lotto28
            'name' => 'advanced-lotto28',
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'bjpc28',
                    'except' => ['delete', 'update', 'create', 'view'],
                    'extraPatterns' => [
                        'GET load' => 'load',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'jndpc28',
                    'except' => ['delete', 'update', 'create', 'view'],
                    'extraPatterns' => [
                        'GET load' => 'load',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'cms',
                    'pluralize' => false,
                    'except' => ['delete', 'update', 'create', 'view'],
                    'extraPatterns' => [
                        'GET type' => 'type',
                        'GET more' => 'more',
                        'GET content/<id>' => 'content',
                    ],
                ],
            ],
        ],
        
    ],
    'params' => $params,
];
