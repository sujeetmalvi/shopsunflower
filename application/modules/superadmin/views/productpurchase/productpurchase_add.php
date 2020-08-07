<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product Purchase </h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Product Purchase</a>
            </li>
            <li class="active">
                <strong>Product Purchase add</strong>
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
                
                </div>
                <div class="ibox-content">
                    <form id="form_productpurchase_save"  action="javascript:;" method="POST">
                        <input type="hidden" name="rowid" id="rowid" value="0">
                        <div class="row">

                                <div class="form-group col-md-3">
                                    <label>Select Vendor *</label>
                                        <input type="text" name="VendorName" id="VendorName" class="form-control required" >
                                        <input type="hidden" name="VendorId" id="VendorId" value="0">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Invoice Date *</label>
                                    <input id="InvoiceDate" name="InvoiceDate" type="text" class="form-control mydatepicker required">
                                </div>
								
								<div class="form-group col-md-3">
                                    <label>Invoice No. *</label>
                                    <input name="InvoiceNo" id="InvoiceNo" type="text" placeholder="Enter Invoice No"  class="form-control required">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Invoice Total Amount *</label>
                                    <input name="InvoiceTotalAmount" id="InvoiceTotalAmount" type="number" placeholder="Enter Invoice Total Amount"  class="form-control required">
                                </div>
								
								<div class="form-group col-lg-12 text-center">
								    <a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-target="#addproduct">Add Products</a>
                                </div>
								
                                <div class="form-group col-lg-12">
                                    <div class="row">
                                        <div class="panel panel-default panel-table">
                                            <div class="panel-heading">
                                                <div class="tr">
                                                    <div class="td" style="padding:6px;">Brand Name</div>
                                                    <div class="td" style="padding:6px;">Barcode</div>
                                                    <div class="td" style="padding:6px;">Sales Pack</div>
                                                    <div class="td" style="padding:6px;">Batch</div>
                                                    <div class="td" style="padding:6px;">Market Price</div>
                                                    <div class="td" style="padding:6px;">Purchase Price</div>
                                                    <div class="td" style="padding:6px;">Mfg Date</div>
                                                    <div class="td" style="padding:6px;">Expiry</div>
                                                    <div class="td" style="padding:6px;">Quantity</div>
                                                    <div class="td" style="padding:6px;">Action</div>
                                                </div>
                                            </div>
                                            <div class="panel-body" id="productpurchaselist">                                    
                                                    <div id="insertAfter"></div> 
                                                    <!-- <div class="tr">
                                                        <div class="td" style="padding:6px;">Brand Name</div>
                                                        <div class="td" style="padding:6px;">Barcode</div>
                                                        <div class="td" style="padding:6px;">Sales Pack</div>
                                                        <div class="td" style="padding:6px;">Batch</div>
                                                        <div class="td" style="padding:6px;">Market Price</div>
                                                        <div class="td" style="padding:6px;">Purchase Price</div>
                                                        <div class="td" style="padding:6px;">Mfg Date</div>
                                                        <div class="td" style="padding:6px;">Expiry</div>
                                                        <div class="td" style="padding:6px;">Quantity</div>
                                                    </div>      -->                              
                                            </div>
                                            <div class="panel-footer">
                                                <!-- <div class="tr">
                                                    <div class="td" style="padding:6px;"></div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

								
                                <div class="form-group col-lg-12">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input  name="submit" type="submit" value="save" class="btn btn-primary" >
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style type="text/css">
    .ui-autocomplete{
        z-index: 9999;
    }
</style>

<div id="addproduct" class="modal" data-easein="flipXIn" data-backdrop="static" data-keyboard="false"   tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Product Details</h4>
                    <button class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true" onclick="clearform()">Close</button>
                </div>
                <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Product Name *</label>
                                <input id="addProductName" name="addProductName" type="text" class="form-control required">
                                <input id="addProductId" name="addProductId" type="hidden" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>ProductDescription *</label>
                                <input id="addProductDescription" name="addProductDescription" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sales Pack *</label>
                                <input id="addSalesPack" name="addSalesPack" type="text" class="form-control required">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Barcode *</label>
                                <input id="addBarcode" name="addBarcode" type="text" class="form-control required">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Product Quantity *</label>
                                <input id="addProductQuantity" name="addProductQuantity" type="number" class="form-control required">
                            </div>
                            
                             <div class="form-group col-md-6"  >
                                <label>Batch *</label>
                                <input id="addBatch" name="addBatch" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6" >
                                <label>Market Price *</label>
                                <input id="addMarketPrice" name="addMarketPrice" type="number" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Purchase Price *</label>
                                <input id="addPurchasePrice" name="addPurchasePrice" type="number" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Mfg Date *</label>
                                <input id="addMfgDate" name="addMfgDate" type="text" class="form-control required mydatepicker">
                            </div>

                            <div class="form-group col-md-6" >
                                <label>Expiry *</label>
                                <input id="addExpiry" name="addExpiry" type="text" class="form-control required mydatepicker">
                            </div>
                           

                        </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input  name="submit" type="button" class="btn btn-primary" value="Add" name="Save" onclick="addproducttolist();" >
                            </div>
                </div>
        </div>
    </div>
</div>

<div id="editproduct" class="modal" data-easein="flipXIn" data-backdrop="static" data-keyboard="false"   tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px;">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Product Details</h4>
                    <button class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true" onclick="clearform()">Close</button>
                </div>
                <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Product Name *</label>
                                <input id="editProductName" name="editProductName" type="text" class="form-control required">
                                <input id="editProductId" name="editProductId" type="hidden" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>ProductDescription *</label>
                                <input id="editProductDescription" name="editProductDescription" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sales Pack *</label>
                                <input id="editSalesPack" name="editSalesPack" type="text" class="form-control required">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Barcode *</label>
                                <input id="editBarcode" name="editBarcode" type="text" class="form-control required">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Product Quantity *</label>
                                <input id="editProductQuantity" name="editProductQuantity" type="text" class="form-control required">
                            </div>
                            
                             <div class="form-group col-md-6"  >
                                <label>Batch *</label>
                                <input id="editBatch" name="editBatch" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6" >
                                <label>Market Price *</label>
                                <input id="editMarketPrice" name="editMarketPrice" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Purchase Price *</label>
                                <input id="editPurchasePrice" name="editPurchasePrice" type="text" class="form-control required">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Mfg Date *</label>
                                <input id="editMfgDate" name="editMfgDate" type="text" class="form-control required mydatepicker">
                            </div>

                            <div class="form-group col-md-6" >
                                <label>Expiry *</label>
                                <input id="editExpiry" name="editExpiry" type="text" class="form-control required mydatepicker">
                            </div>
                           

                        </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" name="editrowid" id="editrowid" value="0">
                                <input  name="submit" type="button" class="btn btn-primary" value="Update" name="Save" onclick="editproducttolist();" >
                            </div>
                </div>
        </div>
    </div>
</div>