<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends MY_Controller {

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
        $this->load->model('state_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'state';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->state_model->get_state_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('state/state_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function state_list_all(){
		 $data = json_encode($this->state_model->get_state_list());
		 echo $data;
	}


    public function state_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'state';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('state/state_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function state_save(){
        $data = $this->state_model->state_save();
        echo $data;        
    }


    public function state_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'state';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->state_model->get_state_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('state/state_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function state_update() {
        $data = $this->state_model->state_update();
        echo $data;
    }

    public function get_state_by_id() {
        $id = $this->input->post('id');
        $data = $this->state_model->get_state_by_id($id);
        echo $data;
    }
    public function state_delete() {
        $data = $this->state_model->state_delete();
        echo $data;
    }

}
