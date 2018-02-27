<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Building_block extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Load model
        $this->load->model('m_building_block');
    }

    public function getAll()
    {
        // Execute get function from model
        $query = $this->m_building_block->getAll();
//         echo "<pre>"; 
// print_r($query); die;
        // Return the result
        return $query;
    }

    public function count($where)
    {
        // Execute count function from model
        $query = $this->m_building_block->count($where);

        // Return the result
        return $query;
    }

    public function insert($data)
    {
        // Execute insert function from model
        $query = $this->m_building_block->insert($data);
        
        // Return the result
        return $query;
    }
}