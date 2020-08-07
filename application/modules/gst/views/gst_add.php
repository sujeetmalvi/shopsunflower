<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Gst </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Gst</a>
            </li>
            <li class="active">
                <strong>Gst add</strong>
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
                    <form id="form_gst_save"  action="javascript:;" method="POST">
                        <div class="row">
                                <div class="form-group">
                                    <label>Gst Name *</label>
                                    <input id="GstName" name="GstName" type="text" class="form-control required">
                                </div>
								
				<div class="form-group">
                                    <label>Gst Value</label>
                                    <input name="GstValue" type="text" placeholder="Enter Value" id="GstValue" class="form-control required">
                                </div>
				<div class="form-group">
                                    <label>Gst Apply</label>
                                    <input name="GstApply" type="text" placeholder="Enter Value" id="GstApply" class="form-control required">
                                </div>				
				<div class="form-group" style="display:none;">
                                    <label>Gst Type</label>
                                     <select name="GstType" id="GstType" class="form-control" >
                                        <option value="">Select Type</option>                                      
                                            <option value="1">Purchase
                                            </option>										
                                            <option value="2">Sales </option>                                        
                                    </select>
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
