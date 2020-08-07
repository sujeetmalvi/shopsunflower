// $('#myModal').modal('toggle');
// $('#myModal').modal('show');
// $('#myModal').modal('hide');

function todaysprofit(){
      $.post(SITE_URL + '/pos/get_todaysprofit', {}, 
        function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== '1') {
               //alertify.alert(response.data);
               $('#todaysprofit').html(response.profit);
            }else{
               $('#todaysprofit').html('0.00');
            }
      });
}

todaysprofit();

function counter_opening_closing_cash(){
      $.post(SITE_URL + '/pos/get_counter_opening_closing_cash', {}, 
        function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== '1') {
               $('#openingcashmodal').modal('hide');
            }else{
               $('#openingcashmodal').modal('show');
            }
      });
}
//counter_opening_closing_cash();




function getcashreturn(cash){
  var finalamount = $('#finalamount').val();
  var returnamount = cash - finalamount;
  $('#CashReturn').val(returnamount.toFixed(2));  
}

function remove_all_products(){
  $('#productlist').html('');
  $('#showtotalamount').html('0.00');
}

$( "#CustomerName" ).focus();
function checkcustomer(){
  var CustomerId = $("#CustomerId").val();

  if (CustomerId=='0') {
    alertify.alert('Please Select Customer');
    return false;
  }else{
    return true;
  }
}

function removecustomerid(){
  $("#CustomerId").val(0);  
}


function checkmobileno(mobileno){

    if(mobileno.length==10){
        $.post(SITE_URL + '/customer/checkmobileno', {
            mobileno:mobileno
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== '1') {
              alertify.alert(response.msg);
              $('#CustomerMobile').val('');
            }else{
              //alertify.alert(response.msg);
            }
        });
  }
}





function showproductdetails(ProductId){
    result='';
    $.post(SITE_URL + '/product/get_product_stock_mil_details_by_id', {
            ProductId:ProductId
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

              $.each( response.datas, function( i, res ) {
                
                result+='<div class="tr">';
                result+='<div class="td">Product Available stock</div>';
                result+='<div class="td">'+res.stock.ProductQuantity+'</div>';
                result+='</div>';
                result+='<div class="tr">';
                result+='<div class="td">Product Minimum Level</div>';
                result+='<div class="td">'+res.stock.ProductMinStockLevel+'</div>';
                result+='</div>';
                result+='<div class="tr">';
                result+='<div class="td">Product Order Quantity</div>';
                result+='<div class="td">'+res.order.ApprovedQuantity+'</div>';
                result+='</div>';

              });

              $('#productdetailsbody').html('');
              $('#productdetailsbody').html(result);
              $('#ProductDetailsModal').modal('show');

              //alertify.alert(response.data);
            }else{
              //alertify.alert(response.msg);
            }
        });
}

function runScript(event) {
    var barcode = $("#ProductName").val();
      $.post(SITE_URL + '/product/get_productid_by_barcode', {barcode:barcode}, 
        function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== '1') {
               get_product_details_by_id(response.productid,'single');
            }else{
               $('#openingcashmodal').modal('show');
            }
      });
      $("#ProductName").val('');
      $("#ProductName").focus();

}

