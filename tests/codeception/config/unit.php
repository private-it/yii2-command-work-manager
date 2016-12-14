<?php
return array_replace_recursive(
    require __DIR__ . '/main.php',
    [
        'language' => 'ru',
        'bootstrap' => ['log'],
        'components' => [
            'log' => [
                'targets' => [
                    'info' => [
                        'class' => 'yii\log\FileTarget',
                        'levels' => ['trace', 'info'],
                        'logFile' => '@runtime/logs/info.log'
                    ],
                    'error' => [
                        'class' => 'yii\log\FileTarget',
                        'levels' => ['error', 'warning'],
                        'logFile' => '@runtime/logs/error.log',
                    ],
                ]
            ],
            'user' => [
                'identityClass' => 'dmplace\application\data\User'
            ]
        ]
    ]
);