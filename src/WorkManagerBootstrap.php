<?php

namespace PrivateIT\command\workManager;

use yii\base\BootstrapInterface;
use yii\base\Application;

class WorkManagerBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            if (!isset($app->controllerMap['work-manager'])) {
                $app->controllerMap['work-manager'] = '\PrivateIT\command\workManager\WorkManagerController';
            }
        }
    }
}