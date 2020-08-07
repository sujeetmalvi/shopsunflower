<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {

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
	 
        $this->load->model('category_model');
		 $this->load->model('category_model');
        
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
	
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'category';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->category_model->get_category_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('category/category_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function category_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'category';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('category/category_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function category_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'category';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->category_model->get_category_details_by_id();				 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('category/category_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function category_save(){
		$data = $this->category_model->category_save();
        echo $data;  
	}
	
	public function category_update() {
        $data = $this->category_model->category_update();
        echo $data;
    }
	
	public function category_delete() {
        $data = $this->category_model->category_delete();
        echo $data;
    }
	
	
}
?>