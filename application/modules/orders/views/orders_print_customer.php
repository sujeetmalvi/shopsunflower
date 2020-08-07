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
                <div class="panel panel-default panel-table" id="orderdetails"><div class="panel-heading" id="panelheading">
                    <div class="tr">
                        <div class="td">OrderId</div>
                        <div class="td">Product UIC</div>
                        <div class="td">OrderType</div>
                        <div class="td">Product Design</div>                       
                        <div class="td">Colour</div>                      
                        <div class="td">Size</div>
                        <div class="td">Quantity</div>
                        <div class="td">Price</div>
                        <div class="td">Amount</div>
                    </div>
                </div>
                <div class="panel-body" id="orderdetailsbody">
                    <div class="tr">
                        <div class="td">1593849134</div>
                        <div class="td">20070200000001</div>
                        <div class="td">READY-STOCK</div>
                        <div class="td">Gown1</div>                       
                        <div class="td">Dark Blue</div>
                        <div class="td">Medium</div>
                        <div class="td">1</div>
                        <div class="td">200.00</div>
                        <div class="td" style="text-align:right;">200.00</div>
                    </div>
                 </div>
                <div class="panel-body" id="orderdetailsbody">
                    <div class="tr">
                        <div class="td">1593849134</div>
                        <div class="td">20070100000008</div>
                        <div class="td">READY-STOCK</div>
                        <div class="td">Gown1</div>                       
                        <div class="td">Dark Blue</div>
                        <div class="td">Extra Large</div>
                        <div class="td">1</div>
                        <div class="td">200.00</div>
                        <div class="td" style="text-align:right;">200.00</div>
                    </div>
                 </div><div class="panel-footer" id="orderdetailsfooter">
                    <div class="tr">
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td"></div>
                        <div class="td">Total</div>
                        <div class="td" id="showtotalamount">400.00</div>
                    </div>
                </div><div>Comment:<div class="row"></div> </div></div>
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
