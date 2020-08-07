<div class="wrapper wrapper-content animated fadeInRight">
    <form id="form_orders_dispatch"  action="javascript:;" method="POST">
            <div class="row">
                <div class="col-lg-12">
                	<!--<button type="button" class="btn btn-xs btn-primary" id="print" onclick="printme('print_table')">Print</button>-->
                <div class="ibox float-e-margins" id="print_table" >
                    <div class="ibox-title">
                    	<div style="text-align: center;">
                        	<h5>Orders Generate</h5>
                        </div>
                        <div class="ibox-tools">
                        	<div class="clearfix"></div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-4"><b>Shop Name:-</b><?php echo $customer_data['FromName'];?></div>
                        	<div class="col-xs-4"><b>Bill Date:-</b><input type='text' name="InvoiceDate" id="InvoiceDate" class="form-control mydatepicker" ></div>
                        	<div class="col-xs-4"><b>Bill No.:-</b><input type='text' name="InvoiceNumber" id="InvoiceNumber" class="form-control" ></div>
                        </div>
						<div class="row">
							<div class="col-xs-4"><b>Order No. :- </b><?php echo $data[0]['OrderId'];?></div>
							<div class="col-xs-4"><b>Order Date. :- </b><?php echo date('d-m-Y H:i A',strtotime($data[0]['OrderedDateTime']));?></div>
							<div class="col-xs-4"><b>Person Name :- </b><?php echo $customer_data['FullName'];?></div>
							
						</div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
								<th>SNo.</th>
								<th>Product Design</th>
								<th>Color</th>
								<th>Size</th>
								<!--<th>OrderQuantity</th>-->
								<th style='width:200px;'>ProductUIC</th>
								<th>Price</th>
								<th>Amount</th>
							</tr>
                            </thead>
                            <tbody>
								<?php 
								$i=1;$total_amount = 0;
								if(is_array($data)){
								foreach($data as $order){
								    
								    $OrderId = $order['OrderId'];
								    $UserId = $order['UserId'];

									//$retailer_purchase_rate = sprintf('%0.2f', $order['PurchaseRate']+(($order['PurchaseRate']*$order['PTRMargin'])/100));
									
									$ProductUIC_arr = explode(',',$order['ProductUIC']);
									$productUIC_with_chkbx='';
									$OrderQuantity=0;
									foreach($ProductUIC_arr as $uic){  //onchange='calculate_amount(".$order['id'].")'
									    $disp_prod_UIC = explode(',',$order['DispatcProductUIC']);
									    if(!in_array($uic,$disp_prod_UIC)){
    									    $productUIC_with_chkbx .= "<label><input type='checkbox' data-orderid='".$order['id']."' name='dispatch_productUIC[".$order['id']."][]' class='dispatch_productUIC dispatchprod".$order['id']."' value='".$uic."' checked='checked' > ".$uic."</label><br>";
    									    $OrderQuantity++;
									    }
									}
									$amount = sprintf('%0.2f', $order['Price']*$OrderQuantity);

								echo "<tr>
									<td>".$i."</td>
									<td>".$order['DesigneCode']."</td>
									<td>".$order['ColourName']."</td>
									<td>".$order['SizeName']."</td>";
								//	<td><input type='text' onfocus='this.blur()' onblur=\"check_quantity('".$order['OrderQuantity']."',this.value,'OrderQuantity".$order['id']."')\" id='OrderQuantity".$order['id']."' name='OrderQuantity[".$order['id']."]' value='".$order['OrderQuantity']."'  /></td>
								echo "<td>".$productUIC_with_chkbx."</td>
									<td>".$order['Price']."<input type='hidden' id='price".$order['id']."' value='".$order['Price']."' /></td>
									<td>
									    <span id='show_amount".$order['id']."'>".$amount."</span>
									    <input type='hidden' class='amount' id='amount".$order['id']."' name='Amount[".$order['id']."]' value='".$amount."' />
									    
									    <input type='hidden' class='quantity' id='quantity".$order['id']."' name='OrderQuantity[".$order['id']."]' value='".$OrderQuantity."' />
									    <input type='hidden' class='actual_quantity' id='actual_quantity".$order['id']."' name='ActualOrderQuantity[".$order['id']."]' value='".$OrderQuantity."' />
									    
									    <input type='hidden' id='ProductId".$order['id']."' name='ProductId[".$order['id']."]' value='".$order['ProductId']."' />
									    <input type='hidden' id='DesigneCode".$order['id']."' name='DesigneCode[".$order['id']."]' value='".$order['DesigneCode']."' />
									    <input type='hidden' id='Price".$order['id']."' name='Price[".$order['id']."]' value='".$order['Price']."' />
									    <input type='hidden' id='ColourId".$order['id']."' name='ColourId[".$order['id']."]' value='".$order['ColourId']."' />
									    <input type='hidden' id='SizeId".$order['id']."' name='SizeId[".$order['id']."]' value='".$order['SizeId']."' />
									    <input type='hidden' id='OrderType".$order['id']."' name='OrderType[".$order['id']."]' value='".$order['OrderType']."' />
									    <input type='hidden' id='ProductUIC".$order['id']."' name='ProductUIC[".$order['id']."]' value='".$order['ProductUIC']."' />
									    <input type='hidden' id='OrderTblId".$order['id']."' name='OrderTblId[".$order['id']."]' value='".$order['id']."' />
									</td>
								</tr>";
								$total_amount += $amount;
								$i++; } } ?>
								<tr>
									<th colspan="6" class="" style="text-align: right;">Total Amount</th>
									<th><span id='total_amount'></span></th>
								</tr>
								<tr>
									<th colspan="6" class="" style="text-align:center;">
									    <input type='hidden' name='TotalAmount' id='TotalAmount' value='<?php echo $total_amount;?>' />
									    <input type='hidden' name='OrderId' id='OrderId' value='<?php echo $OrderId;?>' />
									    <input type='hidden' name='UserId' id='UserId' value='<?php echo $UserId;?>' />
									    <input type='submit' class="btn btn-primary" style="margin-top:16px;" name="submit" value="Dispatch" >
									</th>
								</tr>
							</tbody>	
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </form>
</div>
<script type="text/javascript">
function printme(id){
     var printContents = document.getElementById(id).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     window.close();
    //  document.body.innerHTML = originalContents;
    // //  setTimeout(function(){
    // //     location.reload();
    // // },0);
}
	//printme('print_table');
	
function calculate_total_amount(){
    var total_amount = 0;
    $(".amount").each(function() {
        var amt = $( this ).val();
      total_amount +=parseInt(amt);
    });
    $('#total_amount').text(total_amount.toFixed(2));
}

    calculate_total_amount();
	
	
</script>
