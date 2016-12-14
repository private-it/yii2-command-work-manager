#!/usr/bin/env php
<?php
require_once __DIR__ . '/_bootstrap.php';

$application = new yii\console\Application(require(__DIR__ . '/codeception/config/console.php'));
$exitCode = $application->run();
exit($exitCode);