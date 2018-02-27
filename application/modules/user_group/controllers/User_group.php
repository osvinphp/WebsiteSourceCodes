<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('m_user_group');
    }

    public function getAll()
    {
        // Execute get function from model
        $query = $this->m_user_group->getAll();

        // Return the result
        return $query;
    }

    public function count($where)
    {
        // Execute count function from model
        $query = $this->m_user_group->count($where);

        // Return the result
        return $query;
    }

}