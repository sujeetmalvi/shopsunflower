<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Today</span> 
                    <h5>Total Profit</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $profit; ?></h1>
                    
                    <small>Total Profit</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Today</span> 
                    <h5>Total Customers</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $total_customer; ?></h1>
                    <small>Total Customers</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Today</span> 
                    <h5>Recurring Customers</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo $recurring_customer; ?></h1>
                    <small>Recurring Customers</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Today</span> 
                    <h5>Online Billers</h5>
                </div>
                <div class="ibox-content">
                   <!-- <div class="row">
                    	<div class='col-lg-2'>
                    		<i class="fa fa-circle" style="color:#ff4458"></i>
                    	</div>
                    	<div class='col-lg-10'>
                    		Rakesh Soni
                    	</div>
                    </div>
                    <div class="row">
                    	<div class='col-lg-2'>
                    		<i class="fa fa-circle" style="color:#dddddd"></i>
                    	</div>
                    	<div class='col-lg-10'>
                    		Mukesh Mehta
                    	</div>
                    </div>
                    <div class="row">
                    	<div class='col-lg-2'>
                    		<i class="fa fa-circle" style="color:#94d82d"></i>
                    	</div>
                    	<div class='col-lg-10'>
                    		Bipin Gupta
                    	</div>
                    </div>-->
                </div>
            </div>
        </div>
      </div>
    <div class="row">
         <div class="col-lg-4">
            <div class="ibox float-e-margins">
               <div class="ibox-title">
                  <h5>Expiry Product List</h5>
                   <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Batch</th>
                                                <th>Expiry</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if(!empty($ExpiryProduct)){
                                            foreach($ExpiryProduct as $product)
                                            {                                            		
                                             ?>
                                            <tr>
                                               
                                                <td><?php echo $product['ProductName']; ?></td>
                                                <td><?php echo $product['Batch']; ?></td>
                                                <td > <?php echo $product['Expiry']; ?></td>
                                            </tr>
                                            <?php } }?>
                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Product Quantity Alert</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                            <a class="close-link">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <table class="table table-hover no-margins">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>                                               
                                                <th>Stock</th>
                                                
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            if(!empty($out_of_stock)){
                                            foreach($out_of_stock as $stock)
                                            {                                            		
                                             ?>
                                            <tr>
                                               
                                                <td><?php echo $stock['ProductName']; ?></td>
                                                <td><?php echo $stock['psum']; ?></td>
                                               
                                            </tr>
                                            <?php } }?>
                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>

</div>