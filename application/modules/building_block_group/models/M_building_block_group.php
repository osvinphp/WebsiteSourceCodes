<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseACL;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseCloud;
use Parse\ParseException;

class M_building_block_group extends MY_Model
{
    private $objectName;

    public function __construct()
    {
        $this->objectName = 'BuildingBlockGroups';
    }

    public function getACL()
    {
        $acl = new ParseACL();
        $acl->setRoleWriteAccessWithName('Administrator', true);
        $acl->setPublicReadAccess(true);

        return $acl;
    }

    public function getAll()
    {
        // Create parse user query
        $table = new ParseQuery($this->objectName);
        $numRows = $this->count(null);

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
                $table = new ParseQuery($this->objectName);
                
                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $BuildingBlockGroups = $table->find();

                // Merge user array
                $results = array_merge($results, $BuildingBlockGroups);
                
                // Set last createdAt
                $createdAt = end($BuildingBlockGroups)->getCreatedAt();
            }

        } 
        else 
        {
            // Apply query condition
            $table->descending('createdAt');
            $table->limit(1000);
            
            // Execute the query
            $results = $table->find();
        }

        // return the results
        return $this->fetchResults($results);
    }

    public function getById($id)
    {
        // Create parse user query
        $table = new ParseObject('BuildingBlockGroups', $id);
        $table->fetch();

        // Fetch query data
        $results = $this->fetchData($table);
        
        // return the results
        return (object) $results;
    }

    public function getWhere($where)
    {
        $results = [];

        // Create parse query
        $table = new ParseQuery($this->objectName);

        // Apply query condition
        foreach($where as $key => $value)
        {
            switch ($key) {
                default:
                    $table->equalTo($key, $value);
                break;
            }
        }

        // Execute the query
        $query = $table->find(true);

        // Fetch query data
        $results = $this->fetchResults($query);

        // return the results
        return $results;
    }

    public function insert($data) 
    {
        // Create new parse user object
        $reward = new ParseObject('BuildingBlockGroups');
        
        // Create user ACL
        // $userACL = $this->getACL();

        // Set the new user data
        foreach ($data as $key => $value) {

            if (empty($value))
                continue;

            switch ($key) {

                case 'rewardManager':
                    $manager = new ParseObject('_User', $value);
                    $reward->set($key, $manager);
                break;

                case 'rewardValue':
                    $rewardValue = preg_replace('/[^0-9]/', '', $value);
                    $reward->set($key, (int) $rewardValue);
                break;

                case 'rewardDueDate':
                    $rewardDueDate = new DateTime($value);
                    $reward->set($key, $rewardDueDate);
                break;

                default: 
                    $reward->set($key, $value);
                break;

            }

        }

        // Set user ACL
        // $reward->setACL($userACL);

        // Execute the query
        try {
            // Save user
            $reward->save();
            return true;

        } catch(ParseException $ex) {
            // Query failed
            return $ex->getMessage();
        }
    }

    public function update($data) 
    {
        // Create new parse query
        $reward = new ParseObject('BuildingBlockGroups', $data->id);

        // Remove id props
        unset($data->id);
        
        // Update user data
        foreach ($data as $key => $value) {
            
            if (empty($value))
                continue;

            switch ($key) {

                case 'rewardManager':
                    $manager = new ParseObject('_User', $value);
                    $reward->set($key, $manager);
                break;

                case 'rewardValue':
                    $rewardValue = preg_replace('/[^0-9]/', '', $value);
                    $reward->set($key, (int) $rewardValue);
                break;

                case 'rewardDueDate':
                    $rewardDueDate = new DateTime($value);
                    $reward->set($key, $rewardDueDate);
                break;

                default: 
                    $reward->set($key, $value);
                break;

            }

        }

        // Save changes
        try {
            
            // Save reward
            $reward->save();
            return true;

        } catch(ParseException $ex) {
            // Query failed
            return $ex->getMessage();
        }
    }

    public function delete($id) 
    {
        // Create new parse query
        $reward = new ParseObject('BuildingBlockGroups', $id);

        // Delete reward
        try {
            // Delete success
            $reward->destroy();
            return true;

        } catch(ParseException $ex) {
            // Delete failed
            return $ex->getMessage();
        }
    }

    public function count($where)
    {
        $query = new ParseQuery('BuildingBlockGroups');

        if (!empty($where)) {
            
            foreach ($where as $key => $value) {
                switch ($key) {
                    case 'rewardManager':
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
        $width = $object->get('width');
        $height = $object->get('height');
        $size = ($width && $height) ? $width . ' ' . $height : '';

        return (object) array(
            'id' => $object->getObjectId(),
            'name' => $object->get('name'),
            'createdAt' => $object->getCreatedAt()->format('Y-m-d H:i:s')
        );
    }

}
