<?php

class Retailer_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email',array(
       		'mailtype'  => 'html',
        	'newline'   => '\r\n'
		));
    }


  public function check_login() {
        $loginname = $this->input->post('loginname');
        $loginpassword = $this->input->post('loginpassword');
        $today = date('Y-m-d');

        if (!empty($loginname) && !empty($loginpassword)) {

        $sql = "SELECT * FROM retailer_master WHERE `RetailerEmail`='".$loginname."' AND `RetailerPassword` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') ";

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $data = array(
                        'user_id' => trim($datas[0]['id']),
                        'user_role' => 'retailer',
                        'user_roleid' => '3',
                        'RetailerId' => trim($datas[0]['id']),
                        'user_name' => trim($datas[0]['RetailerName']),
                        'AgentId' => trim($datas[0]['RetailerAsAgentId']),                        
                        'StockistId' => trim($datas[0]['StockistId'])
                        );

                        $this->session->set_userdata($data);

                    /***Activity Logs***/
                    save_activity_details('Retailer Login');
                    /***Activity Logs End***/

                    return true;
                } else {
                    return false;
                }
            }     
        }
    }


     public function get_retailer_list(){
        //$status = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $sql = "SELECT retailer_master.*,city_master.CityName,state_master.StateName,stockist_master.StockistName 
        FROM retailer_master LEFT JOIN state_master ON retailer_master.StateId=state_master.id 
         LEFT JOIN city_master ON retailer_master.CityId=city_master.id 
         LEFT JOIN stockist_master ON stockist_master.id=retailer_master.StockistId 
         WHERE 1 ORDER BY RetailerName ASC";

      
        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();
                    $i=1;

                    foreach ($datas as $key => $value) {

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.' <a class="btn btn-xs btn-warning" href="'.site_url('retailer/retailer_edit').'/?RetailerId='.$value["id"].'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a><button id="delete" onclick="deleterow(\''.$value["id"].'\',\''."row".$value["id"].'\',\''.site_url('retailer/retailer_delete').'\');" class="btn-xs btn-danger" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <td>'.$value['StateName'].'</td>
                        <td>'.$value['CityName'].'</td>
                        <td>'.$value['RetailerName'].'</td>
                        <td>'.$value['RetailerContactNo'].'</td>
                        <td>'.$value['RetailerEmail'].'</td>                        
                        <td>'.$value['StockistName'].'</td>
                        <td>'.$value['CategoryId'].'</td>                       
                        <td>'.$value['ContactPerson'].'</td>
                        <td>'.$value['ContactMobile'].'</td>
                        <td>'.$value['ContactEmail'].'</td>
                        <td>'.$value['PanNo'].'</td>
                        <td>'.$value['TinNo'].'</td>
                        <td>'.$value['DLNo'].'</td>
                        <td>'.$value['LSTNo'].'</td>
                        <td>'.$value['TANNo'].'</td>
                        <td>'.$value['CreditDays'].'</td>
                        <td>'.$value['CreditLimit'].'</td>
                        <td>'.$value['Transporter'].'</td>';

//
                        $result.='<td> </td>';


                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }

    public function retailer_save() {
        
        $RetailerName = $this->input->post('RetailerName');
        $RetailerContactNo = $this->input->post('RetailerContactNo');
        $RetailerEmail = $this->input->post('RetailerEmail'); 
        $RetailerPassword = $RetailerContactNo;       
        $DistributorId = '';
        $StockistId = $this->input->post('StockistId');
        $CategoryId = $this->input->post('CategoryId');
        $HeadQtrId = '';
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
        $TANNo = $this->input->post('TANNo');
        $CreditDays = $this->input->post('CreditDays');
        $CreditLimit = $this->input->post('CreditLimit');
        $Transporter = $this->input->post('Transporter');
        $PartyCode = '';
        $PartyGroup = '';
        $UnderAcGroup = '';
        $datetime = date('Y-m-d H:i:s');

        
        $this->db->trans_start();

        $sql = "SELECT id FROM retailer_master WHERE `RetailerName` = '$RetailerName'  AND StateId='$StateId' AND CityId='$CityId'"; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'RetailerName' => $RetailerName,'RetailerContactNo'=>$RetailerContactNo,'RetailerEmail'=>$RetailerEmail,'RetailerPassword'=>$RetailerPassword,'StockistId'=>$StockistId,'CategoryId'=>$CategoryId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter,'CreatedDateTime'=>$datetime);

        //return echoinsertdata('city_master', $data_array);

        $insert = $this->db->insert('retailer_master', $data_array);
        $insert_id = $this->db->insert_id();
        $AgentId = generate_orderid($insert_id);

        $userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='3' ");


        $update_pass = $this->db->query("update retailer_master set RetailerPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') where id='$insert_id'");

        /*********************************************************************************/

        $data_array_agent = array('AgentId'=>$AgentId,'StateId' => $StateId ,'CityId'=>$CityId,'AgentName' =>$RetailerName ,'AgentMobile'=>$RetailerContactNo,'AgentEmail'=>$RetailerEmail,'AgentPassword'=>$RetailerPassword,'RetailerId'=>$insert_id,'Address'=>$Address,'CreatedDateTime'=>$datetime,'SyncStatus'=>'0');

        //return echoinsertdata('city_master', $data_array);

        $insert_agent = $this->db->insert('agent_master', $data_array_agent);
        //$insert_id_agent = $this->db->insert_id();

        //$userloign = $this->db->query("INSERT login_master set `LoginEmail`='".$RetailerEmail."' ,  LoginPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') , `LoginType`='4' ");


        $update_pass = $this->db->query("update agent_master set AgentPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."') where AgentId='$AgentId'");

        /*********************************************************************************/        

        $update_pass = $this->db->query("update retailer_master set RetailerAsAgentId='".$AgentId."' where id='$insert_id'");

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE){
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        } else {
            /*             * *Activity Logs** */
            $msg = "Add retailer id = $insert_id";
            save_activity_details($msg);

            $msg = "Add Agent id = $AgentId";
            save_activity_details($msg);
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));            
        }
    }


    public function get_retailer_details_by_id($RetailerId){
      $sql = "SELECT `retailer_master`.`id`,`RetailerName`,`RetailerContactNo`,`RetailerEmail`,`PanNo`,`TinNo`,`DLNo`,`LSTNo`,`CSTNo`,`GSTNo`,`TANNo`,`Transporter`,`Address`, state_master.StateName,city_master.CityName 
       FROM retailer_master 
       INNER JOIN state_master ON state_master.id=retailer_master.StateId 
       INNER JOIN city_master ON city_master.id=retailer_master.CityId 
       WHERE retailer_master.id='".$RetailerId."' ";
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


   public function retailer_update() {
      $RetailerName = $this->input->post('RetailerName');
        $RetailerContactNo = $this->input->post('RetailerContactNo');
        $RetailerEmail = $this->input->post('RetailerEmail'); 
        $RetailerPassword = $RetailerContactNo;       
        $DistributorId = '';
        $StockistId = $this->input->post('StockistId');
        $CategoryId = $this->input->post('CategoryId');
        $HeadQtrId = '';
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
        $TANNo = $this->input->post('TANNo');
        $CreditDays = $this->input->post('CreditDays');
        $CreditLimit = $this->input->post('CreditLimit');
        $Transporter = $this->input->post('Transporter');
        $PartyCode = '';
        $PartyGroup = '';
        $UnderAcGroup = '';;
        $RetailerId = $this->input->post('RetailerId');
       
        
        $sql = "SELECT id FROM retailer_master WHERE `RetailerName` = '$RetailerName' AND StateId='$StateId' AND CityId='$CityId' AND id!=$RetailerId "; //" AND `bActive`='0' 
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(Array("status" => "2", "msg" => EXIST_MSG));
            } 
        }

        $data_array = array('StateId' => $StateId ,'CityId'=>$CityId,'RetailerName' => $RetailerName,'RetailerContactNo'=>$RetailerContactNo,'RetailerEmail'=>$RetailerEmail,'RetailerPassword'=>$RetailerPassword,'StockistId'=>$StockistId,'CategoryId'=>$CategoryId,'Address'=>$Address,'StateId'=>$StateId,'CityId'=>$CityId,'ContactPerson'=>$ContactPerson,'ContactMobile'=>$ContactMobile,'ContactEmail'=>$ContactEmail,'PanNo'=>$PanNo,'TinNo'=>$TinNo,'DLNo'=>$DLNo,'LSTNo'=>$LSTNo,'CSTNo'=>$CSTNo,'TANNo'=>$TANNo,'CreditDays'=>$CreditDays,'CreditLimit'=>$CreditLimit,'Transporter'=>$Transporter);
        $this->db->where('id',$RetailerId);
        $update = $this->db->update('retailer_master', $data_array);
        
        if ($update) {
            /*             * *Activity Logs** */
            $msg = "Update Retailer id = $RetailerId";
            save_activity_details($msg);
            
            /* * *Activity Logs End** */

            return json_encode(Array("status" => "1", "msg" => SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }





    public function retailer_delete(){
        $id = $this->input->post('id');
        $sql = "DELETE FROM retailer_master WHERE id = '$id'";
        $query = $this->db->query($sql);
        
        if($query){
            return json_encode(Array("status" => "1", "msg" => SUCCESS_DELETE_MSG));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }



    public function get_retailer_count(){
        $sql = "SELECT count(id) as num FROM retailer_master WHERE StockistId = '".$_SESSION['user_id']."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return json_encode(array('status'=>'1','count'=>$result[0]['num']));
    }



    public function get_top_performing_retailer(){
        $result = array();
        $productsql = "SELECT 
                RetailerId,
                sum(OrderTotalAmount) as amount            
                FROM  orders_master_retailer
                WHERE 1 
                GROUP BY RetailerId
                order by amount DESC
                LIMIT 0,5";

        $productquery = $this->db->query($productsql);
        $productresult = $productquery->result_array();

        foreach ($productresult as $key => $value) {
            $result[$key] = $value;

            $prodnamesql = "SELECT retailer_master.RetailerName, city_master.CityName 
                            FROM retailer_master 
                            INNER JOIN city_master ON city_master.id=retailer_master.CityId
                            WHERE retailer_master.id='".$value['RetailerId']."' ";
            $prodnamequery = $this->db->query($prodnamesql);
            $prodnameresult = $prodnamequery->result_array();
            $result[$key]['RetailerName'] = $prodnameresult[0]['RetailerName'];
            $result[$key]['CityName'] = $prodnameresult[0]['CityName'];
           //$result[$key]['sql'] = $prodnamesql;

        }
        
        if(count($result)>0){
            return json_encode(Array("status" => "1", "data" =>$result));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_total_retailers(){
        $sql = "SELECT count(id) as total FROM `retailer_master`";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return json_encode(Array("status" => "1", "data" =>$result[0]['total']));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }


    public function get_retailers_total_sale_value(){
        $sql = "SELECT SUM(OrderTotalAmount) as Amount FROM `orders_master_customer`";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return json_encode(Array("status" => "1", "data" =>$result[0]['Amount']));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_retailers_total_orders_count(){
        $sql = "SELECT count(id) as num FROM `orders_master_customer`";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return json_encode(Array("status" => "1", "data" =>$result[0]['num']));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }

    public function get_total_new_customers(){
        $sql = "SELECT count(id) as num FROM `customer_master`";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if($result){
            return json_encode(Array("status" => "1", "data" =>$result[0]['num']));
        } else {
            return json_encode(Array("status" => "2", "msg" => ERROR_MSG));
        }
    }
    
    public function get_retailer_all_details_by_id($RetailerId){
      $sql = "SELECT `retailer_master`.*, state_master.StateName,city_master.CityName 
       FROM retailer_master 
       INNER JOIN state_master ON state_master.id=retailer_master.StateId 
       INNER JOIN city_master ON city_master.id=retailer_master.CityId 
       WHERE retailer_master.id='".$RetailerId."' ";
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
    
    public function get_expiry_product()
    {
    	$UserId = $_SESSION['user_id'];
   	$UserRole = $_SESSION['user_roleid'];
   	$date=date('Y-m-d', strtotime("-90 days"));
    	$sql="SELECT product_stock_master.*,product_master_new.ProductName FROM  `product_stock_master` JOIN `product_master_new` ON (product_stock_master.ProductId=product_master_new.id) WHERE product_stock_master.Expiry <= $date AND product_stock_master.`UserId`='$UserId' AND product_stock_master.`UserRoleId`='$UserRole'";
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
   	$UserRole = $_SESSION['user_roleid'];
    	$sql="SELECT SUM( product_stock_master.ProductQuantity ) as psum , product_stock_master.ProductId, product_master_new.ProductName FROM  `product_stock_master` Join product_master_new On (product_master_new.id = product_stock_master.ProductId) WHERE product_stock_master.UserRoleId ='$UserRole' AND product_stock_master.UserId ='$UserId' GROUP BY product_stock_master.ProductId";
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
    
    public function get_all_stock_product()
    {
    	$UserId = $_SESSION['user_id'];
   	$UserRole = $_SESSION['user_roleid'];
    	$sql="SELECT SUM( product_stock_master.ProductQuantity ) as psum,SUM(product_stock_master.ProductQuantity<0) as totalsales , product_stock_master.ProductId, product_master_new.ProductName FROM  `product_stock_master` Join product_master_new On (product_master_new.id = product_stock_master.ProductId) WHERE product_stock_master.UserRoleId ='$UserRole' AND product_stock_master.UserId ='$UserId' GROUP BY product_stock_master.ProductId Order By SUM(product_stock_master.ProductQuantity<0) DESC ";
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
	
	
	public function get_total_customer(){
	$UserId = $_SESSION['user_id'];
		$this->db->from('customer_master');
		$this->db->where('RetailerId',$UserId);
		$query=$this->db->get();
		return $query->num_rows();
		
	}
	
	public function get_recurring_customer(){
	$UserId = $_SESSION['user_id'];
		$this->db->from('customer_master');
		$this->db->where('RetailerId',$UserId);
		$query=$this->db->get()->result();
		
		$recurring=0;
		foreach($query as $qr)
		{
			$customerId=$qr->id;		
			$this->db->from('orders_master_customer');
			$this->db->where('CustomerId',$customerId);
			$count=$this->db->get()->num_rows();
			if($count>0)
			{
				$recurring=$recurring+1;
			}
		
		
		return $recurring;
		
	}
}   
    
   public function forget_password_email_check()
   {
	$email=$this->input->post('email');		
   	$this->db->from('retailer_master');
   	$this->db->where('RetailerEmail',$email);
   	$query=$this->db->get();
   	$array=array();
   	if($query->num_rows())
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
			'msg'	=>'Mail Not Sent..Try Again..!!');
   	}
   	return json_encode($array);
   } 
   
   	
   	
   	function send_forget_password_mail($forgetpassword_code,$result)
	{	
		$name=$result['RetailerName'];
		$email=$result['RetailerEmail'];		
		//$sender_email = 'possupport@escomfort.com';
		//trim($shop->sender_email);
		$sender_name = '' ;
		$to =$email;		
		$subject ='';
		
		$message ='<p>Hi </p>'.$name.',';
		$message .='<p>We have recieved a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this link : </p><br><br>';
		$message .='<a href="'.site_url().'/retailer/reset_password/?forgetpassword_code='.$forgetpassword_code.'" style=" cursor:pointer; border: none;color: white;padding: 10px 32px;  text-align: center; text-decoration: none; display: inline-block;font-size:16px;text-align:center;background-color: #f44336;" class="btn btn-success">Reset Password</a>';
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
			$this->db->where('RetailerEmail',$email);
			$update=$this->db->update('retailer_master',$data_array);
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
			$RetailerPassword=$this->input->post('password');
			 $update_pass = $this->db->query("update retailer_master set RetailerPassword=AES_ENCRYPT('".LOGIN_SALT."','".$RetailerPassword."'), ForgetpasswordCode=''  where ForgetpasswordCode='".$cod."'");
			 if($this->db->affected_rows()>0){
				$array=array(
			'status'=>'success',
			'msg'	=>'Password Reset');
			 }
			 else{
			 $array=array(
			'status'=>'error',
			'msg'	=>'Link Expired');
			 }
			 return json_encode($array);
		}
		
	public function get_all_retailers($stockistid)
	{
        	$sql = "SELECT * FROM `retailer_master` WHERE StockistId='$stockistid'";
        	
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
