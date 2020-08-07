<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

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
        $this->load->model('login/login_model');
        
        date_default_timezone_set('Asia/Calcutta');        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{

        $data = array();

        if ($this->login_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_role == 'admin'){
                redirect(site_url('superadmin/dashboard'));
            }else{
                redirect(base_url());
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
			$data['js_script'] = 'login';
            $this->load->view('login', $data);

        }

	}

	public function registration()
	{
		$data = array();
		$data['js_script'] = 'registration';
		$this->load->view('registration',$data);
	}

	public function registration_save(){
		$data = $this->login_model->registration_save();
		echo json_encode($data);
	}

	public function logout()
	{

        if($this->session->userdata('user_id')){
            /***Activity Logs***/
            save_activity_details('Logout by '. $this->session->userdata('user_role').' Id : '. $this->session->userdata('user_id'));
           /***Activity Logs End***/
            $this->session->sess_destroy();
        }

       

        //if (isset($_SESSION['id'])) {
        //    unset($_SESSION);
        //    session_destroy();
        //}
        //redirect(site_url());
        redirect(base_url());
	}
}
