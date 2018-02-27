<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BaseController {

    public function __construct()
    {
        parent::__construct();
        
        // Check if admin
        // $this->isAdmin();/
        
        // Module components            
        $this->data['module'] = 'Dashboard';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);
    }

    public function index()
    {


        // Page components
        $this->data['pageTitle'] = 'Dashboard';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('dashboard', $this->data, true);
        
        // Render page
        $this->renderPage();
    }
}