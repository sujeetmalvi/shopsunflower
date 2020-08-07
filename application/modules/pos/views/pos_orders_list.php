            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>POS Orders List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="index-2.html">Home</a>
                  </li>
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>POS Orders List</strong>
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
                              <th>Transaction Type</th>
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
                              <th>Transaction Type</th>
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