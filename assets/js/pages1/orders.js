// $('#myModal').modal('toggle');
// $('#myModal').modal('show');
// $('#myModal').modal('hide');

$('.modal').on('hidden.bs.modal', function (e) {
    if($('.modal').hasClass('in')) {
    $('body').addClass('modal-open');
    }    
});

function remove_all_products(){
  $('#productlist').html('');
  $('#showtotalamount').html('0.00');
}


function showproductdetails(ProductId){
    result='';alert(ProductId);
    
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


function get_product_details_by_id(ProductId,Type){
  var result="";
  var PurchaseRate=0;
  var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
	$('#LoadingModal').modal('show');
    $.post(SITE_URL + '/product/get_product_details_by_id', {
            ProductId:ProductId, Type:Type
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

                  $.each( response.datas, function( i, data ) {
			var PurchaseRate=0;
                    rowid = data.id;
                  //  alert(data);
                    var actual_PurchaseRate = parseFloat(data.Diprice);
                    var actual_PTSMargin = parseFloat(data.PTSMargin);
                    var actual_PTRMargin = parseFloat(data.PTRMargin);
                    var actual_PTDMargin = parseFloat(data.PTDMargin);

                    if(UserRole=='stockist'){
                    if(actual_PurchaseRate!=0){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTSMargin/100)));
                      
                      PurchaseRate = PurchaseRate.toFixed(2);
                      }
                    }

                    if(UserRole=='retailer'){
                     if(actual_PurchaseRate!=0){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTRMargin/100)));
                      PurchaseRate = PurchaseRate.toFixed(2);
                      }
                    }

                    if(UserRole=='distributor'){
                     if(actual_PurchaseRate!=0){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTDMargin/100)));
                      PurchaseRate = PurchaseRate.toFixed(2);
                      }

                    }

                      result+='<div class="tr" id="row'+rowid+'">';
                      result+='<div class="td">'+data.Division+'</div>';                      
                      result+='<div class="td">'+data.ProductName+'</div>';
                    
                      result+='<div class="td">'+data.ShipperPack+'</div>';
                      result+='<div class="td">'+PurchaseRate+'</div>';
                      
                      result+='<div class="td"><input type="text" style="width:100px;" class="form-control quantity" id="quantity'+rowid+'" onkeypress="calculate_amount_onchange();" name="quantity[]" onchange="calculate_amount_onchange();" value="1"></div>';
                      //onchange="calculate_amount('+rowid+',this.value,'+data.PTRMargin+','+data.PTSMargin+','+data.PTDMargin+','+data.PurchaseRate+');"
                      result+='<div class="td"><input type="hidden" class="form-control" id="amount'+rowid+'" name="amount[]" value="'+PurchaseRate+'"> <span id="showamount'+rowid+'">'+PurchaseRate+'</span> ';
                      result+='<input type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteme('+rowid+')" value="X">';
                    
                      result+='<input type="hidden" name="ProductId[]" id="ProductId'+rowid+'" value="'+data.id+'">';
                      result+='<input type="hidden" name="MrpRate[]" id="MrpRate'+rowid+'" value="'+data.MRP+'">';
                      result+='<input type="hidden" name="PurchaseRate[]" class="PurchaseRate" id="PurchaseRate'+rowid+'" value="'+PurchaseRate+'">';
			 result+='<input type="hidden" name="Batch[]" class="Batch" id="Batch'+rowid+'" value="'+data.Batch+'">';
			 result+='<input type="hidden" name="Expiry[]" class="Expiry" id="Expiry'+rowid+'" value="'+data.Expiry+'">';
			  result+='<input type="hidden" name="MfgDate[]" class="MfgDate" id="MfgDate'+rowid+'" value="'+data.MfgDate+'">';
                      result+='<input type="hidden" class="productrow" value="'+rowid+'">';
                      result+='</div>';
                      result+='</div>';

                      
                  });


                  if(Type=='all_products'){
                    $('#productlist').html('');
                    result+='<div id="insertbefore"></div>';
                    $('#productlist').html(result);
                     $('#showtotalamount').html('0.00');
                     calculate_amount_onchange();
                     if($('#showtotalamount').text()!='0.00'){
                     	$('#submit').removeAttr('disable');
                     }
                     

                  }else{
                    
                    if ($('#ProductId'+rowid).length > 0) {
                      alertify.alert('This product is already in list.');              
                    }else{
                      $(result).insertBefore('#insertbefore');
                      $('#rowid').val(rowid);
                    }
                    calculate_amount_onchange();
                  }


            }else{
              alertify.alert(response.msg);
            }
          }).done(function() {
              $('#LoadingModal').modal('hide');
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
        PurchaseRate = parseFloat($('#PurchaseRate'+rowid).val());

      amount = quantity*PurchaseRate;
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).html(amount);
      totalamount+=parseFloat(amount);
});

    showtotalamount = parseFloat(totalamount);
    $('#totalamount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

}

