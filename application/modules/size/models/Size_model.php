<?php

class Size_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }



    public function get_size_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT * FROM SizeMaster WHERE 1 ORDER BY SizeName ASC";
        $query = $this->db->query($sql);

        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['SizeName'].'</td>';
                        $result.='<td>'.$value['SizeCode'].'</td>';
                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('size/size_edit').'/?SizeId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('size/size_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
 

    public function get_size_name_list(){
        $sql = "SELECT id,SizeName,SizeCode FROM SizeMaster WHERE 1 ORDER BY SizeName ASC";
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
 

    public function size_save() {
        $SizeName = $this->input->post('SizeName');
        $SizeCode = $this->input->post('SizeCode');
        
        $sql = "SELECT id FROM SizeMaster WHERE `SizeName` = '$SizeName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('SizeName' => $SizeName,'SizeCode' => $SizeCode);
        $insert = $this->db->insert('SizeMaster', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add Size id = $insert_id";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function size_update() {
        $SizeId = $this->input->post('SizeId');
        $SizeName = $this->input->post('SizeName');
        $SizeCode = $this->input->post('SizeCode');
        
        $sql = "SELECT id FROM SizeMaster WHERE `SizeName` = '$SizeName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('SizeName' => $SizeName,'SizeCode' => $SizeCode);
        $this->db->where('id',$SizeId);
        $update = $this->db->update('SizeMaster', $data_array);

        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Size id = $SizeId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_size_details_by_id(){
        $SizeId = $this->input->get('SizeId');
        $sql = "SELECT * FROM SizeMaster WHERE id='".$SizeId."' ";
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

    public function size_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM SizeMaster WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }




} // class ends here
