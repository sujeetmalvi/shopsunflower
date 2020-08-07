<?php

class Barcode_model extends CI_Model {

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

   public function barcode_update($barcode) 
   {
        $id= $this->input->post('id');
        $data_array = array('ProductBarcode'=>$barcode);
        $this->db->where('id',$id);
        $update = $this->db->update('product_master_new', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Product id = $id";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return $barcode;
        } else {
            return false;
        }
    }
    
    public function get_all_product_list(){
        $sql = "SELECT pmn.*, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate, psm.id as psmid FROM  product_master_new pmn       
INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId WHERE `pmn`.ProductBarcode!=''";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }
        }
        }
    
    
    public function get_product_details_by_id($Batch){
    
    $sql = "SELECT pmn.*, psm.ProductQuantity,psm.MRP,psm.Diprice,psm.Batch,psm.Expiry,psm.MfgDate FROM  product_master_new pmn
       
INNER JOIN product_stock_master psm ON pmn.id=psm.ProductId WHERE psm.Batch='".$Batch."' ";
        $query = $this->db->query($sql);
        $result=array();
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
