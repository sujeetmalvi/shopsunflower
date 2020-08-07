<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form id="form_pos_orders_save"  action="javascript:;" method="POST">
                        <input type="hidden" id="UserRole" name="UserRole" value="<?php echo $_SESSION['user_role']?>">
                        <input type="hidden" id="rowid" name="rowid" value="0">
                        <input type="hidden" id="totalamount" name="totalamount" value="0">
                        <input type="hidden" id="CustomerId" name="CustomerId" value="0">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <div class="col-md-10 col-sm-10 col-xs-10 ">
                                        <label>Customer(s)</label>
                                        <input id="CustomerName" class="form-control" placeholder="Type Customer Name" autofocus="autofocus">
                                    </div>
                                    <div class="col-md-2  col-sm-2 col-xs-2">
                                        <a href="#" class="btn btn-circle btn-primary" style="margin-top:20px;" data-toggle="modal" data-target="#addnewcustomer"><i class="fa fa-user-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6" style="display:none;">
                                        <label>Date *</label>
                                        <input id="OrderDate" name="OrderDate" class="form-control mydatepicker" placeholder="Select Date" value="<?php echo date('d-m-Y');?>">
                                    </div>
                                    <div class="col-md-12  col-sm-12 col-xs-12 ">
                                        <label>Product</label>
                                        <input id="ProductName" class="form-control" placeholder="Type product name"  onchange="return runScript(event)">
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row">&nbsp;
                            <?php if(DOCTOR_INFO==true){?>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <input id="DoctorName" name="DoctorName" class="form-control" placeholder=" Doctor name">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>Doctor Mobile</label>
                                    <input id="DoctorMobile" name="DoctorMobile" class="form-control" placeholder=" Doctor Mobile">
                                </div>
                            </div>
                            <?php } ?>
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
                                        <div class="td" style="padding:6px;">Total Item(s): <span id="itemscount">0</span></div>
                                        <div class="td" style="padding:6px;"></div>
                                        <div class="td" style="padding:6px;">Total (₹)</div>
                                        <div class="td" style="padding:6px;text-align:right;" id="showtotalamount">0.00</div>
                                        <div class="td" style="padding:6px;"></div>
                                        <input type="hidden" name="taxpercent" id="taxpercent" value="<?php echo $_SERVER['GST_TAX']; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group col-md-2 col-sm-2" >
                                <label>Pay Mode</label>
                                <select name="paymentmode" id="paymentmode" class="form-control" onchange="calculatefinalamount();">
                                    <option value="">Select Mode</option>
                                    <?php foreach($_SERVER['PAYMENT_MODES'] as $key => $paymodes){?>
                                        <option value="<?php echo $key;?>"><?php echo $paymodes;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-4">
                                <span style="display: none;">
                                    <label>Amt TAX @<?php echo $_SERVER['GST_TAX']+$_SERVER['GST_TAX']; ?>%.</label> = <span id="taxamount">0</span>
                                </span>
                                <label>Final Amount (₹)</label>
                                <input type="text" name="finalamount" id="finalamount" value="0"  class="form-control" onfocus="this.blur();">
                            </div>

                            <div class="form-group col-md-3 col-sm-3">
                                <label>Cash Received</label>
                                <input type="number" name="CashReceived" id="CashReceived" value=""  class="form-control" onblur="getcashreturn(this.value);" step=".01">
                            </div>

                            <div class="form-group col-md-3 col-sm-3">
                                <label>Cash Return</label>
                                <input type="number" name="CashReturn" id="CashReturn" value=""  class="form-control" onfocus="this.blur();" step=".01">
                            </div>

                            <div class="form-group">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <a href="<?php echo site_url('pos/pos_orders_add'); ?>"  class="btn btn-danger pull-left">Cancel</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="https://api.whatsapp.com/send?phone=919425656459&text=helloworld" class="btn btn-primary" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp</a>
                                    <!-- <a href="intent://send/+919425656459#Intent;scheme=smsto;package=com.whatsapp;action=android.intent.action.SENDTO;end" class="btn btn-success">Open WhatsApp chat window</a> -->
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input type="hidden" id="<?=$csrfName;?>" name="<?=$csrfName;?>" value="<?=$csrfHash;?>" />
                                    <label> <input type="checkbox" class="i-checks" name="onhold" id="onhold" value="hold"> On Hold </label>
                                    <a id="saveorder" disabled="disabled" name="saveorder" type="button" class="btn btn-primary pull-right" onclick="saveorder();" >Save</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 hidden-xs" >
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <select id="filter_products" onchange="filter_category_wise_products(this.value);" class="form-control" name="filter_products">
                        <option>Select Category</option>
                        <option value="all">All Category</option>
                        <?php foreach($prodcatlist as $category){?>
                        <option value="<?php echo cleanString($category['value']);?>"><?php echo $category['label'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <input type="text" class="form-control" name="filter_products_by_name" id="filter_products_by_name" onkeyup="filter_name_wise_products(this.value);" placeholder="Filter Product by Name">
                </div>
            </div>
            <div class="row" style="height:500px;overflow:auto;padding:10px;z-index: 99999; ">
                <?php
                //pre($productlist);
                foreach($productlist as $product){ ?>
                <a href="#" class="productthumblist <?php echo cleanString($product['CategoryId']);?>"data-productname="<?php echo $product['ProductName'];?>"  onclick="get_product_details_by_id(<?php echo $product['id']?>,'single');">
                    <div class="col-lg-2 col-md-2 col-sm-2" style="padding:10px;border:solid 1px #999999;height:100px;margin: 6px;background:#ffffff url('<?php echo base_url('assets/img/dd3.png');?>') 52px 60px no-repeat;border-radius:6px; ">
                        <?php echo $product['ProductName'];?>
                    </div></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>



<div id="addnewcustomer" class="modal" data-easein="flipXIn"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
      <div class="modal-dialog">
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
                    <input id="CustomerMobile"  name="CustomerMobile" type="number" class="form-control" onkeyup="checkmobileno(this.value);">
                </div>

                <div class="form-group">
                    <label>Customer Email *</label>
                    <input id="CustomerEmail" name="CustomerEmail" type="email" class="form-control">
                </div>

                <div class="form-group">
                    <label>Address *</label>
                    <input id="Address" name="Address" type="text" class="form-control">
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

 <!-- 
<div id="openingcashmodal" class="modal" data-easein="flipXIn" data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 414px;">
            <form id="form_opening_cash_save"  action="javascript:;" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Opening Cash</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cash in Hand</label>
                        <input class="form-control" type="number" name="openingcash" id="openingcash" step=".01">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-block btn-primary" name="submit" id="submit" value="Submit">
                </div>
        </form>
        </div>
    </div>
</div>



<div id="closingcashmodal" class="modal" data-easein="flipXIn"  data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="costumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 414px;">
            <form id="form_closing_cash_save"  action="javascript:;" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title theme-text">Closing Cash</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cash in Hand</label>
                        <input class="form-control" type="number" name="closingcash" id="closingcash" step=".01">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                    <input type="submit" class="btn btn-block btn-primary" name="submit" id="submit" value="Submit">
                </div>
        </form>
        </div>
    </div>
</div>
  -->