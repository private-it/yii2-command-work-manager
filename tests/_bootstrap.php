<?php
// ensure we get report on all possible php errors
error_reporting(-1);
define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
// require composer autoloader if available
$vendorPath = __DIR__ . '/../vendor/';
if (!is_dir($vendorPath)) {
    $vendorPath = __DIR__ . '/../../../';
}
require_once $vendorPath . 'autoload.php';

require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@uploads', __DIR__ . '/_output/uploads');
