<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends MY_Controller {

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
	 
        $this->load->model('division_model');
		 $this->load->model('division_model');
        
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
	
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'division';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->division_model->get_division_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('division/division_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function division_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'division';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('division/division_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function division_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'division';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->division_model->get_division_details_by_id();				 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('division/division_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function division_save(){
		$data = $this->division_model->division_save();
        echo $data;  
	}
	
	public function division_update() {
        $data = $this->division_model->division_update();
        echo $data;
    }
	
	public function division_delete() {
        $data = $this->division_model->division_delete();
        echo $data;
    }
	
	
}
?>