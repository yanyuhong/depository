<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=depository', // MySQL, MariaDB
            'username' => 'depository',
            'password' => 'depository',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' =>false,//这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.aliyun.com',  //每种邮箱的host配置不一样
                'username' => 'yyhyxcs@aliyun.com',
                'password' => 'yyh12345678',
                'port' => '25',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['yyhyxcs@aliyun.com'=>'hotfitness']
            ],
        ],
    ],
];