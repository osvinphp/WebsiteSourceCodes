<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Check if admin
        // $this->isAdmin();
        
        // Module components            
        $this->data['module'] = 'Setting';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);

    //     // Load model
        $this->load->model('m_setting');
    }

    public function index()
    {
        // Settings data
        $this->data['settings'] = $this->get();
        
        // Page components
        $this->data['pageTitle'] = 'Settings';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('settings', $this->data, true);

        // Render page
        $this->renderPage();
    }

    public function update()
    {
        // Check if ajax request
        // $this->ajaxRequest();

        // Validate the submitted data
        $this->validateInput();

        // Preparing the data before update
        $data = (object) $this->input->post();
        
        // Execute update function from model
        $query = $this->m_setting->update($data);
        
        // Check if query was success
        if ($query === true) {
            $results = array('status' => true, 'action' => 'Success', 'message' => 'Settings updated sucessfully');
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
        $this->form_validation->set_rules('generalAdminEmail', 'General - Admin Email', 'trim|required');
        $this->form_validation->set_rules('generalSiteTitle', 'General - Site Title', 'trim|required');
        // $this->form_validation->set_rules('companyEmail', 'Company - Email', 'trim|required');
        // $this->form_validation->set_rules('companyAddress[]', 'Company - Address', 'trim|required');
        // $this->form_validation->set_rules('companyPhoneNumber', 'Company - Phone Number', 'trim|required');
        // $this->form_validation->set_rules('invoiceTaxCode', 'Invoice - Tax Code', 'trim|required');
        // $this->form_validation->set_rules('invoiceTaxRate', 'Invoice - Tax Rate', 'trim|required');
        // $this->form_validation->set_rules('invoicePaymentTerms', 'Invoice - Payment Terms', 'trim|required');
        // $this->form_validation->set_rules('invoiceRemarks', 'Invoice - Remarks', 'trim|required');
        // $this->form_validation->set_rules('invoiceMercyForBusiness', 'Invoice - Mercy For Your Business', 'trim|required');
        // $this->form_validation->set_rules('stripeDebugApiKey', 'Stripe - Debug API Key', 'trim|required');
        // $this->form_validation->set_rules('stripeDebugSecretKey', 'Stripe - Debug Secret Key', 'trim|required');
        // $this->form_validation->set_rules('stripeLiveApiKey', 'Stripe - Live API Key', 'trim|required');
        // $this->form_validation->set_rules('stripeLiveSecretKey', 'Stripe - Live Secret Key', 'trim|required');
        // $this->form_validation->set_rules('stripePaymentMode', 'Stripe - Payment Mode', 'trim|required');
        // $this->form_validation->set_rules('oneSignalApiKey', 'OneSignal - API Key', 'trim|required');
        // $this->form_validation->set_rules('oneSignalAppId', 'OneSignal - App ID', 'trim|required');
        // $this->form_validation->set_rules('analyticServiceAccount', 'Google Analytics - Service Account', 'trim|required');

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

    public function get()
    {
        // Execute get function from model
        $query = $this->m_setting->get();
        
        // Return the result
        return $query;
    }
}