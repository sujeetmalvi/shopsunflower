function submitform(){
  $("#form_product_savenew").submit();
}


function remove_all_products(){
  $('#productlist').html('');
  $('#showtotalamount').html('0.00');
}


$(document).ready(function (e) {
    $("#form_product_stock_excelupload").on('submit', (function (e) {
    var validate=0;
if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_stock_excelupload', // Url to which the request is send
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
                          $("#excelfile").val('');
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





$(document).ready(function (e) {
    $("#form_product_stock_savenew").on('submit', (function (e) {
    var validate=0;



if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_stock_savenew', // Url to which the request is send
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
            
         });



function get_product_details_by_id(ProductId,Type){
  var result="";
  var PurchaseRate=0;
  var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();

    $.post(SITE_URL + '/product/get_product_stock_received_by_id', {
            ProductId:ProductId, Type:Type
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

                  $.each( response.datas, function( i, data ) {

                    rowid = data.id;
                      result+='<div class="tr" id="row'+rowid+'">';
                      result+='<div class="td">'+data.ProductName+'</div>';
                      result+='<div class="td"><input type="text" style="width:100px;" class="form-control batchno" id="batchno'+rowid+'"  name="batchno[]"></div>';
                      result+='<div class="td"><input style="width:100px;" class="form-control mydatepicker expiry" id="expiry'+rowid+'"  name="expiry[]" value=""></div>';
                      result+='<div class="td"><input style="width:100px;" class="form-control mydatepicker mfgdate" id="mfgdate'+rowid+'"  name="mfgdate[]"></div>';
                      result+='<div class="td"><input type="text" name="MrpRate[]" class="MrpRate form-control" id="MrpRate'+rowid+'" value=""></div>';
                      result+='<div class="td"><input type="text" name="DiPrice[]" class="DiPrice form-control" id="DiPrice'+rowid+'" value=""></div>';
                      result+='<div class="td"><input type="text" name="DavaIndiaPrice[]" class="DavaIndiaPrice form-control" id="DavaIndiaPrice'+rowid+'" value=""></div>';
                      result+='<div class="td"><input type="text" style="width:100px;" class="form-control quantity" id="quantity'+rowid+'"  name="quantity[]" onchange="calculate_amount_onchange();" value="1"></div>';
                       result+='<input type="hidden" name="ProductId[]" id="ProductId'+rowid+'" value="'+data.id+'">';
                      result+='<input type="hidden" class="productrow" value="'+rowid+'">';
                      result+='</div>';
                      result+='</div>';
                
                  });


                  if(Type=='all_products'){
                        $('#productlist').html('');
                        result+='<div id="insertbefore"></div>';
                        $('#productlist').html(result);


                  }else{
                    
                    if ($('#ProductId'+rowid).length > 0) {
                      alertify.alert('This product is already in list.');              
                    }else{
                      $(result).insertBefore('#insertbefore');
                      $('#rowid').val(rowid);
                    }
                  }


            }else{
              alertify.alert(response.msg);
            }
          });

}


function form_product_stock_received_save(){
	$('#form_product_stock_received_save').submit();
}


$(document).ready(function (e) {
    $("#form_product_stock_received_save").on('submit', (function (e) {
    var validate=0;



if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_stock_received_save', // Url to which the request is send
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
                          setTimeout(function(){ 
                              window.location.href=SITE_URL+'/product/product_stock_received';  
                            }, 3000);
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


$(document).ready(function (e) {
    $("#form_product_stocknew_update").on('submit', (function (e) {
    var validate=0;



if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_stock_update', // Url to which the request is send
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
                          setTimeout(function(){ 
                              window.location.href=SITE_URL+'/product/product_stocknew';  
                            }, 3000);
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





