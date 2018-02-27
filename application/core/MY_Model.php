<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseUser;

class MY_Model extends CI_Model 
{
    public $currentUser; 

    public function __construct()
    {
        $this->currentUser = ParseUser::getCurrentUser();
    }
}