<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends CI_Controller {

    public $_module_name;
    public $_module;
    public $_file_path = './assets/media/admin_user/';

    function __construct() {
        parent::__construct();
        // load the specific model
        $this->load->model('admin_user_model');

        // set the global variable
        $this->_module_name = 'Admin User';
        $this->_module = 'admin_user';

        // load the custom file processing library
        $this->load->library('file_processing');

        //check login if user is login or not if nor redirect to login page
        if (!check_admin_login()) {
            $this->session->set_flashdata('error_msg', 'Please login first !!');
            redirect('auth/login');
        }
    }

    // manage all information
    public function index() {
        // set the page name
        $data = array();
        $data['module'] = $this->_module;
        $data['module_name'] = $this->_module_name;
        $data['page_active'] = $this->_module . '_manage';
        $data['page_title'] = 'Manage Users';
        $data['show_date_range'] = 'no';
        $data['photo_path'] = $this->_file_path;

        // get the all information
        $data['allData'] = $this->admin_user_model->get_list(0);
        $data['user_levels'] = getUserLevels(1);

        // load the views
        $this->load->view('header', $data);
        $this->load->view($this->_module . '/manage', $data);
        $this->load->view('footer', $data);
    }

    // create new information
    public function create() {
        // set the page name
        $data['module'] = $this->_module;
        $data['module_name'] = $this->_module_name;
        $data['page_active'] = $this->_module . '_create';
        $data['page_title'] = "Add New " . $this->_module_name;
        $data['photo_path'] = $this->_file_path;

        // check if click on the submit button
        if ($this->input->post('save')) {

            // write the validation rule
            $this->form_validation
                    ->set_rules('level_id', 'User Level', 'required')
                    ->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[admin_users.email]')
                    ->set_rules('password', 'Password', 'trim|required|matches[confirm_password]')
                    ->set_rules('confirm_password', 'Confirm Password', 'trim|required')
                    ->set_rules('full_name', 'Full Name', 'trim|required')
                    ->set_rules('phone', 'Phone Number ', 'trim|numeric|exact_length[11]')
                    ->set_rules('photo', 'User Photo', 'callback_file_validate[no.photo.jpg,jpeg,gif,png]')
            ;
            // check the validation
            if ($this->form_validation->run()) {
                // receved the post value and store into array               
                $addData['admin_user_type_id'] = $this->input->post('level_id');
                $addData['email'] = $this->input->post('email');
                // generate the password and secret code
                $code = geneSecurePass($this->input->post('password'));
                $addData['password'] = $code['password'];
                $addData['secret'] = $code['secret'];
                $addData['full_name'] = $this->input->post('full_name');
                $addData['photo'] = $this->file_processing->image_upload('photo', $this->_file_path, 'size[200,200|50,50]');
                $addData['phone'] = $this->input->post('phone');
                $addData['create_date'] = date('Y-m-d H:i:s');
                // call the crate model and inset into database
                if ($this->admin_user_model->create($addData)) {
                    // set the successfull message and redirect                  
                    $this->session->set_flashdata('success_msg', 'New ' . $this->_module_name . ' Added Successfully!!');
                    redirect($this->_module . '/index');
                } else
                    $data['error_msg'] = mysql_error();
            }
        }

        // load the views
        $this->load->view('header', $data);
        $this->load->view($this->_module . '/create', $data);
        $this->load->view('footer', $data);
    }

    // view specific information based on id
    public function view($id) {
        // set the page name
        $data['module'] = $this->_module;
        $data['pageGroup'] = $this->_module_name;
        $data['pageTitle'] = "View " . $this->_module_name;

        // get the specific information based on ID
        $data['viewData'] = $this->admin_user_model->get_info($id);
        // get the level
        $data['user_levels'] = getUserLevels(1);

        $this->load->view($this->_module . '/view', $data);
    }

    // admin panel add new course type
    public function edit($id) {
        // set the page name
        $data = array();
        $data['module'] = $this->_module;
        $data['module_name'] = $this->_module_name;
        $data['page_active'] = $this->_module . '_manage';
        $data['page_title'] = 'Edit User Info';
        $data['show_date_range'] = 'no';
        $data['photo_path'] = $this->_file_path;
        $data['file_path'] = $this->_file_path;


        // get the specific information based on ID
        $data['info'] = $info = $this->admin_user_model->get_info($id);


        $data['user_id'] = $id;

        // check if click on the submit button
        if ($this->input->post('update')) {
            // check the validation
            $this->form_validation
                    ->set_rules('level_id', 'User Level', 'trim|required')
                    ->set_rules('full_name', 'Full Name', 'trim|required')
                    ->set_rules('photo', 'User Photo', 'callback_file_validate[no.photo.jpg,gif,png,jpeg]')
                    ->set_rules('email', 'User Mail', 'trim|required|valid_email')
                    ->set_rules('phone', 'Phone Number ', 'trim|exact_length[11]')
                    ->set_rules('status', 'User Status', 'trim|required');

            // password reset option 
            if ($this->input->post('password')) {
                $this->form_validation
                        ->set_rules('password', 'Password', 'matches[confirm_password]')
                        ->set_rules('confirm_password', 'Confirm Password', 'required');
            }
            if ($this->form_validation->run()) {
                // set the submit data
                $updateData = array();
                $updateData['admin_user_type_id'] = $this->input->post('level_id');
                $updateData['full_name'] = $this->input->post('full_name');
                $updateData['email'] = $this->input->post('email');
                $updateData['phone'] = $this->input->post('phone');
                $updateData['status'] = $this->input->post('status');
                if ($this->input->post('password')) {
                    $code = geneSecurePass($this->input->post('password'));
                    $updateData['password'] = $code['password'];
                    $updateData['secret'] = $code['secret'];
                }
                if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"]) {
                    $updateData['photo'] = $this->file_processing->image_upload('photo', $this->_file_path, 'size[200,200|50,50]');
                    if ($updateData['photo'])
                        $this->file_processing->delete_multiple($info->photo, $this->_file_path);
                }
                if ($this->admin_user_model->update($updateData, $id)) {
                    // set the successfull message and redirect
                    $this->session->set_flashdata('success_msg', $this->_module_name . ' Update Successfully!!');
                    redirect($this->_module . '/index');
                } else
                    $data['error_msg'] = mysql_error();
            }
        }

        // load the views
        $this->load->view('header', $data);
        $this->load->view($this->_module . '/edit', $data);
        $this->load->view('footer', $data);
    }

    // delete the specific record based on ID
    public function delete($id) {
        // get the specfic recoed item
        $item = $this->admin_user_model->get_info($id);

        if ($this->file_processing->delete_multiple($item->photo, $this->_file_path)) {
            // delete the record from database
            if ($this->admin_user_model->delete($id)) {
                $this->session->set_flashdata('success_msg', '1 user Delete Successfully !!');
                redirect($this->_module . '/index');
            }
        }
    }


    // field existing check
    public function exists_check($fieldValue, $params) {
        $param = explode(',', $params);
        $foundData = $this->global_model->existingCheck($fieldValue, $param[0], $param[1], $param[2], $param[3]);
        if (count($foundData)) {
            $this->form_validation->set_message('exists_check', 'The %s field is already exists!! ');
            return FALSE;
        } else
            return TRUE;
    }

    // file validation
    public function file_validate($fieldValue, $params) {
        // get the parameter as variable
        list($require, $fieldName, $type) = explode('.', $params);
        // get the file field name
        $filename = $_FILES[$fieldName]['name'];
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

}

/* End of file Admin_user.php */
/* Location: ./application/controllers/Admin_user.php */