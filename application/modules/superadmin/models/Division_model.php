<?php

class Division_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function division_save() 
	{        
        $DivisionName = $this->input->post('DivisionName');       
        $Remark = $this->input->post('Remark');      
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM division_master WHERE `DivisionName` = '$DivisionName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('DivisionName' => $DivisionName,'Remark'=>$Remark,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('division_master', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add division id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_all(){
		$sql = "SELECT * FROM `division_master` ";        
         $query = $this->db->query($sql);
		 return $query->result_array();
	}

    public function get_division_list()
	{
       $sql = "SELECT * FROM `division_master` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                       
                        <td>'.$value['DivisionName'].'</td>
                       
                        <td>'.$value['Remark'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('retailer/division/division_edit').'/?DivisionId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('retailer/division/division_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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


   public function division_update() 
	{      
        $DivisionName = $this->input->post('DivisionName');          
        $DivisionId = $this->input->post('DivisionId');
		$Remark = $this->input->post('Remark');  
   
        $sql = "SELECT id FROM division_master WHERE `DivisionName` = '$DivisionName' AND `id`!=$DivisionId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array = array('DivisionName' => $DivisionName,'Remark'=>$Remark);
       
        $this->db->where('id',$DivisionId);
        $update = $this->db->update('division_master', $data_array);        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Division id = $DivisionId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function division_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM division_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_division_details_by_id()
	{	
	   $DivisionId=$this->input->get('DivisionId');
       $sql = "SELECT * FROM division_master WHERE id=$DivisionId "; 
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
