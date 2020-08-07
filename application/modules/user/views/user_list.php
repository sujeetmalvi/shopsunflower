            <div class="row wrapper border-bottom white-bg page-heading">
              <div class="col-lg-10">
                <h2>User List</h2>
                <ol class="breadcrumb">
                  <li>
                    <a href="index-2.html">Home</a>
                  </li>
                  <li>
                    <a>User</a>
                  </li>
                  <li class="active">
                    <strong>User List</strong>
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
                      <a class="btn btn-xs btn-success" href="<?php echo site_url('user/user_add'); ?>">Add User</a>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th style="width:40px;">S.No.</th>
                              <th>Shop Name</th>
                              <th>Full Name</th>
                              <th>EmailId</th>
                              <th>ContactNo</th>
                              <th>DeviceId</th>
                              <th>UserTypeId</th>
                              <th>AgentName</th>
                              <th>DateTime</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th style="width:30px;">S.No.</th>
                              <th>Shop Name</th>
                              <th>Full Name</th>
                              <th>EmailId</th>
                              <th>ContactNo</th>
                              <th>DeviceId</th>
                              <th>UserTypeId</th>
                              <th>AgentName</th>
                              <th>DateTime</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>