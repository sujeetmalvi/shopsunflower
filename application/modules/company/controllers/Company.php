<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {

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
        $this->load->model('company_model');
        $this->load->model('state/state_model');
        $this->load->model('city/city_model');
	$this->load->model('division/division_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
    
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'company';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->company_model->get_company_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('company/company_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function company_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'company';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
		$data['states'] = $this->state_model->get_state_name_list();
		$data['division'] = $this->division_model->get_all();		 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('company/company_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function company_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'company';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $data['details'] = $this->company_model->get_company_details_by_id();
		$data['division'] = $this->division_model->get_all();		 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('company/company_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function company_save(){
		$data = $this->company_model->company_save();
        echo $data;  
	}
	
	public function company_update() {
        $data = $this->company_model->company_update();
        echo $data;
    }
	
	public function company_delete() {
        $data = $this->company_model->company_delete();
        echo $data;
    }
	

	public function get_company_name_list(){
		 $data = json_encode($this->company_model->get_company_name_list());
		 echo $data;
	}
	
}
