<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Barcode </h2>
        <ol class="breadcrumb">
            <li>
                <a>Barcode</a>
            </li>
            <li class="active">
                <strong>Barcode add</strong>
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
                    <form id="form_Barcode_save"  action="javascript:;" method="POST">
                        <div class="row">

                            <div class="form-group">
                                <label>Product *</label>
                                <select name="ProductId" id="ProductId" class="form-control">
                                    <option value="">Select State</option>
                                <?php foreach ($products as $key => $product) {
                                ?>
                                    <option value="<?php echo $product['id']; ?>"><?php echo $product['ProductName']; ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </div>
                          <!-- <div class="form-group">
                                <label>Barcode Copy Count *</label>
                                <input id="BarcodeCount" name="BarcodeCount" type="text" class="form-control required">
                            </div>-->

                            <div class="form-group col-lg-12">
                                
                                <input  name="submit" type="submit" class="btn btn-primary" value="Generate Barcode"  >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