function get_product_details_by_id(ProductId,Type){

  if(!checkcustomer()){
    return false;
  }

  var result="";
  var PurchaseRate=0;
  var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
  var itemscount = parseInt($("#itemscount").text());
  $("#itemscount").text(itemscount+1);



    $.post(SITE_URL + '/product/get_product_details_by_id', {
            ProductId:ProductId, Type:Type
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

                  $.each( response.datas, function( i, data ) {



                    rowid = data.id;
                    var temp_amount = data.MrpRate*1;

                      result+='<div class="tr" id="row'+rowid+'">';
                      //result+='<div class="td">'+data.DivisionId+'</div>';
                      //result+='<div class="td">'+data.Composition+'</div>';
                      result+='<div class="td" style="padding:6px;">'+data.ProductName+'</div>';
                      //result+='<div class="td">'+data.PackingType1+'</div>';
                      //result+='<div class="td">'+data.PackingType2+'</div>';
                      //result+='<div class="td">'+data.ShipperPacking+'</div>';
                      //result+='<div class="td">'+PurchaseRate+'</div>';
                      result+='<div class="td" style="padding:6px;text-align:right;">'+data.MrpRate+'</div>';
                      result+='<div class="td" style="padding:6px;"><input type="text" style="width:60px;" class="form-control quantity touchspin1" id="quantity'+rowid+'" value="1"  name="quantity[]" onchange="calculate_amount_onchange()"></div>'; //calculate_amount('+rowid+',this.value,'+data.MrpRate+');
                      result+='<div class="td" style="padding:6px;text-align:right;"><input type="hidden" class="form-control" id="amount'+rowid+'" name="amount[]" value="'+temp_amount+'"> <span id="showamount'+rowid+'">'+temp_amount+'</span> ';
                      
                      //result+='<br><input type="button" class="btn btn-xs btn-primary" title="Details" onclick="showproductdetails('+data.id+')" value="#">';
                      result+='<input type="hidden" name="ProductId[]" id="ProductId'+rowid+'" value="'+data.id+'">';
                      result+='<input type="hidden" name="MrpRate[]" class="MrpRate" id="MrpRate'+rowid+'" value="'+data.MrpRate+'">';
                      result+='<input type="hidden" class="productrow" value="'+rowid+'">';
                      //result+='<input type="hidden" name="PurchaseRate[]" id="PurchaseRate'+rowid+'" value="'+PurchaseRate+'">';
                      result+='</div>';
                      result+='<div class="td" style="padding:6px;"><a class="btn btn-xs btn-danger" title="Delete" onclick="deleteme('+rowid+')"><i class="fa fa-trash-o"></i></a></div>';
                      result+='</div>';

                      


                    if ($('#ProductId'+rowid).length > 0) {
                      //alertify.alert('This product is already in list.');       
                      var cont = parseInt( $('#quantity'+rowid).val() );
                      $('#quantity'+rowid).val(cont+1);
                      calculate_amount(rowid,1,data.MrpRate);
                      calculatefinalamount();
                      calculate_amount_onchange();

                    }else{
                      $(result).insertAfter('#insertbefore');
                      $('#rowid').val(rowid);
                      calculate_amount(rowid,1,data.MrpRate);
                      calculatefinalamount();
                      calculate_amount_onchange();
                    }
                
                  });
                  $(".touchspin1").TouchSpin({
                          buttondown_class: 'btn btn-white',
                          buttonup_class: 'btn btn-white'
                      });

            }else{
              alertify.alert(response.msg);
            }
          });

}


function calculate_amount_onchange(){
  //var rowid = parseInt($('#rowid').val());

  var totalamount = 0;
  var amount = 0;
  totalamount=parseFloat(totalamount);
$( ".productrow" ).each(function( index ) {
        rowid = $( this ).val();

        quantity = parseFloat($('#quantity'+rowid).val());
        MrpRate = parseFloat($('#MrpRate'+rowid).val());

      amount = quantity*MrpRate;
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).html(amount);
      totalamount+=parseFloat(amount);
});

    showtotalamount = parseFloat(totalamount);
    $('#totalamount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));
    calculatefinalamount();
}

function calculate_amount(rowid,quantity,MrpRate){
  //var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
  var totalamount = parseFloat($('#totalamount').val());
  var amount = 0;

  quantity = parseFloat(quantity);
  MrpRate = parseFloat(MrpRate);

  if(quantity*1>0){
  
      amount = quantity*MrpRate;
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).html(amount);



    showtotalamount = parseFloat(totalamount)+parseFloat(amount);
    $('#totalamount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

  }
}

function deleteme(id){
    $("#row"+id).remove();
    var itemscount = parseInt($("#itemscount").text());
    $("#itemscount").text(itemscount-1);
    calculate_amount_onchange();
}


function filter_category_wise_products(category){
  if(category=='all'){
    $(".productthumblist").show();
  }else{
    $(".productthumblist").hide();
    $("."+category).show();
  }
}


