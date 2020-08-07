<?php

class Locality_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }



     public function get_locality_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT locality_master.*,city_master.CityName,state_master.StateName FROM locality_master LEFT JOIN state_master ON locality_master.StateId=state_master.id LEFT JOIN city_master ON locality_master.CityId=city_master.id WHERE 1 ORDER BY LocalityName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['StateName'].'</td><td>'.$value['CityName'].'</td><td>'.$value['LocalityName'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('locality/locality_edit').'/?LocalityId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('locality/locality_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function locality_save() {
        
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $LocalityName = $this->input->post('LocalityName');

        
        $sql = "SELECT id FROM locality_master WHERE `LocalityName` = '$LocalityName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'LocalityName' => $LocalityName);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('locality_master', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add locality id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_locality_details_by_id(){
        $LocalityId = $this->input->get('LocalityId');
        $sql = "SELECT * FROM locality_master WHERE id='".$LocalityId."' ";
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


   public function locality_update() {
        $CityId = $this->input->post('CityId');
        $StateId = $this->input->post('StateId');
        $LocalityId = $this->input->post('LocalityId');
        $LocalityName = $this->input->post('LocalityName');
        
        $sql = "SELECT id FROM locality_master WHERE `LocalityName` = '$LocalityName' AND StateId='$StateId' AND CityId='$CityId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId'=>$StateId,'CityId'=>$CityId, 'LocalityName' => $LocalityName);
        $this->db->where('id',$LocalityId);
        $update = $this->db->update('locality_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Locality id = $LocalityId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }





    public function locality_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM locality_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


} // class ends here
