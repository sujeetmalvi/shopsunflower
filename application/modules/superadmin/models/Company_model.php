<?php

class Company_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function company_save() 
	{        
        $CompanyName = $this->input->post('CompanyName');       
        $CompanyEmail = $this->input->post('CompanyEmail');     
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');                
        $ShortName = $this->input->post('ShortName');
        $DivisionId = $this->input->post('DivisionId');
        $Remark = $this->input->post('Remark');
        $Pincode = $this->input->post('Pincode');
        $ContactNumber = $this->input->post('ContactNumber');
        $datetime = date('Y-m-d H:i:s');        
        $sql = "SELECT id FROM company_master WHERE `CompanyName` = '$CompanyName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'CompanyName' => $CompanyName,'CompanyEmail'=>$CompanyEmail,'ShortName'=>$ShortName,'DivisionId'=>$DivisionId,'Remark'=>$Remark,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'Pincode'=>$Pincode,'ContactNumber'=>$ContactNumber,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('company_master', $data_array);
        $insert_id = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");
       
        if ($insert) {
            /* * *Activity Logs** */
            $msg = "Add company id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_company_list()
	{
       $sql = "SELECT company_master.*,city_master.CityName,state_master.StateName FROM `company_master` LEFT JOIN state_master ON company_master.StateId=state_master.id LEFT JOIN city_master ON company_master.CityId=city_master.id  ";        
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
                        <td>'.$value['CompanyName'].'</td>
                        <td>'.$value['ContactNumber'].'</td>
                        <td>'.$value['CompanyEmail'].'</td>                       
                        <td>'.$value['ShortName'].'</td>
                        <td>'.$value['DivisionId'].'</td>
                        <td>'.$value['Remark'].'</td>                     
                        <td>'.$value['Address'].'</td>
                        <td>'.$value['Pincode'].'</td>';

                        $result.='<td>
                             <a class="btn btn-xs btn-warning" href="'.site_url('retailer/company/company_edit').'/?CompanyId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('retailer/company/company_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
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


   public function company_update() {
        $CompanyId = $this->input->post('CompanyId');
        $CompanyName = $this->input->post('CompanyName');       
        $CompanyEmail = $this->input->post('CompanyEmail');     
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');                
        $ShortName = $this->input->post('ShortName');
        $DivisionId = $this->input->post('DivisionId');
        $Remark = $this->input->post('Remark');
        $Pincode = $this->input->post('Pincode');
        $contactNumber = $this->input->post('contactNumber');	
        
        $sql = "SELECT id FROM company_master WHERE `CompanyName` = '$CompanyName' AND StateId='$StateId' AND CityId='$CityId' AND `id`!=$CompanyId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
		
		 $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'CompanyName' => $CompanyName,'CompanyEmail'=>$CompanyEmail,'ShortName'=>$ShortName,'DivisionId'=>$DivisionId,'Remark'=>$Remark,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'Pincode'=>$Pincode,'contactNumber'=>$contactNumber);
       
        $this->db->where('id',$CompanyId);
        $update = $this->db->update('company_master', $data_array);
        
        if ($update) 
		{
            /* * *Activity Logs** */
            $msg = "Update Company id = $CompanyId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function company_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM company_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
	
	 public function get_company_details_by_id(){
		$CompanyId=$this->input->get('CompanyId');
       $sql = "SELECT company_master.*,city_master.CityName,state_master.StateName FROM `company_master` LEFT JOIN state_master ON company_master.StateId=state_master.id LEFT JOIN city_master ON company_master.CityId=city_master.id WHERE company_master.id=$CompanyId "; 
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
