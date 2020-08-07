            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product Stock</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Product</a>
                  </li>
                  <li class="active">
                    <strong>Product Stock</strong>
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
                      <form id="form_product_stock_save"  action="javascript:;" method="POST">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name<hr style="margin:0px;border: solid 0.5px #3e3e3e">Composition</th>
                              <th>Packing Type1<hr style="margin:0px;border: solid 0.5px #3e3e3e">Packing Type2</th>
                              <th>Prod. BatchNo</th>
                              <th>Prod. Quantity</th>
                              <th>Prod. Expiry Date</th>
                              <th>Prod. MFG Date</th>
                              <th>Prod. Min Inv.Level</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Product Name<hr style="margin:0px;border: solid 0.5px #3e3e3e">Composition</th>
                              <th>Packing Type1<hr style="margin:0px;border: solid 0.5px #3e3e3e">Packing Type2</th>
                              <th>Prod. BatchNo</th>
                              <th>Prod. Quantity</th>
                              <th>Prod. Expiry Date</th>
                              <th>Prod. MFG Date</th>
                              <th>Prod. Min Inv.Level</th>
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

