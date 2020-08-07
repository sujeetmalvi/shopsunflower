   
// (function() {
//      function IDGenerator(len) {
     
//          this.length = len;
//          this.timestamp = +new Date;
         
//          var _getRandomInt = function( min, max ) {
//             return Math.floor( Math.random() * ( max - min + 1 ) ) + min;
//          }
         
//          this.generate = function() {
//              var ts = this.timestamp.toString();
//              var parts = ts.split( "" ).reverse();
//              var id = "";
             
//              for( var i = 0; i < this.length; ++i ) {
//                 var index = _getRandomInt( 0, parts.length - 1 );
//                 id += parts[index];  
//              }
             
//              return id;
//          }

         
//      }
     
     
//      document.addEventListener( "DOMContentLoaded", function() {
//         var btn = document.querySelector( "#generate" ),
//             output = document.querySelector( "#output" );
            
//         btn.addEventListener( "click", function() {
//             var generator = new IDGenerator(8);
//             output.innerHTML = generator.generate();
//              var unique_id=output.innerHTML;
//              $('#unique_id').val('XMHL'+unique_id);
            
//             // var generator = new IDGenerator(6);
//             // output.innerHTML = generator.generate();
//             //  var password=output.innerHTML;
//             //  $('#Applicantpassword').val(password);
//             myFunctionRegistration();
             
//         }, false); 
         
//      });
     
     
//  })();

$( "#add_more_row" ).click(function() {
    var htmlrow = $("#listrow1").html();
    $( htmlrow ).insertBefore( $( "#insertbefore" ) );
});

function deleterow(id){
  $(id).parent().parent().remove();
}


$(document).ready(function (e) {
    $("#form_driver_save").on('submit', (function (e) {
    var validate=0;

    var DriverName = $('#DriverName').val();
    if ($.trim(DriverName)=='' && validate==0) {
        alertify.alert('Please enter Driver Name.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverName)  && validate==0) {
        alertify.alert('Please enter Driver Name in alphanumeric.');
        var validate=1;
    }

    var DriverImage = $('#DriverImage').val();
    if ($.trim(DriverImage)=='' && validate==0) {
        alertify.alert('Please upload Driver Image.');
        var validate=1;
    }

    var DriverEmail = $('#DriverEmail').val();
    if ($.trim(DriverEmail)!='' && validate==0) {
        if (!valid_emailid.test(DriverEmail)  && validate==0) {
            alertify.alert('Please enter valid Driver Email .');
            var validate=1;
        }
    }


    var DriverMobile = $('#DriverMobile').val();
    if ($.trim(DriverMobile)=='' && validate==0) {
        alertify.alert('Please enter Driver Mobile.');
        var validate=1;
    }
    if (!valid_mobile_numeric.test(DriverMobile)  && validate==0) {
        alertify.alert('Please enter valid Driver Mobile in 10 digit.');
        var validate=1;
    }

    var DriverAddress = $('#DriverAddress').val();
    if ($.trim(DriverAddress)=='' && validate==0) {
        alertify.alert('Please enter Driver Address.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverAddress)  && validate==0) {
        alertify.alert('Please enter valid Driver Address.');
        var validate=1;
    }

    var DriverPincode = $('#DriverPincode').val();
    if ($.trim(DriverPincode)!='' && validate==0) {
        if (!valid_phone_numeric.test(DriverPincode)  && validate==0) {
            alertify.alert('Please enter valid Driver Pincode in 6 digit.');
            var validate=1;
        }
    }

    var DriverLicenseImage = $('#DriverLicenseImage').val();
    if ($.trim(DriverLicenseImage)=='' && validate==0) {
        alertify.alert('Please upload Driver License Image.');
        var validate=1;
    }

    var DriverAadharImage = $('#DriverAadharImage').val();
    if ($.trim(DriverAadharImage)=='' && validate==0) {
        alertify.alert('Please upload Driver Aadhar Image.');
        var validate=1;
    }

    var DriverPoliceVerificationImage = $('#DriverPoliceVerificationImage').val();
    if ($.trim(DriverPoliceVerificationImage)=='' && validate==0) {
        alertify.alert('Please upload Driver Police Verification Image.');
        var validate=1;
    }

    var DriverCity = $('#DriverCity').val();
    if ($.trim(DriverCity)=='' && validate==0) {
        alertify.alert('Please enter Driver City.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverCity)  && validate==0) {
        alertify.alert('Please enter valid Driver City.');
        var validate=1;
    }

    var DriverState = $('#DriverState').val();
    if ($.trim(DriverState)=='' && validate==0) {
        alertify.alert('Please enter Driver State.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverState)  && validate==0) {
        alertify.alert('Please enter valid Driver State.');
        var validate=1;
    }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/superadmin/driver/driver_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/superadmin/driver/driver_add';
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
    $("#form_driver_update").on('submit', (function (e) {
    var validate=0;

    var DriverName = $('#DriverName').val();
    if ($.trim(DriverName)=='' && validate==0) {
        alertify.alert('Please enter Driver Name.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverName)  && validate==0) {
        alertify.alert('Please enter Driver Name in alphanumeric.');
        var validate=1;
    }

    var DriverEmail = $('#DriverEmail').val();
    if ($.trim(DriverEmail)!='' && validate==0) {
        if (!valid_emailid.test(DriverEmail)  && validate==0) {
            alertify.alert('Please enter valid Driver Email .');
            var validate=1;
        }
    }


    var DriverMobile = $('#DriverMobile').val();
    if ($.trim(DriverMobile)=='' && validate==0) {
        alertify.alert('Please enter Driver Mobile.');
        var validate=1;
    }
    if (!valid_mobile_numeric.test(DriverMobile)  && validate==0) {
        alertify.alert('Please enter valid Driver Mobile in 10 digit.');
        var validate=1;
    }

    var DriverAddress = $('#DriverAddress').val();
    if ($.trim(DriverAddress)=='' && validate==0) {
        alertify.alert('Please enter Driver Address.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverAddress)  && validate==0) {
        alertify.alert('Please enter valid Driver Address.');
        var validate=1;
    }

    var DriverPincode = $('#DriverPincode').val();
    if ($.trim(DriverPincode)!='' && validate==0) {
        if (!valid_phone_numeric.test(DriverPincode)  && validate==0) {
            alertify.alert('Please enter valid Driver Pincode in 6 digit.');
            var validate=1;
        }
    }

    var DriverCity = $('#DriverCity').val();
    if ($.trim(DriverCity)=='' && validate==0) {
        alertify.alert('Please enter Driver City.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverCity)  && validate==0) {
        alertify.alert('Please enter valid Driver City.');
        var validate=1;
    }

    var DriverState = $('#DriverState').val();
    if ($.trim(DriverState)=='' && validate==0) {
        alertify.alert('Please enter Driver State.');
        var validate=1;
    }
    if (!valid_alphanumeric.test(DriverState)  && validate==0) {
        alertify.alert('Please enter valid Driver State.');
        var validate=1;
    }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/superadmin/driver/driver_update', // Url to which the request is send
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
