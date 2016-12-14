<?php
use \dmplace\application\modules\cabinet\data\LegalInformation;

return [
    [
        'id' => 2,
        'company_id' => 2,
        'name' => 'ООО Рога и Копыта',
        'full_name' => 'Общество с Ограниченной Ответственностью Рога и Копыта',
        'inn' => '21111111111',
        'kpp' => '22222222222',
        'ogrn' => '2333333333333333',
        'bank' => 'Альфа-Банк',
        'account_pay' => '24444444444444444',
        'account_cor' => '25555555555555555',
        'bik' => '266666666',
        'status' => LegalInformation::STATUS_ACTIVE
    ],
    [
        'id' => 3,
        'company_id' => 4,
        'name' => 'ООО Кредит Сервис',
        'full_name' => 'Общество с Ограниченной Ответственностью Кредит Сервис',
        'inn' => '31111111111',
        'kpp' => '32222222222',
        'ogrn' => '3333333333333333',
        'bank' => 'Альфа-Банк',
        'account_pay' => '34444444444444444',
        'account_cor' => '35555555555555555',
        'bik' => '366666666',
        'status' => LegalInformation::STATUS_ACTIVE
    ]
];