<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendor extends MY_Controller {

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
        $this->load->model('vendor_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
         $this->load->library('email',array(
       		'mailtype'  => 'html',
        	'newline'   => '\r\n'
		));
    }


    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('vendor/vendor_login',$data);
    }

    public function vendor_login()
    {

        //echo "sdfsdfsf";exit;
        $data = array();

        //$dd = $this->vendor_model->check_login();exit;

        if ($this->vendor_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/vendor/vendor_dashboard');
            }else{
                redirect(site_url().'/vendor/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('vendor/vendor_login', $data);

        }

    }


    public function vendor_dashboard(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'dashboard_vendor';
        $data['total_retailers']=$this->vendor_model->get_total_retailers();
        $data['recurring_retailers']=$this->vendor_model->get_recurring_retailers();
        //$Expiry=
        $data['ExpiryProduct'] = $this->vendor_model->get_expiry_product();
        $data['out_of_stock'] = $this->vendor_model->get_out_of_stock_product();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('vendor/vendor_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }


	public function vendor_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->vendor_model->get_vendor_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('vendor/vendor_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function vendor_list_all(){
		 $data = json_encode($this->vendor_model->get_vendor_list());
		 echo $data;
	}


    public function vendor_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('vendor/vendor_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function vendor_save(){
        $data = $this->vendor_model->vendor_save();
        echo $data;        
    }


    public function vendor_edit() 
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $id=$this->input->get('VendorId');
        $data['details'] = $this->vendor_model->get_vendor_all_details_by_id($id);
        //pre($data['details']);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('vendor/vendor_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function vendor_update() {
        $data = $this->vendor_model->vendor_update();
        echo $data;
    }

    public function get_vendor_details_by_id() {
        $vendorId = $this->input->get('vendorId');
        $data = $this->vendor_model->get_vendor_details_by_id($vendorId);
        echo $data;
    }
    
    public function vendor_delete() {
        $data = $this->vendor_model->vendor_delete();
        echo $data;
    }

    public function get_vendor_by_city_id() {
       $CityId = $this->input->post('CityId');
        $data = $this->vendor_model->get_vendor_by_city_id($CityId);
        echo $data;
    }

    public function get_vendor_details_by_id_json(){
        $data = $this->vendor_model->get_vendor_details_by_id_json();
        echo json_encode(array('status'=>true,'data'=>$data));
    }


/**************** DASHBOARD FUNCTIONS ******************************/

    public function get_vendor_count(){
        $data = $this->vendor_model->get_vendor_count();
        echo $data;
    }

    public function get_total_received_orders_amount(){
        $data = $this->vendor_model->get_total_received_orders_amount();
        echo $data;
    }

    public function get_top_performing_vendor(){
        $data = $this->vendor_model->get_top_performing_vendor();
        echo $data;
    }
    
      public function forget_password()
    {
    	$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();  
        $this->load->view('vendor/vendor_forget_password',$data);       
    }

/**************** DASHBOARD FUNCTIONS ******************************/
	public function forget_password_email_check()
	{
		$data = $this->vendor_model->forget_password_email_check();
        	echo $data;  		
	}

public function reset_password()
{
	$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['code']=$this->input->get('forgetpassword_code');
        $data['js_script'] = 'vendor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();  
        $this->load->view('vendor/reset_password',$data); 
}

	public function change_password()
	{	
		$data = $this->vendor_model->change_password();
        	echo $data;  
	}


/**************** DASHBOARD FUNCTIONS ******************************/


}
