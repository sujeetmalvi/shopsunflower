<?php
//pre($details);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<!-- <!DOCTYPE html> -->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <script type="text/javascript"> var BASE_URL = "<?php echo base_url();?>"; </script>
    <script type="text/javascript"> var SITE_URL = "<?php echo site_url(); ?>"; </script>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>  

</head>
<body>
    <div id="wrapper" style="margin-left:20px;margin-right:20px;">
 <input type="button" class="btn btn-primary" onclick="printme('printme') " value="Print">
  <a href="<?php echo site_url('orders/orders_list'); ?>" class="btn btn-info" >Back</a>
<div class="wrapper wrapper-content animated fadeInRight" >

   <div class="row" id="printme">    
    <div class="row">
        <div class="col-xs-12">
           <br>
          
            <div class="row" >
                <div class="col-xs-4 col-md-4 col-lg-4 pull-left">
                    <div class="panel panel-default height">
                    <?php $from=$from[0]; ?>
                        <div class="panel-heading"><b><?php echo strtoupper($from['Name']); ?></b></div>
                        <div class="panel-body">
                            <strong><?php echo strtoupper($from['Address']); ?></strong><br>
                         
                            <strong>Ph.</strong> <?php echo strtoupper($from['Contact']); ?><br>
                            <strong>D.L.No. :</strong> <?php echo strtoupper($from['DLNo']); ?><br>
                            <strong>GSTIN :</strong> <?php echo strtoupper($from['GSTNo']); ?><br>
                            <strong>FASSAI : </strong><?php echo strtoupper($from['FassaiCode']); ?><br>
                            <strong>EMAIL : </strong><?php echo strtoupper($from['Email']); ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4">
                    <div class="panel panel-default height">
                        <div class="panel-heading">GST Tax Invoice</div>
                        <div class="panel-body">
                        <?php $master=$master[0]; ?>
                            <strong>Bill No. : <?php echo $master->BillNo; ?></strong> <br>
                             <strong>Date: <?php echo date('d M Y',strtotime($master->OrderDate));?></strong>
                           
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-md-4 col-lg-4">
                    <div class="panel panel-default height">
                        <div class="panel-heading"><span style="text-align:left;">To,</span><span style="float:right;">Original/Duplicate</span></div>
                        <div class="panel-body">
                        <?php $to = $to[0]; ?>
                        <strong><?php echo strtoupper($to['Name']); ?></strong><br>
                           <?php echo strtoupper($to['Address']); ?><br>                         
                            <strong>Ph.</strong> <?php echo strtoupper($to['Contact']); ?><br>
                            <strong>D.L.No. :</strong> <?php echo strtoupper($to['DLNo']); ?><br>
                            <strong>GSTIN :</strong> <?php echo strtoupper($to['GSTNo']); ?><br>
                            <strong>FASSAI : </strong><?php echo strtoupper($to['FassaiCode']); ?><br>
                            <strong>EMAIL : </strong><?php echo strtoupper($to['Email']); ?>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>         
                                          
                                    <td class="text-center"><strong>SNo</strong></td>
                                    <td class="text-center"><strong>HSN</strong></td>
                                    <td class="text-left"><strong>Product</strong></td>
                                    <td class="text-center"><strong>Pack</strong></td>
                                    <td class="text-center"><strong>Mfg</strong></td>
                                    <td class="text-right"><strong>Qty</strong></td>                                    
                                    <td class="text-center"><strong>DavaIndiaPrice</strong></td>
                                    <td class="text-center"><strong>Market Price</strong></td>
                                    <td class="text-right"><strong>Batch</strong></td>
                                    <td class="text-center"><strong>Exp.</strong></td>
                                    <td class="text-right"><strong>Rate</strong></td>
                                    <!--<td class="text-center"><strong>Disc</strong></td>
                                    <td class="text-center"><strong>Taxable</strong></td>-->
                                    <td class="text-right"><strong>GST%</strong></td>
                                    <td class="text-right"><strong>Amount</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php 
                            	$i=0;
                            	$qty=0;
                            	$amt = 0;
                            	$discount = 0;
                            	$taxable = 0;
                            	$gst=array();
                            	$rate=array();
                            	$cgst=array();
                            	$sgst=array();
                            	foreach($details as $detail)
                            	{

                            	if($detail['ApprovedQuantity']==0){
                            	continue;
                            	break;
                            	}
                            		$gst[$detail['GstValue']][] = $detail['Taxable'];
                            		/*for($l=0;$l<count($Gst);$l++){
                            			if($Gst[$l]==$detail['GstValue'])
                            			{
                            				$rate[$l]=$rate[$l]+$detail['Taxable'];
                            				$cgst[$l]=$cgst[$l]+$detail['Taxable']/2;
                            				$sgst[$l]=$sgst[$l]+$detail['Taxable']/2;
                            			}
                            			
                            		}*/
                            	
                            	
                            	//$taxable = $taxable + $detail['Taxable']; 
                            	$taxable = $taxable + $detail['SalesGST']; 
                            	                          	
                            	//$Amount = ($detail['ProductPurchaseRate']+($detail['ProductPurchaseRate']*$detail['GstActual']/100))*$detail['ApprovedQuantity'];
                            	$Amount = $detail['ProductPurchaseRate']*$detail['ApprovedQuantity'];
                            	 $discount = $discount+($Amount*$detail['Discount']/100); 
                            	$qty=$qty+$detail['ApprovedQuantity'];
                            	//$amt=$qty+$Amount;
                            	if($detail['ApprovedQuantity']!=0){
                            		$amt=$amt+$Amount;
                            	}
                            	
                            		$i++;                            	
                            	?>
                            	<tr>
                            	<td class="text-center"><?php echo $i; ?></td>
                            	<td class="text-center"><?php echo $detail['HSN']; ?></td>
                            	<td class="text-left"><?php echo $detail['ProductName']; ?></td>
                            	<td class="text-center"><?php echo $detail['SalesPack']; ?></td>                            	
                            	<td class="text-center"><?php echo $detail['Mfg']; ?></td>
                            	<td class="text-center"><?php echo number_format($detail['ApprovedQuantity'],2); ?></td>
                            	 <td class="text-center"><?php echo $detail['DavaIndiaPrice']; ?></td>  
                                <td class="text-center"><?php echo $detail['ProductMRP']; ?></td>                                
                                <td class="text-right"><?php echo $detail['Batch']; ?></td>
                                <td class="text-center"><?php echo date('M-y',strtotime($detail['Expiry'])); ?></td>
                                <td class="text-center"><?php echo $detail['ProductPurchaseRate']; ?></td>                               
                                <!--<td class="text-center"><?php echo $detail['Discount']; ?></td>
                                <td class="text-center"><?php echo $detail['Taxable']; ?></td>-->
                                <td class="text-right"><?php echo $detail['GstValue']; ?></td>
                                <?php 
                                	number_format($detail['ApprovedQuantity'],2);
                                ?>
                                <td class="text-right"><strong><?php echo number_format($Amount,2); ?></strong></td>
                                </tr>
                               	<?php 
                               	} 
                               //	pre($gst);?>
                               	
                               	<tr style="border-bottom: 2pt solid black;">
                               	   <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><strong><?php echo number_format($qty,2); ?></strong></td>                                    
                                    <td class="text-center"></td>
                                    <td class="text-right"></td>
                                    <td class="text-center"></td>
                                     
                                    <td class="text-center"></td>
                                    <td class="text-right"></td>
                                    <!--<td class="text-center"></td>
                                    <td class="text-center"></td>-->
                                    <td class="text-right"></td>
                                    <td class="text-right"><strong><?php echo number_format($amt,2); ?></strong></td>
                               	</tr>
                               	<hr>
                               	<tr>
                               	
                               	
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                    <div class="col-md-6 pull-left ">
                    	 <?php 
                                   $SGST=0;
                                   $CGST=0;
					$CGST_value=0;
					$SGST_value=0;
					if( $taxable!=0){
					$CGST = $taxable/2; 
					$SGST = $taxable/2; 
					$CGST_value = ($amt-$discount)*($CGST/100);
					$SGST_value = ($amt-$discount)*($CGST/100);
					}
					 $amt.'<br>';
					 $discount.'<br>';
					 $taxable.'<br>';
