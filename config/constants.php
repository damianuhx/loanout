<?php

return ['types'=>[
    'hidden' => ['id'],
    'name' => ['name', 'name_de', 'name_fr', 'name_en', 'path', 'title', 'last_name', 'first_name', 'addition', 'street', 'city', 'country', 'language', 'type'],
    'text' => ['comment'],
    'number' => ['number', 'zip'],
    'password' => ['password'],
    'check' => ['partner'],
    'radio' => ['location_id', 'source_id'],
    'dropdown' => ['category_id', 'accessoryset_id', 'type_id', 'customer_id', 'state_id'],
    'date' => ['reserved_at', 'picked_at', 'return_until', 'returned_at', 'restocked_at'],
    'document' => ['document_id']
    ]
];

?>