            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Product List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Product</a>
                  </li>
                  <li class="active">
                    <strong>Product List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('product/product_addnew'); ?>">Add Product</a>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Category Name</th>
                                <th>Colour Name</th>
                                <th>Size Name</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Thumbnail</th>
                                <th>Designe Code</th>
                                <th>Visible Status</th>
                                <th>Pre Order ?</th>
                                <th>Is Offer/ Price</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Category Name</th>
                                <th>Colour Name</th>
                                <th>Size Name</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Thumbnail</th>
                                <th>Designe Code</th>
                                <th>Visible Status</th>
                                <th>Pre Order ?</th>
                                <th>Is Offer/ Price</th>
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


