            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Dispatched Orders List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>Dispatched Orders List</strong>
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
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th>S.No.</th>
                              <th>Order Id</th>
                              <th>Invoice Date</th>
                              <th>Invoice No.</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <!--<th>Amount</th>-->
                              <!--<th>Order Status</th>-->
                              <!--<th>Received</th>-->
                              <th>Created Date Time</th>
                              <th>Action</th>
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
                              <th>Invoice Date</th>
                              <th>Invoice No.</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <!--<th>Amount</th>-->
                              <!--<th>Order Status</th>-->
                              <!--<th>Received</th>-->
                              <th>Created Date Time</th>
                              <th>Action</th>
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
        <h4 class="modal-title theme-text">Order Details</h4>
      </div>
      <div class="modal-body" id="print_table">
        <div class="panel panel-default panel-table" id="orderdetails">
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>
