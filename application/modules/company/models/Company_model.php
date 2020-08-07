<?php

class Company_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_company_name_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT id,CompanyName FROM company_master WHERE id > 0 ORDER BY CompanyName ASC";
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
 
     public function company_save() {
        
        $CompanyName = $this->input->post('CompanyName');
        $CompanyContactNo = $this->input->post('CompanyContactNo');
        $CompanyEmail = $this->input->post('CompanyEmail');
        $CompanyPassword = $CompanyContactNo;        
        $DistributorId = '';//$this->input->post('DistributorId');
        $CategoryId = $this->input->post('CategoryId');
        $HeadQtrId = '';//$this->input->post('HeadQtrId');
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $ContactPerson = $this->input->post('ContactPerson');
        $ContactMobile = $this->input->post('ContactMobile');
        $ContactEmail = $this->input->post('ContactEmail');
        $PanNo = $this->input->post('PanNo');
        $TinNo = $this->input->post('TinNo');
        $DLNo = $this->input->post('DLNo');
        $LSTNo = $this->input->post('LSTNo');
        $CSTNo = $this->input->post('CSTNo');
        $GSTNo = $this->input->post('GSTNo');
        $TANNo = $this->input->post('TANNo');
        $CreditDays = $this->input->post('CreditDays');
        $CreditLimit = $this->input->post('CreditLimit');
        $Transporter = $this->input->post('Transporter');
        $PartyCode = '';//$this->input->post('PartyCode');
        $PartyGroup = '';//$this->input->post('PartyGroup');
        $UnderAcGroup = '';//$this->input->post('UnderAcGroup');
        $datetime = date('Y-m-d H:i:s');
        
        $sql = "SELECT id FROM company_master WHERE `CompanyName` = '$CompanyName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'CompanyName' => $CompanyName,'CompanyContactNo'=>$CompanyContactNo, 'CompanyEmail'=>$CompanyEmail,'CompanyPassword'=>$CompanyPassword,'CategoryId'=>$CategoryId,'Address'=>$Address,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('company_master', $data_array);
        $insert_id = $this->db->insert_id();


        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$CompanyEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$CompanyPassword."') , `LoginType`='2' ");


        $update_pass = $this->db->query("update company_master set CompanyPassword=AES_ENCRYPT('".LOGIN_SALT."','".$CompanyPassword."') where id='$insert_id'");

        
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add stockist id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

 /*
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
            /* * *Activity Logs** 
            $msg = "Add company id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** *

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    */
/*
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
*/

     public function get_company_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT company_master.*,city_master.CityName,state_master.StateName FROM company_master LEFT JOIN state_master ON company_master.StateId=state_master.id LEFT JOIN city_master ON company_master.CityId=city_master.id WHERE company_master.id > 0 ORDER BY CompanyName ASC";
        //$sql = "SELECT stockist_master.* FROM stockist_master  WHERE 1 ORDER BY StockistName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'<a class="btn btn-xs btn-warning" href="'.site_url('company/company_edit').'/?CompanyId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a><button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('company/company_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['CompanyName'].'</td>
                        <td>'.$value['CompanyContactNo'].'</td>
                        <td>'.$value['CompanyEmail'].'</td>
                        <td>'.$value['CategoryId'].'</td>
                        <td>'.$value['ContactPerson'].'</td>
                        <td>'.$value['ContactMobile'].'</td>
                        <td>'.$value['ContactEmail'].'</td>
                        <td>'.$value['PanNo'].'</td>
                        <td>'.$value['TinNo'].'</td>
                        <td>'.$value['DLNo'].'</td>
                        <td>'.$value['LSTNo'].'</td>
                        <td>'.$value['CSTNo'].'</td>
                        <td>'.$value['GSTNo'].'</td>
                        <td>'.$value['TANNo'].'</td>
                        <td>'.$value['CreditDays'].'</td>
                        <td>'.$value['CreditLimit'].'</td>
                        <td>'.$value['Transporter'].'</td>';


// <a class="btn btn-xs btn-warning" href="'.site_url('stockist/stockist_edit').'/?StockistId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>


                        $result.='<td>
                              
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
        $CompanyName = $this->input->post('CompanyName');
        $CompanyContactNo = $this->input->post('CompanyContactNo');
        $CompanyEmail = $this->input->post('CompanyEmail');
        $CompanyPassword = $CompanyContactNo;        
        $DistributorId = '';//$this->input->post('DistributorId');
        $CategoryId = $this->input->post('CategoryId');
        $HeadQtrId = '';//$this->input->post('HeadQtrId');
        $Address = $this->input->post('Address');
        $StateId = $this->input->post('StateId');
        $CityId = $this->input->post('CityId');
        $ContactPerson = $this->input->post('ContactPerson');
        $ContactMobile = $this->input->post('ContactMobile');
        $ContactEmail = $this->input->post('ContactEmail');
        $PanNo = $this->input->post('PanNo');
        $TinNo = $this->input->post('TinNo');
        $DLNo = $this->input->post('DLNo');
        $LSTNo = $this->input->post('LSTNo');
        $CSTNo = $this->input->post('CSTNo');
        $GSTNo = $this->input->post('GSTNo');
        $TANNo = $this->input->post('TANNo');
        $CreditDays = $this->input->post('CreditDays');
        $CreditLimit = $this->input->post('CreditLimit');
        $Transporter = $this->input->post('Transporter');
        $PartyCode = '';//$this->input->post('PartyCode');
        $PartyGroup = '';//$this->input->post('PartyGroup');
        $UnderAcGroup = '';//$this->input->post('UnderAcGroup');	
        $CompanyId= $this->input->post('CompanyId');
        $sql = "SELECT id FROM company_master WHERE `CompanyName` = '$CompanyName' AND StateId='$StateId' AND CityId='$CityId' AND `id`!=$CompanyId"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }
		
		 $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'CompanyName' => $CompanyName,'CompanyContactNo'=>$CompanyContactNo, 'CompanyEmail'=>$CompanyEmail,'CompanyPassword'=>$CompanyPassword,'CategoryId'=>$CategoryId,'Address'=>$Address,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter);
       
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
        $sql = "DELETE FROM company_master WHERE id = '$id' AND id > 0";
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
