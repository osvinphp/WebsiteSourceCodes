<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseACL;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;

class M_user extends CI_Model
{
    public $results = array();

    public function getACL()
    {
        $usersACL = new ParseACL();
        $usersACL->setRoleWriteAccessWithName('Administrator', true);
        $usersACL->setPublicReadAccess(true);

        return $usersACL;
    }

    public function getAll($level)
    {
        // Create parse user query
        $table = new ParseQuery('_User');
        $numRows = $this->count([]);

        if ($level) {
            $userLevel = new ParseQuery('UserLevel');
            $userLevel->equalTo('levelName', $level);

            $numRows = new ParseQuery('_User');
            $numRows->matchesQuery('userLevel', $userLevel);
            $numRows = $numRows->count(true);
        }

        // If numRows is higher than 1000
        if ($numRows > 1000)
        {
            set_time_limit(0);
	        ini_set('memory_limit', '512M');

            $results = array();
            $queryLoop = ceil($numRows / 1000);
            $createdAt = null;

            for ($i = 1; $i <= $queryLoop; $i++)
            {
                // Create parse user query
                $table = new ParseQuery('_User');
                
                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                if ($level) $table->matchesQuery('userLevel', $userLevel);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $users = $table->find(true);

                // Merge user array
                $results = array_merge($results, $users);
                
                // Set last createdAt
                $createdAt = end($users)->getCreatedAt();
            }

        } 
        else 
        {
            // Apply query condition
            if ($level) $table->matchesQuery('userLevel', $userLevel);
            $table->descending('createdAt');
            $table->limit(1000);
            
            // Execute the query
            $results = $table->find(true);
        }

        // return the results
        return $this->fetchResults($results);
    }

    public function getBy($key, $value)
    {
        // Create parse user query
        $table = ParseUser::query();

        // Apply query condition
        $table->equalTo($key, $value);

        // Execute the query
        $query = $table->first(true);

        // Fetch query data
        $results = array(
            'id' => $query->getObjectId(),
            'fullName' => $query->get('fullName'),
            'firstName' => $query->get('firstName'),
            'lastName' => $query->get('lastName'),
            'gender' => $query->get('gender'),
            'emailVerified' => $query->get('emailVerified'),
            'saveMedia' => $query->get('saveMedia'),
            'userScore' => $query->get('userScore'),
            'commentNotifications' => $query->get('commentNotifications'),
            'oneSignalId' => $query->get('oneSignalId'),
            'privateAccount' => $query->get('privateAccount'),
            'forbiddenWords' => $query->get('forbiddenWords'),
            'profilePicture' => fetch_user_avatar($query),
            'followNotifications' => $query->get('followNotifications'),
            'bioString' => $query->get('bioString'),
            'dateOfBirth' => $query->get('dateOfBirth'),
            'company' => $query->get('company'),
            'name' => $query->get('name'),
            'username' => $query->get('username'),
            'email' => $query->get('email'),
            'phoneNumber' => $query->get('phoneNumber'),
            'messageNotifications' => $query->get('messageNotifications'),
            'userLevel' => ($query->get('userLevel')) ? $query->get('userLevel')->getObjectId() : null,
            'createdAt' => $query->getCreatedAt()->format('Y-m-d H:i:s')
        );
        
        // return the results
        return (object) $results;
    }

    public function getById($id)
    {
        // Create parse user query
        $table = ParseUser::query();

        // Apply query condition
        $table->equalTo('objectId', $id);
        $table->includeKey('company');

        // Execute the query
        $query = $table->first(true);
        
        // Fetch query data
        $this->results = $this->fetchData($query);
        
        // return the results
        return (object) $this->results;
    }

    public function getWhere($where)
    {
        // Create parse user query
        $table = ParseUser::query();

        // Apply query condition
        foreach($where as $key => $value)
        {
            $table->equalTo($key, $value);
        }

        // Execute the query
        $query = $table->find(true);

        // Fetch query data
        $results = $this->fetchResults($query);

        // return the results
        return (object) $results;
    }

