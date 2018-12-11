<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    private $api_key;
    private $_density_list;
    private $_success_response_code = 1003; //success;

    const RESPONSE_TYPE_SUCCESS = 'success';
    const RESPONSE_TYPE_ERROR = 'error';
    const RESPONSE_TYPE_USER_ERROR = 'userError';

    function __construct() {
        parent::__construct();
      
        $this->db->query("SET time_zone='+6:00'"); // do not change this value
        // load the model
        $this->load->model('api_model');
        $this->config->load('api_response_codes');
        // dessity list
        $this->_density_list = array('xxxhdpi', 'xxhdpi', 'xhdpi', 'mdpi', 'hdpi');
        $this->api_key = $this->input->post('api_key') ? $this->input->post('api_key') : '';
    }

    // save Device Info
    public function saveDeviceInfo() {
        $this->form_validation
                ->set_rules('api_key', 'API Key', 'trim|required')
                ->set_rules('user_id', 'User Id', 'trim')
                ->set_rules('device_push_id', 'Device Push ID', 'trim|min_length[4]')
                ->set_rules('device_uuid', 'Device uuid', 'trim|required|min_length[12]')
                ->set_rules('app_version_name', 'App Version Name', 'trim|required|min_length[1]')
                ->set_rules('app_version_code', 'App Version Code', 'trim|required|min_length[1]')
                ->set_rules('device_type', 'Device Type', 'trim|required|integer|min_length[1]|max_length[1]')
                ->set_rules('device_width', 'Device Width', 'trim|required|numeric')
                ->set_rules('device_height', 'Device Height', 'trim|required|numeric')
                ->set_rules('device_manufacturer', 'device manufacturer', 'trim')
                ->set_rules('device_brand', 'device brand', 'trim')
                ->set_rules('device_product', 'device product', 'trim')
                ->set_rules('device_model', 'device model', 'trim')
                ->set_rules('device_os_version', 'device os version', 'trim')
                ->set_rules('device_sdk_version', 'device api version', 'trim')
                ->set_rules('utm_campaign', 'Utm Campaign', 'trim')
                ->set_rules('utm_content', 'Utm Content', 'trim')
                ->set_rules('utm_source', 'Utm Source', 'trim')
                ->set_rules('utm_medium', 'Utm Medium', 'trim')
                ->set_rules('utm_term', 'Utm Term', 'trim');
        if ($this->input->post('device_type') == 2) {
            $this->form_validation->set_rules('device_density', 'Device Density', 'trim|required|in_list[mdpi,hdpi,xhdpi,xxhdpi,xxxhdpi,ldpi]');
        } else {
            $this->form_validation->set_rules('device_density', 'Device Density', 'trim|required');
        }
        //form validation
        if ($this->form_validation->run() == FALSE) {
            $this->sendFormVelidationErrorResponse();
        }
        // api key varification
        $this->verifyAPIKey($this->api_key);

        $postData = array();
        $postData['device_push_id'] = $device_push_id = ($this->input->post('device_push_id')) ? $this->input->post('device_push_id') : NULL;
        $postData['device_uuid'] = $uuid = $this->input->post('device_uuid');
        $postData['app_version_name'] = ($this->input->post('app_version_name')) ? $this->input->post('app_version_name') : 'N/A';
        $postData['app_version_code'] = ($this->input->post('app_version_code')) ? $this->input->post('app_version_code') : 'N/A';
        $postData['device_type'] = $this->input->post('device_type');
        $postData['device_density'] = $this->input->post('device_density');
        $postData['device_width'] = $this->input->post('device_width');
        $postData['device_height'] = $this->input->post('device_height');
        $postData['device_manufacturer'] = !empty($this->input->post('device_manufacturer')) ? $this->input->post('device_manufacturer') : NULL;
        $postData['device_brand'] = !empty($this->input->post('device_brand')) ? $this->input->post('device_brand') : NULL;
        $postData['device_product'] = !empty($this->input->post('device_product')) ? $this->input->post('device_product') : NULL;
        $postData['device_model'] = !empty($this->input->post('device_model')) ? $this->input->post('device_model') : NULL;
        $postData['device_os_version'] = !empty($this->input->post('device_os_version')) ? $this->input->post('device_os_version') : NULL;
        $postData['device_api_version'] = !empty($this->input->post('device_sdk_version')) ? $this->input->post('device_sdk_version') : NULL;

        $postData['utm_campaign'] = ($this->input->post('utm_campaign')) ? $this->input->post('utm_campaign') : NULL;
        $postData['utm_source'] = ($this->input->post('utm_source')) ? $this->input->post('utm_source') : NULL;
        $postData['utm_medium'] = ($this->input->post('utm_medium')) ? $this->input->post('utm_medium') : NULL;
        $postData['utm_term'] = ($this->input->post('utm_term')) ? $this->input->post('utm_term') : NULL;
        $postData['utm_content'] = ($this->input->post('utm_content')) ? $this->input->post('utm_content') : NULL;

        $customerId = !empty($this->input->post('customer_id')) ? $this->input->post('customer_id') : 0;
        $postData['customer_id'] = $customerId;

        if (is_string($customerId) && (strlen($customerId) > 1)) {

            if ($userId = $this->getInternalCutomerIDByExternalCutomerID($customerId)) {
                $postData['customer_id'] = $customerId;
            } else {
                $response_code = 1019; //Unauthorized access
                $this->logCustomerActivity($postData['customer_id'], $response_code, $this->config->item('response_code')[$response_code], 'customerId: ' . $this->input->post('customer_id') . ' not found in db');
                $this->JSONErrorOutput($response_code);
            }
        } else {
            $postData['customer_id'] = $customerId;
        }

        //save the 
        if (($this->api_model->updateDeviceInfo($postData) == TRUE) && ($this->api_model->updateDeviceActivityLog($postData) == TRUE)) {
            $data = array();
            $response_code = 1020; //Updated successfully
            if ($postData['customer_id'] != 0) {
                // update user info
                $this->updateCustomerData($postData['customer_id'], $uuid, $device_push_id);
                $this->logCustomerActivity($postData['customer_id'], $response_code, $this->config->item('response_code')[$response_code], 'Device info updated for customerId: ' . $postData['customer_id']);
            }
            $this->JSONSuccessOutput($data, $response_code);
        } else {
            $response_code = 1021; //Update failed
            if ($postData['customer_id'] != 0) {
                $this->logCustomerActivity($postData['customer_id'], $response_code, $this->config->item('response_code')[$response_code], 'Device info faield to update for customerId: ' . $postData['customer_id']);
            }
            $this->JSONErrorOutput($response_code);
        }
    }
    
    // start chat
    public function startChat(){        
        $this->form_validation
                ->set_rules('api_key', 'API Key', 'trim|required')
                ->set_rules('topic_title', 'Topic Title', 'trim|required')
                ->set_rules('totpic_desc', 'Topic Details', 'trim');
        //form validation
        if ($this->form_validation->run() == FALSE) {
            $this->sendFormVelidationErrorResponse();
        }
        // api key varification
        $this->verifyAPIKey($this->api_key);
        
        $data = array();
        $data['user_id'] = 5;
        $data['user_image_url'] = 'http://lorempixel.com/output/people-q-c-300-300-9.jpg';
        $data['user_type'] = 'support team';
        $data['text'] = 'How May I help you?';
        $data['time'] = date('Y-m-d H:i A', time());
        $data['show_time'] = '';
        $this->JSONSuccessOutput($data, $this->_success_response_code);        
    }


    public function updateAPIKey() {
        $updateData = array(
            'update_api_key' => $this->input->post('update_api_key')
        );
        return $this->api_model->updateAPIKey($updateData);
    }

    public function getAppSettings() {
        $data = array();
        // api key varification
        $this->verifyAPIKey($this->api_key);
        
        $data['splash_image'] = base_url('assets/apps/images/splash/01.png');
        $data['app_home'] = site_url('apps/home');
        $this->JSONSuccessOutput($data, $this->_success_response_code);
    }

    public function code_test() {
        //$status = mailSend(array('aditya@technobd.com'), 'amar mail jain na kano', 'ei to email gache');
        //var_dump($status);
        $this->load->library('uuid');
        $this->messaging->setType('fcm');
        $this->messaging->setFCMData($receiveIdArray, $row->message, $fcmHeaders->priority, $fcmHeaders->data);
        $response['fcm'] = $this->messaging->send();
    }

    public function pushTest() {
        $userId = $this->input->get('user_id');
        $user = $this->api_model->get_data('users', array('id' => $userId));
        if (!$user) {
            echo "Push Not Send : User not found!!";
            die();
        }
        $receiveIdArray[] = $user->device_push_id;

        $fcmdata = array();
        $fcmdata['type'] = 'registration';
        $fcmdata['message'] = 'Welcome to Kawasaki Motor APPS';
        $message = 'Welcome to Kawasaki Motor';

        $this->load->library('messaging');
        $this->messaging->setType('fcm');
        $this->messaging->setFCMData($receiveIdArray, $message, 'normal', $fcmdata);
        $fcmStatus = $this->messaging->send();

        print "<pre>";
        print_r($fcmStatus);
        print "</pre>";
        die();
    }

    public function file_validate($fieldValue, $params) {
        // get the parameter as variable
        list($require, $fieldName, $type) = explode('.', $params);
        // get the file field name
        $filename = isset($_FILES[$fieldName]['name']) ? $_FILES[$fieldName]['name'] : '';
        if ($filename == '' && $require == 'yes') {
            $this->form_validation->set_message('file_validate', 'The %s field is required');
            return FALSE;
        } elseif ($type != '' && $filename != '') {
            // get the extention
            $ext = strtolower(substr(strrchr($filename, '.'), 1));
            // get the type as array
            $types = explode(',', $type);
            if (!in_array($ext, $types)) {
                $this->form_validation->set_message('file_validate', 'The %s field must be ' . implode(' OR ', $types) . ' !!');
                return FALSE;
            }
        } else
            return TRUE;
    }

    private function getInternalCutomerIDByExternalCutomerID($cutomer_id) {
        $row = $this->api_model->get_data('customers', array('customer_id' => $cutomer_id));
        if (!$row) {
            return FALSE;
        }
        return $row->id;
    }

    private function getExternalCutomerIDByInternalCutomerID($cutomer_id) {
        $row = $this->api_model->get_data('customers', array('id' => $cutomer_id));
        if (!$row) {
            return FALSE;
        }
        return $row->customer_id;
    }

    private function logActivity($type, $message) {
        if ($this->config->item('log_activity') == TRUE) {
            if ($type == 'error') {
                log_message('error', $message);
            } elseif ($type == 'debug') {
                log_message('debug', $message);
            } else {
                log_message('info', $message);
            }
        }
    }

    private function logCustomerActivity($userId = 0, $code = NULL, $message = NULL, $internalMessage = NULL) {
        $deviceUUID = !empty($this->input->post('device_uuid')) ? $this->input->post('device_uuid') : NULL;
        $userData = !empty($this->input->post()) ? $this->input->post() : NULL;
        $data = array(
            'customer_id' => $userId,
            'device_uuid' => $deviceUUID,
            'code' => $code,
            'message' => $message,
            'internal_message' => $internalMessage,
            'user_data' => json_encode($userData),
            'source_url' => current_url()
        );
        $this->api_model->insert('customer_activity_logs', $data);
    }

    private function verifyAPIKey($apiKey) {
        if (!$this->api_model->doesMatchApiKey($apiKey)) {
            $response_code = 1001; //api key not matched
            $this->JSONErrorOutput($response_code);
        } else {
            return TRUE;
        }
    }

    private function getCountryInfo($countryISO) {
        $row = $this->api_model->get_row('countries', array('code' => $countryISO));
        if ($row) {
            return $row;
        } else {
            return FALSE;
        }
    }

    private function sendFormVelidationErrorResponse() {
        $code = 1002; //One or more required field missing
        $error = !empty(str_replace("\n", ' ', strip_tags(validation_errors()))) ? str_replace("\n", ' ', strip_tags(validation_errors())) : $this->config->item('response_code')[$code];

        $this->JSONErrorOutput($code, Api::RESPONSE_TYPE_USER_ERROR, $error);
    }

    // api success out put
    private function JSONSuccessOutput($data = array(), $response_code, $msg = '') {
        header('Content-Type: application/json');
        $response = array();
        $response['code'] = $response_code;
        $response['type'] = Api::RESPONSE_TYPE_SUCCESS;
        $response['message'] = ($msg == '') ? $this->getResponseMessage($response_code) : $msg;
        if (count($data)) {
            $response['data'] = $data;
        }
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    // api error output
    private function JSONErrorOutput($response_code, $type = Api::RESPONSE_TYPE_ERROR, $error_msg = '') {
        header('Content-Type: application/json');
        $response = array();
        $response['code'] = $response_code;
        $response['type'] = $type;
        $response['message'] = $message = ($error_msg == '') ? $this->getResponseMessage($response_code) : $error_msg;

        // log write for error response
        $this->logActivity('error', 'Code : ' . $response_code . ' -> ' . $message . '</br>Source -> ' . current_url() . '</br>User Input Data ->' . json_encode($this->input->post()));

        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    private function getResponseMessage($response_code) {
        return $this->config->item('response_code')[$response_code];
    }

}
