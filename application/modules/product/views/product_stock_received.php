<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Stock Received </h2>
        <ol class="breadcrumb">
            <li>
                <a>Stock</a>
            </li>
            <li class="active">
                <strong>Stock Received</strong>
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
                        <div class="row">
                            <div class="form-group col-md-8">
                                <a class="btn btn-xs btn-primary" href="javascript:;" onclick="get_product_details_by_id('0','all_products')">All Products</a>
                                <a class="btn btn-xs btn-danger" onclick="remove_all_products()" href="javascript:;">Remove All Products</a>
                            </div>
                            <div class="form-group col-md-3">
                                <form id="form_product_stock_excelupload"  action="javascript:;" method="POST" enctype="multipart/form-data">
                                    <label>Product Stock *</label>
                                    <input id="excelfile" name="excelfile" type="file" class="form-control  required">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input  name="submit" type="submit" class="btn btn-xs btn-primary" name="Upload" >
                                </form>
                            </div>
                        </div>
                    
                </div>
                <div class="ibox-content">
                    <form id="form_product_stock_received_save"  action="javascript:;" method="POST">
                        <input type="hidden" id="UserRole" name="UserRole" value="<?php echo $_SESSION['user_role']?>">
                        <input type="hidden" id="rowid" name="rowid" value="0">
                        <input type="hidden" id="TotalAmount" name="TotalAmount" value="0">
                        <div class="row">

                            <div class="form-group">
                                
                                <div class="col-md-4">
                                        <label>Date *</label>
                                        <input id="OrderDate" name="OrderDate" class="form-control mydatepicker" placeholder="Select Date" value="<?php echo date('d-m-Y');?>">
                                </div>
                                <div class="col-md-4">
                                        <label>Refference Order No.</label>
                                        <input id="RefferenceOrderNo" name="RefferenceOrderNo" class="form-control">
                                </div>
                                <div class="col-md-4">
                                        <label>Choose Product(s) *</label>
                                        <input id="ProductName" class="form-control" placeholder="Type product name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <br>
                        </div>
                        <div class="row">

                                <div class="panel panel-default panel-table">
                                    <div class="panel-heading">
                                        <div class="tr">
                                            <!-- <div class="td">Division</div>-->
                                            <!-- <div class="td">Composition</div>-->
                                            <div class="td">Brand Name</div>
                                            <!-- <div class="td">Packtype1</div> -->
                                            <!-- <div class="td">Packtype2</div> -->
                                            <!-- <div class="td">Shipper Pack</div> -->
                                            
                                            <div class="td">Batch No.</div>
                                            <div class="td">Expiry</div>
                                            <div class="td">MFG Date</div>
                                            <!-- <div class="td">Purchase Rate</div> -->
                                            <div class="td">MRP</div>
                                            <div class="td">Di Price</div>
                                            <div class="td">PTR</div>
                                            <div class="td">Quantity</div>
                                            <!-- <div class="td">Amount</div> -->
                                        </div>
                                    </div>
                                    <div class="panel-body" id="productlist">
                                            <div id="insertbefore"></div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="tr">
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <div class="td"></div>
                                            <!-- <div class="td"></div> -->
                                            <!-- <div class="td"></div> -->
                                            <!-- <div class="td"></div> -->
                                            <!-- <div class="td"></div> -->
                                            <div class="td"></div> <!-- Total -->
                                            <div class="td"></div> <!-- id="showtotalamount" -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <input id="submit"  name="submit" type="button" class="btn btn-primary pull-right" onclick="form_product_stock_received_save();" >
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
