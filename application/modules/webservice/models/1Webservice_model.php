<?php

class Webservice_model extends CI_Model {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
    }
        
    /* ----------------------- Manager Rights ------------------------------- */

   public function login() {
        $loginname = $this->input->post('contactno');
        $loginpassword = $this->input->post('password');
        $DeviceId = $this->input->post('deviceid');
        $today = date('Y-m-d');
        $data = array();
        $sql = "SELECT * FROM UserMaster WHERE `ContactNo`='".$loginname."' AND `Password` = AES_ENCRYPT('".LOGIN_SALT."','".$loginpassword."') AND `DeviceId`='$DeviceId' ";

        if (!empty($loginname) && !empty($loginpassword)) {

            $query = $this->db->query($sql);
            if ($query) {
                if ($query->num_rows() > 0) {
                    $datas = $query->result_array();

                    $UserType = $datas[0]['UserTypeId'];

                    if($UserType=='1'){ $UserTypeRole = 'Admin'; }

                    if($UserType=='2'){ $UserTypeRole = 'User'; }

                        $data = array(
                            'id' => trim($datas[0]['id']),
                            'ShopId' => trim($datas[0]['ShopId']),
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

    public function products_list_all(){

        $start = (isset($_POST['start']))?$_POST['start']:0;
        $count = (isset($_POST['count']))?$_POST['count']:10;
        $searchby = "";
        $result = array();
        $searchby .= (isset($_POST['searchby']))?"AND (`CategoryName` LIKE '%".$_POST['searchby']."%' OR `DesigneCode` LIKE '%".$_POST['searchby']."%' )  ":"";

        $product_query = $this->db->query("SELECT ProductMaster.id as ProductId,ProductName,ProductPrice,ProductThumbnail,DesigneCode,CategoryName,CategoryId 
            FROM `ProductMaster` 
            LEFT JOIN CategoryMaster ON CategoryMaster.id = ProductMaster.CategoryId 
            WHERE VisibleStatus='1' $searchby LIMIT $start,$count");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    } 


    public function product_images(){

        $ProductId = $this->input->post('ProductId');
        $result = array();
        $product_query = $this->db->query("SELECT ProductImage FROM `ProductImages` WHERE `ProductId`='$ProductId'");

        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result,'path'=>base_url('uploads/products/')));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }

    }   


    public function product_stock(){
        
        $searchby = "";
        $searchby .= (isset($_POST['searchby']))?"AND (`DesigneCode` LIKE '%".$_POST['searchby']."%' )  ":"";
        $searchby .= (isset($_POST['ProductId']))?"AND (`ProductId` LIKE '%".$_POST['ProductId']."%' )  ":"";
        $result = array();
        $product_query = $this->db->query("SELECT ProductId, DesigneCode,SUM(ProductQty) as ProductQty,ColourMaster.id as ColourId, ColourMaster.ColourName,SizeMaster.id as SizeId,SizeMaster.SizeCode
                                            FROM `ProductStock` 
                                            INNER JOIN ColourMaster ON ProductStock.ColourId = ColourMaster.id
                                            INNER JOIN SizeMaster ON ProductStock.SizeId = SizeMaster.id WHERE 1 $searchby
                                            GROUP BY ProductId,ColourId,SizeId ORDER BY ProductId ASC");
        $result = $product_query->result_array();

        if(count($result)>0){
            return json_encode(array('status'=>true,'data'=>$result));
        }else{
            return json_encode(array('status'=>false,'data'=>$result));
        }
    }    
    
    
   public function add_to_cart() {
        $UserId = $this->input->post('UserId');
        $ProductId = $this->input->post('ProductId');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $ColourId  = $this->input->post('ColourId');
        $SizeId  = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $Price = $this->input->post('Price');

        $CreatedDateTime = date('Y-m-d H:i:s');
        $data_array = array('UserId'=>$UserId,'ProductId'=>$ProductId,'OrderQuantity'=>$OrderQuantity,'ColourId'=>$ColourId,'SizeId'=>$SizeId,'Price'=>$Price,'OrderType'=>$OrderType,'CreatedDateTime'=>$CreatedDateTime);

        $insert = $this->db->insert('UsersCart',$data_array);
        $qry = $this->db->last_query();
        $insert_id = $this->db->insert_id();
        if($insert){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_INSERT_MSG));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 

   public function update_to_cart() {
        $UserId = $this->input->post('UserId');
        $ProductId = $this->input->post('ProductId');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $ColourId  = $this->input->post('ColourId');
        $SizeId  = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $Price = $this->input->post('Price');
        $CreatedDateTime = date('Y-m-d H:i:s');
        
        $data_array = array('UserId'=>$UserId,'ProductId'=>$ProductId,'OrderQuantity'=>$OrderQuantity,'ColourId'=>$ColourId,'SizeId'=>$SizeId,'Price'=>$Price,'CreatedDateTime'=>$CreatedDateTime);

        $this->db->where('UserId',$UserId);
        $this->db->where('ProductId',$ProductId);
        $update = $this->db->update('UsersCart',$data_array);

        if($update){
            return json_encode(array('status'=>true,'msg'=>SUCCESS_UPDATE_MSG));
        } else {
            return json_encode(array('status'=>false,'msg'=>ERROR_MSG));
        }
    } 

   public function delete_from_cart() {
        $UserId = $this->input->post('UserId');
        $ProductId = $this->input->post('ProductId');
        $OrderType = $this->input->post('OrderType');

        $this->db->where('UserId',$UserId);
        $this->db->where('ProductId',$ProductId);
        $this->db->where('OrderType',$OrderType);
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
    
    public function book_order() {
        $result = array();
        $CreatedDateTime = date('Y-m-d H:i:s');
        $OrderId = strtotime(date('Y-m-d H:i:s'));
        $UserId = $this->input->post('UserId');
        $ProductId = $this->input->post('ProductId');
        $Price = $this->input->post('Price');
        $ColourId = $this->input->post('ColourId');
        $SizeId = $this->input->post('SizeId');
        $OrderType = $this->input->post('OrderType');
        $OrderQuantity = $this->input->post('OrderQuantity');
        $Comment = $this->input->post('Comment');
        
        if($OrderType=='3'){
                        $data[] = array(
                            'UserId' => $UserId,
                            'ProductId' => $ProductId,
                            'Price' => $Price,
                            'ColourId' => $ColourId,
                            'SizeId' => $SizeId,
                            'OrderType' => $OrderType,
                            'OrderQuantity' => $OrderQuantity,
                            'OrderId' => $OrderId,
                            'OrderedDateTime' => $CreatedDateTime
                        );
                    
                
                $insert = $this->db->insert_batch('ProductOrders', $data);
                
                $data_summary = array(
                        'OrderId' => $OrderId,
                        'UserId' => $UserId,
                        'Amount' => $Price,
                        'Quantity'=>$OrderQuantity,
                        'Comment' => $Comment,
                        'OrderedDateTime' => $CreatedDateTime
                    );
                $insert = $this->db->insert('ProductOrdersSummary', $data_summary);
                    if($insert){
                        return json_encode(array('status'=>true,'msg'=>'Order booked successfully','OrderId'=>$OrderId,'Amount'=>$Price));
                    }else {
                        return json_encode(array('status'=>false,'msg'=>'Some error occured.'));
                    }
            
        }else{
                $query = $this->db->query("SELECT UsersCart.* FROM `UsersCart` WHERE `UserId`='$UserId'");
                $result = $query->result_array();
                $amount = 0;
                $quantity = 0;
                if(count($result)>0){
                    foreach($result as $k => $res){
                        $amount+=$res['Price'];
                        $quantity+=$res['OrderQuantity'];
                        $data[] = array(
                            'UserId' => $res['UserId'],
                            'ProductId' => $res['ProductId'],
                            'Price' => $res['Price'],
                            'ColourId' => $res['ColourId'],
                            'SizeId' => $res['SizeId'],
                            'OrderType' => $res['OrderType'],
                            'OrderQuantity' => $res['OrderQuantity'],
                            'OrderId' => $OrderId,
                            'OrderedDateTime' => $CreatedDateTime
                        );
                    }
                }
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
                    if($insert){
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

        $data_cancel = array('OrderCancel' => 1);
            
        $this->db->where('UserId',$UserId);
        $this->db->where('OrderId',$OrderId);
        $update = $this->db->update('ProductOrders',$data_cancel);
        
        $data_cancel = array('OrderCancel' => 1);
        $this->db->where('UserId',$UserId);
        $this->db->where('OrderId',$OrderId);
        $update = $this->db->update('ProductOrdersSummary',$data_cancel);
        
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
