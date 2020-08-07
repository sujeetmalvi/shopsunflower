<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends MY_Controller {

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
        $this->load->model('packages_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }


	public function index()
	{
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'packages';
        // $data['js_custom'] = array('assets/js/plugins/staps/jquery.steps.min.js','assets/js/plugins/validate/jquery.validate.min.js');
        // $data['css_custom'] = array('assets/css/plugins/iCheck/custom.css','assets/css/plugins/steps/jquery.steps.css');
        // $data['title'] = 'Institute';
        //$data['status'] = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        //$user_id = $this->session->userdata('user_id');
        //$data['level1_menu_id'] = 1;
        //$data['level2_menu_id'] = 5;
        //$data['page_id'] = '';        

        //$data['rights'] = getcheckedmenu($data['level2_menu_id'] , $user_id);
        //$data['result'] = $this->superadmin_model->get_group_list();
		$this->load->view('template/header',$data);
		$this->load->view('packages/packages_list',$data);
		$this->load->view('template/footer',$data);
	}


	public function add_packages()
	{
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'packages';
		$this->load->view('template/header',$data);
		$this->load->view('packages/add_packages',$data);
		$this->load->view('template/footer',$data);
	}

    public function packages_list(){
        $data = array();
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['js_script'] = 'packages_list';
        $data['list'] = $this->packages_model->get_packages_list();
        $this->load->view('template/header',$data);
        $this->load->view('packages/packages_list',$data);
        $this->load->view('template/footer',$data);
    }



	// public function institute_list_all(){
	// 	 $data = $this->institute_model->get_institute_list();
	// 	 echo $data;
	// }


    public function save_packages() {

		//echo json_encode($_POST);
        $data = $this->packages_model->save_packages();
        echo $data;
    }

 //    public function update_institute() {
 //        $data = $this->institute_model->update_institute();
 //        echo $data;
 //    }

 //    // public function get_institute_by_stateid(){
 //    //     $stateid = $this->input->post('stateid');
 //    //     $data = $this->institute_model->get_institute_by_stateid($stateid);
 //    //     echo $data;
 //    // }

 //    public function get_institute_by_id() {
 //        $id = $this->input->post('id');
 //        $data = $this->institute_model->get_institute_by_id($id);
 //        echo $data;
 //    }

    public function delete_packages() {
        $data = $this->packages_model->delete_packages();
        echo $data;
    }

}
