            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Cancelled Orders List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>Cancelled Orders List</strong>
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
                      <!--<a class="btn btn-xs btn-success" href="<?php echo site_url('orders/orders_add'); ?>">Add Orders</a>-->
                        <div class="form-group">
                            <form  action='<?php echo site_url('orders/get_orderlist_filter');?>' method='post'>
                                
                                <?php $postdate = (isset($_POST['daterange']))?$_POST['daterange']:date('d/m/Y').' - '.date('d/m/Y'); ?>
                                <label>Select date range
                                <input class="form-control" type="text" name="daterange" value="<?php echo $postdate; ?>" />
                                </label>
                                <input type="submit" class="btn btn-primary btn-md" value="Filter" />
                            </form>
                        </div>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th>S.No.</th>
                              <th>Order Id</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <th>Quantity</th>
                              <th>Amount</th>
                              <!--<th>Order Status</th>-->
                              <!--<th>Received</th>-->
                              <th>Created Date Time</th>
                              <!--<th>Comments</th>-->
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>S.No.</th>
                              <th>Order Id</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <th>Amount</th>
                              <th>Quantity</th>
                              <!--<th>Order Status</th>-->
                              <!--<th>Received</th>-->
                              <th>Created Date Time</th>
                              <!--<th>Comments</th>-->
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
  <div class="modal-dialog modal-lg" style='width:1000px;' >
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
        <h4 class="modal-title theme-text">Order Details</h4>
      </div>
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <!--<div class="panel-heading" id="panelheading">-->
                <!--    <div class="tr">-->
                <!--        <div class="td">Division</div>-->
                <!--        <div class="td">Composition</div>-->
                <!--        <div class="td">Brand Name</div>-->
                <!--        <div class="td">Packtype1</div>-->
                <!--        <div class="td">Packtype2</div>-->
                <!--        <div class="td">Shipper Pack</div>-->
                <!--        <div class="td">Purchase Rate</div>-->
                <!--        <div class="td">MRP</div>-->
                <!--        <div class="td">Quantity</div>-->
                <!--        <div class="td">Amount</div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div id="orderrows"> </div>-->
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>
