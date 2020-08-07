function submitform(){
  $("#form_product_savenew").submit();
}

function updateform(){
  $("#form_product_updatenew").submit();
}


function remove_all_products(){
  $('#productlist').html('');
  $('#showtotalamount').html('0.00');
}




$(document).ready(function (e) {
    $("#form_product_excelupload").on('submit', (function (e) {
    var validate=0;
if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_excelupload', // Url to which the request is send
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
    $("#form_product_savenew").on('submit', (function (e) {
    var validate=0;
    
    var CategoryId= $('#CategoryId').val();
    if ($.trim(CategoryId)=='' && validate==0) {
    	$('#CategoryId').focus();
        alertify.alert('Please select Category');
        var validate=1;
    }
    
    var ColourId= $('#ColourId').val();
    if ($.trim(ColourId)=='' && validate==0) {
    	$('#ColourId').focus();
        alertify.alert('Please select Colour');
        var validate=1;
    }
    
    var SizeId= $('#SizeId').val();
    if ($.trim(SizeId)=='' && validate==0) {
    	$('#SizeId').focus();
        alertify.alert('Please select Size');
        var validate=1;
    }
    
    var ProductName = $('#ProductName_add').val();
    if ($.trim(ProductName)=='' && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }
    
    var ProductPrice= $('#ProductPrice').val();
    if ($.trim(ProductPrice)=='' && validate==0) {
    	$('#ProductPrice').focus();
        alertify.alert('Please enter Product Price');
        var validate=1;
    }
    
    var DesigneCode= $('#DesigneCode').val();
    if ($.trim(DesigneCode)=='' && validate==0) {
    	$('#DesigneCode').focus();
        alertify.alert('Please enter Designe Code');
        var validate=1;
    }
    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_savenew', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/product/product_addnew';
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
    $("#form_product_addimages").on('submit', (function (e) {
    var validate=0;
   

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_addimages_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/product/';
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
    $("#form_product_updatenew").on('submit', (function (e) {
    var validate=0;
    
    var CategoryId= $('#CategoryId').val();
    if ($.trim(CategoryId)=='' && validate==0) {
    	$('#CategoryId').focus();
        alertify.alert('Please select Category');
        var validate=1;
    }
    
    var ColourId= $('#ColourId').val();
    if ($.trim(ColourId)=='' && validate==0) {
    	$('#ColourId').focus();
        alertify.alert('Please select Colour');
        var validate=1;
    }
    
    var SizeId= $('#SizeId').val();
    if ($.trim(SizeId)=='' && validate==0) {
    	$('#SizeId').focus();
        alertify.alert('Please select Size');
        var validate=1;
    }
    
    var ProductName = $('#ProductName_add').val();
    if ($.trim(ProductName)=='' && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }
    
    var ProductPrice= $('#ProductPrice').val();
    if ($.trim(ProductPrice)=='' && validate==0) {
    	$('#ProductPrice').focus();
        alertify.alert('Please enter Product Price');
        var validate=1;
    }
    
    var DesigneCode= $('#DesigneCode').val();
    if ($.trim(DesigneCode)=='' && validate==0) {
    	$('#DesigneCode').focus();
        alertify.alert('Please enter Designe Code');
        var validate=1;
    }
    

   

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_update', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/product';
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
    $('#TotalAmount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

}

function calculate_amount(rowid,quantity,PTRMargin,PTSMargin,PTDMargin,PurchaseRate){
  //var rowid = parseInt($('#rowid').val());
  var UserRole = $('#UserRole').val();
  var totalamount = parseFloat($('#TotalAmount').val());
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
    $('#TotalAmount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

  }
}

// function deleteme(id){

//   $(id).parent().parent().remove();

// }

/*
function deleteme(id){

  var totalamount = $('#TotalAmount').val();
  var amount = parseFloat($('#amount'+id).val());
    showtotalamount = parseFloat(totalamount)-parseFloat(amount);
    $('#TotalAmount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

    $("#row"+id).remove();
}


*/




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





