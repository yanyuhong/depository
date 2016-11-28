<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'boss',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'boss\controllers',
    'defaultRoute' => 'dashboard',
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // it can be '@path/to/your/layout'.
            /**/
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\Channel',
                    'idField' => 'id'
                ]
            ],
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
    ],
    'aliases' => [
        '@mdm/admin' => 'vendor\yii2-admin',
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Channel',
            'enableAutoLogin' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
            'defaultRoles' => ['?'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false
        ],
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
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*', 'gii/*', '*'
        ]
    ],
    'params' => $params,
];
