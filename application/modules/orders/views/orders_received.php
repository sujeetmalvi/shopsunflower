          <style>
          #modal_1 {
    overflow-y:scroll;
}
          </style>
          
            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Orders Received List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>Orders Received List</strong>
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
                      <a class="btn btn-xs btn-warning pull-right" onclick="approve_selected_order_all_products()" href="javascript:;">Approve Orders</a>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <?php 
                        if($_SESSION['user_role']=='retailer'){
                          $orderby = 'Retailer';
                          $orderfor = 'Stockist';
                        }
                        if($_SESSION['user_role']=='stockist'){
                          $orderby = 'Stockist';
                          $orderfor = COMPANYNAME;
                        }

                        if($_SESSION['user_role']=='admin'){
                          $orderby = 'Stockist';
                          $orderfor = COMPANYNAME;
                        }

                        ?>
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th><?php echo $orderby; ?></th>
                              <th><?php echo $orderfor; ?></th>
                              <th>Order Total Amount</th>
                              <th>Order Status</th>
                              <th>Dispatch</th>
                              <th>Created Date Time</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th><?php echo $orderby; ?></th>
                              <th><?php echo $orderfor; ?></th>
                              <th>Order Total Amount</th>
                              <th>Order Status</th>
                              <th>Dispatch</th>
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
    <form id="form_order_status_save"  action="javascript:;" method="POST">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Received Details         
            
          <button type="button" class="btn btn-xs btn-primary pull-right" id="print" onclick="printme('print_table')">Print</button>
        </h4>
      </div>
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <div class="panel-heading" id="panelheading">
                    <div class="tr">
                        <div class="td">Division</div>                       
                        <div class="td">Brand Name</div>                       
                        <div class="td">Shipper Pack</div>
                        <div class="td">Purchase Rate</div>
                        <div class="td">MRP</div>
                        <div class="td">Ordered <br> Quantity</div>
                        <div class='td'>Stock <br> Quantity</div>
                        <div class='td'>Approved <br> Quantity</div>
                        <div class="td">Amount</div>
                        
                    </div>
                </div>
               <!--  <div id="orderrows"> </div> -->
            </div>
            
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
       
       
        <input type="submit" class="btn btn-success pull-right" id="submit" name="submit" value="Submit">
       
      </div>
    </div>
    </form>
  </div>
</div>


<div id="OrderRejectionModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 600px;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button>
        <h4 class="modal-title theme-text">
          Please enter Remarks
        </h4>
      </div>
      <div class="modal-body">
          <input type="hidden" id="OrderDetailsId" name="OrderDetailsId" value="">
          <input type="hidden" id="AcceptReject" name="AcceptReject" value="">
          <textarea id="reason" class="form-control" rows="10" name="reason"></textarea>
      </div>
      <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
          <input type="button" class="btn btn-success pull-right" name="remarkssave" value="Remarks Save" onclick="remarkssave();">        
      </div>
    </div>
  </div>
</div>



<div id="OrderDispatch" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 600px;">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Dispatch Transport Details 
        </h4>
      </div>
      <div class="modal-body">
	<div class="row">
	<div class="form-group">
                                    <label>Tranporter Name</label>
                                    <select name="TransporterId" id="TransporterId" class="form-control" >
                                        <option value="">Select Transporter</option>
                                        <?php foreach ($transporter as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['TransporterName']; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>
		
	</div>
	<div class="row">
		<div class="form-group">
			<label>Tranporter Bilty No.</label>
			<input type='text' name='TransporterBiltyNo' id='TransporterBiltyNo' class='form-control' />
		</div>
	</div>
	<div class="row">
		<div class="form-group">
			<label>Remarks / Other Details </label>
			<textarea name='TransportRemarks' id='TransportRemarks' class='form-control'></textarea>
		</div>
	</div>
          
      </div>
      <div class="modal-footer">
      	<input type="hidden" id="OrderIdDispatch"  name="OrderIdDispatch" value="" >
        <input type="button" class="btn btn-success pull-right" name="save" value="Save" onclick="order_dispach_save();">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>