<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logging extends MX_Controller 
{
    public $client;
    public $projectId;

    public function __construct()
    {
        parent::__construct();
        
        $this->client = new Google_Client();
        $this->client->setAuthConfig(json_decode($_SESSION['siteConfigs']->get('analyticServiceAccount'), true));
        $this->client->addScope('https://www.googleapis.com/auth/cloud-platform');
        
        $this->projectId = 'lorien-analytics';
    }

    public function getClientApi($pageToken = null)
    {
        $logEntriesRequest = new Google_Service_Logging_ListLogEntriesRequest();
        $logEntriesRequest->setProjectIds($this->projectId);
        $logEntriesRequest->setOrderBy('timestamp desc');

        if ($pageToken)
            $logEntriesRequest->setPageToken($pageToken);

        $service = new Google_Service_Logging($this->client);
        $response = $service->entries->listEntries($logEntriesRequest);
        
        $logEntries = $response->getEntries();
        $logPageToken = $response->getNextPageToken();

        foreach ($logEntries as $row) {
            $textPayload = $row->getTextPayload();
            $insertId = $row->getInsertId();
            $instanceLabels = $row->getResource()->getLabels();
            $instanceId = (isset($instanceLabels['instance_id'])) ? $instanceLabels['instance_id'] : '';
            $instanceZone = (isset($instanceLabels['zone'])) ? $instanceLabels['zone'] : '';
            $instanceProjectId = (isset($instanceLabels['projectId'])) ? $instanceLabels['projectId'] : '';

            $resource = array(
                'type' => $row->getResource()->getType(),
                'labels' => array(
                    'instanceId' => $instanceId,
                    'zone' => $instanceZone,
                    'projectId' => $instanceProjectId
                )
            );
            $timeStamp = $row->getTimestamp();
            $labels = $row->getLabels();

            $results['entries'][] = array(
                'textPayload' => $textPayload,
                'insertId' => $insertId,
                'resource' => $resource,
                'timestamp' => $timeStamp,
                'labels' => $labels
            );
        }

        $results['pageToken'] = $logPageToken;
        
        return response($results);
    }
}