    public function insert($data) 
    {
        // Create new parse user object
        $user = new ParseObject('_User');
        
        // Create user ACL
        $userACL = $this->getACL();

        // Set the new user data
        foreach ($data as $key => $value) {

            if (empty($value))
                continue;

            switch ($key) {

                case 'company':
                    $company = new ParseObject('Company', $value);
                    $user->set($key, $company);
                break;

                default: 
                    $user->set($key, $value);
                break;

            }

        }

        // Set user ACL
        $user->setACL($userACL);

        // Execute the query
        try {
            
            // Save user
            $user->save(true);
            
            // Get selected role
            $role = new ParseQuery('_Role');
            $userRole = $role->equalTo('name', $data->role)->first(true);
            
            // Add user to role
            $userRole->getUsers()->add($user);
            $userRole->save(true);
            
            return true;

        } catch(ParseException $ex) {
            // Query failed
            return $ex->getMessage();
        }
    }

    public function update($data) 
    {
        // Create new parse query
        $query = new ParseQuery('_User');
        $query->equalTo('objectId', clean_input($data->id));
        
        // Remove id props
        unset($data->id);

        // Execute user query
        $user = $query->first(true);
        
        // Update user data
        foreach ($data as $key => $value) {
            
            if (empty($value))
                continue;

            switch ($key) {

                case 'company':
                    $company = new ParseObject('Company', $value);
                    $user->set($key, $company);
                break;

                default: 
                    $user->set($key, $value);
                break;

            }

        }

        // Save changes
        try {
            
            // Save user
            $user->save(true);
            
            // Create role query
            $role = new ParseQuery('_Role');
            $role->containedIn('users', [$user]);

            // Get user Role
            $oldRole = $role->first(true);
            $oldRoleName = ($oldRole) ? $oldRole->get('name') : '';

            if ($oldRoleName !== $data->role) {

                if ($oldRole) {
                    // Remove user from old role
                    $oldRole->getUsers()->remove($user);
                    $oldRole->save(true);
                }

                // Get selected role
                $role = new ParseQuery('_Role');
                $userRole = $role->equalTo('name', $data->role)->first(true);
                
                // Add user to new role
                $userRole->getUsers()->add($user);
                $userRole->save(true);
            }

            return true;

        } catch(ParseException $ex) {
            // Query failed
            return $ex->getMessage();
        }
    }

    public function delete($id) 
    {
        // Create new parse query
        $query = new ParseQuery('_User');
        $query->equalTo('objectId', clean_input($id));
        
        // Execute user query
        $user = $query->first(true);

        // Delete user
        try {
            // Delete success
            $user->destroy(true);
            return true;

        } catch(ParseException $ex) {
            // Delete failed
            return $ex->getMessage();
        }
    }

    public function getGrid()
    {
        // Initialize bootgrid data
        $current = $this->input->get('current');
        $rowCount = $this->input->get('rowCount');
        $sort = key($this->input->get('sort'));
        $sortMode = $this->input->get('sort')[$sort];
        $searchPhrase = $this->input->get('searchPhrase');
        $rows = array();

        // Create parse user query
        $table = ParseUser::query();
        $table->includeKey('company');

        $total = ParseUser::query()->count(true);

        // If limit is set
        if (!$searchPhrase) {
            $table->limit($rowCount);
            $table->skip(($current - 1) * $rowCount);
        } else {
            $table->limit(1000);
        }

        // Sort query data
        if ($sortMode === 'asc') $table->ascending($sort);
        else $table->descending($sort);

        // Execute the query
        $users = $table->find(true);
        
        // Fetch query data
        $rows = $this->fetchResults($users);

        // If search box is not empty
        if ($searchPhrase)
        {
            $compare_data = array('id', 'firstName', 'lastName', 'username', 'email');
            $rows = custom_search_array($rows, $searchPhrase, $compare_data);
            $total = count($rows);

            $rowCount = ($rowCount <= 0) ? 10 : $rowCount;
            $pages = array_chunk($rows, $rowCount, TRUE);
            $rows = isset($pages[$current - 1]) ? $pages[$current - 1] : [];
            $rows = remove_keys($rows);

            // Return the results
            $results = array(
                'current' => (int)$current,
                'rowCount' => (int)$rowCount,
                'rows' => $rows,
                'total' => $total
            );

            return $results;
        }

        // Return the results
        $results = array(
            'current' => (int)$current,
            'rowCount' => (int)$rowCount,
            'rows' => $rows,
            'total' => $total
        );

        return $results;
    }

