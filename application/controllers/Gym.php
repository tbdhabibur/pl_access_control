<?php
/**
 * Created by PhpStorm.
 * User: habibur
 * Date: 12/10/18
 * Time: 12:24 PM
 */

class Gym extends CI_Controller
{
    private $_module_name;
    private $_module;

    function __construct() {
        parent::__construct();

        $this->load->library('form_validation');

        // load the custom file processing library
        $this->load->library('file_processing');

        $this->_module_name = 'Gym';
        $this->_module = 'gym';

//        if(!file_exists($this->_file_dir))
//        {
//            mkdir($this->_file_dir, 0777, true);
//        }

        // check login if user is login or not if nor redirect to login page
        // if (!check_admin_login()) {
        //     $this->session->set_flashdata('error_msg', 'Please login first !!');
        //     redirect('auth/login');
        // }
    }

    public function __destruct() {
        $this->db->close();
    }

    /*
     * GYM
     * */
    public function index()
    {
        $data['page_title'] = 'Gym';
        $data['result']     = $this->global_model->get('gym', false,false, array('filed'=>'id_gym', 'order'=>'desc'));
        $data['layout']     = $this->load->view($this->_module.'/index', $data, true);
        $this->load->view('template', $data);
    }


    /* CREATE A NEW GYM
     *
     * */
    public function create()
    {
        $data['module'] = $this->_module;
        $data['module_name'] = $this->_module_name;
        $data['page_active'] = $this->_module . '_create';
        $data['page_title'] = "Add New " . $this->_module_name;



        // load the views
        $data['layout'] = $this->load->view($this->_module.'/create', $data, true);
        $this->load->view('template', $data);
    }


}