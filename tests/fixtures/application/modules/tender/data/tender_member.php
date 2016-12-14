<?php
use \dmplace\application\modules\tender\data\Member;
return [
    [
        'id' => 3,
        'tender_id' => 3,
        'ref_id' => 2,
        'status' => Member::STATUS_VERIFICATION,
        'created_at' => '2016-08-07 17:46:00',
    ],
    [
        'id' => 4,
        'tender_id' => 3,
        'ref_id' => 3,
        'status' => Member::STATUS_VERIFICATION,
        'created_at' => '2016-09-07 16:46:00',
    ],
    [
        'id' => 2,
        'tender_id' => 2,
        'ref_id' => 4,
        'status' => Member::STATUS_WINNER_ACCEPTED,
        'created_at' => '2016-07-07 15:46:00',
    ],
];