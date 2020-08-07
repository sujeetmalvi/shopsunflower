<?php

class Colour_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }



    public function get_colour_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT * FROM ColourMaster WHERE 1 ORDER BY ColourName ASC";
        $query = $this->db->query($sql);

        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['ColourName'].'</td>';
                        $result.='<td>'.$value['ColourCode'].'</td>';
                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('colour/colour_edit').'/?ColourId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('colour/colour_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
 

    public function get_colour_name_list(){
        $sql = "SELECT id,ColourName,ColourCode FROM ColourMaster WHERE 1 ORDER BY ColourName ASC";
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
 

    public function colour_save() {
        $ColourName = $this->input->post('ColourName');
        $ColourCode = $this->input->post('ColourCode');
        
        $sql = "SELECT id FROM ColourMaster WHERE `ColourName` = '$ColourName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('ColourName' => $ColourName,'ColourCode' => $ColourCode);
        $insert = $this->db->insert('ColourMaster', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add Colour id = $insert_id";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function colour_update() {
        $ColourId = $this->input->post('ColourId');
        $ColourName = $this->input->post('ColourName');
        $ColourCode = $this->input->post('ColourCode');
        
        $sql = "SELECT id FROM ColourMaster WHERE `ColourName` = '$ColourName' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('ColourName' => $ColourName,'ColourCode' => $ColourCode);
        $this->db->where('id',$ColourId);
        $update = $this->db->update('ColourMaster', $data_array);

        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Colour id = $ColourId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_colour_details_by_id(){
        $ColourId = $this->input->get('ColourId');
        $sql = "SELECT * FROM ColourMaster WHERE id='".$ColourId."' ";
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

    public function colour_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM ColourMaster WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }




} // class ends here
