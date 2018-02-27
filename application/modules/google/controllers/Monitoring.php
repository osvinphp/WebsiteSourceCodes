<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Cloud\Monitoring\V3\MetricServiceClient;
use Google\Monitoring\V3\TimeInterval;
use Google\Monitoring\V3\ListTimeSeriesRequest_TimeSeriesView;
use Google\Protobuf\Timestamp;

class Monitoring extends MX_Controller 
{
    public $client;
    public $projectId;

    public function __construct()
    {
        parent::__construct();
        
        $this->client = new Google_Client();
        $this->client->setAuthConfig(json_decode($_SESSION['siteConfigs']->get('analyticServiceAccount'), true));
        $this->client->addScope('https://www.googleapis.com/auth/cloud-platform');
        
        $this->projectId = 'projects/lorien-analytics';
    }

    public function get($type, $start, $end)
    {
        switch ($type) {
            case 'cpu':
                $filter = 'metric.type="compute.googleapis.com/instance/cpu/utilization"';
            break;

            case 'disk':
                $filter = 'metric.type="compute.googleapis.com/instance/network/received_bytes_count';
            break;

            case 'memory':
            break;
        }

        $metrics = new MetricServiceClient([
            'projectId' => $this->projectId,
        ]);

        $projectName = $metrics->formatProjectName($this->projectId);
    
        // Limit results to the last 20 minutes
        $startTime = new Timestamp();
        $startTime->setSeconds($start);

        $endTime = new Timestamp();
        $endTime->setSeconds($end);
    
        $interval = new TimeInterval();
        $interval->setStartTime($startTime);
        $interval->setEndTime($endTime);
    
        $view = ListTimeSeriesRequest_TimeSeriesView::FULL;
    
        $result = $metrics->listTimeSeries($projectName, $filter, $interval, $view);
        
        foreach ($result->iterateAllElements() as $timeSeries) {
            
            $instanceName = $timeSeries->getMetric()->getLabels()['instance_name'];
            
            foreach ($timeSeries->getPoints() as $point) {
                $data[$instanceName][] = array(
                    (int) gmdate('U', $point->getInterval()->getEndTime()->getSeconds()),
                    $point->getValue()->getDoubleValue()
                );
            }

        }

        return $data;
    }

    public function getClientApi($type, $start, $end)
    {
        $results = [];

        switch ($type) {
            case 'cpu':
                $filter = 'metric.type="compute.googleapis.com/instance/cpu/utilization"';
                $dataLabel = 'doubleValue';
            break;

            case 'disk-read':
                $filter = 'metric.type="compute.googleapis.com/instance/disk/read_bytes_count"';
                $dataLabel = 'int64Value';
            break;

            case 'disk-write':
                $filter = 'metric.type="compute.googleapis.com/instance/disk/write_bytes_count"';
                $dataLabel = 'int64Value';
            break;

            case 'disk-ops-read':
                $filter = 'metric.type="compute.googleapis.com/instance/disk/read_ops_count"';
                $dataLabel = 'int64Value';
            break;

            case 'disk-ops-write':
                $filter = 'metric.type="compute.googleapis.com/instance/disk/write_ops_count"';
                $dataLabel = 'int64Value';
            break;

            case 'network-bytes-received':
                $filter = 'metric.type="compute.googleapis.com/instance/network/received_bytes_count"';
                $dataLabel = 'int64Value';
            break;

            case 'network-bytes-sent':
                $filter = 'metric.type="compute.googleapis.com/instance/network/sent_bytes_count"';
                $dataLabel = 'int64Value';
            break;
        }

        $params = array(
            'interval.startTime' => gmdate('Y-m-d\TH:i:s\Z', $start),
            'interval.endTime' => gmdate('Y-m-d\TH:i:s\Z', $end),
            'filter' => $filter
        );

        $service = new Google_Service_Monitoring($this->client);
        $response = $service->projects_timeSeries->listProjectsTimeSeries($this->projectId, $params);
        
        $cloudInstances = $response->getTimeSeries();
        
        foreach ($cloudInstances as $instance) {

            $instanceName = $instance->getMetric()->getLabels()['instance_name'];

            if ($type == 'disk-read' || $type == 'disk-write' || $type == 'disk-ops-read' || $type == 'disk-ops-write') {

                $deviceName = $instance->getMetric()->getLabels()['device_name'];
                $instanceName = $instance->getMetric()->getLabels()['instance_name'];

                if ($deviceName == 'disk-1')
                    continue;

            }
            
            $points = $instance->getPoints();

            foreach ($points as $point) {
                
                $pointInterval = $point->getInterval();
                $start = new DateTime($pointInterval->getStartTime());
                $end = new DateTime($pointInterval->getEndTime());
                $value = $point->getValue()[$dataLabel];
                
                $results[$instanceName][] = array(
                    (int) $start->getTimestamp(), (double) $value
                );

            }

        }
        
        return $results;
    }
}