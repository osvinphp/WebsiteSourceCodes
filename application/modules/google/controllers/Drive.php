<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Drive extends MX_Controller 
{
    public $client;
    public $projectId;

    public function __construct()
    {
        parent::__construct();
        
        $this->client = new Google_Client();
        $this->client->setAuthConfig(json_decode($_SESSION['siteConfigs']->get('analyticServiceAccount'), true));
        $this->client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
        
        $this->projectId = 'projects/lorien-analytics';
    }

    public function index()
    {
        $service = new Google_Service_Drive($this->client);
        $optParams = [
            'pageSize' => 10,
            'fields' => 'nextPageToken, files(id, name)'
        ];
        $results = $service->files->listFiles($optParams);
        debug_this($results->getFiles());
        if (count($results->getFiles()) == 0) {
            echo 'No files found.';
        } else {
            echo 'Files: \n';
            foreach ($results->getFiles() as $file) {
                printf("%s (%s)\n", $file->getName(), $file->getId());
            }
        }
    }
}