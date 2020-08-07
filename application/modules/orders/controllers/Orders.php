<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

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
        //$this->load->model('retailer/retailer_model');
        $this->load->model('orders_model');

        //if(!isset($_SESSION) || count($_SESSION)<1){ $this->session_timedout(); }
    }
    
    public function sendtestmail(){
        send_mail_simple('smdelhi2020@gmail.com','admin@melhortechnologies.com','Sunflower- Order Cancelled - 123.','Dear Customer,<br> Your OrderId - 123 has been cancelled successfully. <br>Thanks,<br> Sunflower');
    }

    public function changeorderstatus(){
        $data = $this->orders_model->changeorderstatus();
        echo $data;
    }
    
    public function orders_print_dispatched(){
        $OrderId = $this->input->get('OrderId');
        $InvoiceNumber = $this->input->get('InvoiceNumber');
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['summary'] = $this->orders_model->get_orders_dispatch_summary_by_orderid($OrderId);
        $data['list'] = $this->orders_model->get_orders_dispatch_details_by_orderid($OrderId,$InvoiceNumber);
        $this->load->view('orders/orders_print_dispatched',$data);
    }


	public function orders_list()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->orders_model->get_orders_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function orders_list_dispatched()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->orders_model->get_orders_list_dispatched();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_list_dispatched',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	
	public function orders_list_cancelled()
	{
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->orders_model->get_orders_list_cancelled();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_list_cancelled',$data);
        $this->load->view('../../loggedin_template/footer',$data);
	}
	

	// public function orders_list_all(){
	// 	 $data = json_encode($this->orders_model->get_orders_list());
	// 	 echo $data;
	// }
	
	



    public function get_orders_dispatch_details_by_orderid(){
        $OrderId = $this->input->post('OrderId');
        $invoicenumber = $this->input->post('invoicenumber');
        $d="";
        $image = $this->orders_model->get_CustomOrder_image($OrderId);
        
        //pre($data);exit;
        $total=0;
            $d.="<div class='panel-heading' id='panelheading'>
                    <div class='tr' style='font-weight:bold'>
                        <div class='td'>OrderId</div>
                        <div class='td'>Product UIC</div>
                        <div class='td'>OrderType</div>
                        <div class='td'>Product Design</div>                       
                        <div class='td'>Colour</div>                      
                        <div class='td'>Size</div>
                        <div class='td'>Image</div>
                        <div class='td'>Quantity</div>
                        <div class='td'>Price</div>
                        <div class='td'>Amount</div>
                    </div>
                </div>";

        $data = $this->orders_model->get_orders_dispatch_details_by_orderid($OrderId,$invoicenumber);
        foreach ($data as $key => $row) {
            $amount = $row['Price']*$row['ProductQty'];
            $total+=$amount;
            
            $UIC = str_replace(",","<br>",$row['ProductUIC']);
            
            $filename='';
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.jpg') ){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.jpg';    
            }
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.png') ){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.png';
            }
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.jpeg')){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.jpeg';
            }
            
            $d.="
                <div class='panel-body' id='orderdetailsbody'>
                    <div class='tr'>
                        <div class='td'>".$row['OrderId']."</div>
                        <div class='td'>".$UIC."</div>
                        <div class='td'>".$_SERVER['ORDERTYPE'][$row['OrderType']]."</div>
                        <div class='td'>".$row['DesigneCode']."</div>                       
                        <div class='td'>".$row['ColourName']."</div>
                        <div class='td'>";
                    if(!$image){ $d.= $row['SizeName']; }else{ $d.= "Custom Order"; }
                        
                        $d.="</div><div class='td'>";
                        
                        if($image){
                            $d.="<a href='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' target='_blank'><img src='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' height='200' /></a>";
                        }else{
                            $d.="<img src='".base_url('uploads/products/'.$filename)."' style='height:100px;max-width:100px;'>";
                        }
                    
                    $d.="</div>
                        <div class='td'>".$row['ProductQty']."</div>
                        <div class='td'>".$row['Price']."</div>
                        <div class='td' style='text-align:right;'>".sprintf('%0.2f',$amount)."</div>
                    </div>
                 </div>";
        }

        $d.="<div class='panel-footer'  id='orderdetailsfooter'>
                    <div class='tr' style='font-weight:bold'>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'>Total</div>
                        <div class='td' id='showtotalamount'>".sprintf('%0.2f',$total)."</div>
                    </div>
                </div>";
        
        
        $Comment = $this->orders_model->get_Order_Comment($OrderId);
        $Comment_table = "<div class='row'>";
        foreach($Comment as $k => $c){
            $Comment_table .= "<div class='col-md-3' style='width:25%;border-bottom:solid 1px #dddddd'><b>".ucfirst($k)."</b></div><div class='col-md-3' style='width:25%;border-bottom:solid 1px #dddddd'>".$c."</div>";
        }
        $Comment_table .= "</div>";
        $d.="<div>Comment:".$Comment_table." </div>";
        
        /*
        if($image){
            $d.="<div><b>Image:</b> <a href='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' target='_blank'><img src='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' height='200' /></a></div>";
        }
        */
        echo $d;
    }

    public function get_orders_details_by_orderid(){
        $OrderId = $this->input->post('OrderId');
        $d="";
        $image = $this->orders_model->get_CustomOrder_image($OrderId);
        
        //pre($data);exit;
        $total=0;
            $d.="<div class='panel-heading' id='panelheading'>
                    <div class='tr'>
                        <div class='td'>OrderId</div>
                        <div class='td'>Product UIC</div>
                        <div class='td'>OrderType</div>
                        <div class='td'>Product Design</div>                       
                        <div class='td'>Colour</div>                      
                        <div class='td'>Size</div>
                        <div class='td'>Image</div>
                        <div class='td'>Quantity</div>
                        <div class='td'>Price</div>
                        <div class='td'>Amount</div>
                    </div>
                </div>";
                
        $data = $this->orders_model->get_orders_details_by_orderid($OrderId);
        if(is_array($data)){
        foreach ($data as $key => $row) {
            $amount = $row['Price']*$row['OrderQuantity'];
            $total+=$amount;
            
            $UIC = str_replace(",","<br>",$row['ProductUIC']);
            
            
            $filename='';
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.jpg') ){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.jpg';    
            }
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.png') ){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.png';
            }
            if (file_exists('./uploads/products/'.$row['DesigneCode'].'~'.$row['ColourId'].'.jpeg')){
                $filename = $row['DesigneCode'].'~'.$row['ColourId'].'.jpeg';
            }
            
            $d.="
                <div class='panel-body' id='orderdetailsbody'>
                    <div class='tr'>
                        <div class='td'>".$row['OrderId']."</div>
                        <div class='td'>".$UIC."</div>
                        <div class='td'>".$_SERVER['ORDERTYPE'][$row['OrderType']]."</div>
                        <div class='td'>".$row['DesigneCode']."</div>                       
                        <div class='td'>".$row['ColourName']."</div>
                        <div class='td'>";
                    if(!$image){ $d.= $row['SizeName']; }else{ $d.= "Custom Order"; }
                        
                        $d.="</div><div class='td'>";
                        
                        if($image){
                            $d.="<a href='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' target='_blank'><img src='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' height='100' /></a>";
                        }else{
                            $d.="<img src='".base_url('uploads/products/'.$filename)."' style='height:100px;max-width:100px;'>";
                        }
                    
                    $d.="</div>
                        <div class='td'>".$row['OrderQuantity']."</div>
                        <div class='td'>".$row['Price']."</div>
                        <div class='td' style='text-align:right;'>".sprintf('%0.2f',$amount)."</div>
                    </div>
                 </div>";
        }}

        $d.="<div class='panel-footer'  id='orderdetailsfooter'>
                    <div class='tr'>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'></div>
                        <div class='td'>Total</div>
                        <div class='td' id='showtotalamount'>".sprintf('%0.2f',$total)."</div>
                    </div>
                </div>";
        
        
        $Comment = $this->orders_model->get_Order_Comment($OrderId);
        $Comment_table = "<div class='row'>";
        foreach($Comment as $k => $c){
            $Comment_table .= "<div class='col-md-3' style='width:25%;border-bottom:solid 1px #dddddd'><b>".ucfirst($k)."</b></div><div class='col-md-3' style='width:25%;border-bottom:solid 1px #dddddd'>".$c."</div>";
        }
        $Comment_table .= "</div>";
        $d.="<div>Comment:".$Comment_table." </div>";
        
        /*
        if($image){
            $d.="<div><b>Image:</b> <a href='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' target='_blank'><img src='".base_url('uploads/custom_orders/'.$image['custom_order_image'])."' height='200' /></a></div>";
        }
        */
        echo $d;
    }


    public function get_produic_by_design_color_size(){
        $data = $this->orders_model->get_produic_by_design_color_size();
        echo $data;
    }
    
    public function orders_dispatch_save(){
        $data = $this->orders_model->orders_dispatch_save();
        echo $data;
    }


    public function orders_pending()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->orders_model->get_orders_pending_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_pending',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function order_place_now(){
        //pre($_POST); exit;
        $data = $this->orders_model->order_place_now();
        echo $data; 
    }



    public function orders_received()
    {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['transporter']=$this->transporter_model->get_transporter_name_list();
        $data['list'] = $this->orders_model->get_orders_received_list();
        //$data['order_info'] = $this->orders_model->get_order_master_by_orderid($OrderId);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_received',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }



    public function orders_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['productlist'] = $this->product_model->get_all_product_list_with_brand();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
     public function orders_edit() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $OrderId=$this->input->get('OrderId');
        $data['order_info']=$this->orders_model->get_orders_details_by_orderid_for_sender($OrderId);
        //print_r($data['order_info']);
       // exit;
        $data['productlist'] = $this->product_model->get_all_product_list_with_brand();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_edit',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function orders_dispatch() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders_dispatch';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['orders'] = $this->orders_model->get_all_pending_orders_list();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_dispatch',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function get_order_details_for_despatch() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders_dispatch';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['orders'] = $this->orders_model->get_all_pending_orders_list();
        $data['list'] = $this->orders_model->get_order_details_for_despatch();
        $data['list_dispatched'] = $this->orders_model->get_order_details_of_despatched();
        $data['list_processing'] = $this->orders_model->get_order_details_of_processing();
        //pre($data);exit;
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_dispatch',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }
    
    public function orders_generate(){
        $data = array();
        //$orderid = '1589021629';
        $orderid = $this->input->post('OrderId');
        if(isset($_POST['DispatchOrderId'])){
            $DispatchOrderId = $_POST['DispatchOrderId'];
        }else{
            $DispatchOrderId=0;
        }
        $data['js_script'] = 'orders_dispatch';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->orders_model->get_orders_details_by_orderid($orderid);
        $data['customer_data'] = $this->orders_model->get_orders_shop_details_by_orderid($DispatchOrderId);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_generate',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }    
    

    public function pos_orders_add() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['productlist'] = $this->product_model->get_all_product_list_with_brand();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/pos_orders_add',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }

    public function orders_save(){
        //pre($_POST);exit;
        $data = $this->orders_model->orders_save();
        echo $data;        
    }

    public function orders_delete() {
        $data = $this->orders_model->orders_delete();
        echo $data;
    }

    public function get_produic_to_productorders() {
        $data = $this->orders_model->get_produic_to_productorders();
        echo $data;
    }
    
    
    
    public function get_orderlist_filter() {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['list'] = $this->orders_model->get_orderlist_filter();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_list',$data);
        $this->load->view('../../loggedin_template/footer',$data);
    }






    public function order_status_save(){
        //pre($_POST);
        $data = $this->orders_model->order_status_save();
        echo $data;
    }


    public function approve_selected_order_all_products(){
        //pre($_POST);exit;
        $data = $this->orders_model->approve_selected_order_all_products();
        echo $data;
    }


    public function orders_print_customer(){
        $data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = ''; //$this->orders_model->pos_orders_print();
        //pre($data['data']); exit;
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_print_customer',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }

    public function orders_print_retailer(){
        $data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->orders_model->orders_print();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_print_retailer',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }

    public function orders_print_stockist(){
        $data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->orders_model->orders_print();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_print_stockist',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }

   
   
	public function set_orders_status_to_dispatch(){
	
	    $data = $this->orders_model->set_orders_status_to_dispatch();
	    echo $data;       
	}
	
	public function get_orders_dispatched_recieve_list(){
	    $data = $this->orders_model->get_orders_dispatched_recieve_list();
	    echo $data;       
	}
	
	public function save_order_to_stock(){
	    $data = $this->orders_model->save_order_to_stock();
	    echo $data;       
	}



/************************** POS **************************************/

public function pos_orders_save(){
    //pre($_POST);exit;
    $data = $this->orders_model->pos_orders_save();
    echo $data;       
}

public function order_confirm(){	
	$data=$this->orders_model->order_confirm();
	echo $data;
	
}


public function invoice_print_stockist()
{
	$data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
	$id=$this->input->get('billid');
	 $data['master']=$this->orders_model->get_stockist_order_master_by_orderid($id);	
	 $data['details']=$this->orders_model->get_stockist_order_details_by_orderid($id);		 
	// $data['gst']=$this->orders_model->get_orders_group_by_gst($id); 	 
	$data['to']=$this->orders_model->get_stockist_data($data['master'][0]->StockistId);
	$data['from']=$this->orders_model->get_company_data($data['master'][0]->CompanyId);	
        $this->load->view('orders/invoice',$data);
       // $this->load->view('../../loggedin_template/footer',$data);   

}


public function invoice_print_retailer()
{
	$data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
	$id=$this->input->get('billid');
	 $data['master']=$this->orders_model->get_order_master_by_orderid($id);	
	 $data['details']=$this->orders_model->get_order_details_by_orderid($id);	
	// $data['gst']=$this->orders_model->get_orders_group_by_gst($id); 
	 if(isset($data['master'][0]->CompanyId)){
	 	$data['to']=$this->orders_model->get_stockist_data($data['master'][0]->StockistId);
	 	$data['from']=$this->orders_model->get_company_data($data['master'][0]->CompanyId);
	 }
	 if(isset($data['master'][0]->RetailerId))
	 {
		 $data['to']=$this->orders_model->get_retailer_data($data['master'][0]->RetailerId);
		 $data['from']=$this->orders_model->get_stockist_data($data['master'][0]->StockistId);
	 }
	// $data['product']=$this->order_model->get_product_data$data['master'][0]->ProductId();
      // $this->load->view('../../loggedin_template/header',$data);
     // pre($data);
     // exit;
        $this->load->view('orders/invoice',$data);
       // $this->load->view('../../loggedin_template/footer',$data);   

}





public function invoice()
{
	$data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
	$id=$this->input->get('billid');
	 $data['master']=$this->orders_model->get_order_master_by_orderid($id);	
	 $data['details']=$this->orders_model->get_order_details_by_orderid($id);	
	// $data['gst']=$this->orders_model->get_orders_group_by_gst($id); 
	 if(isset($data['master'][0]->CompanyId)){
	 	$data['to']=$this->orders_model->get_stockist_data($data['master'][0]->StockistId);
	 	$data['from']=$this->orders_model->get_company_data($data['master'][0]->CompanyId);
	 }
	 if(isset($data['master'][0]->RetailerId))
	 {
		 $data['to']=$this->orders_model->get_retailer_data($data['master'][0]->RetailerId);
		 $data['from']=$this->orders_model->get_stockist_data($data['master'][0]->StockistId);
	 }
	// $data['product']=$this->order_model->get_product_data$data['master'][0]->ProductId();
      // $this->load->view('../../loggedin_template/header',$data);
      //pre($data);
      //exit;
        $this->load->view('orders/invoice',$data);
       // $this->load->view('../../loggedin_template/footer',$data);   

}

   public function orders_supply() 
   {
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['productlist'] = $this->product_model->get_all_product_list_with_brand();
        $data['customer_list']='';
        if($_SESSION['user_role']=='stockist')
         {      
	        $data['customer_list']=$this->retailer_model->get_all_retailers($_SESSION['user_id']);
         }        
         if($_SESSION['user_role']=='admin')
         {      
       		$data['customer_list']=$this->stockist_model->get_all_stockists();
         }
        // print_r($data['customer_list']);
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_supply',$data);
        $this->load->view('../../loggedin_template/footer',$data);
   }

 public function orders_supply_save(){
        //pre($_POST);exit;
        $data = $this->orders_model->orders_supply_save();
        echo $data;        
    }
    
    public function orders_supply_print_retailer(){
        $data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->orders_model->orders_supply_print();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_print_retailer',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }
    
    public function orders_supply_print_stockist(){
        $data = array();
        $data['js_script'] = 'orders';
        $data['csrfName'] = $this->security->get_csrf_token_name();
        $data['csrfHash'] = $this->security->get_csrf_hash();
        $data['data'] = $this->orders_model->orders_supply_print();
        $this->load->view('../../loggedin_template/header',$data);
        $this->load->view('orders/orders_print_stockist',$data);
        $this->load->view('../../loggedin_template/footer',$data);        
    }




}

