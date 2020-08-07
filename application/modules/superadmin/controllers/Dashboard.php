<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

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
        $this->load->model('dashboard_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $data['js_script'] = 'dashboard';
        $data['title'] = 'Dashboard';
        $data['csrfName'] = '';
        $data['title'] = 'Dashboard';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['total'] = $this->dashboard_model->get_dashboard_count();
        $data['shopsettings'] = $this->dashboard_model->get_shopsettings();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('dashboard/dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);

	}
	

	public function set_shopsettings(){
       echo $this->dashboard_model->set_shopsettings();
	}

}
