<?php

class Webservice_model extends CI_Model {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->load->model('user/user_model');
    }
        
    /* ----------------------- Manager Rights ------------------------------- */
    
    // UPDATE UserMaster SET `Password` = AES_ENCRYPT('gCjhoT3wo253f8g56Dg4re8GS7DH3fgGDgRgfmo2f','123123')  WHERE `ContactNo`='9871539896' AND `DeviceId`='005b5255fef2dbd4' ;

   public function login() {
        $loginname = $this->input->post('contactno');
        $loginpassword = $this->input->post('password');
        $DeviceId = $this->input->post('deviceid');
        $today = date('Y-m-d');
        $data = array();
        $sql = "SELECT UserMaster.*,ShopName,GstinNo FROM UserMaster INNER JOIN ShopMaster ON ShopMaster.id=UserMaster.ShopId WHERE `ContactNo`='".$loginname."' AND `Password` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') AND `DeviceId`='$DeviceId' ";

        $shopsql = "SELECT FlagTitle,FlagSetValue FROM ShopSettings ";
        $shopdata = array();

        //return json_encode(array('status'=>false,'data'=>$sql));

        if (!empty($loginname) && !empty($loginpassword)) {

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    
                    $shopquery = $this->db->query($shopsql);
                    $shopdatas = $shopquery->result_array();
                    foreach($shopdatas as $s){
                        $shopdata[$s['FlagTitle']] = $s['FlagSetValue'];
                    }
                    $shopdata['ShopTimings'] = $shopdata['ShopStartTime'].' : '.$shopdata['ShopEndTime'];
                    

                    $datas = $query->result_array();

                    $UserType = $datas[0]['UserTypeId'];

                    if($UserType=='1'){ $UserTypeRole = 'Admin'; }

                    if($UserType=='2'){ $UserTypeRole = 'User'; }

                        $data = array(
                            'id' => trim($datas[0]['id']),
                            'ShopId' => trim($datas[0]['ShopId']),
                            'ShopName' => trim($datas[0]['ShopName']),
                            'ShopStatus'=>$shopdata['ShopStatus'],
                            'ShopTimings'=>$shopdata['ShopTimings'],
                            'GstinNo' => trim($datas[0]['GstinNo']),
                            'FullName' => trim($datas[0]['FullName']),
                            'EmailId' => trim($datas[0]['EmailId']),
                            'ContactNo' => trim($datas[0]['ContactNo']),
                            'UserType'=>$UserTypeRole
                            );

                    /***Activity Logs***/
                    save_activity_details('User Login');
                    /***Activity Logs End***/

                    return json_encode(array('status'=>true,'data'=>$data));
                } else {
                    return json_encode(array('status'=>false,'data'=>$data));
                }
            }     
        }
    }

  public function create_user() {
        $ShopId = $this->input->post('ShopId');
        $FullName = $this->input->post('FullName');
        $EmailId = $this->input->post('EmailId');
        $Password = $this->input->post('Password');
        $ContactNo = $this->input->post('ContactNo');
        $DeviceId = $this->input->post('DeviceId');
        $UserTypeId = $this->input->post('UserTypeId');
        $AgentName = $this->input->post('AgentName');
        $Termsandcondition = $this->input->post('Termsandcondition');
        $CreatedById = $this->input->post('CreatedById');
        $today = date('Y-m-d');
        
        $sql = "SELECT * FROM UserMaster WHERE `ContactNo`='".$ContactNo."' AND `EmailId`='".$EmailId."'";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(array('status'=>false,'msg'=>EXIST_MSG));            
            }
        }

        $data_array = array('ShopId'=>$ShopId,'FullName'=>$FullName,'EmailId'=>$EmailId,'Password'=>$Password,'ContactNo'=>$ContactNo,'DeviceId'=>$DeviceId,'UserTypeId'=>$UserTypeId,'AgentName'=>$AgentName,'Termsandcondition'=>$Termsandcondition,'CreatedById'=>$CreatedById,'CreatedDateTime'=>$today);

        $insert = $this->db->insert('UserMaster',$data_array);
        $insert_id = $this->db->insert_id();
        
        if($insert){
            
            $this->db->query("UPDATE UserMaster set `Password` = AES_ENCRYPT('".LOGIN_SALT."','".$Password."') WHERE `id`='".$insert_id."'");
                    
        /***Activity Logs***/
        save_activity_details('New User Created Id = '.$insert_id);
        /***Activity Logs End***/

            return json_encode(array('status'=>true,'msg'=>SUCCESS_INSERT_MSG,'UserId'=>$insert_id));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    }     

   public function create_shop() {
        $ShopName = $this->input->post('ShopName');
        $GstinNo = $this->input->post('GstinNo');
        $Address = $this->input->post('Address');
        $State = $this->input->post('State');
        $City = $this->input->post('City');
        $PinNumber = $this->input->post('PinNumber');
        $CreatedById = $this->input->post('CreatedById');
        $today = date('Y-m-d');
        
        $sql = "SELECT * FROM ShopMaster WHERE `GstinNo`='".$GstinNo."'";
        $query = $this->db->query($sql);
        if ($query) {
            if ($query->num_rows() > 0) {
                return json_encode(array('status'=>false,'msg'=>EXIST_MSG));            
            }
        }


        $data_array = array('ShopName'=>$ShopName,'GstinNo'=>$GstinNo,'Address'=>$Address,'State'=>$State,'City'=>$City,'PinNumber'=>$PinNumber,'CreatedById'=>$CreatedById,'CreatedDateTime'=>$today);

        $insert = $this->db->insert('ShopMaster',$data_array);
        $insert_id = $this->db->insert_id();
        if($insert){
                    
        /***Activity Logs***/
        save_activity_details('New Shop Created Id = '.$insert_id);
        /***Activity Logs End***/

            return json_encode(array('status'=>true,'msg'=>SUCCESS_INSERT_MSG,'ShopId'=>$insert_id));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    }     

    public function shop_list(){
        $result = array();
        $product_query = $this->db->query("SELECT id,ShopName FROM `ShopMaster` ");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 

    // public function filter_products(){

    //     $searchkey = $this->input->post('searchkey');

    //     $product_query = $this->db->query("SELECT id,ProductName FROM Product_master WHERE `ProductName` like '".$searchkey."%' ");

    //     $result = $product_query->result_array();

    //     if(count($result)>0){
    //         return json_encode(array('status'=>true,'data'=>$result));
    //     }else{
    //         return json_encode(array('status'=>false,'data'=>''));
    //     }

    // }

    public function category_list(){
        $result = array();
        $product_query = $this->db->query("SELECT id,CategoryName FROM `CategoryMaster` ");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }

    }   


    public function product_gallery(){
        $searchby = "";
        $searchby .= (isset($_POST['searchby']))?"AND (`ProductMaster`.`DesigneCode` LIKE '%".$_POST['searchby']."%' )  ":"";
        
    //SELECT ProductMaster.id as ProductId,ProductName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId FROM `ProductMaster` LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId WHERE VisibleStatus='1' GROUP BY DesigneCode
        $product_query = $this->db->query(" SELECT GROUP_CONCAT(DISTINCT(SizeCode) order by SizeName SEPARATOR ',') as Psize, 
                                            GROUP_CONCAT(DISTINCT(ColourName) order by colourName SEPARATOR ',') as Pcolour ,ProductMaster.id as ProductId,
                                            ProductName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId,IsOffer, OfferPrice  
                                            FROM `ProductMaster` 
                                            LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
                                            INNER JOIN SizeMaster ON SizeMaster.id = ProductMaster.SizeId 
                                            INNER JOIN ColourMaster ON ColourMaster.id = ProductMaster.ColourId 
                                            WHERE VisibleStatus='1' $searchby GROUP BY DesigneCode");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 
    
    public function product_gallery_details(){
        $DesigneCode = $this->input->post('DesigneCode');
        
        $product_query = $this->db->query("SELECT ProductMaster.id as ProductId,ProductName,SizeCode,ColourName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId 
            FROM `ProductMaster` 
            LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
            LEFT JOIN ColourMaster ON ColourMaster.id = ProductMaster.ColourId 
            LEFT JOIN SizeMaster ON SizeMaster.id = ProductMaster.SizeId  
            WHERE VisibleStatus='1' AND DesigneCode = '".$DesigneCode."' ");
            $stock_qr = array();
            
            $result = $product_query->result_array();
            $finaldata = array();
            foreach($result as $key => $res){
    
            //"SELECT SUM(ProductQty) as total,CONCAT(ProductId,ColourId,SizeId) as unikcode FROM `ProductStock` WHERE ProductId = '".$res['ProductId']."' GROUP BY unikcode ";
                $stock_qr = $this->db->query("SELECT SUM(ProductQty) as total,CONCAT(ProductId,ProductMaster.ColourId,ProductMaster.SizeId) as unikcode 
                                        FROM `ProductStock` 
                                        INNER JOIN ProductMaster ON ProductMaster.id=ProductStock.ProductId 
                                        WHERE ProductId = '".$res['ProductId']."'  AND `ProductStatus`='2' AND `DeliveredDateTime` = '0000-00-00 00:00:00' GROUP BY unikcode ");
                $qrresult = $stock_qr->result_array();
                if($qrresult){
                    $finaldata[$key] = $res;
                    $finaldata[$key]['stock'] = $qrresult[0]['total'];
                }else{
                    $finaldata[$key] = $res;
                    $finaldata[$key]['stock'] = 0;
                }
            }

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$finaldata,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 


    public function products_list_grouped(){

        $start = (isset($_POST['start']))?$_POST['start']:0;
        $count = (isset($_POST['count']))?$_POST['count']:10;
        $searchby = "";
        $result = array();
        $searchby .= (isset($_POST['searchby']))?"AND (`CategoryName` LIKE '%".$_POST['searchby']."%' OR `DesigneCode` LIKE '%".$_POST['searchby']."%' )  ":"";

        $product_query = $this->db->query("SELECT ProductMaster.id as ProductId,ProductName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId, IsOffer, OfferPrice 
            FROM `ProductMaster` 
            LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
            WHERE VisibleStatus='1' $searchby  GROUP BY DesigneCode  LIMIT $start,$count");
        $data = array();
        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    }

    public function products_list_all(){

        $start = (isset($_POST['start']))?$_POST['start']:0;
        $count = (isset($_POST['count']))?$_POST['count']:10;
        $CategoryId = (isset($_POST['CategoryId']))?$_POST['CategoryId']:'';
        $searchby = "";
        $CategoryId_filter="";
        $result = array();
        $searchby .= (isset($_POST['searchby']))?"AND (`CategoryName` LIKE '%".$_POST['searchby']."%' OR `DesigneCode` LIKE '%".$_POST['searchby']."%'  )  ":"";
        $group='';
        if($searchby==''){
            $group = ' GROUP BY DesigneCode ';
        }
        
        if($CategoryId!=''){
            $CategoryId_filter = " AND CategoryMaster.id = '".$CategoryId."' ";
        }

        $product_query = $this->db->query("SELECT ProductMaster.id as ProductId,ProductName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId,ColourName,ProductMaster.ColourId,SizeCode,ProductMaster.SizeId,IsOffer, OfferPrice,IsPreOrder 
            FROM `ProductMaster` 
            LEFT JOIN ColourMaster ON ProductMaster.ColourId = ColourMaster.id
            LEFT JOIN SizeMaster ON ProductMaster.SizeId = SizeMaster.id
            LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
            WHERE VisibleStatus='1' $searchby $CategoryId_filter  $group LIMIT $start,$count");
        $data = array();
        $result = $product_query->result_array();
        //foreach($result as $res){
            //$data[$res['DesigneCode']] = $res
        //}
        

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 
    
    


    public function product_images(){

        $ProductId = $this->input->post('ProductId');
        $DesigneCode = $this->input->post('DesigneCode');
        $ColourId = $this->input->post('ColourId');
        $DesigneCodeColourId = $DesigneCode.'~'.$ColourId;
    
        $result = array();
        $product_query = $this->db->query("SELECT ProductImage FROM `ProductImages` WHERE `ProductId`='$ProductId' OR `DesigneCodeColourId`='$DesigneCodeColourId'");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }

    }   


    public function product_stock(){
        
        $searchby = "";
        $searchby .= (isset($_POST['searchby']))?"AND (`ProductMaster`.`DesigneCode` LIKE '%".$_POST['searchby']."%' )  ":"";
        $searchby .= (isset($_POST['ProductId']))?"AND (`ProductMaster`.`id` LIKE '%".$_POST['ProductId']."%' )  ":"";
        $searchby .= (isset($_POST['ColourId']))?"AND (`ProductMaster`.`ColourId` LIKE '%".$_POST['ColourId']."%' )  ":"";
        
        $result = array();
        // $product_query = $this->db->query("SELECT ProductId, ProductStock.DesigneCode,SUM(ProductQty) as ProductQty,ColourMaster.ColourName,ColourMaster.id as ColourId,SizeMaster.SizeCode,SizeMaster.id as SizeId,ProductMaster.IsOffer,ProductMaster.OfferPrice,ProductMaster.OfferPercent 
        //                                     FROM `ProductStock` 
        //                                     JOIN ProductMaster ON ProductStock.ProductId = ProductMaster.id
        //                                     LEFT JOIN ColourMaster ON ProductStock.ColourId = ColourMaster.id
        //                                     LEFT JOIN SizeMaster ON ProductStock.SizeId = SizeMaster.id WHERE 1 AND `ProductStatus`='1' $searchby
        //                                     GROUP BY ProductStock.ProductId,ProductStock.ColourId,ProductStock.SizeId ORDER BY ProductStock.ProductId ASC");
        
        
        $product_query = $this->db->query("SELECT ProductId, ProductMaster.DesigneCode,SUM(ProductQty) as ProductQty,ColourMaster.ColourName,ColourMaster.id as ColourId,SizeMaster.SizeCode,SizeMaster.id as SizeId,ProductMaster.IsOffer,ProductMaster.OfferPrice,ProductMaster.OfferPercent 
                FROM `ProductStock` 
                left JOIN ProductMaster ON ProductStock.ProductId = ProductMaster.id
                LEFT JOIN ColourMaster ON ProductMaster.ColourId = ColourMaster.id
                LEFT JOIN SizeMaster ON ProductMaster.SizeId = SizeMaster.id WHERE `ProductStatus`='2' AND OrderId=0 AND StockType='1' AND VisibleStatus='1'  $searchby
                GROUP BY ProductStock.ProductId,ProductMaster.ColourId,ProductMaster.SizeId ORDER BY ProductMaster.id ASC");
                                            
        // $product_query = $this->db->query("SELECT 
        //                                     COALESCE(ProductId,0) as ProductId, 
        //                                     COALESCE(ProductStock.DesigneCode,0) as DesigneCode,
        //                                     COALESCE(SUM(ProductQty),0) as ProductQty,
                                            
        //                                     COALESCE(SizeMaster.SizeCode,0) as SizeCode,
        //                                     COALESCE(SizeMaster.id,0) as SizeId,
        //                                     COALESCE(ProductMaster.IsOffer,0) as IsOffer,
        //                                     COALESCE(ProductMaster.OfferPrice,0) as OfferPrice,
        //                                     COALESCE(ProductMaster.OfferPercent,0) as OfferPercent
        //                                     FROM `ProductStock` 
        //                                     JOIN ProductMaster ON ProductStock.ProductId = ProductMaster.id
                                            
        //                                     RIGHT JOIN SizeMaster ON ProductStock.SizeId = SizeMaster.id
        //                                     WHERE 1 AND `ProductStatus`='1' $searchby
        //                                     ORDER BY ProductStock.ProductId ASC");
        $result = $product_query->result_array();
        if(count($result)<=0){ return json_encode(array('status'=>false,'msg'=>'No stock found.')); }
        foreach($result as $key => $val){
            //$arr[$val['ProductId']][$val['SizeId']] = 
            $arr[] = $val;
            /*
            if(!isset($arr[$val['ProductId']][1])){
                $arr[$val['ProductId']][1] = array(
                                            "ProductId"=>$val['ProductId'],
                                            "DesigneCode"=>$val['DesigneCode'],
                                            "ProductQty"=>'0',
                                            "ColourName"=>$val['ColourName'],
                                            "ColourId"=>$val['ColourId'],
                                            "SizeCode"=>'M',
                                            "SizeId"=>'1',
                                            "IsOffer"=>0,
                                            "OfferPrice"=>"0.00",
                                            "OfferPercent"=>"0.00");
            } 
            if(!isset($arr[$val['ProductId']][2])){
                $arr[$val['ProductId']][2] = array(
                                            "ProductId"=>$val['ProductId'],
                                            "DesigneCode"=>$val['DesigneCode'],
                                            "ProductQty"=>'0',
                                            "ColourName"=>$val['ColourName'],
                                            "ColourId"=>$val['ColourId'],
                                            "SizeCode"=>'XL',
                                            "SizeId"=>'2',
                                            "IsOffer"=>0,
                                            "OfferPrice"=>"0.00",
                                            "OfferPercent"=>"0.00");
            } 
        */
            
        }
        
        //return json_encode($arr); 
        /*
        
        foreach($arr as $k => $v){
            $res[] = $v[1]; 
            $res[] = $v[2];
        }
        */

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$arr));
        }else{
            return json_encode(array('status'=>false,'data'=>$arr));
        }
    }    
    
    
   public function add_to_cart() {
        $UserId = $this->input->post('UserId');
        //$ProductId = $this->input->post('ProductId');
        $DesigneCode = $this->input->post('DesigneCode');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $ColourId  = $this->input->post('ColourId');
        $SizeId  = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $Price = $this->input->post('Price');

        //$CurrentStock = $this->input->post('CurrentStock');
        
        $p_productid = $this->db->query("SELECT id FROM ProductMaster Where ColourId='".$ColourId."' AND SizeId='".$SizeId."' AND DesigneCode='".$DesigneCode."'")->row();
        $ProductId = $p_productid->id;
        
        $check_prod_in_cart_query = $this->db->query("SELECT count(ProductId) as stock FROM `UsersCart` WHERE `DesigneCode`='$DesigneCode' AND `UserId`='$UserId' AND `SizeId`='$SizeId' AND `ColourId`='$ColourId' AND `OrderType`='$OrderType' ")->row();

        if($check_prod_in_cart_query->stock>0){
            return json_encode(array('status'=>false,'msg'=>'Product Already in Cart.','ordtyp'=>$OrderType,'s'=>$check_prod_in_cart_query->stock));
        }
        
        
        $chk_stock = $this->db->query("SELECT COUNT(ProductQty) as qty,concat(ProductId,'-',PM.ColourId,'-',PM.SizeId) as unq FROM ProductStock PS INNER JOIN ProductMaster PM ON PS.ProductId=PM.id WHERE ProductStatus='2' AND StockType='1' AND OrderId=0 AND PM.DesigneCode='".$DesigneCode."' AND PM.ColourId='".$ColourId."' AND PM.SizeId='".$SizeId."' GROUP BY unq having qty>0")->row();
        
        $CurrentStock = (isset($chk_stock->qty))?$chk_stock->qty:0;
        if($CurrentStock<$OrderQuantity && $OrderType == '1'){
          return json_encode(array('status'=>false,'msg'=>'Order Out OF Stock','currstk'=>$CurrentStock,'ordqty'=>$OrderQuantity,'ordtyp'=>$OrderType));  
        }

        $CreatedDateTime = date('Y-m-d H:i:s');
        $data_array = array('DesigneCode'=>$DesigneCode, 'UserId'=>$UserId,'OrderQuantity'=>$OrderQuantity,'ProductId'=>$ProductId , 'ColourId'=>$ColourId,'SizeId'=>$SizeId,'Price'=>$Price,'OrderType'=>$OrderType,'CreatedDateTime'=>$CreatedDateTime);

        $insert = $this->db->insert('UsersCart',$data_array);
        $qry = $this->db->last_query();
        $insert_id = $this->db->insert_id();
        if($insert){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_INSERT_MSG,'stk'=>$CurrentStock,'oq'=>$OrderQuantity));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 

   public function update_to_cart() {
        $UserId = $this->input->post('UserId');
        $ProductId = $this->input->post('ProductId');
        $DesigneCode = $this->input->post('DesigneCode');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $ColourId  = $this->input->post('ColourId');
        $SizeId  = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $Price = $this->input->post('Price');
        $CreatedDateTime = date('Y-m-d H:i:s');
        $CurrentStock = $this->input->post('CurrentStock');
        
        if($CurrentStock<$OrderQuantity && $OrderType == '1'){
          return json_encode(array('status'=>false,'msg'=>'Order Out Of Stock'));  
        }
        
        $data_array = array('UserId'=>$UserId,'ProductId'=>$ProductId,'DesigneCode'=>$DesigneCode,'OrderQuantity'=>$OrderQuantity,'ColourId'=>$ColourId,'SizeId'=>$SizeId,'Price'=>$Price,'CreatedDateTime'=>$CreatedDateTime);

        $this->db->where('UserId',$UserId);
        $this->db->where('ProductId',$ProductId);
        $this->db->where('OrderType',$OrderType);
        $this->db->where('ColourId',$ColourId);
        $this->db->where('SizeId',$SizeId);
        
        $update = $this->db->update('UsersCart',$data_array);

        if($update){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_UPDATE_MSG,'data'=>$_POST));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 

   public function delete_from_cart() {
        $UserId = $this->input->post('UserId');
        $DesigneCode = $this->input->post('DesigneCode');
        $OrderType = $this->input->post('OrderType');
        $ColourId = $this->input->post('ColourId');
        $SizeId = $this->input->post('SizeId');

        $this->db->where('UserId',$UserId);
        $this->db->where('DesigneCode',$DesigneCode);
        $this->db->where('OrderType',$OrderType);
        $this->db->where('ColourId',$ColourId);
        $this->db->where('SizeId',$SizeId);
        $update = $this->db->delete('UsersCart');

        if($update){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_DELETE_MSG));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 

    public function cart_products_count(){
        $UserId = $this->input->post('UserId');
        
        $query = $this->db->query("SELECT count(id) as num,SUM(OrderQuantity) as total FROM `UsersCart` WHERE `UserId`='$UserId'");

        $result = $query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result[0]['total'],'total'=>$result[0]['num']));
        }else{
            return json_encode(array('status'=>false,'data'=>'0'));
        }
    }

//   public function add_to_cart() {
//         $UserId = $this->input->post('UserId');
//         $ProductId = $this->input->post('ProductId');
//         $NormalOrderQuantity = $this->input->post('NormalOrderQuantity');
//         $PreOrderQuantity = $this->input->post('PreOrderQuantity');
//         $ColourId  = $this->input->post('ColourId');
//         $SizeId  = $this->input->post('SizeId');

//         $CreatedDateTime = date('Y-m-d H:i:s');
//         $data_array = array('UserId'=>$UserId,'ProductId'=>$ProductId,'NormalOrderQuantity'=>$NormalOrderQuantity,'PreOrderQuantity'=>$PreOrderQuantity,'ColourId'=>$ColourId,'SizeId'=>$SizeId,'CreatedDateTime'=>$CreatedDateTime);

//         $insert = $this->db->insert('UsersCart',$data_array);
//         $qry = $this->db->last_query();
//         $insert_id = $this->db->insert_id();
//         if($insert){
//             return json_encode(array('status'=>true,'msg'=>SUCCESS_INSERT_MSG));
//         } else {
//             return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
//         }
//     } 

//   public function update_to_cart() {
//         $UserId = $this->input->post('UserId');
//         $ProductId = $this->input->post('ProductId');
//         $NormalOrderQuantity = $this->input->post('NormalOrderQuantity');
//         $PreOrderQuantity = $this->input->post('PreOrderQuantity');
//         $ColourId  = $this->input->post('ColourId');
//         $SizeId  = $this->input->post('SizeId');
//         $CreatedDateTime = date('Y-m-d H:i:s');
        
//         $data_array = array('NormalOrderQuantity'=>$NormalOrderQuantity,'PreOrderQuantity'=>$PreOrderQuantity,'ColourId'=>$ColourId,'SizeId'=>$SizeId,'CreatedDateTime'=>$CreatedDateTime);

//         $this->db->where('UserId',$UserId);
//         $this->db->where('ProductId',$ProductId);
//         $update = $this->db->update('UsersCart',$data_array);

//         if($update){
//             return json_encode(array('status'=>true,'msg'=>SUCCESS_UPDATE_MSG));
//         } else {
//             return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
//         }
//     } 

//   public function delete_from_cart() {
//         $UserId = $this->input->post('UserId');
//         $ProductId = $this->input->post('ProductId');

//         $this->db->where('UserId',$UserId);
//         $this->db->where('ProductId',$ProductId);
//         $update = $this->db->delete('UsersCart');

//         if($update){
//             return json_encode(array('status'=>true,'msg'=>SUCCESS_DELETE_MSG));
//         } else {
//             return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
//         }
//     } 

    public function offers_list() {
        $result = array();
        $query = $this->db->query("SELECT ProductMaster.*,ColourMaster.ColourName,SizeMaster.SizeCode 
                                    FROM `ProductMaster` 
                                    INNER JOIN ColourMaster ON ProductMaster.ColourId = ColourMaster.id
                                    INNER JOIN SizeMaster ON ProductMaster.SizeId = SizeMaster.id
                                    WHERE `Isoffer` = ' 1' ");
        $result = $query->result_array();
        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    }
    
    


    public function cart_list() {
       $result = array();
        $UserId = $this->input->post('UserId');
        $query = $this->db->query("SELECT UsersCart.*,ProductMaster.ProductThumbnail,ProductMaster.DesigneCode,ProductMaster.ProductPrice,ColourMaster.ColourName,SizeMaster.SizeCode 
                                    FROM `UsersCart` 
                                    INNER JOIN ProductMaster ON ProductMaster.id=UsersCart.ProductId
                                    INNER JOIN ColourMaster ON UsersCart.ColourId = ColourMaster.id
                                    INNER JOIN SizeMaster ON UsersCart.SizeId = SizeMaster.id
                                    WHERE `UserId`='$UserId'");
        $result = $query->result_array();
        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 
    
    public function stock_confirmation_for_booking($UserId=''){
        
        $UserId = ($UserId=='')?$this->input->post('UserId'):$UserId;
        $short = array();
        $query = $this->db->query("SELECT UsersCart.* FROM `UsersCart` WHERE `UserId`='$UserId'");
        $result = $query->result_array();
            if(count($result)>0){
                foreach($result as $k => $res){
                    if($res['OrderType']=='1'){
                        $chk_stock = $this->db->query("SELECT COUNT(ProductQty) as qty,concat(PM.id,'-',PM.ColourId,'-',PM.SizeId) as unq FROM ProductStock PS INNER JOIN ProductMaster PM ON PS.ProductId=PM.id WHERE ProductStatus='2' AND StockType='1' AND OrderId=0 AND PM.DesigneCode='".$res['DesigneCode']."' AND PM.ColourId='".$res['ColourId']."' AND PM.SizeId='".$res['SizeId']."' GROUP BY unq having qty>0")->row();
                        if($chk_stock != null){
                            if($chk_stock->qty<$res['OrderQuantity']){
                                $short[] = array('ProductId'=>$res['ProductId'],'ColourId'=>$res['ColourId'],'SizeId'=>$res['SizeId'],'OrderQuantity'=>$res['OrderQuantity'],'AvailableQty'=>$chk_stock->qty);
                            }
                        }else{
                            $short[] = array('ProductId'=>$res['ProductId'],'ColourId'=>$res['ColourId'],'SizeId'=>$res['SizeId'],'OrderQuantity'=>$res['OrderQuantity'],'AvailableQty'=>0);
                        }
                    }
                }
            }
        if(count($short)>0){    
            return $short;    
        }else{
            return 0;
        }
            
    }
    
    public function book_order() {
        $result = array();
        $UserId = $this->input->post('UserId');
        $OrderType = $this->input->post('OrderType');
        $CreatedDateTime = date('Y-m-d H:i:s');
        $OrderId = strtotime(date('Y-m-d H:i:s'));
        $Comment = $this->input->post('Comment');
        
        $order_table = "<table border='1' cellpadding='10' & cellspacing='0'><tr><th>DesigneCode</th><th>Colour</th><th>Size</th><th>OrderType</th><th>OrderQuantity</th></tr>";
        
        $amount = 0;
        if($OrderType=='3'){
            
            $Price = $this->input->post('Price');
            $ColourId = $this->input->post('ColourId');
            //$SizeId = $this->input->post('SizeId');
            $DesigneCode = $this->input->post('DesigneCode');
            
            $p_productid = $this->db->query("SELECT id,SizeId FROM ProductMaster Where ColourId='".$ColourId."' AND DesigneCode='".$DesigneCode."'")->row();
            $ProductId = $p_productid->id;
            $SizeId = $p_productid->SizeId;
            
            //$ProductId = $this->input->post('ProductId');
            $OrderQuantity = $this->input->post('OrderQuantity');

                        $data = array(
                            'UserId' => $UserId,
                            'DesigneCode' => $DesigneCode,
                            'ProductId' => $ProductId,
                            'Price' => $Price,
                            'ColourId' => $ColourId,
                            'SizeId' => $SizeId,
                            'OrderType' => $OrderType,
                            'OrderQuantity' => $OrderQuantity,
                            'OrderId' => $OrderId,
                            'OrderedDateTime' => $CreatedDateTime
                        );
                        
                $Size_name = $this->db->query("SELECT SizeName FROM SizeMaster Where id='".$SizeId."'")->row();
                $Colour_name = $this->db->query("SELECT ColourName FROM ColourMaster Where id='".$ColourId."'")->row();
                $OrderType_name = $_SERVER['ORDERTYPE'][$OrderType];
                        
                $order_table .= "<tr><td>$DesigneCode</td><td>".$Colour_name->ColourName."</td><td>".$Size_name->SizeName."</td><td>$OrderType_name</th><th>$OrderQuantity</td></tr></table>";                    
                    
                $insert = $this->db->insert('ProductOrders', $data);
                $amount = $Price*$OrderQuantity;
                $data_summary = array(
                        'OrderId' => $OrderId,
                        'UserId' => $UserId,
                        'Amount' => $amount,
                        'Quantity'=>$OrderQuantity,
                        'Comment' => $Comment,
                        'OrderedDateTime' => $CreatedDateTime
                    );
                $insert = $this->db->insert('ProductOrdersSummary', $data_summary);
                $insert_id = $this->db->insert_id();
                    if($insert){
                        $upload_res = upload_image($insert_id, 'cust_order_img', 'COI_','custom_orders');
                        $this->db->update('ProductOrdersSummary', array('custom_order_image'=>$upload_res['filename']), array('id' => $insert_id));
                        
                    $shopquery = $this->db->query("SELECT FlagTitle,FlagSetValue FROM ShopSettings ");
                    $shopdatas = $shopquery->result_array();    
                    foreach($shopdatas as $s){
                        $shopdata[$s['FlagTitle']] = $s['FlagSetValue'];
                    }
                    $user_details = $this->user_model->get_user_details_by_id($UserId);
                    send_mail_simple($user_details['EmailId'],$shopdata['ShopSendEmailFrom'],'Sunflower- Order Booked - '.$OrderId.'.','Dear Customer,<br> Your order with OrderId -<b>'.$OrderId.'</b> has been booked successfully. <br><br>'.$order_table.'<br>Thanks,<br> Sunflower');
                        
                        return json_encode(array('status'=>true,'msg'=>'Order booked successfully','OrderId'=>$OrderId,'Amount'=>$amount,'img'=>$upload_res));
                    }else {
                        return json_encode(array('status'=>false,'msg'=>'Some error occured.','img'=>$upload_res));
                    }
            
        }else{
                $query = $this->db->query("SELECT * FROM `UsersCart` WHERE `UserId`='$UserId'");
                $result = $query->result_array();
                $amount = 0;
                $quantity = 0;
                $update_stock_arr = array();
                if(count($result)>0){
                    foreach($result as $k => $res){
                        
                        if($res['OrderType']=='1'){
                            $qry_productUIC = $this->db->query("SELECT substring_index(group_concat(PS.id SEPARATOR ','), ',', ".$res['OrderQuantity'].") as id,substring_index(group_concat(PS.ProductUIC SEPARATOR ','), ',', ".$res['OrderQuantity'].") as UIC FROM ProductStock PS INNER JOIN ProductMaster PM ON PS.ProductId=PM.id WHERE ProductStatus='2' AND StockType='1' AND OrderId=0 AND PM.DesigneCode='".$res['DesigneCode']."' AND PM.ColourId='".$res['ColourId']."' AND PM.SizeId='".$res['SizeId']."' ");
                            $res_productUIC = (array) $qry_productUIC->row();
                            
                            // condition for stock 
                            $stock_chk = $this->stock_confirmation_for_booking($UserId);
                            if($stock_chk!=0){
                                return json_encode(array('status'=>false,'msg'=>'Out of Stock','stock'=>$stock_chk));
                            }
                        }
                        

                        if($res['OrderType']=='1'){
                            
                            $ProductUIC = (isset($res_productUIC['UIC']))?$res_productUIC['UIC']:'';
                            if($res_productUIC['UIC']!=''){
                                $update_stock_arr[] = array('OrderType'=>$res['OrderType'],'OrderId' => $OrderId,'ProductUIC' => $res_productUIC['UIC']);
                            }

                        }else{
                            $ProductUIC ='';
                        }

                        $amount+=$res['Price']*$res['OrderQuantity'];
                        $quantity+=$res['OrderQuantity'];
                        $data[] = array(
                            'UserId' => $res['UserId'],
                            'DesigneCode' => $res['DesigneCode'],
                            'ProductId' => $res['ProductId'],
                            'Price' => $res['Price'],
                            'ColourId' => $res['ColourId'],
                            'SizeId' => $res['SizeId'],
                            'OrderType' => $res['OrderType'],
                            'OrderQuantity' => $res['OrderQuantity'],
                            'ProductUIC' => $ProductUIC,
                            'OrderId' => $OrderId,
                            'OrderedDateTime' => $CreatedDateTime
                        );
                    
                    $Size_name = $this->db->query("SELECT SizeName FROM SizeMaster Where id='".$res['SizeId']."'")->row();
                    $Colour_name = $this->db->query("SELECT ColourName FROM ColourMaster Where id='".$res['ColourId']."'")->row();
                    $OrderType_name = $_SERVER['ORDERTYPE'][$res['OrderType']];
                    
                    $order_table .= "<tr><td>".$res['DesigneCode']."</td><td>".$Colour_name->ColourName."</td><td>".$Size_name->SizeName."</td><td>".$OrderType_name."</th><th>".$res['OrderQuantity']."</td></tr>";  
                        
                    }

                    $order_table .= "</table>";
                    
                    $insert = $this->db->insert_batch('ProductOrders', $data);
                    
                    $data_summary = array(
                            'OrderId' => $OrderId,
                            'UserId' => $UserId,
                            'Amount' => $amount,
                            'Quantity'=>$quantity,
                            'Comment' => $Comment,
                            'OrderedDateTime' => $CreatedDateTime
                        );
                    
                    $insert = $this->db->insert('ProductOrdersSummary', $data_summary);
                    
                    foreach($update_stock_arr as $stk){
                        if(isset($stk['OrderType']) && $stk['OrderType']=='1'){
                            $update_stock_UIC = $this->db->query("UPDATE ProductStock SET OrderId='".$stk['OrderId']."' WHERE ProductUIC IN(".$stk['ProductUIC'].")");
                        }
                    }

                }
                
                if(isset($insert)){
                    
                    //send_mail_simple($to_email_id,$from_email,$subject,$message)
                    $user_details = $this->user_model->get_user_details_by_id($UserId);
                    send_mail_simple($user_details['EmailId'],'admin@melhortechnologies.com','Sunflower- Order Booked - '.$OrderId.'.','Dear Customer,<br> Your order with OrderId -<b>'.$OrderId.'</b> has been booked successfully. <br>'.$order_table.'<br>Thanks,<br> Sunflower');
                    // email part ends
                    
                    $query = $this->db->query("Delete FROM `UsersCart` WHERE `UserId`='$UserId'");
                    return json_encode(array('status'=>true,'msg'=>'Order booked successfully','OrderId'=>$OrderId,'Amount'=>$amount));
                }else {
                    return json_encode(array('status'=>false,'msg'=>'Cart is empty.'));
                }
        }
    }
  
  
    public function order_history_summary() {
       $result = array();
        $UserId = $this->input->post('UserId');
        $query = $this->db->query("SELECT ProductOrdersSummary.*,ShopMaster.ShopName 
                                    FROM `ProductOrdersSummary` 
                                    INNER JOIN UserMaster ON UserMaster.id = ProductOrdersSummary.UserId
                                    INNER JOIN ShopMaster ON ShopMaster.id = UserMaster.ShopId 
                                    WHERE `UserId`='$UserId'");
        $result = $query->result_array();
        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    }
    
    public function order_history() {
       $result = array();
        $UserId = $this->input->post('UserId');
        $OrderId = $this->input->post('OrderId');
        $query = $this->db->query("SELECT ProductOrders.*,ProductOrdersSummary.Comment,ShopMaster.ShopName,ProductMaster.ProductThumbnail,ProductMaster.DesigneCode,ProductMaster.ProductPrice,ColourMaster.ColourName,SizeMaster.SizeCode 
                                    FROM `ProductOrders` 
                                    INNER JOIN ProductMaster ON ProductMaster.id=ProductOrders.ProductId
                                    INNER JOIN ColourMaster ON ProductOrders.ColourId = ColourMaster.id
                                    INNER JOIN SizeMaster ON ProductOrders.SizeId = SizeMaster.id
                                    INNER JOIN UserMaster ON UserMaster.id = ProductOrders.UserId
                                    INNER JOIN ShopMaster ON ShopMaster.id = UserMaster.ShopId 
                                    LEFT JOIN ProductOrdersSummary ON ProductOrdersSummary.OrderId=ProductOrders.OrderId 
                                    WHERE `ProductOrders`.`UserId`='$UserId' AND `ProductOrders`.`OrderId`='$OrderId' ");
        $result = $query->result_array();
        
        foreach($result as $res){
            $data[$_SERVER['ORDERTYPE'][$res['OrderType']]][] = $res;
        }
        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$data,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 


    public function order_cancel() {
        $UserId = $this->input->post('UserId');
        $OrderId = $this->input->post('OrderId');
        //$OrderType = $this->input->post('OrderType');

        $data_cancel = array('OrderStatus'=>5,'ProductUIC'=>'');
            
        $this->db->where('UserId',$UserId);
        $this->db->where('OrderId',$OrderId);
        $update = $this->db->update('ProductOrders',$data_cancel);
        
        $data_cancel = array('OrderStatus'=>5);
        $this->db->where('UserId',$UserId);
        $this->db->where('OrderId',$OrderId);
        $update = $this->db->update('ProductOrdersSummary',$data_cancel);
        
        $stock_reset = array('OrderId'=> 0,'StockType'=>'1');
        $this->db->where('OrderId',$OrderId);
        $update = $this->db->update('ProductStock',$stock_reset);
        
        // email part start
        
        //send_mail_simple($to_email_id,$from_email,$subject,$message)
        
        $user_details = $this->user_model->get_user_details_by_id($UserId);
        
        send_mail_simple($user_details['EmailId'],'admin@melhortechnologies.com','Sunflower- Order Cancelled - '.$OrderId.'.','Dear Customer,<br> Your OrderId -<b>'.$OrderId.'</b> has been cancelled successfully. <br>Thanks,<br> Sunflower');
        
        // email part ends
        
        if($update){
            return json_encode(array('status'=>true,'msg'=>'Order Canceled Successfully'));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    }

    public function order_delete() {
        $UserId = $this->input->post('UserId');
        $OrderId = $this->input->post('OrderId');
        //$OrderType = $this->input->post('OrderType');

        $this->db->where('UserId',$UserId);
        $this->db->where('OrderId',$OrderId);
        //$this->db->where('OrderType',$OrderType);
        $update = $this->db->delete('ProductOrders');

        if($update){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_DELETE_MSG));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 
    
    // public function book_order() {
    //     $ProductId = $this->input->post('ProductId');
    //     $UserId = $this->input->post('UserId');
    //     $OrderedQuantity = $this->input->post('OrderedQuantity');
    //     $ColourId = $this->input->post('ColourId');
    //     $SizeId = $this->input->post('SizeId');
    //     $OrderType = $this->input->post('OrderType');
    //     $Price = $this->input->post('Price');
    //     $OrderedDateTime = date('Y-m-d H:i:s');
    //     $OrderStatus = 0; 
    //     $OrderType = 0;
    //     $insert = false;
    //     $query = $this->db->query("SELECT SUM(`ProductQty`) as qty FROM `ProductStock` WHERE `ProductId`='$ProductId' AND `ColourId`='$ColourId' AND `SizeId`='$SizeId' ");
    //     $result = $query->result_array();
    //     $res = $result['0']['qty'];
        
    //     //return "SELECT SUM(`ProductQty`) as qty FROM `ProductStock` WHERE `ProductId`='$ProductId' AND `ColourId`='$ColourId' AND `SizeId`='$SizeId' ";
        
    //     if($result['0']['qty'] > $OrderedQuantity){
    //         $data_array = array('UserId'=>$UserId,'ProductId'=>$ProductId,'OrderedQuantity'=>$OrderedQuantity,'OrderedDateTime'=>$OrderedDateTime,'OrderStatus'=>$OrderStatus,'OrderType'=>$OrderType);
    //         $insert = $this->db->insert('ProductOrders',$data_array);
    //         $insert_id = $this->db->insert_id();
            
    //         if($insert){
    //             return json_encode(array('status'=>true,'msg'=>'Order booked successfully'));
    //         }else {
    //             return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
    //         }
    //     }else {
    //         return json_encode(array('status'=>false,'msg'=>"Order Out Of Stock"));
    //     }
         
    // } 

/*

SELECT * FROM `ProductMaster` 
LEFT JOIN ProductStockMaster ON ProductMaster.id = ProductStockMaster.ProductId
LEFT JOIN Category ON Category.id = ProductMaster.CategoryId
LEFT JOIN SubCategory ON SubCategory.id = ProductMaster.SubCategoryId
LEFT JOIN ColourMaster ON ColourMaster.id = ProductStockMaster.ColourId
LEFT JOIN SizeMaster ON SizeMaster.id = ProductStockMaster.SizeId

SELECT ProductStockMaster.id as ProductStockId,DesigneCode,ProductUIC,CategoryName,SubCategoryName,ColourName,ColourCode,SizeName,SizeCode FROM `ProductMaster` 
INNER JOIN ProductStockMaster ON ProductMaster.id = ProductStockMaster.ProductId
INNER JOIN Category ON Category.id = ProductMaster.CategoryId
INNER JOIN SubCategory ON SubCategory.id = ProductMaster.SubCategoryId
INNER JOIN ColourMaster ON ColourMaster.id = ProductStockMaster.ColourId
INNER JOIN SizeMaster ON SizeMaster.id = ProductStockMaster.SizeId


SELECT ProductMaster.id as ProductId,ProductStockMaster.id as ProductStockId,DesigneCode,ProductUIC,CategoryName,SubCategoryName,ColourName,ColourCode,SizeName,SizeCode FROM `ProductMaster` 
LEFT JOIN ProductStockMaster ON ProductMaster.id = ProductStockMaster.ProductId 
LEFT JOIN Category ON Category.id = ProductMaster.CategoryId 
LEFT JOIN SubCategory ON SubCategory.id = ProductMaster.SubCategoryId 
LEFT JOIN ColourMaster ON ColourMaster.id = ProductStockMaster.ColourId 
LEFT JOIN SizeMaster ON SizeMaster.id = ProductStockMaster.SizeId 

*/


}


?>
