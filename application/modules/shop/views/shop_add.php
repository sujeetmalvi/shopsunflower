<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Shop </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Shop</a>
            </li>
            <li class="active">
                <strong>Shop add</strong>
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
                    <form id="form_shop_save"  action="javascript:;" method="POST">
                        <div class="row">
                                <div class="form-group">
                                    <label>Shop Name *</label>
                                    <input id="ShopName" name="ShopName" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>GST No </label>
                                    <input id="GstinNo" name="GstinNo" type="text" class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input id="Address" name="Address" type="text" class="form-control required">
                                </div>
                                <div class="form-group">
                                    <label>State </label>
                                    <input id="State" name="State" type="text" class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label>City </label>
                                    <input id="City" name="City" type="text" class="form-control ">
                                </div>
                                <div class="form-group">
                                    <label>Pin no.</label>
                                    <input id="PinNumber" name="PinNumber" type="text" class="form-control ">
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
