function get_citylist(StateId){
    $.post(SITE_URL + '/city/get_city_by_stateid', {
            StateId: StateId
        }, function (responsedata, status) {
            //var response = JSON.parse(responsedata);
            $('#CityId').html(responsedata);
        });

    // $.post(SITE_URL + '/distributor/get_distributor_by_stateid', {
    //         StateId: StateId
    //     }, function (responsedata, status) {
    //         //var response = JSON.parse(responsedata);
    //         $('#DistributorId').html(responsedata);
    //     });
}


// function get_stockist_by_distributor_id(DistributorId){

//        $.post(SITE_URL + '/stockist/get_stockist_by_distributor_id', {
//             DistributorId: DistributorId
//         }, function (responsedata, status) {
//             //var response = JSON.parse(responsedata);
//             $('#StockistId').html(responsedata);
//         });
// }


function get_stockist_by_city_id(CityId){

       $.post(SITE_URL + '/stockist/get_stockist_by_city_id', {
            CityId: CityId
        }, function (responsedata, status) {
            //var response = JSON.parse(responsedata);
            $('#StockistId').html(responsedata);
        });
}

$(document).ready(function (e) {
    $("#form_retailer_save").on('submit', (function (e) {
    var validate=0;

    var RetailerName = $('#RetailerName').val();
    if ($.trim(RetailerName)=='' && validate==0) {
    	$('#RetailerName').focus();
        alertify.alert('Please enter Retailer Name.');
        var validate=1;
    }
    if (!valid_alpha.test(RetailerName)  && validate==0) {
    	$('#RetailerName').focus();
        alertify.alert('Please enter Retailer Name in Words.');
        var validate=1;
    }

    
    var RetailerContactNo = $('#RetailerContactNo').val();
    if ($.trim(RetailerContactNo)=='' && validate==0) {
    	$('#RetailerContactNo').focus();
        alertify.alert('Please enter Retailer Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(RetailerContactNo)  && validate==0) {
    	$('#RetailerContactNo').focus();
        alertify.alert('Please enter Retailer Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var RetailerEmail = $('#RetailerEmail').val();
    if ($.trim(RetailerEmail)!='' && validate==0) {
        if (!valid_emailid.test(RetailerEmail)  && validate==0) {
	    	$('#RetailerEmail').focus();
	        alertify.alert('Please enter Retailer Email properly.');
	        var validate=1;
    	}
    }

    // var DistributorId = $('#DistributorId').val();
    // if ($.trim(DistributorId)=='' && validate==0) {
    // 	$('#DistributorId').focus();
    //     alertify.alert('Please enter Distributor ');
    //     var validate=1;
    // }


    var StockistId = $('#StockistId').val();
    if ($.trim(StockistId)=='' && validate==0) {
    	$('#StockistId').focus();
        alertify.alert('Please Select Stockist ');
        var validate=1;
    }

    // var CategoryId = $('#CategoryId').val();
    // if ($.trim(CategoryId)=='' && validate==0) {
    // 	$('#CategoryId').focus();
    //     alertify.alert('Please enter Category  ');
    //     var validate=1;
    // }

    
    // var HeadQtrId = $('#HeadQtrId').val();
    // if ($.trim(HeadQtrId)=='' && validate==0) {
    // 	$('#HeadQtrId').focus();
    //     alertify.alert('Please enter HeadQtr ');
    //     var validate=1;
    // }

    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Retailer Address');
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



    var ContactPerson = $('#ContactPerson').val();
    if ($.trim(ContactPerson)=='' && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Contact Person.');
        var validate=1;
    }
    if (!valid_alpha.test(ContactPerson)  && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Contact Person in Words.');
        var validate=1;
    }

    
    var ContactMobile = $('#ContactMobile').val();
    if ($.trim(ContactMobile)=='' && validate==0) {
    	$('#ContactMobile').focus();
        alertify.alert('Please enter Contact Mobile.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(ContactMobile)  && validate==0) {
    	$('#ContactMobile').focus();
        alertify.alert('Please enter Contact Mobile in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var ContactEmail = $('#ContactEmail').val();
    if ($.trim(ContactEmail)!='' && validate==0) {
        if (!valid_emailid.test(ContactEmail)  && validate==0) {
	    	$('#ContactEmail').focus();
	        alertify.alert('Please enter Contact Email properly.');
	        var validate=1;
    	}
    }

    var PanNo = $('#PanNo').val();
    if ($.trim(PanNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(PanNo)  && validate==0) {
	    	$('#PanNo').focus();
	        alertify.alert('Please enter Pan No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var TinNo = $('#TinNo').val();
    if ($.trim(TinNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TinNo)  && validate==0) {
	    	$('#TinNo').focus();
	        alertify.alert('Please enter Tin No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var DLNo = $('#DLNo').val();
    if ($.trim(DLNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(DLNo)  && validate==0) {
	    	$('#DLNo').focus();
	        alertify.alert('Please enter DL No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var LSTNo = $('#LSTNo').val();
    if ($.trim(LSTNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(LSTNo)  && validate==0) {
	    	$('#LSTNo').focus();
	        alertify.alert('Please enter LST No in words or numbers or both.');
	        var validate=1;
	    }
    }
     

    var CSTNo = $('#CSTNo').val();
    if ($.trim(CSTNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CSTNo)  && validate==0) {
	    	$('#CSTNo').focus();
	        alertify.alert('Please enter CSTNo in words or numbers or both.');
	        var validate=1;
	    }
    }

    var TANNo = $('#TANNo').val();
    if ($.trim(TANNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TANNo)  && validate==0) {
	    	$('#TANNo').focus();
	        alertify.alert('Please enter TAN No in words or numbers or both.');
	        var validate=1;
	    }
    }


    var CreditDays = $('#CreditDays').val();
    if ($.trim(CreditDays)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CreditDays)  && validate==0) {
	    	$('#CreditDays').focus();
	        alertify.alert('Please enter Credit Days in words or numbers or both.');
	        var validate=1;
	    }
    }

    var CreditLimit = $('#CreditLimit').val();
    if ($.trim(CreditLimit)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CreditLimit)  && validate==0) {
	    	$('#CreditLimit').focus();
	        alertify.alert('Please enter Credit Limit in words or numbers or both.');
	        var validate=1;
	    }
    }

    var Transporter = $('#Transporter').val();
    if ($.trim(Transporter)!='' && validate==0) {
	    if (!valid_alphanumeric.test(Transporter)  && validate==0) {
	    	$('#Transporter').focus();
	        alertify.alert('Please enter Transporter in words or numbers or both.');
	        var validate=1;
	    }
    }


    // var PartyCode = $('#PartyCode').val();
    // if ($.trim(PartyCode)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(PartyCode)  && validate==0) {
	   //  	$('#PartyCode').focus();
	   //      alertify.alert('Please enter Party Code in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }

    // var PartyGroup = $('#PartyGroup').val();
    // if ($.trim(PartyGroup)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(PartyGroup)  && validate==0) {
	   //  	$('#PartyGroup').focus();
	   //      alertify.alert('Please enter Party Group in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }

    // var UnderAcGroup = $('#UnderAcGroup').val();
    // if ($.trim(UnderAcGroup)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(UnderAcGroup)  && validate==0) {
	   //  	$('#UnderAcGroup').focus();
	   //      alertify.alert('Please enter Under A/c Group in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/retailer/retailer_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/retailer/retailer_list';
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
    $("#form_retailer_update").on('submit', (function (e) {
    var validate=0;

    var RetailerName = $('#RetailerName').val();
    if ($.trim(RetailerName)=='' && validate==0) {
    	$('#RetailerName').focus();
        alertify.alert('Please enter Retailer Name.');
        var validate=1;
    }
    if (!valid_alpha.test(RetailerName)  && validate==0) {
    	$('#RetailerName').focus();
        alertify.alert('Please enter Retailer Name in Words.');
        var validate=1;
    }

    
    var RetailerContactNo = $('#RetailerContactNo').val();
    if ($.trim(RetailerContactNo)=='' && validate==0) {
    	$('#RetailerContactNo').focus();
        alertify.alert('Please enter Retailer Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(RetailerContactNo)  && validate==0) {
    	$('#RetailerContactNo').focus();
        alertify.alert('Please enter Retailer Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var RetailerEmail = $('#RetailerEmail').val();
    if ($.trim(RetailerEmail)!='' && validate==0) {
        if (!valid_emailid.test(RetailerEmail)  && validate==0) {
	    	$('#RetailerEmail').focus();
	        alertify.alert('Please enter Retailer Email properly.');
	        var validate=1;
    	}
    }

    // var DistributorId = $('#DistributorId').val();
    // if ($.trim(DistributorId)=='' && validate==0) {
    // 	$('#DistributorId').focus();
    //     alertify.alert('Please enter Distributor ');
    //     var validate=1;
    // }


    var StockistId = $('#StockistId').val();
    if ($.trim(StockistId)=='' && validate==0) {
    	$('#StockistId').focus();
        alertify.alert('Please Select Stockist ');
        var validate=1;
    }

    // var CategoryId = $('#CategoryId').val();
    // if ($.trim(CategoryId)=='' && validate==0) {
    // 	$('#CategoryId').focus();
    //     alertify.alert('Please enter Category  ');
    //     var validate=1;
    // }

    
    // var HeadQtrId = $('#HeadQtrId').val();
    // if ($.trim(HeadQtrId)=='' && validate==0) {
    // 	$('#HeadQtrId').focus();
    //     alertify.alert('Please enter HeadQtr ');
    //     var validate=1;
    // }

    var Address = $('#Address').val();
    if ($.trim(Address)=='' && validate==0) {
    	$('#Address').focus();
        alertify.alert('Please enter Retailer Address');
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



    var ContactPerson = $('#ContactPerson').val();
    if ($.trim(ContactPerson)=='' && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Contact Person.');
        var validate=1;
    }
    if (!valid_alpha.test(ContactPerson)  && validate==0) {
    	$('#ContactPerson').focus();
        alertify.alert('Please enter Contact Person in Words.');
        var validate=1;
    }

    
    var ContactMobile = $('#ContactMobile').val();
    if ($.trim(ContactMobile)=='' && validate==0) {
    	$('#ContactMobile').focus();
        alertify.alert('Please enter Contact Mobile.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(ContactMobile)  && validate==0) {
    	$('#ContactMobile').focus();
        alertify.alert('Please enter Contact Mobile in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var ContactEmail = $('#ContactEmail').val();
    if ($.trim(ContactEmail)!='' && validate==0) {
        if (!valid_emailid.test(ContactEmail)  && validate==0) {
	    	$('#ContactEmail').focus();
	        alertify.alert('Please enter Contact Email properly.');
	        var validate=1;
    	}
    }

    var PanNo = $('#PanNo').val();
    if ($.trim(PanNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(PanNo)  && validate==0) {
	    	$('#PanNo').focus();
	        alertify.alert('Please enter Pan No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var TinNo = $('#TinNo').val();
    if ($.trim(TinNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TinNo)  && validate==0) {
	    	$('#TinNo').focus();
	        alertify.alert('Please enter Tin No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var DLNo = $('#DLNo').val();
    if ($.trim(DLNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(DLNo)  && validate==0) {
	    	$('#DLNo').focus();
	        alertify.alert('Please enter DL No in words or numbers or both.');
	        var validate=1;
	    }
    }

    var LSTNo = $('#LSTNo').val();
    if ($.trim(LSTNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(LSTNo)  && validate==0) {
	    	$('#LSTNo').focus();
	        alertify.alert('Please enter LST No in words or numbers or both.');
	        var validate=1;
	    }
    }
     

    var CSTNo = $('#CSTNo').val();
    if ($.trim(CSTNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CSTNo)  && validate==0) {
	    	$('#CSTNo').focus();
	        alertify.alert('Please enter CSTNo in words or numbers or both.');
	        var validate=1;
	    }
    }

    var TANNo = $('#TANNo').val();
    if ($.trim(TANNo)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TANNo)  && validate==0) {
	    	$('#TANNo').focus();
	        alertify.alert('Please enter TAN No in words or numbers or both.');
	        var validate=1;
	    }
    }


    var CreditDays = $('#CreditDays').val();
    if ($.trim(CreditDays)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CreditDays)  && validate==0) {
	    	$('#CreditDays').focus();
	        alertify.alert('Please enter Credit Days in words or numbers or both.');
	        var validate=1;
	    }
    }

    var CreditLimit = $('#CreditLimit').val();
    if ($.trim(CreditLimit)!='' && validate==0) {
	    if (!valid_alphanumeric.test(CreditLimit)  && validate==0) {
	    	$('#CreditLimit').focus();
	        alertify.alert('Please enter Credit Limit in words or numbers or both.');
	        var validate=1;
	    }
    }

    var Transporter = $('#Transporter').val();
    if ($.trim(Transporter)!='' && validate==0) {
	    if (!valid_alphanumeric.test(Transporter)  && validate==0) {
	    	$('#Transporter').focus();
	        alertify.alert('Please enter Transporter in words or numbers or both.');
	        var validate=1;
	    }
    }


    // var PartyCode = $('#PartyCode').val();
    // if ($.trim(PartyCode)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(PartyCode)  && validate==0) {
	   //  	$('#PartyCode').focus();
	   //      alertify.alert('Please enter Party Code in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }

    // var PartyGroup = $('#PartyGroup').val();
    // if ($.trim(PartyGroup)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(PartyGroup)  && validate==0) {
	   //  	$('#PartyGroup').focus();
	   //      alertify.alert('Please enter Party Group in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }

    // var UnderAcGroup = $('#UnderAcGroup').val();
    // if ($.trim(UnderAcGroup)!='' && validate==0) {
	   //  if (!valid_alphanumeric.test(UnderAcGroup)  && validate==0) {
	   //  	$('#UnderAcGroup').focus();
	   //      alertify.alert('Please enter Under A/c Group in words or numbers or both.');
	   //      var validate=1;
	   //  }
    // }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/retailer/retailer_update', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/retailer/retailer_list';
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
    $("#forgetpasswordform").on('submit', (function (e) {
    var validate=0;

 /*  
    var ContactEmail = $('#ContactEmail').val();
    if ($.trim(ContactEmail)!='' && validate==0) {
        if (!valid_emailid.test(ContactEmail)  && validate==0) {
	    	$('#ContactEmail').focus();
	        alertify.alert('Please enter Contact Email properly.');
	        var validate=1;
    	}
    }
*/
   

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/retailer/forget_password_email_check', // Url to which the request is send
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
                      if(response.status == 'success')
                      {
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          //window.location.href=SITE_URL+'/retailer/retailer_list';
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


function check_password()
{
	var password=$('#password').val();
	var newpassword=$('#newpassword').val();
	if( password == newpassword)
	{
		$('#spanerror').text('');
	}
	else
	{
		$('#spanerror').text('Password Mismatch');
	}
}

$(document).ready(function (e) {
    $("#resetpasswordform").on('submit', (function (e) {
    var validate=0;

if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/retailer/change_password', // Url to which the request is send
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
                      if(response.status == 'success')
                      {
                          //$('#submit').removeAttr('disabled');
                          alertify.alert(response.msg);
                          //window.location.href=SITE_URL+'/retailer/retailer_list';
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