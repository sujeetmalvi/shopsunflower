<?php

class Category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    public function category_save() 
	{        
        $CategoryName = $this->input->post('CategoryName');       
        $Remark = $this->input->post('Remark');      
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM category_master WHERE `CategoryName` = '$CategoryName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('CategoryName' => $CategoryName,'Remark'=>$Remark,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('category_master', $data_array);
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
	
	public function get_all(){
		$sql = "SELECT * FROM `category_master` ";        
         $query = $this->db->query($sql);
		 return $query->result_array();
	}

    public function get_category_list()
	{
       $sql = "SELECT * FROM `category_master` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                       
                        <td>'.$value['CategoryName'].'</td>
                       
                        <td>'.$value['Remark'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('retailer/category/category_edit').'/?CategoryId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('retailer/category/category_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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


   public function category_update() 
	{      
        $CategoryName = $this->input->post('CategoryName');          
        $CategoryId = $this->input->post('CategoryId');
		$Remark = $this->input->post('Remark');  
   
        $sql = "SELECT id FROM category_master WHERE `CategoryName` = '$CategoryName' AND `id`!=$CategoryId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array = array('CategoryName' => $CategoryName,'Remark'=>$Remark);
       
        $this->db->where('id',$CategoryId);
        $update = $this->db->update('category_master', $data_array);        
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

    public function category_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM category_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_category_details_by_id()
	{	
	   $CategoryId=$this->input->get('CategoryId');
       $sql = "SELECT * FROM category_master WHERE id=$CategoryId "; 
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
