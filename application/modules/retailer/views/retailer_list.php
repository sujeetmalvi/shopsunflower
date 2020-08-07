            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Retailer List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a>Retailer</a>
                  </li>
                  <li class="active">
                    <strong>Retailer List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('retailer/retailer_add'); ?>">Add Retailer</a>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>State Name</th>
                              <th>City Name</th>
                              <th>Retailer Name</th>
                              <th>Retailer Contact No</th>
                              <th>Retailer Email</th>
                              <th>Stockist</th>
                              <th>Category</th>
                              <th>Contact Person</th>
                              <th>Contact Mobile</th>
                              <th>Contact Email</th>
                              <th>Pan No</th>
                              <th>Tin No</th>
                              <th>DL No</th>
                              <th>LST No</th>
                              <th>TAN No</th>
                              <th>Credit Days</th>
                              <th>Credit Limit</th>
                              <th>Transporter</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>State Name</th>
                              <th>City Name</th>
                              <th>Retailer Name</th>
                              <th>Retailer Contact No</th>
                              <th>Retailer Email</th>
                              <th>Stockist</th>
                              <th>Category</th>
                              <th>Contact Person</th>
                              <th>Contact Mobile</th>
                              <th>Contact Email</th>
                              <th>Pan No</th>
                              <th>Tin No</th>
                              <th>DL No</th>
                              <th>LST No</th>
                              <th>TAN No</th>
                              <th>Credit Days</th>
                              <th>Credit Limit</th>
                              <th>Transporter</th>
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

