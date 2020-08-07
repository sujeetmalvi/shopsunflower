<?php

class Customer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM customer_master WHERE `CustomerEmail`='".$loginname."' AND `CustomerPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'customer',
                        'user_roleid' => '4',
                        'CustomerId' => trim($datas[0]['CustomerId']),
                        'user_name' => trim($datas[0]['CustomerName']),
                        'RetailerId' => trim($datas[0]['RetailerId'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Customer Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_customer_list(){
        $UserId = $_SESSION['user_id'];
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT customer_master.*,city_master.CityName,state_master.StateName,retailer_master.RetailerName FROM customer_master LEFT JOIN state_master ON customer_master.StateId=state_master.id LEFT JOIN city_master ON customer_master.CityId=city_master.id LEFT JOIN  retailer_master ON retailer_master.id=customer_master.RetailerId WHERE  retailer_master.id='".$UserId."' ORDER BY CustomerName ASC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'</td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['CustomerName'].'</td>
                        <td>'.$value['CustomerMobile'].'</td>
                        <td>'.$value['CustomerEmail'].'</td>
                        <td>'.$value['RetailerName'].'</td>';

/*
<a class="btn btn-xs btn-warning" href="'.site_url('customer/customer_edit').'/?CustomerId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
*/
                        $result.='<td>
                              <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('customer/customer_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function customer_save() {

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];
        

        $CustomerName = $this->input->post('NewCustomerName');
        if($CustomerName==''){
            $CustomerName = $this->input->post('CustomerName');
        }

        $CustomerMobile = $this->input->post('CustomerMobile');
        $CustomerEmail = $this->input->post('CustomerEmail'); 
        $CustomerPassword = $CustomerMobile;       
        $RetailerId = $this->input->post('RetailerId');
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $datetime = date('Y-m-d H:i:s');
        $DoctorName = $this->input->post('DoctorName');
        $DoctorMobile = $this->input->post('DoctorMobile');
        $CustomerId = $CustomerMobile;

        $sql = "SELECT id FROM customer_master WHERE `CustomerName` = '$CustomerName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('CustomerId'=>$CustomerId,'StateId' => $StateId ,'CityId'=>$CityId,'CustomerName' => $CustomerName,'CustomerMobile'=>$CustomerMobile,'CustomerEmail'=>$CustomerEmail,'CustomerPassword'=>$CustomerPassword,'RetailerId'=>$UserId,'Address'=>$Address,'CreatedDateTime'=>$datetime,'DoctorName'=>$DoctorName,'DoctorMobile'=>$DoctorMobile);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('customer_master', $data_array);
        $insert_id = $this->db->insert_id();

        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$CustomerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$CustomerPassword."') , `LoginType`='5' ");


        $update_pass = $this->db->query("update customer_master set CustomerPassword=AES_ENCRYPT('".LOGIN_SALT."','".$CustomerPassword."') where id='$insert_id'");


        
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add customer id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_customer_details_by_id($CustomerId){
       $sql = "SELECT `customer_master`.`CustomerId`,`CustomerName`,`CustomerMobile`,`CustomerEmail`,state_master.StateName,city_master.CityName  
       FROM customer_master 
       INNER JOIN state_master ON state_master.id=customer_master.StateId 
       INNER JOIN city_master ON city_master.id=customer_master.CityId 
       WHERE customer_master.CustomerId='".$CustomerId."' ";
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


   public function customer_update() {
        $CityId = $this->input->post('CityId');
        $StateId = $this->input->post('StateId');
        $CustomerId = $this->input->post('CustomerId');
        $CustomerName = $this->input->post('CustomerName');
        
        $sql = "SELECT id FROM customer_master WHERE `CustomerName` = '$CustomerName' AND StateId='$StateId' AND CityId='$CityId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId'=>$StateId,'CityId'=>$CityId, 'CustomerName' => $CustomerName);
        $this->db->where('id',$CustomerId);
        $update = $this->db->update('customer_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Customer id = $CustomerId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function customer_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM customer_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_customer_count($id){
        $sql = "SELECT count(id) as num FROM customer_master WHERE RetailerId = '".$id."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return json_encode(array('status'=>'1','count'=>$result[0]['num']));
    }


    public function get_customer_list_json(){
       // $productname = $this->input->get('productname');
        //$sql = "SELECT id,ProductName,concat(ProductName,' (',Composition,') ') as product FROM product_master WHERE ProductName like '%".$productname."%' OR Composition like '%".$productname."%'";
        $sql = "SELECT CustomerId, CustomerName, CustomerMobile FROM customer_master WHERE 1";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $customernamemobile = strtoupper($d["CustomerName"]) .' ( '. $d["CustomerMobile"] .' ) ';
                    $result[] = array('value'=>$d["CustomerId"],'label'=>$customernamemobile);

                 }
                return $result;
            } else {
                return false;
            }
        }
    }

    public function checkmobileno(){
        $mobileno = $this->input->post('mobileno');

        $sql = "SELECT id,CustomerName FROM customer_master WHERE `CustomerMobile`='$mobileno'";
        $query = $this->db->query($sql);
        
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                return json_encode(array('status'=>'1','msg'=>'This No. already registered with <br><b style="color:#ff0000;">'.$data[0]['CustomerName'].'</b>.'));
            }else {
                return json_encode(array('status'=>'2','msg'=>''));
            }
                
        } else {
            return json_encode(array('status'=>'2','msg'=>''));
        }
    }



    // public function sync_customers_save(){
    //     $data = $this->input->post('customerlist');

    //     foreach ($data['customersdata'] as $key => $value) {
    //         $data['customersdata'][$key]['SyncStatus'] = '0';
    //     }
        
      
    //     $insert = $this->db->insert_batch('customer_master',$data['customersdata']);

    //     if($insert){

    //         $sql = "SELECT * FROM customer_master WHERE `RetailerId`='".$data['customersdata'][0]['RetailerId']."' AND `SyncStatus`='1' ";
    //         $query = $this->db->query($sql);
    //         if ($query->num_rows() > 0) {
    //             $customerids = $query->result_array();
    //         }
            
    //         foreach ($customerids as $key => $value) {
    //             $a[] = $value['CustomerId'];
    //         }
    //         $ids = join(',',$a);
            
    //         if(count($a)>0){
    //             return json_encode(array('status'=>'1','msg'=>'data inserted','customerids'=>$ids,'data'=>$customerids));
    //         }else{
    //             return json_encode(array('status'=>'2','msg'=>'No data to sync'));    
    //         }
    //     }else{
    //         return json_encode(array('status'=>'2','msg'=>'No data to sync'));
    //     }
    // }

    public function sync_customers_save(){
        $data = $this->input->post('customerlist');

        foreach ($data['customersdata'] as $key => $value) {
            $data['customersdata'][$key]['SyncStatus'] = '0';
        }
        
        $insert = $this->db->insert_batch('customer_master',$data['customersdata']);

        $passwordupdate = $this->db->query("UPDATE customer_master SET `CustomerPassword` = AES_ENCRYPT('".LOGIN_SALT."',`CustomerMobile`) WHERE  `CustomerPassword`='' ");

        foreach ($data['customersdata'] as $key => $value) {
            $customerids[] = $value['CustomerId'];
        }

        $ids = join(',',$customerids);

        if($insert){
            return json_encode(array('status'=>'1','msg'=>'data inserted','customerids' => $ids));
        }else{
            return json_encode(array('status'=>'2','msg'=>'No data to sync'));
        }
    }


} // class ends here
