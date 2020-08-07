<?php
//pre($data);
//exit; 
?>
<div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if($data['summary'][0]['TransactionType']=='3'){
                    ?>
                	   <a href="#" class="btn btn-sm btn-primary"  onclick="unholdorder(<?php echo $data['summary'][0]['id'];?>);">Un-Hold</a>

                       <a href="#" class="btn btn-sm btn-danger"  onclick="cancelholdorder(<?php echo $data['summary'][0]['id'];?>)">Cancel</a>

                	<?php }elseif($data['summary'][0]['TransactionType']=='1'){?>
                        <a href="#" class="btn btn-sm btn-success" id="print" onclick="printme('print_table')">Print</a>
                    <?php } ?>

                	<a href="<?php echo site_url('pos/pos_orders_add');?>" class="btn btn-sm btn-warning">Add Orders</a>
                <div class="ibox float-e-margins" id="print_table" >
                    <div class="ibox-title">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <h2><b><?php echo $data['OrderSubmitedfor']['RetailerName']; ?></b></h2>
                                        <span style="font-size:12px;"><?php echo $data['OrderSubmitedfor']['Address'].' , '.$data['OrderSubmitedfor']['CityName'].' , '.$data['OrderSubmitedfor']['StateName']; ?></span>
                                    </td>
                                    <td>
                                        <?php if($data['summary'][0]['TransactionType']=='1'){?>
                                        <h5>Bill of Orders (Sales)</h5>
                                        <?php } ?>
                                        <?php if($data['summary'][0]['TransactionType']=='2'){?>
                                        <h5>Bill of Orders (Return)</h5>
                                        <?php } ?>
                                        <br><br>
                                        Original
                                    </td>
                                    <td>
                                         Ph:0731-421547
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Customer Name :- </b><?php echo $data['User']['CustomerName'].' ( '.$data['User']['CustomerMobile'].' )';?>
                                    </td>
                                    <td>
                                        <b>Area :- </b><?php echo $data['User']['CityName'];?>
                                    </td>
                                    <td>
                                        <b>Bill No. :- </b> <?php echo $data['summary'][0]['id'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>Doctor Name :- </b><?php echo 'Dr. Praful Shah ( 9865325896 )';?>
                                    </td>
                                    <td>
                                        <b>Date :- </b><?php echo date('d-m-Y',strtotime($data['summary'][0]['OrderDate']));?>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
								<th>SNo.</th>
								<th>Brand Name</th>
								<!-- <th>Composition</th> -->
								<th>MRP</th>
								<th>Qty</th>
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
                                $amtwithtax = sprintf('%0.2f',round($amtwithtax,0,PHP_ROUND_HALF_UP));
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
                                    <th><?php echo $amtwithtax;?></th>
                                </tr>
                                <tr>
                                    <td colspan="5" class="" style="text-align: left;">In words: <b><?php echo convert_number_to_words($amtwithtax);?></b>.</td>
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
