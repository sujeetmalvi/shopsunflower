<?php

// pre($data);
// exit;
?>



<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                	<button type="button" class="btn btn-xs btn-primary" id="print" onclick="printme('print_table')">Print</button>
                	<a href="<?php echo site_url('orders/orders_list');?>" class="btn btn-xs btn-success">Orders List</a>
                	<a href="<?php echo site_url('orders/orders_add');?>" class="btn btn-xs btn-warning">Orders Add</a>
                <div class="ibox float-e-margins" id="print_table" >
                    <div class="ibox-title">
                    	<div style="text-align: center;">
                        	<h5>Print Orders</h5>
                        </div>
                        <div class="ibox-tools">
                        	<div class="clearfix"></div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12"><b>Retailer Name:-</b><?php echo $data['User']['RetailerName'];?></div>
                        </div>
                        <div class="row">
							<div class="col-xs-4"><b>DL No. :- </b><?php echo $data['User']['DLNo'];?></div>
							<div class="col-xs-4"><b>TIN No. :-</b><?php echo $data['User']['TinNo'];?></div>
							<div class="col-xs-4"></div>
						</div>
						<div class="row">
							<div class="col-xs-4"><b>Order No. :- </b><?php echo $data['summary'][0]['id'];?></div>
							<div class="col-xs-4"><b>Order Date. :- </b><?php echo date('d-m-Y',strtotime($data['summary'][0]['OrderDate']));?></div>
							<div class="col-xs-4"><b>Stockist Name :- </b><?php echo $data['OrderSubmitedfor']['StockistName'];?></div>
							
						</div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
								<th>SNo.</th>
								<th>Brand Name</th>
								
								<th>Purchase Rate</th>
								<th>MRP</th>
								<th>OrderQuantity</th>
								<th>Amount</th>
							</tr>
                            </thead>
                            <tbody>
								<?php 
								$i=1;
								foreach($data['details'] as $order){

									//$retailer_purchase_rate = sprintf('%0.2f', $order['ProductPurchaseRate']+(($order['ProductPurchaseRate']*$order['PTRMargin'])/100));
									$retailer_purchase_rate = $order['ProductPurchaseRate'];
									$amount = sprintf('%0.2f', $retailer_purchase_rate*$order['OrderQuantity']);

								echo "<tr>
									<td>".$i."</td>
									<td>".$order['ProductName']."</td>
									
									<td>".$retailer_purchase_rate."</td>
									<td>".$order['ProductMRP']."</td>
									<td>".$order['OrderQuantity']."</td>
									<td>".$amount."</td>
								</tr>";
								$i++; } ?>
								<tr>
									<th colspan="5" class="" style="text-align: right;">Total Amount</th>
									<td><?php echo $data['summary'][0]['OrderTotalAmount'];?></td>
								</tr>
							</tbody>	
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
</script>
