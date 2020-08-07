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

                       &nbsp; &nbsp; <a href="#" class="btn btn-sm btn-danger"  onclick="cancelholdorder(<?php echo $data['summary'][0]['id'];?>)">Cancel</a>

                	<?php }elseif($data['summary'][0]['TransactionType']=='1'){?>
                        <a href="#" class="btn btn-sm btn-success" id="print" onclick="printme('print_table')">Print</a>
                    <?php } ?>

                	
                <div class="ibox float-e-margins" id="print_table" >
                    <div class="ibox-title">

                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="5">
                                        <h2><b><?php echo $data['OrderSubmitedfor']['RetailerName']; ?></b></h2>
                                        <span style="font-size:12px;"><?php echo $data['OrderSubmitedfor']['Address'].' , '.$data['OrderSubmitedfor']['CityName'].' , '.$data['OrderSubmitedfor']['StateName']; ?></span>
                                    </td>
                                    <td colspan="2">
                                        <img src="<?php echo base_url('assets/img/davaindia-logo.png');?>" style="width:200px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>DL.No. </b><?php echo $data['OrderSubmitedfor']['DLNo'];?>
                                    </td>
                                    <td colspan="3">
                                         <b>GST No. </b><?php echo $data['OrderSubmitedfor']['CSTNo'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>Store Contact No.</b><?php echo $data['OrderSubmitedfor']['RetailerContactNo'];?>
                                    </td>
                                    <td colspan="3">
                                         <b>Memo Type.</b> <?php echo $_SERVER['PAYMENT_MODES'][$data['summary'][0]['PaymentMode']];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>Invoice No.</b><?php echo $data['summary'][0]['OrderId'];?>
                                    </td>
                                    <td colspan="3">
                                        <b>Date :- </b><?php echo date('d-m-Y',strtotime($data['summary'][0]['OrderDate']));?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <b>Customer Name :- </b><?php echo $data['User']['CustomerName'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <b>Contact No. </b><?php echo $data['User']['CustomerMobile']; ?>
                                    </td>
                                    <td colspan="3">
                                         <b>Email Id. </b><?php echo $data['User']['CustomerEmail']; ?>
                                    </td>
                                </tr>
                                <?php if(DOCTOR_INFO==true){?>
                                <tr>
                                    <td colspan="7">
                                        <b>Doctor Name :-</b> Dr. Naman Pathak ( 9852365475 , drnaman@gmail.com )
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr>
								<th>SNo.</th>
								<th>Product Name</th>
								<th>Pack</th>
                                <th>Batch No.</th>
                                <th>Exp. Date</th>
								<th>Qty</th>
                                <th>MRP</th>								
								<th style="text-align: right;">Value</th>
							</tr>
                            </thead>
                            <tbody>
								<?php 
								$i=1;
								foreach($data['details'] as $order){

									$retailer_MrpRate = $order['ProductMRP'];//sprintf('%0.2f', $order['PurchaseRate']+(($order['PurchaseRate']*$order['PTRMargin'])/100));
									$amount = sprintf('%0.2f', $retailer_MrpRate*$order['OrderQuantity']);

    								echo "<tr>
    									<td>".$i."</td>
    									<td>".$order['ProductName']."</td>
                                        <td>".$order['SalesPack']."</td>
                                        <td>".$order['Batch']."</td>
                                        <td>".$order['Expiry']."</td>";
    									//<td>".$order['Composition']."</td>
    								echo "<td>".$order['OrderQuantity']."</td>
                                          <td>".$order['ProductMRP']."</td>
    									  <td style='text-align: right;'>".$amount."</td>
    								</tr>";
								$i++; } 

                                $amt = $data['summary'][0]['OrderTotalAmount'];
                                $tax = $data['summary'][0]['TaxPercentage'];
                                $taxamount = $amt*($tax/100);
                                $amtwithtax = $amt+$taxamount;
                                $amtwithtax = sprintf('%0.2f',round($amtwithtax,0,PHP_ROUND_HALF_UP));
                                ?>
								<tr>
                                    <td rowspan="5" colspan="3" class="" style="text-align: left;border-right:solid 1px;"><br><br><br><br><br><br>Customer Care <br>(Dava India)<br> ***********</td>
                                    <td rowspan="5" colspan="3" class="" style="text-align: center;border-right:solid 1px;"><br><br><br><br>Visit us at <br>davindia.com
                                    </td>
									<td class="" style="text-align: right;">Gross Value (₹) </td>
									<td style="text-align: right;"><?php echo $data['summary'][0]['OrderTotalAmount'];?></td>
								</tr>
                                <tr>
                                    <td  class="" style="text-align: right;">
                                       <!-- GST @<?php echo '';//$data['summary'][0]['TaxPercentage'];?> % -->
                                    </td>
                                    <td><?php echo ''; //sprintf('%0.2f',$taxamount);?></td>
                                </tr>
                                <tr>
                                    <td  class="" style="text-align: right;">
                                     <!--   IGST @<?php echo '';//$data['summary'][0]['TaxPercentage'];?>% -->
                                    </td>
                                    <td><?php echo '';//sprintf('%0.2f',$taxamount);?></td>
                                </tr>
                                <tr>
                                    <td class="" style="text-align: right;">Discount</td>
                                    <td style="text-align: right;">0.00</td>
                                </tr>
                                <tr>
                                    <td class="" style="text-align: right;">Net Value (₹) </td>
                                    <td style="text-align: right;"><b><?php echo $data['summary'][0]['OrderTotalAmount'];//$amtwithtax;?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="" style="text-align: left;">In words: 
                                        <!--<b><?php echo '';//convert_number_to_words($amtwithtax);?></b>. -->
                                        <b><?php echo convert_number_to_words($data['summary'][0]['OrderTotalAmount']);?></b>.
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="" style="text-align: left;">Customer Care (Davaindia) :</td>
                                    <td colspan="3" class="" style="text-align: left;">Visit us at davaindia.com</td>
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
     document.body.innerHTML = originalContents;
    // //  setTimeout(function(){
    // //     location.reload();
    // // },0);
}
	//printme('print_table');
</script>



<div id="calculator" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 414px;">
            <div class="modal-header">
                <h4 class="modal-title theme-text">
                Calculator
                </h4>
            </div>
            <div class="modal-body" id="print_table">
                <FORM NAME="Calc" action="javascript:;">
                    <TABLE class="table table-bordered">
                        <TR>
                            <TD>
                                <INPUT CLASS="DISPLAY" TYPE="text"   NAME="Input" Size="16">
                                <br>
                            </TD>
                        </TR>
                        <TR>
                            <TD>
                                <INPUT CLASS="MYBUTTON" CLASS="MYBUTTON" TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
                                <br>
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="minus" VALUE="  -  " OnClick="Calc.Input.value += ' - '">
                                <br>
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
                                <br>
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="clear" VALUE="  c  " OnClick="Calc.Input.value = ''">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
                                <INPUT CLASS="MYBUTTON" TYPE="button" NAME="div"   VALUE="  /  " OnClick="Calc.Input.value += ' / '">
                                <br>
                            </TD>
                        </TR>
                    </TABLE>
                </FORM>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>
