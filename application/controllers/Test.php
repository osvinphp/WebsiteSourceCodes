<?php defined('BASEPATH') OR exit('No direct script access allowed');
die;
// Load parse sdk
use Parse\ParseACL;
use Parse\ParseRole;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;
use Parse\ParseCloud;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Test extends MX_Controller 
{
	public function index()
    {
        $career = new ParseObject('_User', 'KqoY2wJpt7');
        debug_this($career->fetch()->getAllKeys());

        // $roleACL = new ParseACL();
        // $roleACL->setPublicReadAccess(true);
        // $role = ParseRole::createRole('User', $roleACL);
        // $role->save();

        // Get role object
        // $role = new ParseQuery('_Role');
        // $administrator = $role->equalTo('name', 'Administrator')->first();

        // Get settings object
        // $settings = new ParseObject('Settings', '9SypTQ9l5l');
        // $settingsACL = new ParseACL();
        // $settingsACL->setRoleWriteAccessWithName('Administrator', true);
        // $settings->setACL($settingsACL);
        // $settings->save();

        // debug_this($administrator);

        // $nafplann = new ParseObject('_User', 'rlBQpA3WqD');
        // $nafplann->fetch(true);
        
        // $role = new ParseQuery('_Role');
        // $administrator = $role->equalTo('name', 'Administrator')->first();
        
        // $administrator->getUsers()->add($nafplann);
        // $administrator->save(true);


        // $query = new ParseQuery('_User');
        // $users = $query->find();

        
        // foreach ($users as $row) {
            
        //     $usersACL = new ParseACL();
        //     $usersACL->setRoleWriteAccessWithName('Administrator', true);
        //     $usersACL->setPublicReadAccess(true);
        //     $usersACL->setUserReadAccess($row, true);
        //     $usersACL->setUserWriteAccess($row, true);

        //     $row->setACL($usersACL);
        //     $usersToUpdate[] = $row;

        // }

        // $saveUsers = new ParseObject('_Users');
        // $saveUsers->saveAll($usersToUpdate, true);
        
    }

}
