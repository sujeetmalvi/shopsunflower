<?php

class Driver_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


 /********************************* UNIT ***************************/
    
    public function get_driver_list(){
        $status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT * FROM driver_master WHERE ActiveDeactive='$status' ";
        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows() > 0) {
            	$result = $query->result_array();
            	return $result;
            } else {
                return false;
            }
        }
    }


    public function get_packages_list(){
        $status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT * FROM packages_master WHERE ActiveDeactive='$status' ";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
    }



    public function get_driver_details_by_id(){
        $DriverId = $this->input->get('DriverId');
        $sql = "SELECT * FROM driver_master WHERE id='".$DriverId."' ";
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


    public function get_driver_list_all(){

        $sql = "SELECT *,date_format(CreatedDateTime,'%d-%m-%Y %H:%i:%s') as created FROM driver_master WHERE 1 order by CreatedDateTime ASC";

            $result="";
            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        
                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td><td>'.$value['DriverName'].'</td><td>'.$value['DriverMobile'].'</td><td>'.$value['DriverCity'].'</td><td>'.$value['DriverState'].'</td><td>'.$value['DriverLicenseType'].'</td>';

                        $result.='<td>'.$value['created'].'</td>';

                         $result.='<td>

                            <button type="button" onclick="set_availablity('.$value['id'].')" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#availablity">
                                  Availablity
                                </button> <a class="btn btn-xs btn-warning" href="'.site_url('superadmin/driver/driver_edit').'/?DriverId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('superadmin/driver/driver_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>


                         </td>';


                        $result.='</tr>';
                        $i++;
                    }
                }
            }
            $result.="";
            return $result;
    }



    public function driver_save() {

        $DriverName = $this->input->post('DriverName');
        $DriverImage = $this->input->post('DriverImage');
        $DriverMobile = $this->input->post('DriverMobile');
        $DriverEmail = $this->input->post('DriverEmail');
        $DriverAddress = $this->input->post('DriverAddress');
        $DriverPincode = $this->input->post('DriverPincode');
        $DriverCity = $this->input->post('DriverCity');
        $DriverState = $this->input->post('DriverState');
        $DriverLicenseImage = $this->input->post('DriverLicenseImage');
        $DriverLicenseType = $this->input->post('DriverLicenseType');
        $DriverExperianceYears = $this->input->post('DriverExperianceYears');
        $DriverExperianceWith = $this->input->post('DriverExperianceWith');
        $DriverAadharImage = $this->input->post('DriverAadharImage');
        $DriverPoliceVerificationImage = $this->input->post('DriverPoliceVerificationImage');
        $DriverAvailablity = $this->input->post('DriverAvailablity');
        $datetime = date('Y-m-d H:i:s');


        $data_array = array(
            'DriverName'=>$DriverName, 
            'DriverImage'=>'',
            'DriverMobile'=>$DriverMobile , 
            'DriverEmail'=>$DriverEmail , 
            'DriverAddress'=>$DriverAddress , 
            'DriverPincode'=>$DriverPincode , 
            'DriverCity'=>$DriverCity , 
            'DriverState'=>$DriverState , 
            'DriverLicenseImage'=>'' , 
            'DriverLicenseType'=>$DriverLicenseType , 
            'DriverExperianceYears'=>$DriverExperianceYears , 
            'DriverExperianceWith'=>$DriverExperianceWith , 
            'DriverAadharImage'=>'' , 
            'DriverPoliceVerificationImage'=>'' , 
            'DriverAvailablity'=>$DriverAvailablity, 
            'CreatedDateTime'=>$datetime);

        //return echoinsertdata('Companies_master', $data_array);

        $insert = $this->db->insert('driver_master', $data_array);
        $insert_id = $this->db->insert_id();

        if($_FILES['DriverImage']['name']!=''){
            $result = upload_image($insert_id, 'DriverImage', 'DriverImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverImage'=>$result['filename']);
            $this->db->where('id',$insert_id);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverLicenseImage']['name']!=''){
            $result = upload_image($insert_id, 'DriverLicenseImage', 'DriverLicenseImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverLicenseImage'=>$result['filename']);
            $this->db->where('id',$insert_id);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverAadharImage']['name']!=''){
            $result = upload_image($insert_id, 'DriverAadharImage', 'DriverAadharImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverAadharImage'=>$result['filename']);
            $this->db->where('id',$insert_id);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverPoliceVerificationImage']['name']!=''){
            $result = upload_image($insert_id, 'DriverPoliceVerificationImage', 'DriverPoliceVerificationImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverPoliceVerificationImage'=>$result['filename']);
            $this->db->where('id',$insert_id);
            $this->db->update('driver_master',$update_array);
        }

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add Driver id = $insert_id";
            save_activity_details($msg);
            

            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }



    public function driver_update() {

        $DriverId = $this->input->post('DriverId');
        $DriverName = $this->input->post('DriverName');
        $DriverImage = $this->input->post('DriverImage');
        $DriverMobile = $this->input->post('DriverMobile');
        $DriverEmail = $this->input->post('DriverEmail');
        $DriverAddress = $this->input->post('DriverAddress');
        $DriverPincode = $this->input->post('DriverPincode');
        $DriverCity = $this->input->post('DriverCity');
        $DriverState = $this->input->post('DriverState');
        $DriverLicenseImage = $this->input->post('DriverLicenseImage');
        $DriverLicenseType = $this->input->post('DriverLicenseType');
        $DriverExperianceYears = $this->input->post('DriverExperianceYears');
        $DriverExperianceWith = $this->input->post('DriverExperianceWith');
        $DriverAadharImage = $this->input->post('DriverAadharImage');
        $DriverPoliceVerificationImage = $this->input->post('DriverPoliceVerificationImage');
        $DriverAvailablity = $this->input->post('DriverAvailablity');
        $datetime = date('Y-m-d H:i:s');


        $data_array = array(
            'DriverName'=>$DriverName, 
            'DriverImage'=>'',
            'DriverMobile'=>$DriverMobile , 
            'DriverEmail'=>$DriverEmail , 
            'DriverAddress'=>$DriverAddress , 
            'DriverPincode'=>$DriverPincode , 
            'DriverCity'=>$DriverCity , 
            'DriverState'=>$DriverState , 
            'DriverLicenseImage'=>'' , 
            'DriverLicenseType'=>$DriverLicenseType , 
            'DriverExperianceYears'=>$DriverExperianceYears , 
            'DriverExperianceWith'=>$DriverExperianceWith , 
            'DriverAadharImage'=>'' , 
            'DriverPoliceVerificationImage'=>'' , 
            'DriverAvailablity'=>$DriverAvailablity, 
            'CreatedDateTime'=>$datetime);

        //return echoinsertdata('Companies_master', $data_array);
        $this->db->where('id',$DriverId);
        $insert = $this->db->update('driver_master', $data_array);
        $afftectedRows = $this->db->affected_rows();

        if($_FILES['DriverImage']['name']!=''){
            $result = upload_image($DriverId, 'DriverImage', 'DriverImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverImage'=>$result['filename']);
            $this->db->where('id',$DriverId);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverLicenseImage']['name']!=''){
            $result = upload_image($DriverId, 'DriverLicenseImage', 'DriverLicenseImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverLicenseImage'=>$result['filename']);
            $this->db->where('id',$DriverId);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverAadharImage']['name']!=''){
            $result = upload_image($DriverId, 'DriverAadharImage', 'DriverAadharImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverAadharImage'=>$result['filename']);
            $this->db->where('id',$DriverId);
            $this->db->update('driver_master',$update_array);
        }

        if($_FILES['DriverPoliceVerificationImage']['name']!=''){
            $result = upload_image($DriverId, 'DriverPoliceVerificationImage', 'DriverPoliceVerificationImage'.$DriverMobile, 'driverdocuments');
            $update_array = array('DriverPoliceVerificationImage'=>$result['filename']);
            $this->db->where('id',$DriverId);
            $this->db->update('driver_master',$update_array);
        }

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add Driver id = $DriverId";
            save_activity_details($msg);
            

            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }



    public function driver_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM driver_master  WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

   
} // class ends here
