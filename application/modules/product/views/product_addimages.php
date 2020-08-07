<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product </h2>
        <ol class="breadcrumb">
            <li>
                <a>Product</a>
            </li>
            <li class="active">
                <strong>Product Upload images</strong>
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
                    <form id="form_product_addimages"  action="javascript:;" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Product Image1</label>
                                <input id="ProductImage1" name="ProductImage1" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image2</label>
                                <input id="ProductImage2" name="ProductImage2" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image3</label>
                                <input id="ProductImage3" name="ProductImage3" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image4</label>
                                <input id="ProductImage4" name="ProductImage4" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image5</label>
                                <input id="ProductImage5" name="ProductImage5" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image6</label>
                                <input id="ProductImage6" name="ProductImage6" type="file" class="form-control required">
                            </div>
                            <div class="form-group col-lg-12">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input type="hidden" id="ProductId" name="ProductId" value="<?=$_GET['ProductId'];?>" />
                                <input type="hidden" id="DesigneCode" name="DesigneCode" value="<?=$_GET['DesigneCode'];?>" />
                                <input type="hidden" id="ColourId" name="ColourId" value="<?=$_GET['ColourId'];?>" />
                                <input  name="submit" type="submit" class="btn btn-primary" value="Save" name="Save" >
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col-lg-12">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title">
                    </div>
                    <div class="ibox-content">

                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php echo $list; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                                <th style="width:30px;">S.No.</th>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</div>
