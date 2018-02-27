<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Building_block_type extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('m_building_block_type');
    }

    public function getAll()
    {
        // Execute get function from model
        $query = $this->m_building_block_type->getAll();

        // Return the result
        return $query;
    }

    public function count($where)
    {
        // Execute count function from model
        $query = $this->m_building_block_type->count($where);

        // Return the result
        return $query;
    }

}