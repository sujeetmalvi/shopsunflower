<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Transporter </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Transporter</a>
            </li>
            <li class="active">
                <strong>Transporter update</strong>
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
                    <form id="form_transporter_update" action="javascript:;" method="POST">
                        <div class="row">
                                <div class="form-group">
                                    <label>Transporter Name *</label>
                                    <input id="TransporterName" value="<?php echo $details['TransporterName'];?>" name="TransporterName" type="text" class="form-control required">
                                </div>
				<input type="hidden" name="TransporterId" value="<?php echo $details['id'];?>"> 
				<div class="form-group">
                                    <label>Mobile *</label>
                                    <input id="Mobile" value="<?php echo $details['Mobile'];?>" name="Mobile" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Landline*</label>
                                    <input id="Landline" name="Landline" value="<?php echo $details['Landline'];?>" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Email*</label>
                                    <input id="Email" name="Email" value="<?php echo $details['Email'];?>" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>Contact Person*</label>
                                    <input id="ContactPerson" value="<?php echo $details['ContactPerson'];?>" name="ContactPerson" type="text" class="form-control required">
                                </div>
				<div class="form-group">
                                    <label>Address</label>
                                    <textarea name="Address" placeholder="Enter Address" id="Address" class="form-control required"><?php echo $details['Address'];?></textarea>
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
