<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;

class PublicController extends MX_Controller
{
    public $currentUser;
    public $currentuserLevel;
    public $data = array();

    public function __construct()
    {
        parent::__construct();

        $this->data['module']    = '';
        $this->data['pluginCss'] = '';
        $this->data['pluginJs']  = '';
        $this->data['pageTitle'] = '';
        $this->data['pageCss']   = '';
        $this->data['pageJs']    = '';
        $this->data['content']   = '';
    }

    public function renderPage()
    {
        $this->load->view('layout/layout', $this->data);
    }

    public function ajaxRequest()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    }
}

class BaseController extends PublicController
{
    public function __construct()
    {
        parent::__construct();

        $this->currentUser = ParseUser::getCurrentUser();

        if (!$this->currentUser) {
            
            $referrer = base_url(uri_string());
            $params  = $_SERVER['QUERY_STRING'];
            $fullURL = ($params != '') ? $referrer . '?' . $params : $referrer ;
            $redirectUrl = ($fullURL == base_url()) ? '' : $fullURL;

            if ($redirectUrl)
                redirect('login?redirect=' . $redirectUrl);
            else 
                redirect('login');
                
        } 

        session_write_close();
        
    }

}

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
             
        if ($this->currentUserLevel !== 'Administrator') {
            redirect('dashboard');
        }
    }
}