            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>Transporter List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="#">Home</a>
                  </li>
                  <li>
                    <a>Transporter</a>
                  </li>
                  <li class="active">
                    <strong>Transporter List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('transporter/transporter_add'); ?>">Add Transporter</a>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:30px;">S.No.</th>                              
                              <th>Transporter Name</th>
                              <th>Address</th>
                              <th>Mobile</th>                             
                              <th>Email</th>
                              <th>Landline</th>
                              <th>Contact Person</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                            <th style="width:30px;">S.No.</th>
                             <th>Transporter Name</th>
                              <th>Address</th>
                              <th>Mobile</th>                             
                              <th>Email</th>
                              <th>Landline</th>
                              <th>Contact Person</th>
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