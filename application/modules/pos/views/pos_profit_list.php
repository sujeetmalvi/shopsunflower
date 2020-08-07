            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>POS Profit List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="#">Home</a>
                  </li>
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>POS Profit List</strong>
                  </li>
                </ol>
              </div>
              <div class="col-lg-2">

              </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                  <form id="form_get_orders_by_date" action="javascript:;" method="post">
                    <div class="ibox-title">
                      <!-- <a class="btn btn-xs btn-success" href="<?php //echo site_url('pos/pos_orders_add'); ?>">Add POS Orders</a> -->
                    </div>
                    <div class="ibox-content">
                    	  <div class="form-group ">
	                    	  <div class=" ">
                                      <label>Date</label>
                                      <input type="text" id="date" class="form-control mydatepicker" value="" name="date" placeholder="Enter Date" data-validation="required">
                                 </div>
                           </div>
                           <div class="form-group">
                           	<input type="submit" value="submit" id="submit" class="btn btn-primary" >
                           </div>
		   </div>
		   </form>
		 </div>
	      </div>
	   </div>
	
            <div class="wrapper wrapper-content animated fadeInRight">
              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                      <!-- <a class="btn btn-xs btn-success" href="<?php //echo site_url('pos/pos_orders_add'); ?>">Add POS Orders</a> -->
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <?php 
                          $orderby = 'Agent';
                          $orderfor = 'Customer';
                          ?>
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th><?php echo $orderby; ?></th>
                              <th><?php echo $orderfor; ?></th>
                              <th>Order Total Amount</th>
                              <th>Profit</th>
                              <th>Created Date Time</th>
                            </tr>
                          </thead>
                          <tbody id="replace">
                          <?php 
                          $TotalPrice=0.00;
                          $i=0;
                          foreach($list as $value)
                          {
                          $i++;                          
                          $profit=0.00;
                         	 $order_product=$this->orders_model->get_customer_order_details_by_orderid($value['OrderId']);                         	
                         	foreach($order_product as $order)
                         	{
                         		$profit=$profit + (($order['ProductMRP']*$order['PTRMargin']/100)*$order['OrderQuantity']);
                         	}
                         	$TotalPrice=$TotalPrice+$profit;
                          ?>
                          <tr>
                             <th style="width:80px;"><?php echo $i; ?><a class="btn btn-xs btn-primary" href="<?php echo site_url('pos/pos_orders_print_agent');?>/?OrderId=<?php echo $value['OrderId'] ?>" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a></th>
                             <td><?php echo $value['OrderId']; ?></td>
                             <td><?php echo $value['FromName']; ?></td>
                             <td><?php echo $value['ToName']; ?></td>                             
	                     <td><?php echo $value['OrderTotalAmount']; ?></td>                      
	                     <td><?php echo number_format($profit,2); ?></td>
                             <td><?php echo $value['CreatedDateTime']; ?></td>
                          </tr>	
                          <?php 
                          } ?>
                          <tr  style="background-color: #f8ac594d;">
                             <th style="width:80px;"></th>
                             <td></td>
                             <td></td>
                             <td></td>                             
	                     <td></td>                      
	                     <td>Total</td>
                             <td><?php echo number_format($TotalPrice,2); ?></td>
                          </tr>
                          </tbody>
                          <tfoot>
                            
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



<div id="OrderDetailsModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 1200px;">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Details
          <button type="button" class="btn btn-xs btn-primary pull-right" id="print" onclick="printme('print_table')">Print</button>
        </h4>
      </div>
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <div class="panel-heading" id="panelheading">
                    <div class="tr">
                        <div class="td">Division</div>
                        <div class="td">Composition</div>
                        <div class="td">Brand Name</div>
                        <div class="td">Packtype1</div>
                        <div class="td">Packtype2</div>
                        <div class="td">Shipper Pack</div>
                        <div class="td">Purchase Rate</div>
                        <div class="td">MRP</div>
                        <div class="td">Quantity</div>
                        <div class="td">Amount</div>
                    </div>
                </div>
                <div id="orderrows"> </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>