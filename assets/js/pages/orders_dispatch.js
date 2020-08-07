// $('#myModal').on('hidden', function () {
//     // do something…
// });



function check_quantity(orderqty,newqty,id){
    if(orderqty<newqty){
        alertify.alert("Quantity cannot be greater than ordered quantity");
        $('#'+id).val(orderqty);
    }
}


function showproductuicmodal(id){
    var DesigneCode = $('#designecode'+id).val();
    var ColourId = $('#colourid'+id).val();
    var SizeId = $('#sizeid'+id).val();
      $.post(SITE_URL + '/orders/get_produic_by_design_color_size', {
            DesigneCode:DesigneCode,ColourId:ColourId,SizeId:SizeId
        }, function (responsedata,status) {
          $("#productuics").html('');
          $("#productuics").val('');
          $("#productuics").html(responsedata);
          $("#id").val(id);
        });
    $('#productuicmodal').modal('show');
}

function set_product_uic(){
    var productuics = $('#productuics').val();
    if(productuics==null){
        alertify.alert('Please remove values and select again.');
        return false;
    }
    var id = $('#id').val();
    $('#productuicvalue'+id).val(productuics);
        $.post(SITE_URL + '/orders/get_produic_to_productorders', {
            ProductOrdersId:id,ProductUIC:productuics
        }, function (responsedata,status) { console.log(responsedata) });
    $('#productuicmodal').modal('hide');
}


$("#form_orders_dispatch").on('submit', (function (e) {
    var validate=0;
    
    var validate=0;
    
    var InvoiceDate = $('#InvoiceDate').val();
    if ($.trim(InvoiceDate)=='' && validate==0) {
    	$('#InvoiceDate').focus();
        alertify.alert('Please select Invoice Date.');
         validate=1;
    }
    
    var InvoiceNumber = $('#InvoiceNumber').val();
    if ($.trim(InvoiceNumber)=='' && validate==0) {
    	$('#InvoiceNumber').focus();
        alertify.alert('Please select Invoice Number.');
         validate=1;
    }
    
if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/orders/orders_dispatch_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/orders/orders_dispatch';
                          
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
    
$('.dispatch_productUIC').click(function(){
    if($(this).is(':checked')){
        calculate_amount($(this).data('orderid'));
    } else {
        calculate_amount($(this).data('orderid'));
    }
});
    
function calculate_amount(orderid){
    debugger;
    var price = $('#price'+orderid).val();
    var OrderQuantity = $('.dispatchprod'+orderid+":checkbox:checked").length; //$('#OrderQuantity'+orderid).val();
//    var OrderQuantity = $('input:checkbox:checked').length; //$('#OrderQuantity'+orderid).val();
    amount = parseInt(OrderQuantity)*parseInt(price);
    $('#amount'+orderid).val(amount.toFixed(2));
    $('#quantity'+orderid).val(OrderQuantity);
    $('#show_amount'+orderid).text(amount.toFixed(2));
   
   var ttl_amt = 0;
    $('.amount').each(function(i, obj) {
       ttl_amt += parseInt(obj.value);
    });
    $('#total_amount').html(ttl_amt);

    //calculate_total_amount();
}	


    