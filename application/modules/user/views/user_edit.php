<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>User </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>User</a>
            </li>
            <li class="active">
                <strong>User update</strong>
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
                    <form id="form_user_update" action="javascript:;" method="POST">
                        <div class="row">
                                <div class="form-group">
                                    <label>Shop Name *</label>
                                    <select name='ShopId' class='form-control'>
                                        <?php foreach($shoplist as $shop){
                                            if($details['ShopId']==$shop['id']){ $selected="selected='selected'"; }else{ $selected=""; }
                                        ?>
                                            <option value='<?php echo $shop['id']?>' <?php echo $selected; ?> ><?php echo $shop['ShopName']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label>Full Name *</label>
                                    <input id="FullName" name="FullName" type="text" class="form-control required" value="<?php echo $details['FullName'];?>">
                                </div>
                                <div class="form-group">
                                    <label>Email Id </label>
                                    <input id="EmailId" name="EmailId" type="text" class="form-control" value="<?php echo $details['EmailId'];?>">
                                </div>
                                <div class="form-group">
                                    <label>Password </label>
                                    <input id="Password" name="Password" type="Password" class="form-control" value="" placeholder='Leave blank , to remain same' >
                                </div>
                                <div class="form-group">
                                    <label>Contact No</label>
                                    <input id="ContactNo" name="ContactNo" type="text" class="form-control required" onfocus="this.blur();"  value="<?php echo $details['ContactNo'];?>">
                                </div>
                                <div class="form-group">
                                    <label>Device Id </label>
                                    <input id="DeviceId" name="DeviceId" type="text" class="form-control" onfocus="this.blur();" value="<?php echo $details['DeviceId'];?>">
                                </div>
                                <div class="form-group">
                                    <label>User Type Id </label>
                                    <select id="UserTypeId" name="UserTypeId" class='form-control'>
                                        <option value='1' <?php if($details['UserTypeId']=='1'){ echo 'selected="selected"'; }?>>Administrator</option>
                                        <option value='2' <?php if($details['UserTypeId']=='2'){ echo 'selected="selected"'; }?>>Member</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Agent Name</label>
                                    <input id="AgentName" name="AgentName" type="text" class="form-control" value="<?php echo $details['AgentName'];?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Terms & Condition</label>
                                    <input id="Termsandcondition" name="Termsandcondition" type="text" class="form-control" value="<?php echo $details['Termsandcondition'];?>">
                                </div>

                              
                                <div class="form-group col-lg-12">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input type="hidden" id="UserId" name="UserId" value="<?php echo $details['id'];?>" />
                                    <!--<input type="hidden" id="ShopId" name="ShopId" value="</?php echo $details['ShopId'];?>" />-->
                                    <input  name="submit" type="submit" class="btn btn-primary" >
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
