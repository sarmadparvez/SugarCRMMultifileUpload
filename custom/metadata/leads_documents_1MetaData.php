<?php
// created: 2018-08-02 20:25:17
$dictionary["leads_documents_1"] = array (
  'true_relationship_type' => 'many-to-many',
  'from_studio' => true,
  'relationships' => 
  array (
    'leads_documents_1' => 
    array (
      'lhs_module' => 'Leads',
      'lhs_table' => 'leads',
      'lhs_key' => 'id',
      'rhs_module' => 'Documents',
      'rhs_table' => 'documents',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'leads_documents_1_c',
      'join_key_lhs' => 'leads_documents_1leads_ida',
      'join_key_rhs' => 'leads_documents_1documents_idb',
    ),
  ),
  'table' => 'leads_documents_1_c',
  'fields' => 
  array (
    'id' => 
    array (
      'name' => 'id',
      'type' => 'id',
    ),
    'date_modified' => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    'deleted' => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'default' => 0,
    ),
    'leads_documents_1leads_ida' => 
    array (
      'name' => 'leads_documents_1leads_ida',
      'type' => 'id',
    ),
    'leads_documents_1documents_idb' => 
    array (
      'name' => 'leads_documents_1documents_idb',
      'type' => 'id',
    ),
    'document_revision_id' => 
    array (
      'name' => 'document_revision_id',
      'type' => 'id',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_leads_documents_1_pk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_leads_documents_1_ida1_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_documents_1leads_ida',
        1 => 'deleted',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_leads_documents_1_idb2_deleted',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'leads_documents_1documents_idb',
        1 => 'deleted',
      ),
    ),
    3 => 
    array (
      'name' => 'leads_documents_1_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'leads_documents_1leads_ida',
        1 => 'leads_documents_1documents_idb',
      ),
    ),
  ),
);