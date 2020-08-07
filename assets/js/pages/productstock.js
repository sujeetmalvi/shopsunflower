
function pre_orderid_by_productid(stocktype){
    if(stocktype=='2' || stocktype=='3'){
        var unqId = $('#ProductId').val();
        var OrderType = $('#StockType').val();
        $.post(SITE_URL + '/productstock/get_pre_orderid_by_productid', {
            unqId:unqId,OrderType:OrderType
        }, function (responsedata, status) {
            $('#OrderId').html(responsedata);
        }); 
        $('#divOrderid').show();
        var inpt = "<label>Product QTY *</label><input id='ProductQty' name='ProductQty' type='text' class='form-control' required='' value='1' onclick='this.blur()'>";
        $('#QtyStock').html(inpt);
    }else{
        $('#divOrderid').hide();
        var inpt = "<label>Product QTY *</label><input id='ProductQty' name='ProductQty' type='number' class='form-control' required='' value='1'>";
        $('#QtyStock').html(inpt);
    }
}

function pre_orderqty_by_orderid_productid(){
    var unqId = $('#ProductId').val();
    var OrderId = $('#OrderId').val();
    var OrderType = $('#StockType').val();
    if(OrderId==''){ return false; }
    $.post(SITE_URL + '/productstock/get_pre_orderqty_by_orderid_productid', {
        unqId:unqId,OrderId:OrderId,OrderType:OrderType
    }, function (responsedata, status) {
        $('#ProductQty').val(responsedata);
    });    
}



function get_designcode_by_categoryid(CategoryId,DesignCode){
    $.post(SITE_URL + '/productstock/get_designcode_by_categoryid', {
            CategoryId : CategoryId,DesignCode:DesignCode
        }, function (responsedata, status) {
            $('#DesigneCode').html(responsedata);
        });
}


function get_productid_by_designcode(DesignCode,ProductId){
    $.post(SITE_URL + '/productstock/get_productid_by_designcode', {
            DesignCode : DesignCode,ProductId:ProductId
        }, function (responsedata, status) {
            $('#ProductId').html(responsedata);
        });
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

function changeproductstatus(productstockid,pstatus){
/*
    if($('#'+productstockid).prop( "checked" )){
        var pstatus = 1;
    }else{
        var pstatus = 0;
    }
*/
    $.post(SITE_URL + '/productstock/changeproductstatus', {
        productstockid : productstockid,pstatus:pstatus
        }, function (responsedata, status) {
            var response = JSON.parse(responsedata);
            console.log(response);
            $('#productstatus'+productstockid).html(response.prodstatus);
            if(pstatus==0){
                $('#pdt'+productstockid).text('0000:00:00 00:00:00');
                $('#rdt'+productstockid).text('0000:00:00 00:00:00');
            }
            if(pstatus==1){
                $('#pdt'+productstockid).text(response.dt);
                $('#rdt'+productstockid).text('0000:00:00 00:00:00');
            }
            if(pstatus==2){
                $('#rdt'+productstockid).text(response.dt);
            }
        });
}


function submitform(){
  $("#form_productstock_savenew").submit();
}

$(document).ready(function (e) {
    $("#form_productstock_savenew").on('submit', (function (e) {
    var validate=0;
    
    var CategoryId = $('#CategoryId').val();
    if ($.trim(CategoryId)=='' && validate==0) {
    	$('#CategoryId').focus();
        alertify.alert('Please select Category.');
         validate=1;
    }
    
    var DesigneCode = $('#DesigneCode').val();
    if ($.trim(DesigneCode)=='' && validate==0) {
    	$('#DesigneCode').focus();
        alertify.alert('Please select DesigneCode.');
         validate=1;
    }
    
    var ProductId = $('#ProductId').val();
    if ($.trim(ProductId)=='' && validate==0) {
    	$('#ProductId').focus();
        alertify.alert('Please select Product.');
         validate=1;
    }
    
    var StockType = $('#StockType').val();
    if ($.trim(StockType)=='' && validate==0) {
    	$('#StockType').focus();
        alertify.alert('Please select StockType.');
         validate=1;
    }
    if(StockType=='1'){
        var ProductQty = $('#ProductQty').val();
        if(ProductQty<=0){
            alertify.alert('Please enter Product Qty.');
            validate=1;
        }
    }
    if(StockType=='2'){
        var OrderId = $('#OrderId').val();
        if(OrderId==''){
            alertify.alert('Please select OrderId.');
            validate=1;
        }
        var ProductQty = $('#ProductQty').val();
        if(ProductQty<=0){
            alertify.alert('Please enter Product Qty.');
            validate=1;
        }
    }
    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/productstock/productstock_savenew', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/productstock';
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


function submitformupdate(){
    $("#form_productstock_updatenew").submit();
}
$(document).ready(function (e) {
    $("#form_productstock_updatenew").on('submit', (function (e) {
    var validate=0;
    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/productstock/productstock_updatenew', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/productstock';
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

function addmore(){
    var firstrow = $('#first_row').html();
    var row = '';
    var catlist = $('#cat_list').html();
    var rowcount = parseInt($('#rowcount').val());
        rowcount +=1;
    
        row ='<div class="form-group col-md-3">';
        row ='<label>Category *</label>';
        row ='<select name="CategoryId[]" id="CategoryId'+rowcount+'" class="form-control" onchange="get_designcode_by_categoryid(this.value,'+rowcount+');" required="">';
        row ='<option value="">Select Category</option>'+catlist+'</select>';
        row ='</div>';
        row ='<div class="form-group col-md-3">';
        row ='<label>Design Code *</label>';
        row ='<select name="DesigneCode[]" id="DesigneCode'+rowcount+'" class="form-control" onchange="get_productid_by_designcode(this.value,'+rowcount+');" required="">';
        row ='<option value="">Select Designe Code</option>';
        row ='</select>';
        row ='</div>';
        row ='<div class="form-group col-md-3">';
        row ='<label>Product *</label>';
        row ='<select name="ProductId[]" id="ProductId'+rowcount+'" class="form-control" required="">';
        row ='<option value="">Select Product</option>';
        row ='</select>';
        row ='</div>';
        row ='<div class="form-group col-md-1">';
        row ='<label>Action</label><br>';
        row ='<a href="javascript:;" class="btn btn-sm btn-danger" onclick="deleteme(this);"><i class="fa fa-trash"></i></a>';
        row ='</div>';
    
    var data = '<div class="row">'+firstrow+'</div>';
    $(data).insertBefore("#insertBefore");
}


function deleteme(element){
    var row = $(element).parent().parent();
    var id = $(row).attr('id');
    if(id != 'first_row'){
        $(row).remove();
    }
}


//$('input[name="daterange"]').daterangepicker({format: 'DD/MM/YYYY'});


