<?php

class Ordersbill_model extends CI_Model {

    function __construct() {
        parent::__construct();
//        $this->load->model('stockist/stockist_model');
//        $this->load->model('retailer/retailer_model');
//        $this->load->model('customer/customer_model');
    }


    public function get_partywise_bills_list(){

        //$ = ($this->uri->segment(3))?$this->uri->segment(3):'0';
        $UserId = $_SESSION['user_id'];
        $UserRole = $_SESSION['user_role'];

        if($UserRole== 'stockist'){

            $sql = "SELECT orders_master_retailer. * , date_format(OrderDate,'%d-%m-%Y') as OrderDate, concat(retailer_master.RetailerName,' (' ,retailer_master.RetailerContactNo, ' )') as orderfor , date_format(orders_master_retailer.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
FROM orders_master_retailer
INNER JOIN retailer_master ON orders_master_retailer.RetailerId = retailer_master.id
WHERE orders_master_retailer.`StockistId` =  '".$UserId."'
ORDER BY orders_master_retailer.id DESC ";

//             $sql="SELECT product_master.*,SUM(OrderQuantity) as OrderTotalQuantity ,
// (select sum(ProductQuantity) as ttlproduct FROM product_stock where ProductId=orders_details_retailer.ProductId AND UserId=orders_details_retailer.`StockistId`='1' AND UserRoleId='2'  group by ProductId ) as ProductStock
// FROM orders_details_retailer INNER JOIN product_master ON orders_details_retailer.ProductId=product_master.id WHERE orders_details_retailer.`StockistId`='".$UserId."' AND orders_details_retailer.OrderStatus='1' GROUP BY ProductId ORDER BY orders_details_retailer.id DESC";
        }


        if($UserRole== 'admin'){

            $sql = "SELECT orders_master_stockist. * , date_format(OrderDate,'%d-%m-%Y') as OrderDate, concat(stockist_master.StockistName,' (' ,stockist_master.StockistContactNo, ' )') as orderfor , date_format(orders_master_stockist.CreatedDateTime,'%d-%m-%Y %H:%i:%s') as CreatedDateTime 
FROM orders_master_stockist
INNER JOIN stockist_master ON orders_master_stockist.StockistId = stockist_master.id
WHERE orders_master_stockist.`StockistId` =  '".$UserId."'
ORDER BY orders_master_stockist.id DESC ";
        }

        $query = $this->db->query($sql);
        $result="";
        if ($query) {
            if ($query->num_rows() > 0) {
                $datas = $query->result_array();

                //return pre($datas);
                    $i=1;

                    foreach ($datas as $key => $value) {  

                        $result.='<tr id="row'.$value['id'].'">';
                        $result.='<td>'.$i.'<a href="'.site_url("orders/invoice/?billid=".$value['id']).'" class="btn btn-xs btn-warning pull-right"  id="invoice" name="invoice" ><i class="fa fa-print" aria-hidden="true"></i></a>.</td>
                        <td>'.$value['OrderDate'].'</td>
                        <td>'.$value['BillNo'].'</td>
                        <td>'.$value['orderfor'].'</td>
                        <td>'.$value['OrderTotalAmount'].'</td>
                        <td>'.$value['OrderStatus'].'</td>
                        <td>'.$value['CreatedDateTime'].'</td>';
                        $result.='</tr>';
                        $i++;
                    }
                return $result;
            } else {
                return false;
            }
        }
    }


}