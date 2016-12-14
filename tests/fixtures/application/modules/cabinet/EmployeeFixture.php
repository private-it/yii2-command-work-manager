<?php

namespace tests\fixtures\application\modules\cabinet;

use tests\fixtures\ActiveFixture;

class EmployeeFixture extends ActiveFixture
{
    public $modelClass = 'dmplace\application\modules\cabinet\data\Employee';
    public $depends = [
        'tests\fixtures\application\modules\cabinet\CompanyFixture',
        'tests\fixtures\application\UserFixture'
    ];
}