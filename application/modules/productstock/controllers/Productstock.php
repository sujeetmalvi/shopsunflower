<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productstock extends MY_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
        $this->load->model('productstock_model');
    }


    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productstock';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->productstock_model->get_productstock_listnew();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productstock/productstock_listnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function changeproductstatus(){
        $data = $this->productstock_model->changeproductstatus();
        echo $data;
    }


    public function productstock_addnew() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productstock';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['categories'] = $this->productstock_model->get_productcategory_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productstock/productstock_addnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    public function productstock_savenew(){
        $data = $this->productstock_model->productstock_savenew();
        echo $data;
    }
    
    public function get_pre_orderid_by_productid(){
        $data = $this->productstock_model->get_pre_orderid_by_productid();
        echo $data;
    }
    
    public function get_pre_orderqty_by_orderid_productid(){
        $data = $this->productstock_model->get_pre_orderqty_by_orderid_productid();
        echo $data;
    }
    
    
    

    public function productstock_editnew() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productstock';
        $ProductStockId = $this->input->get('ProductStockId');
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->productstock_model->get_productstock_by_id($ProductStockId);
        $data['categories'] = $this->productstock_model->get_productcategory_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('productstock/productstock_editnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function productstock_updatenew() {
        $data = $this->productstock_model->productstock_updatenew();
        echo $data;
    }

    public function get_product_details_by_id() {
        $ProductId = $this->input->post('ProductId');
        $data = $this->productstock_model->get_product_details_by_id();
        if(count($data)>0){
            echo json_encode(array('status'=>true,'datas'=>$data));
        }else{
            echo json_encode(array('status'=>false,'datas'=>''));
        }
    }

    public function productstock_deletenew() {
        $data = $this->productstock_model->productstock_deletenew();
        echo $data;
    }

    public function get_designcode_by_categoryid(){
        $CategoryId = $this->input->post('CategoryId');
        $DesignCode = $this->input->post('DesignCode');
        $data = $this->productstock_model->get_designcode_by_categoryid($CategoryId,$DesignCode);
        echo $data;
    }
    
    public function get_productid_by_designcode($design_code='',$ProductId='') {
        $ProductId = $this->input->post('ProductId');
        $DesignCode = $this->input->post('DesignCode');
        $data = $this->productstock_model->get_productid_by_designcode($DesignCode,$ProductId);
        echo $data;
    }
    


   

} // class ends here
