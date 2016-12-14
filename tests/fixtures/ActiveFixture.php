<?php
/**
 * Created by PhpStorm.
 * User: user93
 * Date: 18.05.16
 * Time: 12:45
 */

namespace tests\fixtures;


class ActiveFixture extends \yii\test\ActiveFixture
{
    public function beforeLoad()
    {
        parent::beforeLoad();
    }

    public function afterLoad()
    {
        parent::afterLoad();
    }

}