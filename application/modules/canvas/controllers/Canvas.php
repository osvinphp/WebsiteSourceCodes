<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Canvas extends BaseController {

    public function __construct()
    {
        parent::__construct();
        
        // Check if admin
        // $this->isAdmin();/
        
        $this->load->model('m_canvas');

        // Module components            
        $this->data['module'] = 'Canvas';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);
    }

    public function index()
    {

        // Page data
        $this->data['buildingBlocks'] = $this->getBuildingBlocks();
/*        echo "<pre>";

        print_r($this->data);

        die;*/
        $this->data['buildingBlockStatus'] = Modules::run('building_block_status/getAll');
        $this->data['users'] = Modules::run('user/getAll');
        $this->data['userGroups'] = Modules::run('user_group/getAll');

        // Page components
        $this->data['pageTitle'] = 'Expert User Interface';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('canvas', $this->data, true);

        
        // Render page
        $this->renderPage();
    }

    public function getBuildingBlocks()
    {
        $results = [];
        $buildingBlocks = Modules::run('building_block/getAll');
        
        // Group building blocks by its category
        foreach ($buildingBlocks as $buildingBlock) {
            
            $pathString = '';

            if (!empty($buildingBlock->svgIcon)) {
                $dom = new DomDocument;
                $dom->loadXML(file_get_contents($buildingBlock->svgIcon));
                $path = $dom->getElementsByTagName('path');
    
                foreach ($path as $row) {
                    $pathString .= $row->getAttribute('d');
                }
            }

            $buildingBlock->svgPathString = trim(preg_replace('/\s+/', '', $pathString));
            $results[$buildingBlock->systemItem][$buildingBlock->id] = $buildingBlock;
        }

        // Sort results by key name
        ksort($results);

        return $results;
    }

    public function getElementQuery()
    {
        $queryData = (object) $this->input->post();
        $query = $this->m_canvas->getElementQuery($queryData);
        
        return response($query);
    }

    public function saveMolecule()
    {
        // Preparing the data before insert to DB
        $svgIcon = $_FILES['svgIcon'];
        
        if (empty($svgIcon['tmp_name'])) {
            return response(array(
                'status' => false,
                'action' => 'Failed',
                'message' => 'SVG Icon is required'
            ));
        }

        // Get post data
        $moleculeData = (object) $this->input->post();
        $moleculeData->isMolecule = true;
        $moleculeData->svgIcon = $svgIcon;

        // Run insert query
        $query = Modules::run('building_block/insert', $moleculeData);

        // Check if query was success
        if ($query === true) {
            $results = array('status' => true, 'action' => 'Success', 'message' => 'Molecule added sucessfully');
        } else {
            $results = array('status' => false, 'action' => 'Failed', 'message' => $query);
        }

        // Return the result to the view
        return response($results);
    }


    /*push notification for ios common function*/
    public function iosPush($pushData=null) {
        echo "hello"; die;
    // print_r($pushData);
    $deviceToken = $pushData['token'];
    $passphrase = '';
    $ctx = stream_context_create();
    if($pushData['Utype'] == 1){
    stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/MoversPushDevelpoment.p12');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    }else if($pushData['Utype'] == 2){

    stream_context_set_option($ctx, 'ssl', 'local_cert', './certs/MoversPushDevelpoment.p12');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    }
    // Open a connection to the APNS server

    $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
   // if (!$fp) exit("Failed to connect: $err $errstr" . PHP_EOL);
  
         $body['aps'] = array(
        "message" =>$pushData['message'] ,
        "action" => $pushData['action'],
        'booking_id' => $pushData['booking_id'],
        'sound' => 'default'
    );

   
    
    }
}
