<?php

class Stockist_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM stockist_master WHERE `StockistEmail`='".$loginname."' AND `StockistPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'stockist',
                        'user_roleid' => '2',
                        'user_name' => trim($datas[0]['StockistName'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Stockist Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_stockist_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT stockist_master.*,city_master.CityName,state_master.StateName FROM stockist_master LEFT JOIN state_master ON stockist_master.StateId=state_master.id LEFT JOIN city_master ON stockist_master.CityId=city_master.id WHERE 1 ORDER BY StockistName ASC";
        //$sql = "SELECT stockist_master.* FROM stockist_master  WHERE 1 ORDER BY StockistName ASC";
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.' <a class="btn btn-xs btn-warning" href="'.site_url('stockist/stockist_edit').'/?StockistId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
 <button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('stockist/stockist_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['StockistName'].'</td>
                        <td>'.$value['StockistContactNo'].'</td>
                        <td>'.$value['StockistEmail'].'</td>
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

    public function stockist_save() {
        
        $StockistName = $this->input->post('StockistName');
        $StockistContactNo = $this->input->post('StockistContactNo');
        $StockistEmail = $this->input->post('StockistEmail');
        $StockistPassword = $StockistContactNo;        
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
        
        $sql = "SELECT id FROM stockist_master WHERE `StockistName` = '$StockistName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'StockistName' => $StockistName,'StockistContactNo'=>$StockistContactNo,'StockistEmail'=>$StockistEmail,'StockistPassword'=>$StockistPassword,'DistributorId'=>$DistributorId,'CategoryId'=>$CategoryId,'HeadQtrId'=>$HeadQtrId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter,'PartyCode'=>$PartyCode,'PartyGroup'=>$PartyGroup,'UnderAcGroup'=>$UnderAcGroup,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('stockist_master', $data_array);
        $insert_id = $this->db->insert_id();


        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$StockistEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$StockistPassword."') , `LoginType`='2' ");


        $update_pass = $this->db->query("update stockist_master set StockistPassword=AES_ENCRYPT('".LOGIN_SALT."','".$StockistPassword."') where id='$insert_id'");

        
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


    public function get_stockist_details_by_id($StockistId){
        $sql = "SELECT `id`,`StockistName`,`StockistContactNo`,`StockistEmail`,`HeadQtrId`,`PanNo`,`TinNo`,`DLNo`,`LSTNo`,`CSTNo`,`GSTNo`,`TANNo`,`Transporter` FROM stockist_master WHERE id='".$StockistId."' ";
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


   public function stockist_update() 
   {
        $StockistName = $this->input->post('StockistName');
        $StockistContactNo = $this->input->post('StockistContactNo');
        $StockistEmail = $this->input->post('StockistEmail');
        $StockistPassword = $StockistContactNo;        
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
        $StockistId= $this->input->post('StockistId');
        
        $sql = "SELECT id FROM stockist_master WHERE `StockistName` = '$StockistName' AND StateId='$StateId' AND CityId='$CityId' And id!=$StockistId "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'StockistName' => $StockistName,'StockistContactNo'=>$StockistContactNo,'StockistEmail'=>$StockistEmail,'StockistPassword'=>$StockistPassword,'DistributorId'=>$DistributorId,'CategoryId'=>$CategoryId,'HeadQtrId'=>$HeadQtrId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'GSTNo'=>$GSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter);
        $this->db->where('id',$StockistId);
        $update = $this->db->update('stockist_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Stockist id = $StockistId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }





    public function stockist_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM stockist_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_stockist_by_distributorid($DistributorId){
        //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM stockist_master WHERE DistributorId='$DistributorId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select Stockist</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['StockistName']."</option>";
        }
        return $options;
    }

    public function get_stockist_by_city_id($CityId){
        //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM stockist_master WHERE CityId='$CityId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $options= "<option value=''>Select Stockist</option>";
        foreach ($result as $key => $value) {
            $options .="<option value = ".$value['id'].">".$value['StockistName']."</option>";
        }
        return $options;
    }


    public function get_stockist_count(){
        $sql = "SELECT count(id) as num FROM stockist_master WHERE DistributorId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return json_encode(array('status'=>'1','count'=>$result[0]['num']));
    }


    public function get_total_received_orders_amount(){
        $sql = "SELECT SUM(OrderTotalAmount) as totalamount 
        FROM orders_master_retailer WHERE StockistId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($query){
            return json_encode(Array("status" => "1", "totalamount" =>$result[0]['totalamount']));
        } else {
            return json_encode(Array("status" => "2", "totalamount" =>'0'));
        }
    }


    public function get_top_performing_stockist(){
        $result = array();
        $productsql = "SELECT 
                StockistId,
                sum(OrderTotalAmount) as amount            
                FROM  orders_master_stockist
                WHERE 1 
                GROUP BY StockistId
                order by amount DESC
                LIMIT 0,5";

        $productquery = $this->db->query($productsql);
        $productresult = $productquery->result_array();

        foreach ($productresult as $key => $value) {
            $result[$key] = $value;

            $prodnamesql = "SELECT stockist_master.StockistName, city_master.CityName
                            FROM stockist_master 
                            INNER JOIN city_master ON city_master.id=stockist_master.CityId
                            WHERE stockist_master.id='".$value['StockistId']."' ";
            $prodnamequery = $this->db->query($prodnamesql);
            $prodnameresult = $prodnamequery->result_array();
            $result[$key]['StockistName'] = $prodnameresult[0]['StockistName'];
            $result[$key]['CityName'] = $prodnameresult[0]['CityName'];

        }
        
        if(count($result)>0){
            return json_encode(Array("status" => "1", "data" =>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    public function get_stockist_all_details_by_id($StockistId){
        $sql = "SELECT * FROM stockist_master WHERE id='".$StockistId."' ";
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
    
     public function get_all_stockist($CityId)
     {
         //$StateId = $this->input->post('StateId');
        $sql = "SELECT * FROM stockist_master WHERE CityId='$CityId' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
       
        return $result;
    }
    
	public function get_total_retailers(){
		$UserId = $_SESSION['user_id'];
		$this->db->from('retailer_master');
		$this->db->where('StockistId',$UserId);
		$query=$this->db->get();
		return $query->num_rows();
		
	}
	
	public function get_recurring_retailers(){
		$UserId = $_SESSION['user_id'];
		$this->db->from('retailer_master');
		$this->db->where('StockistId',$UserId);
		$query=$this->db->get()->result();
		
		$recurring=0;
		foreach($query as $qr)
		{
			$customerId=$qr->id;		
			$this->db->from('orders_master_retailer');
			$this->db->where('StockistId',$customerId);
			$count=$this->db->get()->num_rows();
			if($count>0)
			{
				$recurring=$recurring+1;
			}
		return $recurring;
		}
	}    
    
    
    public function get_expiry_product()
    {
    	$UserId = $_SESSION['user_id'];
   	$UserRoleId = $_SESSION['user_roleid'];
   	$date=date('Y-m-d', strtotime("-90 days"));
    	$sql="SELECT product_stock_master.*,product_master_new.ProductName FROM  `product_stock_master` JOIN `product_master_new` ON (product_stock_master.ProductId=product_master_new.id) WHERE product_stock_master.Expiry <= $date AND product_stock_master.`UserId`='$UserId' AND product_stock_master.`UserRoleId`='$UserRoleId'";
    	$query = $this->db->query($sql);
    	if($query){
    		if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
                return false;
            }	
    	}
    	
    }
    
    
    public function get_out_of_stock_product()
    {
    	$UserId = $_SESSION['user_id'];
   	$UserRoleId = $_SESSION['user_roleid'];
    	$sql="SELECT SUM( product_stock_master.ProductQuantity ) as psum , product_stock_master.ProductId, product_master_new.ProductName FROM  `product_stock_master` Join product_master_new On (product_master_new.id = product_stock_master.ProductId) WHERE product_stock_master.UserRoleId ='$UserRoleId' AND product_stock_master.UserId ='$UserId' GROUP BY product_stock_master.ProductId";
    	$query = $this->db->query($sql);
    	if($query){
    		if ($query->num_rows() > 0) {    			
	                $result = $query->result_array();
	                $newresult=array();
                	foreach($result as $res)
                	{
                		if($res['psum']<=0 )
                		{
                			$newresult[]=$res;
                		}
                	
               		}
                return $newresult;
            } else {
                return false;
            }	
    	}
    	
    }
    
     public function forget_password_email_check()
   {
	$email=$this->input->post('email');		
   	$this->db->from('stockist_master');
   	$this->db->where('StockistEmail',$email);
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
		$name=$result['StockistName'];
		$email=$result['StockistEmail'];		
		//$sender_email = 'possupport@escomfort.com';
		//trim($shop->sender_email);
		$sender_name = '' ;
		$to =$email;		
		$subject ='';
		
		$message ='<p>Hi </p>'.$name.',';
		$message .='<p>We have recieved a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this link : </p><br><br>';
		$message .='<a href="'.site_url().'/stockist/reset_password/?forgetpassword_code='.$forgetpassword_code.'" style=" cursor:pointer; border: none;color: white;padding: 10px 32px;  text-align: center; text-decoration: none; display: inline-block;font-size:16px;text-align:center;background-color: #f44336;" class="btn btn-success">Reset Password</a>';
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
			$this->db->where('StockistEmail',$email);
			$update=$this->db->update('stockist_master',$data_array);
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
			$StockistPassword=$this->input->post('password');
			 $update_pass = $this->db->query("update stockist_master set StockistPassword=AES_ENCRYPT('".LOGIN_SALT."','".$StockistPassword."'), ForgetpasswordCode=''  where ForgetpasswordCode='".$cod."'");
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
		
		public function get_all_stockists()
		{
        	$sql = "SELECT * FROM `stockist_master`";
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
