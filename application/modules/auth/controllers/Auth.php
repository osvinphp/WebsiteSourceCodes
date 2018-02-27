<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseException;

class Auth extends PublicController {

    public function __construct() 
    {
        parent::__construct();
    }

    public function login()
    {
        $currentUser = ParseUser::getCurrentUser();
        
        if ($currentUser) 
            redirect('/');
        else 
            $this->getConfigs();
        
        $this->load->view('layout/login');
    }

    public function logout()
    {
        ParseUser::logOut();
        redirect('/');
    }

    public function checkLogin()
    {
        // Check if ajax request
        $this->ajaxRequest();

        // Get form data
        $identity = $this->input->post('identity');
        $password = $this->input->post('password');
        $remember = (bool) (!$this->input->post('remember')) ? 0 : 1;
            
        try {
            // Logging the user
            $login = ParseUser::logIn($identity, $password);
            $user = ParseUser::getCurrentUser();

            // Create role query
            $role = new ParseQuery('_Role');
            $role->containedIn('users', [$user]);

            // Get user Role
            $userRole = $role->first();
            $userRoleName = $userRole->get('name');
            
            // Set session expiration time
            $sesionLifeTime = 43200;
            session_set_cookie_params($sesionLifeTime);

            // Set user role
            $_SESSION['parseData']['user']->roleName = $userRoleName;

            // Set configs
            $_SESSION['siteConfigs'] = $this->getConfigs();

            return response(array('status' => true));
       
        } catch (ParseException $error) {
            return response(array('status' => false));
        }            
    }

    public function getConfigs()
    {
        $settings = new ParseQuery('Settings');
        $settings = $settings->first();

        if (!empty(array($settings))) {
            /*
            |--------------------------------------------------------------------------
            | General Constant
            |--------------------------------------------------------------------------
            |
            */
            define('GENERAL_ADMIN_EMAIL', $settings->get('generalAdminEmail'));
            define('GENERAL_SITE_TITLE', $settings->get('generalSiteTitle'));

            /*
            |--------------------------------------------------------------------------
            | Company Constant
            |--------------------------------------------------------------------------
            |
            */
            define('COMPANY_EMAIL', $settings->get('companyEmail'));
            define('COMPANY_ADDRESS', $settings->get('companyAddress'));
            define('COMPANY_BUSINESS_NUMBER', $settings->get('companyBusinessNumber'));
            define('COMPANY_PHONE_NUMBER', $settings->get('companyPhoneNumber'));
            define('COMPANY_WEBSITE', $settings->get('companyWebsite'));

            /*
            |--------------------------------------------------------------------------
            | Company Constant
            |--------------------------------------------------------------------------
            |
            */
            define('INVOICE_TAX_CODE', $settings->get('invoiceTaxCode'));
            define('INVOICE_TAX_RATE', $settings->get('invoiceTaxRate'));
            define('INVOICE_PAYMENT_TERMS', $settings->get('invoicePaymentTerms'));
            define('INVOICE_REMARKS', $settings->get('invoiceRemarks'));
            define('INVOICE_MERCY_FOR_BUSINESS', $settings->get('invoiceMercyForBusiness'));

            /*
            |--------------------------------------------------------------------------
            | Stripe Constant
            |--------------------------------------------------------------------------
            |
            */
            define('STRIPE_DEBUG_API_KEY', $settings->get('stripeDebugApiKey'));
            define('STRIPE_DEBUG_SECRET_KEY', $settings->get('stripeDebugSecretKey'));
            define('STRIPE_LIVE_API_KEY', $settings->get('stripeLiveApiKey'));
            define('STRIPE_LIVE_SECRET_KEY', $settings->get('stripeLiveSecretKey'));
            define('STRIPE_PAYMENT_MODE', $settings->get('stripePaymentMode'));

            /*
            |--------------------------------------------------------------------------
            | OneSignal Constant
            |--------------------------------------------------------------------------
            |
            */
            define('ONESIGNAL_API_KEY', $settings->get('oneSignalApiKey'));
            define('ONESIGNAL_APP_ID', $settings->get('oneSignalAppId'));

            /*
            |--------------------------------------------------------------------------
            | Google Analytic Constant
            |--------------------------------------------------------------------------
            |
            */
            define('ANALYTIC_SERVICE_ACCOUNT', $settings->get('analyticServiceAccount'));
        }

        return $settings;
        
    }
}