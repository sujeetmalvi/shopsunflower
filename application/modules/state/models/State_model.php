<?php

class State_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


 /********************************* UNIT ***************************/
    
    // public function get_state_list(){
    //     $status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
    //     $sql = "SELECT * FROM state_master WHERE bActive='$status' ORDER BY id DESC";
    //     $query = $this->db->query($sql);


    //     if ($query) {
    //         if ($query->num_rows() > 0) {
    //         	$row=0;
    //         	$result = $query->result_array();
	   //         	foreach ($result as $key => $value) {


    //                 $delete="<a id='delete".$value['id']."'  class='btn btn-default'   onclick='confirmdelete(".$value['id'].")'><i class='fa fa-trash'></i></a>                    
    //                             <div id='confirmbox".$value['id']."' class='pull-right fade'>
    //                                 <a href='javascript:;'  class='btn btn-danger' style='margin-right: 10px;' onclick='deleteY(".$value['id'].",\"state\");'>Yes</a> 
    //                                 <a href='javascript:;' class='btn btn-success' onclick='deleteN(".$value['id'].");'>No</a> 
    //                             </div>";


    //        		$data[] = array($row+1,$value['StateName'],$delete); //"<button class='pull-right'>sdfd</button>"
    //         		$row++;
    //         	}
    //         	return array('data' => $data);

    //         } else {
    //             return false;
    //         }
    //     }
    // }

    public function get_state_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT state_master.* FROM state_master WHERE 1 ORDER BY StateName ASC";
        $query = $this->db->query($sql);

        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['StateName'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('state/state_edit').'/?StateId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('state/state_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
 

    public function get_state_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,StateName FROM state_master WHERE 1 ORDER BY StateName ASC";
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
 

    public function state_save() {
        $StateName = $this->input->post('StateName');
        
        $sql = "SELECT id FROM state_master WHERE `StateName` = '$StateName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateName' => $StateName);
        $insert = $this->db->insert('state_master', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add State id = $insert_id";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function state_update() {
        $StateId = $this->input->post('StateId');
        $StateName = $this->input->post('StateName');
        
        $sql = "SELECT id FROM state_master WHERE `StateName` = '$StateName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateName' => $StateName);
        $this->db->where('id',$StateId);
        $update = $this->db->update('state_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update State id = $StateId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_state_details_by_id(){
        $StateId = $this->input->get('StateId');
        $sql = "SELECT * FROM state_master WHERE id='".$StateId."' ";
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

    public function state_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM state_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }




} // class ends here
