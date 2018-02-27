<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Analytic extends BaseController {

    public function __construct()
    {
        parent::__construct();

        // Module components            
        $this->data['module'] = 'Analytic';
        $this->data['pluginCss'] = $this->load->view('assets/_pluginCss', $this->data, true);
        $this->data['pluginJs'] = $this->load->view('assets/_pluginJs', $this->data, true);

        // Load model
        $this->load->model('m_analytic');
    }

    public function index()
    {
        // Page Data
        $this->data['audienceOverview'] ='';

        // Page components
        $this->data['pageTitle'] = 'Analytics';
        $this->data['pageCss'] = $this->load->view('assets/_pageCss', $this->data, true);
        $this->data['pageJs'] = $this->load->view('assets/_pageJs', $this->data, true);
        $this->data['content'] = $this->load->view('analyticList', $this->data, true);

        // Render page
        $this->renderPage();
    }

    public function getAudienceOverview()
    {
        $data = [];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Get date difference +1 day
        $difference = $start->diff($end)->format('%d') + 1;

        // Create earlier date range and modify
        $earlierStart = new DateTime($this->input->get('start'));
        $earlierStart->modify('-'.$difference.' day');
        $earlierEnd = new DateTime($this->input->get('start'));
        $earlierEnd->modify('+1 day');
        
        // Create query metrics
        $metrics = array(
            array('metric' => 'ga:users', 'alias' => 'Users'),
            array('metric' => 'ga:sessions', 'alias' => 'Sessions'),
            array('metric' => 'ga:newUsers', 'alias' => 'NewUsers'),
            array('metric' => 'ga:avgSessionDuration', 'alias' => 'SessionDuration')
        );

        // Create query dimensions
        $dimensions = array('ga:date');
        
        // Run the analytic query
        $currentTotalRange = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics);
        $earlierTotalRange = Modules::run('google/analytics/get', $earlierStart->format('Y-m-d'), $earlierEnd->format('Y-m-d'), $metrics);
        
        $currentRange = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics, $dimensions);
        $earlierRange = Modules::run('google/analytics/get', $earlierStart->format('Y-m-d'), $earlierEnd->format('Y-m-d'), $metrics, $dimensions);
        
        if (!empty((array) $currentRange)) {
            // Fetch chart categories
            foreach ($currentRange->dimensions['ga:date'] as $key => $value) {
                $data['categories'][] = $value;
            }

            // Fetch current metrics data
            foreach ($currentRange->metrics as $key => $value) {
                
                $currentCount = (isset($currentTotalRange->metrics)) ? array_sum($currentTotalRange->metrics[$key]) : 0;
                $earlierCount = (isset($earlierTotalRange->metrics)) ? array_sum($earlierTotalRange->metrics[$key]) : 0;
                $percentage = number_format(abs((1 - $earlierCount / $currentCount) * 100), 2);
                $status = ($currentCount > $earlierCount) ? 'up' : 'down';

                if ($key == 'SessionDuration') {
                    $currentCount = gmdate('i', $currentCount) . 'm' . ' ' . gmdate('s', $currentCount) . 's';
                    $earlierCount = gmdate('i', $earlierCount) . 'm' . ' ' . gmdate('s', $earlierCount) . 's';
                }

                $data[$key] = array(
                    'currentCount' => $currentCount,
                    'earlierCount' => $earlierCount,
                    'percentage' => $percentage,
                    'status' => $status
                );

                $data[$key]['series'][] = array(
                    'name' => 'Current',
                    'data' => array_map('intval', $value)
                );

            }
        }

        if (!empty((array) $earlierRange)) {
            // Fetch last metrics data
            if (isset($earlierRange->metrics)) {

                foreach ($earlierRange->metrics as $key => $value) {
                    $data[$key]['series'][] = array(
                        'name' => 'Last',
                        'data' => array_map('intval', $value)
                    );
                }

            }
        }

        // Convert array to object for easier parsing
        $data = json_decode(json_encode($data));

        // Return the html response
        return response($this->load->view('audienceOverview', $data, true), 'html');

    }

    public function getDevicesReport()
    {
        $data = ['devices' => []];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Create query metrics
        $metrics = array(
            array('metric' => 'ga:sessions', 'alias' => 'Sessions'),
            array('metric' => 'ga:avgSessionDuration', 'alias' => 'AvgSession'),
        );

        // Create query dimensions
        $dimensions = array('ga:deviceCategory');

        // Run the analytic query
        $query = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics, $dimensions);
        
        if (!empty((array) $query)) {
            // Fetch chart categories
            foreach ($query->dimensions['ga:deviceCategory'] as $key => $value) {
                
                $sessionsTotal = array_sum($query->metrics['Sessions']);

                $data['devices'][] = array(
                    'device' => ucwords($value),
                    'category' => $query->dimensions['ga:deviceCategory'][$key],
                    'sessions' => $query->metrics['Sessions'][$key],
                    'percentage' => number_format((($query->metrics['Sessions'][$key] / $sessionsTotal) * 100), 2)
                );

            }
        }

        // Convert array to object for easier parsing
        $data = json_decode(json_encode($data));
        
        // Return the html response
        return response($this->load->view('devicesReport', $data, true), 'html');

    }

    public function getRealtimeReport()
    {
        $activeUsers = Modules::run('google/analytics/getRealtime', 'rt:activeUsers', '');
        $screenViews = Modules::run('google/analytics/getRealtime', 'rt:screenViews', 'rt:minutesAgo');
        $screenName = Modules::run('google/analytics/getRealtime', 'rt:activeUsers', 'rt:screenName');
        
        $screenViewsChart = array();
        $minutes = array();
        
        if ($screenViews->rows) {

            // Fetch screenViews data
            foreach ($screenViews->rows as $key => $value) {
                $minute = ltrim($value[0], '0');
                $minutes[$minute] = (int) $value[1]; 
            }
            
            // Fill empty minute data
            for ($i = 0; $i <= 30; $i++) {
                if (!isset($minutes[$i]))
                    $minutes[$i] = 0;
            }

            // Sort minutes descending by key
            krsort($minutes);

            foreach ($minutes as $key => $value) {
                $screenViewsChart[] = $value;
            }

        } else {
            // Fill empty minute data
            for ($i = 0; $i <= 30; $i++) {
                $screenViewsChart[] = 0;
            }
        }

        $results = array(
            'activeUsers' => $activeUsers->totalsForAllResult['rt:activeUsers'],
            'screenViews' => array(
                array('name' => 'Screen Views', 'data' => $screenViewsChart)
            ),
            'screenName' => $screenName->rows
        );

        return response($results);
    }

    public function getActiveUsersTrending()
    {
        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Create query metrics
        $oneDayMetrics = array(
            array('metric' => 'ga:1dayUsers', 'alias' => 'Daily'),
        );

        $oneWeekMetrics = array(
            array('metric' => 'ga:7dayUsers', 'alias' => 'Weekly'),
        );

        $oneMonthMetrics = array(
            array('metric' => 'ga:30dayUsers', 'alias' => 'Monthly'),
        );

        // Create query dimensions
        $dimensions = array('ga:date');

        // Run the analytic query
        $oneDayRange = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $oneDayMetrics, $dimensions);
        $oneWeekRange = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $oneWeekMetrics, $dimensions);
        $oneMonthRange = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $oneMonthMetrics, $dimensions);

        // Fetch chart categories
        foreach ($oneDayRange->dimensions['ga:date'] as $key => $value) {
            $data['categories'][] = $value;
        }

        // Fetch metrics data
        foreach ($oneDayRange->metrics as $key => $value) {
            
            $data['series'][] = array(
                'name' => $key,
                'data' => array_map('intval', $value)
            );

            $data['current'][$key] = end($value);

        }

        foreach ($oneWeekRange->metrics as $key => $value) {
            
            $data['series'][] = array(
                'name' => $key,
                'data' => array_map('intval', $value)
            );

            $data['current'][$key] = end($value);

        }

        foreach ($oneMonthRange->metrics as $key => $value) {
            
            $data['series'][] = array(
                'name' => $key,
                'data' => array_map('intval', $value)
            );

            $data['current'][$key] = end($value);

        }

        // Convert array to object for easier parsing
        $data = json_decode(json_encode($data));

        // Return the html response
        return response($data);

    }

    public function getAppVersionsReport()
    {
        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));
        
        // Create helper vars
        $data = array();
        $series = array();
        $categories = array();
        $appVersions = array();

        // Create query metrics
        $metrics = array(
            array('metric' => 'ga:sessions', 'alias' => 'Sessions'),
        );

        // Create query dimensions
        $dimensions = array('ga:date', 'ga:appVersion');

        // Run the analytic query
        $query = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics, $dimensions);
        
        // Fetch chart categories
        foreach ($query->dimensions['ga:date'] as $key => $value) {
            
            $appVersion = $query->dimensions['ga:appVersion'][$key];

            if (!in_array($value, $categories)) 
                $categories[] = $value;
            
            if (!in_array($appVersion, $appVersions))
                $appVersions[] = $appVersion;
            
            $data[$value][$appVersion] = (int) $query->metrics['Sessions'][$key];
                
        }
        
        // Fetch date and appVersions
        foreach ($categories as $date) {

            foreach ($appVersions as $appVersion) {
                
                $session = (isset($data[$date][$appVersion])) ? $data[$date][$appVersion] : 0;
                $data['series'][$appVersion][] = $session;

            }

        }

        foreach ($data['series'] as $key => $value) {
            $series[] = array(
                'name' => $key,
                'data' => $value
            );
        }   
        
        $results = array(
            'categories' => $categories,
            'series' => $series
        );

        // Return the results
        return response($results);

    }

    public function getLocationOverview()
    {
        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Create query metrics
        $metrics = array(
            array('metric' => 'ga:sessions', 'alias' => 'Sessions'),
        );

        // Create query dimensions
        $dimensions = array('ga:country', 'ga:countryIsoCode');

        // Run the analytic query
        $query = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics, $dimensions);
    
        // Fetch chart categories
        foreach ($query->dimensions['ga:country'] as $key => $value) {
            
            $data['categories'][] = $value;
            $data['regions'][] = $query->dimensions['ga:countryIsoCode'][$key];
            $data['count'] = array_sum($query->metrics['Sessions']);
            $data['series'][] = array(
                'name' => $value,
                'data' => [(int) $query->metrics['Sessions'][$key]]
            );
        }
        
        // Return the html response
        return response($data);

    }

    public function getScreensReport()
    {
        $data = ['screens' => []];

        // Get input data
        $start = new DateTime($this->input->get('start'));
        $end = new DateTime($this->input->get('end'));

        // Create query metrics
        $metrics = array(
            array('metric' => 'ga:pageviews', 'alias' => 'PageViews')
        );

        // Create query dimensions
        $dimensions = array('ga:pagePath');

        // Run the analytic query
        $query = Modules::run('google/analytics/get', $start->format('Y-m-d'), $end->format('Y-m-d'), $metrics, $dimensions);
        
        if (!empty((array) $query)) {
            // Fetch chart categories
            foreach ($query->dimensions['ga:pagePath'] as $key => $value) {
                
                $data['screens'][$value] = $query->metrics['PageViews'][$key];

            }

            arsort($data['screens']);
        }

        // Convert array to object for easier parsing
        $data = json_decode(json_encode($data));

        // Return the html response
        return response($this->load->view('screensReport', $data, true), 'html');

    }

    public function getCohortAnalysisReport()
    {
        $results = ['cohorts' => []];

        // Get input data
        $dateStart = new DateTime($this->input->get('start'));
        $dateEnd = new DateTime($this->input->get('end'));
        $dateDifference = $this->input->get('difference');

        $query = Modules::run('google/analytics/cohort', $dateStart->format('Y-m-d'), $dateEnd->format('Y-m-d'), $dateDifference);
        
        switch ($dateDifference) {

            case 91:
                $nthDimension = 'ga:cohortNthMonth';
                $nthCount = 3;
                $nthType = 'Month';
            break;

            case 20:
                $nthDimension = 'ga:cohortNthWeek';
                $nthCount = 3;
                $nthType = 'Week';
            break;

            case 41:
                $nthDimension = 'ga:cohortNthWeek';
                $nthCount = 6;
                $nthType = 'Week';
            break;

            default:
                $nthDimension = 'ga:cohortNthDay'; 
                $nthCount = 7;
                $nthType = 'Day';
            break;

        }

        $results['nthCount'] = $nthCount;
        $results['nthType'] = $nthType;

        if (!empty((array) $query)) {

            foreach ($query->dimensions['ga:cohort'] as $key => $value) {
                
                $nth = substr($query->dimensions[$nthDimension][$key], -1);
                
                $data['cohorts'][$value][$nth] = array(
                    'retentionRate' => (int) $query->metrics['ga:cohortRetentionRate'][$key],
                    'activeUsers' => $query->metrics['ga:cohortTotalUsersWithLifetimeCriteria'][$key]
                );

            }
            
            while ($dateStart <= $dateEnd) {

                if ($dateDifference > 41) {
    
                    $cohortName = $dateStart->format('Y-m-d') . '|';
                    $cohortName .= $dateStart->format('Y-m-t');

                    $dateStart->modify('+1 month');

                } elseif ($dateDifference > 6) {
    
                    $cohortName = $dateStart->format('Y-m-d') . '|';
                    $dateStart->modify('+6 day');
                    $cohortName .= $dateStart->format('Y-m-d');

                    if (!isset($data['cohorts'][$cohortName]))
                        $data['cohorts'][$cohortName] = array();
                    
                    for ($i = 0; $i < $nthCount; $i++) {
                        if (!isset($data['cohorts'][$cohortName][$i]))
                            $data['cohorts'][$cohortName][$i] = array(
                                'retentionRate' => 0,
                                'activeUsers' => 0
                            );
                    }

                    $dateStart->modify('+1 day');

                } else {

                    $cohortName = $dateStart->format('Y-m-d');
                    
                    if (!isset($data['cohorts'][$cohortName]))
                        $data['cohorts'][$cohortName] = array();
                    
                    for ($i = 0; $i < $nthCount; $i++) {
                        if (!isset($data['cohorts'][$cohortName][$i]))
                            $data['cohorts'][$cohortName][$i] = array(
                                'retentionRate' => 0,
                                'activeUsers' => 0
                            );
                    }

                    $dateStart->modify('+1 day');
                    
                }

                ksort($data['cohorts'][$cohortName]);

                $nthCount--;

            }
            
            ksort($data['cohorts']);
            
            foreach ($data['cohorts'] as $key => $value) {

                if ($nthType == 'Day') {
                    $date = new DateTime($key);
                    $dataLabel = $date->format('M j');
                } else {
                    $date = explode('|', $key);
                    $dateStart = new DateTime($date[0]);
                    $dateEnd = new DateTime($date[1]);
                    $dataLabel = $dateStart->format('M j') . ' - ' . $dateEnd->format('M j');
                }

                $results['cohorts'][$dataLabel] = $value; 
            }

        }

        return response($this->load->view('cohortAnalysis', $results, true), 'html');
    }

    public function getAnalytics()
    {
        // Get input data
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $metrics = $this->input->get('metrics');
        $dimensions = $this->input->get('dimensions');
        $data = array();

        // Run the analytic query
        $query = Modules::run('google/analytics/get', $start, $end, $metrics, $dimensions);

        // Fetch chart categories
        foreach ($query->dimensions['ga:date'] as $key => $value) {
            $data['categories'][] = $value;
        }

        // Fetch metrics data
        foreach ($query->metrics as $key => $value) {
            $data['series'][] = array(
                'name' => $key,
                'data' => array_map('intval', $value)
            );
        }
        
        // Return the results
        return response($data);
    }
}