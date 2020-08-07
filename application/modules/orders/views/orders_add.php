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
                    <?php 
                     if($_SESSION['user_role']!='retailer'){
                    ?>
                  <!--  <a class="btn btn-xs btn-warning" onclick="get_product_details_by_id('0','all_ordered_products')" href="javascript:;">Orders Received</a>-->
                    <?php } ?>
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
                                            
                                            
                                            <div class="td">Brand Name</div>
                                            <div class="td">Composition</div>                                           
                                            <div class="td">Pack Type</div>
                                            <div class="td">Batch</div>
                                            <div class="td">Purchase Rate</div>                                            
                                            <div class="td">Quantity</div>
                                            <div class="td">Amount</div>
                                        </div>
                                    </div>
                                    <div class="panel-body" id="productlist">
                                            <div id="insertbefore"></div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="tr">
                                            <div class="td"></div>
                                           
                                            <div class="td"></div>
                                            
                                            <div class="td"></div>
                                            <div class="td"></div>
                                             <div class="td"></div>
                                            <div class="td">Total</div>
                                            <div class="td" id="showtotalamount">0.00</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input id="submit"  name="submit" type="button" class="btn btn-primary pull-right" value="Save" onclick="form_orders_save_submit()" >
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
</div>
  
  
  <div id="MyProductModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 800px;">
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
          <div class="panel panel-default panel-table" id="">
                		<div class='panel-heading' id='panelheading'>
                			<div class="tr">         
                			    <div class="td">Select</div>
                                            <div class="td">Brand Name</div>  
                                            <div class="td">Batch</div>
                                            <div class="td">Purchase Rate</div>
                                            <div class="td">Total Available Quantity</div>                                            
                                        </div>
                		</div>
                <div class='panel-body' id='productbatchdetails'>
                    
                </div>
<!--                 <div class='panel-footer'  id='orderdetailsfooter'>
                    <div class='tr'>
                        <div class='td'></div>
                    </div>
                </div> -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
         <a class="btn btn-primary" onclick="add_product_to_the_list()" value="Save" data-dismiss="modal" aria-hidden="true">Save</a>
      </div>
    </div>
  </div>
</div>
</div>
