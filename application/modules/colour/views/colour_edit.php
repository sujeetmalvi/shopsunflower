<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Colour </h2>
        <ol class="breadcrumb">
            <li>
                <a>Colour</a>
            </li>
            <li class="active">
                <strong>Colour Edit</strong>
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
                    <form id="form_colour_update"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>Colour Name *</label>
                                <input id="ColourName" name="ColourName" type="text" class="form-control required" value="<?php echo $details['ColourName']?>">
                            </div>
                            <div class="form-group">
                                <label>Colour Code </label>
                                <input id="ColourCode" name="ColourCode" type="text" class="form-control" value="<?php echo $details['ColourCode']?>">
                            </div>

                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" name="ColourId"  value="<?php echo $details['id']?>">
                                <input  name="submit" type="submit" class="btn btn-primary" value="Submit" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
