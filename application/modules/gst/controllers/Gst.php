<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gst extends MY_Controller {

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
        $this->load->model('gst_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }

	
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'gst';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->gst_model->get_gst_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('gst/gst_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function gst_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'gst';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('gst/gst_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function gst_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'gst';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->gst_model->get_gst_details_by_id();				 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('gst/gst_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function gst_save(){
		$data = $this->gst_model->gst_save();
        echo $data;  
	}
	
	public function gst_update() {
        $data = $this->gst_model->gst_update();
        echo $data;
    }
	
	public function gst_delete() {
        $data = $this->gst_model->gst_delete();
        echo $data;
    }
	

	public function get_gst_name_list($GstType){
		 $data = json_encode($this->division_model->get_gst_name_list($GstType));
		 echo $data;
	}
	
}
