<div class="wrapper wrapper-content">
 <div class="row">
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cube fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Total Categories </span>
                            <h2 class="font-bold"><?php echo $total['categories'];?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <i class="fa fa-cubes fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Total Products </span>
                                <h2 class="font-bold"><?php echo $total['products'];?></h2>
                            </div>
                        </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-building fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Total Shops</span>
                            <h2 class="font-bold"><?php echo $total['shop'];?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Total Users </span>
                            <h2 class="font-bold"><?php echo $total['user'];?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>Shop Settings </h5>
                    </div>
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="panel panel-primary" style='height:130px'>
                                        <div class="panel-heading">
                                            <strong>Shop Status</strong>
                                        </div>
                                        <div class="panel-body">
                                            <select name='ShopStatus' id='ShopStatus' class='form-control'>
                                                <option value='1' <?php echo ($shopsettings['ShopStatus']=='1')?"selected='selected'":'';?>>Closed</option>
                                                <option value='2' <?php echo ($shopsettings['ShopStatus']=='2')?"selected='selected'":'';?>>Open</option>
                                                <option value='3' <?php echo ($shopsettings['ShopStatus']=='3')?"selected='selected'":'';?>>Partialy Open</option>
                                            </select>
                                            <input type='submit' name='submit' value='Set' onclick="set_shopsettings('ShopStatus')" class='btn btn-primary btn-xs' style='margin-top:10px;'>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-success" style='height:130px'>
                                        <div class="panel-heading">
                                            <strong>Shop Timmings</strong>
                                        </div>
                                        <div class="panel-body">
                                            <div class='row'>
                                                <div class='col-md-6'>
                                                    <label>Start Time</label>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" value="<?php echo $shopsettings['ShopStartTime'];?>"  name='ShopStartTime' id='ShopStartTime' onchange="set_shopsettings('ShopStartTime')" >
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>        
                                                </div>
                                                <div class='col-md-6'>
                                                    <label>End Time</label>
                                                    <div class="input-group clockpicker" data-autoclose="true">
                                                        <input type="text" class="form-control" value="<?php echo $shopsettings['ShopEndTime'];?>"  name='ShopEndTime' id='ShopEndTime' onchange="set_shopsettings('ShopEndTime')">
                                                        <span class="input-group-addon">
                                                            <span class="fa fa-clock-o"></span>
                                                        </span>
                                                    </div>        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-warning" style='height:130px'>
                                        <div class="panel-heading">
                                            <strong>Shop Send Email From</strong>
                                        </div>
                                        <div class="panel-body">
                                            <label>Shop Send Email</label>
                                            <div class="input-group" data-autoclose="true">
                                                <input type="text" class="form-control" value="<?php echo $shopsettings['ShopSendEmailFrom'];?>"  name='ShopSendEmailFrom' id='ShopSendEmailFrom'>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-save" style='cursor:pointer' onclick="set_shopsettings('ShopSendEmailFrom')"></span>
                                                </span>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-danger" style='height:130px'>
                                        <div class="panel-heading">
                                             <strong>Shop Received Email To</strong>
                                        </div>
                                        <div class="panel-body">
                                            <label>Shop Receive Email</label>
                                            <div class="input-group" data-autoclose="true">
                                                <input type="text" class="form-control" value="<?php echo $shopsettings['ShopRecieveEmailTo'];?>"  name='ShopRecieveEmailTo' id='ShopRecieveEmailTo'>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-save" style='cursor:pointer' onclick="set_shopsettings('ShopRecieveEmailTo')"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        
</div>
<!--<div class="row">-->
<!--    <div class="col-lg-12">-->
<!--                <div>-->
<!--                    <table class="table" style="background:#ffffff">-->
<!--                        <tbody>-->
<!--                        <tr>-->
<!--                            <td>-->
<!--                                <button type="button"  class="btn btn-danger m-r-sm"><span id="totalretailers">0</span></button>-->
<!--                                Total Retailers-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <button type="button" class="btn btn-primary m-r-sm"><span id="retailerstotalsale">0</span></button>-->
<!--                                Total Sale Value  -->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <button type="button" class="btn btn-info m-r-sm"><span id="retailersorderscount">0</span></button>-->
<!--                               Total Number of Orders-->
<!--                            </td>-->

<!--                            <td>-->
<!--                                <button type="button" class="btn btn-success m-r-sm"><span id="totalnewcustomers">0</span></button>-->
<!--                                Total New Customers-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--    </div>-->

