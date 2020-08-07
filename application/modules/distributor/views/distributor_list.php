            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Distributor List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="index-2.html">Home</a>
                  </li>
                  <li>
                    <a>Distributor</a>
                  </li>
                  <li class="active">
                    <strong>Distributor List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('distributor/distributor_add'); ?>">Add Distributor</a>
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>State Name</th>
                              <th>City Name</th>
                              <th>Distributor Name</th>
                              <th>Association Type</th>
                              <th>Distributor ContactNo</th>
                              <th>Distributor Email</th>
                              <th>Total Margins</th>
                              <th>DSA Margins</th>
                              <th>Outgoing Freight</th>
                              <th>Stockiest Incentives</th>
                              <th>Field Staff Salary</th>
                              <th>Field Staff Expenses</th>
                              <th>Field Staff Incentives</th>
                              <th>Field Staff Payrol</th>
                              <th>Payment Mode</th>
                              <th>Total Sales Person</th>
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
                              <th>Distributor Name</th>
                              <th>Association Type</th>
                              <th>Distributor ContactNo</th>
                              <th>Distributor Email</th>
                              <th>Total Margins</th>
                              <th>DSA Margins</th>
                              <th>Outgoing Freight</th>
                              <th>Stockiest Incentives</th>
                              <th>Field Staff Salary</th>
                              <th>Field Staff Expenses</th>
                              <th>Field Staff Incentives</th>
                              <th>Field Staff Payrol</th>
                              <th>Payment Mode</th>
                              <th>Total Sales Person</th>
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

