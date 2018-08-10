<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * API Class to handle file and image (attachment) interactions with a field in
 * a record.
 * @author Sarmad Parvez <sarmad.pervaiz@rolustech.com>
 */
class CustomDocumentsFileApi extends DocumentsFileApi {
    /**
     * Dictionary registration method, called when the API definition is built
     *
     * @return array
     */
    public function registerApiRest() {
        return array(
            'saveFilePost' => array(
                'reqType' => 'POST',
                'path' => array('Documents', 'new_record', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'saveFilePost',
                'rawPostContents' => true,
                'shortHelp' => 'Saves a file. The file can be a new file or a file override.',
                'longHelp' => 'include/api/help/module_record_file_field_post_help.html',
                'extraScore' => 0.25
            ),
            'saveFilePut' => array(
                'reqType' => 'PUT',
                'path' => array('Documents', '?', 'file', '?'),
                'pathVars' => array('module', 'record', '', 'field'),
                'method' => 'saveFilePut',
                'rawPostContents' => true,
                'shortHelp' => 'Saves a file. The file can be a new file or a file override. (This is an alias of the POST method save.)',
                'longHelp' => 'include/api/help/module_record_file_field_put_help.html',
            ),
        );
    }

    /**
     * Saves a file to a module field using the POST method
     *
     * @overide
     * @param ServiceBase $api The service base
     * @param array $args Arguments array built by the service base
     * @param bool $temporary true if we are saving a temporary image
     * @return array
     * @throws SugarApiExceptionError
     */
    public function saveFilePost(ServiceBase $api, array $args, $temporary = false)
    {
        if ($args['record']=='new_record' && empty($_FILES['filename'])) {
            throw new SugarApiExceptionInvalidParameter("Unable to upload file");
        }
        // create document first
        if (
            $args['record'] == 'new_record' && 
            !empty($_REQUEST['parent_id']) &&
            !empty($_REQUEST['parent_module'])
            ) {
            $doc = BeanFactory::newBean($args['module']);
            // check acl first
            if (!$doc->ACLAccess('save', array('source' => 'module_api'))) {
                // No create access so we construct an error message and throw the exception
                $moduleName = null;
                if(isset($args['module'])){
                    $failed_module_strings = 
                        return_module_language($GLOBALS['current_language'], $args['module']);
                    $moduleName = $failed_module_strings['LBL_MODULE_NAME'];
                }
                $args = null;
                if(!empty($moduleName)){
                    $args = array('moduleName' => $moduleName);
                }
                throw new SugarApiExceptionNotAuthorized('EXCEPTION_CREATE_MODULE_NOT_AUTHORIZED', $args);
            }

            // check relationship with parent module
            $rel = SugarRelationshipFactory::getInstance()->getRelationshipsBetweenModules(
                'Documents',
                $_REQUEST['parent_module']
            );
            if (empty($rel)) {
                throw new SugarApiExceptionNotFound(
                    'Could not find a relationship with Documents module'
                ); 
            }
            // get link field name
            $link_name = $this->getLinkNameFromRelationship($doc, $rel[0]);
            if (!$link_name) {
                throw new SugarApiExceptionNotFound(
                    'Could not find link field for relationship ' . $rel[0] . ' in Documents module'
                );
            }

            $doc->id = create_guid();
            $args['record'] = $doc->id;
            $doc->new_with_id = true;
            $doc->document_name = $_FILES['filename']['name'];
            $doc->save();
            
            // add relationship with parent module
            if ($doc->load_relationship($link_name)) {
                $doc->$link_name->add($_REQUEST['parent_id']);
            } else {
                // The relationship did not load.
                throw new SugarApiExceptionNotFound(
                    'Could not load relationship: ' . $link_name
                ); 
            }
        }
        try {
            return parent::saveFilePost($api, $args, $temporary);
        }
        catch (Exception $e) {
            // if exception occured, it means file is not uploaded, delete the documet bean
            if (isset($doc)) {
                $doc->mark_deleted($doc->id);
            }  
            throw $e;
        }
    }

    /**
    * Get link field name from relationship
    * @param SugarBean $bean bean to find link in
    * @param sting $rel_name
    */
    protected function getLinkNameFromRelationship(SugarBean $bean, $rel_name = '')
    {
        // if link name is same as relationship name
        if (
            isset($bean->field_defs[$rel_name]) &&
            $bean->field_defs[$rel_name]['type'] == 'link' &&
            $bean->field_defs[$rel_name]['relationship'] == $rel_name
            ) {
            return $rel_name;
        }

        // loop through field definition to find link name
        foreach ($bean->field_defs as $field_name => $def) {
            if (
                isset($def['relationship']) &&
                $def['relationship'] == $rel_name &&
                isset($def['type']) &&
                $def['type'] == 'link'
                ){
                return $def['name'];
            }
        }
        return false;
    }
}