<!--    <div class="row">-->
<!--        <div class="col-lg-3">-->
<!--            <div class="ibox float-e-margins">-->
<!--                <div class="ibox-title" id="topproducttitle">-->
<!--                    <h5>Top Performing Products</h5>-->
<!--                     <div class="ibox-tools">-->
<!--                        <a class="collapse-link">-->
<!--                            <i class="fa fa-chevron-up"></i>-->
<!--                        </a>-->
<!--                        <a class="close-link">-->
<!--                            <i class="fa fa-times"></i>-->
<!--                        </a>-->
<!--                    </div> -->
<!--                </div>-->
<!--                <div class="ibox-content" id="topproductcontent">-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-12">-->
<!--                            <table class="table table-hover margin bottom">-->
<!--                                <thead>-->
<!--                                    <tr>-->
<!--                                        <th style="width: 1%" class="text-center">No.</th>-->
<!--                                        <th>Product Brand</th>-->
<!--                                        <th class="text-center">Order Amount</th>-->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody id="topperfomingproducts">-->
<!--                                     <tr>-->
<!--                                        <td class="text-center">1</td>-->
<!--                                        <td> Security doors</td>-->
<!--                                        <td class="text-center"><span class="label label-primary">$483.00</span></td>-->
<!--                                    </tr> -->
<!--                                </tbody>-->
<!--                            </table>-->
<!--                        </div>-->
<!--                       </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-lg-3">-->
<!--            <div class="ibox float-e-margins">-->
<!--                <div class="ibox-title" id="topstockisttitle" style="cursor:pointer;" onclick="showorderslist('stockist');">-->
<!--                    <h5>Top Performing Stockist</h5>-->
<!--                     <div class="ibox-tools">-->
<!--                        <a class="collapse-link">-->
<!--                            <i class="fa fa-chevron-up"></i>-->
<!--                        </a>-->
<!--                        <a class="close-link">-->
<!--                            <i class="fa fa-times"></i>-->
<!--                        </a>-->
<!--                    </div> -->
<!--                </div>-->
<!--                <div class="ibox-content" id="topstockistcontent">-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-12">-->
<!--                            <table class="table table-hover margin bottom">-->
<!--                                <thead>-->
<!--                                    <tr>-->
<!--                                        <th style="width: 1%" class="text-center">No.</th>-->
<!--                                        <th>Stockist Name</th>-->
<!--                                        <th class="text-center">Order Amount</th>-->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody id="topperfomingstockist">-->
                                    
<!--                                </tbody>-->
<!--                            </table>-->
<!--                        </div>-->
<!--                       </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-lg-3">-->
<!--            <div class="ibox float-e-margins">-->
<!--                <div class="ibox-title" id="topretailertitle" style="cursor:pointer;" onclick="showorderslist('retailer');">-->
<!--                    <h5>Top Performing Retailers</h5>-->
<!--                     <div class="ibox-tools">-->
<!--                        <a class="collapse-link">-->
<!--                            <i class="fa fa-chevron-up"></i>-->
<!--                        </a>-->
<!--                        <a class="close-link">-->
<!--                            <i class="fa fa-times"></i>-->
<!--                        </a>-->
<!--                    </div> -->
<!--                </div>-->
<!--                <div class="ibox-content" id="topretailercontent">-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-12">-->
<!--                            <table class="table table-hover margin bottom">-->
<!--                                <thead>-->
<!--                                    <tr>-->
<!--                                        <th style="width: 1%" class="text-center">No.</th>-->
<!--                                        <th>Retailer Name</th>-->
<!--                                        <th class="text-center">Order Amount</th>-->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody id="topperfomingretailer">-->
<!--                                </tbody>-->
<!--                            </table>-->
<!--                        </div>-->
<!--                       </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<table class="table table-striped table-bordered table-hover dataTables-example" style='display:none'  ></table>

<div id="OrderModal" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width: 1200px;">
    <div class="modal-content" >
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          ×
        </button> -->
        <h4 class="modal-title theme-text">
          Order Details
          <!-- <button type="button" class="btn btn-xs btn-primary pull-right" id="print" onclick="printme('print_table')">Print</button> -->
        </h4>
      </div>
      <div class="modal-body" id="print_table">
          <table class="table table-striped table-bordered table-hover dataTables-example" id="orderdetails">
          </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
  </div>
</div>