<?php
use dmplace\application\modules\document\data\Document;
use dmplace\application\modules\document\data\Type;

$data = [];

$types = Document::getTypes();
$i = 200;
foreach ($types as $type => $typeLabel) {
    $data[] = [
        'id' => $i++,
        'name' => $type,
        'status' => Type::STATUS_ACTIVE,
    ];
}

return $data;