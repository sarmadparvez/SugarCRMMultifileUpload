<?php

$manifest = array(
    'acceptable_sugar_flavors' => array('ENT', 'ULT'),
    'acceptable_sugar_versions' => array(
        'exact_matches' => array(),
        'regex_matches' => array(
            '[7-8]\.*',
        ),
    ),
    'key' => 'rt',
    'author' => 'Rolustech',
    'description' => 'Adds a multiupload file field to Leads module. The uploaded files are added as documents.',
    'icon' => '',
    'is_uninstallable' => true,
    'name' => 'Multiupload documents Plugin',
    'published_date' => '2018-08-10 19:00:00',
    'type' => 'module',
    'version' => '1.0',
    'remove_tables' => 'prompt',
);
$installdefs = array(
    'id' => 'multiupload_documents_plugin_1.0.0',
    //copy files
    'copy' => array(
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/JSGroupings/addMultiFileUploadPlugin.php',
            'to' => 'custom/Extension/application/Ext/JSGroupings/addMultiFileUploadPlugin.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/TableDictionary/documents_ids_temp.php',
            'to' => 'custom/Extension/application/Ext/TableDictionary/documents_ids_temp.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/TableDictionary/leads_documents_1.php',
            'to' => 'custom/Extension/application/Ext/TableDictionary/leads_documents_1.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Layoutdefs/leads_documents_1_Documents.php',
            'to' => 'custom/Extension/modules/Documents/Ext/Layoutdefs/leads_documents_1_Documents.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Vardefs/leads_documents_1_Documents.php',
            'to' => 'custom/Extension/modules/Documents/Ext/Vardefs/leads_documents_1_Documents.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Leads/Ext/Vardefs/leads_documents_1_Leads.php',
            'to' => 'custom/Extension/modules/Leads/Ext/Vardefs/leads_documents_1_Leads.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Leads/Ext/clients/base/layouts/subpanels/leads_documents_1_Leads.php',
            'to' => 'custom/Extension/modules/Leads/Ext/clients/base/layouts/subpanels/leads_documents_1_Leads.php',
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Leads/Ext/clients/base/views/record/multifile-upload.php',
            'to' => 'custom/Extension/modules/Leads/Ext/clients/base/views/record/multifile-upload.php',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/api/DownloadDocumentsApi.php',
            'to' => 'custom/clients/base/api/DownloadDocumentsApi.php',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/fields/download-documents/download-documents.js',
            'to' => 'custom/clients/base/fields/download-documents/download-documents.js',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/fields/multifile-upload/detail.hbs',
            'to' => 'custom/clients/base/fields/multifile-upload/detail.hbs',
        ),
        array(
            'from' => '<basepath>/custom/clients/base/fields/multifile-upload/multifile-upload.js',
            'to' => 'custom/clients/base/fields/multifile-upload/multifile-upload.js',
        ),
        array(
            'from' => '<basepath>/custom/include/CustomDownloadFileApi.php',
            'to' => 'custom/include/CustomDownloadFileApi.php',
        ),
        array(
            'from' => '<basepath>/custom/javascript/jquery-file-upload/jquery.fileupload.js',
            'to' => 'custom/javascript/jquery-file-upload/jquery.fileupload.js',
        ),
        array(
            'from' => '<basepath>/custom/javascript/jquery-file-upload/jquery.iframe-transport.js',
            'to' => 'custom/javascript/jquery-file-upload/jquery.iframe-transport.js',
        ),
        array(
            'from' => '<basepath>/custom/javascript/jquery-file-upload/jquery.ui.widget.js',
            'to' => 'custom/javascript/jquery-file-upload/jquery.ui.widget.js',
        ),
        array(
            'from' => '<basepath>/custom/metadata/documents_ids_temp.php',
            'to' => 'custom/metadata/documents_ids_temp.php',
        ),
        array(
            'from' => '<basepath>/custom/metadata/leads_documents_1MetaData.php',
            'to' => 'custom/metadata/leads_documents_1MetaData.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/Documents/clients/base/api/CustomDocumentsFileApi.php',
            'to' => 'custom/modules/Documents/clients/base/api/CustomDocumentsFileApi.php',
        ),
        array(
            'from' => '<basepath>/custom/modules/Documents/clients/base/views/subpanel-list-multi/subpanel-list-multi.php',
            'to' => 'custom/modules/Documents/clients/base/views/subpanel-list-multi/subpanel-list-multi.php',
        )
    ),
    'language' => array(
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/Language/en_us.custom_lang.php',
            'to_module' => 'application',
            'language' => 'en_us'
        ),
        array(
            'from' => '<basepath>/custom/Extension/application/Ext/Language/en_UK.custom_lang.php',
            'to_module' => 'application',
            'language' => 'en_UK'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Language/en_UK.custom_lang.php',
            'to_module' => 'Documents',
            'language' => 'en_UK'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Language/en_us.custom_lang.php',
            'to_module' => 'Documents',
            'language' => 'en_us'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Language/en_UK.customleads_documents_1.php',
            'to_module' => 'Documents',
            'language' => 'en_UK'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Documents/Ext/Language/en_us.customleads_documents_1.php',
            'to_module' => 'Documents',
            'language' => 'en_us'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Leads/Ext/Language/en_UK.customleads_documents_1.php',
            'to_module' => 'Leads',
            'language' => 'en_UK'
        ),
        array(
            'from' => '<basepath>/custom/Extension/modules/Leads/Ext/Language/en_us.customleads_documents_1.php',
            'to_module' => 'Leads',
            'language' => 'en_us'
        ),
    )
);
