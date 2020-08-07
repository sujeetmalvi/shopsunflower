<?php

class Product_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_colours_name_list(){
        $sql = "SELECT id,ColourName FROM ColourMaster  WHERE 1 ORDER BY ColourName ASC";
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
        $sql = "SELECT id,concat(SizeName,' ( ',SizeCode,' )') as SizeName FROM SizeMaster  WHERE 1 ORDER BY SizeName ASC";
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
         $sql = "SELECT * FROM product_master_new  WHERE 1 ORDER BY ProductName ASC";
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
    
	public function get_product_list_by_id($id){
		$sql = "SELECT * FROM ProductMaster WHERE id=$id "; 
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
	
	
	
	


    public function get_all_product_list_with_for_pos(){
        $sql = "SELECT id,ProductName,CategoryId  FROM product_master_new WHERE 1 ORDER BY ProductName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $result[] = array('id'=>$d["id"],'ProductName'=>$d["ProductName"],'CategoryId'=>$d["CategoryId"]);

                 }
                return $result;
            } else {
                return false;
            }
        }
    }


     public function get_product_listnew(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        
       $sql = "SELECT ProductMaster.*,CategoryName,ColourName,SizeName,ProductMaster.ColourId FROM ProductMaster 
                    INNER JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
                    INNER JOIN ColourMaster ON ColourMaster.id = ProductMaster.ColourId 
                    INNER JOIN SizeMaster ON SizeMaster.id = ProductMaster.SizeId 
                    WHERE 1 ORDER BY ProductName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {
                        $filename='';
                        if (file_exists('./uploads/products/'.$value['DesigneCode'].'~'.$value['ColourId'].'.jpg') ){
                            $filename = $value['DesigneCode'].'~'.$value['ColourId'].'.jpg';    
                        }
                        if (file_exists('./uploads/products/'.$value['DesigneCode'].'~'.$value['ColourId'].'.png') ){
                            $filename = $value['DesigneCode'].'~'.$value['ColourId'].'.png';
                        }
                        if (file_exists('./uploads/products/'.$value['DesigneCode'].'~'.$value['ColourId'].'.jpeg')){
                            $filename = $value['DesigneCode'].'~'.$value['ColourId'].'.jpeg';
                        }
                        
                        

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                        <td>'.$value['CategoryName'].'</td>
                        <td>'.$value['ColourName'].'</td>
                        <td>'.$value['SizeName'].'</td>
                        <td>'.$value['ProductName'].'</td>
                        <td>'.$value['ProductPrice'].'</td>
                        <td>';
                        if (file_exists('./uploads/products/'.$filename) || file_exists('./uploads/products/'.$filename) || file_exists('./uploads/products/'.$filename)) {
                        $result.='<a href='.base_url('uploads/products/'.$filename).' target="_new"><img src='.base_url('uploads/products/'.$filename).' style="height:80px;max-width:100px;" /></a>';
                        }else{
                           $result.= base_url().'uploads/products/'.$filename;
                        }
                        
                        $result.='</td>
                        <td>'.$value['DesigneCode'].'</td>';
                        if($value['VisibleStatus']=='1'){ $result.='<td>True</td>'; }else{ $result.='<td>False</td>'; }
                        if($value['IsPreOrder']=='1'){ $result.='<td>Yes</td>'; }else{ $result.='<td>No</td>';}
                        if($value['IsOffer']=='1'){ $result.='<td>'.$value["OfferPrice"].'</td>'; }else{ $result.='<td></td>';}
                        


// `ProductCode`, `ProductName`, `CategoryId`, `DivisionId`, `PackingType1`, `PackingType2`, `OriginalPacking`, `SamplePacking`, `ShipperPacking`, `General_Food`, `PurchaseRate`, `MrpRate`, `PTRMargin`, `PTSMargin`, `PTDMargin`, `Composition`, `SelfLifeExpiry`,CreatedDateTime


// <a class="btn btn-xs btn-warning" href="'.site_url('product/product_edit').'/?ProductId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                        $result.='<td>
                              <a class="btn btn-xs btn-warning" href="'.site_url('product/product_edit').'/?ProductId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('product/product_deletenew').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                              <a class="btn btn-xs btn-success" href="'.site_url('product/product_addimages').'/?ProductId='.$value["id"].'&DesigneCode='.$value["DesigneCode"].'&ColourId='.$value["ColourId"].'" title="add_images"><i class="fa fa-plus" aria-hidden="true"></i></a>
                              </td>';
                            //   <a class="btn btn-xs btn-warning" href="'.site_url('product/product_edit').'/?ProductId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                         


                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }



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


    // public function product_savenew() {

        
    //     // $dd = '';
    //     // foreach($_POST as $key => $val){
    //     //     //$dd .= "'".$key."' => $".$key.", ";
    //     //     //$dd .= "$".$key."' = $"."this->input->post('".$key."');<br>";
    //     // }
    //     // return $dd;

    //  $ProductName  = $this->input->post('ProductName');
    //  $ProductDescription  = $this->input->post('ProductDescription');
    //  $Company  = $this->input->post('Company');
    //  $Division  = $this->input->post('Division');
    //  $PurPack  = $this->input->post('PurPack');
    //  $SalesPack  = $this->input->post('SalesPack');
    //  $MinStock  = $this->input->post('MinStock');
    //  $MaxStock  = $this->input->post('MaxStock');
    //  $MRP  = $this->input->post('MRP');
    //  $Batch  = $this->input->post('Batch');
    //  $VatOn  = $this->input->post('VatOn');
    //  $VatPercent  = $this->input->post('VatPercent');
    //  $Favourite  = $this->input->post('Favourite');
    //  $RackId  = $this->input->post('RackId');
    //  $Active  = $this->input->post('Active');
    //  $Discount  = $this->input->post('Discount');
    //  $Mfg  = $this->input->post('Mfg');
    //  $SalesPackQty  = $this->input->post('SalesPackQty');
    //  $ShipperPack  = $this->input->post('ShipperPack');
    //  $Ratio  = $this->input->post('Ratio');
    //  $ReorderQty  = $this->input->post('ReorderQty');
    //  $Expiry  = $this->input->post('Expiry');
    //  $AddVat  = $this->input->post('AddVat');
    //  $TaxOnRate  = $this->input->post('TaxOnRate');
    //  $Barcode  = $this->input->post('Barcode');
    //  $Category  = $this->input->post('Category');
    //  $Schedule  = $this->input->post('Schedule');
    //  $HSN  = $this->input->post('HSN');
    //  $PurGST  = $this->input->post('PurGST');
    //  $SalesGST  = $this->input->post('SalesGST');
    //  $MaxDisc  = $this->input->post('MaxDisc');
    //  $ItemType  = $this->input->post('ItemType');
    //  $MRPRate  = $this->input->post('MRPRate');
    //  $TP  = $this->input->post('TP');
    //  $TPDiscountPercent  = $this->input->post('TPDiscountPercent');
    //  $CR  = $this->input->post('CR');
    //  $Excise  = $this->input->post('Excise');
    //  $ExciseDiscount  = $this->input->post('ExciseDiscount');
    //  $CST  = $this->input->post('CST');
    //  $Purchase  = $this->input->post('Purchase');
    //  $Cost  = $this->input->post('Cost');
    //  $SaleRate  = $this->input->post('SaleRate');
    //  $PTR  = $this->input->post('PTR');
    //  $PTS  = $this->input->post('PTS');
    //  $MarginPercentage  = $this->input->post('MarginPercentage');
    //  $MarginRupees  = $this->input->post('MarginRupees');
    //  $RetPercentage  = $this->input->post('RetPercentage');

    //     $sql = "SELECT id FROM tally_data WHERE `ProductName` = '$ProductName'  "; //" AND `bActive`='0' 
    //     $query = $this->db->query($sql);
    //     if ($query) {
    //         if ($query->num_rows() > 0) {
    //             return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
    //         } 
    //     }


    //     $data_array = array('ProductName' => $ProductName, 'ProductDescription' => $ProductDescription, 'Company' => $Company, 'Division' => $Division, 'PurPack' => $PurPack, 'SalesPack' => $SalesPack, 'MinStock' => $MinStock, 'MaxStock' => $MaxStock, 'MRP' => $MRP, 'Batch' => $Batch, 'VatOn' => $VatOn, 'VatPercent' => $VatPercent, 'Favourite' => $Favourite, 'RackId' => $RackId, 'Active' => $Active, 'Discount' => $Discount, 'Mfg' => $Mfg, 'SalesPackQty' => $SalesPackQty, 'ShipperPack' => $ShipperPack, 'Ratio' => $Ratio, 'ReorderQty' => $ReorderQty, 'Expiry' => $Expiry, 'AddVat' => $AddVat, 'TaxOnRate' => $TaxOnRate, 'Barcode' => $Barcode, 'Category' => $Category, 'Schedule' => $Schedule, 'HSN' => $HSN, 'PurGST' => $PurGST, 'SalesGST' => $SalesGST, 'MaxDisc' => $MaxDisc, 'ItemType' => $ItemType, 'MRPRate' => $MRPRate, 'TP' => $TP, 'TPDiscountPercent' => $TPDiscountPercent, 'CR' => $CR, 'Excise' => $Excise, 'ExciseDiscount' => $ExciseDiscount, 'CST' => $CST, 'Purchase' => $Purchase, 'Cost' => $Cost, 'SaleRate' => $SaleRate, 'PTR' => $PTR, 'PTS' => $PTS, 'MarginPercentage' => $MarginPercentage, 'MarginRupees' => $MarginRupees, 'RetPercentage' => $RetPercentage);

    //     //return echoinsertdata('city_master', $data_array);

    //     $insert = $this->db->insert('tally_data', $data_array);
    //     $insert_id = $this->db->insert_id();
    //     if ($insert) {
    //         /*             * *Activity Logs** */
    //         $msg = "Add product id = $insert_id";
    //         save_activity_details($msg);
    //         /* * *Activity Logs End** */

    //         return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
    //     } else {
    //         return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
    //     }
    // }


    public function product_savenew() {

    $ProductName = $this->input->post('ProductName');
    $ProductPrice  = $this->input->post('ProductPrice');
    $ProductThumbnail  = $this->input->post('ProductThumbnail');
    $DesigneCode  = $this->input->post('DesigneCode');
    $CategoryId  = $this->input->post('CategoryId');
    $ColourId  = $this->input->post('ColourId');
    $SizeId  = $this->input->post('SizeId');
    $VisibleStatus  = ($this->input->post('VisibleStatus')=='')?0:$this->input->post('VisibleStatus');
    $IsOffer  = ($this->input->post('IsOffer')=='')?0:$this->input->post('IsOffer');
    $IsPreOrder  = ($this->input->post('IsPreOrder')=='')?0:$this->input->post('IsPreOrder');
    $OfferPrice  = ($IsOffer=='1')?$this->input->post('OfferPrice'):0;
    $datetime = date('Y-m-d H:i:s');


        $sql = "SELECT id FROM ProductMaster WHERE `ProductName` = '$ProductName' AND `DesigneCode`= '$DesigneCode' AND `CategoryId`='$CategoryId' AND `ColourId` = '$ColourId' AND `SizeId` = '$SizeId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }


        $data_array = array(
          'ProductName' => $ProductName,
          'ProductPrice' => $ProductPrice,
          'ProductThumbnail' => '',
          'DesigneCode' => $DesigneCode,
          'CategoryId' => $CategoryId,
          'ColourId' => $ColourId,
          'SizeId' => $SizeId,
          'VisibleStatus' => $VisibleStatus,
          'IsOffer' => $IsOffer,
          'IsPreOrder'=> $IsPreOrder,
          'OfferPrice' => $OfferPrice,
          'CreatedDateTime'=> $datetime
        );
        $insert = $this->db->insert('ProductMaster', $data_array);
        $q = $this->db->last_query();
        $insert_id = $this->db->insert_id();
        

        if ($insert) {
            
            $file_arr = upload_image($ColourId, 'ProductThumbnail', $DesigneCode.'~','products');
            $data_array = array('ProductThumbnail' => $file_arr['filename']);
        	$this->db->where('id',$insert_id);
            $update = $this->db->update('ProductMaster', $data_array);
        
            /* * *Activity Logs** */
  
            	$msg = "Add product id = $insert_id";
            	save_activity_details($msg);
            	/* * *Activity Logs End** */

           	 return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        	} else {
            		return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        	}
        	
    	}
    	
    	

    public function product_addimages_save() {

    $ProductId = $this->input->post('ProductId');
    $DesigneCode = $this->input->post('DesigneCode');
    $ColourId = $this->input->post('ColourId');
    
    $imagename = $DesigneCode.'~'.$ColourId;
    
        $data_array = array();

        $file_arr1 = upload_image('1', 'ProductImage1', 'p'.$imagename.'-','products');
        if($file_arr1['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr1['filename']);
        }

        $file_arr2 = upload_image('2', 'ProductImage2', 'p'.$imagename.'-','products');
        if($file_arr2['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr2['filename']);
        }

        $file_arr3 = upload_image('3', 'ProductImage3', 'p'.$imagename.'-','products');
        if($file_arr3['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr3['filename']);
        }

        $file_arr4 = upload_image('4', 'ProductImage4', 'p'.$imagename.'-','products');
        if($file_arr4['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr3['filename']);
        }

        $file_arr5 = upload_image('5', 'ProductImage5', 'p'.$imagename.'-','products');
        if($file_arr5['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr5['filename']);
        }

        $file_arr6 = upload_image('6', 'ProductImage6', 'p'.$imagename.'-','products');
        if($file_arr6['filename']!=''){
            $data_array[] = array('ProductId'=>$ProductId ,'DesigneCodeColourId'=>$imagename ,'ProductImage' => $file_arr6['filename']);
        }

        $insert = $this->db->insert_batch('ProductImages', $data_array);
        if ($insert) {
            /* * *Activity Logs** */
  
            	$msg = "Add product id = $ProductId";
            	save_activity_details($msg);
            	/* * *Activity Logs End** */

           	        return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        	} else {
            		return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        	}
}   	
    public function product_update(){

    $ProductId = $this->input->post('ProductId');
    $ProductName  = $this->input->post('ProductName');
    $ProductPrice  = $this->input->post('ProductPrice');
    $ProductThumbnail  = $_FILES['ProductThumbnail'];
    $DesigneCode  = $this->input->post('DesigneCode');
    $CategoryId  = $this->input->post('CategoryId');
    $ColourId  = $this->input->post('ColourId');
    $SizeId  = $this->input->post('SizeId');
    $VisibleStatus  = ($this->input->post('VisibleStatus')=='')?0:$this->input->post('VisibleStatus');
    $IsOffer  = ($this->input->post('IsOffer')=='')?0:$this->input->post('IsOffer');
    $IsPreOrder  = ($this->input->post('IsPreOrder')=='')?0:$this->input->post('IsPreOrder');
    $OfferPrice  = ($IsOffer=='1')?$this->input->post('OfferPrice'):0;
    $datetime = date('Y-m-d H:i:s');

/*
        $sql = "SELECT id FROM ProductMaster WHERE `ProductName` = '$ProductName' AND id!=$ProductId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
*/

        $data_array = array(
          'ProductName' => $ProductName,
          'ProductPrice' => $ProductPrice,
          'DesigneCode' => $DesigneCode,
          'CategoryId' => $CategoryId,
          'ColourId' => $ColourId,
          'SizeId' => $SizeId,
          'VisibleStatus' => $VisibleStatus,
          'IsOffer' => $IsOffer,
          'IsPreOrder'=>$IsPreOrder,
          'OfferPrice' => $OfferPrice,
          'CreatedDateTime'=> $datetime
        );
        
        //$this->db->where('id',$ProductId);
        //$update = $this->db->update('ProductMaster', $data_array);

        if($ProductThumbnail['size']!=0){
            $file_arr = upload_image($ColourId, 'ProductThumbnail', $DesigneCode.'~','products');
            $data_array['ProductThumbnail'] = $file_arr['filename'];
        }
        
        
    	$this->db->where('id',$ProductId);
        $update = $this->db->update('ProductMaster', $data_array);
        //$q = $this->db->last_query();
    
        /* * *Activity Logs** */

        	$msg = "Update product id = $ProductId";
        	save_activity_details($msg);
        	/* * *Activity Logs End** */

       	    return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));

    }

    public function get_product_images_list(){
        $productid = $_GET['ProductId'];
        $DesigneCode = $_GET['DesigneCode'];
        $ColourId = $_GET['ColourId'];
        
        $DesigneCodeColourId = $DesigneCode.'~'.$ColourId;
        
        //$sql = "SELECT * FROM ProductImages WHERE ProductId = '".$productid."'";
        $sql = "SELECT * FROM ProductImages WHERE DesigneCodeColourId = '".$DesigneCodeColourId."'";
        
        $query = $this->db->query($sql);
        $result='';
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                        <td><a href='.base_url('uploads/products/'.$value['ProductImage']).' target="_new"><img src='.base_url('uploads/products/'.$value['ProductImage']).' style="height:80px;" /></a></td>';

                        $result.='<td>
                              <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('product/product_delete_addimages').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                              
                              </td>';
                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }    	
    	
    	
    	
    	
    	

    public function product_save() {
        
        $ProductCode = $this->input->post('ProductCode');
        $ProductName = $this->input->post('ProductName');
        $CategoryId = $this->input->post('CategoryId');
        $DivisionId = $this->input->post('DivisionId');
        $PackingType1 = $this->input->post('PackingType1');
        $PackingType2 = $this->input->post('PackingType2');
        $OriginalPacking = $this->input->post('OriginalPacking');
        $SamplePacking = $this->input->post('SamplePacking');
        $ShipperPacking = $this->input->post('ShipperPacking');
        $General_Food = $this->input->post('General_Food');
        $PurchaseRate = $this->input->post('PurchaseRate');
        $MrpRate = $this->input->post('MrpRate');
        $PTRMargin = $this->input->post('PTRMargin');
        $PTSMargin = $this->input->post('PTSMargin');
        $PTDMargin = $this->input->post('PTDMargin');
        $Composition = $this->input->post('Composition');
        $SelfLifeExpiry = $this->input->post('SelfLifeExpiry');
        $datetime = date('Y-m-d H:i:s');
        
        $sql = "SELECT id FROM product_master WHERE `ProductCode` = '$ProductCode'  AND ProductName='$ProductName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('ProductCode' => $ProductCode,'ProductName'=>$ProductName,'CategoryId'=>$CategoryId,'DivisionId'=>$DivisionId,'PackingType1'=>$PackingType1,'PackingType2'=>$PackingType2,'OriginalPacking'=>$OriginalPacking,'SamplePacking'=>$SamplePacking,'ShipperPacking'=>$ShipperPacking,'General_Food'=>$General_Food,'PurchaseRate'=>$PurchaseRate,'MrpRate'=>$MrpRate,'PTRMargin'=>$PTRMargin,'PTSMargin'=>$PTSMargin,'PTDMargin'=>$PTDMargin,'Composition'=>$Composition,'SelfLifeExpiry'=>$SelfLifeExpiry,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('product_master', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add product id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_product_details_by_id(){
        $ProductId = $this->input->post('ProductId');
        $Type = $this->input->post('Type');

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];


        if($ProductId=='0'){
            if($Type=='all_products'){
                $sql = "SELECT DISTINCT pmn.id, pmn. * , psm.ProductQuantity, psm.MRP, psm.Diprice, psm.Batch, psm.Expiry, psm.MfgDate , gm.GstApply 
                        FROM product_master_new pmn
                        INNER JOIN product_stock_master psm ON pmn.id = psm.ProductId
                        INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue
                        WHERE 1  GROUP BY pmn.id
                        ORDER BY psm.Expiry DESC ";
            }elseif ($Type=='all_ordered_products') {

                if($UserRole== 'stockist'){

                    $sql = "SELECT product_master_new.* 
                            FROM product_master_new 
                            INNER JOIN orders_details_retailer ON orders_details_retailer.ProductId=product_master_new.id
                            WHERE orders_details_retailer.StockistId='".$UserId."' 
                            AND orders_details_retailer.OrderStatus='1' 
                            AND orders_details_retailer.OrderBookedStatus='0' ";
                    }

                    if($UserRole== 'admin'){

                        $sql = "SELECT product_master_new.* 
                                FROM product_master_new 
                                INNER JOIN orders_details_stockist ON orders_details_stockist.ProductId=product_master_new.id
                                WHERE orders_details_stockist.StockistId='".$UserId."' 
                                AND orders_details_stockist.OrderStatus='1' 
                                AND orders_details_stockist.OrderBookedStatus='0' ";
                    }
               
            }
        }else{
        $ParentId='';
        $ParentRoleId='';
        if($UserRole=='retailer'){        
        	$parent_id=$this->retailer_model->get_retailer_details_by_id($UserId);
        	$ParentId=$parent_id['StockistId'];
        	$ParentRoleId=2;
        }
        if($UserRole=='stockist'){        
        	$parent_id=$this->retailer_model->get_retailer_details_by_id($UserId);
        	$ParentId=1;
        	$ParentRoleId=0;
        }
            
            $sql ="SELECT sum(psm.ProductQuantity) as TotalQuantity , pmn.*,psm.id as stockid, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate,gm.GstApply 
            FROM  product_master_new pmn 
            INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId 
            INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue 
            WHERE pmn.id='".$ProductId."' AND psm.`UserId`='".$ParentId."' AND psm.`UserRoleId`='".$ParentRoleId."' 
            GROUP BY psm.Batch  ORDER BY psm.Expiry DEsc";


            //"SELECT pmn.*, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate,gm.GstApply FROM  product_master_new pmn INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue WHERE pmn.id='".$ProductId."' ORDER BY psm.Expiry DEsc   ";
//GROUP BY pmn.id LIMIT 1
/*$UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];
            $sql = "SELECT sum(psm.ProductQuantity) as TotalQuantity , pmn.*,psm.id as stockid, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate,gm.GstApply FROM  product_master_new pmn 
INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId 
INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue 
WHERE pmn.id='".$ProductId."' AND psm.`UserId`='".$UserId."' AND psm.`UserRoleId`='".$UserRoleId."' GROUP BY psm.Batch  ORDER BY psm.Expiry DEsc "*/
        }
        //return $sql;
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            
            } else {
                return $this->db->last_query();
            }
        }
    }
    
    public function get_product_stock_received_by_id(){
        $ProductId = $this->input->post('ProductId');
        $Type = $this->input->post('Type');

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];


        if($ProductId=='0'){
            if($Type=='all_products'){
                $sql = "SELECT DISTINCT pmn.id, pmn. *
                FROM product_master_new pmn
                WHERE 1 ";
            }elseif ($Type=='all_ordered_products') {

                if($UserRole== 'stockist'){

                    $sql = "SELECT product_master_new.* 
                            FROM product_master_new 
                            INNER JOIN orders_details_retailer ON orders_details_retailer.ProductId=product_master_new.id
                            WHERE orders_details_retailer.StockistId='".$UserId."' 
                            AND orders_details_retailer.OrderStatus='1' 
                            AND orders_details_retailer.OrderBookedStatus='0' ";
                    }

                    if($UserRole== 'admin'){

                        $sql = "SELECT product_master_new.* 
                                FROM product_master_new 
                                INNER JOIN orders_details_stockist ON orders_details_stockist.ProductId=product_master_new.id
                                WHERE orders_details_stockist.StockistId='".$UserId."' 
                                AND orders_details_stockist.OrderStatus='1' 
                                AND orders_details_stockist.OrderBookedStatus='0' ";
                    }
               
            }
        }else{
            $sql = "SELECT pmn.* FROM  product_master_new pmn 
                    WHERE pmn.id='".$ProductId."' 
                    LIMIT 1  ";
        }
        //return $sql;
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return json_encode(array('status'=>'1','datas'=>$result));
            
            } else {
                return false;
            }
        }
    }


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

    

    public function get_all_product_category_list_for_pos(){
        $sql = "SELECT CategoryId FROM product_master_new WHERE 1 GROUP BY CategoryId ORDER BY CategoryId ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $result[] = array('value'=>$d["CategoryId"],'label'=>$d["CategoryId"]);

                 }
                return $result;
            } else {
                return false;
            }
        }
    }
    
    
    
    
    
        public function get_product_stocknew_by_loginid($id){
    	
    	$UserId = $_SESSION['user_id'];
        $UserRoleId = $_SESSION['user_roleid'];
        $result = "";
        $sql = "SELECT product_stock_master .* ,
        date_format(Expiry,'%d-%m-%Y') as Expiry,
        date_format(MfgDate,'%d-%m-%Y') as MfgDate,
        date_format(product_stock_master.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime,
        product_master_new.ProductName 
        FROM product_stock_master 
        INNER JOIN product_master_new ON product_master_new.id=product_stock_master.ProductId 
        WHERE product_stock_master.id=$id AND product_stock_master.UserId='".$UserId."' AND product_stock_master.UserRoleId='".$UserRoleId."'  ";

        $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                
                
              
                return $datas[0];
        }else{
        return false;
        }
    }


    public function get_all_product_stocknew_by_loginid(){
      $UserId = $_SESSION['user_id'];
        $UserRoleId = $_SESSION['user_roleid'];
        $result = "";
        $sql = "SELECT product_stock_master .* ,
         SUM(product_stock_master.ProductQuantity) as ProductQuantity,
        date_format(Expiry,'%d-%m-%Y') as Expiry,
        date_format(MfgDate,'%d-%m-%Y') as MfgDate,
        date_format(product_stock_master.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime,
        product_master_new.ProductName 
        FROM product_stock_master 
        INNER JOIN product_master_new ON product_master_new.id=product_stock_master.ProductId 
        WHERE product_stock_master.UserId='".$UserId."' AND product_stock_master.UserRoleId='".$UserRoleId."' GROUP BY product_stock_master.ProductId, product_stock_master.Batch";

        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=0;
                    $n=1;

                    //return json_encode($datas);
                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$i.'">';
                        $result.='<td>'.$n.'</td>
                        <td>'.$value['ProductName'].'</td>
                        <td>'.$value['Batch'].'</td>
                        <td>'.$value['MRP'].'</td>
                        <td>'.$value['DiPrice'].'</td>
                        <td>'.$value['ProductQuantity'].'</td>                       
                        <td>'.$value['Expiry'].'</td>
                        <td>'.$value['MfgDate'].'</td>                        
                        <td>'.$value['CreatedDateTime'].'</td>
                        ';
                        if($value['ProductQuantity']>=0) {                 
 
 $result.='<td><a class="btn btn-xs btn-warning" href="'.site_url('product/product_stocknew_edit').'/?StockId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>                         </td></tr>';
 }
 else{
 $result.='<td></td>';}
                        $i++;
                        $n++;
                   }
                return $result;
            } else {
                return false;
            }
       
    }



    public function get_all_product_stock_by_loginid(){
    	$UserId = $_SESSION['user_id'];
        $UserRoleId = $_SESSION['user_roleid'];
    	$result="";
        //$sql = "SELECT product_stock.*,product_master.ProductName,product_master.Composition,product_master.PackingType1,product_master.PackingType2 , date_format(ProductExpiryDate,'%d-%m-%Y') as ProductExpiryDate,date_format(ProductMFGDate,'%d-%m-%Y') as ProductMFGDate FROM product_master INNER JOIN product_stock ON product_master.id=product_stock.ProductId WHERE product_stock.UserId='".$UserId."' AND product_stock.UserRoleId='".$UserRoleId."'";

        $sql = "SELECT SUM(ProductQuantity) as ProductQuantity,`UserId`,`UserRoleId`,`RefferenceOrderNo`,`ProductId`,`ProductBatchNo`,`ProductMRP`,`ProductExpiryDate`,`ProductMFGDate`
            FROM product_stock  
            WHERE product_stock.UserId='".$UserId."' AND product_stock.UserRoleId='".$UserRoleId."'  
            GROUP BY ProductId ORDER BY `product_stock`.`ProductId` ASC";

//         $sql = "SELECT product_stock.* FROM product_stock  WHERE product_stock.UserId='".$UserId."' AND product_stock.UserRoleId='".$UserRoleId."'";

        $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                $stocks = array();
                foreach ($datas as $key => $data) {
                    $stocks[$data['ProductId']] = $data;
                }

                //pre($stocks);

                $i=1;
                $n=1;
                    

            $allprodsql = "SELECT id, ProductName, Composition, PackingType1, PackingType2 FROM product_master_new  WHERE 1";
            $allprodquery = $this->db->query($allprodsql);
            $allproddatas = $allprodquery->result_array();

            //pre($allproddatas);
                    
                    foreach ($allproddatas as $key => $value) {
                        if(!isset($stocks[$value['id']]) || $stocks[$value['id']]['ProductExpiryDate']=='1970-01-01'){
                            $value['ProductExpiryDate'] = '';
                        }else{
                            $value['ProductExpiryDate'] = $stocks[$value['id']]['ProductExpiryDate'];
                        }
                        if(!isset($stocks[$value['id']]) || $stocks[$value['id']]['ProductMFGDate']=='1970-01-01'){
                            $value['ProductMFGDate'] = '';
                        }else{
                            $value['ProductMFGDate'] = $stocks[$value['id']]['ProductMFGDate'];
                        }
                        if(!isset($stocks[$value['id']]['ProductBatchNo'])){
                            $value['ProductBatchNo'] = '';
                        }else{
                            $value['ProductBatchNo'] = $stocks[$value['id']]['ProductBatchNo'];
                        }
                        if(!isset($stocks[$value['id']]['ProductQuantity'])){
                            $value['ProductQuantity'] = '';
                        }else{
                            $value['ProductQuantity'] = $stocks[$value['id']]['ProductQuantity'];
                        }
                        if(!isset($stocks[$value['id']]['ProductMinStockLevel'])){
                            $value['ProductMinStockLevel'] = '';
                        }else{
                            $value['ProductMinStockLevel'] = $stocks[$value['id']]['ProductMinStockLevel'];
                        }

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$n.'</td>

                        <td>'.$value['ProductName'].'<hr style="margin:0px;border: solid 0.5px #3e3e3e">'.$value['Composition'].'</td>

                        <td>'.$value['PackingType1'].'<hr style="margin:0px;border: solid 0.5px #3e3e3e">'.$value['PackingType2'].'</td>

                        <td><input type="text" class="form-control" value="'.$value['ProductBatchNo'].'" name="ProductBatchNo['.$value['id'].']"/></td>

                        <td><input type="text" class="form-control" value="'.$value['ProductQuantity'].'" name="ProductQuantity['.$value['id'].']"/></td>

                        <td><input type="text" class="form-control mydatepicker" value="'.$value['ProductExpiryDate'].'" name="ProductExpiryDate['.$value['id'].']"/></td>
                        <td><input type="text" class="form-control mydatepicker" value="'.$value['ProductMFGDate'].'" name="ProductMFGDate['.$value['id'].']"/></td>
                        <td><input type="text" class="form-control" value="'.$value['ProductMinStockLevel'].'" name="ProductMinStockLevel['.$value['id'].']"/>
                        <input type="hidden" value="'.$value['id'].'" name="ProductId['.$value['id'].']"/></td>';
      
                        $result.='</tr>';
                        $i++;
                        $n++;
                    }
                return $result;
        }else{
            $sql = "SELECT product_master_new.id,product_master_new.ProductName ROM product_master_new
                WHERE 1";
        $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=0;
                    $n=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$i.'">';
                        $result.='<td>'.$n.'</td>
                        <td>'.$value['ProductName'].'<hr style="margin:0px;border: solid 0.5px #3e3e3e">'.$value['Composition'].'</td>
                        <td>'.$value['PackingType1'].'<hr style="margin:0px;border: solid 0.5px #3e3e3e">'.$value['PackingType2'].'</td>
                        <td><input type="text" class="form-control" value="" name="ProductBatchNo['.$i.']"/></td>
                        <td><input type="text" class="form-control" value="" name="ProductQuantity['.$i.']"/></td>
                        <td><input type="text" class="form-control mydatepicker" value="" name="ProductExpiryDate['.$i.']"/></td>
                        <td><input type="text" class="form-control mydatepicker" value="" name="ProductMFGDate['.$i.']"/></td>
                        <td><input type="text" class="form-control" value="" name="ProductMinStockLevel['.$i.']"/>
                        <input type="hidden" value="'.$value['id'].'" name="ProductId['.$i.']"/></td>';
                        $result.='</tr>';
                        $i++;
                        $n++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }


    public function product_deletenew(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM ProductMaster WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    public function product_delete_addimages(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM ProductImages WHERE id = '$id'";
        $query = $this->db->query($sql);

        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }    
    





    public function product_stock_savenew(){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $ProductId      = $this->input->post('ProductId');
        $MRP            = $this->input->post('MRP');
        $Batch        = $this->input->post('Batch');
        $Expiry      = $this->input->post('Expiry');
        $MfgDate         = $this->input->post('MfgDate');
        $PurchaseRate         = $this->input->post('PurchaseRate');
        $Quantity         = $this->input->post('Quantity');
        

        $datetime = date('Y-m-d H:i:s');
        $check_key=false;
        $incrementid = '0';

        foreach ($Batch as $key => $value) {
           // if($check_key==false){ $check_key=true; $incrementid=$key; }
            $ExpiryDate = date('Y-m-d',strtotime($Expiry[$key]));
            $MFGDate = date('Y-m-d',strtotime($MfgDate[$key]));

                $insert_array[] = array(
                    'UserId'=>$UserId,
                    'UserRoleId'=>$UserRoleId,
                    'ProductId'=>$ProductId[$key],
                    'Batch' => $Batch[$key], 
                    'ProductQuantity' => $Quantity[$key], 
                    'Expiry' => $ExpiryDate, 
                    'MfgDate' => $MFGDate, 
                    'CreatedDateTime' => $datetime
                );

        }

            $insert = $this->db->insert_batch('product_stock',$insert_array);
//            $q=$this->db->last_query();
            if($insert>0){
                return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
            } else {
                return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
            }
    }

    public function product_stock_save(){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $ProductId              = $this->input->post('ProductId');
        $ProductBatchNo         = $this->input->post('ProductBatchNo');
        $ProductQuantity        = $this->input->post('ProductQuantity');
        $ProductExpiryDate      = $this->input->post('ProductExpiryDate');
        $ProductMFGDate         = $this->input->post('ProductMFGDate');
        $ProductMinStockLevel   = $this->input->post('ProductMinStockLevel');
        $datetime = date('Y-m-d H:i:s');
        $check_key=false;
        $incrementid = '0';

        foreach ($ProductBatchNo as $key => $value) {
           // if($check_key==false){ $check_key=true; $incrementid=$key; }
            $ExpiryDate = date('Y-m-d',strtotime($ProductExpiryDate[$key]));
            $MFGDate = date('Y-m-d',strtotime($ProductMFGDate[$key]));

                $insert_array[] = array(
                    'UserId'=>$UserId,
                    'UserRoleId'=>$UserRoleId,
                    'ProductId'=>$ProductId[$key],
                    'ProductBatchNo' => $ProductBatchNo[$key], 
                    'ProductQuantity' => $ProductQuantity[$key], 
                    'ProductExpiryDate' => $ExpiryDate, 
                    'ProductMFGDate' => $MFGDate, 
                    'ProductMinStockLevel' => $ProductMinStockLevel[$key], 
                    'CreatedDateTime' => $datetime
                );

        }



            $delete_qry = $this->db->query("DELETE FROM product_stock WHERE UserId='".$UserId."' AND UserRoleId='".$UserRoleId."'");
            $insert = $this->db->insert_batch('product_stock',$insert_array);
            $q=$this->db->last_query();
            if($insert>0){
                return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG,'q'=>$q));
            } else {
                return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
            }



    }


    public function get_product_stock_mil_details_by_id(){
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];

        $ProductId = $this->input->post('ProductId');  
            $stockresult[0] = array('ProductQuantity'=>0,'ProductMinStockLevel'=>0);
            $stocksql = "SELECT SUM(ProductQuantity) as ProductQuantity,ProductMinStockLevel FROM product_stock 
                    WHERE 
                        ProductId='$ProductId' 
                        AND UserId='$UserId'
                        AND UserRoleId='$UserRoleId' 
                        GROUP BY ProductId";
        
        $stockquery = $this->db->query($stocksql);
        $stockresult = $stockquery->result_array();
        if ( $stockquery->num_rows() > 0) {
            $stockresult = $stockquery->result_array();
        }



        if($UserRole== 'stockist'){
            $orderresult[0] = array('ApprovedQuantity'=>0);
            $ordersql = "SELECT SUM(ApprovedQuantity) as ApprovedQuantity
                FROM orders_details_retailer 
                WHERE orders_details_retailer.StockistId='".$UserId."' 
                AND orders_details_retailer.OrderStatus='1' 
                AND orders_details_retailer.OrderBookedStatus='0' 
                AND ProductId='$ProductId' 
                GROUP BY ProductId";
        }

        if($UserRole== 'admin'){
            $orderresult[0] = array('ApprovedQuantity'=>0);
            $ordersql = "SELECT SUM(ApprovedQuantity) as ApprovedQuantity
                    FROM orders_details_stockist 
                    WHERE orders_details_stockist.StockistId='".$UserId."' 
                    AND orders_details_stockist.OrderStatus='1' 
                    AND orders_details_stockist.OrderBookedStatus='0' 
                    AND ProductId='$ProductId'
                    GROUP BY ProductId";
        }

        $orderquery = $this->db->query($ordersql);
        if ( $orderquery->num_rows() > 0) {
            $orderresult = $orderquery->result_array();
        }

        $datas['result'] = array('stock'=>$stockresult[0],'order'=>$orderresult[0]);

        //return $result;

        if (count($stockresult)>0 && count($orderresult)>0) {
            return json_encode(Array("status" => "1", "datas" => $datas ,"msg" =>$ordersql));
        } else {
            return json_encode(Array("status" => "2", "datas" => $datas, "msg" => ERROR_MSG));
        }

    }

    public function get_top_performing_products(){
        $result = array();
        $productsql = "SELECT 
                count(ProductId) as prod_count,
                ProductId,
                sum(ProductPurchaseRate*OrderQuantity) as amount            
                FROM  orders_details_distributor 
                WHERE 1 
                GROUP BY ProductId 
                ORDER BY prod_count DESC 
                LIMIT 0,5";

        $productquery = $this->db->query($productsql);
        $productresult = $productquery->result_array();

        foreach ($productresult as $key => $value) {
            $result[$key] = $value;

            $prodnamesql = "SELECT ProductName FROM product_master_new where id='".$value['ProductId']."' ";
            $prodnamequery = $this->db->query($prodnamesql);
            $prodnameresult = $prodnamequery->result_array();
            $result[$key]['ProductName'] = $prodnameresult[0]['ProductName'];

        }
        
        if(count($result)>0){
            return json_encode(Array("status" => "1", "data" =>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function product_stock_received_save(){

        $UserId             = $_SESSION['user_id'];
        $UserRole           = $_SESSION['user_role'];
        $UserRoleId         = $_SESSION['user_roleid'];

       // $TotalAmount        = $this->input->post('TotalAmount');
        $OrderDate          = $this->input->post('OrderDate');
        $RefferenceOrderNo  = $this->input->post('RefferenceOrderNo');

        // ARRAYS
        $ProductId          = $this->input->post('ProductId');
        $ProductMRP         = $this->input->post('MrpRate');
        $ProductQuantity    = $this->input->post('quantity');
        $amount             = $this->input->post('amount');
        //$PurchaseRate       = $this->input->post('PurchaseRate');
        $batchno            = $this->input->post('batchno');
        $expiry             = $this->input->post('expiry');    
        $mfgdate            = $this->input->post('mfgdate');    
        $DiPrice            = $this->input->post('DiPrice'); 
$DavaIndiaPrice            = $this->input->post('DavaIndiaPrice');




        $datetime = date('Y-m-d H:i:s');

        foreach ($ProductId as $key => $value) {

            $expdate = ($expiry[$key]=='')?'':date('Y-m-d',strtotime($expiry[$key]));
            
            $mgfdate = ($mfgdate[$key]=='')?'':date('Y-m-d',strtotime($mfgdate[$key]));

            

            // $data_array[] = array(
            //                 'UserId'=>$UserId,
            //                 'UserRoleId'=>$UserRoleId,
            //                 'RefferenceOrderNo'=>$RefferenceOrderNo,
            //                 'ProductId'=>$ProductId[$key],
            //                 'ProductBatchNo'=>$batchno[$key],
            //                 'ProductQuantity'=>$ProductQuantity[$key],
            //                 'ProductMRP'=>$ProductMRP[$key],
            //                 'ProductExpiryDate'=>$expdate,
            //                 'ProductMFGDate'=>$mgfdate,
            //                 'CreatedDateTime'=>$datetime
            //                 );



            $data_array[] = array(
                            'UserId'=>$UserId,
                            'UserRoleId'=>$UserRoleId,
                            'RefferenceOrderNo'=>$RefferenceOrderNo,
                            'ProductId'=>$ProductId[$key],
                            'Batch'=>$batchno[$key],
                            'ProductQuantity'=>$ProductQuantity[$key],
                            'MRP'=>$ProductMRP[$key],
                            'DiPrice'=>$DiPrice[$key],
                            'DavaIndiaPrice'=>$DavaIndiaPrice[$key],
                            'Expiry'=>$expdate,
                            'MfgDate'=>$mgfdate,
                            'CreatedDateTime'=>$datetime
                            );
        }

        $insert = $this->db->insert_batch('product_stock_master',$data_array);

        if($insert){
            return json_encode(Array("status" => "1", "msg" =>'Stock Saved Successfully'));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }

    }



    public function product_mil_stock_save(){

        $UserId             = $_SESSION['user_id'];
        $UserRole           = $_SESSION['user_role'];
        $UserRoleId         = $_SESSION['user_roleid'];
        // ARRAYS
        $ProductId          = $this->input->post('ProductId');
        $MilQuantity	    = $this->input->post('quantity');
 

        $datetime = date('Y-m-d H:i:s');

        foreach ($ProductId as $key => $value) {

            $data_array[] = array(
                            'UserId'=>$UserId,
                            'UserRoleId'=>$UserRoleId,
                            'ProductId'=>$ProductId[$key],
                            'MilQuantity'=>$MilQuantity[$key],
                            'CreatedDateTime'=>$datetime
                            );
        }

        $insert = $this->db->insert_batch('product_min_stock_level',$data_array);

        if($insert){
            return json_encode(Array("status" => "1", "msg" =>'Stock MIL Saved Successfully'));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }

    }

    public function product_mil_stock_list(){
        $UserId             = $_SESSION['user_id'];
        $UserRole           = $_SESSION['user_role'];
        $UserRoleId         = $_SESSION['user_roleid'];
        
        $sql = "SELECT product_master_new.id as ProductId,product_master_new.ProductName,product_min_stock_level.MilQuantity,product_min_stock_level.id FROM product_master_new INNER JOIN product_min_stock_level ON product_master_new.id=product_min_stock_level.ProductId 
        WHERE `UserId`='$UserId' AND `UserRoleId`='$UserRoleId' ORDER BY ProductName ASC";
        $query = $this->db->query($sql);
        $result='';
       if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                        <td>'.$value['ProductName'].'</td>
                        <td>'.$value['MilQuantity'].'</td>';
                        $result.='<td>
                              <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('product/product_mil_stock_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button> &nbsp; &nbsp; <a class="btn btn-xs btn-warning" href="javascript:;" title="Edit" onclick="product_mil_stock_edit('.$value["ProductId"].',\''.$value['ProductName'].'\')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                         </td>';


                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }




    public function product_mil_stock_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM product_min_stock_level WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    
      public function product_mil_stock_update(){
      	$ProductId = $this->input->post('ProductId');
      	$quantity = $this->input->post('quantity');
      	
      	$UserId             = $_SESSION['user_id'];
        $UserRole           = $_SESSION['user_role'];
        $UserRoleId         = $_SESSION['user_roleid'];
      	
      	$data = array('MilQuantity'=>$quantity);
      	$this->db->where('ProductId',$ProductId);
      	$this->db->where('UserId',$UserId);
      	$this->db->where('UserRoleId',$UserRoleId);
    	
      	
      	$this->db->update('product_min_stock_level',$data);
      	$q = $this->db->last_query();
      	$afftectedRows = $this->db->affected_rows();
        if($afftectedRows>0){
            return json_encode(Array("status" => "1", "msg" =>'Stock Update Successfully.'));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG,'$q'=>$q));
        }
        
      }
    
    
    

    public function get_productcategory_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,CategoryName FROM CategoryMaster WHERE 1 ORDER BY CategoryName ASC";
        $query = $this->db->query($sql);

        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }
 
     public function productcategory_save() 
	{        
        $CategoryName = $this->input->post('CategoryName');       
        $Remark = $this->input->post('Remark');      
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM product_category_master WHERE `ProductCategoryName` = '$CategoryName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('ProductCategoryName' => $CategoryName,'Remark'=>$Remark,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('product_category_master', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add productcategory id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_all(){
		$sql = "SELECT * FROM `product_category_master` ";        
         $query = $this->db->query($sql);
		 return $query->result_array();
	}

    public function get_productcategory_list()
	{
       $sql = "SELECT * FROM `product_category_master` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                       
                        <td>'.$value['ProductCategoryName'].'</td>
                       
                        <td>'.$value['Remark'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('product/productcategory_edit').'/?CategoryId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('product/productcategory_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                         </td>';
                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }


   public function productcategory_update() 
	{      
        $CategoryName = $this->input->post('CategoryName');          
        $CategoryId = $this->input->post('CategoryId');
		$Remark = $this->input->post('Remark');  
   
        $sql = "SELECT id FROM product_category_master WHERE `ProductCategoryName` = '$CategoryName' AND `id`!=$CategoryId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array = array('ProductCategoryName' => $CategoryName,'Remark'=>$Remark);
       
        $this->db->where('id',$CategoryId);
        $update = $this->db->update('product_category_master', $data_array);        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Category id = $CategoryId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function productcategory_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM product_category_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_productcategory_details_by_id()
	{	
	   $CategoryId=$this->input->get('CategoryId');
       $sql = "SELECT * FROM product_category_master WHERE id=$CategoryId "; 
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
	

    public function product_stock_update(){

        $ProductId      = $this->input->post('ProductName');
        $MRP            = $this->input->post('MRP');
        $Batch        = $this->input->post('Batch');
        $Expiry      = $this->input->post('Expiry');
        $MfgDate         = $this->input->post('MfgDate');
        $PurchaseRate         = $this->input->post('Diprice');
        $Quantity         = $this->input->post('ProductQuantity');
        $ReceivedRemarks = $this->input->post('ReceivedRemarks');
        $id= $this->input->post('id');
        

        $datetime = date('Y-m-d H:i:s');
        $check_key=false;
        $incrementid = '0';

        
            $ExpiryDate = date('Y-m-d',strtotime($Expiry));
            $MFGDate = date('Y-m-d',strtotime($MfgDate));

                $insert_array = array(
                    'MRP'=>$MRP,
                    'Diprice'=>$PurchaseRate,
                    'ProductId'=>$ProductId,
                    'Batch' => $Batch, 
                    'ProductQuantity' => $Quantity, 
                    'Expiry' => $ExpiryDate, 
                    'MfgDate' => $MFGDate, 
                    'ReceivedRemarks'=>$ReceivedRemarks ,                    
                );

     
		$this->db->where('id',$id);
            $update= $this->db->update('product_stock_master',$insert_array);
//            $q=$this->db->last_query();
            if($update>0){
                return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
            } else {
                return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
            }
    }
    
    
    public function get_product_details_by_id_supply(){
        $ProductId = $this->input->post('ProductId');
        $Type = $this->input->post('Type');

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];


        if($ProductId=='0'){
            if($Type=='all_products'){
                $sql = "SELECT DISTINCT pmn.id, pmn. * , psm.ProductQuantity, psm.MRP, psm.Diprice, psm.Batch, psm.Expiry, psm.MfgDate , gm.GstApply 
FROM product_master_new pmn
INNER JOIN product_stock_master psm ON pmn.id = psm.ProductId
INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue
WHERE 1  GROUP BY pmn.id
ORDER BY psm.Expiry DESC 
";
            }elseif ($Type=='all_ordered_products') {

                if($UserRole== 'stockist'){

                    $sql = "SELECT product_master_new.* 
                            FROM product_master_new 
                            INNER JOIN orders_details_retailer ON orders_details_retailer.ProductId=product_master_new.id
                            WHERE orders_details_retailer.StockistId='".$UserId."' 
                            AND orders_details_retailer.OrderStatus='1' 
                            AND orders_details_retailer.OrderBookedStatus='0' ";
                    }

                    if($UserRole== 'admin'){

                        $sql = "SELECT product_master_new.* 
                                FROM product_master_new 
                                INNER JOIN orders_details_stockist ON orders_details_stockist.ProductId=product_master_new.id
                                WHERE orders_details_stockist.StockistId='".$UserId."' 
                                AND orders_details_stockist.OrderStatus='1' 
                                AND orders_details_stockist.OrderBookedStatus='0' ";
                    }
               
            }
        }else{
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];
            $sql = "SELECT sum(psm.ProductQuantity) as TotalQuantity , pmn.*,psm.id as stockid, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate,gm.GstApply FROM  product_master_new pmn 
INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId 
INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue 
WHERE pmn.id='".$ProductId."' AND psm.`UserId`='".$UserId."' AND psm.`UserRoleId`='".$UserRoleId."' GROUP BY psm.Batch  ORDER BY psm.Expiry DEsc ";
//GROUP BY pmn.id LIMIT 1
        }
        //return $sql;
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

public function get_product_details_by_stockid(){
$stockid=$this->input->post('ProductId');
$sql="SELECT  pmn.*, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate,gm.GstApply FROM  product_master_new pmn 
INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId 
INNER JOIN gst_master gm ON pmn.SalesGST = gm.GstValue WHERE psm.id='".$stockid."'  ";
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


} // class ends here
