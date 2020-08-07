<?php

class Vendor_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function get_vendor_details_by_id_json(){
       
        $sql = "SELECT id,VendorName FROM vendor_master WHERE 1  ORDER BY VendorName ASC";
        $query = $this->db->query($sql);
        $result=array();
        if ($query) {
            if ($query->num_rows() > 0) {
                $data = $query->result_array();
                 foreach($data as $d) {
                        //$result.='<option value="'.$d["id"].'">'.$d["product"].'</option>';
                    $result[] = array('value'=>$d["id"],'label'=>$d["VendorName"]);

                 }
                return $result;
            } else {
                return false;
            }
        }
    }


  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM vendor_master WHERE `VendorEmail`='".$loginname."' AND `VendorPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'vendor',
                        'user_roleid' => '2',
                        'user_name' => trim($datas[0]['VendorName'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Vendor Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_vendor_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT vendor_master.*,city_master.CityName,state_master.StateName FROM vendor_master LEFT JOIN state_master ON vendor_master.StateId=state_master.id LEFT JOIN city_master ON vendor_master.CityId=city_master.id WHERE 1 ORDER BY VendorName ASC";
        //$sql = "SELECT vendor_master.* FROM vendor_master  WHERE 1 ORDER BY VendorName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.' <a class="btn btn-xs btn-warning" href="'.site_url('vendor/vendor_edit').'/?VendorId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
 <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('vendor/vendor_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['VendorName'].'</td>
                        <td>'.$value['VendorContactNo'].'</td>
                        <td>'.$value['VendorEmail'].'</td>
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


// 

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

    public function vendor_save() {
        
        $VendorName = $this->input->post('VendorName');
        $VendorContactNo = $this->input->post('VendorContactNo');
        $VendorEmail = $this->input->post('VendorEmail');
        $VendorPassword = $VendorContactNo;        
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
        
        $sql = "SELECT id FROM vendor_master WHERE `VendorName` = '$VendorName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'VendorName' => $VendorName,'VendorContactNo'=>$VendorContactNo,'VendorEmail'=>$VendorEmail,'VendorPassword'=>$VendorPassword,'DistributorId'=>$DistributorId,'CategoryId'=>$CategoryId,'HeadQtrId'=>$HeadQtrId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter,'PartyCode'=>$PartyCode,'PartyGroup'=>$PartyGroup,'UnderAcGroup'=>$UnderAcGroup,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('vendor_master', $data_array);
        $insert_id = $this->db->insert_id();


        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$VendorEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$VendorPassword."') , `LoginType`='2' ");


        $update_pass = $this->db->query("update vendor_master set VendorPassword=AES_ENCRYPT('".LOGIN_SALT."','".$VendorPassword."') where id='$insert_id'");

        
        if ($insert) {
            /*             * *Activity Logs** */
            $msg = "Add vendor id = $insert_id";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_vendor_details_by_id($VendorId){
        $sql = "SELECT `id`,`VendorName`,`VendorContactNo`,`VendorEmail`,`HeadQtrId`,`PanNo`,`TinNo`,`DLNo`,`LSTNo`,`CSTNo`,`GSTNo`,`TANNo`,`Transporter` FROM vendor_master WHERE id='".$VendorId."' ";
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


   public function vendor_update() 
   {
        $VendorName = $this->input->post('VendorName');
        $VendorContactNo = $this->input->post('VendorContactNo');
        $VendorEmail = $this->input->post('VendorEmail');
        $VendorPassword = $VendorContactNo;        
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
        $VendorId= $this->input->post('VendorId');
        
        $sql = "SELECT id FROM vendor_master WHERE `VendorName` = '$VendorName' AND StateId='$StateId' AND CityId='$CityId' And id!=$VendorId "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'VendorName' => $VendorName,'VendorContactNo'=>$VendorContactNo,'VendorEmail'=>$VendorEmail,'VendorPassword'=>$VendorPassword,'DistributorId'=>$DistributorId,'CategoryId'=>$CategoryId,'HeadQtrId'=>$HeadQtrId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter);
        $this->db->where('id',$VendorId);
        $update = $this->db->update('vendor_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Vendor id = $VendorId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }





    public function vendor_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM vendor_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_vendor_by_distributorid($DistributorId){
        //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM vendor_master WHERE DistributorId='$DistributorId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select Vendor</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['VendorName']."</option>";
        }
        return $options;
    }

    public function get_vendor_by_city_id($CityId){
        //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM vendor_master WHERE CityId='$CityId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select Vendor</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['VendorName']."</option>";
        }
        return $options;
    }


    public function get_vendor_count(){
        $sql = "SELECT count(id) as num FROM vendor_master WHERE DistributorId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return json_encode(array('status'=>'1','count'=>$result[0]['num']));
    }


    public function get_total_received_orders_amount(){
        $sql = "SELECT SUM(OrderTotalAmount) as totalamount 
        FROM orders_master_retailer WHERE VendorId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($query){
            return json_encode(Array("status" => "1", "totalamount" =>$result[0]['totalamount']));
        } else {
            return json_encode(Array("status" => "2", "totalamount" =>'0'));
        }
    }


    public function get_top_performing_vendor(){
        $result = array();
        $productsql = "SELECT 
                VendorId,
                sum(OrderTotalAmount) as amount            
                FROM  orders_master_vendor
                WHERE 1 
                GROUP BY VendorId
                order by amount DESC
                LIMIT 0,5";

        $productquery = $this->db->query($productsql);
        $productresult = $productquery->result_array();

        foreach ($productresult as $key => $value) {
            $result[$key] = $value;

            $prodnamesql = "SELECT vendor_master.VendorName, city_master.CityName
                            FROM vendor_master 
                            INNER JOIN city_master ON city_master.id=vendor_master.CityId
                            WHERE vendor_master.id='".$value['VendorId']."' ";
            $prodnamequery = $this->db->query($prodnamesql);
            $prodnameresult = $prodnamequery->result_array();
            $result[$key]['VendorName'] = $prodnameresult[0]['VendorName'];
            $result[$key]['CityName'] = $prodnameresult[0]['CityName'];

        }
        
        if(count($result)>0){
            return json_encode(Array("status" => "1", "data" =>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    public function get_vendor_all_details_by_id($VendorId){
        $sql = "SELECT * FROM vendor_master WHERE id='".$VendorId."' ";
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
    
     public function get_all_vendor($CityId)
     {
         //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM vendor_master WHERE CityId='$CityId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
       
        return $result;
    }
    

    
     public function forget_password_email_check()
   {
	$email=$this->input->post('email');		
   	$this->db->from('vendor_master');
   	$this->db->where('VendorEmail',$email);
   	$query=$this->db->get();
   	$array=array();
   	if($query->num_rows()>0)
   	{	
   		$result=$query->result_array();
   		$data=$result[0];
   		$forgetpassword_code=substr(md5(uniqid(rand(), true)), 10, 10);
		$date=date('Y-m-d H:i:s');
   		$data_array=array('ForgetpasswordCode'=>$forgetpassword_code,'ForgetpasswordTime'=>$date);
		$update=$this->update_forgetpasswordcode($data_array,$email,$data['id']);	
   		//$this->send_forget_password_mail($result[0]);
   		if($update)
		{
			$send_mail=$this->send_forget_password_mail($forgetpassword_code,$result[0]);
		}
		else{
			$array=array(
			'status'=>'success',
			'msg'	=>$this->db->last_query());
		}
		if($send_mail)
		{	
			$array=array(
			'status'=>'success',
			'msg'	=>'Mail Sent..!! Check Your Mail Inbox');
		}
		else
		{
			$array=array(
			'status'=>'error',
			'msg'	=>'Mail Not Sent..Try Again..!!');
		}
   		//return true;
   	}
   	else
   	{
   		 $array=array(
			'status'=>'error',
			'msg'	=>'No UserFound..!!');
   	}
   	return json_encode($array);
   } 
   
   	
   	
   	function send_forget_password_mail($forgetpassword_code,$result)
	{	
		$name=$result['VendorName'];
		$email=$result['VendorEmail'];		
		//$sender_email = 'possupport@escomfort.com';
		//trim($shop->sender_email);
		$sender_name = '' ;
		$to =$email;		
		$subject ='';
		
		$message ='<p>Hi </p>'.$name.',';
		$message .='<p>We have recieved a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this link : </p><br><br>';
		$message .='<a href="'.site_url().'/vendor/reset_password/?forgetpassword_code='.$forgetpassword_code.'" style=" cursor:pointer; border: none;color: white;padding: 10px 32px;  text-align: center; text-decoration: none; display: inline-block;font-size:16px;text-align:center;background-color: #f44336;" class="btn btn-success">Reset Password</a>';
		$message .='<p>Thanks,</p>';
		$message .='<p>DavaIndia Team</p>';	
		$this->email->from(FROM_EMAIL,'Davaindia');			
		
		$this->email->to($to); 
		$this->email->subject($subject);
		$this->email->message($message);	
		if($this->email->send()){
			return true;
		} else {
			return false;
		}
		
	}

		public function update_forgetpasswordcode($data_array,$email,$id)
		{
			$this->db->where('id',$id);
			$this->db->where('VendorEmail',$email);
			$update=$this->db->update('vendor_master',$data_array);
			if($update){
			return true;
			}
			else{
			return false;}
		}
		
		public function change_password()
		{
			$array='';
			$cod=$this->input->post('forgetpassword_code');
			$VendorPassword=$this->input->post('password');
			 $update_pass = $this->db->query("update vendor_master set VendorPassword=AES_ENCRYPT('".LOGIN_SALT."','".$VendorPassword."'), ForgetpasswordCode=''  where ForgetpasswordCode='".$cod."'");
			 if($this->db->affected_rows()>0){
				$array=array(
			'status'=>'success',
			'msg'	=>'Password Reset');
			 }
			 else{
			 $array=array(
			'status'=>'error',
			'msg'	=>'Link Expired..!!');
			 }
			 return json_encode($array);
		}
		
		public function get_all_vendors()
		{
        	$sql = "SELECT * FROM `vendor_master`";
        	$query = $this->db->query($sql);
        	$result = $query->result_array();
        	if($result)
        	{
            		return $result;
        	} 
        	else {
            		return false;
        	}
    		}
		
		
} // class ends here
