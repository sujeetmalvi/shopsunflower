<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product Stock</h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product Stock Upload</strong>
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
                <!--<div class="ibox-title">-->
                    <!-- <h5>All form elements <small>With custom checbox and radion elements.</small></h5> -->
                <!--    <form id="form_product_excelupload"  action="javascript:;" method="POST" enctype="multipart/form-data">-->
                <!--        <div class="row">-->
                <!--            <div class="form-group col-md-8">-->
                <!--                &nbsp;                                -->
                <!--            </div>-->
                <!--            <div class="form-group col-md-3">-->
                <!--                <label>Product Excel *</label>-->
                <!--                <input id="excelfile" name="excelfile" type="file" class="form-control required">-->
                <!--                <input type="hidden" id="</?=$csrfName;?>" name="</?=$csrfName;?>" value="</?=$csrfHash;?>" />-->
                <!--                <input  name="submit" type="submit" class="btn btn-primary" name="Upload" >-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </form>-->
                <!--</div>-->
                <div class="ibox-content">
                    <form id="form_productstock_savenew"  action="javascript:;" method="POST" enctype="multipart/form-data">
                        <!--<div class="row">-->
                        <!--    <div class="form-group col-lg-12">-->
                        <!--      <input type="button" class="btn btn-primary pull-right" value="Add More" name="Add More" onclick="addmore();" >-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="row" id="first_row">
                            
                            <div class="form-group col-md-2">
                                <label>Category *</label>
                                <select name="CategoryId" id="CategoryId" class="form-control" onchange='get_designcode_by_categoryid(this.value);' required="">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $category) {?>
                                        <option value="<?php echo $category['id']; ?>">
                                            <?php echo $category['CategoryName']; ?>
                                        </option>
                                    <?php } ?>   
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Design Code *</label>
                                <select name="DesigneCode" id="DesigneCode" class="form-control" onchange='get_productid_by_designcode(this.value);' required="">
                                    <option value="">Select Designe Code</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Product *</label>
                                <select name="ProductId" id="ProductId" class="form-control" required="">
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Stock Type</label>
                                <select name="StockType" id="StockType" class="form-control" required="" onchange='pre_orderid_by_productid(this.value);'>
                                    <option value="">Select Product</option>
                                    <?php foreach($_SERVER['ORDERTYPE'] as $key => $val){?>
                                    <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2" id='divOrderid' style='display:none;'>
                                <label>Order Id</label>
                                <select name="OrderId" id="OrderId" class="form-control" required="" onchange='pre_orderqty_by_orderid_productid();'></select>
                            </div>
                            <div class="form-group col-md-2" id='QtyStock'>
                                <label>Product QTY *</label>
                                <input id="ProductQty" name="ProductQty" type="number" class="form-control" required="" value='1' onclick='this.blur()'>
                            </div>
                            <!--<div class="form-group col-md-1">-->
                            <!--    <label>Action</label><br>-->
                            <!--    <a href="javascript:;" class="btn btn-sm btn-danger" onclick="deleteme(this);"><i class='fa fa-trash'></i></a>-->
                            </div>
                        </div>
                        <div id="insertBefore"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" id="rowcount" name="rowcount" value="1" />
                                <input name="submit" type="button" class="btn btn-success" value="Save" onclick="submitform();" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<select id='cat_list'>-->
<!--</?php foreach ($categories as $key => $category) {?>-->
<!--    <option value="</?php echo $category['id']; ?>">-->
<!--        </?php echo $category['CategoryName']; ?>-->
<!--    </option>-->
<!--</?php } ?>    -->
<!--</select>-->
