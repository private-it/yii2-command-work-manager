<?php
use \dmplace\application\modules\cabinet\data\Address;

return [
    [
        'id' => 2,
        'company_id' => 2,
        'area' => 'Новосибирск',
        'street' => 'Мусы Джалиля',
        'build' => '3/1',
        'room' => '834',
        'type' => Address::TYPE_LEGAL,
        'status' => Address::STATUS_ACTIVE,
    ],
    [
        'id' => 3,
        'company_id' => 2,
        'area' => 'Новосибирск',
        'street' => 'Мусы Джалиля',
        'build' => '3/1',
        'room' => '834',
        'type' => Address::TYPE_POSTAL,
        'status' => Address::STATUS_ACTIVE,
    ]
];