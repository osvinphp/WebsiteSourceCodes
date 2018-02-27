<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;

class M_role
{
    public $results = array();

    public function getAll()
    {
        // Create parse userLevel query
        $table = new ParseQuery('_Role');
        $numRows = $table->count(true);

        // If numRows is higher than 1000
        if ($numRows > 1000)
        {
            $query = array();
            $queryLoop = ceil($numRows / 1000);
            $createdAt = null;

            for ($i = 1; $i <= $queryLoop; $i++)
            {
                // Create parse userLevel query
                $table = new ParseQuery('_Role');
                
                // Apply query condition
                if ($createdAt) $table->lessThan('createdAt', $createdAt);
                $table->descending('createdAt');
                $table->limit(1000);

                // Execute the query
                $userLevel = $table->find(true);

                // Merge userLevel array
                $query = array_merge($query, $userLevel);
                
                // Set last createdAt
                $createdAt = end($userLevel)->getCreatedAt();
            }

        } 
        else 
        {
            // Apply query condition
            $table->descending('createdAt');
            $table->limit(1000);
            
            // Execute the query
            $query = $table->find(true);
        }

        // return the results
        return $query;
    }
    
    public function get()
    {
        // Execute getAll
        $query = $this->getAll();
        
        // Fetch query data
        foreach($query as $row)
        {
            $this->results[] = (object) array(
                'id' => $row->getObjectId(),
                'name' => $row->get('name')
            );
        }

        // return the results
        return $this->results;
    }

}