    public function count($where)
    {
        $query = new ParseQuery('_User');

        if (!empty($where)) {
            
            foreach ($where as $key => $value) {
                
                switch ($key) {

                    case 'userManager':
                        $user = new ParseObject('_User', $value);
                        $query->equalTo($key, $user);
                    break;

                    default: 
                        $query->equalTo($key, $value);
                    break;

                }
            } 

        }

        $numRows = $query->count(true);

        return $numRows;
    }

    public function countByDate($from, $to)
    {
        $start = new DateTime($from . ' 00:00:00');
        $end = new DateTime($to . ' 23:59:59');

        $query = new ParseQuery('_User');
        $query->greaterThanOrEqualTo('createdAt', $start);
        $query->lessThanOrEqualTo('createdAt', $end);

        $numRows = $query->count(true);
        return $numRows;
    }

    public function getJoinDate($date)
    {
        $start = new DateTime($date . ' 00:00:00');
        $end = new DateTime($date . ' 23:59:59');

        // Create parse user query
        $table = ParseUser::query();

        $table->greaterThanOrEqualTo('createdAt', $start);
        $table->lessThanOrEqualTo('createdAt', $end);

        $numRows = $table->count(true);

        // If numRows is higher than 1000
        if ($numRows > 1000)
        {
            set_time_limit(0);
	        ini_set('memory_limit', '512M');

            $data = array();
            $queryLoop = ceil($numRows / 1000);
            $createdAt = null;

            for ($i = 1; $i <= $queryLoop; $i++)
            {
                // Create parse user query
                $table = ParseUser::query();
                
                $table->greaterThanOrEqualTo('createdAt', $start);
                $table->lessThanOrEqualTo('createdAt', $end);

                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $users = $table->find(true);

                // Merge user array
                $results = array_merge($data, $users);
                
                // Set last createdAt
                $createdAt = end($users)->getCreatedAt();
            }

        } 
        else 
        {
            // Create parse user query
            $table = ParseUser::query();
            $table->greaterThanOrEqualTo('createdAt', $start);
            $table->lessThanOrEqualTo('createdAt', $end);

            // Apply query condition
            $table->descending('createdAt');
            $table->limit(1000);
            
            // Execute the query
            $data = $table->find(true);
        }

        $this->results = $this->fetchResults($data);

        // return the results
        return $this->results;
    }

    public function fetchResults($data)
    {
        $results = array();
        
        foreach($data as $row)
        {
            $results[$row->getObjectId()] = $this->fetchData($row);
        }

        return $results;
    }

    public function fetchData($object)
    {
        // Create role query
        $role = new ParseQuery('_Role');
        $role->containedIn('users', [$object]);

        // Get user Role
        $userRole = $role->first(true);
        $userRoleName = ($userRole) ? $userRole->get('name') : '';

        // Get user age
        $dob = $object->get('dateOfBirth');
        $age = ($dob) ? (date('Y') - $dob->format('Y')) : '0';

        return (object) array(
            'id' => $object->getObjectId(),
            'firstName' => $object->get('firstName'),
            'lastName' => $object->get('lastName'),
            'fullName' => $object->get('firstName') . ' ' . $object->get('lastName'),
            'username' => $object->get('username'),
            'email' => $object->get('email'),
            'phoneNumber' => $object->get('phoneNumber'),
            'userRole' => $userRoleName,
            'age' => $age,
            'gender' => $object->get('gender'),
            'location' => $object->get('location'),
            'createdAt' => $object->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }
}
