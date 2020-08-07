<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retailer extends MY_Controller {

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
        $this->load->model('state/state_model');
        $this->load->model('city/city_model');
        $this->load->model('orders/orders_model');
        $this->load->model('pos/pos_model');
        $this->load->model('Stockist/stockist_model');
        $this->load->model('retailer_model');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
         $this->load->library('email',array(
       		'mailtype'  => 'html',
        	'newline'   => '\r\n'
		));
    }

    public function retailer_login()
    {

        $data = array();

        if ($this->retailer_model->check_login() || isset($_SESSION['user_id'])) {

            $user_id = $this->session->userdata('user_id');
            $user_role = $this->session->userdata('user_role');
            $user_name = $this->session->userdata('user_name');

            //redirect(site_url('welcome'));

            if($user_id != ''){
                redirect(site_url().'/retailer/retailer_dashboard');
            }else{
                redirect(site_url().'/retailer/');
            }

        } else {

            if ($this->input->post()) {
                $data = array('error_msg' => 'Invalid username or password.');
            } else {
                $data = array();
            }
            $data['js_script'] = 'login';
            $this->load->view('retailer/retailer_login', $data);

        }

    }


    public function retailer_dashboard()
    {

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $list= $this->pos_model->get_pos_profit_list();  
         $TotalPrice=0.00;
                          $i=0;
                          foreach($list as $value)
                          {
                          $i++;                          
                          $profit=0.00;
                         	 $order_product=$this->orders_model->get_customer_order_details_by_orderid($value['OrderId']);                         	
                         	foreach($order_product as $order)
                         	{
                         		$profit=$profit + (($order['ProductMRP']*$order['PTRMargin']/100)*$order['OrderQuantity']);
                         	}
                         	$TotalPrice=$TotalPrice+$profit;
                         }      
        $data['profit']=$TotalPrice;
        $data['total_customer']=$this->retailer_model->get_total_customer();
         $data['recurring_customer']=$this->retailer_model->get_recurring_customer();
        //$Expiry=
        $data['ExpiryProduct'] = $this->retailer_model->get_expiry_product();
        $data['out_of_stock'] = $this->retailer_model->get_out_of_stock_product();
        
	//print_R($data['ExpiryProduct']);
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('retailer/retailer_dashboard',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }



    public function index()
    {

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->retailer_model->get_retailer_list();
        $this->load->view('retailer/retailer_login',$data);
    }

	public function retailer_list()
	{

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->retailer_model->get_retailer_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('retailer/retailer_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}

	public function retailer_list_all(){

		 $data = json_encode($this->retailer_model->get_retailer_list());
		 echo $data;
	}


    public function retailer_add() {

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        //$data['stockist'] = $this->stockist_model->get_stockist_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('retailer/retailer_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function retailer_save(){
        $data = $this->retailer_model->retailer_save();
        echo $data;        
    }


    public function retailer_edit() {

        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['cities'] = $this->city_model->get_city_name_list();
	
	$id=$this->input->get('RetailerId');
        $data['details'] = $this->retailer_model->get_retailer_all_details_by_id($id);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('retailer/retailer_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function retailer_update() {

        $data = $this->retailer_model->retailer_update();
        echo $data;
    }

    public function get_retailer_details_by_id() {

        $RetailerId = $this->input->get('RetailerId');
        $data = $this->retailer_model->get_retailer_details_by_id($RetailerId);
        echo $data;
    }


    
    public function retailer_delete() {

        $data = $this->retailer_model->retailer_delete();
        echo $data;
    }

/**************** DASHBOARD FUNCTIONS ******************************/

    public function get_retailer_count(){
    
        $data = $this->retailer_model->get_retailer_count();
        echo $data;
    }

    public function get_top_performing_retailer(){
        $data = $this->retailer_model->get_top_performing_retailer();
        echo $data;
    }

    public function get_total_retailers(){
        $data = $this->retailer_model->get_total_retailers();
        echo $data;
    }

    public function get_retailers_total_sale_value(){
        $data = $this->retailer_model->get_retailers_total_sale_value();
        echo $data;
    }

    public function get_retailers_total_orders_count(){
        $data = $this->retailer_model->get_retailers_total_orders_count();
        echo $data;
    }

    public function get_total_new_customers(){
        $data = $this->retailer_model->get_total_new_customers();
        echo $data;   
    }
    
    public function forget_password()
    {
    	$data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'retailer';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();  
        $this->load->view('retailer/retailer_forget_password',$data);       
    }

/**************** DASHBOARD FUNCTIONS ******************************/
	public function forget_password_email_check()
	{
		$data = $this->retailer_model->forget_password_email_check();
        	echo $data;  		
	}

	public function reset_password()
	{
		$data = array();
        	$user_id = $this->session->userdata('user_id');
        	$data['code']=$this->input->get('forgetpassword_code');
        	$data['js_script'] = 'retailer';
        	$data['csrfName'] = $this->security->get_csrf_token_name();
        	$data['csrfHash'] = $this->security->get_csrf_hash();  
        	$this->load->view('retailer/reset_password',$data); 
	}

	public function change_password()
	{	

		$data = $this->retailer_model->change_password();
        	echo $data;  
	}
	
	public function expiry_product()
	{

		$data = array();
		$data['csrfName'] = $this->security->get_csrf_token_name();
        	$data['csrfHash'] = $this->security->get_csrf_hash();
		$user_id = $this->session->userdata('user_id');
		$data['js_script'] = 'retailer';
		$ExpiryProduct = $this->retailer_model->get_expiry_product();
		$expiry='';
		if(!empty($ExpiryProduct)){
		$s=0;
                      foreach($ExpiryProduct as $product)
                       { $s++;                                           		
             
             		     $expiry .="     <tr>
             		      <td>".$s."</td>
                                    <td>".$product['ProductName']."</td>
                                    <td>". $product['Batch']."</td>
                                    <td > ". $product['Expiry']."</td>
                                  </tr>";
                         }
                          }
                $data['list']=$expiry;         	
		 	
		$this->load->view('../../loggedin_template/header',$data);
        $this->load->view('../../report/expiry_list',$data); 
        $this->load->view('../../loggedin_template/footer',$data); 
        	
	}
	
		public function out_of_stock_product()
	{
		$data = array();
		$data['csrfName'] = $this->security->get_csrf_token_name();
        	$data['csrfHash'] = $this->security->get_csrf_hash();  
		$user_id = $this->session->userdata('user_id');
		$data['js_script'] = 'retailer';
		 $out_of_stock = $this->retailer_model->get_out_of_stock_product();
		 $datas='';
		if(!empty($out_of_stock)){
		$s=1;
		
                          foreach($out_of_stock as $stocks)
                          {  
                                       
                                       $datas .= '<tr>
                                       <td>'.$s.'</td>
                                       <td>'.$stocks['ProductName'].'</td>
                                       <td>'.$stocks['psum'].'</td>';
                                            
                                       
                                           $s++; }
                          }
                                           
$data['list']=$datas; 
        	
		$this->load->view('../../loggedin_template/header',$data);
        $this->load->view('../../report/out_of_stock',$data); 
        $this->load->view('../../loggedin_template/footer',$data);
        	
	}
	
		public function all_stock_product()
	{
		$data = array();
		$data['csrfName'] = $this->security->get_csrf_token_name();
        	$data['csrfHash'] = $this->security->get_csrf_hash();  
		$user_id = $this->session->userdata('user_id');
		$data['js_script'] = 'retailer';
		 $stocks= $this->retailer_model->get_all_stock_product();
		 $datas='';
		if(!empty($stocks)){
		$s=1;
		
                          foreach($stocks as $stock)
                          {  
                                       
                                       $datas .= '<tr>
                                       <td>'.$s.'</td>
                                       <td>'.$stock['ProductName'].'</td>
                                       <td>'.$stock['psum'].'</td>
                                       <td>'.$stock['totalsales'].'</td>';
                                            
                                       
                                           $s++; }
                          }
                                           
$data['list']=$datas; 
        	
		$this->load->view('../../loggedin_template/header',$data);
        $this->load->view('../../report/all_stock_product',$data); 
        $this->load->view('../../loggedin_template/footer',$data);
        	
	}
	
	



}
