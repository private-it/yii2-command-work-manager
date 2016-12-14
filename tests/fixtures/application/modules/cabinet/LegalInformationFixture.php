<?php

namespace tests\fixtures\application\modules\cabinet;

use tests\fixtures\ActiveFixture;

class LegalInformationFixture extends ActiveFixture
{
    public $modelClass = 'dmplace\application\modules\cabinet\data\LegalInformation';
    public $depends = [
        'tests\fixtures\application\modules\cabinet\CompanyFixture',
    ];
}