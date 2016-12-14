<?php
use dmplace\application\modules\document\data\Document;
return [
    [
        'id' => 12,
        'initiator_user_id' => 2,
        'name' => 'test-file-2.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 13,
        'initiator_user_id' => 2,
        'name' => 'test-file-3.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 14,
        'initiator_user_id' => 2,
        'name' => 'test-file-4.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 15,
        'initiator_user_id' => 2,
        'name' => 'test-file-4.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO_PASSPORT),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 16,
        'initiator_user_id' => 2,
        'name' => 'test-file-5.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 17,
        'initiator_user_id' => 2,
        'name' => 'test-file-tender-2.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_TENDER),
        'status' => Document::STATUS_ACTIVE,
    ],
    [
        'id' => 18,
        'initiator_user_id' => 2,
        'name' => 'test-file-portfolio-passport-16.doc',
        'type_id' => Document::getTypeIdByName(Document::TYPE_PORTFOLIO_PASSPORT),
        'status' => Document::STATUS_ACTIVE,
    ]
];