<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Size extends MY_Controller {

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
        $this->load->model('size_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'size';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->size_model->get_size_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('size/size_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function size_list_all(){
		 $data = json_encode($this->size_model->get_size_list());
		 echo $data;
	}


    public function size_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'size';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('size/size_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function size_save(){
        $data = $this->size_model->size_save();
        echo $data;        
    }


    public function size_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'size';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->size_model->get_size_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('size/size_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function size_update() {
        $data = $this->size_model->size_update();
        echo $data;
    }

    public function get_size_by_id() {
        $id = $this->input->post('id');
        $data = $this->size_model->get_size_by_id($id);
        echo $data;
    }
    public function size_delete() {
        $data = $this->size_model->size_delete();
        echo $data;
    }

}
