<?php defined('BASEPATH') OR exit('No direct script access allowed');

    if (!function_exists('response'))
    {
        function response($data, $type = null)
        {
            switch($type) {
                case 'json':
                    $contentType = 'application/json';
                    $data = json_encode($data, JSON_PRETTY_PRINT);
                break;

                case 'html':
                    $contentType = 'text/html';
                break;

                default:
                    $contentType = 'application/json';
                    $data = json_encode($data, JSON_PRETTY_PRINT);
                break;
            }

            $CI = get_instance();

            $CI->output
                ->set_content_type($contentType)
                ->set_status_header(200)
                ->set_output($data)
                ->_display();

            exit;
        }
    }

    if (!function_exists('date_db'))
    {
        function date_db($date)
        {
            return date_format(date_create($date), 'Y-m-d');
        }
    }

    if (!function_exists('date_view'))
    {
        function date_view($date)
        {
            return date_format(date_create($date), 'd-m-Y');
        }
    }

    if (!function_exists('date_in_range'))
    {
        function date_in_range($startDate, $endDate, $date)
        {
            // Convert to timestamp
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);
            $date = strtotime($date);

            // Check that user date is between start & end
            return (($date >= $startDate) && ($date <= $endDate));
        }
    }

    if (!function_exists('time_in_range'))
    {
        function time_in_range($start, $end, $time)
        {
            // Convert to timestamp
            $start = strtotime($start);
            $end = strtotime($end);
            $time = strtotime($time);

            // Check that user time is between start & end
            return (bool) (($time >= $start) && ($time <= $end));
        }
    }

    if (!function_exists('time_elapsed'))
    {
        function time_elapsed($datetime, $full = false) {

            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
    }

    if (!function_exists('clean_input'))
    {
        function clean_input($string)
        {
            $CI = get_instance();
            $string = $CI->security->xss_clean($string);
            $string = html_escape($string);
            return $string;
        }
    }

    if (!function_exists('compare_data'))
    {
        function compare_data($main, $values = [])
        {
            $set_minimize = function ($value)
            {
                return strtolower($value);
            };

            $main = strtolower($main);

            foreach (array_map($set_minimize, $values) as $value)
            {
                if (strpos($value, $main) !== FALSE)
                {
                    return TRUE;
                }
            }

            return FALSE;
        }
    }

    if (!function_exists('remove_keys'))
    {
        function remove_keys($result)
        {
            $data = [];

            foreach ($result as $value)
            {
                $data[] = $value;
            }

            return $data;
        }
    }

    if (!function_exists('custom_search_array'))
    {
        function custom_search_array($rows, $search_phrase, $compare_keys)
        {
            $format_data = function ($rows) use ($search_phrase, $compare_keys)
            {
                $compare = [];

                foreach ($compare_keys as $value)
                {
                    $compare[] = $rows[$value];
                }

                if (compare_data($search_phrase, $compare))
                {
                    return $rows;
                }
            };

            $rows = array_map($format_data, $rows);
            $rows = array_filter($rows);

            return remove_keys($rows);
        }
    }

    if (!function_exists('debug_this'))
    {
        function debug_this($data)
        {
            die(print_r($data));
        }
    }

    if (!function_exists('round_this'))
    {
        function round_this($double, $round = 5)
        {
            return (float) number_format($double, $round, '.', ',');
        }
    }

    if (!function_exists('filesize_from_url'))
    {
        function filesize_from_url($url) 
        {
            static $regex = '/^Content-Length: *+\K\d++$/im';

            if (!$fp = @fopen($url, 'rb')) {
                return false;
            }
            
            if (
                isset($http_response_header) &&
                preg_match($regex, implode("\n", $http_response_header), $matches)
            ) {
                return (int)$matches[0];
            }
            
            return strlen(stream_get_contents($fp));
        }
    }

    if (!function_exists('encode_message'))
    {
        function encode_message($message, $password = '0123456789') 
        {
            $cryptor = new \RNCryptor\RNCryptor\Encryptor;
            $plaintext = $cryptor->encrypt($message, $password);
            
            return $plaintext;
        }
    }

    if (!function_exists('decode_message'))
    {
        function decode_message($message, $password = '0123456789') 
        {
            $cryptor = new \RNCryptor\RNCryptor\Decryptor;
            $plaintext = $cryptor->decrypt($message, $password);
            
            return $plaintext;
        }
    }

    if (!function_exists('decode_file'))
    {
        function decode_file($type, $fileUrl, $password = '0123456789') 
        {
            $data = file_get_contents($fileUrl);
            $base64Encrypted = base64_encode($data);
    
            $cryptor = new \RNCryptor\RNCryptor\Decryptor;
            $plaintext = $cryptor->decrypt($base64Encrypted, $password);

            switch ($type) {
                case 'picture':
                    $src = 'data:image/' . 'jpg' . ';base64,' . base64_encode($plaintext);
                break;

                case 'video':
                    $src = 'data:video/' . 'mp4' . ';base64,' . base64_encode($plaintext);
                break;

                case 'audio':
                    $src = 'data:audio/' . 'mpeg' . ';base64,' . base64_encode($plaintext);
                break;
            }
            
            return $src;
        }
    }

    if (!function_exists('create_initials'))
    {
        function create_initials($name) 
        {
            $initial = '';
            preg_match_all("/[A-Z]/", ucwords(strtolower($name)), $matches);

            for ($i = 0; $i < 2; $i++) {
                $initial .= $matches[0][$i];
            }

            return $initial;
        }
    }

    if (!function_exists('my_role'))
    {
        function my_role() {
            return $_SESSION['parseData']['user']->roleName;
        }
    }