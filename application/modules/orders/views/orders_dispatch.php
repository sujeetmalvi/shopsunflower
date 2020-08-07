            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Orders Dispatch</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Orders</a>
                  </li>
                  <li class="active">
                    <strong>Orders Dispatch</strong>
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
                        <div class="form-group">
                            <form  action='<?php echo site_url('orders/get_order_details_for_despatch');?>' method='post'>
                                <select name="OrderId" id="OrderId" class="form-control pull-left select2_demo_2" style="width:50%">
                                    <option value="">Select Order</option>
                                    <?php if(is_array($orders)){
                                    foreach ($orders as $key => $order) {
                                        $selected = "";
                                        if(isset($_POST['OrderId'])){
                                            $selected = ($_POST['OrderId']==$order['OrderId'])?' selected="selected"':"";
                                        }
                                    ?>
                                        <option value="<?php echo $order['OrderId']; ?>" <?php echo $selected; ?> >
                                            <?php echo $order['OrderId']; ?>
                                        </option>
                                        <?php } }?>
                                </select>
                                <input type="submit" class="btn btn-primary btn-md" value="Show" />
                            </form>
                        </div>
                    </div>
                    <form id="form_product_dispatch" method="post" action="<?php echo site_url('orders/orders_generate');?>">
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo (isset($list))?$list:''; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <th>Shop Name</th>
                              <th>User Name</th>
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Amount</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-3">
                            <input type='hidden' name="DispatchOrderId" id="DispatchOrderId" value="<?php echo isset($_POST['OrderId'])?$_POST['OrderId']:''; ?>"  >
                            <?php if(isset($_POST['OrderId'])){ ?>
                            <input type='submit' class="btn btn-primary" style="margin-top:16px;" name="submit" value="Move to Dispatch" >
                            <?php } ?>
                        </div>
                      </div>
                    </div>
                    </form>
                    
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h3>Processing Orders list</h3>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <!--<th>Shop Name</th>-->
                              <!--<th>User Name</th>-->
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <!--<th>Price</th>-->
                              <!--<th>Amount</th>-->
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo (isset($list_processing))?$list_processing:''; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <!--<th>Shop Name</th>-->
                              <!--<th>User Name</th>-->
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <!--<th>Price</th>-->
                              <!--<th>Amount</th>-->
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                       <h3>Dispatched Orders list</h3>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <!--<th>Shop Name</th>-->
                              <!--<th>User Name</th>-->
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <!--<th>Price</th>-->
                              <!--<th>Amount</th>-->
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo (isset($list_dispatched))?$list_dispatched:''; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:80px;">S.No.</th>
                              <th>Order Id</th>
                              <th>Order Type</th>
                              <th>Product UIC</th>
                              <!--<th>Shop Name</th>-->
                              <!--<th>User Name</th>-->
                              <th>Product Design</th>
                              <th>Colour</th>
                              <th>Size</th>
                              <th>Quantity</th>
                              <!--<th>Price</th>-->
                              <!--<th>Amount</th>-->
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


<div class="modal inmodal fade" id="productuicmodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Select Product UIC</h4>
            </div>
            <div class="modal-body">
                <select id="productuics" name="productuics[]" data-placeholder="Choose a Product UIC" multiple="multiple" class="select2_demo_1  form-control" multiple style="width:100%;" tabindex="4" >
                    <option value="">Select</option>
                </select>
            </div>
            <div class="modal-footer">
                <input type='hidden' id='id' value=''/>
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="set_product_uic();" >Set Product UIC</button>
            </div>
        </div>
    </div>
</div>

