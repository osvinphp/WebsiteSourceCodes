<?php defined('BASEPATH') OR exit('No direct script access allowed');

// load Parse library
use Parse\ParseClient;
use Parse\ParseSessionStorage;

class Parse
{
    public function __construct()
    {
        $sesionLifeTime = 43200;
        session_set_cookie_params($sesionLifeTime);
        session_start();
        ParseClient::initialize(PARSE_APP_ID, PARSE_REST_KEY, PARSE_MASTER_KEY);
        ParseClient::setServerURL(PARSE_SERVER_URL, 'parse-dev');
        ParseClient::setStorage(new ParseSessionStorage());
    }
}
