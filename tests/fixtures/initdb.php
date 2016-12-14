<?php

$migrations = [
    '@vendor/dmplace/auth/src/migrations' => 'migration_auth',
    '@vendor/dmplace/cabinet/src/migrations' => 'migration_cabinet',
    '@vendor/dmplace/portfolio/src/migrations' => 'migration_portfolio',
    '@vendor/dmplace/document/src/migrations' => 'migration_document',
    '@vendor/dmplace/tender/src/migrations' => 'migration_tender',
    '@vendor/dmplace/notice/src/migrations' => 'migration_notice',
    '@vendor/dmplace/exchange1c/src/migrations' => 'migration_exchange1c',
    '@vendor/dmplace/service/src/migrations' => 'migration_service',
    '@vendor/private-it/yii2-data-module-questionnaire/src/migrations' => 'migration_questionnaire',
    '@vendor/private-it/yii2-data-module-mail-template/src/migrations' => 'migration_mail_template_template',
    '@vendor/private-it/yii2-data-module-messenger/src/migrations' => 'migration_messenger',
    '@app/src/migrations' => 'migration_application',
];

$migrateController = new \yii\console\controllers\MigrateController('migrate', Yii::$app);

foreach ($migrations as $path => $table) {
    $migrateController->migrationPath = $path;
    $migrateController->migrationTable = $table;
    $migrateController->runAction('up', ['interactive' => 0]);
}
