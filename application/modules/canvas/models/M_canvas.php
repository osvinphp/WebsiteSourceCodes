<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Load parse sdk
use Parse\ParseACL;
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseCloud;
use Parse\ParseException;

class M_canvas extends MY_Model
{
    private $objectName;

    public function __construct()
    {
        $this->objectName = 'BuildingBlockTypes';
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
                $BuildingBlockTypes = $table->find(true);

                // Merge user array
                $results = array_merge($results, $BuildingBlockTypes);
                
                // Set last createdAt
                $createdAt = end($BuildingBlockTypes)->getCreatedAt();
            }

        } 
        else 
        {
            // Apply query condition
            $table->descending('createdAt');
            $table->limit(1000);
            
            // Execute the query
            $results = $table->find(true);
        }

        // return the results
        return $this->fetchResults($results);
    }

    public function getById($id)
    {
        // Create parse user query
        $table = new ParseObject('BuildingBlockTypes', $id);
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
        $reward = new ParseObject('BuildingBlockTypes');
        
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
        $reward = new ParseObject('BuildingBlockTypes', $data->id);

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
        $reward = new ParseObject('BuildingBlockTypes', $id);

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
        $query = new ParseQuery('BuildingBlockTypes');

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

    public function getElementQuery($data)
    {
        $query = new ParseQuery($data->dataType);
        $columnName = $data->fieldToQuery;
        $columnType = 'int';
        $results = [];

        switch ($data->dataSource) {
            case 'Individual':
                if ($data->user !== 'All') {
                    $user = new ParseObject('_User', $data->user);
                    $query->equalTo('userOwner', $user);
                }
            break;

            case 'Group':
                $group = new ParseObject('UserGroups', $data->group);
                $user = new ParseQuery('_User');
                $user->equalTo('groups', $group);
                $query->matchesQuery('userOwner', $user); 
            break;
        }

        switch ($data->dataType) {
            case 'DataAccelerometer':
            case 'DataGyro':
            case 'DataMagnetic':
                if (isset($data->xReading)) {
                    $xReading = explode(';', $data->xReading);
                    $query->greaterThanOrEqualTo('xReading', (int) $xReading[0]);
                    $query->lessThanOrEqualTo('xReading', (int) $xReading[1]);
                }
                
                if (isset($data->yReading)) {
                    $yReading = explode(';', $data->yReading);
                    $query->greaterThanOrEqualTo('yReading', (int) $yReading[0]);
                    $query->lessThanOrEqualTo('yReading', (int) $yReading[1]);
                }

                if (isset($data->zReading)) {
                    $zReading = explode(';', $data->zReading);
                    $query->greaterThanOrEqualTo('zReading', (int) $zReading[0]);
                    $query->lessThanOrEqualTo('zReading', (int) $zReading[1]);
                }
            break;

            case 'DataGravity':
                if (isset($data->xReading)) {
                    $xReading = explode(';', $data->xReading);
                    $query->greaterThanOrEqualTo('xReading', (int) $xReading[0]);
                    $query->lessThanOrEqualTo('xReading', (int) $xReading[1]);
                }
                
                if (isset($data->yReading)) {
                    $yReading = explode(';', $data->yReading);
                    $query->greaterThanOrEqualTo('yReading', (int) $yReading[0]);
                    $query->lessThanOrEqualTo('yReading', (int) $yReading[1]);
                }

                if (isset($data->zReading)) {
                    $zReading = explode(';', $data->zReading);
                    $query->greaterThanOrEqualTo('zReading', (int) $zReading[0]);
                    $query->lessThanOrEqualTo('zReading', (int) $zReading[1]);
                }

                if (isset($data->rollReading)) {
                    $rollReading = explode(';', $data->rollReading);
                    $query->greaterThanOrEqualTo('rollReading', (int) $rollReading[0]);
                    $query->lessThanOrEqualTo('rollReading', (int) $rollReading[1]);
                }
               
                if (isset($data->pitchReading)) {
                    $pitchReading = explode(';', $data->pitchReading);
                    $query->greaterThanOrEqualTo('pitchReading', (int) $pitchReading[0]);
                    $query->lessThanOrEqualTo('pitchReading', (int) $pitchReading[1]);
                }

                if (isset($data->azimuthReadung)) {
                    $azimuthReadung = explode(';', $data->azimuthReadung);
                    $query->greaterThanOrEqualTo('azimuthReadung', (int) $azimuthReadung[0]);
                    $query->lessThanOrEqualTo('azimuthReadung', (int) $azimuthReadung[1]);
                }
            break;

            case 'DataSteps':
                if (isset($data->stepsReading)) {
                    $stepsReading = explode(';', $data->stepsReading);
                    $query->greaterThanOrEqualTo('stepsReading', (int) $stepsReading[0]);
                    $query->lessThanOrEqualTo('stepsReading', (int) $stepsReading[1]);
                }

                if (isset($data->distanceReading)) {
                    $distanceReading = explode(';', $data->distanceReading);
                    $query->greaterThanOrEqualTo('distanceReading', (int) $distanceReading[0]);
                    $query->lessThanOrEqualTo('distanceReading', (int) $distanceReading[1]);
                }

                if (isset($data->ascendedReading)) {
                    $ascendedReading = explode(';', $data->ascendedReading);
                    $query->greaterThanOrEqualTo('ascendedReading', (int) $ascendedReading[0]);
                    $query->lessThanOrEqualTo('ascendedReading', (int) $ascendedReading[1]);
                }

                if (isset($data->descendedReading)) {
                    $descendedReading = explode(';', $data->descendedReading);
                    $query->greaterThanOrEqualTo('descendedReading', (int) $descendedReading[0]);
                    $query->lessThanOrEqualTo('descendedReading', (int) $descendedReading[1]);
                }

                if (isset($data->paceReading)) {
                    $paceReading = explode(';', $data->paceReading);
                    $query->greaterThanOrEqualTo('paceReading', (int) $paceReading[0]);
                    $query->lessThanOrEqualTo('paceReading', (int) $paceReading[1]);
                }

                if (isset($data->cadenceReading)) {
                    $cadenceReading = explode(';', $data->cadenceReading);
                    $query->greaterThanOrEqualTo('cadenceReading', (int) $cadenceReading[0]);
                    $query->lessThanOrEqualTo('cadenceReading', (int) $cadenceReading[1]);
                }
            break;

            case 'DataAltitude':
                if (isset($data->pressureReading)) {
                    $pressureReading = explode(';', $data->pressureReading);
                    $query->greaterThanOrEqualTo('pressureReading', (int) $pressureReading[0]);
                    $query->lessThanOrEqualTo('pressureReading', (int) $pressureReading[1]);
                }

                if (isset($data->relativeReading)) {
                    $relativeReading = explode(';', $data->relativeReading);
                    $query->greaterThanOrEqualTo('relativeReading', (int) $relativeReading[0]);
                    $query->lessThanOrEqualTo('relativeReading', (int) $relativeReading[1]);
                }
            break;

            case 'DataLocation':
            break;

            case 'DataBattery':
                if (isset($data->levelReading)) {
                    $levelReading = explode(';', $data->levelReading);
                    $query->greaterThanOrEqualTo('levelReading', (int) $levelReading[0]);
                    $query->lessThanOrEqualTo('levelReading', (int) $levelReading[1]);
                }

                if (isset($data->chargingReading)) {
                    $query->equalTo('chargingReading', (bool) $data->chargingReading);
                    $columnType = 'bool';
                }

                if (isset($data->fullReading)) {
                    $query->equalTo('fullReading', (bool) $data->fullReading);
                    $columnType = 'bool';
                }
            break;

            case 'DataUV':
                if (isset($data->exposureReading)) {
                    $exposureReading = explode(';', $data->exposureReading);
                    $query->greaterThanOrEqualTo('exposureReading', (int) $exposureReading[0]);
                    $query->lessThanOrEqualTo('exposureReading', (int) $exposureReading[1]);
                }

                if (isset($data->temperatureReading)) {
                    $temperatureReading = explode(';', $data->temperatureReading);
                    $query->greaterThanOrEqualTo('temperatureReading', (int) $temperatureReading[0]);
                    $query->lessThanOrEqualTo('temperatureReading', (int) $temperatureReading[1]);
                }
            break;

            case 'DataBloodPressure':
                if (isset($data->systolicReading)) {
                    $systolicReading = explode(';', $data->systolicReading);
                    $query->greaterThanOrEqualTo('systolicReading', (int) $systolicReading[0]);
                    $query->lessThanOrEqualTo('systolicReading', (int) $systolicReading[1]);
                }

                if (isset($data->diastolicReading)) {
                    $diastolicReading = explode(';', $data->diastolicReading);
                    $query->greaterThanOrEqualTo('diastolicReading', (int) $diastolicReading[0]);
                    $query->lessThanOrEqualTo('diastolicReading', (int) $diastolicReading[1]);
                }
            break;

            case 'DataHeartRate':
                if (isset($data->opticalReading)) {
                    $opticalReading = explode(';', $data->opticalReading);
                    $query->greaterThanOrEqualTo('opticalReading', (int) $opticalReading[0]);
                    $query->lessThanOrEqualTo('opticalReading', (int) $opticalReading[1]);
                }

                if (isset($data->averageReading)) {
                    $averageReading = explode(';', $data->averageReading);
                    $query->greaterThanOrEqualTo('averageReading', (int) $averageReading[0]);
                    $query->lessThanOrEqualTo('averageReading', (int) $averageReading[1]);
                }
            break;

            case 'DataHRV':
                if (isset($data->peakFrequency)) {
                    $peakFrequency = explode(';', $data->peakFrequency);
                    $query->greaterThanOrEqualTo('peakFrequency', (int) $peakFrequency[0]);
                    $query->lessThanOrEqualTo('peakFrequency', (int) $peakFrequency[1]);
                }
            break;

            case 'DataGalvanicSkinResponse':
                if (isset($data->responseReading)) {
                    $responseReading = explode(';', $data->responseReading);
                    $query->greaterThanOrEqualTo('responseReading', (int) $responseReading[0]);
                    $query->lessThanOrEqualTo('responseReading', (int) $responseReading[1]);
                }
            break;
            
            case 'DataBRBuy':
            case 'DataBRProfit':
            case 'DataBRSell':
                if (isset($data->tradeValue)) {
                    $tradeValue = explode(';', $data->tradeValue);
                    $query->greaterThanOrEqualTo('tradeValue', (int) $tradeValue[0]);
                    $query->lessThanOrEqualTo('tradeValue', (int) $tradeValue[1]);
                }
            break;
        }

        $data = $query->find();
        
        if (count($data) === 0) {

            return [
                'status' => false,
                'count' => 0
            ];
        }

        foreach ($data as $row) {
            $users[$row->getObjectId()][] = $row;
        }

        foreach ($users as $key => $value) {
            $results[$key] = $this->fetchUserData($columnType, $columnName, $value);
        }
        
        return $results;        
    }

    public function fetchUserData($columnType, $columnName, $data) 
    {
        switch ($columnType) {
            case 'int':
                $total = 0;
                
                foreach ($data as $row) {
                    $total += $row->get($columnName);
                }
                
                return [
                    $columnName => $total / count($data),
                    'status' => true,
                    'count' => count($data)
                ];

            break;

            default:
                return [];
            break;
        }

    }

}
