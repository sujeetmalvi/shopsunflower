// $('#myModal').modal('toggle');
// $('#myModal').modal('show');
// $('#myModal').modal('hide');




// $('.modal').on('hidden.bs.modal', function (e) {
//     if($('.modal').hasClass('in')) {
//     $('body').addClass('modal-open');
//     }    
// });

// function remove_all_products(){
//   $('#productlist').html('');
//   $('#showtotalamount').html('0.00');
// }






function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    //mywindow.close();

    return true;
}


function changeorderstatus(orderid,ostatus){
    $.post(SITE_URL + '/orders/changeorderstatus', {
        orderid : orderid,ostatus:ostatus
        }, function (responsedata, status) {
            var response = JSON.parse(responsedata);
            console.log(response);
            //$('#productstatus'+productstockid).html(response.prodstatus);
        });
}




function printme(id){
     var printContents = document.getElementById(id).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     /*
     window.print();
     document.body.innerHTML = originalContents;
     setTimeout(function(){
        location.reload();
    },0);
    */
}

function form_orders_save_submit(){
	$("#form_orders_save").submit();
}

$("#form_orderlist_filter").on('submit', (function (e) {
    var validate=0;
    
if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/get_orderlist_filter', // Url to which the request is send
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


function form_orders_supply_save(){
	$('#form_orders_supply_save').submit();
}

$(document).ready(function (e) {
    $("#form_orders_supply_save").on('submit', (function (e) {
    var validate=0;

	var CustomerId= $('#CustomerId').val();
    if ($.trim(CustomerId)=='' && validate==0) {
        alertify.alert('Please Select Customer Id.');
         validate=1;
    }

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
            url: SITE_URL+'/orders/orders_supply_save', // Url to which the request is send
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
                          if(response.OrderSubmitUserType=='stockist'){
                            window.location.href=SITE_URL+'/orders/orders_supply_print_retailer?OrderId='+response.orderid;
                          }
                          if(response.OrderSubmitUserType=='admin'){
                            window.location.href=SITE_URL+'/orders/orders_supply_print_stockist?OrderId='+response.orderid;
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

/*

$(function() {
    
    var products = '';
    $.post(SITE_URL+'/product/get_product_details_by_id_json', {}, 
         function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                products = response.data;

                $( "#ProductName1" ).autocomplete({
               minLength: 0,
               source: products, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#ProductName1" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  //$( "#ProductName1" ).val( ui.item.label );
                  $( "#ProductName1" ).val('');
                  get_product_details_by_id_supply(ui.item.value,'single');
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
*/


  function ShowOrderDetailsDispatched(OrderId,invoicenumber=''){
      $.post(SITE_URL + '/orders/get_orders_dispatch_details_by_orderid', {
            OrderId: OrderId,invoicenumber:invoicenumber
        }, function (responsedata, status) {
          $("#orderdetails").html('');
          $("#orderdetails").html(responsedata);
        });
  }


  function ShowOrderDetailsSender(OrderId){
      $.post(SITE_URL + '/orders/get_orders_details_by_orderid', {
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

