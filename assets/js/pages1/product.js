function submitform(){
  $("#form_product_savenew").submit();
}


function remove_all_products(){
  $('#productlist').html('');
  $('#showtotalamount').html('0.00');
}

$(document).ready(function (e) {
    $("#form_product_save").on('submit', (function (e) {
    var validate=0;

    var ProductCode = $('#ProductCode').val();
    if ($.trim(ProductCode)=='' && validate==0) {
    	$('#ProductCode').focus();
        alertify.alert('Please enter Product Code.');
         validate=1;
    }
    if (!valid_alphanumeric.test(ProductCode)  && validate==0) {
    	$('#ProductCode').focus();
        alertify.alert('Please enter Product Code in Words.');
         validate=1;
    }

    var ProductName = $('#ProductName_add').val();
    if ($.trim(ProductName)=='' && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }
    if (!valid_alpha.test(ProductName)  && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name in Words.');
         validate=1;
    }
    

    var CategoryId = $('#CategoryId').val();
    if ($.trim(CategoryId)!='' && validate==0) {
        if (!valid_alphanumeric.test(CategoryId)  && validate==0) {
            $('#CategoryId').focus();
            alertify.alert('Please enter Category Id in words or numbers or both.');
             validate=1;
        }
    }

   

    var PackingType1 = $('#PackingType1').val();
    if ($.trim(PackingType1)!='' && validate==0) {
        if (!valid_alphanumeric.test(PackingType1)  && validate==0) {
            $('#PackingType1').focus();
            alertify.alert('Please enter Packing Type1 in words or numbers or both.');
             validate=1;
        }
    }

    var PackingType2 = $('#PackingType2').val();
    if ($.trim(PackingType2)!='' && validate==0) {
        if (!valid_alphanumeric.test(PackingType2)  && validate==0) {
            $('#PackingType2').focus();
            alertify.alert('Please enter Packing Type2 in words or numbers or both.');
             validate=1;
        }
    }


    var OriginalPacking = $('#OriginalPacking').val();
    if ($.trim(OriginalPacking)!='' && validate==0) {
	    if (!valid_alphanumeric.test(OriginalPacking)  && validate==0) {
	    	$('#OriginalPacking').focus();
	        alertify.alert('Please enter Original Packing in words or numbers or both.');
	         validate=1;
	    }
    }

    var SamplePacking = $('#SamplePacking').val();
    if ($.trim(SamplePacking)!='' && validate==0) {
	    if (!valid_alphanumeric.test(SamplePacking)  && validate==0) {
	    	$('#SamplePacking').focus();
	        alertify.alert('Please enter Sample Packing in words or numbers or both.');
	         validate=1;
	    }
    }

    var ShipperPacking = $('#ShipperPacking').val();
    if ($.trim(ShipperPacking)!='' && validate==0) {
	    if (!valid_alphanumeric.test(ShipperPacking)  && validate==0) {
	    	$('#ShipperPacking').focus();
	        alertify.alert('Please enter Shipper Packing in words or numbers or both.');
	         validate=1;
	    }
    }


    var General_Food = $('#General_Food').val();
    if ($.trim(General_Food)!='' && validate==0) {
	    if (!valid_alphanumeric.test(General_Food)  && validate==0) {
	    	$('#General_Food').focus();
	        alertify.alert('Please enter General/Food in words or numbers or both.');
	         validate=1;
	    }
    }

    var PurchaseRate = $('#PurchaseRate').val();
    if ($.trim(PurchaseRate)!='' && validate==0) {
        if (!valid_amount_numeric.test(PurchaseRate)  && validate==0) {
            $('#PurchaseRate').focus();
            alertify.alert('Please enter Purchase Rate in numbers.');
             validate=1;
        }
    }

    var MrpRate = $('#MrpRate').val();
    if ($.trim(MrpRate)!='' && validate==0) {
        if (!valid_amount_numeric.test(MrpRate)  && validate==0) {
            $('#MrpRate').focus();
            alertify.alert('Please enter MRP Rate in numbers.');
             validate=1;
        }
    }

    var PTRMargin = $('#PTRMargin').val();
    if ($.trim(PTRMargin)!='' && validate==0) {
        if (!valid_amount_numeric.test(PTRMargin)  && validate==0) {
            $('#PTRMargin').focus();
            alertify.alert('Please enter PTR Margin in words or numbers or both.');
             validate=1;
        }
    }

    var PTSMargin = $('#PTSMargin').val();
    if ($.trim(PTSMargin)!='' && validate==0) {
        if (!valid_amount_numeric.test(PTSMargin)  && validate==0) {
            $('#PTSMargin').focus();
            alertify.alert('Please enter PTS Margin in words or numbers or both.');
             validate=1;
        }
    }

    var PTDMargin = $('#PTDMargin').val();
    if ($.trim(PTDMargin)!='' && validate==0) {
        if (!valid_amount_numeric.test(PTDMargin)  && validate==0) {
            $('#PTDMargin').focus();
            alertify.alert('Please enter PTD Margin in words or numbers or both.');
             validate=1;
        }
    }

    var SelfLifeExpiry = $('#SelfLifeExpiry').val();
    if ($.trim(SelfLifeExpiry)!='' && validate==0) {
        if (!valid_date.test(SelfLifeExpiry)  && validate==0) {
            $('#SelfLifeExpiry').focus();
            alertify.alert('Please enter SelfLifeExpiry in date format.');
             validate=1;
        }
    }

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/product/product_add';
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
    


    var ProductName = $('#ProductName_add').val();
    if ($.trim(ProductName)=='' && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }
    if (!valid_alphanumeric.test(ProductName)  && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name in Words.');
         validate=1;
    }
    
    
    var CompanyId= $('#CompanyId').val();
    if ($.trim(CompanyId)=='' && validate==0) {
    	$('#CompanyId').focus();
        alertify.alert('Please select Company');
        var validate=1;
    }
    
  
    var Active= $('#Active').val();
    if ($.trim(Active)=='' && validate==0) {
    	$('#Active').focus();
        alertify.alert('Please select Active');
        var validate=1;
    }
    
    
        var SalesPackQty= $('#SalesPackQty').val();
    if ($.trim(SalesPackQty)=='' && validate==0) {
    	$('#SalesPackQty').focus();
        alertify.alert('Please enter Sales Pack Qty.');
         validate=1;
    }
    
    
    var ShipperPack= $('#ShipperPack').val();
    if ($.trim(ShipperPack)=='' && validate==0) {
    	$('#ShipperPack').focus();
        alertify.alert('Please enter Shipper Pack.');
         validate=1;
    }
    
     var Ratio= $('#Ratio').val();
    if ($.trim(Ratio)=='' && validate==0) {
    	$('#Ratio').focus();
        alertify.alert('Please enter Ratio.');
         validate=1;
    }
    
   var CategoryId= $('#CategoryId').val();
    if ($.trim(CategoryId)=='' && validate==0) {
    	$('#CategoryId').focus();
        alertify.alert('Please select Category');
        var validate=1;
    }
   var SalesGSTId= $('#SalesGSTId').val();
    if ($.trim(SalesGSTId)=='' && validate==0) {
    	$('#SalesGSTId').focus();
        alertify.alert('Please select Sales GST');
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
    $("#form_product_update").on('submit', (function (e) {
    var validate=0;


  
    var ProductName = $('#ProductName_add').val();
    if ($.trim(ProductName)=='' && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }
    if (!valid_alphanumeric.test(ProductName)  && validate==0) {
    	$('#ProductName').focus();
        alertify.alert('Please enter Product Name in Words.');
         validate=1;
    }
    
    
    var CompanyId= $('#CompanyId').val();
    if ($.trim(CompanyId)=='' && validate==0) {
    	$('#CompanyId').focus();
        alertify.alert('Please select Company');
        var validate=1;
    }
    
  

    var Active= $('#Active').val();
    if ($.trim(Active)=='' && validate==0) {
    	$('#Active').focus();
        alertify.alert('Please select Active');
        var validate=1;
    }
    
    
        var SalesPackQty= $('#SalesPackQty').val();
    if ($.trim(SalesPackQty)=='' && validate==0) {
    	$('#SalesPackQty').focus();
        alertify.alert('Please enter Sales Pack Qty.');
         validate=1;
    }
    
    
    var ShipperPack= $('#ShipperPack').val();
    if ($.trim(ShipperPack)=='' && validate==0) {
    	$('#ShipperPack').focus();
        alertify.alert('Please enter Shipper Pack.');
         validate=1;
    }
    
     var Ratio= $('#Ratio').val();
    if ($.trim(Ratio)=='' && validate==0) {
    	$('#Ratio').focus();
        alertify.alert('Please enter Ratio.');
         validate=1;
    }
    
   var CategoryId= $('#CategoryId').val();
    if ($.trim(CategoryId)=='' && validate==0) {
    	$('#CategoryId').focus();
        alertify.alert('Please select Category');
        var validate=1;
    }
   var SalesGSTId= $('#SalesGSTId').val();
    if ($.trim(SalesGSTId)=='' && validate==0) {
    	$('#SalesGSTId').focus();
        alertify.alert('Please select Sales GST');
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
    $("#form_product_stock_save").on('submit', (function (e) {
    var validate=0;



if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/product/product_stock_save', // Url to which the request is send
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

    $.post(SITE_URL + '/product/get_product_details_by_id', {
            ProductId:ProductId, Type:Type
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

                  $.each( response.datas, function( i, data ) {

                    rowid = data.id;
                    var actual_PurchaseRate = parseFloat(data.PurchaseRate);
                    var actual_PTSMargin = parseFloat(data.PTSMargin);
                    var actual_PTRMargin = parseFloat(data.PTRMargin);
                    var actual_PTDMargin = parseFloat(data.PTDMargin);

                    if(UserRole=='stockist'){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTSMargin/100)));
                      PurchaseRate = PurchaseRate.toFixed(2);
                    }

                    if(UserRole=='retailer'){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTRMargin/100)));
                      PurchaseRate = PurchaseRate.toFixed(2);
                    }

                    if(UserRole=='distributor'){
                      PurchaseRate = actual_PurchaseRate+((actual_PurchaseRate*(actual_PTDMargin/100)));
                      PurchaseRate = PurchaseRate.toFixed(2);

                    }

                      result+='<div class="tr" id="row'+rowid+'">';
                      //result+='<div class="td">'+data.DivisionId+'</div>';
                      //result+='<div class="td">'+data.Composition+'</div>';
                      result+='<div class="td">'+data.ProductName+'</div>';
                      //result+='<div class="td">'+data.PackingType1+'</div>';
                      //result+='<div class="td">'+data.PackingType2+'</div>';
                      //result+='<div class="td">'+data.ShipperPacking+'</div>';

                      result+='<div class="td"><input type="text" style="width:100px;" class="form-control batchno" id="batchno'+rowid+'"  name="batchno[]"></div>';
                      result+='<div class="td"><input style="width:100px;" class="form-control mydatepicker expiry" id="expiry'+rowid+'"  name="expiry[]" value=""></div>';
                      result+='<div class="td"><input style="width:100px;" class="form-control mydatepicker mfgdate" id="mfgdate'+rowid+'"  name="mfgdate[]"></div>';

                      //result+='<div class="td">'+PurchaseRate+'</div>';
                      //result+='<div class="td">'+data.MrpRate+'</div>';
                      
                      result+='<div class="td"><input type="text" name="MrpRate[]" class="MrpRate form-control" id="MrpRate'+rowid+'" value=""></div>';
                      result+='<div class="td"><input type="text" name="DiPrice[]" class="DiPrice form-control" id="DiPrice'+rowid+'" value=""></div>';

                      result+='<div class="td"><input type="text" style="width:100px;" class="form-control quantity" id="quantity'+rowid+'"  name="quantity[]" onchange="calculate_amount_onchange();" value="1"></div>';
                      //result+='<div class="td"><input type="hidden" class="form-control" id="amount'+rowid+'" name="amount[]" value="'+PurchaseRate+'"> <span id="showamount'+rowid+'">'+PurchaseRate+'</span> ';
                      //result+='<input type="button" class="btn btn-xs btn-danger" title="Delete" onclick="deleteme('+rowid+')" value="X">';
                      //result+='<br><input type="button" class="btn btn-xs btn-primary" title="Details" onclick="showproductdetails('+data.id+')" value="#">';
                      result+='<input type="hidden" name="ProductId[]" id="ProductId'+rowid+'" value="'+data.id+'">';
                      result+='<input type="hidden" name="MrpRate[]" class="MrpRate" id="MrpRate'+rowid+'" value="'+data.MrpRate+'">';
                      result+='<input type="hidden" name="PurchaseRate[]" class="PurchaseRate" id="PurchaseRate'+rowid+'" value="'+PurchaseRate+'">';
                      result+='<input type="hidden" class="productrow" value="'+rowid+'">';
                      result+='</div>';
                      result+='</div>';
                
                  });


                  if(Type=='all_products'){
                        $('#productlist').html('');
                        result+='<div id="insertbefore"></div>';
                        $('#productlist').html(result);
                        $('#showtotalamount').html('0.00');

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
function deleteme(id){

  var totalamount = $('#TotalAmount').val();
  var amount = parseFloat($('#amount'+id).val());
    showtotalamount = parseFloat(totalamount)-parseFloat(amount);
    $('#TotalAmount').val(showtotalamount);
    $('#showtotalamount').html(showtotalamount.toFixed(2));

    $("#row"+id).remove();
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





