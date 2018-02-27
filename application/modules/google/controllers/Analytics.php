<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends MX_Controller 
{
    public $client;
    public $viewId = '164937539';

    public function __construct()
    {
        parent::__construct();
        // putenv('GOOGLE_APPLICATION_CREDENTIALS='. FCPATH . 'assets'.DIRECTORY_SEPARATOR.'service_account.json');
        // $this->client->useApplicationDefaultCredentials();
        $this->client = new Google_Client();
        $this->client->setAuthConfig(json_decode($_SESSION['siteConfigs']->get('analyticServiceAccount'), true));
        $this->client->setApplicationName('Analytics Reporting');
        $this->client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
    }

    public function getActiveUsers($from)
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate('today');
        
        // Create the Metrics object.
        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression('ga:users');
        $users->setAlias('users');
        
        // Create the Dimensions object.
        $date = new Google_Service_AnalyticsReporting_Dimension();
        $date->setName('ga:date');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($users));
        $request->setDimensions(array($date));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);

        return $results;
    }

    public function getUserVisits($from)
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate('today');
        
        // Create the Metrics object.
        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression('ga:users');
        $users->setAlias('users');

        // Create the Metrics object.
        $newUsers = new Google_Service_AnalyticsReporting_Metric();
        $newUsers->setExpression('ga:newUsers');
        $newUsers->setAlias('newUsers');
        
        // Create the Dimensions object.
        $date = new Google_Service_AnalyticsReporting_Dimension();
        $date->setName('ga:date');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($users, $newUsers));
        $request->setDimensions(array($date));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);

        return $results;
    }

    public function getTimeVisits($from)
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate('today');
        
        // Create the Metrics object.
        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression('ga:users');
        $users->setAlias('users');

        // Create the Dimensions object.
        $hour = new Google_Service_AnalyticsReporting_Dimension();
        $hour->setName('ga:hour');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($users));
        $request->setDimensions(array($hour));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);
        return $results;
    }

    public function getScreenVisits($from)
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate('yesterday');
        
        // Create the Metrics object.
        $screenviews = new Google_Service_AnalyticsReporting_Metric();
        $screenviews->setExpression('ga:screenviews');
        $screenviews->setAlias('screenviews');

        // Create the Dimensions object.
        $screenName = new Google_Service_AnalyticsReporting_Dimension();
        $screenName->setName('ga:screenName');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($screenviews));
        $request->setDimensions(array($screenName));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);
        return $results;
    }

    public function getAppVersion($from)
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($from);
        $dateRange->setEndDate('yesterday');
        
        // Create the Metrics object.
        $sessions = new Google_Service_AnalyticsReporting_Metric();
        $sessions->setExpression('ga:sessions');
        $sessions->setAlias('sessions');

        // Create the Dimensions object.
        $appVersion = new Google_Service_AnalyticsReporting_Dimension();
        $appVersion->setName('ga:appVersion');

        // Create the Dimensions object.
        $date = new Google_Service_AnalyticsReporting_Dimension();
        $date->setName('ga:date');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($sessions));
        $request->setDimensions(array($appVersion, $date));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);
        return $results;
    }

    public function getRealtimeVisitors()
    {
        $analytics = new Google_Service_Analytics($this->client);

        $optParams = array('dimensions' => 'rt:medium');
        
        try {

            $results = $analytics->data_realtime->get('ga:135966535', 'rt:activeUsers', $optParams);
            $totals = $results->getTotalsForAllResults();

            foreach ($totals as $metricName => $metricTotal) {
                $activeUsers = $metricTotal;
                return response($activeUsers);
            }

            return response(0);

        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
        }
    }

    public function getTodayVisitors()
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate(date('Y-m-d'));
        $dateRange->setEndDate('today');
        
        // Create the Metrics object.
        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression('ga:users');
        $users->setAlias('users');

        // Create the Dimensions object.
        $hour = new Google_Service_AnalyticsReporting_Dimension();
        $hour->setName('ga:hour');

        // Create the Dimensions object.
        $country = new Google_Service_AnalyticsReporting_Dimension();
        $country->setName('ga:countryIsoCode');
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($users));
        $request->setDimensions(array($hour, $country));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);

        return $results;
    }

    public function getTodayHits()
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);

        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate(date('Y-m-d'));
        $dateRange->setEndDate('today');
        
        // Create the Metrics object.
        $users = new Google_Service_AnalyticsReporting_Metric();
        $users->setExpression('ga:users');
        $users->setAlias('users');

        // Create the Dimensions object.
        $country = new Google_Service_AnalyticsReporting_Dimension();
        $country->setName('ga:country');

        // Create the Dimensions object.
        $hour = new Google_Service_AnalyticsReporting_Dimension();
        $hour->setName('ga:dateHourMinute');

        // Create the Dimensions object.
        $operatingSystem = new Google_Service_AnalyticsReporting_Dimension();
        $operatingSystem->setName('ga:operatingSystem');

        // Create the Dimensions object.
        $appVersion = new Google_Service_AnalyticsReporting_Dimension();
        $appVersion->setName('ga:appVersion');

        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics(array($users));
        $request->setDimensions(array($country, $hour, $operatingSystem, $appVersion));

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);

        return $results;
    }

    public function get($start, $end, $metrics, $dimensions = [])
    {
        $analytics = new Google_Service_AnalyticsReporting($this->client);
        $metricsToQuery = array();
        $dimensionsToQuery = array();
        
        // Create the DateRange object.
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($start);
        $dateRange->setEndDate($end);
        
        foreach ($metrics as $key => $value)
        {
            // Create the Metrics object.
            $metric = new Google_Service_AnalyticsReporting_Metric();
            $metric->setExpression($value['metric']);
            $metric->setAlias($value['alias']);

            $metricsToQuery[] = $metric;
        }

        foreach ($dimensions as $key => $value)
        {
            // Create the Dimensions object.
            $dimension = new Google_Service_AnalyticsReporting_Dimension();
            $dimension->setName($value);

            $dimensionsToQuery[] = $dimension;
        }
        
        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setDateRanges($dateRange);
        $request->setMetrics($metricsToQuery);
        $request->setDimensions($dimensionsToQuery);

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);
        
        return (object) $results;
    }

    public function getRealtime($metrics, $dimensions)
    {
        $analytics = new Google_Service_Analytics($this->client);
        $viewId = 'ga:' . $this->viewId;
        $dimensionsToQuery = ($dimensions) ? array('dimensions' => $dimensions) : [];
        
        try {

            $results = $analytics->data_realtime->get($viewId, $metrics, $dimensionsToQuery);
            
            $data = (object) array(
                'totalsForAllResult' => $results->getTotalsForAllResults(),
                'rows' => ($results->getRows()) ? $results->getRows() : []
            );

            return $data;

        } catch (apiServiceException $e) {
            // Handle API service exceptions.
            $error = $e->getMessage();
        }
    }

    public function cohort($start, $end, $dateDifference)
    {
        $dateStart = new DateTime($start);
        $dateEnd = new DateTime($end);

        $analytics = new Google_Service_AnalyticsReporting($this->client);
        
        // Create the Metrics object.
        $retentionRate = new Google_Service_AnalyticsReporting_Metric();
        $retentionRate->setExpression('ga:cohortRetentionRate');

        $activeUsers = new Google_Service_AnalyticsReporting_Metric();
        $activeUsers->setExpression('ga:cohortActiveUsers');

        $cohortTotalUsersWithLifetimeCriteria = new Google_Service_AnalyticsReporting_Metric();
        $cohortTotalUsersWithLifetimeCriteria->setExpression('ga:cohortTotalUsersWithLifetimeCriteria');

        $cohortAppviewsPerUserWithLifetimeCriteria = new Google_Service_AnalyticsReporting_Metric();
        $cohortAppviewsPerUserWithLifetimeCriteria->setExpression('ga:cohortAppviewsPerUserWithLifetimeCriteria');
        
        // Create the Dimensions object.
        $cohort = new Google_Service_AnalyticsReporting_Dimension();
        $cohort->setName('ga:cohort');

        $acquisitionMedium = new Google_Service_AnalyticsReporting_Dimension();
        $acquisitionMedium->setName('ga:acquisitionMedium');

        if ($dateDifference > 41) {
            $cohortNth = new Google_Service_AnalyticsReporting_Dimension();
            $cohortNth->setName('ga:cohortNthMonth');
        } elseif ($dateDifference > 6) {
            $cohortNth = new Google_Service_AnalyticsReporting_Dimension();
            $cohortNth->setName('ga:cohortNthWeek');
        } else {
            $cohortNth = new Google_Service_AnalyticsReporting_Dimension();
            $cohortNth->setName('ga:cohortNthDay');
        }

        $day = 0;

        while ($dateStart <= $dateEnd) {

            if ($dateDifference > 41) {
  
                $start = $dateStart->format('Y-m-d');
                $cohortName = $start . '|';
                $end = $dateStart->format('Y-m-t');
                $cohortName .= $end;

                $dateStart->modify('+1 month');

            } elseif ($dateDifference > 6) {
  
                $start = $dateStart->format('Y-m-d');
                $cohortName = $dateStart->format('Y-m-d') . '|';
                
                $dateStart->modify('+6 day');
                
                $end = $dateStart->format('Y-m-d');
                $cohortName .= $dateStart->format('Y-m-d');

                $dateStart->modify('+1 day');

            } else {

                $start = $dateStart->format('Y-m-d');
                $end = $dateStart->format('Y-m-d');
                $cohortName = $dateStart->format('Y-m-d');
                $dateStart->modify('+1 day');

            }
            
            $day++;

            $dateRange = new Google_Service_AnalyticsReporting_DateRange();
            $dateRange->setStartDate($start);
            $dateRange->setEndDate($end);

            $cohortObj = new Google_Service_AnalyticsReporting_Cohort();
            $cohortObj->setDateRange($dateRange);
            $cohortObj->setName($cohortName);
            $cohortObj->setType('FIRST_VISIT_DATE');

            $cohorts[] = $cohortObj;

        }
        
        // Create the Cohort group.
        $cohortGroup = new Google_Service_AnalyticsReporting_CohortGroup();
        $cohortGroup->setCohorts($cohorts);
        // $cohortGroup->setLifetimeValue(true);

        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();
        $request->setViewId($this->viewId);
        $request->setMetrics(array($retentionRate, $cohortTotalUsersWithLifetimeCriteria, $activeUsers, $cohortAppviewsPerUserWithLifetimeCriteria));
        $request->setDimensions(array($cohort, $cohortNth, $acquisitionMedium));
        $request->setCohortGroup($cohortGroup);

        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests( array( $request) );
        
        $response = $analytics->reports->batchGet( $body );
        $results = $this->fetchResults($response);
        return (object) $results;
    }

    public function fetchResults($reports) {
        for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
            $report = $reports[ $reportIndex ];
            $header = $report->getColumnHeader();
            $dimensionHeaders = $header->getDimensions();
            $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
            $rows = $report->getData()->getRows();
            
            for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
                
                $row = $rows[ $rowIndex ];
                $dimensions = $row->getDimensions();
                $metrics = $row->getMetrics();
                
                for ($i = 0; $i < count($dimensionHeaders) && $i < count($dimensions); $i++) {
                    // print($dimensionHeaders[$i] . ': ' . $dimensions[$i] . '<br>');
                    
                    if (!isset($results['dimensions'][$dimensionHeaders[$i]])) $results['dimensions'][$dimensionHeaders[$i]] = array();
                    $results['dimensions'][$dimensionHeaders[$i]][] = $dimensions[$i];
                    //$results[$dimensionHeaders[$i]][$dimensions[$i]] = array();
                }

                for ($j = 0; $j < count($metrics); $j++) {
                    $values = $metrics[$j]->getValues();
                    for ($k = 0; $k < count($values); $k++) {
                        $entry = $metricHeaders[$k];
                        // print($entry->getName() . ': ' . $values[$k] . '<br>');
                        
                        if (!isset($results['metrics'][$entry->getName()])) $results['metrics'][$entry->getName()] = array();
                        $results['metrics'][$entry->getName()][] = $values[$k];
                        // $results[$dimensionHeaders[$j]][$dimensions[$j]][$entry->getName()] = $values[$k];
                    }
                }
            }
        }
        
        return $results;
    }
}
