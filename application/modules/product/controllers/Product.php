<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MY_Controller {

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
        $this->load->model('product_model');
    }


    public function index()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_product_listnew();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_listnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_addnew() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['categories'] = $this->product_model->get_productcategory_name_list();
        $data['colours'] = $this->product_model->get_colours_name_list();
        $data['sizes'] = $this->product_model->get_sizes_name_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_addnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    public function product_addimages(){
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_product_images_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_addimages',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    

    public function product_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }


    public function product_list_all(){
         $data = json_encode($this->product_model->get_product_list());
         echo $data;
    }
    
    public function product_excelupload(){
        $data = $this->product_model->product_excelupload();
        echo $data;        
    }

    public function product_stock_excelupload(){
        $data = $this->product_model->product_stock_excelupload();
        echo $data;        
    }



    public function product_savenew(){
        $data = $this->product_model->product_savenew();
        //pre($data);
        echo $data;        
    }

    public function product_addimages_save(){
        $data = $this->product_model->product_addimages_save();
        //pre($data);
        echo $data;        
    }



    public function product_save(){
        $data = $this->product_model->product_save();
        echo $data;        
    }


    public function product_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $id=$this->input->get('ProductId');
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['categories'] = $this->product_model->get_productcategory_name_list();
        $data['colours'] = $this->product_model->get_colours_name_list();
        $data['sizes'] = $this->product_model->get_sizes_name_list();
        $data['list'] = $this->product_model->get_product_list_by_id($id);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_update() {
        $data = $this->product_model->product_update();
        echo $data;
    }

    public function get_all_product_list_with_brand(){
        $data = $this->product_model->get_all_product_list_with_brand();
        echo $data;
    }

    public function get_product_details_by_id_json() {
        //$ProductId = $this->input->post('ProductId');
        $data = $this->product_model->get_all_product_list_with_brand();
        echo json_encode(array('status'=>true,'data'=>$data));
    }

    public function get_product_details_by_id() {
        $ProductId = $this->input->post('ProductId');
        $data = $this->product_model->get_product_details_by_id();
        if(count($data)>0){
            echo json_encode(array('status'=>true,'datas'=>$data));
        }else{
            echo json_encode(array('status'=>false,'datas'=>''));
        }
    }


    public function product_deletenew() {
        $data = $this->product_model->product_deletenew();
        echo $data;
    }

    public function product_delete_addimages() {
        $data = $this->product_model->product_delete_addimages();
        echo $data;
    }



    public function product_delete() {
        $data = $this->product_model->product_delete();
        echo $data;
    }




    public function product_stock() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_all_product_stock_by_loginid();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_stock',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_stock_save(){
        $data = $this->product_model->product_stock_save();
        echo $data;
    }


    public function product_stocknew() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_all_product_stocknew_by_loginid();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_stocknew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    
    public function product_stocknew_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_all_product_list();
        //pre($data['list']);
        $id=$this->input->get('StockId');
        $data['details'] = $this->product_model->get_product_stocknew_by_loginid($id);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_stocknew_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }


    public function product_stock_addnew() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_all_product_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_stock_addnew',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_stock_savenew(){
        $data = $this->product_model->product_stock_savenew();
        echo $data;
    }
    
    public function product_stock_update(){
        $data = $this->product_model->product_stock_update();
        echo $data;
    }




    public function get_product_stock_mil_details_by_id(){
        //pre($_POST);exit;
        $data = $this->product_model->get_product_stock_mil_details_by_id();
        echo $data;
    }

    public function get_top_performing_products(){
        //pre($_POST);exit;
        $data = $this->product_model->get_top_performing_products();
        echo $data;
    }



    public function product_stock_received() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product_stock_received';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['productlist'] = $this->product_model->get_all_product_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_stock_received',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_stock_received_save(){
        $data = $this->product_model->product_stock_received_save();
        echo $data;
    }

    public function get_productid_by_barcode(){
        $data = $this->product_model->get_productid_by_barcode();
        echo $data;   
    }

    public function get_product_stock_received_by_id(){
        $data = $this->product_model->get_product_stock_received_by_id();
        echo $data;
    }
		
	public function productcategory_list(){
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productcategory';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->get_productcategory_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/productcategory_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function productcategory_add()
	{
		$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productcategory';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();	 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/productcategory_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	  public function productcategory_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'productcategory';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->product_model->get_productcategory_details_by_id();				 
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/productcategory_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
	
	public function productcategory_save(){
		$data = $this->product_model->productcategory_save();
        echo $data;  
	}
	
	public function productcategory_update() {
        $data = $this->product_model->productcategory_update();
        echo $data;
    }
	
	public function productcategory_delete() {
        $data = $this->product_model->productcategory_delete();
        echo $data;
    }
    
    public function product_mil_stock() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product_mil_stock';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['productlist'] = $this->product_model->get_all_product_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_mil_stock',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function product_mil_stock_save(){
        $data = $this->product_model->product_mil_stock_save();
        echo $data;
    }

    public function product_mil_stock_list() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'product_mil_stock';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->product_model->product_mil_stock_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('product/product_mil_stock_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    
    public function product_mil_stock_delete() {
        $data = $this->product_model->product_mil_stock_delete();
        echo $data;
    }

    public function product_mil_stock_update() {
        $data = $this->product_model->product_mil_stock_update();
        echo $data;
    }
    
     public function get_product_details_by_id_supply() {
        $ProductId = $this->input->post('ProductId');
        $data = $this->product_model->get_product_details_by_id_supply();
        if(count($data)>0){
            echo json_encode(array('status'=>true,'datas'=>$data));
        }else{
            echo json_encode(array('status'=>false,'datas'=>''));
        }
    }  
    
    public function get_product_details_by_stockid()
    {        
        $data = $this->product_model->get_product_details_by_stockid();
       // print_r()
        if(count($data)>0){
            echo json_encode(array('status'=>true,'datas'=>$data));
        }else{
            echo json_encode(array('status'=>false,'datas'=>''));
        }
    }  
   

} // class ends here
