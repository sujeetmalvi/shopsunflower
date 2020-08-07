<?php

class Orders_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('retailer/retailer_model');
        $this->load->model('user/user_model');
    }

     public function get_orders_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $UserId = $_SESSION['user_id'];
            $sql = "SELECT 
            ProductOrdersSummary.*,
            ShopMaster.ShopName as FromName,UserMaster.FullName,
            date_format(ProductOrdersSummary.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM ProductOrdersSummary 
            INNER JOIN UserMaster ON UserMaster.id=ProductOrdersSummary.UserId
            INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
            WHERE OrderStatus<3 ORDER BY ProductOrdersSummary.id DESC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        
                        switch ($value['OrderStatus']) {
                            case 5:
                                $bgcolor = '#ffcaca';
                                break;
                            case 0:
                                $bgcolor = '#cbcaff';
                                break;
                            case 1:
                                $bgcolor = '#cafffd';
                                break;
                            case 2:
                                $bgcolor = '#d2ffca';
                                break;
                            case 6:
                                $bgcolor = '#dddddd';
                                break;
                            case 3:
                                $bgcolor = '#cbcaff';
                                break;
                        }
                        
                        //<a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit').'/?OrderId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    $color='';
                        $result.='<tr '.$color.' id="row'.$value['id'].'"  style="background-color:'.$bgcolor.'">';
                        $result.='<td>'.$i.'.</td>';
                        $result.='<td>
                                <a class="btn btn-xs btn-success" href="#"  data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsSender('.$value['OrderId'].')">
                                <i class="fa fa-table" aria-hidden="true"></i></a>';
                        $result.="<select name='OrderStatus' class='form-control' style='width:140px;' data-dd='".$value['OrderStatus']."'        "; 
                               
                                if(in_array($value['OrderStatus'],array(3,5,6))){ $result.= "disabled='disabled'"; } 
                               
                        $result.=" onchange='changeorderstatus(".$value['OrderId'].",this.value);'>
                                <option value='0'";
                                if($value['OrderStatus']>0) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='0')?'selected="selected"':'';
                        $result.=">New Order</option>
                                <option value='1'";
                                if($value['OrderStatus']>1) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='1')?'selected="selected"':'';    
                        $result.=">Processing</option>
                                <option value='2'";
                                if($value['OrderStatus']>2) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='2')?'selected="selected"':'';    
                        $result.=">Ready</option>";
                        //        <option value='4'";
                        //    $result.= ($value['OrderStatus']=='4')?'selected="selected"':'';    
                        //$result.=">Partially Dispatched</option>
                        /*
                        $result.="<option value='3' disabled='disabled' ";
                        if($value['OrderStatus']==3) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='3')?'selected="selected"':'';    
                        $result.=">Dispatched</option>
                        */
                        
                        $result.="<option value='5'";
                                if($value['OrderStatus']==5) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='5')?'selected="selected"':'';    
                        $result.=">Cancel</option>";
                        /*
                                <option value='6'";
                                if($value['OrderStatus']==6) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='6')?'selected="selected"':'';    
                        $result.=">Delivered</option>
                        */
                        $result.="</select>
                                </td>"; 
                        
                        $result.='
                        <td>'.$value['OrderId'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['FullName'].'</td>
                        <td>'.$value['Quantity'].'</td>
                        <td>'.$value['Amount'].'</td>
                        <td>'.$value['CreatedDateTime'].'</td>';
                        $result.='</tr>';
                        $i++;
                        // <a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit/?OrderId='.$value["id"]).'" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    }
                return $result;
            } else {
                return false;
            }
        }
    }
    
    
    
    
 public function get_orders_list_dispatched(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $UserId = $_SESSION['user_id'];
            $sql = "SELECT 
            DispatchSummary.*,
            ShopMaster.ShopName as FromName,UserMaster.FullName,
            date_format(DispatchSummary.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime,
            date_format(DispatchSummary.InvoiceDate,'%d-%m-%Y') as InvoiceDate,InvoiceNumber
            FROM DispatchSummary 
            INNER JOIN UserMaster ON UserMaster.id=DispatchSummary.UserId
            INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
            WHERE 1  ORDER BY DispatchSummary.id DESC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        
                        
                        //<a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit').'/?OrderId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    $color='';
                        $result.='<tr '.$color.' id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'.</td>';
                        $result.='
                        <td><a class="btn btn-xs btn-success" href="#"  data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsDispatched('.$value['OrderId'].',\''.$value['InvoiceNumber'].'\')">
                                <i class="fa fa-table" aria-hidden="true"></i></a> '.$value['OrderId'].'</td>
                        <td>'.$value['InvoiceDate'].'</td>
                        <td>'.$value['InvoiceNumber'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['FullName'].'</td>
                        <td>'.$value['CreatedDateTime'].'</td>
                        <td><a class="btn btn-xs btn-success" target="_blank" href="'.site_url('orders/orders_print_dispatched/?OrderId='.$value['OrderId'].'&InvoiceNumber='.$value['InvoiceNumber']).'")">Print</a></td>';
                        $result.='</tr>';
                        $i++;
                        // <a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit/?OrderId='.$value["id"]).'" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    }
                return $result;
            } else {
                return false;
            }
        }
    }
    
 public function get_orders_list_cancelled(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $UserId = $_SESSION['user_id'];
            $sql = "SELECT 
            ProductOrdersSummary.*,
            ShopMaster.ShopName as FromName,UserMaster.FullName,
            date_format(ProductOrdersSummary.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM ProductOrdersSummary 
            INNER JOIN UserMaster ON UserMaster.id=ProductOrdersSummary.UserId
            INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
            WHERE OrderStatus='5' ORDER BY ProductOrdersSummary.id DESC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        
                        
                        //<a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit').'/?OrderId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    $color='';
                        $result.='<tr '.$color.' id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'.</td>';
                        $result.='
                        <td><a class="btn btn-xs btn-success" href="#"  data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsSender('.$value['OrderId'].')">
                                <i class="fa fa-table" aria-hidden="true"></i></a> '.$value['OrderId'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['FullName'].'</td>
                        <td>'.$value['Quantity'].'</td>
                        <td>'.$value['Amount'].'</td>
                        <td>'.$value['CreatedDateTime'].'</td>';
                        $result.='</tr>';
                        $i++;
                        // <a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit/?OrderId='.$value["id"]).'" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    }
                return $result;
            } else {
                return false;
            }
        }
    }
    
    public function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux,$to_format);
    }
    
    public function get_orderlist_filter(){
        //$UserId = $_SESSION['user_id'];
        $daterange = $_POST['daterange'];
        $dt = str_replace(" ","",$daterange);
        $range = explode('-',$dt);
        $d2 = $this->reformatDate($range[0]);
        $d3 = $this->reformatDate($range[1]);
        $sql = "SELECT ProductOrdersSummary.*, ShopMaster.ShopName as FromName,UserMaster.FullName, date_format(ProductOrdersSummary.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
                FROM ProductOrdersSummary 
                INNER JOIN UserMaster ON UserMaster.id=ProductOrdersSummary.UserId 
                INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
                WHERE ProductOrdersSummary.OrderStatus!='5' AND date_format(`OrderedDateTime`,'%Y-%m-%d') >= date_format('".$d2."','%Y-%m-%d') AND date_format(`OrderedDateTime`,'%Y-%m-%d') <= date_format('".$d3."','%Y-%m-%d')  
                ORDER BY ProductOrdersSummary.id DESC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) { 
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        switch ($value['OrderStatus']) {
                            case 5:
                                $bgcolor = '#ffcaca';
                                break;
                            case 0:
                                $bgcolor = '#cbcaff';
                                break;
                            case 1:
                                $bgcolor = '#cafffd';
                                break;
                            case 2:
                                $bgcolor = '#d2ffca';
                                break;
                            case 6:
                                $bgcolor = '#dddddd';
                                break;
                            case 3:
                                $bgcolor = '#cbcaff';
                                break;
                        }
                        
                        //<a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit').'/?OrderId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    $color='';
                        $result.='<tr '.$color.' id="row'.$value['id'].'"  style="background-color:'.$bgcolor.'">';
                        $result.='<td>'.$i.'</td>';
                        $result.='<td>
                                <a class="btn btn-xs btn-success" href="#"  data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsSender('.$value['OrderId'].')">
                                <i class="fa fa-table" aria-hidden="true"></i></a>';
                        $result.="<select name='OrderStatus' class='form-control' style='width:140px;' data-dd='".$value['OrderStatus']."'        "; 
                               
                                if(in_array($value['OrderStatus'],array(5,6))){ $result.= "disabled='disabled'"; } 
                               
                        $result.=" onchange='changeorderstatus(".$value['OrderId'].",this.value);'>
                                <option value='0'";
                                if($value['OrderStatus']>0) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='0')?'selected="selected"':'';
                        $result.=">New Order</option>
                                <option value='1'";
                                if($value['OrderStatus']>1) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='1')?'selected="selected"':'';    
                        $result.=">Processing</option>
                                <option value='2'";
                                if($value['OrderStatus']>2) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='2')?'selected="selected"':'';    
                        $result.=">Ready</option>";
                        //        <option value='4'";
                        //    $result.= ($value['OrderStatus']=='4')?'selected="selected"':'';    
                        //$result.=">Partially Dispatched</option>
                        $result.="<option value='3' disabled='disabled' ";
                        if($value['OrderStatus']>3) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='3')?'selected="selected"':'';    
                        $result.=">Dispatched</option>
                                <option value='5'";
                                if($value['OrderStatus']>5) { $result.= "disabled='disabled'"; }
                            $result.= ($value['OrderStatus']=='5')?'selected="selected"':'';    
                        $result.=">Cancelled</option>
                                <option value='6'";
                            $result.= ($value['OrderStatus']=='6')?'selected="selected"':'';    
                        $result.=">Delivered</option>
                            </select>
                                </td>"; 
                        $result.='
                        <td>'.$value['OrderId'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['FullName'].'</td>
                        <td>'.$value['Amount'].'</td>
                        <td>'.$value['Quantity'].'</td>';
                        $result.='<td>'.$value['CreatedDateTime'].'</td>';
                        $result.='</tr>';
                        $i++;
                        // <a class="btn btn-xs btn-warning" href="'.site_url('orders/orders_edit/?OrderId='.$value["id"]).'" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    }
                return $result;
            } else {
                return false;
            }
        }
    }

    public function get_orders_dispatch_summary_by_orderid($OrderId){
            $OrderId = ($OrderId!='')?$OrderId:$_POST['OrderId'];
            $sql = "SELECT 
            DispatchSummary.*,UserMaster.FullName,UserMaster.ContactNo,UserMaster.EmailId,
            ShopMaster.ShopName,ShopMaster.GstinNo,date_format(DispatchSummary.InvoiceDate,'%d-%m-%Y') as InvoiceDate 
            FROM DispatchSummary 
            INNER JOIN UserMaster ON UserMaster.id=DispatchSummary.UserId 
            INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
            WHERE DispatchSummary.`OrderId`='$OrderId' limit 0,1";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result;
            } else {
                return false;
            }
        }
    }

    public function get_orders_dispatch_details_by_orderid($OrderId,$invoicenumber=''){
            $OrderId = ($OrderId!='')?$OrderId:$_POST['OrderId'];
            $condition='';
            if($invoicenumber!=''){
                $condition = " AND  DispatchSummary.InvoiceNumber = '".$invoicenumber."'";
            }
            $sql = "SELECT 
            DispatchHistory.*,ProductMaster.ColourId,
            ProductMaster.DesigneCode,ProductMaster.ProductThumbnail,
            ColourMaster.ColourName,
            SizeMaster.SizeName
            FROM DispatchHistory 
            LEFT JOIN ProductMaster ON ProductMaster.id=DispatchHistory.ProductId 
            LEFT JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
            LEFT JOIN SizeMaster ON SizeMaster.id=ProductMaster.SizeId 
            LEFT JOIN DispatchSummary ON DispatchSummary.id=DispatchHistory.DispatchId 
            WHERE DispatchHistory.`OrderId`='$OrderId' $condition ORDER BY DispatchHistory.id DESC";
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
    
    public function get_orders_details_by_orderid($OrderId=''){
            //$OrderId = ($OrderId!='')?$OrderId:()?$_POST['DispatchOrderId']:'';
            
            $condition=" ProductOrders.id='' ";
            
            if(isset($_POST['ProdDispatchOrderId'])){
                $ProdDispatchOrderId = join(',',$_POST['ProdDispatchOrderId']);
                $condition = " ProductOrders.id IN($ProdDispatchOrderId)";
                
                $sql = "SELECT 
                ProductOrders.*,ProductMaster.ColourId,
                ProductMaster.DesigneCode,ProductMaster.ProductThumbnail,
                ColourMaster.ColourName,
                SizeMaster.SizeName,
                ( 
                    SELECT GROUP_CONCAT(ProductUIC) FROM DispatchHistory 
                    WHERE DispatchHistory.OrderId=ProductOrders.OrderId 
                    	AND DispatchHistory.ProductId=ProductOrders.ProductId 
                    	AND DispatchHistory.OrderType=ProductOrders.OrderType GROUP by ProductId,OrderType) as DispatcProductUIC,
                date_format(ProductOrders.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
                FROM ProductOrders 
                INNER JOIN ProductMaster ON ProductMaster.id=ProductOrders.ProductId 
                INNER JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
                INNER JOIN SizeMaster ON SizeMaster.id=ProductMaster.SizeId 
                WHERE  $condition ORDER BY ProductOrders.id DESC";
                
            }elseif(isset($_POST['DispatchOrderId']) && trim($_POST['DispatchOrderId'])!='' ){
                $condition = " ProductOrders.OrderId IN(".$_POST['DispatchOrderId'].")";
                
                $sql = "SELECT 
                ProductOrders.*,ProductMaster.ColourId,
                ProductMaster.DesigneCode,ProductMaster.ProductThumbnail,
                ColourMaster.ColourName,
                SizeMaster.SizeName,
                ( 
                    SELECT GROUP_CONCAT(ProductUIC) FROM DispatchHistory 
                    WHERE DispatchHistory.OrderId=ProductOrders.OrderId 
                    	AND DispatchHistory.ProductId=ProductOrders.ProductId 
                    	AND DispatchHistory.OrderType=ProductOrders.OrderType GROUP by ProductId,OrderType) as DispatcProductUIC,
                date_format(ProductOrders.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
                FROM ProductOrders 
                INNER JOIN ProductMaster ON ProductMaster.id=ProductOrders.ProductId 
                INNER JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
                INNER JOIN SizeMaster ON SizeMaster.id=ProductMaster.SizeId 
                WHERE  $condition ORDER BY ProductOrders.id DESC";
            }elseif($OrderId!=''){
                $condition = " ProductOrders.OrderId IN($OrderId)";
                $sql = "SELECT 
                ProductOrders.*,ProductMaster.ColourId,
                ProductMaster.DesigneCode,ProductMaster.ProductThumbnail,
                ColourMaster.ColourName,ProductOrders.ProductUIC  as DispatcProductUIC,
                SizeMaster.SizeName,date_format(ProductOrders.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
                FROM ProductOrders 
                INNER JOIN ProductMaster ON ProductMaster.id=ProductOrders.ProductId 
                INNER JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
                INNER JOIN SizeMaster ON SizeMaster.id=ProductMaster.SizeId 
                WHERE  $condition ORDER BY ProductOrders.id DESC";
            }
            
            //   $sql = "SELECT 
            //     ProductOrders.*,ProductMaster.ColourId,
            //     ProductMaster.DesigneCode,ProductMaster.ProductThumbnail,
            //     ColourMaster.ColourName,
            //     SizeMaster.SizeName,
            //     ( 
            //         SELECT GROUP_CONCAT(ProductUIC) FROM DispatchHistory 
            //         WHERE DispatchHistory.OrderId=ProductOrders.OrderId 
            //         	AND DispatchHistory.ProductId=ProductOrders.ProductId 
            //         	AND DispatchHistory.OrderType=ProductOrders.OrderType GROUP by ProductId,OrderType) as DispatcProductUIC,
            //     date_format(ProductOrders.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            //     FROM ProductOrders 
            //     INNER JOIN ProductMaster ON ProductMaster.id=ProductOrders.ProductId 
            //     INNER JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
            //     INNER JOIN SizeMaster ON SizeMaster.id=ProductMaster.SizeId 
            //     WHERE  $condition ORDER BY ProductOrders.id DESC"; //ProductOrders.`OrderId`='$OrderId'
            
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
    
    
    public function get_CustomOrder_image($orderid){
        $sql = "SELECT custom_order_image FROM ProductOrdersSummary WHERE OrderId='".$orderid."' AND custom_order_image<>'' ";
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
    
    public function get_orders_shop_details_by_orderid($orderid){
        $sql = "SELECT ShopMaster.*, ShopMaster.ShopName as FromName,UserMaster.FullName, date_format(ProductOrdersSummary.OrderedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
                FROM ProductOrdersSummary 
                INNER JOIN UserMaster ON UserMaster.id=ProductOrdersSummary.UserId 
                INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId 
                WHERE OrderId='".$orderid."'  
                ORDER BY ProductOrdersSummary.id DESC";
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
    
    public function orders_save() {
	
	//return json_encode($_POST);

        $OrderDate = $this->input->post('OrderDate'); 
        $OrderDate = date('Y-m-d',strtotime($OrderDate));
        $UserRole = $this->input->post('UserRole');
        $totalamount = $this->input->post('totalamount');
        $ProductId = $this->input->post('ProductId');
        $MrpRate = $this->input->post('MrpRate');
	    $Batch = $this->input->post('Batch');
        $MfgDate = $this->input->post('MfgDate');
        $Expiry = $this->input->post('Expiry');
        $PurchaseRate = $this->input->post('PurchaseRate');
        
        $PTRMargin = $this->input->post('PTRMargin');
        $PTSMargin = $this->input->post('PTSMargin');
        
        $quantity = $this->input->post('quantity');
        $amount = $this->input->post('amount');        
        $datetime = date('Y-m-d H:i:s');
        
        //return json_encode(array('qty'=>count($quantity),'exp'=>count($Expiry)));
        	
        // $sql = "SELECT id FROM orders_master WHERE `ProductCode` = '$ProductCode'  AND ProductName='$ProductName' "; //" AND `bActive`='0' 
        // $query = $this->db->query($sql);
        // if ($query) {
        //     if ($query->num_rows() > 0) {
        //         return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
        //     } 
        // }

        if($UserRole== 'retailer'){
            $RetailerId = $_SESSION['user_id'];
            $StockistId = $_SESSION['StockistId'];

             $data_array = array('OrderDate'=>$OrderDate,
                                'RetailerId' => $RetailerId,
                                'StockistId'=>$StockistId,
                                'OrderTotalAmount'=>$totalamount,
                                'OrderStatus'=>'0',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_retailer', $data_array);
            $insert_id = $this->db->insert_id();
		    $BillNo= '#DI'.$insert_id;
            $ar=array('BillNo'=>$BillNo);
            $this->db->where('id',$insert_id);
            $update = $this->db->update('orders_master_retailer',$ar);
                foreach ($Expiry as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'RetailerId' =>$RetailerId,
                        'StockistId'=>$StockistId,
                        'ProductId'=>$ProductId[$key],
                        'Expiry'=>$Expiry[$key],
			'MfgDate'=>$MfgDate[$key],
			'Batch'=>$Batch[$key],					
                        'ProductMRP'=>$MrpRate[$key],
                        'ProductPurchaseRate'=>$PurchaseRate[$key],
                        'OrderQuantity'=>$quantity[$key],
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_retailer', $data_details_array);


        }
        
        if($UserRole== 'stockist'){
            $StockistId = $_SESSION['user_id'];
            //$DistributorId = $_SESSION['DistributorId'];
            $CompanyId = '0';

             $data_array = array('OrderDate'=>$OrderDate,
                                'StockistId'=>$StockistId,
                                'CompanyId'=>$CompanyId,
                                'OrderTotalAmount'=>$totalamount,
                                'OrderStatus'=>'0',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_stockist', $data_array);
            $insert_id = $this->db->insert_id();
            $BillNo= '#DI'.$insert_id;
            $ar=array('BillNo'=>$BillNo);
            $this->db->where('id',$insert_id);
            $update = $this->db->update('orders_master_stockist',$ar);
                foreach ($Expiry as $key1 => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'StockistId' =>$StockistId,
                        'CompanyId'=>$CompanyId,
                        'ProductId'=>$ProductId[$key1],
                        'ProductMRP'=>$MrpRate[$key1],
			'Expiry'=>$Expiry[$key1],
			'MfgDate'=>$MfgDate[$key1],
			'Batch'=>$Batch[$key1],
                        'ProductPurchaseRate'=>$PurchaseRate[$key1],
                        'OrderQuantity'=>$quantity[$key1],
                        'Discount'=>$PTSMargin[$key1],
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_stockist', $data_details_array);
        }
        

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add orders id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            //$this->send_order_on_mail($insert_id,$data_array,$data_details_array);

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'orderid'=>$insert_id,'OrderSubmitUserType'=>$UserRole));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
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


        if($_SESSION['user_role']=='stockist'){

            
             $data['User'] = $this->stockist_model->get_stockist_details_by_id($orderdata['StockistId']);
             $data['OrderSubmitedfor'] = COMPANYNAME;

            $orderbookedby = $data['User']['StockistName'];

            $message .="<thead>
                <tr>
                    <th colspan='4'></th>
                </tr>
                <tr>
                    <th colspan='4'>Stockist Name:-".$data['User']['StockistName']."</th>
                </tr>
                <tr>
                    <th  colspan='2'>DL No. :- ".$data['User']['DLNo']."</th>
                    <th  colspan='2'>TIN No. :-".$data['User']['TinNo']."</th>
                </tr>
                <tr>
                    <th>Order No. :- ".$orderid."</th>
                    <th>Order Date. :- ".date('d-m-Y',strtotime($orderdata['OrderDate']))."</th>
                    <th>Company Name :- ".COMPANYNAME."</th>
                    <th></th>
                </tr>
                </thead>";

            $toemail  = '';//$data['OrderSubmitedfor']['DistributorEmail'];
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

    public function get_produic_by_design_color_size(){
        $DesigneCode = $this->input->post('DesigneCode');
        $ColourId = $this->input->post('ColourId');
        $SizeId = $this->input->post('SizeId');
        
        $sql = "SELECT ProductUIC FROM ProductStock WHERE DesigneCode='$DesigneCode' AND ColourId='$ColourId' AND SizeId='$SizeId' AND ProductStatus='2' AND BillNo='' ";
        $query = $this->db->query($sql);
        $data='';
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $res){
                    $data .='<option value="'.$res['ProductUIC'].'">'.$res['ProductUIC'].'</option>';
                }
                return $data;
            } else {
                return $data;
            }
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
    
    
    public function get_all_pending_orders_list(){
        $sql = "SELECT ProductOrdersSummary.id,ProductOrdersSummary.OrderId 
                FROM ProductOrdersSummary 
                INNER JOIN ProductOrders ON ProductOrders.OrderId=ProductOrdersSummary.OrderId
                WHERE  ProductOrders.OrderCancel ='0' AND ( ProductOrders.OrderStatus = '1' || ProductOrders.OrderStatus = '2' || ProductOrders.OrderStatus = '4')
                GROUP BY OrderId ORDER BY id DESC ";
        $query = $this->db->query($sql);
        $result='';
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            // foreach($result as $res){
            //     $list.="<option value='".$res['id']."'>".$res['OrderId']."</option>";
            // }
            return $result;
        } else {
            return $result;
        }

    }

    public function get_order_details_for_despatch(){
        $OrderId = $this->input->post('OrderId');
        $sql = "SELECT ProductOrders.id,ProductOrders.OrderId,ProductMaster.DesigneCode,ColourMaster.ColourName,SizeMaster.SizeCode,
        ProductOrders.OrderQuantity,ProductOrders.Price,ShopMaster.ShopName as FromName,UserMaster.FullName,
        ProductOrders.ColourId,ProductOrders.SizeId,ProductOrders.ProductUIC,ProductOrders.OrderType
            FROM ProductOrders 
            LEFT JOIN ProductOrdersSummary ON ProductOrdersSummary.OrderId=ProductOrders.OrderId 
            LEFT JOIN ProductMaster ON  ProductMaster.id=ProductOrders.ProductId  
            LEFT JOIN ColourMaster ON ColourMaster.id=ProductOrders.ColourId 
            LEFT JOIN SizeMaster ON SizeMaster.id=ProductOrders.SizeId 
            LEFT JOIN UserMaster ON UserMaster.id=ProductOrders.UserId 
            LEFT JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId
            WHERE ( ProductOrders.OrderStatus = '1' || ProductOrders.OrderStatus = '2' ||  ProductOrders.OrderStatus = '4')  
            AND ProductOrders.OrderCancel ='0' AND `ProductOrders`.`OrderId`= '".$OrderId."' 
            ORDER BY id DESC ";
        $query = $this->db->query($sql);
        $data='<tr><td colspan="10">This order id is not yet ready. </td></tr>';
        if ($query->num_rows() > 0) {
            $data="";
            $result = $query->result_array();
            $i=1;
            foreach($result as $res){
                
                $OrderType = ($res['OrderType']=='1')?'Ready Stock':'Pre Order';
                
                //<a href='javascript:;' onclick='showproductuicmodal(".$res['id'].")' ></a>
                /*
                  <input type='hidden' id='designecode".$res['id']."' value='".$res['DesigneCode']."'/>
                  <input type='hidden' id='colourid".$res['id']."' value='".$res['ColourId']."'/>
                  <input type='hidden' id='sizeid".$res['id']."' value='".$res['SizeId']."'/>
                  <input type='hidden' id='productuicvalue".$res['id']."'  name='productuicvalue".$res['id']."' value='".$res['ProductUIC']."'/>
                  <input type='hidden' id='id' value='".$res['id']."'/>
                */
            if($res['ProductUIC']!=''){
            $data.="<tr>
                      <td>".$i."<input type='checkbox' name='ProdDispatchOrderId[]' value='".$res['id']."'>
                      </td>
                      <td>".$res['OrderId']."</td>
                      <td>".$OrderType."</td>
                      <td>".$res['ProductUIC']."</td>
                      <td>".$res['FromName']."</td>
                      <td>".$res['FullName']."</td>
                      <td>".$res['DesigneCode']."</td>
                      <td>".$res['ColourName']."</td>
                      <td>".$res['SizeCode']."</td>
                      <td>".$res['OrderQuantity']."</td>
                      <td>".$res['Price']."</td>
                      <td>".$res['Price']*$res['OrderQuantity']."</td>
                    </tr>";
            $i++;
            } }
            return $data;
        } else {
            return $data;
        }

    }
    
    public function get_order_details_of_despatched(){
        $OrderId = $this->input->post('OrderId');
        $sql = "SELECT ProductOrders.id,ProductOrders.OrderId,ProductMaster.DesigneCode,ColourMaster.ColourName,SizeMaster.SizeCode,
        ProductOrders.OrderQuantity,ProductOrders.Price,ShopMaster.ShopName as FromName,UserMaster.FullName,
        ProductOrders.ColourId,ProductOrders.SizeId,ProductOrders.ProductUIC,ProductOrders.OrderType
            FROM ProductOrders 
            LEFT JOIN ProductOrdersSummary ON ProductOrdersSummary.OrderId=ProductOrders.OrderId 
            LEFT JOIN ProductMaster ON  ProductMaster.id=ProductOrders.ProductId  
            LEFT JOIN ColourMaster ON ColourMaster.id=ProductOrders.ColourId 
            LEFT JOIN SizeMaster ON SizeMaster.id=ProductOrders.SizeId 
            LEFT JOIN UserMaster ON UserMaster.id=ProductOrders.UserId 
            LEFT JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId
            WHERE ( ProductOrders.OrderStatus = '3')  
            AND ProductOrders.OrderCancel ='0' AND `ProductOrders`.`OrderId`= '".$OrderId."' 
            ORDER BY id DESC ";
        $query = $this->db->query($sql);
        $data='<tr><td colspan="10">No Product is dispatched for this order. </td></tr>';
        if ($query->num_rows() > 0) {
            $data="";
            $result = $query->result_array();
            $i=1;
            foreach($result as $res){
                
                $OrderType = ($res['OrderType']=='1')?'Ready Stock':'Pre Order';
                
                //<a href='javascript:;' onclick='showproductuicmodal(".$res['id'].")' ></a>
                /*
                  <input type='hidden' id='designecode".$res['id']."' value='".$res['DesigneCode']."'/>
                  <input type='hidden' id='colourid".$res['id']."' value='".$res['ColourId']."'/>
                  <input type='hidden' id='sizeid".$res['id']."' value='".$res['SizeId']."'/>
                  <input type='hidden' id='productuicvalue".$res['id']."'  name='productuicvalue".$res['id']."' value='".$res['ProductUIC']."'/>
                  <input type='hidden' id='id' value='".$res['id']."'/>
                */
            if($res['ProductUIC']!=''){
            $data.="<tr>
                      <td>".$i."</td>
                      <td>".$res['OrderId']."</td>
                      <td>".$OrderType."</td>
                      <td>".$res['ProductUIC']."</td>";
                    //  <td>".$res['FromName']."</td>
                    //  <td>".$res['FullName']."</td>
            $data.="  <td>".$res['DesigneCode']."</td>
                      <td>".$res['ColourName']."</td>
                      <td>".$res['SizeCode']."</td>
                      <td>".$res['OrderQuantity']."</td>";
                      //<td>".$res['Price']."</td>
                      //<td>".$res['Price']*$res['OrderQuantity']."</td>
            $data.="</tr>";
            $i++;
            } }
            return $data;
        } else {
            return $data;
        }

    }
    
    public function get_order_details_of_processing(){
        $OrderId = $this->input->post('OrderId');
        $sql = "SELECT ProductOrders.id,ProductOrders.OrderId,ProductMaster.DesigneCode,ColourMaster.ColourName,SizeMaster.SizeCode,
        ProductOrders.OrderQuantity,ProductOrders.Price,ShopMaster.ShopName as FromName,UserMaster.FullName,
        ProductOrders.ColourId,ProductOrders.SizeId,ProductOrders.ProductUIC,ProductOrders.OrderType
            FROM ProductOrders 
            LEFT JOIN ProductOrdersSummary ON ProductOrdersSummary.OrderId=ProductOrders.OrderId 
            LEFT JOIN ProductMaster ON  ProductMaster.id=ProductOrders.ProductId  
            LEFT JOIN ColourMaster ON ColourMaster.id=ProductOrders.ColourId 
            LEFT JOIN SizeMaster ON SizeMaster.id=ProductOrders.SizeId 
            LEFT JOIN UserMaster ON UserMaster.id=ProductOrders.UserId 
            LEFT JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId
            WHERE ( ProductOrders.OrderStatus = '1')  
            AND ProductOrders.OrderCancel ='0' AND `ProductOrders`.`OrderId`= '".$OrderId."' 
            ORDER BY id DESC ";
        $query = $this->db->query($sql);
        $data='<tr><td colspan="10">No Product in processing for this order. </td></tr>';
        if ($query->num_rows() > 0) {
            $data="";
            $result = $query->result_array();
            $i=1;
            foreach($result as $res){
                
                $OrderType = ($res['OrderType']=='1')?'Ready Stock':'Pre Order';
                
                //<a href='javascript:;' onclick='showproductuicmodal(".$res['id'].")' ></a>
                /*
                  <input type='hidden' id='designecode".$res['id']."' value='".$res['DesigneCode']."'/>
                  <input type='hidden' id='colourid".$res['id']."' value='".$res['ColourId']."'/>
                  <input type='hidden' id='sizeid".$res['id']."' value='".$res['SizeId']."'/>
                  <input type='hidden' id='productuicvalue".$res['id']."'  name='productuicvalue".$res['id']."' value='".$res['ProductUIC']."'/>
                  <input type='hidden' id='id' value='".$res['id']."'/>
                */
            if($res['ProductUIC']!=''){
            $data.="<tr>
                      <td>".$i."</td>
                      <td>".$res['OrderId']."</td>
                      <td>".$OrderType."</td>
                      <td>".$res['ProductUIC']."</td>";
                    //  <td>".$res['FromName']."</td>
                    //  <td>".$res['FullName']."</td>
            $data.="  <td>".$res['DesigneCode']."</td>
                      <td>".$res['ColourName']."</td>
                      <td>".$res['SizeCode']."</td>
                      <td>".$res['OrderQuantity']."</td>";
                      //<td>".$res['Price']."</td>
                      //<td>".$res['Price']*$res['OrderQuantity']."</td>
            $data.="</tr>";
            $i++;
            } }
            return $data;
        } else {
            return $data;
        }

    }
    
    
    
    public function get_produic_to_productorders(){
        $ProductOrdersId = $this->input->post('ProductOrdersId');
        $ProductUIC = $this->input->post('ProductUIC');
        $ProductUICs = join(',',$ProductUIC);
        $this->db->query("UPDATE ProductOrders SET `ProductUIC`= '$ProductUICs',`OrderStatus`='2' WHERE `id`='$ProductOrdersId'");
        return true;
    }

    public function orders_dispatch_save(){
        //"{"ProdDispatchOrderId":["74","73"],"productuicvalue":["220918002,220918003",""],"BillDate":"","BillNo":"","BillAmount":""}"
        
        $InvoiceDate = $this->input->post('InvoiceDate');
        $InvoiceDate = date('Y-m-d H:i:s',strtotime($InvoiceDate));
        $InvoiceNumber = $this->input->post('InvoiceNumber');
        $OrderId = $this->input->post('OrderId');
        $UserId = $this->input->post('UserId');
        $TotalAmount = $this->input->post('TotalAmount');
        $CreatedBy = 1;
        $CreatedDateTime = date('Y-m-d H:i:s');
        $ActualOrderQuantity = $this->input->post('ActualOrderQuantity');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $Amount = $this->input->post('Amount');
        $ProductId = $this->input->post('ProductId');
        $DesigneCode = $this->input->post('DesigneCode');
        $Price = $this->input->post('Price');
        $ColourId = $this->input->post('ColourId');
        $SizeId = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $ProductUIC = $this->input->post('ProductUIC');
        $OrderTblId = $this->input->post('OrderTblId');
        $dispatch_productUIC = $this->input->post('dispatch_productUIC');
        $prodUIC_arr = array();
        $partially = 0;
        
        $DispatchSummary_arr = array('OrderId'=>$OrderId, 'Amount'=>$TotalAmount, 'UserId'=>$UserId, 'InvoiceDate'=>$InvoiceDate, 'InvoiceNumber'=>$InvoiceNumber, 'CreatedBy'=>$CreatedBy, 'CreatedDateTime'=>$CreatedDateTime);
        $this->db->insert('DispatchSummary',$DispatchSummary_arr);
        //$dsum = $this->db->last_query();
        $DispatchId = $this->db->insert_id();
        $email_details = array();
        foreach($ProductId as $key => $val){
            $ProductUIC[$key] = join(',',$dispatch_productUIC[$key]); 
            $DispatchHistory_arr[] = array('DispatchId'=>$DispatchId,'OrderId'=>$OrderId, 'ProductId'=>$ProductId[$key], 'ProductUIC'=>$ProductUIC[$key], 'ProductQty'=>$OrderQuantity[$key], 'Price'=>$Price[$key], 'OrderType'=>$OrderType[$key], 'DesigneCode'=>$DesigneCode[$key], 'ColourId'=>$ColourId[$key], 'SizeId'=>$SizeId[$key]);
            $prodUIC_arr[] = $ProductUIC[$key];
            
            $ProductName = $this->db->query("SELECT ProductName FROM `ProductMaster` WHERE id='".$ProductId[$key]."'")->row();
            $ColourName = $this->db->query("SELECT ColourName FROM `ColourMaster` WHERE id='".$ColourId[$key]."'")->row();
            $SizeName = $this->db->query("SELECT SizeName FROM `SizeMaster` WHERE id='".$SizeId[$key]."'")->row();
            $email_details[] = array('DispatchId'=>$DispatchId,'OrderId'=>$OrderId, 'ProductName'=>$ProductName->ProductName, 'ProductUIC'=>$ProductUIC[$key], 'ProductQty'=>$OrderQuantity[$key], 'Price'=>$Price[$key], 'OrderType'=>$_SERVER['ORDERTYPE'][$OrderType[$key]], 'DesigneCode'=>$DesigneCode[$key], 'ColourName'=>$ColourName->ColourName, 'SizeName'=>$SizeName->SizeName);
            
            
        }
        $this->db->insert_batch('DispatchHistory',$DispatchHistory_arr);
        //$dhis = $this->db->last_query();
        
        foreach($ProductId as $key => $val){
            if($ActualOrderQuantity[$key]==$OrderQuantity[$key]){
                $Ostatus = '3'; // full dispatched
            }else{
                $Ostatus = '4'; // partial dispatched
                $partially = 1;
            }
            $update_arr[] = array('id'=>$OrderTblId[$key],'DispatchQty'=> `DispatchQty` + $OrderQuantity[$key],'OrderStatus'=>$Ostatus);
        }
        $this->db->update_batch('ProductOrders',$update_arr,'id');
        
        if($partially==1){
            $this->db->where('OrderId',$OrderId);
            $this->db->update('ProductOrdersSummary',array('OrderStatus'=>'4'));
        }else{

            $q = $this->db->query("SELECT id FROM `ProductOrders` WHERE OrderId='".$OrderId."' GROUP by OrderStatus");
            if($q->num_rows() > 0) {
                $this->db->where('OrderId',$OrderId);
                $this->db->update('ProductOrdersSummary',array('OrderStatus'=>'4'));
            }else{
                $this->db->where('OrderId',$OrderId);
                $this->db->update('ProductOrdersSummary',array('OrderStatus'=>'3'));
            }
        }
        
        $prodUIC = join(',',$prodUIC_arr);
        $update_prod_stock  = $this->db->query("UPDATE ProductStock SET ProductStatus='3' WHERE ProductUIC IN(".$prodUIC.")");
        
        $table="<table width='100%' border='1' cellpadding='6' cellspacing='0'><tr><th>Order Id</th><th>Dispatch Id</th><th>Product Name</th><th>Design Code</th><th>Colour</th><th>Size</th><th>Quantity</th><th>Price</th><th>Amount</th></tr>";
        foreach($email_details as $e){
            $table.="<tr><td>".$e['OrderId']."</td><td>".$e['DispatchId']."</td><td>".$e['ProductName']."</td><td>".$e['DesigneCode']."</td><td>".$e['ColourName']."</td><td>".$e['SizeName']."</td><td>".$e['ProductQty']."</td><td>".$e['Price']."</td><td>".($e['ProductQty']*$e['Price'])."</td></tr>";
        }
        $table.="</table>";
        $user_details = $this->user_model->get_user_details_by_id($UserId);
        send_mail_simple($user_details['EmailId'],'admin@melhortechnologies.com','Sunflower- Order Dispatched - '.$OrderId.'.','Dear Customer,<br> Your order with OrderId -<b>'.$OrderId.'</b> has been dispatched successfully.<br><br>'.$table.' <br>Thanks,<br> Sunflower');
        // email part ends
                    
        
        //return json_encode(array('dsum'=>$dsum,'dhis'=>$dhis,'dupd'=>$dupd));
        return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        
    }



    public function order_place_now(){

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        
        $OrderDate = date('Y-m-d');
        $ProductId = $this->input->post('ProductId');
        $MrpRate = $this->input->post('ProductMRP');
        $PurchaseRate = $this->input->post('PurchaseRate');
        $quantity = $this->input->post('ApprovedQuantity');
        $OrderAmount = $this->input->post('OrderAmount');

        $totalamount = $this->input->post('OrderTotalAmount');

        
        $datetime = date('Y-m-d H:i:s');
        
        // $sql = "SELECT id FROM orders_master WHERE `ProductCode` = '$ProductCode'  AND ProductName='$ProductName' "; //" AND `bActive`='0' 
        // $query = $this->db->query($sql);
        // if ($query) {
        //     if ($query->num_rows() > 0) {
        //         return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
        //     } 
        // }

        if($UserRole== 'retailer'){
            $RetailerId = $_SESSION['user_id'];
            $StockistId = $_SESSION['StockistId'];

             $data_array = array('OrderDate'=> $OrderDate,
                                'RetailerId' => $RetailerId,
                                'StockistId'=> $StockistId,
                                'OrderTotalAmount'=> $totalamount,
                                'OrderStatus'=>'0',
                                'CreatedDateTime'=> $datetime);
            $insert = $this->db->insert('orders_master_retailer', $data_array);
            $insert_id = $this->db->insert_id();

                foreach ($quantity as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    

                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'RetailerId' =>$RetailerId,
                        'StockistId'=>$StockistId,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$MrpRate[$key],
                        'ProductPurchaseRate'=>$PurchaseRate[$key],
                        'OrderQuantity'=>$qty,
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_retailer', $data_details_array);

                

        }
        
        if($UserRole== 'stockist'){
            $StockistId = $_SESSION['user_id'];
            $CompanyId = '0';//$_SESSION['DistributorId'];

             $data_array = array('OrderDate'=>$OrderDate,
                                'StockistId'=>$StockistId,
                                'CompanyId'=>$CompanyId,
                                'OrderTotalAmount'=>$totalamount,
                                'OrderStatus'=>'0',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_stockist', $data_array);
            $insert_id = $this->db->insert_id();

                foreach ($quantity as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }

                    $orderbookedproductid[] = array(
                                            'ProductId'=>$ProductId[$key],
                                            'OrderBookedStatus'=>'1'    
                                            ); 
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'StockistId' =>$StockistId,
                        'CompanyId'=>$CompanyId,
                        'ProductId'=>$ProductId[$key],
                        'ProductMRP'=>$MrpRate[$key],
                        'ProductPurchaseRate'=>$PurchaseRate[$key],
                        'OrderQuantity'=>$qty,
                        'OrderBookedStatus'=>'0',
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_stockist', $data_details_array);

                $this->db->where('StockistId',$StockistId);
                $this->db->update_batch('orders_details_retailer',$orderbookedproductid,'ProductId');
        }
        
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add orders id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            $this->send_order_on_mail($insert_id,$data_array,$data_details_array);

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'orderid'=>$insert_id,'OrderSubmitUserType'=>$UserRole));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


     public function get_orders_received_list(){
     
    
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $data['orderstatus']=0;

        if($UserRole== 'stockist'){

            $sql = "SELECT 
            orders_master_retailer.*,
            retailer_master.RetailerName as FromName,
            stockist_master.StockistName as ToName, 
            date_format(orders_master_retailer.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM orders_master_retailer 
            INNER JOIN retailer_master ON orders_master_retailer.RetailerId=retailer_master.id 
            INNER JOIN stockist_master ON orders_master_retailer.StockistId=stockist_master.id 
            WHERE `orders_master_retailer`.`StockistId`='".$UserId."' ORDER BY id DESC";

        }

        
        if($UserRole== 'admin'){


            $sql = "SELECT 
            orders_master_stockist.*,
            stockist_master.StockistName as FromName,
            'Company' as ToName, 
            date_format(orders_master_stockist.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
            FROM orders_master_stockist 
            INNER JOIN stockist_master ON orders_master_stockist.StockistId=stockist_master.id 
            WHERE `orders_master_stockist`.`CompanyId`='0' ORDER BY id DESC";


        }


        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;
		$orderstatus = 0;
                    foreach ($datas as $key => $value) {
                    $id=$value['id'];
                  if($value['OrderPlacedBy']==1)
                  {
                  $color="style=background-color:#edc9c8";
                  }
                  else{
                  $color='';}
                        $result.='<tr '.$color.'  id="row'.$value['id'].'">';
						
						if($value['OrderStatus']==0){
							$orderstatus = $_SERVER['ORDER_STATUS'][$value['OrderStatus']];;
				$result.='<td>'.$i.'. <a class="btn btn-xs btn-info" href="" title="Details" data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsReceiver('.$value['id'].','.$value['OrderStatus'].')"><i class="fa fa-pencil" aria-hidden="true"></i></a>  ';
						}
                    else if($value['OrderStatus']>'0' && $value['OrderStatus'] < '4')
			{
				
				$orderstatus = '<input type="button" value="Confirm" class="btn btn-primary" onclick="order_confirm('.$id.')">';
				$result.='<td>'.$i.'. <a class="btn btn-xs btn-info" href="" title="Details" data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsReceiver('.$value['id'].','.$value['OrderStatus'].')"><i class="fa fa-pencil" aria-hidden="true"></i></a>  <div class="checkbox checkbox-primary ">
                                <input type="checkbox" class="form-control approveorder" name="OrderId" value="'.$value['id'].'">
                                <label for="checkbox2"></label>
                            </div>';
				
				  
			}
			else
			{
				$orderstatus = $_SERVER['ORDER_STATUS'][$value['OrderStatus']];
				
				$result.='<td>'.$i.'. <a class="btn btn-xs btn-success" href="" title="Details" data-toggle="modal" data-target="#OrderDetailsModal" onclick="ShowOrderDetailsReceiver('.$value['id'].','.$value['OrderStatus'].')"><i class="fa fa-table" aria-hidden="true"></i></a> <a href="'.site_url("orders/invoice/?billid=".$value['id']).'" class="btn btn-xs btn-warning pull-right"  id="invoice" name="invoice" ><i class="fa fa-print" aria-hidden="true"></i></a>';
			}
                      
                            
                        $result.='
                            

                            </td>

                        <td>'.$value['id'].'</td>
                        <td>'.$value['FromName'].'</td>
                        <td>'.$value['ToName'].'</td>
                        <td>'.$value['OrderTotalAmount'].' ( '.$value['OrderApprovedAmount'].' )'.'</td>
                        <td>'.$orderstatus.'</td>
                        <td>';
                        
                        if($value['OrderStatus']=='4'){
                        $result.='<input type="button" class="btn btn-xs btn-primary" id="Dispach" name="Dispach" value="Dispach" onclick="order_dispach('.$value['id'].')"/>';
                        }
                        $result.='</td>
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


    public function get_orders_details_by_orderid_for_sender($OrderId){

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        if($UserRole== 'retailer'){
            $sql = "SELECT *,orders_details_retailer.id as orderdetailsid,product_master_new.id as productmasterid 
                    FROM orders_details_retailer 
                    INNER JOIN product_master_new ON orders_details_retailer.ProductId=product_master_new.id 
                    WHERE orders_details_retailer.OrderId='".$OrderId."' ";
        }
        
        if($UserRole== 'stockist'){
            $sql = "SELECT *,orders_details_stockist.id as orderdetailsid,product_master_new.id as productmasterid 
                    FROM orders_details_stockist 
                    INNER JOIN product_master_new ON orders_details_stockist.ProductId=product_master_new.id 
                    WHERE orders_details_stockist.OrderId='".$OrderId."' ";
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


    public function get_orders_details_by_orderid_for_receiver($OrderId){

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        // if($UserRole== 'retailer'){
        //     $sql = "SELECT *,orders_details_retailer.id as orderdetailsid,product_master.id as productmasterid FROM orders_details_retailer INNER JOIN product_master ON orders_details_retailer.ProductId=product_master.id WHERE orders_details_retailer.OrderId='".$OrderId."' ";
        // }
        
        if($UserRole == 'stockist'){
            $sql = "SELECT *,orders_details_retailer.id as orderdetailsid,product_master_new.id as productmasterid FROM orders_details_retailer INNER JOIN product_master_new ON orders_details_retailer.ProductId=product_master_new.id WHERE orders_details_retailer.OrderId='".$OrderId."' ";
            // $sql = "SELECT *,orders_details_stockist.id as orderdetailsid,product_master.id as productmasterid FROM orders_details_stockist INNER JOIN product_master ON orders_details_stockist.ProductId=product_master.id WHERE orders_details_stockist.OrderId='".$OrderId."' ";
            $UserRoleId = '2';
        }

        if($UserRole == 'admin'){
            $sql = "SELECT *,orders_details_stockist.id as orderdetailsid,product_master_new.id as productmasterid FROM orders_details_stockist INNER JOIN product_master_new ON orders_details_stockist.ProductId=product_master_new.id WHERE orders_details_stockist.OrderId='".$OrderId."' ";
            $UserRoleId = '0';
        }


        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();

                foreach ($result as $key => $res) {
                    $details = $this->get_product_stock_by_productid($res['ProductId'],$UserId,$UserRoleId);
                    $result[$key]['ProductStock'] =  $details['ProductQuantity'];
                    $result[$key]['ProductMinStockLevel'] = ''; //$details['ProductMinStockLevel'];
                }

                return $result;
            } else {
                return false;
            }
        }
    }


    public function get_product_stock_by_productid($ProductId,$UserId,$UserRoleId){
        $sql = "SELECT SUM(ProductQuantity) as ProductQuantity  FROM product_stock_master WHERE ProductId='".$ProductId."' AND UserId='".$UserId."' AND UserRoleId='".$UserRoleId."' GROUP BY ProductId LIMIT 0,1 "; 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0];
            } 
        }
    }


   public function orders_update() {
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


    public function orders_delete(){
        $id = $this->input->post('id');
        if($_SESSION['user_role']=='retailer'){
            $sql = "DELETE FROM orders_master_retailer WHERE id = '$id'";
        }
        if($_SESSION['user_role']=='stockist'){
            $sql = "DELETE FROM orders_master_stockist WHERE id = '$id'";
        }
        
        $query = $this->db->query($sql);

        if($query){
            if($_SESSION['user_role']=='retailer'){
                $orders_details_sql = "DELETE FROM orders_details_retailer WHERE OrderId = '$id'";
            }
            if($_SESSION['user_role']=='stockist'){
                $orders_details_sql = "DELETE FROM orders_details_stockist WHERE OrderId = '$id'";
            }    
            
            $query = $this->db->query($orders_details_sql);
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function orders_print(){
        $data = array();
        $OrderId = $this->input->get('OrderId');

        if($_SESSION['user_role']=='retailer'){

            $sql = "SELECT * FROM orders_master_retailer WHERE id='".$OrderId."' ";
            $query = $this->db->query($sql);
            $result = $query->result_array(); 
            $data['summary'] = $query->result_array(); 
            $data['details'] = $this->get_orders_details_by_orderid_for_sender($result[0]['id']);

            $data['User'] = $this->retailer_model->get_retailer_details_by_id($result[0]['RetailerId']);
            $data['OrderSubmitedfor'] = $this->stockist_model->get_stockist_details_by_id($result[0]['StockistId']);
        }
        if($_SESSION['user_role']=='stockist'){

            $sql = "SELECT * FROM orders_master_stockist WHERE id='".$OrderId."' ";
            $query = $this->db->query($sql);
            $result = $query->result_array(); 
            $data['summary'] = $query->result_array(); 
            $data['details'] = $this->get_orders_details_by_orderid_for_sender($result[0]['id']);

             $data['User'] = $this->stockist_model->get_stockist_details_by_id($result[0]['StockistId']);
             $data['OrderSubmitedfor'] = COMPANYNAME; //$this->distributor_model->get_distributor_details_by_id($result[0]['DistributorId']);
        }

        return $data;

    }

    public function get_orders_sender_details_by_orderid($OrderId){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        if($UserRole== 'retailer'){
            $sql = "SELECT retailer_master.RetailerName as SenderName,stockist_master.StockistName as ReceiverName, date_format(OrderDate,'%d-%m-%Y') as OrderDate FROM orders_master_retailer INNER JOIN retailer_master ON retailer_master.id=orders_master_retailer.RetailerId INNER JOIN stockist_master ON stockist_master.id=orders_master_retailer.StockistId WHERE orders_master_retailer.id='$OrderId' limit 0,1 ";
        }
        
        if($UserRole== 'stockist'){
            $sql = "SELECT stockist_master.StockistName as SenderName,'".COMPANYNAME."' as ReceiverName, date_format(OrderDate,'%d-%m-%Y') as OrderDate FROM orders_master_stockist INNER JOIN stockist_master ON stockist_master.id=orders_master_stockist.StockistId WHERE orders_master_stockist.id='$OrderId'  limit 0,1";
        }

        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];

    }


    public function get_orders_receiver_details_by_orderid($OrderId){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        
        if($UserRole== 'stockist'){
            $sql = "SELECT orders_master_retailer.*,retailer_master.RetailerName as SenderName,stockist_master.StockistName as ReceiverName, date_format(OrderDate,'%d-%m-%Y') as OrderDate FROM orders_master_retailer INNER JOIN retailer_master ON retailer_master.id=orders_master_retailer.RetailerId INNER JOIN stockist_master ON stockist_master.id=orders_master_retailer.StockistId WHERE orders_master_retailer.id='$OrderId' limit 0,1 ";
        }

        if($UserRole== 'admin'){
            $sql = "SELECT orders_master_stockist.*,stockist_master.StockistName as SenderName,'Company' as ReceiverName, date_format(OrderDate,'%d-%m-%Y') as OrderDate FROM orders_master_stockist INNER JOIN stockist_master ON stockist_master.id=orders_master_stockist.StockistId WHERE orders_master_stockist.id='$OrderId'  limit 0,1";
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0];

    }
    
    public function order_status_save()
    {

        //pre($_POST);exit;

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
	$GstValue= $this->input->post('GstValue');
        $GstActual= $this->input->post('GstActual');
        $Taxable= $this->input->post('Taxable');
        $approvedquantity = $this->input->post('approvedquantity');
        $approverejectreason = $this->input->post('approverejectreason');
        $OrderStatus = $this->input->post('status');
        $orderdetailsid = $this->input->post('orderdetailsid');
        $orderid = $this->input->post('OrderId');
        $OrderApprovedAmount = $this->input->post('OrderApprovedAmount');
        $datetime = date('Y-m-d H:i:s');
        
        if($UserRole== 'stockist'){
            $order_master_table = 'orders_master_retailer';
            $order_details_table = 'orders_details_retailer';

        }

        if($UserRole== 'admin'){
            $order_master_table = 'orders_master_stockist';
            $order_details_table = 'orders_details_stockist';
        }

        $i=0;
        $j=0;
        foreach ($orderdetailsid as $key => $id) {
            if($OrderStatus[$key]=='1'){ $i+=1; }
            if($OrderStatus[$key]=='2'){ $j+=1; }

                $update_data_array[] = array(
                    'id'=>$id,
		    'GstValue'=>$GstValue[$key],
		    'GstActual'=>$GstActual[$key],
		    'Taxable'=>$Taxable[$key],
                    'ApprovedQuantity'=>$approvedquantity[$key],
                    'ApproveRejectRemarks'=>$approverejectreason[$key],
                    'OrderStatus'=>$OrderStatus[$key],
                    'OrderStatusChngDateTime'=>$datetime
                    );
        }

        $this->db->update_batch($order_details_table,$update_data_array,'id');
        //$dsql = $this->db->last_query();
        $afftectedRows = $this->db->affected_rows();



        if($i>0 && $j==0){ $FinalOrderStatus = 1; }
        if($i==0 && $j>0){ $FinalOrderStatus = 2; }
        if($i>0 && $j>0){ $FinalOrderStatus = 3; }

        $update_order_master_array= array(
            'OrderStatus'=>$FinalOrderStatus,
            'OrderApprovedAmount'=>$OrderApprovedAmount,
            'OrderStatusChngDateTime'=>$datetime);
        $this->db->where('id',$orderid);
        $this->db->update($order_master_table,$update_order_master_array);
        //$msql = $this->db->last_query();
        $afftectedRows = $this->db->affected_rows();
        //$q=$this->db->last_query();

        if ($afftectedRows>0) {
            /*             * *Activity Logs** */
            //$msg = " Approved/Reject stock id = $insert_id";
            //save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function approve_selected_order_all_products(){

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $orderids = $this->input->post('orderids');
        $orderids = join(',', $orderids);

        $datetime = date('Y-m-d H:i:s');

        if($UserRole== 'stockist'){

            $sql_master="UPDATE `orders_master_retailer` 
                SET `OrderStatus` = '1', 
                    `OrderStatusChngDateTime` = '".$datetime."', 
                    `OrderApprovedAmount`= `OrderTotalAmount` 
                WHERE `id` IN('".$orderids."')";

            $query = $this->db->query($sql_master);

            $sql_details="UPDATE `orders_details_retailer` 
                SET `OrderStatus` = '1', 
                    `OrderStatusChngDateTime` = '".$datetime."', 
                    `ApprovedQuantity`= `OrderQuantity` ,
                    `ApproveRejectRemarks`=''
                WHERE `OrderId` IN('".$orderids."')";

            $query = $this->db->query($sql_details);
            $afftectedRows = $this->db->affected_rows();

        }

        if($UserRole== 'admin'){
            $sql_master="UPDATE `orders_master_stockist` 
                SET `OrderStatus` = '1', 
                    `OrderStatusChngDateTime` = '".$datetime."', 
                    `OrderApprovedAmount`= `OrderTotalAmount` 
                WHERE `id` IN('".$orderids."')";

            $query = $this->db->query($sql_master);

            $sql_details="UPDATE `orders_details_stockist` 
                SET `OrderStatus` = '1', 
                    `OrderStatusChngDateTime` = '".$datetime."', 
                    `ApprovedQuantity`= `OrderQuantity` ,
                    `ApproveRejectRemarks`=''
                WHERE `OrderId` IN('".$orderids."')";

            $query = $this->db->query($sql_details);
            $afftectedRows = $this->db->affected_rows();
        }

        if ($afftectedRows>0) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }

    }
    
    
    public function order_confirm()
    {    
     	$UserId = $_SESSION['user_id'];
     	$UserRole = $_SESSION['user_role'];
 	$orderid = $this->input->post('orderid');
	if($UserRole== 'stockist')
	{
            $order_master_table = 'orders_master_retailer';
            $order_details_table = 'orders_details_retailer';
        }

        if($UserRole== 'admin')
        {
            $order_master_table = 'orders_master_stockist';
            $order_details_table = 'orders_details_stockist';
        }
        
        $update_order_master_array= array(
            'OrderStatus'=>4);
        $this->db->where('id',$orderid);
        $this->db->update($order_master_table,$update_order_master_array);
    	 $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows>0) {
            /*             * *Activity Logs** */
            //$msg = " Approved/Reject stock id = $insert_id";
            //save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    
   public function get_order_master_by_orderid($orderid)
   {
   	$UserId = $_SESSION['user_id'];
     	$UserRole = $_SESSION['user_role'];
   	
   	
   	if($UserRole== 'admin')
        {
            $order_master_table = 'orders_master_stockist';
            
        }  	

   	if($UserRole== 'stockist' )
	{
            $order_master_table = 'orders_master_retailer';
           
        }   	
   	
   	if( $UserRole== 'retailer' )
	{
            $order_master_table = 'orders_master_retailer';
           
        }

        
        
        $this->db->from($order_master_table);
        $this->db->where('id',$orderid);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result();
        }
        else
        {
        	return false;
        }
        
   }
   
   
    public function get_stockist_data($id)
   {
   	$this->db->select('StockistName as Name,StockistContactNo as Contact,StockistEmail as Email,Address,DLNo,FassaiCode,PanNo,GSTNo');
        $this->db->from('stockist_master');
        $this->db->where('id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return $false();
        }
        
   }
   
   public function get_retailer_data($id)
   {
   	$this->db->select('RetailerName as Name,RetailerContactNo as Contact,RetailerEmail as Email,Address,DLNo,FassaiCode,PanNo,GSTNo');
        $this->db->from('retailer_master');
        $this->db->where('id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return $false();
        }
   }
   
   
   public function get_order_details_by_orderid($orderid)
   {
   	$UserId = $_SESSION['user_id'];
     	$UserRole = $_SESSION['user_role'];
   	if($UserRole== 'stockist')
	{
            $order_details_table = 'orders_details_retailer';
           
        }
        
        if($UserRole== 'retailer')
	{
            $order_details_table = 'orders_details_retailer';
           
        }
        
         if($UserRole== 'admin')
	{
            $order_details_table = 'orders_details_stockist';
           
        }
        
        
        $this->db->from($order_details_table);
        $this->db->where('OrderId',$orderid);
        $this->db->join('product_master_new',"$order_details_table.ProductId=product_master_new.id");
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return false;
        }
   }
   
   public function get_stockist_order_master_by_orderid($orderid)
   {
   	$UserId = $_SESSION['user_id'];
     	$UserRole = $_SESSION['user_role'];
   	if($UserRole== 'stockist' )
	{
            $order_master_table = 'orders_master_stockist';           
        }   	   	
   	
        $this->db->from($order_master_table);
        $this->db->where('id',$orderid);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result();
        }
        else
        {
        	return false;
        }
        
   }
   
   
   public function get_stockist_order_details_by_orderid($orderid)
   {
   	$UserId = $_SESSION['user_id'];
     	$UserRole = $_SESSION['user_role'];
   	if($UserRole== 'stockist')
	{
            $order_details_table = 'orders_details_stockist';
           
        }
        
        $this->db->from($order_details_table);
        $this->db->where('OrderId',$orderid);
        $this->db->join('product_master_new',"$order_details_table.ProductId=product_master_new.id");
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return false;
        }
   }
   
    public function get_company_data($id)
   {
   	$this->db->select('CompanyName as Name,CompanyContactNo as Contact,CompanyEmail as Email,Address,DLNo,FassaiCode,PanNo,GSTNo');
        $this->db->from('company_master');
        $this->db->where('id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return false;
        }
        
   }
   
   
   public function get_product_info_by_id($id)
   {
   	$this->db->select('product_master_new.*,gst_master.GstValue,gst_master.GstApply');
   	$this->db->from('product_master_new');
   	$this->db->where('product_master_new.id',$id);
   	$this->db->join('gst_master','gst_master.GstValue=product_master_new.SalesGST','left');
   	$query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->row();
        }
        else
        {
        	return false;
        }
   
   }
   
   
   

   public function set_orders_status_to_dispatch()
   {
   	$UserRole = $_SESSION['user_role'];
	$OrderId = $this->input->post('OrderId');	
	$TransporterId= $this->input->post('TransporterId');
	$TransporterBiltyNo = $this->input->post('TransporterBiltyNo');
	$TransportRemarks = $this->input->post('TransportRemarks');
	$update_master_array = array('OrderStatus'=>'5','TransporterId'=>$TransporterId, 'TransporterBiltyNo'=>$TransporterBiltyNo,'TransportRemarks'=>$TransportRemarks);
	
	$update_details_array = array('OrderStatus'=>'5');
	
   	if($UserRole== 'stockist')
	{
            $order_details_table = 'orders_details_retailer';
            $order_master_table = 'orders_master_retailer';           
        }
       
         if($UserRole== 'admin')
	{
            $order_details_table = 'orders_details_stockist';
            $order_master_table = 'orders_master_stockist';           
        }
        
        $this->db->where('id',$OrderId );
        $this->db->update($order_master_table ,$update_master_array);
        
        
        $this->db->where('OrderId',$OrderId );
        $this->db->update($order_details_table,$update_details_array);
        
        //$dsql = $this->db->last_query();
        
        $afftectedRows = $this->db->affected_rows();
        
        
            if ($afftectedRows>0) {
            /*             * *Activity Logs** */
            $msg = " Order Dispatch Order Id = $OrderId";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }

   }   
   
	public function get_orders_dispatched_recieve_list(){
		$UserId = $_SESSION['user_id'];
        	$UserRole = $_SESSION['user_role'];
		    $OrderId = $this->input->post('OrderId');	
	        $StateId = $this->input->post('StateId');
	        
	        
   	if($UserRole== 'stockist')
	{
            $order_details_table = 'orders_details_stockist';
            $order_master_table = 'orders_master_stockist';           
        }
       
         if($UserRole== 'retailer')
	{
	    $order_details_table = 'orders_details_retailer';
            $order_master_table = 'orders_master_retailer'; 
          
        }
        $result = array();
	        
        $sql_master = "SELECT * FROM $order_master_table WHERE id='$OrderId' ";
        $query = $this->db->query($sql_master);
        $result_master = $query->result_array();
        $result['master'] = $result_master;
        
        $sql_details = "SELECT $order_details_table.*,product_master_new.ProductName 
        FROM $order_details_table 
        INNER JOIN product_master_new ON product_master_new.id=$order_details_table.ProductId 
        WHERE $order_details_table.OrderId='$OrderId' AND $order_details_table.OrderStatus='5' ";
        $query = $this->db->query($sql_details);
        $result_details = $query->result_array();
        $result['details'] = $result_details;
        
        if (count($result_master)>0) {
            return json_encode(Array("status" => "1", 'data'=>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
}


    public function save_order_to_stock() {
    
//    return json_encode($_POST);
    
    $UserId = $_SESSION['user_id'];
    $UserRoleId = $_SESSION['user_roleid'];
    $UserRole = $_SESSION['user_role'];
    
    $receivedquantity = $this->input->post('receivedquantity'); 
    $receivedremarks = $this->input->post('receivedremarks'); 
    $ProductId = $this->input->post('ProductId'); 
    $Batch = $this->input->post('Batch'); 
    $Expiry = $this->input->post('Expiry'); 
    $MfgDate = $this->input->post('MfgDate'); 
    $ProductMRP = $this->input->post('ProductMRP'); 
    $ProductPurchaseRate = $this->input->post('ProductPurchaseRate'); 
    $OrderId = $this->input->post('OrderId'); 
    $datetime = date('Y-m-d H:i:s');
       $ParentId='';
       $ParentRoleId='';
        if($UserRole== 'stockist')
	{
	$ParentId=1;
	$ParentRoleId=0;
            $order_details_table = 'orders_details_stockist';
            $order_master_table = 'orders_master_stockist';           
        }
       
         if($UserRole== 'retailer')
	{
	     $ParentId=$this->get_stockistId_by_orderid($OrderId[0]);
	     $ParentId=$ParentId;
	     $ParentRoleId=2;
	    $order_details_table = 'orders_details_retailer';
            $order_master_table = 'orders_master_retailer';           
        }
        
        foreach($receivedquantity as $key=>$value){
        
        
        $sql_diprice = "SELECT DiPrice FROM product_stock_master WHERE `ProductId` = '".$ProductId[$key]."' AND `Batch`='".$Batch[$key]."'";
        $query_diprice = $this->db->query($sql_diprice);
        $res_diprice = $query_diprice->result_array();
        $result=array();
        
        $stockorderid = $OrderId[$key];
        	$data_array[] = array(
        		'UserId'=>$ParentId,
        		'UserRoleId'=>$ParentRoleId,
        		'ProductId'=>$ProductId[$key],
        		'ProductQuantity'=>-$receivedquantity[$key],
        		'MRP'=>$ProductMRP[$key],
        		'PurchasePrice'=>$ProductPurchaseRate[$key],
        		'Batch'=>$Batch[$key],
        		'Expiry'=>$Expiry[$key],
        		'MfgDate'=>$MfgDate[$key],
        		 'DiPrice'=>$res_diprice[0]['DiPrice'],
        		'ReceivedRemarks'=>$receivedremarks[$key],
        		'CreatedDateTime'=>$datetime,
        		'RefferenceOrderNo'=>$OrderId[$key]
        	);
        	
        	$data_myarray[] = array(
        		'UserId'=>$UserId,
        		'UserRoleId'=>$UserRoleId,
        		'ProductId'=>$ProductId[$key],
        		'ProductQuantity'=>$receivedquantity[$key],
        		'MRP'=>$ProductMRP[$key],
        		'PurchasePrice'=>$ProductPurchaseRate[$key],
        		 'DiPrice'=>$res_diprice[0]['DiPrice'],
        		'Batch'=>$Batch[$key],
        		'Expiry'=>$Expiry[$key],
        		'MfgDate'=>$MfgDate[$key],
        		'ReceivedRemarks'=>$receivedremarks[$key],
        		'CreatedDateTime'=>$datetime,
        		'RefferenceOrderNo'=>$OrderId[$key]
        	);
        }
                $insert_batch = $this->db->insert_batch('product_stock_master', $data_array);                
                $myinsert_batch = $this->db->insert_batch('product_stock_master', $data_myarray);
                
   	if($UserRole== 'stockist')
	{
            $order_details_table = 'orders_details_stockist';
            $order_master_table = 'orders_master_stockist';           
        }
       
         if($UserRole== 'retailer')
	{
	    $order_details_table = 'orders_details_retailer';
            $order_master_table = 'orders_master_retailer';           
        }

	$update_data = array('OrderStatus'=>'6');
	$this->db->where('id',$stockorderid);
	$this->db->update($order_master_table ,$update_data);
	
	$this->db->where('OrderId',$stockorderid);
	$this->db->update($order_details_table ,$update_data);
 

        if ($insert_batch) {
            /*             * *Activity Logs** */
            //$msg = "Add product stock add order id = $insert_id";
            //save_activity_details($msg);
            /* * *Activity Logs End** */

            //$this->send_order_on_mail($insert_id,$data_array,$data_details_array);

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_stockistId_by_orderid($OrderId)
    {
            $sql = "SELECT StockistId FROM orders_master_retailer WHERE id='$OrderId' ";
            $query = $this->db->query($sql);
            $result = $query->result_array();
    	return $result[0]['StockistId'];
    }

    public function get_Order_Comment($OrderId)
    {
            $sql = "SELECT Comment FROM ProductOrdersSummary WHERE OrderId='$OrderId' ";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            if(count($result)>0){
    	        return $this->get_comment_data_array($result[0]['Comment']);
            }else{
                return "";
            }   
    }
    
    public function get_comment_data_array($comment){
        //$comment_data = (!empty($value['Comment']))?array('comment'=>$value['Comment']):array('comment'=>''); //get_comment_data_array($value['Comment'])
        $comments = explode('|',$comment);
        $comment_data = array();
        foreach($comments as $comnt){
            $cmt = explode(':',$comnt);
            if(!empty($cmt[0]) && !empty($cmt[1])){
                $comment_data[$cmt[0]] = $cmt[1];    
            }
        }
        return $comment_data;
    }

 public function get_customer_order_details_by_orderid($orderid)
   { 
        $order_details_table = 'orders_details_customer';      
        $this->db->from($order_details_table);
        $this->db->where('OrderId',$orderid);
        $this->db->join('product_master_new',"$order_details_table.ProductId=product_master_new.id");
       
        $query=$this->db->get();
        if($query->num_rows()>0)
        {
        	 return $query->result_array();
        }
        else
        {
        	return false;
        }
   }
   
   
   
   
     public function orders_supply_save() {
	
	//return json_encode($_POST);

        $OrderDate = $this->input->post('OrderDate'); 
        $OrderDate = date('Y-m-d',strtotime($OrderDate));
        $UserRole = $this->input->post('UserRole');
        $totalamount = $this->input->post('totalamount');
        $ProductId = $this->input->post('ProductId');
        $MrpRate = $this->input->post('MrpRate');
	$Batch = $this->input->post('Batch');
        $MfgDate = $this->input->post('MfgDate');
        $Expiry = $this->input->post('Expiry');
        $PurchaseRate = $this->input->post('PurchaseRate');
        
        $PTRMargin = $this->input->post('PTRMargin');
        $PTSMargin = $this->input->post('PTSMargin');
        
        $quantity = $this->input->post('quantity');
        $amount = $this->input->post('amount');        
        $datetime = date('Y-m-d H:i:s');
        $insert='';
        
        if($UserRole== 'stockist'){
            $RetailerId = $this->input->post('RetailerId');
            $StockistId = $_SESSION['user_id'];

             $data_array = array('OrderDate'=>$OrderDate,
                                'RetailerId' => $RetailerId,
                                'StockistId'=>$StockistId,
                                'OrderTotalAmount'=>$totalamount,
                                'OrderStatus'=>'4',
                                'OrderPlacedBy'=>'1',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_retailer', $data_array);
            $insert_id = $this->db->insert_id();
		    $BillNo= '#DI'.$insert_id;
            $ar=array('BillNo'=>$BillNo);
            $this->db->where('id',$insert_id);
            $update = $this->db->update('orders_master_retailer',$ar);
                foreach ($Expiry as $key => $qty) {
                    if($qty<=0){
                        continue;
                    }
                     $productinfo=$this->orders_model->get_product_info_by_id($ProductId[$key]);
		if(!empty($productinfo)){
			
			$GST=$productinfo->GstValue;
			if($GST!=0){
			$apply=$productinfo->GstValue;
			$Taxable = ($PurchaseRate[$key]*$quantity[$key])*$apply/100;	
			}
			else{
			$GST=0.00;
			$apply=0.00;		
			$Taxable = ($PurchaseRate[$key]*$quantity[$key]);	
			}
		}
		else{
		$GST=0.00;
		$apply=0.00;
		$Taxable=0.00;
		}
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'RetailerId' =>$RetailerId,
                        'StockistId'=>$StockistId,
                        'ProductId'=>$ProductId[$key],
                        'Expiry'=>$Expiry[$key],
			'MfgDate'=>$MfgDate[$key],
			'Batch'=>$Batch[$key],					
                        'ProductMRP'=>$MrpRate[$key],
                        'ProductPurchaseRate'=>$PurchaseRate[$key],
                        'OrderQuantity'=>$quantity[$key],
                        'ApprovedQuantity'=>$quantity[$key],
                        'Taxable'=>$Taxable,
                        'GstActual'=>$apply,
                        'GstValue'=>$GST,
                        'OrderStatus'=>4,
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_retailer', $data_details_array);


        }
        
        if($UserRole== 'admin'){
            $StockistId = $this->input->post('StockistId');
            $CompanyId = '0';

             $data_array = array('OrderDate'=>$OrderDate,
                                'StockistId'=>$StockistId,
                                'CompanyId'=>$CompanyId,
                                'OrderTotalAmount'=>$totalamount,
                                 'OrderStatus'=>'4',
                                'OrderPlacedBy'=>'1',
                                'CreatedDateTime'=>$datetime);
            $insert = $this->db->insert('orders_master_stockist', $data_array);
            $insert_id = $this->db->insert_id();
            $BillNo= '#DI'.$insert_id;
            $ar=array('BillNo'=>$BillNo);
            $this->db->where('id',$insert_id);
            $update = $this->db->update('orders_master_stockist',$ar);
                foreach ($Expiry as $key1 => $qty) {
                    if($qty<=0){
                        continue;
                    }
                    
                    $productinfo=$this->orders_model->get_product_info_by_id($ProductId[$key1]);
		if(!empty($productinfo))		
		{			
			
			$GST=$productinfo->GstValue;
			if($GST!=0){
			$apply=$productinfo->GstValue;
			$Taxable = ($PurchaseRate[$key1]*$quantity[$key1])*$apply/100;	
			}
			else{
			$GST=0.00;
			$apply=0.00;		
			$Taxable = ($PurchaseRate[$key1]*$quantity[$key1]);	
			}
		}
		else{
		$GST=0.00;
		$apply=0.00;
		$Taxable=0.00;
		}
                    
                    $data_details_array[] = array('OrderDate'=>$OrderDate,
                        'OrderId' => $insert_id,
                        'StockistId' =>$StockistId,
                        'CompanyId'=>$CompanyId,
                        'ProductId'=>$ProductId[$key1],
                        'ProductMRP'=>$MrpRate[$key1],
			'Expiry'=>$Expiry[$key1],
			'MfgDate'=>$MfgDate[$key1],
			'Batch'=>$Batch[$key1],
                        'ProductPurchaseRate'=>$PurchaseRate[$key1],
                        'OrderQuantity'=>$quantity[$key1],
                        'Discount'=>$PTSMargin[$key1],
                        'ApprovedQuantity'=>$quantity[$key1],
                        'Taxable'=>$Taxable,
                        'GstActual'=>$apply,
                        'GstValue'=>$GST,
                        'OrderStatus'=>4,
                        'CreatedDateTime'=>$datetime);

                }
                $insert_batch = $this->db->insert_batch('orders_details_stockist', $data_details_array);
        }
        

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add orders id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            //$this->send_order_on_mail($insert_id,$data_array,$data_details_array);

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'orderid'=>$insert_id,'OrderSubmitUserType'=>$UserRole));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
   
 public function orders_supply_print(){
        $data = array();
        $OrderId = $this->input->get('OrderId');

        if($_SESSION['user_role']=='stockist'){

            $sql = "SELECT * FROM orders_master_retailer WHERE id='".$OrderId."' ";
            $query = $this->db->query($sql);
            $result = $query->result_array(); 
            $data['summary'] = $query->result_array(); 
            $data['details'] = $this->get_orders_supply_details_by_orderid_for_sender($result[0]['id']);

            $data['User'] = $this->retailer_model->get_retailer_details_by_id($result[0]['RetailerId']);
            $data['OrderSubmitedfor'] = $this->stockist_model->get_stockist_details_by_id($result[0]['StockistId']);
        }
        if($_SESSION['user_role']=='admin'){

            $sql = "SELECT * FROM orders_master_stockist WHERE id='".$OrderId."' ";
            $query = $this->db->query($sql);
            $result = $query->result_array(); 
            $data['summary'] = $query->result_array(); 
            $data['details'] = $this->get_orders_supply_details_by_orderid_for_sender($result[0]['id']);

             $data['User'] = $this->stockist_model->get_stockist_details_by_id($result[0]['StockistId']);
             $data['OrderSubmitedfor'] = COMPANYNAME; //$this->distributor_model->get_distributor_details_by_id($result[0]['DistributorId']);
        }

        return $data;

    }
    
    public function get_orders_supply_details_by_orderid_for_sender($OrderId){

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        if($UserRole== 'stockist'){
            $sql = "SELECT *,orders_details_retailer.id as orderdetailsid,product_master_new.id as productmasterid FROM orders_details_retailer INNER JOIN product_master_new ON orders_details_retailer.ProductId=product_master_new.id WHERE orders_details_retailer.OrderId='".$OrderId."' ";
        }
        
        if($UserRole== 'admin'){
            $sql = "SELECT *,orders_details_stockist.id as orderdetailsid,product_master_new.id as productmasterid FROM orders_details_stockist INNER JOIN product_master_new ON orders_details_stockist.ProductId=product_master_new.id WHERE orders_details_stockist.OrderId='".$OrderId."' ";
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
    
    
   public function changeorderstatus() {
	 $orderid  = $this->input->post('orderid');
	 $ostatus  = $this->input->post('ostatus');
	 
	 if($ostatus==0){
	     $datatime = '0000-00-00 00:00:00';
	     $resp_order_status = 'Pending';
	 }else{
	    $datatime = date('Y-m-d H:i:s');    
	    $resp_order_status = 'Ready';
	 }
	 
    if($ostatus==5){	 
	    $data_array = array('OrderId' => '0','StockType' => '1' );
        $this->db->where('OrderId',$orderid);
        $update = $this->db->update('ProductStock', $data_array);
        $ProductOrders_array['ProductUIC'] = '';

        $table="<table width='100%' border='1' cellpadding='6' cellspacing='0'><tr><th>Order Id</th><th>Product Name</th><th>Design Code</th><th>Colour</th><th>Size</th><th>Quantity</th><th>Price</th><th>Amount</th></tr>";
        $OrderDetails = $this->db->query("SELECT * FROM ProductOrders WHERE id='".$orderid."'");
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $e){
                    $ProductName = $this->db->query("SELECT ProductName FROM `ProductMaster` WHERE id='".$e['ProductId']."'")->row();
                    $ColourName = $this->db->query("SELECT ColourName FROM `ColourMaster` WHERE id='".$e['ColourId']."'")->row();
                    $SizeName = $this->db->query("SELECT SizeName FROM `SizeMaster` WHERE id='".$e['SizeId']."'")->row();
                    $table.="<tr><td>".$e['OrderId']."</td><td>".$ProductName."</td><td>".$e['DesigneCode']."</td><td>".$ColourName."</td><td>".$SizeName."</td><td>".$e['ProductQty']."</td><td>".$e['Price']."</td><td>".($e['ProductQty']*$e['Price'])."</td></tr>";
                }
                $table.="</table>";
                
            }
        }
        
        $user_details = $this->user_model->get_user_details_by_id($UserId);
        send_mail_simple($user_details['EmailId'],'admin@melhortechnologies.com','Sunflower- Order Cancelled - '.$OrderId.'.','Dear Customer,<br> Your order with OrderId -<b>'.$OrderId.'</b> has been cancelled successfully.<br><br>'.$table.' <br>Thanks,<br> Sunflower');
        
    }
	 
	    $ProductOrders_array['OrderStatus'] = $ostatus;
        $this->db->where('OrderId',$orderid);
        $update = $this->db->update('ProductOrders', $ProductOrders_array);
	 
	    $ProductOrdersSummary_array = array('OrderStatus' => $ostatus);
		$this->db->where('OrderId',$orderid);
        $update = $this->db->update('ProductOrdersSummary', $ProductOrdersSummary_array);
        


        if ($update) {
            /*             * *Activity Logs** */
            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG,"OrderStatus" => $resp_order_status));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    } 
    
    
    

} // class ends here

