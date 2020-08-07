<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product </h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product add</strong>
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
                    <form id="form_product_save"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>Product Code *</label>
                                <input id="ProductCode" name="ProductCode" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Product Name *</label>
                                <input id="ProductName" name="ProductName" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Category </label>
                                <input id="CategoryId" name="CategoryId" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Division </label>
                                <input id="DivisionId" name="DivisionId" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Packing Type1 </label>
                                <input id="PackingType1" name="PackingType1" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Packing Type2 </label>
                                <input id="PackingType2" name="PackingType2" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Original Packing </label>
                                <input id="OriginalPacking" name="OriginalPacking" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Sample Packing </label>
                                <input id="SamplePacking" name="SamplePacking" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Shipper Packing </label>
                                <input id="ShipperPacking" name="ShipperPacking" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>General/Food </label>
                                <input id="General_Food" name="General_Food" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Purchase Rate </label>
                                <input id="PurchaseRate" name="PurchaseRate" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Mrp Rate </label>
                                <input id="MrpRate" name="MrpRate" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>PTR Margin </label>
                                <input id="PTRMargin" name="PTRMargin" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>PTS Margin </label>
                                <input id="PTSMargin" name="PTSMargin" type="text" class="form-control required">
                            </div>
                            <div class="form-group">
                                <label>PTD Margin </label>
                                <input id="PTDMargin" name="PTDMargin" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Composition </label>
                                <input id="Composition" name="Composition" type="text" class="form-control required">
                            </div>

                            <div class="form-group">
                                <label>Self Life Expiry </label>
                                <input id="SelfLifeExpiry" name="SelfLifeExpiry" type="text" class="form-control mydatepicker required">
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