function filter_name_wise_products(product){
  if(product==''){
    $(".productthumblist").show();
  }else{
    $(".productthumblist").hide();
    $(".productthumblist").each(function( index ) {
        var productname = $( this ).data('productname').toLowerCase();
        var n = productname.search(product);
        if(n>-1){
          $( this ).show();
        }
      });
  }
}





/***************************************** POS ********************************/

function saveorder(){
  $("#form_pos_orders_save").submit();
}


$(document).ready(function (e) {
    $("#form_pos_orders_save").on('submit', (function (e) {
    var validate=0;


    var OrderDate = $('#OrderDate').val();
    if ($.trim(OrderDate)=='' && validate==0) {
        alertify.alert('Please enter  Order Date.');
        var validate=1;
    }
    if (!valid_date.test(OrderDate)  && validate==0) {
        alertify.alert('Please enter Order Date in date format DD-MM-YYYY.');
        var validate=1;
    }

    $( ".quantity" ).each(function( index ) {
        chk_iQuantity = $( this ).val();
        if($.trim(chk_iQuantity)==''){
            alertify.alert('Please enter  Quantity');
            validate=1;
            return false;
        }

        if (!valid_numeric.test(chk_iQuantity)  && validate==0) {
          alertify.alert('Please enter quantity in Numeric');
          var validate=1;
        }
    });

    
    var paymentmode = $('#paymentmode').val();
    if ($.trim(paymentmode)=='' && validate==0) {
        alertify.alert('Please select payment mode.');
        var validate=1;
    }
  
          if(validate==0){
                $('#submit').attr('disabled','disabled');
                e.preventDefault();
                $.ajax({
                        url: SITE_URL+'/pos/pos_orders_save', // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (data)   // A function to be called if request succeeds
                        {
                            data = data.trim();
                              if(data) {
                                try {
                                  var response = JSON.parse(data);
                                  if(response.status == '1')
                                  {
                                      //$('#submit').removeAttr('disabled');
                                     //alertify.alert(response.msg);
                                      window.location.href=SITE_URL+'/pos/pos_orders_print_agent?OrderId='+response.orderid;
                                      //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');
                                   }
                                  else
                                  {   
                                      //$('#submit').removeAttr('disabled');
                                      alertify.alert(response.msg);
                                  }
                                } catch(e) {
                                    alertify.alert(e); // error in the above string (in this case, yes)!
                                }
                              }
                        }
                    });
            } // validation ends here 
            // end of OK pressed

    }));
});



         $(function() {
    
    var products = '';

    $.post(SITE_URL+'/product/get_product_details_by_id_json', {}, 
      function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                products = response.data;

                $( "#ProductName" ).autocomplete({
               minLength: 0,
               source: products, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#ProductName" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  //$( "#ProductName" ).val( ui.item.label );
                  $( "#ProductName" ).val('');
                  get_product_details_by_id(ui.item.value,'single');
                  //$( "#project-description" ).html( ui.item.desc );
                  return false;
               }
            })
        
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li  style='padding:5px;'>" )
               .append( "<a>" + item.label + "</a>" )
               .appendTo( ul );
            };
            }else{
              alertify.alert("No Product Found");
            }
          });


    var customers ='';
    $.post(SITE_URL+'/customer/get_customer_list_json', {}, 
      function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                customers = response.data;

                $( "#CustomerName" ).autocomplete({
               minLength: 0,
               source: customers, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#CustomerName" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  //$( "#ProductName" ).val( ui.item.label );
                 //$( "#CustomerName" ).val('');
                  //get_product_details_by_id(ui.item.value,'single');
                  $( "#CustomerId" ).val( ui.item.value );
                  return false;
               }
            })
        
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li style='padding:5px;'>" )
               .append( "<a>" + item.label + "</a>" )
               .appendTo( ul );
            };
            }else{
              alertify.alert("No Customer Found");
            }
          });


            
         });



function get_citylist(StateId){
    $.post(SITE_URL + '/city/get_city_by_stateid', {
            StateId: StateId
        }, function (responsedata, status) {
            //var response = JSON.parse(responsedata);
            $('#CityId').html(responsedata);
        });
}


