            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product Stock List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Product Stock</a>
                  </li>
                  <li class="active">
                    <strong>Product stock List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('productstock/productstock_addnew'); ?>">Add Product Stock</a>
                      
                      
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Category<br>Name</th>
                                <th>Designe<br>Code</th>
                                <th>Colour<br>Name</th>
                                <th>Size<br>Name</th>
                                <th>UIC</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>In Process<br>DateTime</th>
                                <th>Ready<br>DateTime</th>
                                <th>OrderId</th>
                                <th>StockType</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Category<br>Name</th>
                                <th>Designe<br>Code</th>
                                <th>Colour<br>Name</th>
                                <th>Size<br>Name</th>
                                <th>UIC</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>In Process<br>DateTime</th>
                                <th>Ready<br>DateTime</th>
                                <th>OrderId</th>
                                <th>StockType</th>
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

