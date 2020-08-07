 
 $.post(SITE_URL+'/stockist/get_stockist_count', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalstockistcount').text(response.count);
        }else{
          $('#totalstockistcount').text('0');
        }
});


 $.post(SITE_URL+'/distributor/get_total_received_orders_amount', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalordersprice').text(response.totalamount);
        }else{
          $('#totalordersprice').text('0');
        }
});

