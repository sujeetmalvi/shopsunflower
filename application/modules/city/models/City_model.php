<?php

class City_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


 /********************************* UNIT ***************************/
    
    // function get_city_list(){
    //     $status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
    //     $sql = "SELECT city_master.*,state_master.StateName FROM city_master INNER JOIN state_master ON state_master.id=city_master.StateId WHERE city_master.bActive='$status' ORDER BY city_master.id DESC";
    //     $query = $this->db->query($sql);

    //     if ($query) {
    //         if ($query->num_rows() > 0) {
    //         	$row=0;
    //         	$result = $query->result_array();
	   //         	foreach ($result as $key => $value) {

    //             $delete="<a id='delete".$value['id']."'  class='btn btn-default'   onclick='confirmdelete(".$value['id'].")'><i class='fa fa-trash'></i></a>                    
    //                 <div id='confirmbox".$value['id']."' class='pull-right fade'>
    //                     <a href='javascript:;'  class='btn btn-danger' style='margin-right: 10px;' onclick='deleteY(".$value['id'].",\"city\");'>Yes</a> 
    //                     <a href='javascript:;' class='btn btn-success' onclick='deleteN(".$value['id'].");'>No</a> 
    //                 </div>";

    //        		$data[] = array($row+1,$value['StateName'],$value['CityName'],$delete );
    //         		$row++;
    //         	}
    //         	return array('data' => $data);

    //         } else {
    //             return false;
    //         }
    //     }
    // }

    public function get_city_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,CityName FROM city_master WHERE 1 ORDER BY CityName ASC";
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


     public function get_city_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT city_master.*,state_master.StateName FROM city_master LEFT JOIN state_master ON city_master.StateId=state_master.id WHERE 1 ORDER BY CityName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['StateName'].'</td><td>'.$value['CityName'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('city/city_edit').'/?CityId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('city/city_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function city_save() {
        
        $StateId = $this->input->post('StateId');
        $CityName = $this->input->post('CityName');

        
        $sql = "SELECT id FROM city_master WHERE `CityName` = '$CityName'  AND StateId='$StateId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityName' => $CityName);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('city_master', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add city id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_city_details_by_id(){
        $CityId = $this->input->get('CityId');
        $sql = "SELECT * FROM city_master WHERE id='".$CityId."' ";
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


   public function city_update() {
        $CityId = $this->input->post('CityId');
        $StateId = $this->input->post('StateId');
        $CityName = $this->input->post('CityName');
        
        $sql = "SELECT id FROM city_master WHERE `CityName` = '$CityName' AND StateId='$StateId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId'=>$StateId,'CityName' => $CityName);
        $this->db->where('id',$CityId);
        $update = $this->db->update('city_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update City id = $CityId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_city_by_stateid($StateId){
        $StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM city_master WHERE StateId='$StateId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select City</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['CityName']."</option>";
        }
        return $options;
    }


    public function city_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM city_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


} // class ends here
