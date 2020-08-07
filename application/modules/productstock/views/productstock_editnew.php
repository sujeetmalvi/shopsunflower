<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product Stock</h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product Stock Edit</strong>
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
                <div class="ibox-content">
                    <form id="form_productstock_updatenew"  action="javascript:;" method="POST" enctype="multipart/form-data">
                        <!--<div class="row">-->
                        <!--    <div class="form-group col-lg-12">-->
                        <!--      <input type="button" class="btn btn-primary pull-right" value="Add More" name="Add More" onclick="addmore();" >-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="row" id="first_row">
                            
                            <div class="form-group col-md-3">
                                <label>Category *</label>
                                <select name="CategoryId" id="CategoryId" class="form-control" onchange='get_designcode_by_categoryid(this.value);' required="">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $category) {?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo ($list->CategoryId == $category['id'])?"selected='selected'":""; ?> >
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
                            <!--<div class="form-group col-md-3">-->
                            <!--    <label>Product UIC *</label>-->
                            <!--    <input id="ProductUIC" name="ProductUIC" type="text" class="form-control required">-->
                            <!--</div>-->
                            <div class="form-group col-md-3" style="display:none;">
                                <label>Product QTY *</label>
                                <input id="ProductQty" name="ProductQty" type="number" class="form-control" required="" value='1'>
                            </div>
                            <!--<div class="form-group col-md-1">-->
                            <!--    <label>Action</label>-->
                            <!--    <a href="javascript:;" class="btn btn-sm btn-danger" onclick="deleterow(this);"><i class='fa fa-trash'></i></a>-->
                            <!--</div>-->
                        </div>
                        <div id="insertBefore"></div>
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" id="ProductStockId" name="ProductStockId" value="<?=$list->id;?>" />
                                <input name="submit" type="button" class="btn btn-success" value="Update" onclick="submitformupdate();" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

$(document).ready(function() {
  get_designcode_by_categoryid('<?php echo $list->CategoryId; ?>','<?php echo $list->DesigneCode; ?>');
  get_productid_by_designcode('<?php echo $list->DesigneCode; ?>','<?php echo $list->ProductId; ?>');
  debugger;
});
    
</script>

