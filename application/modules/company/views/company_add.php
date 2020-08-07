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
                <strong>Company add</strong>
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
                    <form id="form_company_save"  action="javascript:;" method="POST">
                        <div class="row">

                                <div class="form-group">
                                    <label>Company Name *</label>
                                    <input id="CompanyName" name="CompanyName" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Company Contact No *</label>
                                    <input id="CompanyContactNo" name="CompanyContactNo" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Company Email </label>
                                    <input id="CompanyEmail" name="CompanyEmail" type="text" class="form-control required">
                                </div>

                                <div class="form-group" style="display:none;">
                                    <label>Category  *</label>
                                    <input id="CategoryId" name="CategoryId" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>Address *</label>
                                    <input id="Address" name="Address" type="text" class="form-control required">
                                </div>


                                <div class="form-group">
                                    <label>State *</label>
                                    <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $key => $state) {
                                            ?>
                                            <option value="<?php echo $state['id']; ?>"><?php echo $state['StateName']; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>City *</label>
                                    <select name="CityId" id="CityId" class="form-control">
                                        <option value="">Select City</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Contact Person *</label>
                                    <input id="ContactPerson" name="ContactPerson" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Contact Mobile *</label>
                                    <input id="ContactMobile" name="ContactMobile" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Contact Email </label>
                                    <input id="ContactEmail" name="ContactEmail" type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Pan No </label>
                                    <input id="PanNo" name="PanNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>Tin No </label>
                                    <input id="TinNo" name="TinNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>DL No </label>
                                    <input id="DLNo" name="DLNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>LST No </label>
                                    <input id="LSTNo" name="LSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>CST No </label>
                                    <input id="CSTNo" name="CSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>GST No </label>
                                    <input id="GSTNo" name="GSTNo" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>TAN No </label>
                                    <input id="TANNo" name="TANNo" type="text" class="form-control ">
                                </div>
                                

                                <div class="form-group" style="display:none;">
                                    <label>Credit Days </label>
                                    <input id="CreditDays" name="CreditDays" type="text" class="form-control ">
                                </div>

                                <div class="form-group" style="display:none;">
                                    <label>Credit Limit </label>
                                    <input id="CreditLimit" name="CreditLimit" type="text" class="form-control ">
                                </div>

                                <div class="form-group">
                                    <label>Transporter </label>
                                    <input id="Transporter" name="Transporter" type="text" class="form-control ">
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
