<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Module components            
        $this->data['module'] = 'User';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);

        // Load model
        $this->load->model('m_user');
    }

    public function index()
    {
        // Page components
        $this->data['pageTitle'] = 'Users';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('userList', $this->data, true);

        // Render page
        $this->renderPage();
    }

    public function loadGrid()
    {
        // Check if ajax request
        $this->ajaxRequest();

        // Execute getGrid function from model
        $query = $this->m_user->getGrid();

        // Return the result to the view
        return response($query);
    }

    public function loadAddForm()
    {   
        // Check if ajax request
        $this->ajaxRequest();

        // Get related data
        $data['companies'] = Modules::run('public/company/getAll');
        $data['roles'] = Modules::run('role/get');
        
        // Return the result to the view
        return response($this->load->view('userAdd', $data, true), 'html');
    }

    public function loadEditForm()
    {   
        // Check if ajax request
        $this->ajaxRequest();

        // Get user data
        $id = $this->input->get('id', true);
        $query = $this->m_user->getById($id);
        
        if ($query) {
            
            // Set user data
            $data['user'] = $query;
            $data['companies'] = Modules::run('public/company/getAll');
            $data['roles'] = Modules::run('role/get');
            
            // Return the result to the view
            return response($this->load->view('userEdit', $data, true), 'html');
        }

        // Return 404 if data not found
        return show_404();
    }

    public function insert()
    {
        // Check if ajax request
        $this->ajaxRequest();

        // Validate the submitted data
        $this->validateInput();

        // Preparing the data before insert to DB
        $data = (object) $this->input->post();

        // Execute insert function from model
        $query = $this->m_user->insert($data);
        
        // Check if query was success
        if ($query === true) {
            $results = array('status' => true, 'action' => 'Success', 'message' => 'User added sucessfully');
        } else {
            $results = array('status' => false, 'action' => 'Failed', 'message' => $query);
        }

        // Return the result to the view
        return response($results);
    }

    public function update()
    {
        // Check if ajax request
        $this->ajaxRequest();

        // Validate the submitted data
        $this->validateInput();

        // Preparing the data before update
        $data = (object)$this->input->post();
        
        // Execute update function from model
        $query = $this->m_user->update($data);
        
        // Check if query was success
        if ($query === true) {
            $results = array('status' => true, 'action' => 'Success', 'message' => 'User updated sucessfully');
        } else {
            $results = array('status' => false, 'action' => 'Failed', 'message' => $query);
        }

        // Return the result to the view
        return response($results);
    }

    public function delete()
    {
        // Check if ajax request
        $this->ajaxRequest();

        // Get user id
        $id = $this->input->post('id');
        
        // Execute update function from model
        $query = $this->m_user->delete($id);
        
        // Check if query was success
        if ($query === true) {
            $results = array('status' => true, 'action' => 'Success', 'message' => 'User deleted sucessfully');
        } else {
            $results = array('status' => false, 'action' => 'Failed', 'message' => $query);
        }

        // Return the result to the view
        return response($results);
    }

    public function validateInput()
    {
        // Load form validation library
        $this->load->library('form_validation');

        // Set validation rules
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('role', 'Permission Level', 'trim|required');
        
        // If is editing user
        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        }

        // Run the validation
        if ($this->form_validation->run() === false) {

            $response = array(
                'status' => false,
                'action' => 'Failed',
                'message' => $this->form_validation->error_string('<h5>', '</h5>')
            );

            return response($response);

        }
    }

    public function countByDate($start, $end)
    {
        // Execute count function from model
        $query = $this->m_user->countByDate($start, $end);

        // Return the result
        return $query;
    }

    public function getAll($level = '')
    {
        // Execute get function from model
        $query = $this->m_user->getAll($level);

        // Return the result
        return $query;
    }

    public function getWhere($where)
    {
        // Execute getBy function from model
        $query = $this->m_user->getWhere($where);
        
        // Return the result
        return $query;
    }

    public function getBy($key, $value)
    {
        // Execute getBy function from model
        $query = $this->m_user->getBy($key, $value);

        // Return the result
        return $query;
    }

    public function getJoinDate($date)
    {
        // Execute get function from model
        $query = $this->m_user->getJoinDate($date);

        // Return the result
        return $query;
    }

    public function count($where)
    {
        // Execute count function from model
        $query = $this->m_user->count($where);

        // Return the result
        return $query;
    }
}