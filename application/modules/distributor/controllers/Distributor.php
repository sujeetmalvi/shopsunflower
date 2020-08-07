<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor extends MY_Controller {

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
        $this->load->model('distributor_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }




    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'distributor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->distributor_model->get_distributor_list();
        $this->load->view('distributor/distributor_login',$data);
    }

    public function distributor_login()
    {

        $data = array();

        if ($this->distributor_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/distributor/distributor_dashboard');
            }else{
                redirect(site_url().'/distributor/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('distributor/distributor_login', $data);

        }

    }


    public function distributor_dashboard(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'dashboard_distributor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('distributor/distributor_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

	public function distributor_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'distributor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->distributor_model->get_distributor_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('distributor/distributor_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function distributor_list_all(){
		 $data = json_encode($this->distributor_model->get_distributor_list());
		 echo $data;
	}


    public function distributor_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'distributor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('distributor/distributor_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function distributor_save(){
        $data = $this->distributor_model->distributor_save();
        echo $data;        
    }


    public function distributor_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'distributor';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $data['details'] = $this->distributor_model->get_distributor_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('distributor/distributor_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function distributor_update() {
        $data = $this->distributor_model->distributor_update();
        echo $data;
    }

    public function get_distributor_details_by_id() {
        $DistributorId = $this->input->get('DistributorId');
        $data = $this->distributor_model->get_distributor_details_by_id($DistributorId);
        echo $data;
    }

    
    public function distributor_delete() {
        $data = $this->distributor_model->distributor_delete();
        echo $data;
    }



    public function get_distributor_by_stateid() {
        $StateId = $this->input->post('StateId');
        $data = $this->distributor_model->get_distributor_by_stateid($StateId);
        echo $data;
    }


    public function get_total_received_orders_amount(){
        $data = $this->distributor_model->get_total_received_orders_amount();
        echo $data;
    }

    public function get_top_performing_distributors(){
        $data = $this->distributor_model->get_top_performing_distributors();
        echo $data;
    }

}
