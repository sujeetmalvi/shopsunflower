            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Orders Club List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>Orders Club List</strong>
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
                      <input type="button" class="btn btn-xs btn-success pull-right" onclick="ordernow();" value="Order Now">
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <?php 
                        // if($_SESSION['user_role']=='stockist'){
                        //   $orderby = 'Retailer';
                        //   $orderfor = 'Stockist';
                        // }
                          ?>
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>Composition</th>
                              <th>Purchase Rate</th>
                              <th>MRP</th>
                              <th>Total Quantity</th>
                              <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>Composition</th>
                              <th>Purchase Rate</th>
                              <th>MRP</th>
                              <th>Total Quantity</th>
                              <th>Amount</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      <input type="button" class="btn btn-xs btn-success pull-right" onclick="ordernow();" value="Order Now">
                    </div>
                  </div>
                </div>
              </div>
            </div>



<div id="OrderBookModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 1000px;">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Now 
          <button type="button" class="btn btn-xs btn-primary pull-right" id="print" onclick="printme('print_table')">Print</button>
        </h4>
      </div>
      <form id="form_order_place_now"  action="javascript:;" method="POST">
      <div class="modal-body" id="print_table">
          <div class="panel panel-default panel-table" id="orderdetails">
                <div class="panel-heading" id="panelheading">
                    <div class="tr">
                        <div class="td">Product Name</div>
                        <div class="td">Composition</div>
                        <div class="td">Purchase Rate</div>
                        <div class="td">MRP</div>
                        <div class="td">Total Quantity</div>
                        <div class="td">Amount</div>
                    </div>
                </div>                
                <div class='panel-body' id='orderdetailsbody'>
                  
                </div>
                <div class='panel-footer'  id='orderdetailsfooter'>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
        <input id="submit"  name="submit" type="submit" class="btn btn-primary pull-right" value="Place Order Now">
      </div>
    </form>
    </div>
  </div>
</div>