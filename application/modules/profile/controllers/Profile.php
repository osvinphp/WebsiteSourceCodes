<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Profile extends BaseController {

        public function __construct()
        {
            parent::__construct();

            // Module components            
            $this->data['module']    = 'Profile';
            $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
            $this->data['pluginJs']  = $this->load->view('assets/_pluginJs', $this->data, true);
            
            $this->load->model('m_profile');
        }

        public function index($userId)
        {
            $user = Modules::run('user/getBy', 'objectId', $userId);

            if (!$user) show_404();
            
            // Page components
            $this->data['pageTitle'] = $user->firstName . '\'s Profile';
            $this->data['pageCss']   = $this->load->view('assets/_pageCss', $this->data, true);
            $this->data['pageJs']    = $this->load->view('assets/_pageJs', $this->data, true);
            $this->data['user']      = $user;
            $this->data['content']   = $this->load->view('myProfile', $this->data, true);

            // Render page
            $this->renderPage();
        }

        public function loadAvatarForm()
        {   
            // Check if ajax request
            $this->ajaxRequest();

            // Return the result to the view
            return response($this->load->view('profileAvatar', null, true), 'html');
        }

        public function cropAvatar()
        {
            // Check if ajax request
            $this->ajaxRequest();

            // Load cropper library
            $this->load->library('cropper');

            // Preparing the data before update
			$id             = $this->currentUser->id;
            $cropper_src    = $this->input->post('avatar_src');
            $cropper_data   = $this->input->post('avatar_data');
            $cropper_file   = $_FILES['avatar_file'];
            $cropper_config = array('url' => 'uploads/avatars/', 'prefix' => 'user_avatar_'.$this->currentUser->username.'_');
            
            // Execute crop function
            $crop = $this->cropper->run($cropper_src, $cropper_data, $cropper_file, $cropper_config);
            
            // Check if crop was success
            if ($crop['result']) {
                // Update user avatar
                $update = $this->m_profile->update($id, array('avatar' => $crop['filename']));
                $results = array('status' => true, 'action' => 'Success', 'message' => 'Avatar updated successfully');
            } else {
                $results = array('status' => false, 'action' => 'Failed', 'message' => $crop['message']);
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
			$id = $this->currentUser->id;
			
            foreach($this->input->post() as $key => $value) {
                
                if ($key == 'dob') $value = date_db($value);
                if ($key != 'action') $data[$key] = $value;
                
            }
			
            // Execute update function from model
            $query = $this->m_profile->update($id, $data);
            
            // Check if query was success
            if ($query) {
                $results = array('status' => true, 'action' => 'Success', 'message' => 'Profile updated successfully');
            } else {
                $results = array('status' => false, 'action' => 'Failed', 'message' => 'Failed to update Profile');
            }

            // Return the result to the view
            return response($results);
        }

        public function updatePassword()
        {
            // Check if ajax request
            $this->ajaxRequest();

            // Validate the submitted data
            $this->validateInput();

            // Preparing the data before update
			$id           = $this->currentUser->id;
			$email     = $this->currentUser->email;
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            
            // Check old password
            $change = $this->ion_auth->change_password($email, $old_password, $new_password);
            
            // if old password is correct
            if ($change) {
                $results = array('status' => true, 'action' => 'Success', 'message' => 'Password updated successfully');
            } else {
                $results = array('status' => false, 'action' => 'Failed', 'message' => 'Old password is incorrect');
            }

            // Return the result to the view
            return response($results);
        }

        public function validateInput()
        {
            // Load form validation library
            $this->load->library('form_validation');
            
            // Check form action
            switch ($this->input->post('action')) {

                // Set validation rules by action
                case 'update-thoughts':
                    $this->form_validation->set_rules('thoughts', 'Thoughts', 'trim|required');
                break;

                // Set validation rules by action
                case 'update-identity':
                    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                    $this->form_validation->set_rules('last_name', 'Last Name', 'trim');
                    $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
                    $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                break;

                // Set validation rules by action
                case 'update-contact':
                    $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
                break;

                case 'update-password':
                    $this->form_validation->set_rules('old_password','Old Password','required|min_length[6]');
                    $this->form_validation->set_rules('new_password','Password','required|min_length[6]');
                    $this->form_validation->set_rules('confirm_password','Password confirmation','required|matches[new_password]');
                break;

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

        public function get($orderBy = 'name')
        {
            $query = $this->m_groups->get($orderBy);
            return $query;
        }

    }
?>
