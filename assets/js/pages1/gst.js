$(document).ready(function (e) {
    $("#form_gst_save").on('submit', (function (e) {
    var validate=0;

    var GstName = $('#GstName').val();
    if ($.trim(GstName)=='' && validate==0) {
    	$('#GstName').focus();
        alertify.alert('Please enter Gst Name.');
        var validate=1;
    }
	
	var GstValue = $('#GstValue').val();
    if ($.trim(GstValue)=='' && validate==0) {
    	$('#GstValue').focus();
        alertify.alert('Please enter Gst Value.');
        var validate=1;
    }
	if (!valid_amount_numeric.test(GstValue)  && validate==0) {
    	$('#GstValue').focus();
        alertify.alert('Please enter Gst Value in Numbers');
        var validate=1;
    }
    
	var GstApply = $('#GstApply').val();
    if ($.trim(GstApply)=='' && validate==0) {
    	$('#GstApply').focus();
        alertify.alert('Please enter Gst Value.');
        var validate=1;
    }
	if (!valid_amount_numeric.test(GstApply)  && validate==0) {
    	$('#GstApply').focus();
        alertify.alert('Please enter Gst Apply in Numbers');
        var validate=1;
    }
/*	
	 var GstType = $('#GstType').val();
    if ($.trim(GstType)=='' && validate==0) {
    	$('#GstType').focus();
        alertify.alert('Please enter Gst Type.');
        var validate=1;
    }
 */

  if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/gst/gst_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/gst/';
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
    $("#form_gst_update").on('submit', (function (e) {
    var validate=0;

      var GstName = $('#GstName').val();
    if ($.trim(GstName)=='' && validate==0) {
    	$('#GstName').focus();
        alertify.alert('Please enter Gst Name.');
        var validate=1;
    }
  
   

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/gst/gst_update', // Url to which the request is send
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
