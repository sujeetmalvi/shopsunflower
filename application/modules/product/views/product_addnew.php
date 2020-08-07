<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product </h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product Upload</strong>
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
                <!--                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />-->
                <!--                <input  name="submit" type="submit" class="btn btn-primary" name="Upload" >-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </form>-->
                <!--</div>-->
                <div class="ibox-content">
                    <form id="form_product_savenew"  action="javascript:;" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Category *</label>
                                <select name="CategoryId" id="CategoryId" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php foreach ($categories as $key => $category) {?>
                                        <option value="<?php echo $category['id']; ?>">
                                            <?php echo $category['CategoryName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Colour *</label>
                                <select name="ColourId" id="ColourId" class="form-control">
                                    <option value="">Select Colour</option>
                                    <?php foreach ($colours as $key => $colour) {?>
                                        <option value="<?php echo $colour['id']; ?>">
                                            <?php echo $colour['ColourName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Size *</label>
                                <select name="SizeId" id="SizeId" class="form-control">
                                    <option value="">Select Size</option>
                                    <?php foreach ($sizes as $key => $size) {?>
                                        <option value="<?php echo $size['id']; ?>">
                                            <?php echo $size['SizeName']; ?>
                                        </option>
                                        <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Name *</label>
                                <input id="ProductName_add" name="ProductName" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Price *</label>
                                <input id="ProductPrice" name="ProductPrice" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Thumbnail </label>
                                <input id="ProductThumbnail" name="ProductThumbnail" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Designe Code *</label>
                                <input id="DesigneCode" name="DesigneCode" type="text" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Offer Price </label>
                                <input id="IsOffer" name="IsOffer" type="checkbox" value="1">
                                <input id="OfferPrice" name="OfferPrice" type="text" class="form-control" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Visible Status </label>
                                <input id="VisibleStatus" name="VisibleStatus" type="checkbox" value="1" >
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pre Order enabled ?</label>
                                <input id="IsPreOrder" name="IsPreOrder" type="checkbox" value="1" >
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input  name="submit" type="button" class="btn btn-primary" value="Save" name="Save" onclick="submitform();" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
