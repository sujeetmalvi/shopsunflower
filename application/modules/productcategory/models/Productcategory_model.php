<?php

class productcategory_model extends CI_Model {

    function __construct() {
        parent::__construct();
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
                'DiPrice'	        =>	        $row['D'],
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
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM CategoryMaster WHERE `CategoryName` = '$CategoryName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('CategoryName' => $CategoryName,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('CategoryMaster', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add category id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
// 	public function get_all(){
// 		$sql = "SELECT * FROM `product_category_master` ";        
//          $query = $this->db->query($sql);
// 		 return $query->result_array();
// 	}

    public function get_productcategory_list()
	{
       $sql = "SELECT * FROM `CategoryMaster` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                       
                        <td>'.$value['CategoryName'].'</td>';
                       
                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('productcategory/productcategory_edit').'/?CategoryId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('productcategory/productcategory_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

        $sql = "SELECT id FROM CategoryMaster WHERE `CategoryName` = '$CategoryName' AND `id`!=$CategoryId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array = array('CategoryName' => $CategoryName);
       
        $this->db->where('id',$CategoryId);
        $update = $this->db->update('CategoryMaster', $data_array);        
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
        $sql = "DELETE FROM CategoryMaster WHERE id = '$id'";
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
       $sql = "SELECT * FROM CategoryMaster WHERE id=$CategoryId "; 
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
	

} // class ends here
