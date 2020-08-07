<?php

class Shop_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_shop_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,ShopName FROM ShopMaster WHERE id > 0 ORDER BY ShopName ASC";
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
 
     public function shop_save() {
         
        $ShopName = $this->input->post('ShopName');
        $GstinNo = $this->input->post('GstinNo');
        $Address = $this->input->post('Address');
        $State = $this->input->post('State');
        $City = $this->input->post('City');
        $PinNumber = $this->input->post('PinNumber');
        //CreatedDateTime
        //CreatedById
        $datetime = date('Y-m-d H:i:s');
        
        $sql = "SELECT id FROM ShopMaster WHERE `ShopName` = '$ShopName'  AND GstinNo='$GstinNo'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('ShopName' => $ShopName,'Address'=>$Address,'State' => $State ,'City'=>$City,'GstinNo'=>$GstinNo,'PinNumber'=>$PinNumber,'CreatedDateTime'=>$datetime);
    
        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('ShopMaster', $data_array);
        $insert_id = $this->db->insert_id();

        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add Shop id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

 

     public function get_shop_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT ShopMaster.* FROM ShopMaster WHERE 1 ORDER BY ShopName ASC";
        //$sql = "SELECT stockist_master.* FROM stockist_master  WHERE 1 ORDER BY StockistName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.' <a class="btn btn-xs btn-warning" href="'.site_url('shop/shop_edit').'/?ShopId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a><button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('shop/shop_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['ShopName'].'</td>
                        <td>'.$value['GstinNo'].'</td>
                        <td>'.$value['Address'].'</td>
                        <td>'.$value['State'].'</td>
                        <td>'.$value['City'].'</td>
                        <td>'.$value['PinNumber'].'</td>
                        <td>'.$value['CreatedDateTime'].'</td>';
                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }
   public function shop_update() {
        $ShopName = $this->input->post('ShopName');
        $GstinNo = $this->input->post('GstinNo');
        $Address = $this->input->post('Address');
        $State = $this->input->post('State');
        $City = $this->input->post('City');
        $PinNumber = $this->input->post('PinNumber');
        $datetime = date('Y-m-d H:i:s');
        $ShopId= $this->input->post('ShopId');
        
        $sql = "SELECT id FROM ShopMaster WHERE `ShopName` = '$ShopName'  AND `id`!=$ShopId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
		
		$data_array = array('ShopName' => $ShopName,'Address'=>$Address,'State' => $State ,'City'=>$City,'GstinNo'=>$GstinNo,'PinNumber'=>$PinNumber,'CreatedDateTime'=>$datetime);
       
        $this->db->where('id',$ShopId);
        $update = $this->db->update('ShopMaster', $data_array);    
        //$qry = $this->db->last_query();
        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Shop id = $ShopId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function shop_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM ShopMaster WHERE id = '$id' AND id > 0";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	 public function get_shop_details_by_id(){
		$ShopId=$this->input->get('ShopId');
       $sql = "SELECT ShopMaster.* FROM `ShopMaster` WHERE ShopMaster.id=$ShopId "; 
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
