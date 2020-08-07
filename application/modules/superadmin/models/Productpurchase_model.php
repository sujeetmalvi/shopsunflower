<?php

class Productpurchase_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	

    public function get_all_product_list_with_brand(){
        $sql = "SELECT pmn.id,pmn.ProductName as product FROM product_master_new as pmn WHERE 1 ORDER BY pmn.ProductName ASC";
        
        
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $result[] = array('value'=>$d["id"],'label'=>$d["product"]);

                 }
                return $result;
            } else {
                return false;
            }
        }
    }


    public function get_product_details_by_productid(){
        $ProductId = $this->input->post('ProductId');
         $sql = "SELECT * FROM product_master_new  WHERE id='".$ProductId."' ORDER BY ProductName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return json_encode(array('status'=>'1','data'=>$result[0]));
            } else {
                return json_encode(array('status'=>'2','data'=>''));
            }
        }
    }


    public function productpurchase_save() 
	{     

        $InvoiceDate  = $this->input->post('InvoiceDate');
        $InvoiceDate = date('Y-m-d',strtotime($InvoiceDate));
        $VendorId  = $this->input->post('VendorId');
        $InvoiceNo  = $this->input->post('InvoiceNo');
        $InvoiceTotalAmount  = $this->input->post('InvoiceTotalAmount');


        $ProductName = $this->input->post('ProductName');
		$ProductDescription = $this->input->post('ProductDescription');
        $ProductId = $this->input->post('ProductId');
        $SalesPack = $this->input->post('SalesPack');
        $Barcode = $this->input->post('Barcode');
        $ProductQuantity = $this->input->post('ProductQuantity');
        $Batch = $this->input->post('Batch');
        $MarketPrice = $this->input->post('MarketPrice');
        $PurchasePrice = $this->input->post('PurchasePrice');
        $MfgDate = $this->input->post('MfgDate');      
        $Expiry = $this->input->post('Expiry');
        
        $datetime = date('Y-m-d H:i:s');   

        $this->db->trans_start();

        $master_data_array = array(
                        'InvoiceDate' => $InvoiceDate,
                        'InvoiceNo'=>$InvoiceNo,
                        'InvoiceTotalAmount'=>$InvoiceTotalAmount,
                        'CreatedDateTime'=>$datetime); 

        $insert = $this->db->insert('product_purchase_master', $master_data_array);
        $insert_id = $this->db->insert_id();

        foreach ($ProductName as $key => $value) {

            $MfgDate_date = date('Y-m-d',strtotime($MfgDate[$key]));
            $Expiry_date = date('Y-m-d',strtotime($Expiry[$key]));

            $ProductId[$key] = (isset($ProductId[$key]))?$ProductId[$key]:0;

            $data_array[] = array(
                        'ProductName' => $ProductName[$key],
                        'ProductId'=>$ProductId[$key],
                        'ProductDescription'=>$ProductDescription[$key],
                        'SalesPack'=>$SalesPack[$key],
                        'Barcode'=>$Barcode[$key],
                        'ProductQuantity'=>$ProductQuantity[$key],
                        'Batch'=>$Batch[$key],
                        'MarketPrice'=>$MarketPrice[$key],
                        'PurchasePrice'=>$PurchasePrice[$key],
                        'MfgDate'=>$MfgDate_date,
                        'Expiry'=>$Expiry_date,
                        'ProductPurchaseId'=>$insert_id,
                        'CreatedDateTime'=>$datetime);
        }

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert_batch('product_purchase_details', $data_array);


       $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE){
            /*             * *Activity Logs** */
            $msg = "Add product_purchase id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_all(){
		$sql = "SELECT * FROM `gst_master` ";        
         	$query = $this->db->query($sql);
		 return $query->result_array();
	}

    public function get_productpurchase_list()
	{
       $sql = "SELECT *,date_format(InvoiceDate,'%d-%m-%Y') as InvoiceDate,date_format(CreatedDatetime,'%d-%m-%Y %H:%i:%s') as CreatedDatetime FROM `product_purchase_master` order by CreatedDatetime DESC ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        $btnaddtostock='';
                        if($value['addtostockstatus']>0){
                        $btnaddtostock = '</button> <button id="addtostock" onclick="addtostock(\''.$value["id"].'\');" class="btn-xs btn-primary" title="add to stock">Add to Stock</button>';
                        }

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'<button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('superadmin/productpurchase/productpurchase_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button> <button id="delete" onclick="product_purchase_details(\''.$value["id"].'\');" class="btn-xs btn-success" title="Details"><i class="fa fa-table" aria-hidden="true"></i></button> </td>
                        <td>'.$value['InvoiceDate'].'</td>
                        <td>'.$value['InvoiceNo'].'</td>
                        <td>'.$value['InvoiceTotalAmount'].'</td>
                        <td>'.$btnaddtostock.'</td>
                        <td>'.$value['CreatedDatetime'].'</td>';					
                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }


   public function gst_update() 
	{      
        $GstName = $this->input->post('GstName'); 
		$GstValue = $this->input->post('GstValue');
		$GstType = $this->input->post('GstType');	
		$GstApply = $this->input->post('GstApply');
        $GstId = $this->input->post('GstId');
		
        $sql = "SELECT id FROM gst_master WHERE `GstName` = '$GstName' AND `id`!=$GstId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array = array('GstName' => $GstName,'GstApply'=>$GstApply,'GstValue'=>$GstValue,'GstType'=>$GstType,);
       
        $this->db->where('id',$GstId);
        $update = $this->db->update('gst_master', $data_array);        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Gst id = $GstId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function productpurchase_delete()
	{
        $id = $this->input->post('id');
        
        $this->db->trans_start();

        $sql = "DELETE FROM product_purchase_master WHERE id = '$id'";
        $query = $this->db->query($sql);

        $sql = "DELETE FROM product_purchase_details WHERE  ProductPurchaseId = '$id'";
        $query = $this->db->query($sql);

        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === TRUE){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_productpurchase_details_by_productpurchaseid()
	{	

	   $ProductPurchaseId = $this->input->post('ProductPurchaseId');
       $sql = "SELECT *,date_format(MfgDate,'%b-%Y') as MfgDate,date_format(Expiry,'%b-%Y') as Expiry FROM product_purchase_details WHERE ProductPurchaseId='$ProductPurchaseId' "; 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return json_encode(Array("status" => "1", "datas" => $result));
            } else {
                return json_encode(Array("status" => "2", "datas" => $sql));
            }
        }
    }



    

    public function addtostock_save() 
    {     
        $ProductPurchaseId = $this->input->post('ProductPurchaseId');
        $ProductName = $this->input->post('ProductName');
        $ProductDescription = $this->input->post('ProductDescription');
        $ProductId = $this->input->post('ProductId');
        $SalesPack = $this->input->post('SalesPack');
        $Barcode = $this->input->post('Barcode');
        $ProductQuantity = $this->input->post('ProductQuantity');
        $Batch = $this->input->post('Batch');
        $MarketPrice = $this->input->post('MarketPrice');
        $PurchasePrice = $this->input->post('PurchasePrice');
        $MfgDate = $this->input->post('MfgDate');      
        $Expiry = $this->input->post('Expiry');
        $Ratio = $this->input->post('Ratio');

        $SalesGst = $this->input->post('SalesGst');
        $DiPrice = $this->input->post('DiPrice');
        $DavaIndiaPrice = $this->input->post('DavaIndiaPrice');
        $ReceivedRemarks = $this->input->post('ReceivedRemarks');

        $datetime = date('Y-m-d H:i:s'); 


        $this->db->trans_start();

        foreach ($ProductName as $key => $Product) {
            $product_data_array[] = array(
                            `id`=>'',
                            `ProductName`=>$ProductName[$key],
                            `ProductDescription`=>$ProductDescription[$key],
                            `Company`=>'',
                            `Division`=>'',
                            `PurPack`=>'',
                            `SalesPack`=>$SalesPack[$key],
                            `MinStock`=>'',
                            `MaxStock`=>'', 
                            `RackId`=>'',
                            `Active`=>'',
                            `SalesPackQty`=>'', 
                            `ShipperPack`=>'', 
                            `Ratio`=>$Ratio[$key],
                            `ReorderQty`=>'', 
                            `ProductBarcode`=>$Barcode[$key],
                            `Category`=>'',
                            `HSN`=>'',
                            `PurGST`=>'',
                            `SalesGST`=>$SalesGst[$key],
                            `PTRMargin`=>'',
                            `PTSMargin`=>'',
                            `ProductMIL`=>'',
                            `CreatedDateTime`=>$datetime
                            );
        }
        $insert = $this->db->insert_batch('product_master_new', $product_data_array);
         
        foreach ($ProductName as $key => $Product) {
            $stock_data_array[] = array(
                            `id`=>'',
                            `UserId`=>'1', 
                            `UserRoleId`=>'0', 
                            `ProductId`=>$ProductId[$key], 
                            `ProductQuantity`=>$ProductQuantity[$key], 
                            `MRP`=>$MarketPrice[$key], 
                            `DiPrice`=>$DiPrice[$key], 
                            `PurchasePrice`=>$PurchasePrice[$key], 
                            `DavaIndiaPrice`=>$DavaIndiaPrice[$key], 
                            `Batch`=>$Batch[$key], 
                            `Expiry`=>$Expiry[$key], 
                            `MfgDate`=>$MfgDate[$key], 
                            `ReceivedRemarks`=>'', 
                            `RefferenceOrderNo`=>'', 
                            `SyncStatus`=>'1', 
                            'CreatedDateTime'=>$datetime
                            );
        }
        $insert = $this->db->insert_batch('product_stock_master', $stock_data_array);

        $update = $this->db->query("update product_purchase_master set addtostockstatus='0' WHERE id='".$ProductPurchaseId."'");
        $update = $this->db->query("update product_purchase_details set addtostockstatus='0' WHERE ProductPurchaseId='".$ProductPurchaseId."'");

       $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE){
            /*             * *Activity Logs** */
            $msg = "Add Product Purchase add to stock  id = $ProductPurchaseId";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


} // class ends here
