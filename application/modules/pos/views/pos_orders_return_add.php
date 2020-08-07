<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form id="form_pos_orders_return_save"  action="javascript:;" method="POST">
                        <input type="hidden" id="UserRole" name="UserRole" value="<?php echo $_SESSION['user_role']?>">
                        <input type="hidden" id="rowid" name="rowid" value="0">
                        <input type="hidden" id="totalamount" name="totalamount" value="0">
                        <input type="hidden" id="CustomerId" name="CustomerId" value="">
                        <div class="row">
                            <div class="form-group">

                                <div class="col-md-10">
                                    <label>Date *</label>
                                    <input id="OrderDate" name="OrderDate" class="form-control mydatepicker" placeholder="Select Date" value="">
                                </div>
                                <div class="col-md-2">
                                    <input style="margin-top:25px;" class="btn btn-primary" type="button" name="search" id="search" value="Show" onclick="get_sales_orders_list_by_date();">
                                </div>

                                <div class="col-md-10">
                                    <label>Sales Order No.</label>
                                    <select name="salesorderno" class="form-control" id="salesorderno" onchange="get_order_details_by_orderid(this.value)"></select>
                                </div>

                                <div class="col-md-10">
                                    <label>Customer(s)</label>
                                    <input type="text" id="CustomerName" class="form-control" onfocus="this.blur();">
                                    

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <br>
                        </div>
                        <div class="row">
                            <div class="panel panel-default panel-table">
                                <div class="panel-heading">
                                    <div class="tr">
                                        <div class="td" style="width:100%;padding:6px;">Brand Name</div>
                                        <div class="td" style="padding:6px;">MRP</div>
                                        <div class="td" style="padding:6px;">Quantity</div>
                                        <div class="td" style="padding:6px;">Amount</div>
                                        <div class="td" style="padding:6px;"></div>
                                    </div>
                                </div>
                                <div class="panel-body" id="productlist">
                                    <div id="insertbefore"></div>
                                </div>
                                <div class="panel-footer">
                                    <div class="tr">
                                        <div class="td" style="padding:6px;"></div>
                                        <div class="td" style="padding:6px;"></div>
                                        <div class="td" style="padding:6px;">Total</div>
                                        <div class="td" style="padding:6px;" id="showtotalamount">0.00</div>
                                        <div class="td" style="padding:6px;"></div>
                                        <input type="hidden" name="taxpercent" id="taxpercent" value="0">
                                        <input type="hidden" name="paymentmode" id="paymentmode" value="0">
                                        <input type="hidden" name="finalamount" id="finalamount" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                <input id="submit"  name="submit" type="submit" class="btn btn-primary pull-right" value="Save" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>



    <div id="addnewcustomer" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 1000px;">
        <div class="modal-content" >
          <div class="modal-header">
            <h4 class="modal-title theme-text">
              Add New Customer
          </h4>
      </div>
      <form id="form_customer_save"  action="javascript:;" method="POST">
          <div class="modal-body" id="print_table">
              <div class="row">
                <div class="form-group">
                    <label>Customer Name *</label>
                    <input id="NewCustomerName" name="NewCustomerName" type="text" class="form-control required">
                </div>

                <div class="form-group">
                    <label>Customer Mobile *</label>
                    <input id="CustomerMobile" name="CustomerMobile" type="text" class="form-control required">
                </div>

                <div class="form-group">
                    <label>Customer Email *</label>
                    <input id="CustomerEmail" name="CustomerEmail" type="text" class="form-control required">
                </div>

                <div class="form-group">
                    <label>Address *</label>
                    <input id="Address" name="Address" type="text" class="form-control required">
                </div>

                <div class="form-group">
                    <label>State *</label>
                    <select name="StateId" id="StateId" class="form-control" onchange="get_citylist(this.value);">
                        <option value="">Select State</option>
                        <?php foreach ($states as $key => $state) {
                            ?>
                            <option value="<?php echo $state['id']; ?>"><?php echo $state['StateName']; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City *</label>
                        <select name="CityId" id="CityId" class="form-control">
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                <input  name="submit" type="submit" class="btn btn-primary" value="Submit" >
            </div>
        </form>
    </div>
</div>
</div>