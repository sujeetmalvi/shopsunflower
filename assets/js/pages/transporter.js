$(document).ready(function (e) {
    $("#form_transporter_save").on('submit', (function (e) {
    var validate=0;

    var TransporterName = $('#TransporterName').val();
    if ($.trim(TransporterName)=='' && validate==0) {
    	$('#TransporterName').focus();
        alertify.alert('Please enter Transporter Name.');
        var validate=1;
    }
    var Landline = $('#Landline').val();
    if ($.trim(Landline)=='' && validate==0) {
    	$('#Landline').focus();
        alertify.alert('Please enter Transporter Landline.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(Landline)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Transporter Landlinein Numbers between 6 to 10 digit.');
        var validate=1;
    }
    var Mobile= $('#Mobile').val();
    if ($.trim(Mobile)=='' && validate==0) {
    	$('#Mobile').focus();
        alertify.alert('Please enter Transporter Mobile No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(Mobile)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Transporter Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }  
     var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Transporter Address');
        var validate=1;
    }
    var ContactPerson = $('#ContactPerson').val();
    if ($.trim(ContactPerson)=='' && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Transporter Name.');
        var validate=1;
    }
  
  

  if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/transporter/transporter_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/transporter/';
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
    $("#form_transporter_update").on('submit', (function (e) {
    var validate=0;

      var TransporterName = $('#TransporterName').val();
    if ($.trim(TransporterName)=='' && validate==0) {
    	$('#TransporterName').focus();
        alertify.alert('Please enter Transporter Name.');
        var validate=1;
    }
    
    var Landline = $('#Landline').val();
    if ($.trim(Landline)=='' && validate==0) {
    	$('#Landline').focus();
        alertify.alert('Please enter Transporter Landline.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(Landline)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Transporter Landlinein Numbers between 6 to 10 digit.');
        var validate=1;
    }
    var Mobile= $('#Mobile').val();
    if ($.trim(Mobile)=='' && validate==0) {
    	$('#Mobile').focus();
        alertify.alert('Please enter Transporter Mobile No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(Mobile)  && validate==0) {
    	$('#').focus();
        alertify.alert('Please enter Transporter Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }       
     var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Transporter Address');
        var validate=1;
    }
    
    var ContactPerson = $('#ContactPerson').val();
    if ($.trim(ContactPerson)=='' && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Transporter Name.');
        var validate=1;
    }

  
   

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/transporter/transporter_update', // Url to which the request is send
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
