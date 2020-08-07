            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product MIL Stock List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Product</a>
                  </li>
                  <li class="active">
                    <strong>Product MIL Stock List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('product/product_mil_stock');?>">Add Product MIL Quantity</a>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>MIL Quantity</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>MIL Quantity</th>
                              <th>Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




<div id="Editmodal" class="modal" data-easein="flipXIn"  data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Edit MIL Stock Quantity</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>MIL Quantity</label>
                        <input class="form-control" type="text" name="quantity" id="quantity" >
                    </div>
                </div>
                <div class="modal-footer">
	            <input  type="hidden" name="ProductId" id="ProductId" value="">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    <input type="button" class="btn btn-block btn-primary" name="submit" id="submit" value="Submit" onclick="product_mil_stock_update();">
                </div>
        </div>
    </div>
</div>
