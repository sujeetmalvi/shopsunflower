<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stockist extends MY_Controller {

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
        $this->load->model('stockist_model');
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
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('stockist/stockist_login',$data);
    }

    public function stockist_login()
    {

        //echo "sdfsdfsf";exit;
        $data = array();

        //$dd = $this->stockist_model->check_login();exit;

        if ($this->stockist_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/stockist/stockist_dashboard');
            }else{
                redirect(site_url().'/stockist/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('stockist/stockist_login', $data);

        }

    }


    public function stockist_dashboard(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'dashboard_stockist';
        $data['total_retailers']=$this->stockist_model->get_total_retailers();
        $data['recurring_retailers']=$this->stockist_model->get_recurring_retailers();
        //$Expiry=
        $data['ExpiryProduct'] = $this->stockist_model->get_expiry_product();
        $data['out_of_stock'] = $this->stockist_model->get_out_of_stock_product();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('stockist/stockist_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }


	public function stockist_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->stockist_model->get_stockist_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('stockist/stockist_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function stockist_list_all(){
		 $data = json_encode($this->stockist_model->get_stockist_list());
		 echo $data;
	}


    public function stockist_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('stockist/stockist_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function stockist_save(){
        $data = $this->stockist_model->stockist_save();
        echo $data;        
    }


    public function stockist_edit() 
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $id=$this->input->get('StockistId');
        $data['details'] = $this->stockist_model->get_stockist_all_details_by_id($id);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('stockist/stockist_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function stockist_update() {
        $data = $this->stockist_model->stockist_update();
        echo $data;
    }

    public function get_stockist_details_by_id() {
        $StockistId = $this->input->get('StockistId');
        $data = $this->stockist_model->get_stockist_details_by_id($StockistId);
        echo $data;
    }
    
    public function stockist_delete() {
        $data = $this->stockist_model->stockist_delete();
        echo $data;
    }

    public function get_stockist_by_city_id() {
       $CityId = $this->input->post('CityId');
        $data = $this->stockist_model->get_stockist_by_city_id($CityId);
        echo $data;
    }

/**************** DASHBOARD FUNCTIONS ******************************/

    public function get_stockist_count(){
        $data = $this->stockist_model->get_stockist_count();
        echo $data;
    }

    public function get_total_received_orders_amount(){
        $data = $this->stockist_model->get_total_received_orders_amount();
        echo $data;
    }

    public function get_top_performing_stockist(){
        $data = $this->stockist_model->get_top_performing_stockist();
        echo $data;
    }
    
      public function forget_password()
    {
    	$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();  
        $this->load->view('stockist/stockist_forget_password',$data);       
    }

/**************** DASHBOARD FUNCTIONS ******************************/
	public function forget_password_email_check()
	{
		$data = $this->stockist_model->forget_password_email_check();
        	echo $data;  		
	}

public function reset_password()
{
	$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['code']=$this->input->get('forgetpassword_code');
        $data['js_script'] = 'stockist';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();  
        $this->load->view('stockist/reset_password',$data); 
}

	public function change_password()
	{	
		$data = $this->stockist_model->change_password();
        	echo $data;  
	}


/**************** DASHBOARD FUNCTIONS ******************************/


}
