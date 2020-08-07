<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller {

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
        $this->load->model('driver_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'driver';
		$this->load->view('template/header',$data);
		$this->load->view('driver/driver_list',$data);
		$this->load->view('template/footer',$data);
	}


    public function task(){
        $tasktype = $this->input->get('tasktype');
        $tablename = $this->input->get('tbl');
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = $tablename;
        if($tasktype=='add' || $tasktype=='edit' || $tasktype=='list'){
            $this->load->view('template/header',$data);
            $this->load->view('driver/driver_add',$data);
            $this->load->view('template/footer',$data);            
        }
    }



	public function driver_add()
	{
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'driver';
		$this->load->view('template/header',$data);
		$this->load->view('driver/driver_add',$data);
		$this->load->view('template/footer',$data);
	}

    public function driver_list(){
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'driver';
        $data['list'] = $this->driver_model->get_driver_list_all();
        $this->load->view('template/header',$data);
        $this->load->view('driver/driver_list',$data);
        $this->load->view('template/footer',$data);
    }

    public function driver_save() {
        $data = $this->driver_model->driver_save();
        echo $data;
    }


    public function driver_edit()
    {
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'driver';
        //$data['Packages'] = $this->driver_model->get_packages_list();
        $data['details'] = $this->driver_model->get_driver_details_by_id();
        $this->load->view('template/header',$data);
        $this->load->view('driver/driver_edit',$data);
        $this->load->view('template/footer',$data);
    }

    public function driver_update() {
        $data = $this->driver_model->driver_update();
        echo $data;
    }

    public function driver_delete() {
        $data = $this->driver_model->driver_delete();
        echo $data;
    }




    // public function get_institute_by_stateid(){
    //     $stateid = $this->input->post('stateid');
    //     $data = $this->institute_model->get_institute_by_stateid($stateid);
    //     echo $data;
    // }

    public function get_companies_by_id() {
        $id = $this->input->post('id');
        $data = $this->driver_model->get_companies_by_id($id);
        echo $data;
    }


}
