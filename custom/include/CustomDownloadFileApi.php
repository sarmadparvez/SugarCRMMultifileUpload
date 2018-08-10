<?php

require_once('include/download_file.php');

/**
 * Override DownloadFileApi to handle special case for Documents
 *
 * @author Sarmad Parvez <sarmad.pervaiz@rolustech.com>
 */
class CustomDownloadFileApi extends DownloadFileApi
{
	 /**
     * This function makes sure the bean exists, the field exists in the bean and is the expected type
     *
     * @param SugarBean $bean The SugarBean to get the file for
     * @param string $field The field name to get the file for
     * @param string $type the type of the field
     * @return bool
     * @throws Exception
     */
    protected function validateBeanAndField($bean, $field, $type)
    {
        if (!$bean instanceof SugarBean || empty($bean->id) ||
        	(empty($bean->{$field}) && $bean->object_name != 'Document')
        ) {
            // @TODO Localize this exception message
            throw new Exception('Invalid SugarBean');
            return false;
        }
        if (!isset($bean->field_defs[$field])) {
            // @TODO Localize this exception message
            throw new Exception('Missing field definitions for ' . $field);
            return false;
        }
        if (!isset($bean->field_defs[$field]['type']) || $bean->field_defs[$field]['type'] != $type) {
            return false;
        }
        return true;
    }


    /**
     * Sends an HTTP response with the contents of the request file for download
     * Override to remove temporary zip file after downloading 
     *
     * @param boolean $forceDownload true if force to download the file
     * @param array $info Array containing the file details.
     * Currently supported:
     * - content-type - content type for the file
     *
     */
    public function outputFile($forceDownload, array $info)
    {
    	parent::outputFile($forceDownload, $info);

    	if (SugarAutoloader::fileExists($info['path'])) {
    		register_shutdown_function('unlink', $info['path']);
		}
    }
}