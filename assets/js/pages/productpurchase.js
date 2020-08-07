
         $(function() {
    
    var products = '';

    $.post(SITE_URL+'/superadmin/productpurchase/get_product_details_by_id_json', {}, 
      function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                products = response.data;

                $( "#addProductName" ).autocomplete({
               minLength: 0,
               source: products, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#ProductName" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#addProductName" ).val( ui.item.label );
                  //$( "#ProductName" ).val('');
                  get_product_details_by_productid(ui.item.value,'add');
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


    var products = '';

    $.post(SITE_URL+'/superadmin/productpurchase/get_product_details_by_id_json', {}, 
      function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                products = response.data;

                $( "#editProductName" ).autocomplete({
               minLength: 0,
               source: products, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#editProductName" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#editProductName" ).val( ui.item.label );
                  //$( "#ProductName" ).val('');
                  get_product_details_by_productid(ui.item.value,'edit');
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


   var vendor = '';

    $.post(SITE_URL+'/vendor/get_vendor_details_by_id_json', {}, 
      function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
                vendor = response.data;

                $( "#VendorName" ).autocomplete({
               minLength: 0,
               source: vendor, //SITE_URL+'/product/get_product_details_by_id_json',
               focus: function( event, ui ) {
                  $( "#VendorName" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#VendorName" ).val( ui.item.label );
                  $( "#VendorId" ).val(ui.item.value);
                  //get_product_details_by_productid(ui.item.value);
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


function get_product_details_by_productid(ProductId,type){
    
    $.post(SITE_URL + '/superadmin/productpurchase/get_product_details_by_productid', {
            ProductId:ProductId
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {

              $('#'+type+'ProductId').val(response.data.id);
              $('#'+type+'ProductDescription').val(response.data.ProductDescription);
              $('#'+type+'SalesPack').val(response.data.SalesPack);
              $('#'+type+'Barcode').val(response.data.ProductBarcode);
              //alertify.alert(response.data);
            }
        });
}


function addproducttolist(){
  var result = '';
  var validate=0;

var rowid = parseInt($('#rowid').val());
var ProductName = $('#addProductName').val();
var ProductId = $('#addProductId').val();
var ProductDescription = $('#addProductDescription').val();
var SalesPack = $('#addSalesPack').val();
var Barcode = $('#addBarcode').val();
var ProductQuantity = $('#addProductQuantity').val();
var Batch = $('#addBatch').val();
var MarketPrice = $('#addMarketPrice').val();
var PurchasePrice = $('#addPurchasePrice').val();
var MfgDate = $('#addMfgDate').val();
var Expiry = $('#addExpiry').val();



    if ($.trim(ProductName)=='' && validate==0) {
      $('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }

    if ($.trim(ProductDescription)=='' && validate==0) {
      $('#ProductDescription').focus();
        alertify.alert('Please enter Product Description.');
         validate=1;
    }

    if ($.trim(SalesPack)=='' && validate==0) {
      $('#SalesPack').focus();
        alertify.alert('Please enter Sales Pack.');
         validate=1;
    }

    if ($.trim(Barcode)=='' && validate==0) {
      $('#Barcode').focus();
        alertify.alert('Please enter Barcode.');
         validate=1;
    }


    if ($.trim(ProductQuantity)=='' && validate==0) {
      $('#ProductQuantity').focus();
        alertify.alert('Please enter Product Quantity.');
         validate=1;
    }

    if (!valid_numeric.test(ProductQuantity)  && validate==0) {
      $('#ProductQuantity').focus();
        alertify.alert('Please enter Product Quantity in Numbers.');
         validate=1;
    }


    if ($.trim(Batch)=='' && validate==0) {
      $('#Batch').focus();
        alertify.alert('Please enter Product Batch.');
         validate=1;
    }


    if ($.trim(MarketPrice)=='' && validate==0) {
      $('#MarketPrice').focus();
        alertify.alert('Please enter Product Market Price.');
         validate=1;
    }

    if (!valid_amount_numeric.test(MarketPrice)  && validate==0) {
      $('#MarketPrice').focus();
      alertify.alert('Please enter Product Market Price in Numbers.');
      validate=1;
    }


    if ($.trim(PurchasePrice)=='' && validate==0) {
      $('#PurchasePrice').focus();
        alertify.alert('Please enter Product Purchase Price.');
         validate=1;
    }
    if (!valid_numeric.test(PurchasePrice)  && validate==0) {
      $('#PurchasePrice').focus();
        alertify.alert('Please enter Product PurchaseP rice in Numbers.');
         validate=1;
    }

    if ($.trim(MfgDate)=='' && validate==0) {
      $('#MfgDate').focus();
        alertify.alert('Please enter Product Mfg Date.');
         validate=1;
    }

    if ($.trim(Expiry)=='' && validate==0) {
      $('#Expiry').focus();
        alertify.alert('Please enter Product Expiry.');
         validate=1;
    }

if(validate!=0){
  return false;
}
rowid = rowid+1;

  result +='<div class="tr" id="row'+rowid+'">';
  result +='<div class="td" style="padding:6px;">'+ProductName+' ( '+ProductDescription+' )'+'</div>';
  result +='<div class="td" style="padding:6px;">'+Barcode+'</div>';
  result +='<div class="td" style="padding:6px;">'+SalesPack+'</div>';
  result +='<div class="td" style="padding:6px;">'+Batch+'</div>';
  result +='<div class="td" style="padding:6px;">'+MarketPrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+PurchasePrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+MfgDate+'</div>';
  result +='<div class="td" style="padding:6px;">'+Expiry+'</div>';
  result +='<div class="td" style="padding:6px;">'+ProductQuantity+'</div>';
  result+='<div class="td" style="padding:6px;">';
  result+='<a class="btn btn-xs btn-warning" title="Edit" onclick="editeme(\''+rowid+'\')"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
  result+='&nbsp; <a class="btn btn-xs btn-danger" title="Delete" onclick="deleteme(\''+rowid+'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
  result+='</div>';
  result+='<input type="hidden" id="ProductName'+rowid+'" name="ProductName[]" value="'+ProductName+'"/>';
  result+='<input type="hidden" id="ProductDescription'+rowid+'" name="ProductDescription[]" value="'+ProductDescription+'"/>';
  result+='<input type="hidden" id="ProductId'+rowid+'" name="ProductId[]" value="'+ProductId+'"/>';
  result+='<input type="hidden" id="SalesPack'+rowid+'" name="SalesPack[]" value="'+SalesPack+'"/>';
  result+='<input type="hidden" id="Barcode'+rowid+'" name="Barcode[]" value="'+Barcode+'"/>';
  result+='<input type="hidden" id="ProductQuantity'+rowid+'" name="ProductQuantity[]" value="'+ProductQuantity+'"/>';
  result+='<input type="hidden" id="Batch'+rowid+'" name="Batch[]" value="'+Batch+'"/>';
  result+='<input type="hidden" id="MarketPrice'+rowid+'" name="MarketPrice[]" value="'+MarketPrice+'"/>';
  result+='<input type="hidden" id="PurchasePrice'+rowid+'" name="PurchasePrice[]" value="'+PurchasePrice+'"/>';
  result+='<input type="hidden" id="MfgDate'+rowid+'" name="MfgDate[]" value="'+MfgDate+'"/>';
  result+='<input type="hidden" id="Expiry'+rowid+'" name="Expiry[]" value="'+Expiry+'"/>';
  result +='</div>';
  
    $('#rowid').val(rowid);
    $(result).insertAfter('#insertAfter');

    $('#addProductName').val('');
    $('#addProductDescription').val('');
    $('#addProductId').val('');
    $('#addSalesPack').val('');
    $('#addBarcode').val('');
    $('#addProductQuantity').val('');
    $('#addBatch').val('');
    $('#addMarketPrice').val('');
    $('#addPurchasePrice').val('');
    $('#addMfgDate').val('');
    $('#addExpiry').val('');

    $('#addproduct').modal('hide');
}

function deleteme(rowid){
  $("#row"+rowid).remove();
}


function editeme(editrowid){

  var ProductName = $('#ProductName'+editrowid).val();
  var ProductId = $('#ProductId'+editrowid).val();
  var ProductDescription = $('#ProductDescription'+editrowid).val();
  var SalesPack = $('#SalesPack'+editrowid).val();
  var Barcode = $('#Barcode'+editrowid).val();
  var ProductQuantity = $('#ProductQuantity'+editrowid).val();
  var Batch = $('#Batch'+editrowid).val();
  var MarketPrice = $('#MarketPrice'+editrowid).val();
  var PurchasePrice = $('#PurchasePrice'+editrowid).val();
  var MfgDate = $('#MfgDate'+editrowid).val();
  var Expiry = $('#Expiry'+editrowid).val();

    $('#editProductName').val(ProductName);
    $('#editProductDescription').val(ProductDescription);
    $('#editProductId').val(ProductId);
    $('#editSalesPack').val(SalesPack);
    $('#editBarcode').val(Barcode);
    $('#editProductQuantity').val(ProductQuantity);
    $('#editBatch').val(Batch);
    $('#editMarketPrice').val(MarketPrice);
    $('#editPurchasePrice').val(PurchasePrice);
    $('#editMfgDate').val(MfgDate);
    $('#editExpiry').val(Expiry);
    $('#editrowid').val(editrowid);
    $('#editproduct').modal('show');

}


function editproducttolist(){
  var result = '';
  var validate=0;

var rowid = parseInt($('#editrowid').val());
var ProductName = $('#editProductName').val();
var ProductId = $('#editProductId').val();
var ProductDescription = $('#editProductDescription').val();
var SalesPack = $('#editSalesPack').val();
var Barcode = $('#editBarcode').val();
var ProductQuantity = $('#editProductQuantity').val();
var Batch = $('#editBatch').val();
var MarketPrice = $('#editMarketPrice').val();
var PurchasePrice = $('#editPurchasePrice').val();
var MfgDate = $('#editMfgDate').val();
var Expiry = $('#editExpiry').val();

    if ($.trim(ProductName)=='' && validate==0) {
      $('#ProductName').focus();
        alertify.alert('Please enter Product Name.');
         validate=1;
    }

    if ($.trim(ProductDescription)=='' && validate==0) {
      $('#ProductDescription').focus();
        alertify.alert('Please enter Product Description.');
         validate=1;
    }

    if ($.trim(SalesPack)=='' && validate==0) {
      $('#SalesPack').focus();
        alertify.alert('Please enter Sales Pack.');
         validate=1;
    }

    if ($.trim(Barcode)=='' && validate==0) {
      $('#Barcode').focus();
        alertify.alert('Please enter Barcode.');
         validate=1;
    }


    if ($.trim(ProductQuantity)=='' && validate==0) {
      $('#ProductQuantity').focus();
        alertify.alert('Please enter Product Quantity.');
         validate=1;
    }

    if (!valid_numeric.test(ProductQuantity)  && validate==0) {
      $('#ProductQuantity').focus();
        alertify.alert('Please enter Product Quantity in Numbers.');
         validate=1;
    }


    if ($.trim(Batch)=='' && validate==0) {
      $('#Batch').focus();
        alertify.alert('Please enter Product Batch.');
         validate=1;
    }


    if ($.trim(MarketPrice)=='' && validate==0) {
      $('#MarketPrice').focus();
        alertify.alert('Please enter Product Market Price.');
         validate=1;
    }

    if (!valid_amount_numeric.test(MarketPrice)  && validate==0) {
      $('#MarketPrice').focus();
      alertify.alert('Please enter Product Market Price in Numbers.');
      validate=1;
    }


    if ($.trim(PurchasePrice)=='' && validate==0) {
      $('#PurchasePrice').focus();
        alertify.alert('Please enter Product Purchase Price.');
         validate=1;
    }
    if (!valid_numeric.test(PurchasePrice)  && validate==0) {
      $('#PurchasePrice').focus();
        alertify.alert('Please enter Product PurchaseP rice in Numbers.');
         validate=1;
    }

    if ($.trim(MfgDate)=='' && validate==0) {
      $('#MfgDate').focus();
        alertify.alert('Please enter Product Mfg Date.');
         validate=1;
    }

    if ($.trim(Expiry)=='' && validate==0) {
      $('#Expiry').focus();
        alertify.alert('Please enter Product Expiry.');
         validate=1;
    }

if(validate!=0){
  return false;
}

  $('#row'+rowid).remove();

  result +='<div class="tr" id="row'+rowid+'">';
  result +='<div class="td" style="padding:6px;">'+ProductName+' ( '+ProductDescription+' )'+'</div>';
  result +='<div class="td" style="padding:6px;">'+Barcode+'</div>';
  result +='<div class="td" style="padding:6px;">'+SalesPack+'</div>';
  result +='<div class="td" style="padding:6px;">'+Batch+'</div>';
  result +='<div class="td" style="padding:6px;">'+MarketPrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+PurchasePrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+MfgDate+'</div>';
  result +='<div class="td" style="padding:6px;">'+Expiry+'</div>';
  result +='<div class="td" style="padding:6px;">'+ProductQuantity+'</div>';
  result+='<div class="td" style="padding:6px;">';
  result+='<a class="btn btn-xs btn-warning" title="Edit" onclick="editeme(\''+rowid+'\')"><i class="fa fa-pencil" aria-hidden="true"></i></a> ';
  result+='&nbsp; <a class="btn btn-xs btn-danger" title="Delete" onclick="deleteme(\''+rowid+'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
  result+='</div>';
  result+='<input type="hidden" id="ProductName'+rowid+'" name="ProductName[]" value="'+ProductName+'"/>';
  result+='<input type="hidden" id="ProductDescription'+rowid+'" name="ProductDescription[]" value="'+ProductDescription+'"/>';
  result+='<input type="hidden" id="ProductId'+rowid+'" name="ProductId[]" value="'+ProductId+'"/>';
  result+='<input type="hidden" id="SalesPack'+rowid+'" name="SalesPack[]" value="'+SalesPack+'"/>';
  result+='<input type="hidden" id="Barcode'+rowid+'" name="Barcode[]" value="'+Barcode+'"/>';
  result+='<input type="hidden" id="ProductQuantity'+rowid+'" name="ProductQuantity[]" value="'+ProductQuantity+'"/>';
  result+='<input type="hidden" id="Batch'+rowid+'" name="Batch[]" value="'+Batch+'"/>';
  result+='<input type="hidden" id="MarketPrice'+rowid+'" name="MarketPrice[]" value="'+MarketPrice+'"/>';
  result+='<input type="hidden" id="PurchasePrice'+rowid+'" name="PurchasePrice[]" value="'+PurchasePrice+'"/>';
  result+='<input type="hidden" id="MfgDate'+rowid+'" name="MfgDate[]" value="'+MfgDate+'"/>';
  result+='<input type="hidden" id="Expiry'+rowid+'" name="Expiry[]" value="'+Expiry+'"/>';
  result +='</div>';
  
  $('#rowid').val(rowid);
  $(result).insertAfter('#insertAfter');

$('#editProductName').val('');
$('#editProductDescription').val('');
$('#editProductId').val('');
$('#editSalesPack').val('');
$('#editBarcode').val('');
$('#editProductQuantity').val('');
$('#editBatch').val('');
$('#editMarketPrice').val('');
$('#editPurchasePrice').val('');
$('#editMfgDate').val('');
$('#editExpiry').val('');

  $('#editproduct').modal('hide');
}

function clearform(){

$('#addProductName').val('');
$('#addProductDescription').val('');
$('#addProductId').val('');
$('#addSalesPack').val('');
$('#addBarcode').val('');
$('#addProductQuantity').val('');
$('#addBatch').val('');
$('#addMarketPrice').val('');
$('#addPurchasePrice').val('');
$('#addMfgDate').val('');
$('#addExpiry').val('');

$('#editProductName').val('');
$('#editProductDescription').val('');
$('#editProductId').val('');
$('#editSalesPack').val('');
$('#editBarcode').val('');
$('#editProductQuantity').val('');
$('#editBatch').val('');
$('#editMarketPrice').val('');
$('#editPurchasePrice').val('');
$('#editMfgDate').val('');
$('#editExpiry').val('');

}


$(document).ready(function (e) {
    $("#form_productpurchase_save").on('submit', (function (e) {
    var validate=0;
   

if(validate==0){
$('#LoadingModal').modal('show');
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/superadmin/productpurchase/productpurchase_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/superadmin/productpurchase/productpurchase_list';                         

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


function product_purchase_details(ProductPurchaseId){
    
    var result='';
    $('#productpurchaselist').html('');
    result+='<div id="insertAfter"></div>';
    $('#productpurchaselist').html(result);
    var result='';


    $.post(SITE_URL + '/superadmin/productpurchase/get_productpurchase_details_by_productpurchaseid', {
            ProductPurchaseId:ProductPurchaseId
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {


  result +='<div class="tr" id="row">';
  result +='<div class="td" style="padding:6px;">'+response.data.ProductName+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.ProductDescription+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.Barcode+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.SalesPack+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.Batch+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.MarketPrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.PurchasePrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.MfgDate+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.Expiry+'</div>';
  result +='<div class="td" style="padding:6px;">'+response.data.ProductQuantity+'</div>';

  $(result).insertAfter('#insertAfter');
  $('#productpurchasedetailsmodal').modal('show');

              //alertify.alert(response.data);
            }
        });

}

function addtostock(ProductPurchaseId){
      var result='';
    $('#addtostocklist').html('');
    result+='<div id="insertAfteraddtostock"></div>';
    $('#addtostocklist').html(result);
    var result='';


    $.post(SITE_URL + '/superadmin/productpurchase/get_productpurchase_details_by_productpurchaseid', {
            ProductPurchaseId:ProductPurchaseId
        }, function(responsedata,status){
            responsedata = responsedata.trim();
            var response = JSON.parse(responsedata);
            if (response.status== true) {
 
            $('#ProductPurchaseId').val(ProductPurchaseId);

        $.each( response.datas, function( i, data ) {

  result +='<div class="tr" id="row">';
  result +='<div class="td" style="padding:6px;"></div>';
  result +='<div class="td" style="padding:6px;">'+data.ProductName+'<hr style="margin-top: 6px;margin-bottom: 6px;">'+data.ProductDescription+'</div>';
  result +='<div class="td" style="padding:6px;">'+data.Barcode+'<hr style="margin-top: 6px;margin-bottom: 6px;">'+data.SalesPack+'<hr style="margin-top: 6px;margin-bottom: 6px;">'+data.Batch+'</div>';
  result +='<div class="td" style="padding:6px;">'+data.MarketPrice+'<hr style="margin-top: 6px;margin-bottom: 6px;">'+data.PurchasePrice+'</div>';
  result +='<div class="td" style="padding:6px;">'+data.MfgDate+'<hr style="margin-top: 6px;margin-bottom: 6px;">'+data.Expiry+'</div>';
  result +='<div class="td" style="padding:6px;">'+data.ProductQuantity+'</div>';

  result +='<div class="td" style="padding:6px;"><input type="text" style="width:60px" class="form-control" name="SalesGst[]" id="SalesGst" value="0"></div>';
  result +='<div class="td" style="padding:6px;"><input type="text" style="width:60px" class="form-control" name="DiPrice[]" id="DiPrice" value="0" ></div>';
  result +='<div class="td" style="padding:6px;"><input type="text" style="width:60px" class="form-control" name="DavaIndiaPrice[]" id="DavaIndiaPrice" value="0" ></div>';
  result +='<div class="td" style="padding:6px;"><input type="text" style="width:60px" class="form-control" name="Ratio[]" id="Ratio" value="0" ></div>';
  result +='<div class="td" style="padding:6px;"><textarea class="form-control" name="ReceivedRemarks[]" id="ReceivedRemarks"></textarea>';
  
  result +='<input type="hidden" name="ProductName[]" id="ProductName" value="'+data.ProductName+'">';
  result +='<input type="hidden" name="ProductId[]" id="ProductId" value="'+data.ProductId+'">';
  result +='<input type="hidden" name="Barcode[]" id="Barcode[]" value="'+data.Barcode+'">';
  result +='<input type="hidden" name="SalesPack[]" id="SalesPack" value="'+data.SalesPack+'">';
  result +='<input type="hidden" name="Batch[]" id="Batch" value="'+data.Batch+'">';
  result +='<input type="hidden" name="MarketPrice[]" id="MarketPrice" value="'+data.MarketPrice+'">';
  result +='<input type="hidden" name="PurchasePrice[]" id="PurchasePrice" value="'+data.PurchasePrice+'">';
  result +='<input type="hidden" name="MfgDate[]" id="MfgDate" value="'+data.MfgDate+'">';
  result +='<input type="hidden" name="Expiry[]" id="Expiry" value="'+data.Expiry+'">';
  result +='<input type="hidden" name="ProductQuantity[]" id="ProductQuantity" value="'+data.ProductQuantity+'">';
  result +='</div>';
  result +='</div>';

});

  $(result).insertAfter('#insertAfteraddtostock');
  $('#addtostockmodal').modal('show');

                //alertify.alert(response.data);
            }
        });
}






$(document).ready(function (e) {
    $("#form_addtostock_save").on('submit', (function (e) {
    var validate=0;
   

if(validate==0){
$('#LoadingModal').modal('show');
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/superadmin/productpurchase/addtostock_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/superadmin/productpurchase/productpurchase_list';                         

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
