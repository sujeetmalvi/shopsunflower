function get_citylist(StateId){
    $.post(SITE_URL + '/city/get_city_by_stateid', {
            StateId: StateId
        }, function (responsedata, status) {
            //var response = JSON.parse(responsedata);
            $('#CityId').html(responsedata);
        });


}




$(document).ready(function (e) {
    $("#form_distributor_save").on('submit', (function (e) {
    var validate=0;

    var DistributorName = $('#DistributorName').val();
    if ($.trim(DistributorName)=='' && validate==0) {
    	$('#DistributorName').focus();
        alertify.alert('Please enter Distributor Name.');
        var validate=1;
    }
    if (!valid_alpha.test(DistributorName)  && validate==0) {
    	$('#DistributorName').focus();
        alertify.alert('Please enter Distributor Name in Words.');
        var validate=1;
    }

    var AssociationType = $('#AssociationType').val();
    if ($.trim(AssociationType)=='' && validate==0) {
    	$('#AssociationType').focus();
        alertify.alert('Please enter Association Type.');
        var validate=1;
    }
    if (!valid_alpha.test(AssociationType)  && validate==0) {
    	$('#AssociationType').focus();
        alertify.alert('Please enter Association Type in Words.');
        var validate=1;
    }
    
    var DistributorContactNo = $('#DistributorContactNo').val();
    if ($.trim(DistributorContactNo)=='' && validate==0) {
    	$('#DistributorContactNo').focus();
        alertify.alert('Please enter Distributor Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(DistributorContactNo)  && validate==0) {
    	$('#DistributorContactNo').focus();
        alertify.alert('Please enter Distributor Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var DistributorEmail = $('#DistributorEmail').val();
    if ($.trim(DistributorEmail)!='' && validate==0) {
        if (!valid_emailid.test(DistributorEmail)  && validate==0) {
	    	$('#DistributorEmail').focus();
	        alertify.alert('Please enter Distributor Email properly.');
	        var validate=1;
    	}
    }


    var DistributorAddress = $('#DistributorAddress').val();
    if ($.trim(DistributorAddress)=='' && validate==0) {
    	$('#DistributorAddress').focus();
        alertify.alert('Please enter Distributor Address');
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

    var TotalMargins = $('#TotalMargins').val();
    if ($.trim(TotalMargins)!='' && validate==0) {
	    if (!valid_amount_numeric.test(TotalMargins)  && validate==0) {
	    	$('#TotalMargins').focus();
	        alertify.alert('Please enter Total Margins in words or numbers or both.');
	        var validate=1;
	    }
    }

    var DSAMargins = $('#DSAMargins').val();
    if ($.trim(DSAMargins)!='' && validate==0) {
	    if (!valid_amount_numeric.test(DSAMargins)  && validate==0) {
	    	$('#DSAMargins').focus();
	        alertify.alert('Please enter DSA Margins in words or numbers or both.');
	        var validate=1;
	    }
    }

    var OutgoingFreight = $('#OutgoingFreight').val();
    if ($.trim(OutgoingFreight)!='' && validate==0) {
	    if (!valid_amount_numeric.test(OutgoingFreight)  && validate==0) {
	    	$('#OutgoingFreight').focus();
	        alertify.alert('Please enter Outgoing Freight in words or numbers or both.');
	        var validate=1;
	    }
    }

    var StockiestIncentives = $('#StockiestIncentives').val();
    if ($.trim(StockiestIncentives)!='' && validate==0) {
	    if (!valid_amount_numeric.test(StockiestIncentives)  && validate==0) {
	    	$('#StockiestIncentives').focus();
	        alertify.alert('Please enter Stockiest Incentives in words or numbers or both.');
	        var validate=1;
	    }
    }
     

    var FieldStaffSalary = $('#FieldStaffSalary').val();
    if ($.trim(FieldStaffSalary)!='' && validate==0) {
	    if (!valid_amount_numeric.test(FieldStaffSalary)  && validate==0) {
	    	$('#FieldStaffSalary').focus();
	        alertify.alert('Please enter Field Staff Salary in words or numbers or both.');
	        var validate=1;
	    }
    }

    var FieldStaffExpenses = $('#FieldStaffExpenses').val();
    if ($.trim(FieldStaffExpenses)!='' && validate==0) {
	    if (!valid_amount_numeric.test(FieldStaffExpenses)  && validate==0) {
	    	$('#FieldStaffExpenses').focus();
	        alertify.alert('Please enter Field Staff Expenses in words or numbers or both.');
	        var validate=1;
	    }
    }


    var FieldStaffIncentives = $('#FieldStaffIncentives').val();
    if ($.trim(FieldStaffIncentives)!='' && validate==0) {
	    if (!valid_alphanumeric.test(FieldStaffIncentives)  && validate==0) {
	    	$('#FieldStaffIncentives').focus();
	        alertify.alert('Please enter Field Staff Incentives in words or numbers or both.');
	        var validate=1;
	    }
    }

    var FieldStaffPayrol = $('#FieldStaffPayrol').val();
    if ($.trim(FieldStaffPayrol)!='' && validate==0) {
	    if (!valid_alphanumeric.test(FieldStaffPayrol)  && validate==0) {
	    	$('#FieldStaffPayrol').focus();
	        alertify.alert('Please enter Field Staff Payrol in words or numbers or both.');
	        var validate=1;
	    }
    }

    var PaymentMode = $('#PaymentMode').val();
    if ($.trim(PaymentMode)!='' && validate==0) {
	    if (!valid_alphanumeric.test(PaymentMode)  && validate==0) {
	    	$('#PaymentMode').focus();
	        alertify.alert('Please enter Payment Mode in words or numbers or both.');
	        var validate=1;
	    }
    }


    var TotalSalesPerson = $('#TotalSalesPerson').val();
    if ($.trim(TotalSalesPerson)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TotalSalesPerson)  && validate==0) {
	    	$('#TotalSalesPerson').focus();
	        alertify.alert('Please enter Total Sales Person in words or numbers or both.');
	        var validate=1;
	    }
    }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/distributor/distributor_save', // Url to which the request is send
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
                          window.location.href=SITE_URL+'/distributor/distributor_add';
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
    $("#form_distributor_update").on('submit', (function (e) {
    var validate=0;
   var DistributorName = $('#DistributorName').val();
    if ($.trim(DistributorName)=='' && validate==0) {
    	$('#DistributorName').focus();
        alertify.alert('Please enter Distributor Name.');
        var validate=1;
    }
    if (!valid_alpha.test(DistributorName)  && validate==0) {
    	$('#DistributorName').focus();
        alertify.alert('Please enter Distributor Name in Words.');
        var validate=1;
    }

    var AssociationType = $('#AssociationType').val();
    if ($.trim(AssociationType)=='' && validate==0) {
    	$('#AssociationType').focus();
        alertify.alert('Please enter Association Type.');
        var validate=1;
    }
    if (!valid_alpha.test(AssociationType)  && validate==0) {
    	$('#AssociationType').focus();
        alertify.alert('Please enter Association Type in Words.');
        var validate=1;
    }
    
    var DistributorContactNo = $('#DistributorContactNo').val();
    if ($.trim(DistributorContactNo)=='' && validate==0) {
    	$('#DistributorContactNo').focus();
        alertify.alert('Please enter Distributor Contact No.');
        var validate=1;
    }
    if (!valid_phone_numeric.test(DistributorContactNo)  && validate==0) {
    	$('#DistributorContactNo').focus();
        alertify.alert('Please enter Distributor Contact No in Numbers between 6 to 10 digit.');
        var validate=1;
    }    

    var DistributorEmail = $('#DistributorEmail').val();
    if ($.trim(DistributorEmail)!='' && validate==0) {
        if (!valid_emailid.test(DistributorEmail)  && validate==0) {
	    	$('#DistributorEmail').focus();
	        alertify.alert('Please enter Distributor Email properly.');
	        var validate=1;
    	}
    }


    var DistributorAddress = $('#DistributorAddress').val();
    if ($.trim(DistributorAddress)=='' && validate==0) {
    	$('#DistributorAddress').focus();
        alertify.alert('Please enter Distributor Address');
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

    var TotalMargins = $('#TotalMargins').val();
    if ($.trim(TotalMargins)!='' && validate==0) {
	    if (!valid_amount_numeric.test(TotalMargins)  && validate==0) {
	    	$('#TotalMargins').focus();
	        alertify.alert('Please enter Total Margins in words or numbers or both.');
	        var validate=1;
	    }
    }

    var DSAMargins = $('#DSAMargins').val();
    if ($.trim(DSAMargins)!='' && validate==0) {
	    if (!valid_amount_numeric.test(DSAMargins)  && validate==0) {
	    	$('#DSAMargins').focus();
	        alertify.alert('Please enter DSA Margins in words or numbers or both.');
	        var validate=1;
	    }
    }

    var OutgoingFreight = $('#OutgoingFreight').val();
    if ($.trim(OutgoingFreight)!='' && validate==0) {
	    if (!valid_amount_numeric.test(OutgoingFreight)  && validate==0) {
	    	$('#OutgoingFreight').focus();
	        alertify.alert('Please enter Outgoing Freight in words or numbers or both.');
	        var validate=1;
	    }
    }

    var StockiestIncentives = $('#StockiestIncentives').val();
    if ($.trim(StockiestIncentives)!='' && validate==0) {
	    if (!valid_amount_numeric.test(StockiestIncentives)  && validate==0) {
	    	$('#StockiestIncentives').focus();
	        alertify.alert('Please enter Stockiest Incentives in words or numbers or both.');
	        var validate=1;
	    }
    }
     

    var FieldStaffSalary = $('#FieldStaffSalary').val();
    if ($.trim(FieldStaffSalary)!='' && validate==0) {
	    if (!valid_amount_numeric.test(FieldStaffSalary)  && validate==0) {
	    	$('#FieldStaffSalary').focus();
	        alertify.alert('Please enter Field Staff Salary in words or numbers or both.');
	        var validate=1;
	    }
    }

    var FieldStaffExpenses = $('#FieldStaffExpenses').val();
    if ($.trim(FieldStaffExpenses)!='' && validate==0) {
	    if (!valid_amount_numeric.test(FieldStaffExpenses)  && validate==0) {
	    	$('#FieldStaffExpenses').focus();
	        alertify.alert('Please enter Field Staff Expenses in words or numbers or both.');
	        var validate=1;
	    }
    }


    var FieldStaffIncentives = $('#FieldStaffIncentives').val();
    if ($.trim(FieldStaffIncentives)!='' && validate==0) {
	    if (!valid_alphanumeric.test(FieldStaffIncentives)  && validate==0) {
	    	$('#FieldStaffIncentives').focus();
	        alertify.alert('Please enter Field Staff Incentives in words or numbers or both.');
	        var validate=1;
	    }
    }

    var FieldStaffPayrol = $('#FieldStaffPayrol').val();
    if ($.trim(FieldStaffPayrol)!='' && validate==0) {
	    if (!valid_alphanumeric.test(FieldStaffPayrol)  && validate==0) {
	    	$('#FieldStaffPayrol').focus();
	        alertify.alert('Please enter Field Staff Payrol in words or numbers or both.');
	        var validate=1;
	    }
    }

    var PaymentMode = $('#PaymentMode').val();
    if ($.trim(PaymentMode)!='' && validate==0) {
	    if (!valid_alphanumeric.test(PaymentMode)  && validate==0) {
	    	$('#PaymentMode').focus();
	        alertify.alert('Please enter Payment Mode in words or numbers or both.');
	        var validate=1;
	    }
    }


    var TotalSalesPerson = $('#TotalSalesPerson').val();
    if ($.trim(TotalSalesPerson)!='' && validate==0) {
	    if (!valid_alphanumeric.test(TotalSalesPerson)  && validate==0) {
	    	$('#TotalSalesPerson').focus();
	        alertify.alert('Please enter Total Sales Person in words or numbers or both.');
	        var validate=1;
	    }
    }


if(validate==0){
    $('#submit').attr('disabled','disabled');
    e.preventDefault();
    $.ajax({
            url: SITE_URL+'/distributor/distributor_update', // Url to which the request is send
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