$(document).ready(function (e) {
    $("#form_customer_save").on('submit', (function (e) {
    var validate=0;

    var NewCustomerName = $('#NewCustomerName').val();
    if ($.trim(NewCustomerName)=='' && validate==0) {
      $('#NewCustomerName').focus();
        alertify.alert('Please enter Customer Name.');
        var validate=1;
    }
    if (!valid_alpha.test(NewCustomerName)  && validate==0) {
      $('#NewCustomerName').focus();
        alertify.alert('Please enter Customer Name in Words.');
        var validate=1;
    }

    
    var CustomerMobile = $('#CustomerMobile').val();
    if ($.trim(CustomerMobile)=='' && validate==0) {
      $('#CustomerMobile').focus();
        alertify.alert('Please enter Customer Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(CustomerMobile)  && validate==0) {
      $('#CustomerMobile').focus();
        alertify.alert('Please enter Customer Contact No in Numbers between in 10 digit.');
        var validate=1;
    }    

    var CustomerEmail = $('#CustomerEmail').val();
    if ($.trim(CustomerEmail)!='' && validate==0) {
        if (!valid_emailid.test(CustomerEmail)  && validate==0) {
        $('#CustomerEmail').focus();
          alertify.alert('Please enter Customer Email properly.');
          var validate=1;
      }
    }


    // var Address = $('#Address').val();
    // if ($.trim(Address)=='' && validate==0) {
    //   $('#Address').focus();
    //     alertify.alert('Please enter Customer Address');
    //     var validate=1;
    // }

    var StateId = $('#StateId').val();
    if ($.trim(StateId)=='' && validate==0) {
      $('#StateId').focus();
        alertify.alert('Please select State');
        var validate=1;
    }

    var CityId = $('#CityId').val();
    if ($.trim(CityId)=='' && validate==0) {
      $('#CityId').focus();
        alertify.alert('Please select City');
        var validate=1;
    }




if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/customer/customer_save', // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                data = data.trim();
                  if(data) {
                    try {
                      var response = JSON.parse(data);
                      if(response.status == '1')
                      {
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          window.location.href=SITE_URL+'/pos/pos_orders_add';
                       }
                      else
                      {   
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                      }
                    } catch(e) {
                        alertify.alert(e); // error in the above string (in this case, yes)!
                    }
                  }
            }
        });
} // validation ends here 

    }));
});


function calculatefinalamount(){
  var totalamount = parseFloat($("#showtotalamount").html());
  var taxpercent = parseFloat($("#taxpercent").val());
  var taxamount = (totalamount*taxpercent)/100;
  var finalamount = totalamount+((totalamount*taxpercent)/100);
  $("#taxamount").text(taxamount.toFixed(2));
  //$("#finalamount").val(finalamount.toFixed(2));
  $("#finalamount").val(totalamount.toFixed(2));
  $('#saveorder').removeAttr('disabled');
  //console.log(totalamount);
}



function get_sales_orders_list_by_date(){
  var orderdate = $("#OrderDate").val();
  $.post(SITE_URL + '/pos/get_sales_orders_list_by_date', {
        orderdate: orderdate
    }, function (responsedata, status) {
      var response = JSON.parse(responsedata);
        var options = "<option value=''>Select Order Id</option>";;
        $.each( response, function( i, val ) {
          options+="<option value='"+val.id+"'>"+val.id+"</option>";
        });
        $("#salesorderno").html(options);
    });
}

