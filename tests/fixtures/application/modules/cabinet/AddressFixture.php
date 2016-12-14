<?php

namespace tests\fixtures\application\modules\cabinet;

use tests\fixtures\ActiveFixture;

class AddressFixture extends ActiveFixture
{
    public $modelClass = 'dmplace\application\modules\cabinet\data\Address';
    public $depends = [
        'tests\fixtures\application\modules\cabinet\CompanyFixture',
    ];
}