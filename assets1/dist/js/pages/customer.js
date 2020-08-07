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

    var CustomerName = $('#CustomerName').val();
    if ($.trim(CustomerName)=='' && validate==0) {
    	$('#CustomerName').focus();
        alertify.alert('Please enter Customer Name.');
        var validate=1;
    }
    if (!valid_alpha.test(CustomerName)  && validate==0) {
    	$('#CustomerName').focus();
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
        alertify.alert('Please enter Customer Contact No in Numbers between 6 to 10 digit.');
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


    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Customer Address');
        var validate=1;
    }

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
                          window.location.href=SITE_URL+'/customer/customer_add';
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
    $("#form_customer_update").on('submit', (function (e) {
    var validate=0;

    var CustomerName = $('#CustomerName').val();
    if ($.trim(CustomerName)=='' && validate==0) {
    	$('#CustomerName').focus();
        alertify.alert('Please enter Customer Name.');
        var validate=1;
    }
    if (!valid_alpha.test(CustomerName)  && validate==0) {
    	$('#CustomerName').focus();
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
        alertify.alert('Please enter Customer Contact No in Numbers between 6 to 10 digit.');
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



    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Customer Address');
        var validate=1;
    }

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
            url: SITE_URL+'/customer/customer_update', // Url to which the request is send
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