function get_order_details_by_orderid(orderid){

  $.post(SITE_URL + '/pos/get_order_details_by_orderid', {
        orderid: orderid
    }, function (responsedata, status) {
      var response = JSON.parse(responsedata);

      $("#CustomerName").val(response.summary.CustomerName);
      $("#CustomerId").val(response.summary.CustomerId);
      $("#finalamount").val(response.summary.OrderTotalAmount);
      $("#paymentmode").val(response.summary.PaymentMode);
      
      

      var result = '';

      $.each( response.details, function( i, data ) {

      rowid = data.id;
      var temp_amount = data.ProductMRP*1;
      result+='<div class="tr" id="row'+rowid+'">';
      result+='<div class="td" style="padding:6px;">'+data.ProductName+'</div>';
      result+='<div class="td" style="padding:6px;">'+data.ProductMRP+'</div>';
      result+='<div class="td" style="padding:6px;"><input type="text" style="width:100px;" class="form-control quantity touchspin1" id="quantity'+rowid+'" value="'+data.OrderQuantity+'"  name="quantity[]" onchange="calculate_amount_onchange()"></div>'; //calculate_amount('+rowid+',this.value,'+data.MrpRate+');
      result+='<div class="td" style="padding:6px;"><input type="hidden" class="form-control" id="amount'+rowid+'" name="amount[]" value="'+temp_amount+'"> <span id="showamount'+rowid+'">'+temp_amount+'</span> ';
      result+='<input type="hidden" name="ProductId[]" id="ProductId'+rowid+'" value="'+data.id+'">';
      result+='<input type="hidden" name="MrpRate[]" class="MrpRate" id="MrpRate'+rowid+'" value="'+data.ProductMRP+'">';
      result+='<input type="hidden" class="productrow" value="'+rowid+'">';
      result+='</div>';
      result+='<div class="td"><button class="btn btn-xs btn-danger" title="Delete" onclick="deleteme('+rowid+')"><i class="fa fa-trash-o"></i></button></div>';
      result+='</div>';



      });

      

      $('#productlist').html('');
      result+='<div id="insertbefore"></div>';
      $('#productlist').html(result);
      $('#rowid').val(rowid);
      calculate_amount_onchange();


      $(".touchspin1").TouchSpin({
          buttondown_class: 'btn btn-white',
          buttonup_class: 'btn btn-white'
      });

      //console.log(response.summary.CustomerName);

    });

}





$(document).ready(function (e) {
    $("#form_pos_orders_return_save").on('submit', (function (e) {
    var validate=0;


    var OrderDate = $('#OrderDate').val();
    if ($.trim(OrderDate)=='' && validate==0) {
        alertify.alert('Please enter  Order Date.');
        var validate=1;
    }
    if (!valid_date.test(OrderDate)  && validate==0) {
        alertify.alert('Please enter Order Date in date format DD-MM-YYYY.');
        var validate=1;
    }

    var salesorderno = $('#salesorderno').val();
    if ($.trim(salesorderno)=='' && validate==0) {
        alertify.alert('Please select Order No..');
        var validate=1;
    }

    $( ".quantity" ).each(function( index ) {
        chk_iQuantity = $( this ).val();
        if($.trim(chk_iQuantity)==''){
            alertify.alert('Please enter  Quantity');
            validate=1;
            return false;
        }

        if (!valid_numeric.test(chk_iQuantity)  && validate==0) {
          alertify.alert('Please enter quantity in Numeric');
          var validate=1;
        }
    });

    
    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/pos/pos_orders_return_save', // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                data = data.trim();
                  if(data) {
                    try {
                      var response = JSON.parse(data);
                      if(response.status == '1')
                      {
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          window.location.href=SITE_URL+'/pos/pos_orders_print_agent?OrderId='+response.orderid;
                                                  
                          //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');

                       }
                      else
                      {   
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                      }
                    } catch(e) {
                        alertify.alert(e); // error in the above string (in this case, yes)!
                    }
                  }
            }
        });
} // validation ends here 

    }));
});



function unholdorder(holdorderid){
    alertify.confirm("Do you want to Un-hold this order ? ", function (e) {
      if (e) {
          // user clicked "ok"
          $.post(SITE_URL + '/pos/unholdposorder', {
              orderid: holdorderid
          }, function (responsedata, status) {
            var response = JSON.parse(responsedata);
            if(response.status == '1')
            {
                alertify.alert(response.msg);
                window.location.href=SITE_URL+'/pos/pos_orders_print_agent?OrderId='+holdorderid;
             }
            else
            {   
                alertify.alert(response.msg);
            }
          });          

      } else {
          // user clicked "cancel"
      }
    });
}