function calculate_amount(rowid,quantity,PTRMargin,PTSMargin,PTDMargin,PurchaseRate){
  //var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
  var totalamount = parseFloat($('#totalamount').val());
  var amount = 0;

  quantity = parseFloat(quantity);
  PTRMargin = parseFloat(PTRMargin);
  PTSMargin = parseFloat(PTSMargin);
  PTDMargin = parseFloat(PTDMargin);
  PurchaseRate = parseFloat(PurchaseRate);

  if(quantity*1>0){
  
    if(UserRole=='stockist'){
      amount = quantity*(PurchaseRate+((PurchaseRate*PTSMargin)/100));
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).text(amount);
    }

    if(UserRole=='retailer'){
      amount = quantity*(PurchaseRate+((PurchaseRate*PTRMargin)/100));
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).text(amount);
    }

    if(UserRole=='distributor'){
      amount = quantity*(PurchaseRate+((PurchaseRate*PTDMargin)/100));
      amount = amount.toFixed(2);
      $('#amount'+rowid).val(amount);
      $('#showamount'+rowid).text(amount);
    }

    showtotalamount = parseFloat(totalamount)+parseFloat(amount);
    $('#totalamount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

  }
}

// function deleteme(id){

//   $(id).parent().parent().remove();

// }
function deleteme(id){
calculate_amount_onchange();
  var totalamount = $('#totalamount').val();
  var amount = parseFloat($('#amount'+id).val());
    showtotalamount = parseFloat(totalamount)-parseFloat(amount);
    $('#totalamount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));
	
    $("#row"+id).remove();
    calculate_amount_onchange();
    
}



function printme(id){
     var printContents = document.getElementById(id).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
     setTimeout(function(){
        location.reload();
    },0);
}

$(document).ready(function (e) {
    $("#form_orders_save").on('submit', (function (e) {
    var validate=0;


    var OrderDate = $('#OrderDate').val();
    if ($.trim(OrderDate)=='' && validate==0) {
        alertify.alert('Please enter  Order Date.');
         validate=1;
    }
    if (!valid_date.test(OrderDate)  && validate==0) {
        alertify.alert('Please enter Order Date in date format DD-MM-YYYY.');
         validate=1;
    }

    if($( ".quantity" ).length == 0) {
      alertify.alert('Please add Product(s).');
      $("#alertify").css('border-color','#ff0000 !important');
            validate=1;
            return false;
    }

    $( ".quantity" ).each(function( index ) {
        chk_iQuantity = $( this ).val();
        if($.trim(chk_iQuantity)=='' || $.trim(chk_iQuantity)=='0'){
            alertify.alert('Please enter  Quantity');
            validate=1;
            return false;
        }

        if (!valid_numeric.test(chk_iQuantity)  && validate==0) {
          alertify.alert('Please enter quantity in Numeric');
           validate=1;
        }
    });

    
    

if(validate==0){
$('#LoadingModal').modal('show');
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/orders_save', // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
            $('#LoadingModal').modal('hide');
                data = data.trim();
                  if(data) {
                    try {
                      var response = JSON.parse(data);
                      if(response.status == '1')
                      {
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          if(response.OrderSubmitUserType=='retailer'){
                            window.location.href=SITE_URL+'/orders/orders_print_retailer?OrderId='+response.orderid;
                          }
                          if(response.OrderSubmitUserType=='stockist'){
                            window.location.href=SITE_URL+'/orders/orders_print_stockist?OrderId='+response.orderid;
                          }
                          if(response.OrderSubmitUserType=='distributor'){
                            window.location.href=SITE_URL+'/orders/orders_print_distributor?OrderId='+response.orderid;
                          }
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
               return $( "<li>" )
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
               return $( "<li>" )
               .append( "<a>" + item.label + "</a>" )
               .appendTo( ul );
            };
            }else{
              alertify.alert("No Customer Found");
            }
          });


            
         });


  function ShowOrderDetailsSender(OrderId){
      $.post(SITE_URL + '/orders/get_orders_details_by_orderid_sender', {
            OrderId: OrderId
        }, function (responsedata, status) {
          $("#orderdetails").html('');
          $("#orderdetails").html(responsedata);
        });
  }

    function ShowOrderDetailsReceiver(OrderId,status=0){
    if(status>=4){
    	$('#submit').hide();
    }
    else{
    	$('#submit').show();
    }
      $.post(SITE_URL + '/orders/get_orders_details_by_orderid_receiver', {
            OrderId: OrderId
        }, function (responsedata, status) {
          $("#orderdetails").html('');
          $("#orderdetails").html(responsedata);
        });
  }

  function accept(OrderDetailsId){
    //$('#status'+OrderDetailsId).val('1');
    //$('#statustxt'+OrderDetailsId).html('<i style="color:#1ab394">Accept</i>');
    
    var approvedquantity = $('#approvedquantity'+OrderDetailsId).val();

    if($.trim(approvedquantity)<='0'){
        alertify.alert('Please fill quantity properly. ');
        validate=1;
        return false;
    }

    $('#OrderRejectionModal').modal('show');
    $('#OrderDetailsId').val(OrderDetailsId);
    $('#AcceptReject').val('1');
    if($('#status'+OrderDetailsId).val()=='1'){
      $('#reason').val($('#statustxt'+OrderDetailsId).text());
    }
    
  }

  function reject(OrderDetailsId){
    $('#approvedquantity'+OrderDetailsId).val('0');
    $('#OrderRejectionModal').modal('show');
    $('#OrderDetailsId').val(OrderDetailsId);
    $('#AcceptReject').val('2');
    if($('#status'+OrderDetailsId).val()=='2'){
      $('#reason').val($('#statustxt'+OrderDetailsId).text());
    }
  }

  function remarkssave()
  {
    var reason = $('#reason').val();
    var OrderDetailsId = $('#OrderDetailsId').val();
    $('#rejectreason'+OrderDetailsId).val(reason);
    $('#status'+OrderDetailsId).val($('#AcceptReject').val());
    if($('#AcceptReject').val()=='1'){
      $('#statustxt'+OrderDetailsId).html('<i style="color:#1ab394">Accept</i> : '+reason);
    }
    if($('#AcceptReject').val()=='2'){
      $('#statustxt'+OrderDetailsId).html('<i style="color:#ed5565">Reject</i> : '+reason);
      $('#recieve_row'+OrderDetailsId).hide();
    }
    $('#reason').val('');
    $('#approvedquantity'+OrderDetailsId).attr('onFocus','this.blur();');
    $('#OrderRejectionModal').modal('hide');
  }



function calculate_amount_approve_reject(rowid,quantity,PurchaseRate,ProductStock,ProductMIL){
  //var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
  var totalamount = 0;
  var amount = 0;

  quantity = parseFloat(quantity);
  PurchaseRate = parseFloat(PurchaseRate);

  var ProductStock = parseFloat(ProductStock);
  var ProductMIL = parseFloat(ProductMIL);

  if(quantity>(ProductStock+ProductMIL)){
    alertify.alert('In-sufficient stock to complete this order.');
  }else if(quantity>ProductStock){
    alertify.alert('This will effect Product MIL.');
  }

  


  if(quantity*1>0){
  
      amount = quantity*PurchaseRate;
      amount = amount.toFixed(2);
      $('#rowtotalamount'+rowid).val(amount);
      $('#showamount'+rowid).text(amount);

      $( ".rowtotalamount" ).each(function( index ) {
        var rowtotalamount = parseFloat( $( this ).val() );
         totalamount += rowtotalamount;
      });

    //showtotalamount = parseFloat(totalamount)+parseFloat(amount);
    //$('#totalamount'+rowid).val(totalamount);
    $('#showtotalamount').html(totalamount.toFixed(2));
    $('#OrderApprovedAmount').val(totalamount.toFixed(2));

  }
}  


  $(document).ready(function (e) {
    $("#form_order_status_save").on('submit', (function (e) {
    var validate=0;

      $( ".approvedquantity" ).each(function( index ) {
        approvedQuantity = $( this ).val();
        if($.trim(approvedQuantity)==''){
            alertify.alert('Please fill quantity properly');
            validate=1;
            return false;
        }

        if (!valid_numeric.test(approvedQuantity)  && validate==0) {
        alertify.alert('Please enter Quantity in Numbers Only.');
        validate=1;
        return false;
    }
    });

    if(validate==0){
      $( ".approvedrejectstatus" ).each(function( index ) {
          chk_iQuantity = $( this ).val();
          if($.trim(chk_iQuantity)=='0'){
              alertify.alert('Please click Approve or Reject option for each product. ');
              validate=1;
              return false;
          }
      });
    }
    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/order_status_save', // Url to which the request is send
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
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderDetailsModal').modal('hide');
                          //window.open(SITE_URL+'/orders/orders_received');
                          window.location.href=SITE_URL+'/orders/orders_received';

                       }
                      else
                      {   
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderDetailsModal').modal('hide');
                           window.location.href=SITE_URL+'/orders/orders_received';
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


function ordernow(){
  var rowsbody='';
  var rowsfooter='';
  var ordertotalamount = 0;
    $( ".selectproduct:checkbox:checked" ).each(function( index ) {
       
       var ProductId = $( this ).val(); 
//       alertify.alert($( this ).val());
       rowsbody+="<div class='tr'>";
       rowsbody+="<div class='td'>"+$('#ProductName'+ProductId).val()+"</div>";
       rowsbody+="<div class='td'>"+$('#Composition'+ProductId).val()+"</div>";
       rowsbody+="<div class='td'>"+$('#PurchaseRate'+ProductId).val()+"</div>";
       rowsbody+="<div class='td'>"+$('#ProductMRP'+ProductId).val()+"</div>";
       rowsbody+="<div class='td'>";
       rowsbody+="<input type='text' id='OrderQuantity' class='form-control' onblur='ordernowgetamount("+$('#PurchaseRate'+ProductId).val()+","+ProductId+",this.value);' name='ApprovedQuantity[]' value='"+$('#ApprovedQuantity'+ProductId).val()+"' />";
       rowsbody+="<input type='hidden' name='ProductId[]' value='"+ProductId+"' />";
       rowsbody+="<input type='hidden' name='PurchaseRate[]' value='"+$('#PurchaseRate'+ProductId).val()+"' />";
       rowsbody+="<input type='hidden' name='ProductMRP[]' value='"+$('#ProductMRP'+ProductId).val()+"' />";
       rowsbody+="<input type='hidden' class='OrderAmount' name='OrderAmount[]' value='"+$('#Amount'+ProductId).val()+"' id='OrderAmount"+ProductId+"' />";
       rowsbody+="</div>";
       rowsbody+="<div class='td' id='OrdershowAmount"+ProductId+"'>"+$('#Amount'+ProductId).val()+"</div>";
       rowsbody+="</div>";

       ordertotalamount+= parseFloat($('#Amount'+ProductId).val());
       //debugger;

    });


    rowsfooter+="<div class='tr'>";
    rowsfooter+="<div class='td'></div>";
    rowsfooter+="<div class='td'></div>";
    rowsfooter+="<div class='td'></div>";
    rowsfooter+="<div class='td'></div>";
    rowsfooter+="<div class='td'>Total</div>";
    rowsfooter+="<div class='td' id='showtotalamount'>"+ordertotalamount+"</div>";
    rowsfooter+="<input type='hidden' name='OrderTotalAmount' id='OrderTotalAmount' value='"+ordertotalamount+"' />";
    rowsfooter+="</div>";



    $('#orderdetailsbody').html(rowsbody);
    $('#orderdetailsfooter').html(rowsfooter);

    $('#OrderBookModal').modal('show');
    
}

function ordernowgetamount(PurchaseRate,ProductId,Quantity){
  //var Quantity = parseFloat($('#OrderQuantity').val());
  var PurchaseRate = parseFloat(PurchaseRate);
  var OrderAmount = parseFloat(Quantity*PurchaseRate);
  $('#OrderAmount'+ProductId).val(OrderAmount.toFixed(2));
  $('#OrdershowAmount'+ProductId).text(OrderAmount.toFixed(2));
  //alertify.alert(PurchaseRate+' , '+ProductId+' , '+Quantity);  
  ordernowgettotalamount();
}


function ordernowgettotalamount(){
      var OrderTotalAmount=0;
      $( ".OrderAmount" ).each(function( index ) {
        OrderTotalAmount += parseFloat($( this ).val());
      });

      $('#OrderTotalAmount').val(OrderTotalAmount.toFixed(2));
      $('#showtotalamount').text(OrderTotalAmount.toFixed(2));

}





  $(document).ready(function (e) {
    $("#form_order_place_now").on('submit', (function (e) {
    var validate=0;    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/order_place_now', // Url to which the request is send
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
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderBookModal').modal('hide');
                          //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');

                       }
                      else
                      {   
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderBookModal').modal('hide');
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


function approve_selected_order_all_products(){
  var orderids = [];
  var validate = 1;
    $( ".approveorder:checkbox:checked" ).each(function( index ) {
      var orderid = $( this ).val();
      orderids.push(orderid);
      validate=0;
    });

    console.log(orderids);

    if(validate==0){
        $.post(SITE_URL + '/orders/approve_selected_order_all_products', {
            orderids: orderids
        }, function (responsedata, status) {

          var response = JSON.parse(responsedata);
          if(response.status == '1')
            {
                alertify.alert(response.msg);
                window.location.href=SITE_URL+'/orders/orders_received';
            }
            else
            {   
                alertify.alert(response.msg);
            }
          
        });
    } // validation ends here 
  
}

function hiderow(rowid,quantity,PurchaseRate,ProductStock,ProductMIL)
{
	reject(rowid);
	$('#recieve_row'+rowid).hide();
	//calculate_amount_onchange();
	calculate_amount_approve_reject(rowid,quantity,PurchaseRate,ProductStock,ProductMIL);
	$('#approvedquantity'+rowid).val(0);
	
}

function order_confirm(id)
{	
	 $.post(SITE_URL + '/orders/order_confirm', {
            orderid: id
        }, function (responsedata, status) {
          var response = JSON.parse(responsedata);
          if(response.status == '1')
            {
                alertify.alert(response.msg);
                window.location.href=SITE_URL+'/orders/orders_received';
            }
            else
            {   
                alertify.alert(response.msg);
            }          
        });
}


  function order_dispach(OrderId){
  	$("#OrderIdDispatch").val(OrderId);
  	$('#OrderDispatch').modal('show');
  }
  
  function order_dispach_save(){
  
  var OrderId = $("#OrderIdDispatch").val();
  var TransporterId= $("#TransporterId").val();
  var TransporterBiltyNo = $("#TransporterBiltyNo").val();
  var TransportRemarks= $("#TransportRemarks").val();
 
      $.post(SITE_URL + '/orders/set_orders_status_to_dispatch', {
            OrderId: OrderId, TransporterId:TransporterId, TransporterBiltyNo:TransporterBiltyNo, TransportRemarks:TransportRemarks 
        }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
          if(response.status == '1')
            {
                alertify.alert(response.msg);
                 window.location.href=SITE_URL+'/orders/orders_received';
            }
            else
            {   
                alertify.alert(response.msg);
            }
        });
  }


  function orderdispatchedrecievedlist(OrderId){
  
      $.post(SITE_URL + '/orders/get_orders_dispatched_recieve_list', {
            OrderId: OrderId
        }, function (responsedata, status) {
        
        var result='';
        //console.log(responsedata);
        var response = JSON.parse(responsedata);
          if(response.status == '1')
            {
           	$('#BillNo').text(response.data.master[0].BillNo);
           	$('#TransporterName').text(response.data.master[0].TransporterName);
           	$('#TransporterBiltyNo').text(response.data.master[0].TransporterBiltyNo);
           	$('#TransportRemarks').text(response.data.master[0].TransportRemarks);
           	
           	$.each( response.data.details, function( i, res ) {
           	
           	//if(res.ApprovedQuantity>0){
               result+='<div class="tr">';
               result+='<div class="td">'+res.ProductName+'</div>';
               result+='<div class="td">'+res.ProductMRP+'</div>';
               result+='<div class="td">'+res.Batch+'</div>';
               result+='<div class="td">'+res.Expiry+'</div>';
               result+='<div class="td">'+res.MfgDate+'</div>';
               result+='<div class="td"><input type="text" id="receivedquantity'+i+'" name="receivedquantity[]" class="form-control receivedquantity" value="'+res.ApprovedQuantity+'" /></div>';
               result+='<div class="td"><textarea id="receivedremarks'+i+'" name="receivedremarks[]" ></textarea>';
               result+='<input type="hidden" name="ProductId[]" value="'+res.ProductId+'" />';
               result+='<input type="hidden" name="Batch[]" value="'+res.Batch+'" />';
               result+='<input type="hidden" name="Expiry[]" value="'+res.Expiry+'" />';
               result+='<input type="hidden" name="MfgDate[]" value="'+res.MfgDate+'" />';
               result+='<input type="hidden" name="ProductMRP[]" value="'+res.ProductMRP+'" />';
               result+='<input type="hidden" name="ProductPurchaseRate[]" value="'+res.ProductPurchaseRate+'" />';
               result+='<input type="hidden" name="OrderId[]" value="'+res.OrderId+'" />';
               result+='</div>';
               result+='</div>';
                });
               // }
                
                $('#orderreceivedlist').html(result);
                $('#OrderReceived').modal('show');
            }
            else
            {   
                alertify.alert(response.msg);
            }
        });
  }


  $(document).ready(function (e) {
    $("#form_save_order_to_stock").on('submit', (function (e) {
    var validate=0;    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/save_order_to_stock', // Url to which the request is send
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
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderReceived').modal('hide');
                          window.location.href=SITE_URL+'/orders/orders_list';

                       }
                      else
                      {   
                          $('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          $('#OrderReceived').modal('hide');
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


/***************************************** POS ********************************/




// $(document).ready(function (e) {
//     $("#form_pos_orders_save").on('submit', (function (e) {
//     var validate=0;


//     var OrderDate = $('#OrderDate').val();
//     if ($.trim(OrderDate)=='' && validate==0) {
//         alertify.alert('Please enter  Order Date.');
//         var validate=1;
//     }
//     if (!valid_date.test(OrderDate)  && validate==0) {
//         alertify.alert('Please enter Order Date in date format DD-MM-YYYY.');
//         var validate=1;
//     }

//     $( ".quantity" ).each(function( index ) {
//         chk_iQuantity = $( this ).val();
//         if($.trim(chk_iQuantity)==''){
//             alertify.alert('Please enter  Quantity');
//             validate=1;
//             return false;
//         }

//         if (!valid_numeric.test(chk_iQuantity)  && validate==0) {
//           alertify.alert('Please enter quantity in Numeric');
//           var validate=1;
//         }
//     });

    
    

// if(validate==0){
//     $('#submit').attr('disabled','disabled');
//     e.preventDefault();
//     $.ajax({
//             url: SITE_URL+'/orders/pos_orders_save', // Url to which the request is send
//             type: "POST", // Type of request to be send, called as method
//             data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
//             contentType: false, // The content type used when sending data to the server.
//             cache: false, // To unable request pages to be cached
//             processData: false, // To send DOMDocument or non processed data file it is set to false
//             success: function (data)   // A function to be called if request succeeds
//             {
//                 data = data.trim();
//                   if(data) {
//                     try {
//                       var response = JSON.parse(data);
//                       if(response.status == '1')
//                       {
//                           //$('#submit').removeAttr('disabled');
//                           alertify.alert(response.msg);
//                           window.location.href=SITE_URL+'/orders/pos_orders_print?OrderId='+response.orderid;
                                                  
//                           //window.open(SITE_URL+'/orders/orders_print?OrderId='+response.orderid,'_blank');

//                        }
//                       else
//                       {   
//                           //$('#submit').removeAttr('disabled');
//                           alertify.alert(response.msg);
//                       }
//                     } catch(e) {
//                         alertify.alert(e); // error in the above string (in this case, yes)!
//                     }
//                   }
//             }
//         });
// } // validation ends here 

//     }));
// });
