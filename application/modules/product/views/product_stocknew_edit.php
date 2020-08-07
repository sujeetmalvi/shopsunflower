<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Product Stock</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a>Company</a>
            </li>
            <li class="active">
                <strong>Product Stock update</strong>
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
                    <form id="form_product_stocknew_update" action="javascript:;" method="POST">
                        <div class="row">

                            <?php //print_r($details); ?>   
                                <div class="form-group">
                                    <label>Product Name*</label>									
                                    <select name="ProductName" id="ProductName" class="form-control"  >
                                        <option value="">Select Product</option>
                                        <?php foreach ($list as $key => $product) {
											
					if($details['ProductId']==$product['id']){
                                        $ProductNameselected = "selected='selected'";
                                    }else{
                                        $ProductNameselected = "";
                                    }
									?>
                                            <option value="<?php echo $product['id']; ?>" <?php echo $ProductNameselected ;?>><?php echo $product['ProductName']; ?>
                                            </option>
                                            <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Product Quantity *</label>
                                    <input id="ProductQuantity" value="<?php echo $details['ProductQuantity'];?>" name="ProductQuantity" type="text" class="form-control required">
                                </div>
                                
                               
                                    <input id="id" value="<?php echo $details['id'];?>" name="id" type="hidden" class="form-control required">
                                

                                <div class="form-group">
                                    <label>MRP *</label>
                                    <input id="MRP" value="<?php echo $details['MRP'];?>" name="MRP" type="text" class="form-control required">
                                </div>
								
                                <div class="form-group">
                                    <label>DiPrice *</label>
                                    <input id="Diprice" value="<?php echo $details['DiPrice'];?>" name="Diprice" type="text" class="form-control required">
                                </div>
                                
                                <div class="form-group">
                                    <label>Batch *</label>
                                    <input id="Batch" value="<?php echo $details['Batch'];?>" name="Batch" type="text" class="form-control required">
                                </div>

                                <div class="form-group">
                                    <label>Expiry *</label>
                                    <input id="Expiry" value="<?php echo $details['Expiry'];?>" name="Expiry" type="text" class="form-control required">
                                </div>
								
                                <div class="form-group">
                                    <label>MfgDate*</label>
                                    <input id="MfgDate" value="<?php echo $details['MfgDate'];?>" name="MfgDate" type="text" class="form-control required">
                                </div>
                                
                                <div class="form-group">
                                    <label>Received Remarks*</label>
                                    <textarea id="ReceivedRemarks" name="ReceivedRemarks" class="form-control required"><?php echo $details['ReceivedRemarks'];?></textarea>
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