//					$totalamount=$amt-$discount+$taxable;
					$totalamount= $amt-$discount+$CGST_value+$SGST_value;
					 $final=round($totalamount);
					if($totalamount>$final){
						$round=$totalamount-$final;
					}
					else{
						$round=$final-$totalamount;
					}
					
                                   ?> 
                    	<table class=" table table-bordered">
                    		  <tr style="background-color: bisque;">                                           
                                    <!--<td class="text-center"><strong>Taxable</strong></td>-->
                                    <td class="text-center"><strong>SGST%</strong></td>
                                    <td class="text-center"><strong>CGST%</strong></td>
                                    <td class="text-center"><strong>SGST</strong></td>
                                    <td class="text-center"><strong>CGST</strong></td>
                                    <td class="text-center"><strong>IGST%</strong></td>
                                    <td class="text-center"><strong>IGST</strong></td>
                                </tr>
                                <?php 
                                //pre($gst);
                                $totalgst=array();
                                foreach ($gst as $key => $val){ 
                                $taxable = array_sum($val);
                             
                                $totalgst[] = $taxable;
                                
                                ?>
                                <tr>
                                	<!--<td class="text-center"><?php echo number_format($taxable,2); ?></td>-->
                                	<td class="text-center"><?php echo number_format($key/2,2); ?>%</td>                                	
                                	<td class="text-center"><?php echo number_format($key/2,2); ?>%</td>
                                	<td class="text-center"><?php echo number_format($taxable/2,2); ?></td>                                	
                                	<td class="text-center"><?php echo number_format($taxable/2,2); ?></td>
                                	<td class="text-center"><?php echo "0.00"; ?></td>
                                	<td class="text-center"><?php echo "0.00"; ?></td>                                	
                                	
                                	
                                	
                                </tr>
                                <?php  }
                                $grandtotalgst = array_sum($totalgst);
                                ?>
                                <tr>
                                	<td colspan="7">
                               		<strong><?php echo strtoupper(getIndianCurrency($final)); ?></strong>
                               		</td>
                               	</tr>
                                
                    	</table>
                    	</div>
                    	
                    	<div class="col-md-3 pull-right ">
                    	
                    	<table class=" table table-bordered">
                    		 <tr style="border-left: 0pt solid black; border-bottom: 0pt solid black;">         
                                         
                                    <td class="text-center"><strong>Discount </strong></td>
				    <td class="text-right"><?php echo number_format($discount,2);?></td>

                                </tr>
                                <tr style="border-left: 0pt solid black; border-bottom: 0pt solid black;">         
                                         
                                    <td class="text-center"><strong>Taxable Amt.</strong></td>
				    <td class="text-right"><?php echo number_format($amt-$discount,2);?></td>

                                </tr>
                                <tr style="border-left: 0pt solid black; border-bottom: 0pt solid black;">         
                                    
                                  
                                    <td class="text-center" ><strong>CGST</strong></td>
                                    <td class="text-right"><?php echo number_format($grandtotalgst/2,2);?></td>
                                </tr>
                                
                                <tr >
                                   
                                    <td class="text-center" ><strong>SGST</strong></td>
                                    <td class="text-right"><?php echo number_format($grandtotalgst/2,2);?></td>
                                </tr>
                                
                                <tr >
                                    
                                    <td class="text-center" ><strong>Rounding Off</strong></td>
                                    <td class="text-right"><?php echo number_format($round,2);?></td>
                                </tr>
                                <tr style="background-color: bisque;">
                                    <td class="text-center"  ><strong style="font-size:18px;">Grand Total <i class="fa fa-inr"></i></strong></td>
                                    <td class="text-right"><?php echo number_format($final,2);?></td>
                                </tr>
                    	</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>
                 
    </div>
  </div>
</div>
 <?php if(isset($js_script)){?>
    <script src="<?php echo base_url('assets/js/pages/');?><?=$js_script?>.js"></script>
    <?php } ?>
   
 <script src="<?php echo base_url('assets/js/jquery-2.1.1.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    </div>
    <?php 
    
function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
      return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise .'Only' ;
      }
    ?>