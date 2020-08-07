<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_user_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,UserName FROM UserMaster WHERE id > 0 ORDER BY UserName ASC";
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
 
     public function user_save() {
         
        $ShopId = $this->input->post('ShopId');
        $FullName = $this->input->post('FullName');
        $EmailId = $this->input->post('EmailId');
        $Password = $this->input->post('Password');
        $ContactNo = $this->input->post('ContactNo');
        $DeviceId = $this->input->post('DeviceId');
        $UserTypeId = $this->input->post('UserTypeId');
        $AgentName = $this->input->post('AgentName');
        $Termsandcondition = $this->input->post('Termsandcondition');
        $CreatedById = $this->session->userdata('UserId');
        //CreatedDateTime = $this->input->post('CreatedDateTime');        
        //CreatedDateTime
        //CreatedById
        $datetime = date('Y-m-d H:i:s');
        
        $sql = "SELECT id FROM UserMaster WHERE `FullName` = '$FullName' AND ContactNo = '$ContactNo' AND ShopId='$ShopId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('ShopId'=>$ShopId,'FullName' => $FullName,'EmailId' => $EmailId ,'ContactNo'=>$ContactNo,'DeviceId'=>$DeviceId,'UserTypeId'=>$UserTypeId,'AgentName'=>$AgentName,'Termsandcondition'=>$Termsandcondition,'CreatedById'=>$CreatedById, 'CreatedDateTime'=>$datetime);
        
    
        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('UserMaster', $data_array);
        $insert_id = $this->db->insert_id();

        $update_pass = $this->db->query("update UserMaster set `Password`=AES_ENCRYPT('".LOGIN_SALT."','".$Password."') where id='$insert_id'");


        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add User id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

 

     public function get_user_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT UserMaster.*,ShopName FROM UserMaster INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId WHERE 1 ORDER BY id DESC";
        //$sql = "SELECT stockist_master.* FROM stockist_master  WHERE 1 ORDER BY StockistName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.' <a class="btn btn-xs btn-warning" href="'.site_url('user/user_edit').'/?UserId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a><button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('user/user_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['ShopName'].'</td>
                        <td>'.$value['FullName'].'</td>
                        <td>'.$value['EmailId'].'</td>
                        <td>'.$value['ContactNo'].'</td>
                        <td>'.$value['DeviceId'].'</td>';
                        if($value['UserTypeId']=='1'){
                            $result.='<td>Administrator</td>';
                        }else{
                            $result.='<td>Member</td>';
                        }
                        $result.='<td>'.$value['AgentName'].'</td>
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
   public function user_update() {
       
        $ShopId = $this->input->post('ShopId');
        $FullName = $this->input->post('FullName');
        $EmailId = $this->input->post('EmailId');
        $Password = $this->input->post('Password');
        $ContactNo = $this->input->post('ContactNo');
        $DeviceId = $this->input->post('DeviceId');
        $UserTypeId = $this->input->post('UserTypeId');
        $AgentName = $this->input->post('AgentName');
        $Termsandcondition = $this->input->post('Termsandcondition');
        $CreatedById = $this->input->post('CreatedById');
        $datetime = date('Y-m-d H:i:s');
        
        
        $UserId= $this->input->post('UserId');
        
        /*
        $sql = "SELECT id FROM UserMaster WHERE `FullName` = '$FullName' AND ContactNo = '$ContactNo' AND ShopId='$ShopId' AND DeviceId='$DeviceId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
		*/
		
		$data_array = array(
		                    'ShopId'=>$ShopId,'FullName' => $FullName,
		                    'EmailId' => $EmailId ,
		                    //'ContactNo'=>$ContactNo,
		                    //'DeviceId'=>$DeviceId,
		                    'UserTypeId'=>$UserTypeId,
		                    'AgentName'=>$AgentName,'Termsandcondition'=>$Termsandcondition,
		                    'CreatedById'=>$CreatedById, 'CreatedDateTime'=>$datetime);
       
        $this->db->where('id',$UserId);
        $update = $this->db->update('UserMaster', $data_array);    
        if($Password!=''){
            $update_pass = $this->db->query("update UserMaster set `Password`=AES_ENCRYPT('".LOGIN_SALT."','".$Password."') where id='$UserId'");
        }
        
        //$qry = $this->db->last_query();
        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update User id = $UserId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function user_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM UserMaster WHERE id = '$id' AND id > 0";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	 public function get_user_details_by_id($UserId=''){
	     
	   $UserId=($UserId=='')?$this->input->get('UserId'):$UserId;
       $sql = "SELECT UserMaster.*,ShopName FROM UserMaster INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId WHERE UserMaster.id=$UserId "; 
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
