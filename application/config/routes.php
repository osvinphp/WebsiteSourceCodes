<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Default Routes
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Session Routes
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

// Profile Routes
$route['profile/(:any)'] = 'profile/index/$1';