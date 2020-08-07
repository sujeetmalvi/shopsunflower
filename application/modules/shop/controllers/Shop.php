<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller {

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
        $this->load->model('shop_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
    
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'shop';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->shop_model->get_shop_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('shop/shop_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function shop_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'shop';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('shop/shop_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function shop_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'shop';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->shop_model->get_shop_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('shop/shop_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function shop_save(){
		$data = $this->shop_model->shop_save();
        echo $data;  
	}
	
	public function shop_update() {
        $data = $this->shop_model->shop_update();
        echo $data;
    }
	
	public function shop_delete() {
        $data = $this->shop_model->shop_delete();
        echo $data;
    }
	

	public function get_shop_name_list(){
		 $data = json_encode($this->shop_model->get_shop_name_list());
		 echo $data;
	}
	
}
