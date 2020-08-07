<?php

class Gst_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
    public function gst_save() 
	{        
        $GstName = $this->input->post('GstName');
		$GstValue = $this->input->post('GstValue');
		$GstType = $this->input->post('GstType');	
		$GstApply =   $this->input->post('GstApply');	
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM gst_master WHERE `GstName` = '$GstName'  "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('GstName' => $GstName,'GstValue'=>$GstValue,'GstApply'=>$GstApply,'GstType'=>$GstType,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('gst_master', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add gst id = $insert_id";
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

    public function get_gst_list()
	{
       $sql = "SELECT * FROM `gst_master` ";        
         $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                       
                        <td>'.$value['GstName'].'</td>
                       
                        <td>'.$value['GstValue'].'</td>
						 <td>'.$value['GstType'].'</td>';
						

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('retailer/gst/gst_edit').'/?GstId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('retailer/gst/gst_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function gst_delete()
	{
        $id = $this->input->post('id');
        $sql = "DELETE FROM gst_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	public function get_gst_details_by_id()
	{	
	   $GstId=$this->input->get('GstId');
       $sql = "SELECT * FROM gst_master WHERE id=$GstId "; 
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
