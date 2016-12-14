<?php
use dmplace\application\modules\document\data\Ref;

return [
    [
        'id' => 2,
        'initiator_user_id' => 2,
        'document_id' => 12,
        'object_id' => 24,
    ],
    [
        'id' => 3,
        'initiator_user_id' => 2,
        'document_id' => 13,
        'object_id' => 22,
    ],
    [
        'id' => 4,
        'initiator_user_id' => 2,
        'document_id' => 14,
        'object_id' => 23,
        'object_type' => Ref::OBJECT_TYPE_PORTFOLIO,
    ],
    [
        'id' => 5,
        'initiator_user_id' => 2,
        'document_id' => 15,
        'object_id' => 23,
    ],
    [
        'id' => 6,
        'initiator_user_id' => 2,
        'document_id' => 16,
        'object_id' => 24,
        'object_type' => Ref::OBJECT_TYPE_PORTFOLIO,
    ],
    [
        'id' => 7,
        'initiator_user_id' => 2,
        'document_id' => 17,
        'object_id' => 2,
        'object_type' => Ref::OBJECT_TYPE_TENDER,
    ],
    [
        'id' => 8,
        'initiator_user_id' => 2,
        'document_id' => 18,
        'object_id' => 16,
        'object_type' => Ref::OBJECT_TYPE_PORTFOLIO,
    ],
];