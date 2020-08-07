            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product Stock</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Product</a>
                  </li>
                  <li class="active">
                    <strong>Product Stock Add</strong>
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
                      <form id="form_product_stock_savenew"  action="javascript:;" method="POST">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover " >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>Prod. BatchNo</th>
                              <th>Prod. MRP</th>
                              <th>Prod. Purchase Rate</th>
                              <th>Prod. Quantity</th>
                              <th>Prod. Expiry Date</th>
                              <th>Prod. MFG Date</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $i=1; foreach ($list as $key => $value) {  ?>
                            <tr>
                              <td style="widtd:30px;"><?php echo $i;?></td>
                                <td><?php echo $value['ProductName'];?></td>
                                <td><input type="text" name="Batch[]"  value="" class="form-control"></td>
                                <td><input type="text" name="MRP[]"  value="" class="form-control"></td>
                                <td><input type="text" name="PurchaseRate[]" value="" class="form-control"></td>
                                <td><input type="text" name="Quantity[]" value="" class="form-control"></td>
                                <td><input type="text" name="Expiry[]" value="" class="form-control mydatepicker"></td>
                                <td>
                                  <input type="text" name="MfgDate[]" id="MfgDate" value="" class="form-control mydatepicker">
                                  <input type="hidden" name="ProductId[]" value="" >
                                </td>
                            </tr>
                          <?php $i++; } ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name</th>
                              <th>Prod. BatchNo</th>
                              <th>Prod. MRP</th>
                              <th>Prod. Purchase Rate</th>
                              <th>Prod. Quantity</th>
                              <th>Prod. Expiry Date</th>
                              <th>Prod. MFG Date</th>
                            </tr>
                          </tfoot>
                        </table>
                        <button type="Submit" id="Submit" class="btn btn-success pull-right">Submit</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

