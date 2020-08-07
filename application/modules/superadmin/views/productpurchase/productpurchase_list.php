            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product Purchase List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="#">Home</a>
                  </li>
                  <li>
                    <a>Product Purchase</a>
                  </li>
                  <li class="active">
                    <strong>Product Purchase List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('superadmin/productpurchase/productpurchase_add'); ?>">Add Product Purchase</a>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Invoice Date</th>
                              <th>Invoice No.</th>
  							              <th>Invoice Amount</th>
                              <th>Add to Stock</th>
                              <th>Created DateTime</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Invoice Date</th>
                              <th>Invoice No.</th>
                              <th>Invoice Amount</th>
                              <th>Add to Stock</th>               
                              <th>Created DateTime</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

<div id="productpurchasedetailsmodal" class="modal" data-easein="flipXIn" data-backdrop="static" data-keyboard="false"   tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 800px;">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Product Details</h4>
                    <button class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true" >Close</button>
                </div>
                <div class="modal-body">
                <div class="row">
                      <div class="panel panel-default panel-table">
                          <div class="panel-heading">
                              <div class="tr">
                                  <div class="td" style="padding:6px;">Brand Name</div>
                                  <div class="td" style="padding:6px;">Description</div>
                                  <div class="td" style="padding:6px;">Barcode</div>
                                  <div class="td" style="padding:6px;">Sales Pack</div>
                                  <div class="td" style="padding:6px;">Batch</div>
                                  <div class="td" style="padding:6px;">Market Price</div>
                                  <div class="td" style="padding:6px;">Purchase Price</div>
                                  <div class="td" style="padding:6px;">Mfg Date</div>
                                  <div class="td" style="padding:6px;">Expiry</div>
                                  <div class="td" style="padding:6px;">Quantity</div>
                              </div>
                          </div>
                          <div class="panel-body" id="productpurchaselist">                                    
                                  <div id="insertAfter"></div> 
                           
                          </div>
                          <div class="panel-footer">
                              <!-- <div class="tr">
                                  <div class="td" style="padding:6px;"></div>
                              </div> -->
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                </div>
        </div>
    </div>
</div>


<div id="addtostockmodal" class="modal" data-easein="flipXIn" data-backdrop="static" data-keyboard="false"   tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 100%;">
    <form id="form_addtostock_save"  action="javascript:;" method="POST">
        <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Products add to stock</h4>
                    <button class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true" >Close</button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="ProductPurchaseId" id="ProductPurchaseId" value="">
                <div class="row">
                      <div class="panel panel-default panel-table">
                          <div class="panel-heading">
                              <div class="tr">
                                  <div class="td" style="padding:6px;"></div>
                                  <div class="td" style="padding:6px;">Brand Name 
                                  <hr style="margin-top: 6px;margin-bottom: 6px;">
                                  Description</div>
                                  <div class="td" style="padding:6px;">Barcode
                                  <hr style="margin-top: 6px;margin-bottom: 6px;">
                                  Sales Pack
                                  <hr style="margin-top: 6px;margin-bottom: 6px;">
                                  Batch</div>
                                  <div class="td" style="padding:6px;">Market Price
                                  <hr style="margin-top: 6px;margin-bottom: 6px;">
                                  Purchase Price</div>
                                  <div class="td" style="padding:6px;">Mfg Date
                                  <hr style="margin-top: 6px;margin-bottom: 6px;">
                                  Expiry</div>
                                  <div class="td" style="padding:6px;">Quantity</div>

                                  <div class="td" style="padding:6px;">Sales Gst</div>
                                  <div class="td" style="padding:6px;">PTR</div>
                                  <div class="td" style="padding:6px;">DavaIndia Price</div>
                                  <div class="td" style="padding:6px;">Ratio</div>
                                  <div class="td" style="padding:6px;">Received Remarks</div>
                              </div>
                          </div>
                          <div class="panel-body" id="addtostocklist">                                    
                                  <div id="insertAfteraddtostock"></div>                            
                          </div>
                          <div class="panel-footer">
                              <!-- <div class="tr">
                                  <div class="td" style="padding:6px;"></div>
                              </div> -->
                          </div>
                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                <input type="submit" class="btn btn-success pull-right" id="submit" name="submit" value="Submit">
                </div>
        </div>
        </form>
    </div>
</div>