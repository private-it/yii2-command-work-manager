<?php

namespace tests\fixtures\application\modules\tender;

use tests\fixtures\ActiveFixture;

class MemberFixture extends ActiveFixture
{
    public $modelClass = 'dmplace\application\modules\tender\data\Member';
    public $depends = [
        'tests\fixtures\application\modules\tender\TenderFixture',
        'tests\fixtures\application\modules\cabinet\CompanyFixture'
    ];
}