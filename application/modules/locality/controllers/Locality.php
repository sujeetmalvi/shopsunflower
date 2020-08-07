<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locality extends MY_Controller {

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
        $this->load->model('locality_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'locality';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->locality_model->get_locality_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('locality/locality_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);

	}

	public function locality_list_all(){
		 $data = json_encode($this->locality_model->get_locality_list());
		 echo $data;
	}


    public function locality_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'locality';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('locality/locality_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function locality_save(){
        $data = $this->locality_model->locality_save();
        echo $data;        
    }


    public function locality_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'locality';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
        $data['details'] = $this->locality_model->get_locality_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('locality/locality_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function locality_update() {
        $data = $this->locality_model->locality_update();
        echo $data;
    }

    // public function get_city_by_stateid() {
    //     $StateId = $this->input->post('StateId');
    //     $data = $this->locality_model->get_locality_by_id($StateId);
    //     echo $data;
    // }
    public function locality_delete() {
        $data = $this->locality_model->locality_delete();
        echo $data;
    }
}
