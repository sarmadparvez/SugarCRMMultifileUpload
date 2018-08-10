<?php
require_once('custom/include/CustomDownloadFileApi.php');

/**
 * Download multiple files from documents
 *
 * @author Sarmad Parvez <sarmad.pervaiz@rolustech.com>
 */
class DownloadDocumentsApi extends SugarApi
{
    /**
     * Dictionary registration method, called when the API definition is built
     *
     * @return array
     */
    public function registerApiRest() {
        return array(
            'downloadDocuments' => array(
                'reqType' => 'GET',
                'path' => array('downloadDocuments'),
                'pathVars' => array(''),
                'method' => 'downloadDocuments',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'shortHelp' => 'Download files from documents module'
            ),
            'storeRecordIds' => array(
                'reqType' => 'POST',
                'path' => array('storeRecordIds'),
                'pathVars' => array(''),
                'method' => 'storeRecordIds',
                'shortHelp' => 'Store document ids in a table',
            )
        );
    }

    /**
     * Store record ids in database
     *
     * @param ServiceBase $api  The service base
     * @param array       $args Arguments array built by the service base
     *
     * @throws SugarApiExceptionMissingParameter
     * @return array
     */
    public function storeRecordIds(ServiceBase $api, array $args)
    {
        $this->requireArgs($args, array('record_ids'));

        $ids = json_encode($args['record_ids']);
        $guid = create_guid();

        $db = DBManagerFactory::getInstance();
        $sql = "INSERT INTO documents_ids_temp (id, document_ids) values (?, ?)";
        $db->getConnection()->executeQuery($sql, array($guid, $ids));
        return array('id' => $guid);
    }
    /**
     * Download documents
     *
     * @param ServiceBase $api  The service base
     * @param array       $args Arguments array built by the service base
     *
     * @throws SugarApiExceptionMissingParameter
     */
    public function downloadDocuments(ServiceBase $api, array $args)
    {
        $args['force_download'] = 1;

        $this->requireArgs($args, array('temp_id'));
        $db = DBManagerFactory::getInstance();
        // get document ids from table
        $sql = "SELECT document_ids from documents_ids_temp where id = ?";
        $stmt = $db->getConnection()->executeQuery($sql, array($args['temp_id']));
        $result = $stmt->fetch();
        
        if (empty($result)) {
            throw new SugarApiExceptionNotFound(
                'Unable to find record ' . $args['temp_id'] . ' in documents_ids_temp table'
            );
        }
       $doc_ids = json_decode($result['document_ids'], true);

        // get Documents beans from ids
        $document_bean = BeanFactory::newBean('Documents');
        $query = new SugarQuery();
        $query->from($document_bean, array('team_security' => false));
        $query->where()->in('id', $doc_ids);

        $document_beans = $document_bean->fetchFromQuery($query);

        $download = $this->getCustomDownloadFileApi($api);
       
        try{
            $download->getArchive(
                $document_beans,
                'filename',
                empty($args['zip_name']) ? 'documents' : $args['zip_name']
            );
            $sql = "DELETE from documents_ids_temp where id = ?";
            $db->getConnection()->executeQuery($sql, array($args['temp_id']));

        } catch (Exception $e) {
            throw new SugarApiExceptionNotFound($e->getMessage(), null, null, 0, $e);
        }
    }

    /**
     * Gets the CustomDownloadFileApi object for api.
     *
     * @param ServiceBase $api Api.
     * @return CustomDownloadFileApi
     */
    protected function getCustomDownloadFileApi(ServiceBase $api)
    {
        return new CustomDownloadFileApi($api);
    }
}
