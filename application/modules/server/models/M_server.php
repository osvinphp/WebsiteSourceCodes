<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;

class M_server extends CI_Model
{
    public $results = array();

    public function getAll()
    {
        // Create parse analytic query
        $table = new ParseQuery('Comments');
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
                // Create parse analytic query
                $table = new ParseQuery('Comments');
                
                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $analytics = $table->find(true);

                // Merge analytic array
                $results = array_merge($data, $analytics);
                
                // Set last createdAt
                $createdAt = end($analytics)->getCreatedAt();
            }

        } 
        else 
        {
            // Create parse analytic query
            $table = new ParseQuery('Comments');

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

    public function getById($id)
    {
        // Create parse analytic query
        $table = new ParseQuery('Comments');

        // Apply query condition
        $table->equalTo('objectId', $id);

        // Execute the query
        $query = $table->first(true);
        
        // Fetch query data
        $this->results = array(
            'id' => $query->getObjectId(),
            'fullName' => $query->get('fullName'),
            'analyticname' => $query->get('analyticname'),
            'email' => $query->get('email'),
            'phoneNumber' => $query->get('phoneNumber'),
            'analyticLevel' => ($query->get('analyticLevel')) ? $query->get('analyticLevel')->getObjectId() : null
        );
        
        // return the results
        return (object)$this->results;
    }

    public function getWhere($where)
    {
        // Create parse analytic query
        $table = new ParseQuery('Comments');

        // Apply query condition
        foreach($where as $key => $value)
        {
            $table->equalTo($key, $value);
        }

        // Execute the query
        $query = $table->find(true);

        // Fetch query data
        foreach($query as $row)
        {
            $this->results[] = array(
                'id' => $row->getObjectId(),
                'firstName' => $row->get('firstName'),
                'lastName' => $row->get('lastName'),
                'analyticname' => $row->get('analyticname'),
                'email' => $row->get('email'),
                'phoneNumber' => $query->get('phoneNumber')
            );
        }

        // return the results
        return (object)$this->results;
    }

    public function insert($data) 
    {
        // Create new parse analytic object
        $analytic = new ParseObject('_User');
        $analyticLevel = new ParseObject('UserLevel', $data['analyticLevel']);

        // Set the new analytic data
        $analytic->set('fullName', clean_input($data['fullName']));
        $analytic->set('email', clean_input($data['email']));
        $analytic->set('analyticname', clean_input($data['analyticname']));
        $analytic->set('password', clean_input($data['password']));
        $analytic->set('phoneNumber', clean_input($data['phoneNumber']));
        $analytic->set('analyticLevel', $analyticLevel);

        // Execute the query
        try {
            // Query success
            $analytic->save(true);
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
        
        // Create new parse object
        $analyticLevel = new ParseObject('UserLevel', $data->analyticLevel);

        // Execute analytic query
        $analytic = $query->first(true);
        
        // Update analytic data
        $analytic->set('fullName', clean_input($data->fullName));
        $analytic->set('analyticname', clean_input($data->analyticname));
        $analytic->set('email', clean_input($data->email));
        $analytic->set('password', $data->password);
        $analytic->set('phoneNumber', $data->phoneNumber);
        $analytic->set('analyticLevel', $analyticLevel);

        // Save changes
        try {
            // Query success
            $analytic->save(true);
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
        
        // Execute analytic query
        $analytic = $query->first(true);

        // Delete analytic
        try {
            // Delete success
            $analytic->destroy(true);
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

        // Create parse analytic query
        $table = new ParseQuery('Comments');
        // $total = new ParseQuery('Comments')->count(true);

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
        $analytics = $table->find(true);
        
        // Fetch query data
        foreach($analytics as $row)
        {
            $rows[] = array(
                'id' => $row->getObjectId(),
                'firstName' => $row->get('firstName'),
                'lastName' => $row->get('lastName'),
                'analyticname' => $row->get('analyticname'),
                'email' => $row->get('email'),
                'phoneNumber' => $row->get('phoneNumber'),
                'createdAt' => $row->getcreatedAt()->format('d-m-Y H:i:s'),
                'levelName' => ($row->get('analyticLevel')) ? $row->get('analyticLevel')->fetch(true)->get('levelName') : null
            );
        }

        // If search box is not empty
        if ($searchPhrase)
        {
            $compare_data = array('id', 'firstName', 'lastName', 'analyticname', 'email', 'analyticLevel');
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

    public function count()
    {
        $query = new ParseQuery('Comments');
        $numRows = $query->count(true);
        return $numRows;
    }

    public function getCommentDate($date)
    {
        $start = new DateTime($date . ' 00:00:00');
        $end = new DateTime($date . ' 23:59:59');

        // Create parse analytic query
        $table = new ParseQuery('Comments');

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
                // Create parse analytic query
                $table = new ParseQuery('Comments');
                
                $table->greaterThanOrEqualTo('createdAt', $start);
                $table->lessThanOrEqualTo('createdAt', $end);

                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $analytics = $table->find(true);

                // Merge analytic array
                $data = array_merge($data, $analytics);
                
                // Set last createdAt
                $createdAt = end($analytics)->getCreatedAt();
            }

        } 
        else 
        {
            // Create parse analytic query
            $table = new ParseQuery('Comments');
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
            $results[] = (object) array(
                'id' => $row->getObjectId(),
                'htmlComment' => $row->get('htmlComment'),
                'createdAt' => $row->getCreatedAt()->format('Y-m-d H:i:s')
            );
        }

        return $results;
    }
}
