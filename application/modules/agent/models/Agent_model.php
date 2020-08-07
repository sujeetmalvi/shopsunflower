<?php

class Agent_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }



  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM agent_master WHERE `AgentEmail`='".$loginname."' AND `AgentPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'agent',
                        'user_roleid' => '4',
                        'AgentId' => trim($datas[0]['AgentId']),
                        'user_name' => trim($datas[0]['AgentName']),
                        'RetailerId' => trim($datas[0]['RetailerId'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Agent Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_agent_list(){
        $UserId = $_SESSION['user_id'];
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT agent_master.*,city_master.CityName,state_master.StateName,retailer_master.RetailerName FROM agent_master LEFT JOIN state_master ON agent_master.StateId=state_master.id LEFT JOIN city_master ON agent_master.CityId=city_master.id LEFT JOIN  retailer_master ON retailer_master.id=agent_master.RetailerId WHERE retailer_master.id='".$UserId."' ORDER BY AgentName ASC";

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['AgentId'].'">';
                        $result.='<td>'.$i.'</td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['AgentName'].'</td>
                        <td>'.$value['AgentMobile'].'</td>
                        <td>'.$value['AgentEmail'].'</td>
                        <td>'.$value['RetailerName'].'</td>';

/*
<a class="btn btn-xs btn-warning" href="'.site_url('agent/agent_edit').'/?AgentId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
*/
                        $result.='<td>
                              <button id="delete" onclick="deleterow(\''.$value["AgentId"].'\',\''."row".$value["AgentId"].'\',\''.site_url('agent/agent_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function agent_save() {

        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];
        $UserRoleId = $_SESSION['user_roleid'];
        
        $AgentName = $this->input->post('AgentName');
        $AgentMobile = $this->input->post('AgentMobile');
        $AgentEmail = $this->input->post('AgentEmail'); 
        $AgentPassword = $AgentMobile;       
        //$RetailerId = $this->input->post('RetailerId');
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $datetime = date('Y-m-d H:i:s');
        $AgentId = generate_orderid($UserId);

        
        $sql = "SELECT id FROM agent_master WHERE `AgentName` = '$AgentName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('AgentId'=>$AgentId,'StateId' => $StateId ,'CityId'=>$CityId,'AgentName' => $AgentName,'AgentMobile'=>$AgentMobile,'AgentEmail'=>$AgentEmail,'AgentPassword'=>$AgentPassword,'RetailerId'=>$UserId,'Address'=>$Address,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('agent_master', $data_array);
        $insert_id = $this->db->insert_id();

        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$AgentEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$AgentPassword."') , `LoginType`='4' ");


        $update_pass = $this->db->query("update agent_master set AgentPassword=AES_ENCRYPT('".LOGIN_SALT."','".$AgentPassword."') where id='$insert_id'");


        
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add agent id = $AgentId";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_agent_details_by_id($AgentId){
       $sql = "SELECT `id`,`AgentName`,`AgentMobile`,`AgentEmail` FROM agent_master WHERE id='".$AgentId."' ";
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


   public function agent_update() {
        $CityId = $this->input->post('CityId');
        $StateId = $this->input->post('StateId');
        $AgentId = $this->input->post('AgentId');
        $AgentName = $this->input->post('AgentName');
        
        $sql = "SELECT AgentId FROM agent_master WHERE `AgentName` = '$AgentName' AND StateId='$StateId' AND CityId='$CityId' "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId'=>$StateId,'CityId'=>$CityId, 'AgentName' => $AgentName);
        $this->db->where('id',$AgentId);
        $update = $this->db->update('agent_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Agent id = $AgentId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function agent_delete(){
        $id = $this->input->post('AgentId');
        $sql = "DELETE FROM agent_master WHERE AgentId = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_agent_count($id){
        $sql = "SELECT count(id) as num FROM agent_master WHERE RetailerId = '".$id."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return json_encode(array('status'=>'1','count'=>$result[0]['num']));
    }


    public function get_agent_list_json(){
       // $productname = $this->input->get('productname');
        //$sql = "SELECT id,ProductName,concat(ProductName,' (',Composition,') ') as product FROM product_master WHERE ProductName like '%".$productname."%' OR Composition like '%".$productname."%'";
        $sql = "SELECT AgentId,AgentName FROM agent_master WHERE 1";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $result[] = array('value'=>$d["AgentId"],'label'=>$d["AgentName"]);
                 }
                return $result;
            } else {
                return false;
            }
        }
    }

    public function sync_save_agent_master_data(){
        $data = $this->input->post('agentdata');

        foreach ($data['agentdata'] as $key => $value) {
            $data['agentdata'][$key]['SyncStatus'] = '0';
        }
        
        $insert = $this->db->insert_batch('agent_master',$data['agentdata']);

        $passwordupdate = $this->db->query("UPDATE agent_master SET `AgentPassword` = AES_ENCRYPT('".LOGIN_SALT."',`AgentMobile`) WHERE  `AgentPassword`='' ");

        foreach ($data['agentdata'] as $key => $value) {
            $AgentIds[] = $value['AgentId'];
        }

        $ids = join(',',$AgentIds);

        if($insert){
            return json_encode(array('status'=>'1','msg'=>'data inserted','AgentIds' => $ids));
        }else{
            return json_encode(array('status'=>'2','msg'=>'No data to sync'));
        }
    }


} // class ends here
