<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public $_module_name;
    public $_module;
//    public $_file_path = './assets/media/user_photo/';
//    public $_image_quality = 80;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');

        // load the custom file processing library
        $this->load->library('file_processing');

        $this->_module_name = 'Users';
        $this->_module = 'users';
    }

    public function __destruct() {
        $this->db->close();
    }

    public function index() {
        $data['page_title'] = 'Users';
        $data['result']     = $this->custom_model->getUsers(false, array('field'=>'pl_user.id', 'order'=>'desc'));
        $data['layout']     = $this->load->view($this->_module.'/index', $data, true);
        $this->load->view('template', $data);
    }

    public function create(){
        $data['page_title'] = 'Users';
        $data['result']     = $this->global_model->get('pl_user_role', false,false, array('filed'=>'id', 'order'=>'desc'));
        $data['layout']     = $this->load->view($this->_module.'/create', $data, true);

        if ($this->input->post()) {

            $this->form_validation
                ->set_rules('name', 'name', 'required')
                ->set_rules('email', 'email', 'required|is_unique[pl_user.email]')
                ->set_rules('slug', 'slug', 'required|is_unique[pl_user.slug]')
                ->set_rules('password', 'password', 'required')
                ->set_rules('role', '', 'required')
            ;

            if ($this->form_validation->run()) {

                // generate the password and secret code
                $code                           = geneSecurePass($this->input->post('password'));

                $row_data['name']               = $this->input->post('name');
                $row_data['email']              = $this->input->post('email');
                $row_data['phone']              = $this->input->post('phone');
                $row_data['pl_user_role_id']    = $this->input->post('role');
                $row_data['slug ']              = $this->input->post('slug');
                $row_data['password']           = $code['password'];
                $row_data['pl_user_role_id']    = $this->input->post('role');
                $row_data['phone']              = ($this->input->post('phone'))? $this->input->post('phone'):0;

                //$this->varDump($code['password']);

                // call the crate model and inset into database
                if ($this->global_model->insert('pl_user',$row_data)) {
                    // set the successfull message and redirect
                    $this->session->set_flashdata('success_msg', 'New ' . $this->_module_name . ' Added Successfully!!');
                    redirect($this->_module . '/index');
                }
            }
        }

        $this->load->view('template', $data);
    }

    private function varDump($data = null){
        echo '<pre/>';
        var_dump($data);
        die;

    }



}
