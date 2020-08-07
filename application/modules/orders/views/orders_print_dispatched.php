<?php
//  pre($summary);
//  pre($list);
?>
    <button type="button" class="btn btn-xs btn-primary" id="print" onclick="printme('print_table')">Print</button>
    <div id="print_table" >
    <div id="orderdetails">
        <table border='1' cellpadding='10' cellspacing='0' width='90%' style='margin:0 auto;font-family: sans-serif;font-size: small;'>
            <tr>
                <td style='text-align:center;' colspan='5'><img alt="image" class="img-responsive" src="<?php echo base_url('assets/img/logo.jpg');?>" style="border:1px solid #ffffff; padding:2px;border-radius:10px;height:50px;"></td>
            </tr>
            <tr>
                <td><strong>OrderId</strong> - <?php echo $summary->OrderId;?> </td>
                <td><strong>Bill No.</strong>-<?php echo $summary->InvoiceNumber;?></td>
                <td><strong>Invoice Date</strong> - <?php echo $summary->InvoiceDate;?></td>
                <td><strong>Shop Name.</strong> <?php echo $summary->ShopName.' ('.$summary->GstinNo.')';?></td>
                <td><strong>Member Name.</strong> <?php echo $summary->FullName.' ('.$summary->ContactNo.')';?></td>
                
            </tr>
        </table>
        <table border='1' cellpadding='10' cellspacing='0' width='90%' style='margin:0 auto;font-family: sans-serif;font-size: small;' >
            <tr>
                
                <th>Product UIC</th>
                <th>Product Design</th>
                <th>Order Type</th>
                <th>Colour</th>                      
                <th>Size</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
            <?php $total=0; foreach($list as $l){?>
            <tr>
                <td><?php echo $l['ProductUIC'];?></td>
                <td><?php echo $l['DesigneCode'];?></td>
                <td><?php echo $_SERVER['ORDERTYPE'][$l['OrderType']];?></td>
                <td><?php echo $l['ColourName'];?></td>
                <td><?php echo $l['SizeName'];?></td>
                <td style='text-align:right;'><?php echo $l['ProductQty'];?></td>
                <td style='text-align:right;'><?php echo $l['Price'];?></td>
                <td style="text-align:right;"><?php $amount = $l['ProductQty']*$l['Price']; echo number_format((float)$amount, 2, '.', '');  $total+=$amount;?></td>
            </tr>
            <?php }?>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th id="showtotalamount" style='text-align:right;'><?php echo number_format((float)$total, 2, '.', '');?></th>
            </tr>
        </table>
        <table border='1' cellpadding='0' cellspacing='0' width='90%' style='margin:0 auto;font-family: sans-serif;font-size: small;' >
            <tr>
                <td style='text-align:center;'>Designed & Developed by Melhor Technologies Pvt. Ltd. </td>
            </tr>
        </table>
        
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
