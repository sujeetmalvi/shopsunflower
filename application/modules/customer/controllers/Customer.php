<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {

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
        $this->load->model('state/state_model');
        $this->load->model('city/city_model');
        $this->load->model('customer_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }

    public function customer_login()
    {

        $data = array();

        if ($this->customer_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/customer/customer_dashboard');
            }else{
                redirect(site_url().'/customer/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('customer/customer_login', $data);

        }

    }


    public function customer_dashboard(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'customer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('customer/customer_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }



    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'customer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->customer_model->get_customer_list();
        $this->load->view('customer/customer_login',$data);
    }

	public function customer_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'customer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->customer_model->get_customer_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('customer/customer_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function customer_list_all(){
		 $data = json_encode($this->customer_model->get_customer_list());
		 echo $data;
	}


    public function customer_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'customer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('customer/customer_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function customer_save(){
        $data = $this->customer_model->customer_save();
        echo $data;        
    }


    public function customer_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'customer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $data['details'] = $this->customer_model->get_customer_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('customer/customer_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function customer_update() {
        $data = $this->customer_model->customer_update();
        echo $data;
    }

    public function get_customer_details_by_id() {
        $RetailerId = $this->input->get('RetailerId');
        $data = $this->customer_model->get_customer_details_by_id($RetailerId);
        echo $data;
    }


    
    public function customer_delete() {
        $data = $this->customer_model->customer_delete();
        echo $data;
    }


/**************** DASHBOARD FUNCTIONS ******************************/

    public function get_customer_count(){
        $id = $_SESSION['user_id'];
        $data = $this->customer_model->get_customer_count();
        echo $data;
    }

/**************** DASHBOARD FUNCTIONS ******************************/


    public function get_customer_list_json() {
        //$ProductId = $this->input->post('ProductId');
        $data = $this->customer_model->get_customer_list_json();
        echo json_encode(array('status'=>true,'data'=>$data));
    }

    public function checkmobileno(){
        $data = $this->customer_model->checkmobileno();
        echo $data;
    }


    public function sync_customers_save(){
        $data = $this->customer_model->sync_customers_save();
        echo $data;
    }

}
