<?php

class Transporter_model extends CI_Model {

    function __construct() 
    {
        parent::__construct();
    }

    public function get_transporter_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,TransporterName FROM transporter_master  ORDER BY TransporterName ASC";
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
 
    public function transporter_save() 
	{        
        $TransporterName = $this->input->post('TransporterName');       
        $Mobile= $this->input->post('Mobile');  
        $Landline= $this->input->post('Landline'); 
        $ContactPerson= $this->input->post('ContactPerson'); 
        $Email= $this->input->post('Email');
        $Address= $this->input->post('Address');     
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM transporter_master WHERE `TransporterName` = '$TransporterName' AND `Mobile`='$Mobile' AND `ContactPerson`='$ContactPerson' AND `Email`='$Email' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('TransporterName' => $TransporterName,'Mobile'=>$Mobile,'Landline'=>$Landline,'ContactPerson'=>$ContactPerson,'Email'=>$Email,'Address'=>$Address,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('transporter_master', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add transporter id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_all(){
		$sql = "SELECT * FROM `transporter_master` ";        
         $query = $this->db->query($sql);
		 return $query->result_array();
	}

    public function get_transporter_list()
	{
       $sql = "SELECT * FROM `transporter_master` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>                       
                        <td>'.$value['TransporterName'].'</td>
                       <td>'.$value['Address'].'</td>
                       <td>'.$value['Mobile'].'</td>                      
                       <td>'.$value['Email'].'</td>
                       <td>'.$value['Landline'].'</td>
                       <td>'.$value['ContactPerson'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('transporter/transporter_edit').'/?TransporterId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('transporter/transporter_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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


   public function transporter_update() 
	{      
        $TransporterName = $this->input->post('TransporterName');          
        $TransporterId = $this->input->post('TransporterId');
	$Mobile= $this->input->post('Mobile');  
        $Landline= $this->input->post('Landline'); 
        $ContactPerson= $this->input->post('ContactPerson'); 
        $Email= $this->input->post('Email');
        $Address= $this->input->post('Address');  
   
      $sql = "SELECT id FROM transporter_master WHERE `TransporterName` = '$TransporterName' AND `Mobile`='$Mobile' AND `ContactPerson`='$ContactPerson' AND `Email`='$Email' AND `id` != $TransporterId "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) 
		{
            if ($query->num_rows() > 0) 
			{
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
		}		
		 $data_array =array ('TransporterName' => $TransporterName,'Mobile'=>$Mobile,'Landline'=>$Landline,'ContactPerson'=>$ContactPerson,'Email'=>$Email,'Address'=>$Address);
       
        $this->db->where('id',$TransporterId);
        $update = $this->db->update('transporter_master', $data_array);        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Transporter id = $TransporterId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function transporter_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM transporter_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_transporter_details_by_id()
	{	
	   $TransporterId=$this->input->get('TransporterId');
       $sql = "SELECT * FROM transporter_master WHERE id=$TransporterId "; 
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
