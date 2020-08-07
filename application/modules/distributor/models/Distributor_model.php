<?php

class Distributor_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM distributor_master WHERE `DistributorEmail`='".$loginname."' AND `DistributorPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'distributor',
                        'user_roleid' => '1',
                        'user_name' => trim($datas[0]['DistributorName'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Distributor Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_distributor_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT distributor_master.*,city_master.CityName,state_master.StateName FROM distributor_master LEFT JOIN state_master ON distributor_master.StateId=state_master.id LEFT JOIN city_master ON distributor_master.CityId=city_master.id WHERE 1 ORDER BY DistributorName ASC";
        
        //$sql = "SELECT distributor_master.* FROM distributor_master WHERE 1 ORDER BY DistributorName ASC";
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
                        <td>'.$value['DistributorName'].'</td>
                        <td>'.$value['AssociationType'].'</td>
                        <td>'.$value['DistributorContactNo'].'</td>
                        <td>'.$value['DistributorEmail'].'</td>
                        <td>'.$value['TotalMargins'].'</td>
                        <td>'.$value['DSAMargins'].'</td>
                        <td>'.$value['OutgoingFreight'].'</td>
                        <td>'.$value['StockiestIncentives'].'</td>
                        <td>'.$value['FieldStaffSalary'].'</td>
                        <td>'.$value['FieldStaffExpenses'].'</td>
                        <td>'.$value['FieldStaffIncentives'].'</td>
                        <td>'.$value['FieldStaffPayrol'].'</td>
                        <td>'.$value['PaymentMode'].'</td>
                        <td>'.$value['TotalSalesPerson'].'</td>';

// 

                        $result.='<td><a class="btn btn-xs btn-warning" href="'.site_url('distributor/distributor_edit').'/?DistributorId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('distributor/distributor_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function distributor_save() {
        
        $DistributorName = $this->input->post('DistributorName');
        $AssociationType = $this->input->post('AssociationType');
        $DistributorEmail = $this->input->post('DistributorEmail');
        $DistributorContactNo = $this->input->post('DistributorContactNo');
        $DistributorPassword = $DistributorContactNo;
        $DistributorAddress = $this->input->post('DistributorAddress');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $TotalMargins = $this->input->post('TotalMargins');
        $DSAMargins = $this->input->post('DSAMargins');        
        $OutgoingFreight = $this->input->post('OutgoingFreight');
        $StockiestIncentives = $this->input->post('StockiestIncentives');
        $FieldStaffSalary = $this->input->post('FieldStaffSalary');
        $FieldStaffExpenses = $this->input->post('FieldStaffExpenses');
        $FieldStaffIncentives = $this->input->post('FieldStaffIncentives');
        $FieldStaffPayrol = $this->input->post('FieldStaffPayrol');
        $PaymentMode = $this->input->post('PaymentMode');
        $TotalSalesPerson = $this->input->post('TotalSalesPerson');
        $datetime = date('Y-m-d H:i:s');
        
        $sql = "SELECT id FROM distributor_master WHERE `DistributorName` = '$DistributorName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'DistributorName' => $DistributorName,'AssociationType'=>$AssociationType,'DistributorEmail'=>$DistributorEmail,'DistributorPassword'=>$DistributorPassword,'DistributorContactNo'=>$DistributorContactNo,'DistributorAddress'=>$DistributorAddress,'TotalMargins'=>$TotalMargins,'DSAMargins'=>$DSAMargins,'OutgoingFreight'=>$OutgoingFreight,'StockiestIncentives'=>$StockiestIncentives,'FieldStaffSalary'=>$FieldStaffSalary,'FieldStaffExpenses'=>$FieldStaffExpenses,'FieldStaffIncentives'=>$FieldStaffIncentives,'FieldStaffPayrol'=>$FieldStaffPayrol,'PaymentMode'=>$PaymentMode,'TotalSalesPerson'=>$TotalSalesPerson,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('distributor_master', $data_array);
        $insert_id = $this->db->insert_id();

        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$DistributorEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$DistributorPassword."') , `LoginType`='1' ");

        $update_pass = $this->db->query("update distributor_master set DistributorPassword=AES_ENCRYPT('".LOGIN_SALT."','".$DistributorPassword."') where id='$insert_id'");


        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add distributor id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_distributor_details_by_id($DistributorId){
        $sql = "SELECT `id`,`DistributorName`,`AssociationType`,`DistributorContactNo`,`DistributorEmail`,`TotalMargins`,`DSAMargins`,`OutgoingFreight`,`PaymentMode` FROM distributor_master WHERE id='".$DistributorId."' ";
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


   public function distributor_update() {

        $DistributorId = $this->input->post('DistributorId');
        $DistributorName = $this->input->post('DistributorName');
        $AssociationType = $this->input->post('AssociationType');
        $DistributorEmail = $this->input->post('DistributorEmail');
        $DistributorContactNo = $this->input->post('DistributorContactNo');
        $DistributorAddress = $this->input->post('DistributorAddress');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $TotalMargins = $this->input->post('TotalMargins');
        $DSAMargins = $this->input->post('DSAMargins');        
        $OutgoingFreight = $this->input->post('OutgoingFreight');
        $StockiestIncentives = $this->input->post('StockiestIncentives');
        $FieldStaffSalary = $this->input->post('FieldStaffSalary');
        $FieldStaffExpenses = $this->input->post('FieldStaffExpenses');
        $FieldStaffIncentives = $this->input->post('FieldStaffIncentives');
        $FieldStaffPayrol = $this->input->post('FieldStaffPayrol');
        $PaymentMode = $this->input->post('PaymentMode');
        $TotalSalesPerson = $this->input->post('TotalSalesPerson');
        $datetime = date('Y-m-d H:i:s');

        
        // $sql = "SELECT id FROM distributor_master WHERE `cDistributorName` = '$cDistributorName' AND StateId='$StateId' AND CityId='$CityId' "; //" AND `bActive`='0' 
        // $query = $this->db->query($sql);
        // if ($query) {
        //     if ($query->num_rows() > 0) {
        //         return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
        //     } 
        // }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'DistributorName' => $DistributorName,'AssociationType'=>$AssociationType,'DistributorEmail'=>$DistributorEmail,'DistributorContactNo'=>$DistributorContactNo,'DistributorAddress'=>$DistributorAddress,'TotalMargins'=>$TotalMargins,'DSAMargins'=>$DSAMargins,'OutgoingFreight'=>$OutgoingFreight,'StockiestIncentives'=>$StockiestIncentives,'FieldStaffSalary'=>$FieldStaffSalary,'FieldStaffExpenses'=>$FieldStaffExpenses,'FieldStaffIncentives'=>$FieldStaffIncentives,'FieldStaffPayrol'=>$FieldStaffPayrol,'PaymentMode'=>$PaymentMode,'TotalSalesPerson'=>$TotalSalesPerson,'CreatedDateTime'=>$datetime);

        
        $this->db->where('id',$DistributorId);
        $update = $this->db->update('distributor_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Distributor id = $DistributorId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }





    public function distributor_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM distributor_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_distributor_by_stateid($StateId){
        $StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM distributor_master WHERE StateId='$StateId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select Distributor</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['DistributorName']."</option>";
        }
        return $options;
    }

    public function get_total_received_orders_amount(){
        $sql = "SELECT SUM(OrderTotalAmount) as totalamount 
        FROM orders_master_stockist WHERE DistributorId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($query){
            return json_encode(Array("status" => "1", "totalamount" =>$result[0]['totalamount']));
        } else {
            return json_encode(Array("status" => "2", "totalamount" =>'0'));
        }
    }

    public function get_top_performing_distributors(){
        $result = array();
        $productsql = "SELECT 
                DistributorId,
                sum(OrderTotalAmount) as amount            
                FROM  orders_master_distributor 
                WHERE 1 
                GROUP BY DistributorId
                order by amount DESC
                LIMIT 0,5";

        $productquery = $this->db->query($productsql);
        $productresult = $productquery->result_array();

        foreach ($productresult as $key => $value) {
            $result[$key] = $value;

            $prodnamesql = "SELECT distributor_master.DistributorName, state_master.StateName
                            FROM distributor_master 
                            INNER JOIN state_master ON state_master.id=distributor_master.StateId
                            WHERE distributor_master.id='".$value['DistributorId']."' ";
            $prodnamequery = $this->db->query($prodnamesql);
            $prodnameresult = $prodnamequery->result_array();
            $result[$key]['DistributorName'] = $prodnameresult[0]['DistributorName'];
            $result[$key]['StateName'] = $prodnameresult[0]['StateName'];

        }
        
        if(count($result)>0){
            return json_encode(Array("status" => "1", "data" =>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }




} // class ends here
