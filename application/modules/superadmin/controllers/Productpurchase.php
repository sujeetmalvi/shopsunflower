<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productpurchase extends MY_Controller {

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
	 
	$this->load->model('productpurchase_model');
	$this->load->model('company/company_model');
	$this->load->model('product/product_model');
	$this->load->model('gst/gst_model');
        
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
	
	public function index(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productpurchase';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->productpurchase_model->get_productpurchase_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productpurchase/productpurchase_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function productpurchase_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productpurchase';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	
        $data['companyies'] = $this->company_model->get_company_name_list();
        $data['categories'] = $this->product_model->get_productcategory_name_list();
        $data['salegsts'] = $this->gst_model->get_gst_name_list('2'); 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productpurchase/productpurchase_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function productpurchase_list()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productpurchase';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	
        $data['list'] = $this->productpurchase_model->get_productpurchase_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productpurchase/productpurchase_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function get_product_details_by_productid(){
		$data = $this->productpurchase_model->get_product_details_by_productid();
        echo $data;
	}

	public function productpurchase_save(){
		$data = $this->productpurchase_model->productpurchase_save();
        echo $data;  
	}
	
	public function gst_update() {
        $data = $this->gst_model->gst_update();
        echo $data;
    }
	
	public function productpurchase_delete() {
        $data = $this->productpurchase_model->productpurchase_delete()();
        echo $data;
    }
	
	public function get_productpurchase_details_by_productpurchaseid(){
	    $data = $this->productpurchase_model->get_productpurchase_details_by_productpurchaseid();
        echo $data;
	}
	

	public function get_product_details_by_id_json() {
        //$ProductId = $this->input->post('ProductId');
        $data = $this->productpurchase_model->get_all_product_list_with_brand();
        echo json_encode(array('status'=>true,'data'=>$data));
    }

    public function addtostock_save(){
		$data = $this->productpurchase_model->addtostock_save();
        echo $data;  
	}
}
?>