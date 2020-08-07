<?php

class Productstock_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_colours_name_list(){
        $sql = "SELECT id,ColourName FROM ColourMaster ORDER BY ColourName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }

    public function get_sizes_name_list(){
        $sql = "SELECT id,concat(SizeName,' ( ',SizeCode,' )') as SizeName FROM SizeMaster ORDER BY SizeName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }


    public function get_productcategory_name_list(){
        $sql = "SELECT id,CategoryName  FROM CategoryMaster ORDER BY CategoryName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }



    public function get_all_product_list(){
        $sql = "SELECT * FROM product_master_new ORDER BY ProductName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }
    
    
    public function get_productstock_by_id($ProductStockId=''){
        $sql = "SELECT ProductStock.*,DesigneCode,ColourId,SizeId FROM ProductStock INNER JOIN ProductMaster ON ProductMaster.id=ProductStock.ProductId WHERE ProductStock.id='".$ProductStockId."'";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result;
            } else {
                return false;
            }
        }
        
    }


    public function get_designcode_by_categoryid($category_id='',$designcode=''){
        
        $categoryid = ($category_id=='')?$this->input->post('categoryid'):$category_id;
        
        $sql = "SELECT DesigneCode FROM ProductMaster WHERE CategoryId='$categoryid' GROUP BY DesigneCode ORDER BY id ASC";
        $query = $this->db->query($sql);
        $result=array();
        $data = "<option value=''>Select DesignCode</option>";
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $key => $row){
                    if($designcode!='' && $designcode==$row['DesigneCode']){ $selected="selected='selected'"; }else{ $selected='';}
                    $data .= "<option value='".$row['DesigneCode']."'   ".$selected."  >".$row['DesigneCode']."</option>";        
                }
                return $data;
            } else {
                return false;
            }
        }
    }
    
    public function get_productid_by_designcode($design_code='',$ProductId=''){
        
        $designcode = ($design_code=='')?$this->input->post('designcode'):$design_code;
        
         $sql = "SELECT  CONCAT(ProductMaster.DesigneCode,'#',ProductMaster.ColourId,'#',ProductMaster.SizeId) as  unqid,CONCAT(ProductName,'-',ColourName,'-',SizeName) as Product 
                FROM ProductMaster 
                INNER JOIN ColourMaster ON ColourMaster.id=ProductMaster.ColourId 
                INNER JOIN SizeMaster ON SizeMaster.id = ProductMaster.SizeId
                WHERE DesigneCode='$designcode' ORDER BY ProductMaster.id ASC";
        $query = $this->db->query($sql);
        $result=array();
        $data = "<option value=''>Select Product</option>";
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                foreach($result as $key => $row){
                    if($ProductId!='' && $ProductId==$row['unqid']){ $selected="selected='selected'"; }else{ $selected='';}
                    $data .= "<option value='".$row['unqid']."' ".$selected.">".$row['Product']."</option>";        
                }
                return $data;
            } else {
                return false;
            }
        }
    }
    

    
    public function productstock_savenew(){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $CategoryId = $this->input->post('CategoryId');
        $DesigneCode = $this->input->post('DesigneCode');
        $ProductId = $this->input->post('ProductId');
        $d = explode('#',$ProductId);
        $ColourId = $d[1];
        $SizeId = $d[2];
        
        $p_productid = $this->db->query("SELECT id FROM ProductMaster Where ColourId='".$ColourId."' AND SizeId='".$SizeId."' AND DesigneCode='".$DesigneCode."'")->row();
        $ProductId = $p_productid->id;
        
        if(0 != $this->input->post('OrderId')){
            $OrderId = $this->input->post('OrderId');
        }else{ $OrderId=0; }
        //$Prod_details = explode('-',$ProductId);
        $ProductQty = $this->input->post('ProductQty');
        $StockType = $this->input->post('StockType');
        $datetime = date('Y-m-d H:i:s');
        
        $dt = date('ymd');
        
        $PUIC = $this->db->query("SELECT SUBSTR(ProductUIC, 7, 8)*1 ProductUIC FROM ProductStock WHERE ProductUIC like '".$dt."%' order by ProductUIC DESC limit 0,1")->row();
        $res_inc="";
        $inc = 0;
        if (isset($PUIC->ProductUIC) &&  $PUIC->ProductUIC > 0) {
            $inc= $PUIC->ProductUIC;
        }else{
            $inc = 0;
        }
            for($i=1;$i<=$ProductQty;$i++){
                $inc = $inc+1;
                $res_inc = str_pad($inc,8,"0",STR_PAD_LEFT);
                /*
                if($inc<10){
                    $res_inc = '00'.$inc;
                }elseif($inc>9){
                    $res_inc = '0'.$inc;
                }elseif($inc>99){
                    $res_inc = $inc;
                }
            */
                $data_arr[] = array(
                            'CategoryId'=>$CategoryId,
                            'ProductId'=>$ProductId,
                            'DesigneCode'=>$DesigneCode,
                            'ColourId' => $ColourId,
                            'SizeId' => $SizeId,
                            'ProductUIC' => $dt.$res_inc,
                            'ProductQty' => '1',
                            'StockType' => $StockType,
                            'OrderId' => $OrderId
                            );
                $ProductUIC[] = $dt.$res_inc;
            }
            $insert = $this->db->insert_batch('ProductStock',$data_arr);
            //$q = $this->db->last_query();

            if($insert){
                $ProductUIC = join(',',$ProductUIC);
                $update_arr=array('ProductUIC'=>$ProductUIC,'OrderStatus'=>'1');
                $this->db->where('OrderId', $OrderId);
                $this->db->where('OrderType',$StockType);
                $this->db->where('DesigneCode',$DesigneCode);
                $this->db->where('ColourId',$ColourId);
                $this->db->where('SizeId',$SizeId);
                $this->db->update('ProductOrders',$update_arr);
                
                $update_arr=array('OrderStatus'=>'1');
                $this->db->where('OrderId', $OrderId);
                $this->db->update('ProductOrdersSummary',$update_arr);
                
                return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'puic'=>$PUIC));
            } else {
                return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
            }
        
        return $res_inc;
    }
    
    
    public function productstock_updatenew(){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $ProductStockId = $this->input->post('ProductStockId');
        $CategoryId = $this->input->post('CategoryId');
        $DesigneCode = $this->input->post('DesigneCode');
        $ProductId = $this->input->post('ProductId');
        //$Prod_details = explode('-',$ProductId);
        $ProductQty = $this->input->post('ProductQty');
        $datetime = date('Y-m-d H:i:s');
        
        $data_arr = array(
                    'CategoryId'=>$CategoryId,
                    'ProductId'=>$ProductId,
                    'DesigneCode'=>$DesigneCode,
                    'ProductQty' => '1',
                    'InProcessDateTime' => $datetime
                    );
            //}
            
            $this->db->where('id',$ProductStockId);
            $insert = $this->db->update('ProductStock',$data_arr);
                
            if($insert){
                return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
            } else {
                return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
            }
        
        return $res_inc;
    }


   public function changeproductstatus() {
	 $productstockid  = $this->input->post('productstockid');
	 $pstatus  = $this->input->post('pstatus');
     $datatime = date('Y-m-d H:i:s');    

	if($pstatus==0){ 
        $data_array = array(
          'ProductStatus' => $pstatus, 
          'ReadyDateTime' => '0000-00-00 00:00:00',
          'InProcessDateTime' => '0000-00-00 00:00:00'
        );
	}elseif($pstatus==1){
	    $data_array = array(
          'ProductStatus' => $pstatus, 
          'ReadyDateTime' => '0000-00-00 00:00:00',
          'InProcessDateTime' => date('Y-m-d H:i:s')
        );
	}elseif($pstatus==2){
	    $data_array = array(
          'ProductStatus' => $pstatus, 
          'ReadyDateTime' => date('Y-m-d H:i:s'),
        );
	}
		$this->db->where('id',$productstockid);
        $update = $this->db->update('ProductStock', $data_array);
        //$q= $this->db->last_query();

        if ($update) {
            /*             * *Activity Logs** */
            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG,'dt'=>$datatime));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }    



     public function get_productstock_listnew(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        
       $sql = "SELECT ProductStock.*,ColourName,SizeName,CategoryName,ProductMaster.DesigneCode FROM ProductStock 
                    INNER JOIN ProductMaster ON ProductMaster.id=ProductStock.ProductId 
                    INNER JOIN ColourMaster ON ColourMaster.id = ProductMaster.ColourId 
                    INNER JOIN SizeMaster ON SizeMaster.id = ProductMaster.SizeId
                    INNER JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId
                    WHERE ProductStatus!=3 ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                   
                     if($value['ProductStatus']=='3' && $value['OrderId']>0 ){ $disable = 'disabled="disabled"'; }else{ $disable=""; }

                        $result.="<tr id='row'".$value['id'].">";
                        $result.="<td>".$i."</td>
                        <td>".$value['CategoryName']."</td>
                        <td>".$value['DesigneCode']."</td>
                        <td>".$value['ColourName']."</td>
                        <td>".$value['SizeName']."</td>
                        <td>".$value['ProductUIC']."</td>
                        <td>".$value['ProductQty']."</td>
                        <td><select name='ProductStatus' onchange='changeproductstatus(".$value['id'].",this.value);' ".$disable." >
                                <option value='0'";
                            $result.= ($value['ProductStatus']=='0')?'selected="selected"':'';
                        $result.=">Pending</option>
                                <option value='1'";
                            $result.= ($value['ProductStatus']=='1')?'selected="selected"':'';    
                        $result.=">In Process</option>
                                <option value='2'";
                            $result.= ($value['ProductStatus']=='2')?'selected="selected"':'';    
                        $result.=">Ready</option>";
                    //            <option value='3'";
                    //$result.= ($value['ProductStatus']=='3')?'selected="selected"':''; $result.=">Dispatched</option>
                        $result.="</select></td>
                        <td id='pdt".$value['id']."'>".$value['InProcessDateTime']."</td>
                        <td id='rdt".$value['id']."'>".$value['ReadyDateTime']."</td>
                        <td>".$value['OrderId']."</td>
                        <td>";
                        $result.= $_SERVER['ORDERTYPE'][$value['StockType']];
                        $result.="</td>";
                        
                    $result.='<td>';
                    if($value['OrderId']=='0'){
                        //<a class="btn btn-xs btn-warning" href="'.site_url('productstock/productstock_editnew').'/?ProductStockId='.$value['id'].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    $result.='<a id="delete" onclick="deleterow(\''.$value['id'].'\',\'row'.$value['id'].'\',\''.site_url('productstock/productstock_deletenew').'\')" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    }          
                    $result.='</td>';
                        $result.="</tr>"; 
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }

//<input id="'.$value['id'].'" onclick="changeproductstatus(this.id);" type="checkbox"  '.$checked.' '.$disable.' ><span id="productstatus'.$value['id'].'">'.$prodstatus.'</span></td> <!--disabled="disabled"-->                        







    public function product_stock_excelupload() {
        
    $i = 1;
    $CI =& get_instance();
    $UserRoleId = $this->session->userdata('UserRoleId');
    $UserId = $this->session->userdata('UserId');

    //load the excel library
    $this->load->library('excel');
    $file = $_FILES['excelfile']['tmp_name'];

    //read file from path
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    //get only the Cell Collection
    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
    //extract to a PHP readable array format
    foreach ($cell_collection as $cell) {
        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
        //header will/should be in row 1 only. of course this can be modified to suit your need.
        if ($row == 1) {
            $header[$row][$column] = $data_value;
        } else {
            $arr_data[$row][$column] = $data_value;
        }
    }
    //send the data in an array format
    $data['header'] = $header;
    $data['values'] = $arr_data;



    $CreatedDateTime = date('Y-m-d H:i:s');
//insert_batch
    foreach ($arr_data as $key => $row) {
//    return json_encode(array($row['A']));
//'Expiry'          =>      date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row['F'])),
//MfgDate'         =>      date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($row['G'])),
//return $row['A'];
        $insert_data[] = array(
                'UserId'          =>      $UserId,
                'UserRoleId'      =>      $UserRoleId,
                'ProductId'       =>      $row['A'],
                'ProductQuantity' =>      $row['B'],
                'MRP'             =>      $row['C'],
                'DiPrice'	  =>	  $row['D'],
                'Batch'           =>      $row['E'],
                'Expiry'          =>      $row['F'],
                'MfgDate'         =>      $row['G'],
                'CreatedDateTime' =>      $CreatedDateTime
                );
        $i++;
    }

    $insert = $this->db->insert_batch('product_stock_master',$insert_data);
    //$q= $this->db->last_query();

    if($insert){
        return json_encode(array('status'=>'1','msg'=>$i ." recoreds imported successfuly "));
    }else{
        return json_encode(array('status'=>'2','msg'=>"Sorry! There is some problem at row no.".$i." ."));
    }
  }

    public function product_excelupload() {
        
    $i = 1;
    $user_id = $this->session->userdata('user_id');

    //load the excel library
    $this->load->library('excel');
    $file = $_FILES['excelfile']['tmp_name'];

    //read file from path
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    //get only the Cell Collection
    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
    //extract to a PHP readable array format
    foreach ($cell_collection as $cell) {
        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
        //header will/should be in row 1 only. of course this can be modified to suit your need.
        if ($row == 1) {
            $header[$row][$column] = $data_value;
        } else {
            $arr_data[$row][$column] = $data_value;
        }
    }
    //send the data in an array format
    $data['header'] = $header;
    $data['values'] = $arr_data;

    $CreatedDateTime = date('Y-m-d H:i:s');

//insert_batch
    foreach ($arr_data as $key => $row) {
        $insert_data[] = array(
                'ProductName'       =>      (isset($row['A']))?$row['A']:'',
                'ProductDescription'=>      (isset($row['B']))?$row['B']:'',
                'Company'           =>      (isset($row['C']))?$row['C']:'',
                'Division'          =>      (isset($row['D']))?$row['D']:'',
                'PurPack'           =>      (isset($row['E']))?$row['E']:'',
                'SalesPack'         =>      (isset($row['F']))?$row['F']:'',
                'MinStock'          =>      (isset($row['G']))?$row['G']:'',
                'MaxStock'          =>      (isset($row['H']))?$row['H']:'',
                'RackId'            =>      (isset($row['I']))?$row['I']:'',
                'Active'            =>      (isset($row['J']))?$row['J']:'',
                'SalesPackQty'      =>      (isset($row['K']))?$row['K']:'',
                'ShipperPack'       =>      (isset($row['L']))?$row['L']:'',
                'Ratio'             =>      (isset($row['M']))?$row['M']:'',
                'ReorderQty'        =>      (isset($row['N']))?$row['N']:'',
                'ProductBarcode'    =>      (isset($row['O']))?$row['O']:'',
                'Category'          =>      (isset($row['P']))?$row['P']:'',
                'HSN'               =>      (isset($row['Q']))?$row['Q']:'',
                'PurGST'            =>      (isset($row['R']))?$row['R']:'',
                'SalesGST'          =>      (isset($row['S']))?$row['S']:'',
                'PTRMargin'         =>      (isset($row['T']))?$row['T']:'',
                'PTSMargin'         =>      (isset($row['U']))?$row['U']:'',
                'CreatedDateTime'   =>      $CreatedDateTime
                );
        $i++;
    }

    $insert = $this->db->insert_batch('product_master_new',$insert_data);

    if($insert){
        return json_encode(array('status'=>'1','msg'=>$i ." recoreds imported successfuly"));
    }else{
        return json_encode(array('status'=>'2','msg'=>"Sorry! There is some problem at row no.".$i." ."));
        
    }
  }


//     public function product_excelupload() {
        
//     $i = 1;
//     $CI =& get_instance();
//     $user_id = $CI->session->userdata('user_id');

//     //load the excel library
//     $CI->load->library('excel');
//     $file = $_FILES['excelfile']['tmp_name'];

//     //read file from path
//     $objPHPExcel = PHPExcel_IOFactory::load($file);

//     //get only the Cell Collection
//     $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
//     //extract to a PHP readable array format
//     foreach ($cell_collection as $cell) {
//         $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
//         $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
//         $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
//         //header will/should be in row 1 only. of course this can be modified to suit your need.
//         if ($row == 1) {
//             $header[$row][$column] = $data_value;
//         } else {
//             $arr_data[$row][$column] = $data_value;
//         }
//     }
//     //send the data in an array format
//     $data['header'] = $header;
//     $data['values'] = $arr_data;


// //insert_batch
//     foreach ($arr_data as $key => $row) {
//         $insert_data[] = array(
//                 'ProductName'              =>      $row['A'],
//                 'ProductDescription'       =>      $row['B'],
//                 'Company'           =>      $row['C'],
//                 'Division'          =>      $row['D'],
//                 'PurPack'           =>      $row['E'],
//                 'SalesPack'         =>      $row['F'],
//                 'MinStock'          =>      $row['G'],
//                 'MaxStock'          =>      $row['H'],
//                 'MRP'               =>      $row['I'],
//                 'Batch'             =>      $row['J'],
//                 'VatOn'             =>      $row['K'],
//                 'VatPercent'        =>      $row['L'],
//                 'Favourite'         =>      $row['M'],
//                 'RackId'            =>      $row['N'],
//                 'Active'            =>      $row['O'],
//                 'Discount'          =>      $row['P'],
//                 'Mfg'               =>      $row['Q'],
//                 'SalesPackQty'      =>      $row['R'],
//                 'ShipperPack'       =>      $row['S'],
//                 'Ratio'             =>      $row['T'],
//                 'ReorderQty'        =>      $row['U'],
//                 'Expiry'            =>      $row['V'],
//                 'AddVat'            =>      $row['W'],
//                 'TaxOnRate'         =>      $row['X'],
//                 'Barcode'           =>      $row['Y'],
//                 'Category'          =>      $row['Z'],
//                 'Schedule'          =>      $row['AA'],
//                 'HSN'               =>      $row['AB'],
//                 'PurGST'            =>      $row['AC'],
//                 'SalesGST'          =>      $row['AD'],
//                 'MaxDisc'           =>      $row['AE'],
//                 'ItemType'          =>      $row['AF'],
//                 'MRPRate'           =>      $row['AG'],
//                 'TP'                =>      $row['AH'],
//                 'TPDiscountPercent' =>      $row['AI'],
//                 'CR'                =>      $row['AJ'],
//                 'Excise'            =>      $row['AK'],
//                 'ExciseDiscount'    =>      $row['AL'],
//                 'CST'               =>      $row['AM'],
//                 'Purchase'          =>      $row['AN'],
//                 'Cost'              =>      $row['AO'],
//                 'SaleRate'          =>      $row['AP'],
//                 'PTR'               =>      $row['AQ'],
//                 'PTS'               =>      $row['AR'],
//                 'MarginPercentage'  =>      $row['AS'],
//                 'MarginRupees'      =>      $row['AT'],
//                 'RetPercentage'     =>      $row['AU'],
//                 );
//         $i++;
//     }

//     $insert = $CI->db->insert_batch('tally_data',$insert_data);

//     if($insert){
//         return json_encode(array('status'=>'1','msg'=>$i ." recoreds imported successfuly"));
//     }else{
//         return json_encode(array('status'=>'2','msg'=>"Sorry! There is some problem at row no.".$i." ."));
        
//     }

//         // $data_array = array('ProductCode' => $ProductCode,'ProductName'=>$ProductName,'CategoryId'=>$CategoryId,'DivisionId'=>$DivisionId,'PackingType1'=>$PackingType1,'PackingType2'=>$PackingType2,'OriginalPacking'=>$OriginalPacking,'SamplePacking'=>$SamplePacking,'ShipperPacking'=>$ShipperPacking,'General_Food'=>$General_Food,'PurchaseRate'=>$PurchaseRate,'MrpRate'=>$MrpRate,'PTRMargin'=>$PTRMargin,'PTSMargin'=>$PTSMargin,'PTDMargin'=>$PTDMargin,'Composition'=>$Composition,'SelfLifeExpiry'=>$SelfLifeExpiry,'CreatedDateTime'=>$datetime);

//         // //return echoinsertdata('city_master', $data_array);

//         // $insert = $this->db->insert('product_master', $data_array);
//         // $insert_id = $this->db->insert_id();
//         // if ($insert) {
//         //     /*             * *Activity Logs** */
//         //     $msg = "Add product id = $insert_id";
//         //     save_activity_details($msg);
//         //     /* * *Activity Logs End** */

//         //     return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
//         // } else {
//         //     return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
//         // }
//     }


    public function get_productid_by_barcode(){
        $barcode = $this->input->post('barcode');
        $sql = "SELECT id FROM product_master_new WHERE ProductBarcode ='".$barcode."' ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return json_encode(array('status'=>true,'productid'=>$result[0]['id']));
            }else{
            return json_encode(array('status'=>false,'productid'=>''));
            }
        }

    }

    public function productstock_deletenew(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM ProductStock WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    

    public function get_pre_orderid_by_productid(){
        $unqId = $this->input->post('unqId');
        $OrderType = $this->input->post('OrderType');
        $data = explode('#',$unqId);
        $DesigneCode = $data[0];
        $ColourId = $data[1];
        $SizeId = $data[2];
        
        $sql = "SELECT OrderId FROM `ProductOrders` WHERE DesigneCode='$DesigneCode' AND ColourId='$ColourId' AND SizeId ='$SizeId' AND OrderType='".$OrderType."' AND OrderStatus=1 AND ( ProductUIC='' OR ProductUIC IS NULL )";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $res="<option value=''>Select Order Id</option>";
        foreach($result as $r){
            $res.="<option value='".$r['OrderId']."'>".$r['OrderId']."</option>";
        }
        return $res;
    }
    
    public function get_pre_orderqty_by_orderid_productid(){
        $OrderId = $this->input->post('OrderId');
        $unqId = $this->input->post('unqId');
        $OrderType = $this->input->post('OrderType');
        $data = explode('#',$unqId);
        $DesigneCode = $data[0];
        $ColourId = $data[1];
        $SizeId = $data[2];
        
        $sql = "SELECT OrderQuantity FROM `ProductOrders` WHERE OrderId='$OrderId' AND DesigneCode='$DesigneCode' AND ColourId='$ColourId' AND SizeId ='$SizeId' AND OrderType='".$OrderType."' AND OrderStatus=1 AND ( ProductUIC='' OR ProductUIC IS NULL )";
        $query = $this->db->query($sql);
        $result = $query->row();
        if(isset($result->OrderQuantity)){
            $res= $result->OrderQuantity;
            return $res;
        }else{
            return $res=0;
        }
    }
    

 


} // class ends here
