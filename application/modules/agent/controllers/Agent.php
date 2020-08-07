<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends MY_Controller {

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
        $this->load->model('agent_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }

    public function agent_login()
    {

        $data = array();

        if ($this->agent_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/pos/pos_orders_add');
            }else{
                redirect(site_url().'/agent/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('agent/agent_login', $data);

        }

    }


    public function agent_dashboard(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'agent';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('agent/agent_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }



    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'agent';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->agent_model->get_agent_list();
        $this->load->view('agent/agent_login',$data);
    }

	public function agent_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'agent';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->agent_model->get_agent_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('agent/agent_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function agent_list_all(){
		 $data = json_encode($this->agent_model->get_agent_list());
		 echo $data;
	}


    public function agent_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'agent';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('agent/agent_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function agent_save(){
        $data = $this->agent_model->agent_save();
        echo $data;        
    }


    public function agent_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'agent';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $data['details'] = $this->agent_model->get_agent_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('agent/agent_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function agent_update() {
        $data = $this->agent_model->agent_update();
        echo $data;
    }

    public function get_agent_details_by_id() {
        $RetailerId = $this->input->get('RetailerId');
        $data = $this->agent_model->get_agent_details_by_id($RetailerId);
        echo $data;
    }


    
    public function agent_delete() {
        $data = $this->agent_model->agent_delete();
        echo $data;
    }


/**************** DASHBOARD FUNCTIONS ******************************/

    public function get_agent_count(){
        $id = $_SESSION['user_id'];
        $data = $this->agent_model->get_agent_count();
        echo $data;
    }

/**************** DASHBOARD FUNCTIONS ******************************/


    public function get_agent_list_json() {
        //$ProductId = $this->input->post('ProductId');
        $data = $this->agent_model->get_agent_list_json();
        echo json_encode(array('status'=>true,'data'=>$data));
    }

    public function sync_save_agent_master_data(){
        $data = $this->agent_model->sync_save_agent_master_data();
        echo $data;
    }

}
