<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Division </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Division</a>
            </li>
            <li class="active">
                <strong>Division update</strong>
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
                    <form id="form_division_update" action="javascript:;" method="POST">
                        <div class="row">

                                <div class="form-group">
                                    <label>Division Name *</label>
                                    <input id="DivisionName" value="<?php echo $details['DivisionName'];?>" name="DivisionName" type="text" class="form-control required">
                                </div>
								<input type="hidden" name="DivisionId" value="<?php echo $details['id'];?>">  
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
