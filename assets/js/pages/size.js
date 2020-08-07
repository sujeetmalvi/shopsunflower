$(document).ready(function (e) {
    $("#form_size_save").on('submit', (function (e) {
    var validate=0;

    var SizeName = $('#SizeName').val();
    if ($.trim(SizeName)=='' && validate==0) {
        alertify.alert('Please enter Size Name.');
        var validate=1;
    }

    if (!valid_alphanumeric.test(SizeName)  && validate==0) {
        alertify.alert('Please enter Size Name in alphanumeric.');
        var validate=1;
    }
    
    var SizeCode = $('#SizeCode').val();
    if ($.trim(SizeCode)=='' && validate==0) {
        alertify.alert('Please enter Size Code.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(SizeCode)  && validate==0) {
        alertify.alert('Please enter Size Code in alphanumeric.');
        var validate=1;
    }


    

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/size/size_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/size';
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
    $("#form_size_update").on('submit', (function (e) {
    var validate=0;

    var SizeName = $('#SizeName').val();
    if ($.trim(SizeName)=='' && validate==0) {
        alertify.alert('Please enter Size Name.');
        var validate=1;
    }

    if (!valid_alphanumeric.test(SizeName)  && validate==0) {
        alertify.alert('Please enter Size Name in alphanumeric.');
        var validate=1;
    }
    
    var SizeCode = $('#SizeCode').val();
    if ($.trim(SizeCode)=='' && validate==0) {
        alertify.alert('Please enter Size Code.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(SizeCode)  && validate==0) {
        alertify.alert('Please enter Size Code in alphanumeric.');
        var validate=1;
    }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/size/size_update', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/size';
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
