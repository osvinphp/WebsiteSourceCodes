<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Module components            
        $this->data['module'] = 'Server';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);

        // Load model
        $this->load->model('m_server');
    }

    public function index()
    {
        // Page components
        $this->data['pageTitle'] = 'Server';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('serverList', $this->data, true);

        // Render page
        $this->renderPage();
    }

    public function getCpuUsage()
    {
        $results = [];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Run the analytic query
        $query = Modules::run('google/monitoring/getClientApi', 'cpu', (int) $start->getTimestamp(), (int) $end->getTimestamp());
        
        // Fetch query data
        foreach ($query as $key => $value) {
            $results['series'][] = array(
                'name' => $key,
                'data' => $value
            );
        }

        // Return the results
        return response($results);
    }

    public function getDiskUsage()
    {
        $results = [];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Run the analytic query
        $diskRead = Modules::run('google/monitoring/getClientApi', 'disk-read', (int) $start->getTimestamp(), (int) $end->getTimestamp());
        $diskWrite = Modules::run('google/monitoring/getClientApi', 'disk-write', (int) $start->getTimestamp(), (int) $end->getTimestamp());

        // Fetch query data
        foreach ($diskRead as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Read)',
                'data' => $value
            );
        }

        foreach ($diskWrite as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Write)',
                'data' => $value
            );
        }

        // Return the results
        return response($results);
    }

    public function getDiskOperationUsage()
    {
        $results = [];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Run the analytic query
        $diskRead = Modules::run('google/monitoring/getClientApi', 'disk-ops-read', (int) $start->getTimestamp(), (int) $end->getTimestamp());
        $diskWrite = Modules::run('google/monitoring/getClientApi', 'disk-ops-write', (int) $start->getTimestamp(), (int) $end->getTimestamp());

        // Fetch query data
        foreach ($diskRead as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Read)',
                'data' => $value
            );
        }

        foreach ($diskWrite as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Write)',
                'data' => $value
            );
        }

        // Return the results
        return response($results);
    }

    public function getNetworkBytes()
    {
        $results = [];
        
        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Run the analytic query
        $networkReceived = Modules::run('google/monitoring/getClientApi', 'network-bytes-received', (int) $start->getTimestamp(), (int) $end->getTimestamp());
        $networkSent = Modules::run('google/monitoring/getClientApi', 'network-bytes-sent', (int) $start->getTimestamp(), (int) $end->getTimestamp());

        // Fetch query data
        foreach ($networkReceived as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Received)',
                'data' => $value
            );
        }

        foreach ($networkSent as $key => $value) {
            $results['series'][] = array(
                'name' => $key . ' (Sent)',
                'data' => $value
            );
        }

        // Return the results
        return response($results);
    }

    public function getServerLogs()
    {
        // Get input values
        $pageToken = $this->input->get('pageToken');

        // Run the logging query
        $query = Modules::run('google/logging/getClientApi', $pageToken);

        // Return the results
        return response($query);
    }

}