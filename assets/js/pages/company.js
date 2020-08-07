function get_citylist(StateId){
    $.post(SITE_URL + '/city/get_city_by_stateid', {
            StateId: StateId
        }, function (responsedata, status) {
            //var response = JSON.parse(responsedata);
            $('#CityId').html(responsedata);
        });

   
}


$(document).ready(function (e) {
    $("#form_company_save").on('submit', (function (e) {
    var validate=0;

    var CompanyName = $('#CompanyName').val();
    if ($.trim(CompanyName)=='' && validate==0) {
    	$('#CompanyName').focus();
        alertify.alert('Please enter Company Name.');
        var validate=1;
    }
  

    
    var CompanyContactNo = $('#CompanyContactNo').val();
    if ($.trim(CompanyContactNo)=='' && validate==0) {
    	$('#CompanyContactNo').focus();
        alertify.alert('Please enter Company Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(CompanyContactNo)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Company Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var CompanyEmail = $('#CompanyEmail').val();
    if ($.trim(CompanyEmail)!='' && validate==0) {
        if (!valid_emailid.test(CompanyEmail)  && validate==0) {
	    	$('#CompanyEmail').focus();
	        alertify.alert('Please enter Company Email properly.');
	        var validate=1;
    	}
    }
/*
    var DivisionId = $('#DivisionId').val();
    if ($.trim(DivisionId)=='' && validate==0) {
    	$('#DivisionId').focus();
        alertify.alert('Please enter Division ');
        var validate=1;
    }
*/
    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Company Address');
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
            url: SITE_URL+'/company/company_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/company/';
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
    $("#form_company_update").on('submit', (function (e) {
    var validate=0;

   
    var CompanyName = $('#CompanyName').val();
    if ($.trim(CompanyName)=='' && validate==0) {
    	$('#CompanyName').focus();
        alertify.alert('Please enter Company Name.');
        var validate=1;
    }
  

    
    var CompanyContactNo = $('#CompanyContactNo').val();
    if ($.trim(CompanyContactNo)=='' && validate==0) {
    	$('#CompanyContactNo').focus();
        alertify.alert('Please enter Company Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(CompanyContactNo)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Company Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var CompanyEmail = $('#CompanyEmail').val();
    if ($.trim(CompanyEmail)!='' && validate==0) {
        if (!valid_emailid.test(CompanyEmail)  && validate==0) {
	    	$('#CompanyEmail').focus();
	        alertify.alert('Please enter Company Email properly.');
	        var validate=1;
    	}
    }
/*
    var DivisionId = $('#DivisionId').val();
    if ($.trim(DivisionId)=='' && validate==0) {
    	$('#DivisionId').focus();
        alertify.alert('Please enter Division ');
        var validate=1;
    }
*/
    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Company Address');
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
            url: SITE_URL+'/company/company_update', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/company/';
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
