<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos extends MY_Controller {

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
        $this->load->model('product/product_model');
        $this->load->model('pos_model');
        $this->load->model('state/state_model');
        $this->load->model('orders/orders_model');
        $this->load->model('city/city_model');
        $this->load->library('encrypt');
        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }

    public function t(){
       $o =  generate_orderid('2');
       echo $o;
       echo "<br>";
       echo strlen($o);
    }

	public function pos_orders_list()
	{
        $data = array();
        $user_id = $this->session->userdata('AgentId');
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->pos_model->get_pos_orders_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('pos/pos_orders_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}




    public function pos_orders_add() {
        $data = array();
        //$user_id = $this->session->userdata('AgentId');
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['productlist'] = $this->product_model->get_all_product_list_with_for_pos();
        $data['prodcatlist'] = $this->product_model->get_all_product_category_list_for_pos();
        $this->load->view('pos_template/header',$data);
        $this->load->view('pos/pos_orders_add',$data);
        $this->load->view('pos_template/footer',$data);
    }

    public function pos_orders_save(){
        //pre($_POST);exit;
        $data = $this->pos_model->pos_orders_save();
        echo $data;       
    }

    public function orders_edit() {
        $data = array();
        //$user_id = $this->session->userdata('AgentId');
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['details'] = $this->pos_model->get_orders_details_by_id();
        $this->load->view('pos_template/header',$data);
        $this->load->view('pos/pos_orders_edit',$data);
        $this->load->view('pos_template/footer',$data);
    }



    public function pos_orders_delete() {
        $data = $this->pos_model->pos_orders_delete();
        echo $data;
    }

    public function pos_orders_print_agent(){
        $data = array();
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->pos_model->pos_orders_print();
        //pre($data['data']); exit;
        $this->load->view('pos_template/header',$data);
        $this->load->view('pos/pos_orders_print_agent',$data);
        $this->load->view('pos_template/footer',$data);        
    }



    public function pos_orders_return_add(){
        $data = array();
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['states'] = $this->state_model->get_state_name_list();
        $data['productlist'] = $this->product_model->get_all_product_list_with_for_pos();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('pos/pos_orders_return_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }


    public function get_sales_orders_list_by_date(){
        $data = $this->pos_model->get_sales_orders_list_by_date();
        echo $data;
    }

    public function get_order_details_by_orderid(){
        $data = $this->pos_model->get_order_details_by_orderid();
        echo $data;
    }


    public function pos_orders_return_save(){
        $data = $this->pos_model->pos_orders_return_save();
        echo $data;       
    }

    public function unholdposorder(){
        $data = $this->pos_model->unholdposorder();
        echo $data;          
    }
    
    public function cancelholdorder(){
        $data = $this->pos_model->cancelholdorder();
        echo $data;          
    }    

    public function get_todaysprofit(){
        $data = $this->pos_model->get_todaysprofit();
        echo $data;          
    }    

    public function get_counter_opening_closing_cash(){
        $data = $this->pos_model->get_counter_opening_closing_cash();
        echo $data;
    }

    public function opening_cash_save(){
        $data = $this->pos_model->opening_cash_save();
        echo $data;
    }

    public function closing_cash_save(){
        $data = $this->pos_model->closing_cash_save();
        echo $data;
    }

    public function sync_pos_orders_master_customer(){
        $data = $this->pos_model->sync_pos_orders_master_customer();
        echo $data;
    }

    public function sync_pos_orders_details_customer(){
        $data = $this->pos_model->sync_pos_orders_details_customer();
        echo $data;
    }
    
    public function list_hold_orders(){
        $data = $this->pos_model->list_hold_orders();
        echo $data;
    }

    public function update_hold_orders(){
        $data = $this->pos_model->update_hold_orders();
        echo $data;
    }

    public function sync_pos_product_stock_master(){
        $data = $this->pos_model->sync_pos_product_stock_master();
        echo $data;
    }

    public function update_product_stock_master_status(){
        $data = $this->pos_model->update_product_stock_master_status();
        echo $data;
    }
     public function tosync_pos_product_stock_master_LtoS(){
        $data = $this->pos_model->tosync_pos_product_stock_master_LtoS();
        echo $data;
    }
    
    public function pos_profit_list()
    {    
        $data = array();
        $user_id = $this->session->userdata('AgentId');
        $data['js_script'] = 'pos';
        $data['csrfName'] = $this->security->get_csrf_token_name();
       	$data['csrfHash'] = $this->security->get_csrf_hash();
       	$data['list'] = $this->pos_model->get_pos_profit_list();     
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('pos/pos_profit_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
   }
   
   public function get_orders_by_date()
   {
   	$date=$this->input->post('date');
   	$data = $this->pos_model->get_orders_by_date($date);
        echo $data;
   }
/************************** POS **************************************/
}

