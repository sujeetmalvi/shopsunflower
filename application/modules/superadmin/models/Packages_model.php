<?php

class Packages_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


 /********************************* UNIT ***************************/
    
    function get_packages_list(){
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

     public function packages_name_list(){
        $status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT * FROM institute_master WHERE ActiveDeactive='$status' ORDER BY id DESC";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return $result = $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function save_packages() {
        
        $PackageName = $this->input->post('PackageName');
        $NumberOfEmployies = $this->input->post('NumberOfEmployies');
        $PackagePrice = $this->input->post('PackagePrice');
        $PackageDuration = $this->input->post('PackageDuration');
        $datetime = date('Y-m-d H:i:s');



        $data_array = array('PackageName'=>$PackageName, 'NumberOfEmployies'=>$NumberOfEmployies, 'PackageDuration'=>$PackageDuration, 'PackagePrice'=>$PackagePrice, 'CreatedDateTime'=>$datetime);



        //return echoinsertdata('institute_master', $data_array);

        $insert = $this->db->insert('packages_master', $data_array);
        $insert_id = $this->db->insert_id();
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add institute id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }



    public function delete_packages(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM packages_master WHERE id = '$id'";
        $query = $this->db->query($sql);        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

} // class ends here
