 
 $.post(SITE_URL+'/retailer/get_retailer_count', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalretailercount').text(response.count);
        }else{
          $('#totalretailercount').text('0');
        }
});


 $.post(SITE_URL+'/stockist/get_total_received_orders_amount', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalordersprice').text(response.totalamount);
        }else{
          $('#totalordersprice').text('0');
        }
});

