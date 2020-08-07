<?php

class Pos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('stockist/stockist_model');
        $this->load->model('retailer/retailer_model');
        $this->load->model('customer/customer_model');
    }



     public function get_pos_orders_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';

        $UserId = $_SESSION['AgentId'];
        $UserRole = $_SESSION['user_role'];

            $sql = "SELECT 
            orders_master_customer.*,
            agent_master.AgentName as FromName,
            customer_master.CustomerName as ToName, 
            date_format(orders_master_customer.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM orders_master_customer 
            INNER JOIN agent_master ON orders_master_customer.AgentId=agent_master.AgentId 
            INNER JOIN customer_master ON orders_master_customer.CustomerId=customer_master.CustomerId 
            WHERE `orders_master_customer`.`AgentId`='".$UserId."' ORDER BY id DESC";
   


        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
/*
<a class="btn btn-xs btn-success" href="" title="Details" data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsSender('.$value['id'].')"><i class="fa fa-table" aria-hidden="true"></i></a> 
                            
<a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit').'/?OrderId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
*/                      if($value['TransactionType']=='1'){
                            $rowbg = '';
                            $TransactionType='Sale';
                        }elseif($value['TransactionType']=='3'){
                            $rowbg = 'background:#CEFFC1';
                            $TransactionType='hold';
                        }else{
                            $rowbg = 'background:#ffc2c2;';
                            $TransactionType='Return';
                        }

                        // <button id="delete" onclick="deleterow(\''.$value["OrderId"].'\',\''."row".$value["id"].'\',\''.site_url('pos/pos_orders_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        
                        $result.='<tr id="row'.$value['id'].'" style="'.$rowbg.'" >';
                        $result.='<td>'.$i.'. 

                            <a class="btn btn-xs btn-primary" href="'.site_url('pos/pos_orders_print_agent').'/?OrderId='.$value["OrderId"].'" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></td>

                        <td>'.$value['OrderId'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['ToName'].'</td>
                        <td>'.$value['OrderTotalAmount'].'</td>
                        <td>'.$TransactionType.'</td>
                        <td>'.$value['CreatedDateTime'].'</td>';

                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }

 

    public function send_order_on_mail($orderid,$orderdata,$orderdetails){

        $toemail='';
        $orderbookedby="";

        $message ="<table style='width: 100%;' border='1'>";


        if($_SESSION['user_role']=='retailer'){


            $data['User'] = $this->retailer_model->get_retailer_details_by_id($orderdata['RetailerId']);
            $data['OrderSubmitedfor'] = $this->stockist_model->get_stockist_details_by_id($orderdata['StockistId']);
            $orderbookedby = $data['User']['RetailerName'];

    $message .="<thead>
        <tr>
            <th colspan='4'></th>
        </tr>
        <tr>
            <th colspan='4'>Retailer Name:-".$data['User']['RetailerName']."</th>
        </tr>
        <tr>
            <th  colspan='2'>DL No. :- ".$data['User']['DLNo']."</th>
            <th  colspan='2'>TIN No. :-".$data['User']['TinNo']."</th>
        </tr>
        <tr>
            <th>Order No. :- ".$orderid."</th>
            <th>Order Date. :- ".date('d-m-Y',strtotime($orderdata['OrderDate']))."</th>
            <th>Stockist Name :- ".$data['OrderSubmitedfor']['StockistName']."</th>
            <th></th>
        </tr>
        </thead>";

        $toemail  = $data['OrderSubmitedfor']['StockistEmail'];

        }


        // pre($orderdata); 
        // pre($orderdetails);
        //pre($data['OrderSubmitedfor']);

        // exit;


    $message .="
        <tbody>
            <tr>
                <th colspan='4'>
                    <table border='1' style='width: 100%'>
                        <thead>
                            <tr>
                                <th>SNo.</th>
                                <th>Brand Name</th>
                                <th>Composition</th>
                                <th>Purchase Rate</th>
                                <th>MRP</th>
                                <th>OrderQuantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>";
                            $i=1;
                            foreach($orderdetails as $order){

                                $purchase_rate = $order['ProductPurchaseRate'];
                                $amount = $purchase_rate*$order['OrderQuantity'];

                                $product_details = $this->get_product_details_by_id($order['ProductId']);

                                $message .="<tr>
                                        <td>".$i."</td>
                                        <td>".$product_details['ProductName']."</td>
                                        <td>".$product_details['Composition']."</td>
                                        <td>".$purchase_rate."</td>
                                        <td>".$order['ProductMRP']."</td>
                                        <td>".$order['OrderQuantity']."</td>
                                        <td>".$amount."</td>
                                    </tr>";
                                    $i++; 
                            }
                        $message .="<tr>
                                <th colspan='6' class='' style='text-align: right;'>Total Amount</th>
                                <td>".$orderdata['OrderTotalAmount']."</td>
                            </tr>
                        </tbody>                    
                    </table>                
                </th>
            </tr>
        </tbody>
    </table>";

        if(!empty($toemail)){
            send_mail_simple($toemail,FROM_EMAIL,'New Order Booked by '.$orderbookedby,$message);
        }

    }



    public function get_product_details_by_id($productid){
        
        $sql = "SELECT ProductName,Composition FROM product_master_new WHERE id='".$productid."' ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } else {
                return false;
            }
        }
    }

    public function get_orders_details_by_id($OrderId){
        
        $sql = "SELECT * FROM orders_details WHERE OrderId='".$OrderId."' ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } else {
                return false;
            }
        }
    }



    public function get_orders_details_by_orderid_for_sender($OrderId){

        $UserRole = $_SESSION['user_role'];

        if($UserRole== 'agent' || $UserRole== 'retailer'){
            $sql = "SELECT *,orders_details_customer.id as orderdetailsid,product_master_new.id as productmasterid FROM orders_details_customer INNER JOIN product_master_new ON orders_details_customer.ProductId=product_master_new.id WHERE orders_details_customer.OrderId='".$OrderId."' ";
        }
        
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }


    public function get_product_stock_by_productid($ProductId,$UserId,$UserRoleId){
        $sql = "SELECT SUM(ProductQuantity) as ProductQuantity , ProductMinStockLevel FROM product_stock WHERE ProductId='".$ProductId."' AND UserId='".$UserId."' AND UserRoleId='".$UserRoleId."' GROUP BY ProductId LIMIT 0,1 "; 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } 
        }
    }






   public function pos_orders_update() {
        $CityId = $this->input->post('CityId');
        $StateId = $this->input->post('StateId');
        $CityName = $this->input->post('CityName');
        
        $sql = "SELECT id FROM orders_master WHERE `CityName` = '$CityName' AND StateId='$StateId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId'=>$StateId,'CityName' => $CityName);
        $this->db->where('id',$CityId);
        $update = $this->db->update('orders_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update City id = $CityId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_orders_by_stateid($StateId){
        $StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM orders_master WHERE StateId='$StateId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select City</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['CityName']."</option>";
        }
        return $options;
    }


    public function pos_orders_delete(){
        $OrderId = $this->input->post('id');
        $sql = "DELETE FROM orders_master_customer WHERE OrderId = '$OrderId'";
        $query = $this->db->query($sql);
        
        if($query){
            $orders_details_sql = "DELETE FROM orders_details_customer WHERE OrderId = '$OrderId'";
            $query = $this->db->query($orders_details_sql);
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function pos_orders_print(){
        $data = array();
        $OrderId = $this->input->get('OrderId');

            $sql = "SELECT * FROM orders_master_customer WHERE OrderId='".$OrderId."' ";
            $query = $this->db->query($sql);
            $result = $query->result_array(); 
            $data['summary'] = $query->result_array(); 
            $data['details'] = $this->get_orders_details_by_orderid_for_sender($result[0]['OrderId']);

            $data['User'] = $this->customer_model->get_customer_details_by_id($result[0]['CustomerId']);

            $data['OrderSubmitedfor'] = $this->retailer_model->get_retailer_details_by_id($result[0]['RetailerId']);
        return $data;
    }




/********************* POS *******************************/
    public function pos_orders_save() {

        $OrderDate = $this->input->post('OrderDate'); 
        $CustomerId = $this->input->post('CustomerId'); 
        $OrderDate = date('Y-m-d',strtotime($OrderDate));
        $UserRole = $this->input->post('UserRole');
        $totalamount = $this->input->post('totalamount');
        $ProductId = $this->input->post('ProductId');
        $MrpRate = $this->input->post('MrpRate');
        $quantity = $this->input->post('quantity');
        $amount = $this->input->post('amount');
        $datetime = date('Y-m-d H:i:s');
        $AgentId = $_SESSION['AgentId'];
        $RetailerId = $_SESSION['RetailerId'];
        $TaxPercentage = $this->input->post('taxpercent');
        $AmountWithTax = $this->input->post('finalamount');
        $PaymentMode = $this->input->post('paymentmode');
        $onhold = $this->input->post('onhold');

        //unique order generate for offline and online case
        $orderid = generate_orderid($RetailerId);
        
        if($onhold=='hold'){ $type='3'; }else{ $type='1'; }
		
		$this->db->trans_start();
            
            $data_array = array('OrderDate'=>$OrderDate,
                                'OrderId'=>$orderid,
                                'RetailerId' => $RetailerId,
                                'AgentId'=>$AgentId,
                                'CustomerId'=>$CustomerId,
                                'OrderTotalAmount'=>$totalamount,
                                'TaxPercentage'=>$TaxPercentage,
                                'AmountWithTax'=>$AmountWithTax,
                                'PaymentMode'=>$PaymentMode,
                                'TransactionType'=>$type, // on hold
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_customer', $data_array);
            $insert_id = $this->db->insert_id();

            $stock_array = array();
            $data_details_array = array();

                foreach ($quantity as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $orderid,
                        'RetailerId' => $RetailerId,
                        'AgentId'=>$AgentId,
                        'CustomerId'=>$CustomerId,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$MrpRate[$key],
                        'OrderQuantity'=>$qty,
                        'TransactionType'=>$type, // on hold
                        'CreatedDateTime'=>$datetime);

                    $stock_array[] = array(
                        'UserId'=>$RetailerId,
                        'UserRoleId'=>'3',
                        'RefferenceOrderNo' => $orderid,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$MrpRate[$key],
                        'ProductQuantity'=> -$qty,
                        'CreatedDateTime'=>$datetime
                        );
                }

                $insert_batch = $this->db->insert_batch('orders_details_customer', $data_details_array);

                //$inventory_batch = $this->db->insert_batch('inventory_master', $inventory_array);
                $insert = $this->db->insert_batch('product_stock',$stock_array);
				
				$this->db->trans_complete();

        if ($this->db->trans_status() === TRUE){
            /*             * *Activity Logs** */
            $msg = "Add POS orders id = $orderid";
            save_activity_details($msg);
            /* * *Activity Logs End** */


            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'orderid'=>$orderid));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function pos_orders_return_save() {

        $OrderDate = $this->input->post('OrderDate'); 
        $CustomerId = $this->input->post('CustomerId'); 
        $OrderDate = date('Y-m-d',strtotime($OrderDate));
        $UserRole = $this->input->post('UserRole');
        $totalamount = $this->input->post('totalamount');
        $ProductId = $this->input->post('ProductId');
        $ProductMRP = $this->input->post('MrpRate');
        $quantity = $this->input->post('quantity');
        $amount = $this->input->post('amount');
        $datetime = date('Y-m-d H:i:s');
        $AgentId = $_SESSION['AgentId'];
        $RetailerId = $_SESSION['RetailerId'];
        $TaxPercentage = $this->input->post('taxpercent');
        $AmountWithTax = $this->input->post('finalamount');
        $PaymentMode = $this->input->post('paymentmode');
            
            $data_array = array('OrderDate'=>$OrderDate,
                                'RetailerId' => $RetailerId,
                                'AgentId'=>$AgentId,
                                'CustomerId'=>$CustomerId,
                                'OrderTotalAmount'=>$totalamount,
                                'TaxPercentage'=>$TaxPercentage,
                                'AmountWithTax'=>$totalamount,
                                'PaymentMode'=>$PaymentMode,
                                'TransactionType'=>'2',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_customer', $data_array);
            $insert_id = $this->db->insert_id();

            $stock_array = array();
            $data_details_array = array();

                foreach ($quantity as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'RetailerId' => $RetailerId,
                        'AgentId'=>$AgentId,
                        'CustomerId'=>$CustomerId,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$ProductMRP[$key],
                        'OrderQuantity'=>$qty,
                        'TransactionType'=>'2',
                        'CreatedDateTime'=>$datetime);

                    $stock_array[] = array(
                        'UserId'=>$RetailerId,
                        'UserRoleId'=>'3',
                        'RefferenceOrderNo' => $insert_id,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$ProductMRP[$key],
                        'ProductQuantity'=> $qty,
                        'CreatedDateTime'=>$datetime
                        );
                }

                $insert_batch = $this->db->insert_batch('orders_details_customer', $data_details_array);

                //$inventory_batch = $this->db->insert_batch('inventory_master', $inventory_array);
                $insert = $this->db->insert_batch('product_stock',$stock_array);

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add POS orders return id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */


            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'orderid'=>$insert_id));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_product_info_by_id($ProductId){

        $sql = "SELECT * FROM product_master_new
                INNER JOIN product_stock ON product_stock.ProductId=product_master_new.id
                WHERE product_master_new.id='".$ProductId."' ";
        //return $sql;
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            
            } else {
                return false;
            }
        }
    }


    // public function get_sales_orders_list_by_date(){
    //     $orderdate = $this->input->post('orderdate');

    //     $odate = date('Y-m-d',strtotime($orderdate));

    //     $sql = "SELECT id FROM orders_master_customer 
    //             WHERE OrderDate ='".$odate."' AND TransactionType='1'";
    //     //return $sql;
    //     $query = $this->db->query($sql);
    //     if ($query) {
    //         if ($query->num_rows() > 0) {
    //             $result = $query->result_array();
    //             return json_encode($result);
            
    //         } else {
    //             return false;
    //         }
    //     }
    // }


    public function get_order_details_by_orderid(){
        $orderid = $this->input->post('orderid');

        $data = array();

        $sql = "SELECT orders_master_customer.*,customer_master.CustomerName FROM orders_master_customer 
                INNER JOIN customer_master ON orders_master_customer.CustomerId=customer_master.id
                WHERE orders_master_customer.id ='".$orderid."' ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                $data['summary'] = $result[0];

                    $sql_details = "SELECT orders_details_customer.*,product_master_new.ProductName FROM orders_details_customer 
                            INNER JOIN product_master_new ON orders_details_customer.ProductId=product_master_new.id
                            WHERE OrderId ='".$orderid."' ";
                    $query_details = $this->db->query($sql_details);
                    $result_details = $query_details->result_array();
                    $data['details'] = $result_details;

                return json_encode($data);
            
            } else {
                return false;
            }
        }
    }


    public function unholdposorder(){
        $orderid = $this->input->post('orderid');

        $update_data = array('TransactionType'=>'1');

        $this->db->where('id',$orderid);
        $this->db->update('orders_master_customer',$update_data);

        $this->db->where('OrderId',$orderid);
        $this->db->update('orders_details_customer',$update_data);
        $afftectedRows = $this->db->affected_rows();

        if ($afftectedRows) {
            /*             * *Activity Logs** */
            $msg = "Un-hold POS orders id = $orderid";
            save_activity_details($msg);
            /* * *Activity Logs End** */
            return json_encode(Array("status" => "1",'msg'=>'Un-Hold successfully'));
        } else {
            return json_encode(Array("status" => "2",'msg'=>ERROR_MSG));
        }
    }


    public function cancelholdorder(){
        $orderid = $this->input->post('orderid');

        $this->db->where('id',$orderid);
        $this->db->where('TransactionType','3');
        $this->db->delete('orders_master_customer');

        $this->db->where('OrderId',$orderid);
        $this->db->where('TransactionType','3');
        $this->db->delete('orders_details_customer');

        $this->db->where('RefferenceOrderNo',$orderid);
        $this->db->delete('product_stock');
        $afftectedRows = $this->db->affected_rows();

        if ($afftectedRows) {
            /*             * *Activity Logs** */
            $msg = "Cancel POS hold orders id = $orderid";
            save_activity_details($msg);
            /* * *Activity Logs End** */
            return json_encode(Array("status" => "1",'msg'=>'Canceled successfully'));
        } else {
            return json_encode(Array("status" => "2",'msg'=>ERROR_MSG));
        }
    }


    public function get_todaysprofit(){

        $prod_sql = "SELECT id, ROUND((`PurchaseRate`+(`PurchaseRate`*(`PTRMargin`/100))),2) as Rate FROM `product_master_new` ORDER BY id ASC";
        $prod_query = $this->db->query($prod_sql);
        $prod_result = $prod_query->result_array();

        foreach ($prod_result as $key => $value) {
            $products[$value['id']] = $value['Rate'];
        }

        $todaydate = date('Y-m-d'); //'2018-04-11';
        $data = array();
        $total_purchase_money = array();
        $total_mrp_money = array();
        $sql = "SELECT ProductId,`ProductMRP` , `OrderQuantity` 
            FROM `orders_details_customer` 
            WHERE `OrderDate`='".$todaydate."' AND  ( `TransactionType`='1' OR `TransactionType`='3')";
        //return $sql;
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();

                foreach ($result as $k => $v) {
                    $data[$k] = $v;
                    $data[$k]['Purchase'] = $products[$v['ProductId']];
                }


                foreach ($data as $key => $value) {
                    $total_purchase_money[$key] = $value['OrderQuantity']*$value['Purchase'];
                    $total_mrp_money[$key] = $value['OrderQuantity']*$value['ProductMRP']; 
                }

                $total_purchase = array_sum($total_purchase_money);
                $total_mrp = array_sum($total_mrp_money);

                $profit = sprintf( '%0.2f', $total_mrp - $total_purchase );

                return json_encode(array('status'=>'1','data'=>$data,'purchase'=>$total_purchase,'$mrp'=>$total_mrp,'profit'=>$profit));
            
            } else {
                return json_encode(array('status'=>'2'));
            }
        }        
    }


    public function get_counter_opening_closing_cash(){

        $RetailerId = $this->session->userdata('RetailerId');
        $AgentId = $this->session->userdata('AgentId');
        $todaydate = date('Y-m-d');

        $sql = "SELECT id FROM agent_daily_cash  
                WHERE `RetailerId`='".$RetailerId."' AND `AgentId`='".$AgentId."' AND date_format(OpeningDateTime,'%Y-%m-%d') = '".$todaydate."'  AND (`ClosingCash` IS NULL  OR  `ClosingCash`='0.00' ) AND `OpeningCash`IS NOT NULL ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return json_encode(array('status'=>'1','result'=>$result));
            } else {
                return json_encode(array('status'=>'2'));
            }
        }
    }


    public function opening_cash_save(){
        $openingcash = $this->input->post('openingcash');
        $RetailerId = $this->session->userdata('RetailerId');
        $AgentId = $this->session->userdata('AgentId');
        $todaydatetime = date('Y-m-d H:i:s');

        $insert_data = array('RetailerId'=>$RetailerId,'AgentId'=>$AgentId,'OpeningDateTime'=>$todaydatetime,'OpeningCash'=>$openingcash,'ClosingDateTime'=>'','ClosingCash'=>'');
        $insert = $this->db->insert('agent_daily_cash',$insert_data);
        return $this->db->last_query();

            if ($insert) {
                return json_encode(array('status'=>'1','msg'=>SUCCESS_INSERT_MSG));
            } else {
                return json_encode(array('status'=>'2','msg'=>ERROR_MSG));
            }

    }


    public function closing_cash_save(){
        $closingcash = $this->input->post('closingcash');
        $RetailerId = $this->session->userdata('RetailerId');
        $AgentId = $this->session->userdata('AgentId');
        $todaydatetime = date('Y-m-d H:i:s');
        $todaydate = date('Y-m-d');

        $data = array('ClosingDateTime'=>$todaydatetime,'ClosingCash'=>$closingcash);

        $this->db->where('RetailerId',$RetailerId);
        $this->db->where('AgentId',$AgentId);
        $this->db->where("date_format(OpeningDateTime,'%Y-%m-%d')",$todaydate);
        $this->db->where('ClosingCash','0.00');
        $insert = $this->db->update('agent_daily_cash',$data);
        //return $q = $this->db->last_query();

            if ($insert) {
                return json_encode(array('status'=>'1','msg'=>SUCCESS_INSERT_MSG));
            } else {
                return json_encode(array('status'=>'2','msg'=>ERROR_MSG));
            }
    }


    public function sync_pos_orders_master_customer(){
        $data = $this->input->post('orders_master');

        foreach ($data['orders_master_customer'] as $key => $value) {
            $data['orders_master_customer'][$key]['SyncStatus'] = '0';
        }
        
        $insert = $this->db->insert_batch('orders_master_customer',$data['orders_master_customer']);

        foreach ($data['orders_master_customer'] as $key => $value) {
            $OrderIds[] = $value['OrderId'];
        }

        $ids = join(',',$OrderIds);

        if($insert){
            return json_encode(array('status'=>'1','msg'=>'data inserted','OrderIds' => $ids));
        }else{
            return json_encode(array('status'=>'2','msg'=>'No data to sync'));
        }
    }

    public function sync_pos_orders_details_customer(){
        $data = $this->input->post('orders_details');

        foreach ($data['orders_details_customer'] as $key => $value) {
            $data['orders_details_customer'][$key]['SyncStatus'] = '0';
        }
        
        $insert = $this->db->insert_batch('orders_details_customer',$data['orders_details_customer']);

        foreach ($data['orders_details_customer'] as $key => $value) {
            $OrderIds[] = $value['OrderId'];
        }

        $ids = join(',',$OrderIds);

        if($insert){
            return json_encode(array('status'=>'1','msg'=>'data inserted','OrderIds' => $ids));
        }else{
            return json_encode(array('status'=>'2','msg'=>'No data to sync'));
        }
    }

    public function list_hold_orders(){
        $sql = "SELECT OrderId FROM orders_master_customer WHERE `TransactionType`='3' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            foreach ($data as $key => $value) {
                $ids[] = $value['OrderId']; 
            }

            $orderids = join(',',$ids);

            return json_encode(array('status'=>'1','msg'=>'Data Sync','data'=>$orderids));
        } else {
            return json_encode(array('status'=>'2','msg'=>'No Data to Sync','data'=>''));
        }
    }

    public function update_hold_orders(){
        $updateorderids = $this->input->post('updateorderids');

        $this->db->query("UPDATE orders_master_customer SET `TransactionType`='1' WHERE OrderId IN (".$updateorderids.")");

        $this->db->query("UPDATE orders_details_customer SET `TransactionType`='1' WHERE OrderId IN (".$updateorderids.")");

        return json_encode(array('status'=>'1','msg'=>'Data Sync','data'=>$updateorderids));
    }

    public function sync_pos_product_stock_master(){
        $UserId = $this->input->post('UserId');
        $UserRoleId = $this->input->post('UserRoleId');

        $sql = "SELECT  `UserId`, `UserRoleId`, `ProductId`, `ProductQuantity`, `MRP`, `DiPrice`, `Batch`, `Expiry`, `MfgDate`, `CreatedDateTime`, `RefferenceOrderNo`
                FROM product_stock_master WHERE `SyncStatus`='1' AND `UserId`='$UserId' AND `UserRoleId`='$UserRoleId' ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data['product_stock_master'] = $query->result_array();
            return json_encode(array('status'=>'1','msg'=>'Data Sync','data'=>$data));
        } else {
            return json_encode(array('status'=>'2','msg'=>'No Data to Sync','data'=>$sql));
        }
    }

    public function update_product_stock_master_status(){

        $updatecondition = $this->input->post('updatecondition');
        
        $update_data = array('SyncStatus'=>'0');

        foreach ($updatecondition as $key => $condition) {
            $this->db->where($condition);
            $this->db->update('product_stock_master',$update_data);
        }
        
        
        return json_encode(array('status'=>'1','msg'=>'Data Sync'));
    }
    public function tosync_pos_product_stock_master_LtoS(){

        $data = $this->input->post('productstockmaster');

        foreach ($data['product_stock_master'] as $key => $value) {
            $data['product_stock_master'][$key]['SyncStatus'] = '0';
        }
        
        $insert = $this->db->insert_batch('product_stock_master',$data['product_stock_master']);

        foreach ($data['product_stock_master'] as $key => $value) {
            $condition[] = array('Batch'=>$value['Batch'],'ProductId'=>$value['ProductId'],'SyncStatus'=>'1');
        }

        //$ids = join(',',$OrderIds);

        if($insert){
            return json_encode(array('status'=>'1','msg'=>'data inserted','condition' => $condition));
        }else{
            return json_encode(array('status'=>'2','msg'=>'No data to sync'));
        }

    }
    
    
     public function get_pos_profit_list()
     {
        $UserId = $_SESSION['AgentId'];
        $UserRole = $_SESSION['user_role'];
        $sql = "SELECT 
            orders_master_customer.*,
            agent_master.AgentName as FromName,
            customer_master.CustomerName as ToName, 
            date_format(orders_master_customer.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM orders_master_customer 
            INNER JOIN agent_master ON orders_master_customer.AgentId=agent_master.AgentId 
            INNER JOIN customer_master ON orders_master_customer.CustomerId=customer_master.CustomerId 
            WHERE `orders_master_customer`.`AgentId`='".$UserId."'  AND orders_master_customer.OrderDate= CURDATE() AND orders_master_customer.TransactionType=1 OR orders_master_customer.TransactionType=2 ORDER BY id DESC";   
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
           	$result=$query->result_array();
        }
        return $result;
    }
    
    public function get_orders_by_date($date)
    {
     $UserId = $_SESSION['AgentId'];
        $UserRole = $_SESSION['user_role'];
        $date=date('Y-m-d',strtotime($date));
    	$sql = "SELECT 
            orders_master_customer.*,
            agent_master.AgentName as FromName,
            customer_master.CustomerName as ToName, 
            date_format(orders_master_customer.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM orders_master_customer 
            INNER JOIN agent_master ON orders_master_customer.AgentId=agent_master.AgentId 
            INNER JOIN customer_master ON orders_master_customer.CustomerId=customer_master.CustomerId 
            WHERE `orders_master_customer`.`AgentId`='".$UserId."' AND orders_master_customer.TransactionType=1 AND orders_master_customer.OrderDate='$date' ORDER BY id DESC";   
        $query = $this->db->query($sql);
        $result="";
        $div='';
        if ($query) {
           	$result=$query->result_array();
           	 $TotalPrice=0.00;
           	 $i=1;
                          foreach($result as $value)
                          {
                          $i=$i++;
                          $profit=0.00;
                         	 $order_product=$this->orders_model->get_customer_order_details_by_orderid($value['OrderId']);                         	
                         	foreach($order_product as $order)
                         	{
                         		$profit=$profit + (($order['ProductMRP']*$order['PTRMargin']/100)*$order['OrderQuantity']);
                         	}
                         	$TotalPrice=$TotalPrice+$profit;
                        
                          $div= '<tr >
                             <th style="width:80px;">'.$i.'<a class="btn btn-xs btn-primary" href="'.site_url('pos/pos_orders_print_agent').'/?OrderId='.$value["OrderId"].'" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></th>
                             <td>'.$value['OrderId'].' </td>
                             <td>'.$value['FromName'].'</td>
                             <td>'.$value['ToName'].'</td>                             
	                     <td>'.$value['OrderTotalAmount'].'</td>                      
	                     <td>'. number_format($profit,2).'</td>
                             <td>'.$value['CreatedDateTime'].'</td>
                          </tr>	';
                         
                          } 
                          $div .='<tr style="background-color: #f8ac594d;">
                             <th style="width:80px;"></th>
                             <td></td>
                             <td></td>
                             <td></td>                             
	                     <td></td>                      
	                     <td>Total</td>
                             <td>'.number_format($TotalPrice,2).'</td>
                          </tr>';
        }
        return $div;
    
    }

} // class ends here



