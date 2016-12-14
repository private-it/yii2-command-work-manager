<?php
return array_replace(
    [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=test',
        'username' => 'root',
        'password' => 'password',
        'charset' => 'utf8',
        'on afterOpen' => function ($event) {
            $event->sender->createCommand("SET time zone 'UTC'")->execute();
        }
    ],
    file_exists(__DIR__ . '/db-local.php') ? require __DIR__ . '/db-local.php' : []
);