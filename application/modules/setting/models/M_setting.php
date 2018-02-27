<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;

class M_setting
{
    public $results = array();

    public function get()
    {
        // Create parse query
        $setting = new ParseQuery('Settings');

        // Execute getAll
        $query = $setting->first(true);
        
        // Fetch query data
        $settings = $this->fetchData($query);

        // return the results
        return $settings;
    }

    public function getById($id)
    {
        // Create parse user query
        $table = ParseUser::query();

        // Apply query condition
        $table->equalTo('objectId', $id);

        // Execute the query
        $query = $table->first(true);
        
        // Fetch query data
        $this->results = (object) array(
            'id' => $query->getObjectId(),
            'firstName' => $query->get('firstName'),
            'lastName' => $query->get('lastName'),
            'username' => $query->get('username'),
            'email' => $query->get('email'),
            'phone' => $query->get('phone')
        );

        // return the results
        return $this->results;
    }

    public function update($data) 
    {
        // Create new parse query
        $settings = new ParseObject('Settings', $data->id);
        unset($data->id);

        // Update user data
        foreach ($data as $key => $value) {

            switch ($key) {
                case 'companyAddress':
                    $settings->setArray($key, $value);
                break;

                case 'invoiceTaxRate':
                case 'invoicePaymentTerms':
                    $settings->set($key, (int) $value);
                break;

                default: 
                    $settings->set($key, $value);
                break;

            }

        }

        // Save changes
        try {
            // Query success
            $settings->save(true);
            return true;

        } catch(ParseException $ex) {
            // Query failed
            return $ex->getMessage();
        }
    }

    public function fetchData($object)
    {
        if (!$object)
            return $object;
        
        return (object) array(
            'id' => $object->getObjectId(),
            'generalAdminEmail' => $object->get('generalAdminEmail'),
            'generalSiteTitle' => $object->get('generalSiteTitle'),
            'companyEmail' => $object->get('companyEmail'),
            'companyAddress' => $object->get('companyAddress'),
            'companyBusinessNumber' => $object->get('companyBusinessNumber'),
            'companyPhoneNumber' => $object->get('companyPhoneNumber'),
            'companyWebsite' => $object->get('companyWebsite'),
            'invoiceTaxCode' => $object->get('invoiceTaxCode'),
            'invoiceTaxRate' => $object->get('invoiceTaxRate'),
            'invoicePaymentTerms' => $object->get('invoicePaymentTerms'),
            'invoiceRemarks' => $object->get('invoiceRemarks'),
            'invoiceMercyForBusiness' => $object->get('invoiceMercyForBusiness'),
            'stripeDebugApiKey' => $object->get('stripeDebugApiKey'),
            'stripeDebugSecretKey' => $object->get('stripeDebugSecretKey'),
            'stripeLiveApiKey' => $object->get('stripeLiveApiKey'),
            'stripeLiveSecretKey' => $object->get('stripeLiveSecretKey'),
            'stripePaymentMode' => $object->get('stripePaymentMode'),
            'oneSignalApiKey' => $object->get('oneSignalApiKey'),
            'oneSignalAppId' => $object->get('oneSignalAppId'),
            'analyticServiceAccount' => $object->get('analyticServiceAccount')
        );
    }
}
