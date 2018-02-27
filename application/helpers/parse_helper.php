<?php defined('BASEPATH') OR exit('No direct script access allowed');

    if (!function_exists('fetch_user_avatar'))
    {
        function fetch_user_avatar($user)
        {
            if (!$user)
                return base_url('uploads/avatars/noavatar.png');

            if ($user->get('profilePicture')) {

                $avatar = $user->get('profilePicture')->getURL();

            } else {

                switch ($user->get('gender'))
                {
                    case 'Male':
                        $avatar = base_url('uploads/avatars/male.jpg');
                    break;

                    case 'Female':
                        $avatar = base_url('uploads/avatars/female.jpg');
                    break;

                    default:
                        $avatar = base_url('uploads/avatars/noavatar.png');
                    break;
                }

            }
            
            return $avatar;
        }
    }