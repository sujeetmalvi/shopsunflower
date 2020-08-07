<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Distributor </h2>
        <ol class="breadcrumb">
            <li>
                <a href="index-2.html">Home</a>
            </li>
            <li>
                <a>Distributor</a>
            </li>
            <li class="active">
                <strong>Distributor add</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <!-- <h5>All form elements <small>With custom checbox and radion elements.</small></h5> -->
                </div>
                <div class="ibox-content">
                    <form id="form_distributor_update"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>Distributor Name *</label>
                                <input id="DistributorName" name="DistributorName" type="text" class="form-control required" value="<?php echo $details['DistributorName'];?>">
                            </div>

                            <div class="form-group">
                                <label>Association Type *</label>
                                <input id="AssociationType" name="AssociationType" type="text" class="form-control required" value="<?php echo $details['AssociationType'];?>">
                            </div>

                            <div class="form-group">
                                <label>Distributor Contact No *</label>
                                <input id="DistributorContactNo" name="DistributorContactNo" type="text" class="form-control required"  value="<?php echo $details['DistributorContactNo'];?>">
                            </div>

                            <div class="form-group">
                                <label>Distributor Email </label>
                                <input id="DistributorEmail" name="DistributorEmail" type="text" class="form-control required"  value="<?php echo $details['DistributorEmail'];?>">
                            </div>

                            <div class="form-group">
                                <label>Distributor Address *</label>
                                <input id="DistributorAddress" name="DistributorAddress" type="text" class="form-control required" value="<?php echo $details['DistributorAddress'];?>">
                            </div>

                            <div class="form-group">
                                <label>State *</label>
                                <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);">
                                    <option value="">Select State</option>
                                <?php foreach ($states as $key => $state) {
                                    if($details['StateId']==$state['id']){
                                        $Stateselected = "selected='selected'";
                                    }else{
                                        $Stateselected = "";
                                    }
                                ?>
                                    <option value="<?php echo $state['id']; ?>" <?php echo $Stateselected;?>><?php echo $state['StateName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City *</label>
                                <select name="CityId" id="CityId" class="form-control">
                                 <?php foreach ($cities as $key => $city) {
                                    if($details['CityId']==$city['id']){
                                        $Cityselected = "selected='selected'";
                                    }else{
                                        $Cityselected = "";
                                    }
                                ?>
                                    <option value="<?php echo $city['id']; ?>" <?php echo $Cityselected;?>><?php echo $city['CityName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Total Margins</label>
                                <input id="TotalMargins" name="TotalMargins" type="text" class="form-control required" value="<?php echo $details['TotalMargins'];?>">
                            </div>

                            <div class="form-group">
                                <label>DSA Margins </label>
                                <input id="DSAMargins" name="DSAMargins" type="text" class="form-control required" value="<?php echo $details['DSAMargins'];?>">
                            </div>

                            <div class="form-group">
                                <label>Outgoing Freight </label>
                                <input id="OutgoingFreight" name="OutgoingFreight" type="text" class="form-control required" value="<?php echo $details['OutgoingFreight'];?>">
                            </div>

                            <div class="form-group">
                                <label>Stockiest Incentives </label>
                                <input id="StockiestIncentives" name="StockiestIncentives" type="text" class="form-control required" value="<?php echo $details['StockiestIncentives'];?>">
                            </div>

                            <div class="form-group">
                                <label>Field Staff Salary </label>
                                <input id="FieldStaffSalary" name="FieldStaffSalary" type="text" class="form-control required" value="<?php echo $details['FieldStaffSalary'];?>">
                            </div>

                            <div class="form-group">
                                <label>Field Staff Expenses </label>
                                <input id="FieldStaffExpenses" name="FieldStaffExpenses" type="text" class="form-control required" value="<?php echo $details['FieldStaffExpenses'];?>">
                            </div>

                            <div class="form-group">
                                <label>Field Staff Incentives </label>
                                <input id="FieldStaffIncentives" name="FieldStaffIncentives" type="text" class="form-control required" value="<?php echo $details['FieldStaffIncentives'];?>">
                            </div>

                            <div class="form-group">
                                <label>Field Staff Payrol </label>
                                <input id="FieldStaffPayrol" name="FieldStaffPayrol" type="text" class="form-control required" value="<?php echo $details['FieldStaffPayrol'];?>">
                            </div>

                            <div class="form-group">
                                <label>Payment Mode </label>
                                <input id="PaymentMode" name="PaymentMode" type="text" class="form-control required" value="<?php echo $details['PaymentMode'];?>">
                            </div>


                            <div class="form-group">
                                <label>Total Sales Person </label>
                                <input id="TotalSalesPerson" name="TotalSalesPerson" type="text" class="form-control required" value="<?php echo $details['TotalSalesPerson'];?>">
                            </div>

                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" name="DistributorId"  value="<?php echo $details['id'];?>">
                                <input  name="submit" type="submit" class="btn btn-primary" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
