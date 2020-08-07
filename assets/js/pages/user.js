
$(document).ready(function (e) {
    $("#form_user_save").on('submit', (function (e) {
    var validate=0;

    // var ShopName = $('#ShopName').val();
    // if ($.trim(ShopName)=='' && validate==0) {
    // 	$('#ShopName').focus();
    //     alertify.alert('Please enter Shop Name.');
    //     validate=1;
    // }
    // var Address = $('#Address').val();
    // if ($.trim(Address)=='' && validate==0) {
    // 	$('#Address').focus();
    //     alertify.alert('Please enter Shop Address');
    //     validate=1;
    // }
    // var State = $('#State').val();
    // if ($.trim(State)=='' && validate==0) {
    // 	$('#State').focus();
    //     alertify.alert('Please enter State');
    //     validate=1;
    // }
    // var City = $('#City').val();
    // if ($.trim(City)=='' && validate==0) {
    // 	$('#City').focus();
    //     alertify.alert('Please enter City');
    //     validate=1;
    // }

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/user/user_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/user/';
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
    $("#form_user_update").on('submit', (function (e) {
    var validate=0;

    //  var ShopName = $('#ShopName').val();
    // if ($.trim(ShopName)=='' && validate==0) {
    // 	$('#ShopName').focus();
    //     alertify.alert('Please enter Shop Name.');
    //     validate=1;
    // }
    // var Address = $('#Address').val();
    // if ($.trim(Address)=='' && validate==0) {
    // 	$('#Address').focus();
    //     alertify.alert('Please enter Shop Address');
    //     validate=1;
    // }
    // var State = $('#State').val();
    // if ($.trim(State)=='' && validate==0) {
    // 	$('#State').focus();
    //     alertify.alert('Please enter State');
    //     validate=1;
    // }
    // var City = $('#City').val();
    // if ($.trim(City)=='' && validate==0) {
    // 	$('#City').focus();
    //     alertify.alert('Please enter City');
    //     validate=1;
    // }

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/user/user_update', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/user/';
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
