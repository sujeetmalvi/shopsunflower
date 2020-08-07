<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colour extends MY_Controller {

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
        $this->load->model('colour_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'colour';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->colour_model->get_colour_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('colour/colour_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function colour_list_all(){
		 $data = json_encode($this->colour_model->get_colour_list());
		 echo $data;
	}


    public function colour_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'colour';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('colour/colour_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function colour_save(){
        $data = $this->colour_model->colour_save();
        echo $data;        
    }


    public function colour_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'colour';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->colour_model->get_colour_details_by_id();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('colour/colour_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function colour_update() {
        $data = $this->colour_model->colour_update();
        echo $data;
    }

    public function get_colour_by_id() {
        $id = $this->input->post('id');
        $data = $this->colour_model->get_colour_by_id($id);
        echo $data;
    }
    public function colour_delete() {
        $data = $this->colour_model->colour_delete();
        echo $data;
    }

}
