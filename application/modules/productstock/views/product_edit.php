<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Distributor </h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product Edit</strong>
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
                    <form id="form_product_update"  action="javascript:;" method="POST">
                        <div class="row">

                            
                           <div class="form-group col-md-6">
                                <label>Product Name *</label>
                                <input id="ProductName_add" value="<?php echo $list['ProductName'] ?> "  name="ProductName" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>ProductDescription *</label>
                                <input id="ProductDescription" value="<?php echo $list['ProductDescription'] ?> " name="ProductDescription" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Company *</label>
                                <select name="CompanyId" id="CompanyId" class="form-control">
                                    <option value="">Select Company</option>
                                    <?php foreach ($companyies as $key => $company) {
                                    if($list['Company']==$company['id']){
                                        $companyselected = "selected='selected'";
                                    }else{
                                        $companyselected = "";
                                    }?>
                                        <option value="<?php echo $company['id']; ?>" <?php echo $companyselected ;?>>
                                            <?php echo $company['CompanyName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Division *</label>
                                <select name="DivisionId" id="DivisionId" class="form-control">
                                    <option value="">Select Division</option>
                                    <?php foreach ($divisions as $key => $division) {
                                     if($list['Division']==$division['id']){
                                        $divisionselected = "selected='selected'";
                                    }else{
                                        $divisionselected = "";
                                    }?>
                                        <option value="<?php echo $division['id']; ?>" <?php echo $divisionselected ;?>>
                                            <?php echo $division['DivisionName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pur Pack *</label>
                                <input id="PurPack"value="<?php echo $list['PurPack'] ?> " name="PurPack" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sales Pack </label>
                                <input id="SalesPack" value="<?php echo $list['SalesPack'] ?> " name="SalesPack" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Min Stock </label>
                                <input id="MinStock"value="<?php echo $list['MinStock'] ?> "  name="MinStock" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Max Stock </label>
                                <input id="MaxStock" value="<?php echo $list['MaxStock'] ?> " name="MaxStock" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6" style="display:none">
                                <label>MRP </label>
                                <input id="MRP" value="<?php echo $list['ProductName'] ?> " name="MRP" type="text" class="form-control required">
                            </div>
                   
                            <div class="form-group col-md-6">
                                <label>RackId </label>
                                <input id="RackId" value="<?php echo $list['RackId'] ?> " name="RackId" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Active </label>
                                <select id="Active" name="Active" class="form-control required">
                                    <option value="">select</option>
                                    <?php foreach($_SERVER['YESNO'] as $key => $value){
                                     if($list['Active']==$key){
                                        $activeselected = "selected='selected'";
                                    }else{
                                        $activeselected = "";
                                    }?>
                                        <option value="<?php echo $key;?>"  <?php echo $activeselected ;?>><?php echo $value;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Sales Pack Qty </label>
                                <input id="SalesPackQty" value="<?php echo $list['SalesPackQty'] ?> " name="SalesPackQty" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Shipper Pack </label>
                                <input id="ShipperPack" value="<?php echo $list['ShipperPack'] ?> " name="ShipperPack" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ratio </label>
                                <input id="Ratio" value="<?php echo $list['Ratio'] ?> " name="Ratio" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Reorder Qty </label>
                                <input id="ReorderQty" value="<?php echo $list['ProductName'] ?> " name="ReorderQty" type="text" class="form-control required">
                            </div>
                           
                            <input id="id" value="<?php echo $list['id'] ?> " name="id" type="hidden" class="form-control required">
                            <div class="form-group col-md-6">
                                <label>Category *</label>
                                <select name="CategoryId" id="CategoryId" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $category) {
                                    if($list['Category']==$category['id']){
                                        $categoryselected = "selected='selected'";
                                    }else{
                                        $categoryselected = "";
                                    }?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo $categoryselected ;?>>
                                            <?php echo $category['ProductCategoryName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                           
                            <div class="form-group col-md-6">
                                <label>HSN </label>
                                <input id="HSN" value="<?php echo $list['HSN'] ?> " name="HSN" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6" style="display:none;">
                                <label>Pur GST </label>
                                <select name="PurGSTId" id="PurGSTId" class="form-control">
                                    <option value="">Select Pur GST</option>
                                    <?php foreach ($purgsts as $key => $purgst) { ?>
                                        <option value="<?php echo $purgst['GstValue']; ?>">
                                            <?php echo $purgst['GstName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sales GST </label>
                                <select name="SalesGSTId" id="SalesGSTId" class="form-control">
                                    <option value="">Select Sales GST</option>
                                    <?php foreach ($salegsts as $key => $salegst) {
                                     if($list['SalesGST']==$salegst['GstValue']){
                                        $salegstselected = "selected='selected'";
                                    }else{
                                        $salegstselected = "";
                                    }?>
                                        <option value="<?php echo $salegst['GstValue']; ?>" <?php echo $salegstselected ;?>>
                                            <?php echo $salegst['GstName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                           
                            <div class="form-group col-md-6">
                                <label>PTR </label>
                                <input id="PTRMargin" name="PTRMargin" value="<?php echo $list['PTRMargin'] ?> " type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>PTS </label>
                                <input id="PTS" name="PTSMargin" value="<?php echo $list['PTSMargin'] ?> " type="text" class="form-control required">
                            </div>
                            
                        	<div class="form-group col-md-6">
                                <label>Barcode</label>
                                <input id="ProductBarcode" name="ProductBarcode" value="<?php echo $list['ProductBarcode'] ?> " type="text" class="form-control required">
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
