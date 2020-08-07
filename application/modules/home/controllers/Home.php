<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function __construct() {
        parent::__construct();
        //  error_reporting(E_ALL);
        $this->load->model('home_model');
        date_default_timezone_set('Asia/Calcutta'); 
    }

	public function index()
	{
        $data = array();
        $this->load->view('../../template/header',$data);
        $this->load->view('home/home', $data);
        $this->load->view('../../template/footer',$data);
	}

	public function privacypolicy()
	{
        $data = array();
        $this->load->view('../../template/header',$data);
        $this->load->view('home/privacypolicy', $data);
        $this->load->view('../../template/footer',$data);
	}

	public function forgot_password()
	{
        $data = array();
        $EmployeesId = $this->input->get('link');
        $data['EmployeesId'] = $EmployeesId;
        $data['js_script'] = 'forgot_password';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        //$data['details'] = $this->home_model->get_employees_details($imei);
        $this->load->view('../../template/header',$data);
        $this->load->view('home/forgot_password', $data);
        $this->load->view('../../template/footer',$data);
	}

}
