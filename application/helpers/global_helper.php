<?php

// generate the password and secret
if (!function_exists('geneSecurePass')) {

    function geneSecurePass($password, $secret = false) {

        if ($secret) {
            // create the salt using secret
            list($salt1, $salt2) = str_split($secret, ceil(strlen($secret) / 2));
            $code = md5($salt1 . $password . $salt2);
        } else {
            // generate the randomcode
            $code['secret'] = $secret = rand(100000, 999999);
            // create the salt using secret
            list($salt1, $salt2) = str_split($secret, ceil(strlen($secret) / 2));
            // generate the password
            $code['password'] = md5($salt1 . $password . $salt2);
        }

        return $code;
    }

}

// create paggination configuratin
if (!function_exists('createPagging')) {

    function createPagging($page_url, $total_rows, $per_page, $uri_segment = 3, $num_links = 2) {
        $CI = &get_instance();
        //load the pagging library
        $CI->load->library('pagination');
        // set the configuration
        $config['base_url'] = site_url($page_url);
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        //$config['uri_segment'] = $uri_segment;
        $config['num_links'] = $num_links;

        $config['page_query_string'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers'] = TRUE;

        // pagging design section
        //full tag
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        // first tag
        $config['first_link'] = '<span aria-hidden="true">First</span>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        //Last Link
        $config['last_link'] = '<span aria-hidden="true">Last</span>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        //“Next” Link
        $config['next_link'] = '<span aria-hidden="true">Next</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        //"privious" link
        $config['prev_link'] = '<span aria-hidden="true">Privious</span>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';


        //"Current Page" Link
        $config['cur_tag_open'] = '<li class = "active"><a href = "javascript:void(0)">';
        $config['cur_tag_close'] = '</a></li>';

        // "Digit" Link
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';


        $CI->pagination->initialize($config);
    }

}

/**
 * @package Helper
 * @subpackage mailSend
 * @return string
 * @author Aditya <aditya.cse04@gmail.com>
 */
if (!function_exists('mailSend')) {

    function mailSend($to_address = array(), $subject = '', $message = '', $attachment = false) {
        // get the CI instanse
        $CI = &get_instance();
        $config = array('protocol' => 'smtp',
            'smtp_host' => 'apicta.org.bd',
            'smtp_port' => '25',
            'smtp_user' => 'info@apicta.org.bd',
            'smtp_pass' => 'OOHq;_cZfl+e',
            'charset' => 'utf-8',
            'newline' => '\r\n',
            'mailtype' => 'html',
            'smtp_timeout' => 15,
            'validation' => TRUE);
        // clear the mail
        $CI->email->clear();
        $CI->email->initialize($config);
        $CI->email->from('info@apicta.org.bd', $CI->config->item('full_title'));
        $CI->email->to($to_address);

        $CI->email->subject($subject);

        $CI->email->message($message);
        // attach file if found
        if ($attachment) {
            $CI->email->attach($attachment);
        }
        try {
            if ($CI->email->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

}

// function show the sub string text
if (!function_exists('showText')) {

    function showText($str = '', $length = 0) {
        $string = strip_tags($str);
        if (strlen($string) > ($length + 3)) {
            $substr = mb_substr($string, 0, $length);
            $new_length = strrpos($substr, " ", -1);
            return substr($substr, 0, $new_length) . '...';
        } else {
            return $string;
        }
    }

}

// function convert number
if (!function_exists('convert_number')) {

    function convert_number($number, $lang = 'en') {
        $bn_array = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",", "ই", "লা", "রা", "য়");
        $en_array = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ":", ",", "th", "st", "nd", "rd");
        if ($lang == 'en') {
            $convert_num = str_replace($bn_array, $en_array, $number);
        } elseif ($lang == 'bn') {
            $convert_num = str_replace($en_array, $bn_array, $number);
        }
        return $convert_num;
    }

}

if (!function_exists('get_photo')) {

    function get_photo($filename, $path, $type = '') {
        // set the path base on type
        if ($type != '') {
            $path .= $type . "/";
        }

        if (!empty($filename)) {
            if (!file_exists($path . $filename)) {
                return base_url($path . 'nophoto.jpg');
            } else {
                return base_url($path . $filename);
            }
        } else {
            return base_url($path . 'nophoto.jpg');
        }
    }

}

// return human readable date time
if (!function_exists('show_date')) {

    function show_date($dateTime, $format = 'datetime') {
        $intTime = (!ctype_digit($dateTime)) ? strtotime($dateTime) : $dateTime;
        if ($intTime) {
            switch ($format) {
                case 'datetime':
                    return date('jS M, Y \a\t h:i:s a', $intTime);
                case 'date_time':
                    return date('j M y, h:i A', $intTime);
                case 'date':
                    return date('jS F, Y', $intTime);
                case 'time':
                    return date('h:i', $intTime);
                case 'short':
                    return date('jS M, y', $intTime);
                case 'MY':
                    return date('F Y', $intTime);
                case 'Y':
                    return date('Y', $intTime);
                case 'M':
                    return date('F', $intTime);
                case 'full':
                    return date('j M, Y h:i:s a', $intTime);
                case 'md':
                    return date('j M, h:i a', $intTime);
                case 'activity_time':
                    return date('d.m.y, h:i A', $intTime);
                default:
                    break;
            }
        } else
            return "Not yet";
    }

}

// image resize
if (!function_exists('img_resize')) {

    function img_resize($ini_path, $dest_path, $params = array()) {
        $width = !empty($params['width']) ? $params['width'] : null;
        $height = !empty($params['height']) ? $params['height'] : null;
        $constraint = !empty($params['constraint']) ? $params['constraint'] : false;
        $rgb = !empty($params['rgb']) ? $params['rgb'] : 0xFFFFFF;
        $quality = !empty($params['quality']) ? $params['quality'] : 100;
        $aspect_ratio = isset($params['aspect_ratio']) ? $params['aspect_ratio'] : true;
        $crop = isset($params['crop']) ? $params['crop'] : true;

        if (!file_exists($ini_path))
            return false;

        if (!is_dir($dir = dirname($dest_path)))
            mkdir($dir);

        $img_info = getimagesize($ini_path);

        if ($img_info === false)
            return false;


        $ini_p = $img_info[0] / $img_info[1];
        if ($constraint) {
            $con_p = $constraint['width'] / $constraint['height'];
            $calc_p = $constraint['width'] / $img_info[0];

            if ($ini_p < $con_p) {
                $height = $constraint['height'];
                $width = $height * $ini_p;
            } else {
                $width = $constraint['width'];
                $height = $img_info[1] * $calc_p;
            }
        } else {
            if (!$width && $height) {
                $width = ($height * $img_info[0]) / $img_info[1];
            } else if (!$height && $width) {
                $height = ($width * $img_info[1]) / $img_info[0];
            } else if (!$height && !$width) {
                $width = $img_info[0];
                $height = $img_info[1];
            }
        }

        preg_match('/\.([^\.]+)$/i', basename($dest_path), $match);
        $ext = strtolower($match[1]);
        $output_format = ($ext == 'jpg') ? 'jpeg' : $ext;

        $format = strtolower(substr($img_info['mime'], strpos($img_info['mime'], '/') + 1));
        $icfunc = "imagecreatefrom" . $format;

        $iresfunc = "image" . $output_format;

        if (!function_exists($icfunc))
            return false;

        $dst_x = $dst_y = 0;
        $src_x = $src_y = 0;
        $res_p = $width / $height;
        if ($crop && !$constraint) {
            $dst_w = $width;
            $dst_h = $height;
            if ($ini_p > $res_p) {
                $src_h = $img_info[1];
                $src_w = $img_info[1] * $res_p;
                $src_x = ($img_info[0] >= $src_w) ? floor(($img_info[0] - $src_w) / 2) : $src_w;
            } else {
                $src_w = $img_info[0];
                $src_h = $img_info[0] / $res_p;
                $src_y = ($img_info[1] >= $src_h) ? floor(($img_info[1] - $src_h) / 2) : $src_h;
            }
        } else {
            if ($ini_p > $res_p) {
                $dst_w = $width;
                $dst_h = $aspect_ratio ? floor($dst_w / $img_info[0] * $img_info[1]) : $height;
                $dst_y = $aspect_ratio ? floor(($height - $dst_h) / 2) : 0;
            } else {
                $dst_h = $height;
                $dst_w = $aspect_ratio ? floor($dst_h / $img_info[1] * $img_info[0]) : $width;
                $dst_x = $aspect_ratio ? floor(($width - $dst_w) / 2) : 0;
            }
            $src_w = $img_info[0];
            $src_h = $img_info[1];
        }

        $isrc = $icfunc($ini_path);
        $idest = imagecreatetruecolor($width, $height);
        if (($format == 'png' || $format == 'gif                  ') && $output_format == $format) {
            imagealphablending($idest, false);
            imagesavealpha($idest, true);
            imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
            imagealphablending($isrc, true);
            $quality = 0;
        } else {
            imagefill($idest, 0, 0, $rgb);
        }
        imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        $res = $iresfunc($idest, $dest_path, $quality);


//imagedestroy($isrc);
//imagedestroy($idest);

        return $res;
    }

}


if (!function_exists('longDateHuman')) {

    function longDateHuman($dateTime, $format = 'datetime') {
        $intTime = (!ctype_digit($dateTime)) ? strtotime($dateTime) : $dateTime;
        if ($intTime) {
            switch ($format) {
                case 'datetime':
                    return date('jS M, Y \a\t h:i:s a', $intTime);
                case 'date_time':
                    return date('j M y, h:i A', $intTime);
                case 'date':
                    return date('jS F, Y', $intTime);
                case 'time':
                    return date('h:i', $intTime);
                case 'short':
                    return date('jS M, y', $intTime);
                case 'MY':
                    return date('F Y', $intTime);
                case 'Y':
                    return date('Y', $intTime);
                case 'M':
                    return date('F', $intTime);
                case 'full':
                    return date('j M Y, h:i a', $intTime);
                case 'md':
                    return date('j M, h:i a', $intTime);
                case 'task_time':
                    return date('M j, Y h:i a', $intTime);
                case 'task_date':
                    return date('M j, Y', $intTime);
                default:
                    break;
            }
        } else
            return "Not yet";
    }

}
