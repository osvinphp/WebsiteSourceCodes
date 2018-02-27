<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('m_role');
    }

    public function get()
    {
        // Execute get function from model
        $query = $this->m_role->get();
        
        // Return the result
        return $query;
    }
}