function cancelholdorder(holdorderid){
    alertify.confirm("Do you want to Cancel this order ? ", function (e) {
      if (e) {
          // user clicked "ok"
          $.post(SITE_URL + '/pos/cancelholdorder', {
              orderid: holdorderid
          }, function (responsedata, status) {
            var response = JSON.parse(responsedata);
            if(response.status == '1')
            {
                alertify.alert(response.msg);
                window.location.href=SITE_URL+'/pos/pos_orders_add';
             }
            else
            {   
                alertify.alert(response.msg);
            }
          });          

      } else {
          // user clicked "cancel"
      }
    }); 
}





$(document).ready(function (e) {
    $("#form_opening_cash_save").on('submit', (function (e) {
    var validate=0;

    var openingcash = $('#openingcash').val();
    if (!valid_numeric.test(openingcash) && validate==0) {
        alertify.alert('Please enter Opening Cash.');
        var validate=1;
    }
  
          if(validate==0){
                $('#submit').attr('disabled','disabled');
                e.preventDefault();
                $.ajax({
                        url: SITE_URL+'/pos/opening_cash_save', // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (data)   // A function to be called if request succeeds
                        {
                            data = data.trim();
                              if(data) {
                                try {
                                  var response = JSON.parse(data);
                                  if(response.status == '1')
                                  {
                                      //$('#submit').removeAttr('disabled');
                                     //alertify.alert(response.msg);
                                      window.location.href=SITE_URL+'/pos/pos_orders_add';
                                      //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');
                                   }
                                  else
                                  {   
                                      //$('#submit').removeAttr('disabled');
                                      alertify.alert(response.msg);
                                  }
                                } catch(e) {
                                    alertify.alert(e); // error in the above string (in this case, yes)!
                                }
                              }
                        }
                    });
            } // validation ends here 
            // end of OK pressed

    }));
});



$(document).ready(function (e) {
    $("#form_closing_cash_save").on('submit', (function (e) {
    var validate=0;

    var closingcash = $('#closingcash').val();
    if (!valid_numeric.test(closingcash) && validate==0) {
        alertify.alert('Please enter Closing Cash.');
        var validate=1;
    }
  
          if(validate==0){
                $('#submit').attr('disabled','disabled');
                e.preventDefault();
                $.ajax({
                        url: SITE_URL+'/pos/closing_cash_save', // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (data)   // A function to be called if request succeeds
                        {
                            data = data.trim();
                              if(data) {
                                try {
                                  var response = JSON.parse(data);
                                  if(response.status == '1')
                                  {
                                      //$('#submit').removeAttr('disabled');
                                     //alertify.alert(response.msg);
                                      window.location.href=SITE_URL+'/login/logout';
                                      //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');
                                   }
                                  else
                                  {   
                                      //$('#submit').removeAttr('disabled');
                                      alertify.alert(response.msg);
                                  }
                                } catch(e) {
                                    alertify.alert(e); // error in the above string (in this case, yes)!
                                }
                              }
                        }
                    });
            } // validation ends here 
            // end of OK pressed

    }));
});



$(document).ready(function (e) {
    $("#form_get_orders_by_date").on('submit', (function (e) {
    var validate=0;


   
    var OrderDate= $('#date').val();
    if ($.trim(OrderDate)=='' && validate==0) {
        alertify.alert('Please select Date.');
        var validate=1;
    }
  
          if(validate==0){
               
                e.preventDefault();
                $.ajax({
                        url: SITE_URL+'/pos/get_orders_by_date', // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false, // To send DOMDocument or non processed data file it is set to false
                        success: function (data)   // A function to be called if request succeeds
                        {
                            data = data.trim();
                              if(data) {
                               
                                 
                                   
                                    $('#replace').html(data);
                                  $('#submit').attr('enable','enable');
                                  
                                 
                                
                                }
                                else
                                  {   
                                      //
                                      alertify.alert(response.msg);
                                  }
                              }
                     
                    });
            } // validation ends here 
            // end of OK pressed

    }));
});