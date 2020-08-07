<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Orders </h2>
        <ol class="breadcrumb">
            <li>
                <a>Orders</a>
            </li>
            <li class="active">
                <strong>Orders add</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <a class="btn btn-xs btn-success" href="<?php echo site_url('orders/orders_list'); ?>">Orders List</a>
                    <a class="btn btn-xs btn-primary" href="javascript:;" onclick="get_product_details_by_id('0','all_products')">All Products</a>
                    <a class="btn btn-xs btn-warning" onclick="get_product_details_by_id('0','all_ordered_products')" href="javascript:;">Orders Received</a>
                    <a class="btn btn-xs btn-danger" onclick="remove_all_products()" href="javascript:;">Remove All Products</a>
                </div>
                <div class="ibox-content">
                    <form id="form_orders_save"  action="javascript:;" method="POST">
                        <input type="hidden" id="UserRole" name="UserRole" value="<?php echo $_SESSION['user_role']?>">
                        <input type="hidden" id="rowid" name="rowid" value="0">
                        <input type="hidden" id="totalamount" name="totalamount" value="0">
                        <div class="row">

                            <!-- <div class="form-group">
                                <label>Product *</label>
                                <select id="combobox" onchange="get_product_details_by_id(this.value);">
                                    <option value=""></option>
                                    <?php // echo $productlist;?>
                                </select>
                            </div> -->

                            <div class="form-group">
                                <div class="col-md-6">
                                        <label>Choose Product(s) *</label>
                                        <input id="ProductName" class="form-control" placeholder="Type product name">
                                </div>
                                <div class="col-md-6">
                                        <label>Date *</label>
                                        <input id="OrderDate" name="OrderDate" class="form-control mydatepicker" placeholder="Select Date" value="<?php echo date('d-m-Y');?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <br>
                        </div>
                        <div class="row">

                                <div class="panel panel-default panel-table">
                                    <div class="panel-heading">
                                        <div class="tr">
                                            <div class="td">Division</div>
                                           
                                            <div class="td">Brand Name</div>
                                            
                                            <div class="td">Shipper Pack</div>
                                            <div class="td">Purchase Rate</div>
                                            <div class="td">MRP</div>
                                            <div class="td">Quantity</div>
                                            <div class="td">Amount</div>
                                        </div>
                                    </div>
                                    <div class="panel-body" id="productlist">
                                            
         <?php
         $total=0;
         if(!empty($order_info)){
          foreach($order_info as $info){
         $total=(float)$total+($info['OrderQuantity']*$info['ProductPurchaseRate']);		?>
	<div class="tr" id="<?php echo $info['id']; ?>">	
      <div class="td"><?php echo $info['Division']; ?></div>      
       <div class="td"><?php echo $info['ProductName']; ?></div>
       
       <div class="td"><?php echo $info['ShipperPack']; ?></div>       
       <div class="td"><?php echo $info['ProductPurchaseRate']; ?></div>
       <div class="td"><?php echo $info['ProductMRP'];?></div>
       
      <div class="td"><input type="text" style="width:100px;" class="form-control quantity" id="quantity<?php echo $info['id']; ?>"  name="quantity[]" onchange="calculate_amount_onchange();" value="<?php echo $info['OrderQuantity']; ?>">
	  </div>
                     
                      <div class="td">
                      <input type="hidden" class="form-control" id="amount<?php echo $info['id']; ?>" name="amount[]" value="<?php echo $info['ProductPurchaseRate']; ?>"> 
                      <span id="showamount<?php echo $info['id']; ?>"><?php echo $info['OrderQuantity']*$info['ProductPurchaseRate']; ?></span><br> 
                      <input type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteme(<?php echo $info['id']; ?>)" value="X">
                      <input type="button" class="btn btn-xs btn-primary" title="Details" onclick="showproductdetails(<?php echo $info['id']; ?>)" value="#">
                      <input type="hidden" name="ProductId[]" id="ProductId<?php echo $info['id']; ?>" value="<?php echo $info['id']; ?>">
                      <input type="hidden" name="MrpRate[]" id="MrpRate<?php echo $info['id']; ?>" value="<?php echo $info['ProductMRP'];?>">
                      <input type="hidden" name="PurchaseRate[]" class="PurchaseRate" id="PurchaseRate<?php echo $info['id']; ?>" value="<?php echo $info['ProductPurchaseRate']; ?>">
                      <input type="hidden" class="productrow" value="<?php echo $info['id']; ?>">
                      </div>
                      
                     
    </div>
	<?php }
	} ?>
	<div id="insertbefore">
                                            </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="tr">
                                            <div class="td"></div>
                                            <div class="td"></div>                                            
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td">Total</div>
                                            <div class="td" id="showtotalamount"><?php echo $total; ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input id="submit"  name="submit" type="submit" class="btn btn-primary pull-right" value="Save" >
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ProductDetailsModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 400px;">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Product Details
        </h4>
      </div>
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <div class='panel-heading' id='panelheading'>
                </div>
                <div class='panel-body' id='productdetailsbody'>
                    
                </div>
<!--                 <div class='panel-footer'  id='orderdetailsfooter'>
                    <div class='tr'>
                        <div class='td'></div>
                    </div>
                </div> -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>