<?php
//pre($data);
//exit; 
?>

<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                	<button type="button" class="btn btn-xs btn-primary" id="print" onclick="printme('print_table')">Print</button>
                	<a href="<?php echo site_url('pos/pos_orders_list');?>" class="btn btn-xs btn-success">Orders List</a>
                	<a href="<?php echo site_url('pos/pos_orders_add');?>" class="btn btn-xs btn-warning">Orders Add</a>
                <div class="ibox float-e-margins" id="print_table" >
                    <div class="ibox-title">
                    	<div style="text-align: center;">
                            <?php if($data['summary'][0]['TransactionType']=='1'){?>
                        	<h5>Print Orders (Sales)</h5>
                            <?php } ?>
                            <?php if($data['summary'][0]['TransactionType']=='2'){?>
                            <h5>Print Orders (Return)</h5>
                            <?php } ?>
                        </div>
                        <div class="ibox-tools">
                        	<div class="clearfix"></div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12"><b>Customer Name :- </b><?php echo $data['User']['CustomerName'];?></div>
                        </div>
						<div class="row">
							<div class="col-xs-4"><b>Order No. :- </b><?php echo $data['summary'][0]['id'];?></div>
							<div class="col-xs-4"><b>Order Date. :- </b><?php echo date('d-m-Y',strtotime($data['summary'][0]['OrderDate']));?></div>
							<div class="col-xs-4"><b>Retailer Name :- </b><?php echo $data['OrderSubmitedfor']['RetailerName'];?></div>
							
						</div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
								<th>SNo.</th>
								<th>Brand Name</th>
								<!-- <th>Composition</th> -->
								<th>MRP</th>
								<th>OrderQuantity</th>
								<th>Amount</th>
							</tr>
                            </thead>
                            <tbody>
								<?php 
								$i=1;
								foreach($data['details'] as $order){

									$retailer_MrpRate = $order['MrpRate'];//sprintf('%0.2f', $order['PurchaseRate']+(($order['PurchaseRate']*$order['PTRMargin'])/100));
									$amount = sprintf('%0.2f', $retailer_MrpRate*$order['OrderQuantity']);

    								echo "<tr>
    									<td>".$i."</td>
    									<td>".$order['ProductName']."</td>";
    									//<td>".$order['Composition']."</td>
    								echo "<td>".$order['MrpRate']."</td>
    									<td>".$order['OrderQuantity']."</td>
    									<td>".$amount."</td>
    								</tr>";
								$i++; } 

                                $amt = $data['summary'][0]['OrderTotalAmount'];
                                $tax = $data['summary'][0]['TaxPercentage'];
                                $taxamount = $amt*($tax/100);
                                $amtwithtax = $amt+$taxamount;

                                ?>
								<tr>
									<td colspan="4" class="" style="text-align: right;">Amount</td>
									<td><?php echo $data['summary'][0]['OrderTotalAmount'];?></td>
								</tr>

                                <tr>
                                    <td colspan="4" class="" style="text-align: right;">Tax % @<?php echo $data['summary'][0]['TaxPercentage'];?></td>
                                    <td><?php echo sprintf('%0.2f',$taxamount);?></td>
                                </tr>
                                
                                <tr>
                                    <th colspan="4" class="" style="text-align: right;">Final Amount</th>
                                    <th><?php echo $data['summary'][0]['AmountWithTax'];?></th>
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
