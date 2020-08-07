<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends MY_Controller {

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
        $this->load->model('city_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        //$data['status'] = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $user_id = $this->session->userdata('user_id');
        //$data['level1_menu_id'] = 1;
        //$data['level2_menu_id'] = 5;
        //$data['page_id'] = '';
        $data['js_script'] = 'city';
        $data['title'] = 'City';

        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->city_model->get_city_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('city/city_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function city_list_all(){
		 $data = json_encode($this->city_model->get_city_list());
		 echo $data;
	}


    public function city_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'city';
        $data['title'] = 'City';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('city/city_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function city_save(){
        $data = $this->city_model->city_save();
        echo $data;        
    }


    public function city_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'city';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['details'] = $this->city_model->get_city_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('city/city_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function city_update() {
        $data = $this->city_model->city_update();
        echo $data;
    }

    public function get_city_by_id() {
        $id = $this->input->post('id');
        $data = $this->city_model->get_city_by_id($id);
        echo $data;
    }


    public function get_city_by_stateid() {
        $StateId = $this->input->post('StateId');
        $data = $this->city_model->get_city_by_stateid($StateId);
        echo $data;
    }
    public function city_delete() {
        $data = $this->city_model->city_delete();
        echo $data;
    }
}
