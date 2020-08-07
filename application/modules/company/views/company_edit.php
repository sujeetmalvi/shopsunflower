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
                                    <input id="CompanyContactNo" value="<?php echo $details['CompanyContactNo'];?>" name="CompanyContactNo" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Company Email </label>
                                    <input id="CompanyEmail" value="<?php echo $details['CompanyEmail'];?>" name="CompanyEmail" type="text" class="form-control required">
                                </div>

                                
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input id="Address" value="<?php echo $details['Address'];?>" name="Address" type="text" class="form-control required">
                                </div>


                                <div class="form-group">
                                    <label>State *</label>
                                    <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $key => $state) {
                                           $selected='';
                                        if($details['StateId']==$state['id'])
                                        {
                                        	$selected='selected';
                                        }
                                        else{
                                        $selected='';}
                                        
                                            ?>
                                            <option value="<?php echo $state['id']; ?>" <?php echo $selected; ?>><?php echo $state['StateName']; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>City *</label>
                                    <select name="CityId"  id="CityId" class="form-control">
                                        <option value="">Select City</option>
                                         <?php foreach ($cities as $key => $cit) {
                                          $cselected='';
                                          if($details['CityId']==$cit['id'])
                                          {
                                        	$cselected='selected';
                                          }
                                        else{
                                        $cselected='';}
                                            ?>
                                            <option value="<?php echo $cit['id']; ?>" <?php echo $cselected; ?>><?php echo $cit['CityName']; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Contact Person *</label>
                                    <input id="ContactPerson" value="<?php echo $details['ContactPerson'];?>" name="ContactPerson" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Contact Mobile *</label>
                                    <input id="ContactMobile" value="<?php echo $details['ContactMobile'];?>" name="ContactMobile" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Contact Email </label>
                                    <input id="ContactEmail" value="<?php echo $details['ContactEmail'];?>" name="ContactEmail" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Pan No </label>
                                    <input id="PanNo" value="<?php echo $details['PanNo'];?>" name="PanNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>Tin No </label>
                                    <input id="TinNo" value="<?php echo $details['TinNo'];?>" name="TinNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>DL No </label>
                                    <input id="DLNo" value="<?php echo $details['DLNo'];?>" name="DLNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>LST No </label>
                                    <input id="LSTNo" value="<?php echo $details['LSTNo'];?>" name="LSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>CST No </label>
                                    <input id="CSTNo" value="<?php echo $details['CSTNo'];?>" name="CSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>GST No </label>
                                    <input id="GSTNo" value="<?php echo $details['GSTNo'];?>" name="GSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>TAN No </label>
                                    <input id="TANNo" value="<?php echo $details['TANNo'];?>" name="TANNo" type="text" class="form-control ">
                                     <input id="CompanyId" value="<?php echo $details['id'];?>" name="CompanyId" type="hidden" class="form-control ">
                                </div>
                                
                                <div class="form-group" style="display:none;">
                                    <label>Credit Days </label>
                                    <input id="CreditDays" value="<?php echo $details['CreditDays'];?>" name="CreditDays" type="text" class="form-control ">
                                </div>

                                <div class="form-group" style="display:none;">
                                    <label>Credit Limit </label>
                                    <input id="CreditLimit" value="<?php echo $details['CreditLimit'];?>" name="CreditLimit" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>Transporter </label>
                                    <input id="Transporter" value="<?php echo $details['Transporter'];?>" name="Transporter" type="text" class="form-control ">
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
