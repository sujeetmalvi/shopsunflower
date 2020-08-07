<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Company </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Company</a>
            </li>
            <li class="active">
                <strong>Company update</strong>
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
                    <form id="form_company_update" action="javascript:;" method="POST">
                        <div class="row">

                                <div class="form-group">
                                    <label>Company Name *</label>
                                    <input id="CompanyName" value="<?php echo $details['CompanyName'];?>" name="CompanyName" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Company Contact No *</label>
                                    <input id="ContactNumber" value="<?php echo $details['ContactNumber'];?>" name="ContactNumber" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Company Email *</label>
                                    <input id="CompanyEmail" value="<?php echo $details['CompanyEmail'];?>" name="CompanyEmail" type="text" class="form-control required">
                                </div>
								
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input id="Address" value="<?php echo $details['Address'];?>" name="Address" type="text" class="form-control required">
                                </div>
								
                                <div class="form-group">
                                    <label>State *</label>									
                                    <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);" >
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
                                    <label>Short Name *</label>
                                    <input id="ShortName" value="<?php echo $details['ShortName'];?>" name="ShortName" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Pincode*</label>
                                    <input id="Pincode" value="<?php echo $details['Pincode'];?>" name="Pincode" type="text" class="form-control required">
                                </div>
								
								<div class="form-group">
                                    <label>CompanyId*</label>
                                    <input id="CompanyId" value="<?php echo $details['id'];?>" name="CompanyId" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Division Id</label>                                   
                                    <select name="DivisionId" id="DivisionId" class="form-control">
                                        <option value="">Select Division</option>
                                        <?php foreach ($division as $key => $div) {
										
									if($details['DivisionId']==$div['id']){
                                        $Divisionselected = "selected='selected'";
									
                                    }else{
                                        $Divisionselected = "";
                                    }
									//$details['DivisionId']
									?>                                           
                                        <option value="<?php echo $div['id']; ?>" <?php echo $Divisionselected;?>><?php echo $div['DivisionName']; ?>
                                        </option>
                                            <?php } ?>
                                    </select>                                
                                </div>
								
								
								<div class="form-group">
                                    <label>Remark</label>
                                    <textarea name="Remark"  placeholder="Enter Remark" id="Remark" class="form-control required"><?php echo $details['Remark'];?></textarea>
                                </div>
                              
                                <div class="form-group col-lg-12">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input  name="submit" type="submit" class="btn btn-primary" >
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
