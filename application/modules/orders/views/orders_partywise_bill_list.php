  <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Partywise Bills List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Bills</a>
                  </li>
                  <li class="active">
                    <strong>Partywise Bills List</strong>
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
                    <div class="ibox-title">
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('orders/orders_add'); ?>">Add Orders</a>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <?php 
                        if($_SESSION['user_role']=='admin'){
                          $orderby = 'Stockist';
                        }
                        if($_SESSION['user_role']=='stockist'){
                          $orderby = 'Retailer';
                        }

                          ?>
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Date</th>
			      <th>Order Bill No.</th>
                              <th><?php echo $orderby; ?></th>
                              <th>Order Total Amount</th>
                              <th>Order Status</th>
                              <th>Created Date Time</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Date</th>
			      <th>Order Bill No.</th>
                              <th><?php echo $orderby; ?></th>
                              <th>Order Total Amount</th>
                              <th>Order Status</th>
                              <th>Created Date Time</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



<div id="OrderDetailsModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Details
        </h4>
		<button type="button" class="btn btn-xs btn-primary pull-right" id="print" onclick="printme('print_table')">Print</button>
        
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



<div id="OrderReceived" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 800px;">
    <div class="modal-content" >
    <form id="form_save_order_to_stock" action="javascript:;" method="post" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Receive          
        </h4>
        
        <div class="row">
        	<div class="col-md-3"><b>BillNo</b></div>
        	<div class="col-md-3" id="BillNo"></div>
        	<div class="col-md-3"><b>Order Id</b></div>
        	<div class="col-md-3"></div>
        </div>
        <div class="row">
        	<div class="col-md-3"><b>Transporter Name:</b><br><span id="TransporterName"></span></div>
        	<div class="col-md-3"><b>Transporter Bilty No.:</b><br><span id="TransporterBiltyNo"></span></div>
	       	<div class="col-md-6"><b>Transport Remarks:</b><br><span id="TransportRemarks"></span></div>
        </div>
      </div>
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <div class="panel-heading" id="panelheading">
                    <div class="tr">
                        <div class="td">Product Name</div>
                        <div class="td">MRP</div>
                        <div class="td">Batch</div>
                        <div class="td">Expiry</div>
                        <div class="td">Mfg.Date</div>
                        <div class="td">Quantity</div>
                        <div class="td">Remarks</div>
                    </div>
                </div>
                <div id="orderreceivedlist" class="panel-body"> </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-success" onclick="()">Save to Stock</button>
      </div>
      </form>
    </div>
  </div>
</div>
