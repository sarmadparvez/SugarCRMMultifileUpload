<?php

$dictionary["documents_ids_temp"] = array(
    'table' => 'documents_ids_temp',
    'fields' =>
    array(
        array('name' => 'id', 'type' => 'char', 'len' => 36),
        array('name' => 'document_ids', 'type' => 'text'),
    ),
    'indices' =>
    array(
        array('name' => 'id_idx', 'type' => 'primary', 'fields' => array('id')),
    ),
);
