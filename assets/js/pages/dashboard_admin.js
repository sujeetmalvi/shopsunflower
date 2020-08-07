 var type = 'company';
 var prod_result = '';
 $.post(SITE_URL+'/product/get_top_performing_products', {  }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          var j=1;
          $.each( response.data, function( i, res ) {
            prod_result+='<tr>';
            prod_result+='<td class="text-center">'+j+'</td>';
            prod_result+='<td>('+res.prod_count+') '+res.ProductName+'</td>';
            prod_result+='<td class="text-center">';
            prod_result+='<span class="label label-primary">'+res.amount+'</span>';
            prod_result+='</td>';
            prod_result+='</tr>';
            j++;
          });

          $('#topperfomingproducts').html(prod_result);
        }else{
          $('#topperfomingproducts').html('');
        }
});

var dist_result='';
 $.post(SITE_URL+'/distributor/get_top_performing_distributors', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          var j=1;
          $.each( response.data, function( i, res ) {
            dist_result+='<tr>';
            dist_result+='<td class="text-center">'+j+'</td>';
            dist_result+='<td>'+res.DistributorName+'<br>('+res.StateName+')</td>';
            dist_result+='<td class="text-center">';
            dist_result+='<span class="label label-primary">'+res.amount+'</span>';
            dist_result+='</td>';
            dist_result+='</tr>';
            j++;
          });

          $('#topperfomingdistributor').html(dist_result);
        }else{
          $('#topperfomingdistributor').html('');
        }
});


var stock_result='';
 $.post(SITE_URL+'/stockist/get_top_performing_stockist', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          var j=1;
          $.each( response.data, function( i, res ) {
            stock_result+='<tr>';
            stock_result+='<td class="text-center">'+j+'</td>';
            stock_result+='<td>'+res.StockistName+'<br>('+res.CityName+')</td>';
            stock_result+='<td class="text-center">';
            stock_result+='<span class="label label-primary">'+res.amount+'</span>';
            stock_result+='</td>';
            stock_result+='</tr>';
            j++;
          });

          $('#topperfomingstockist').html(stock_result);
        }else{
          $('#topperfomingstockist').html('');
        }
});



var retail_result='';
 $.post(SITE_URL+'/retailer/get_top_performing_retailer', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          var j=1;
          $.each( response.data, function( i, res ) {
            retail_result+='<tr>';
            retail_result+='<td class="text-center">'+j+'</td>';
            retail_result+='<td>'+res.RetailerName+'<br>('+res.CityName+')</td>';
            retail_result+='<td class="text-center">';
            retail_result+='<span class="label label-primary">'+res.amount+'</span>';
            retail_result+='</td>';
            retail_result+='</tr>';
            j++;
          });

          $('#topperfomingretailer').html(retail_result);
        }else{
          $('#topperfomingretailer').html('');
        }
});




 $.post(SITE_URL+'/retailer/get_total_retailers', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalretailers').html(response.data);
        }else{
          $('#totalretailers').html('0');
        }
});



 $.post(SITE_URL+'/retailer/get_retailers_total_sale_value', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#retailerstotalsale').html(response.data);
        }else{
          $('#retailerstotalsale').html('0');
        }
});


 $.post(SITE_URL+'/retailer/get_retailers_total_orders_count', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#retailersorderscount').html(response.data);
        }else{
          $('#retailersorderscount').html('0');
        }
});

 $.post(SITE_URL+'/retailer/get_total_new_customers', { }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#totalnewcustomers').html(response.data);
        }else{
          $('#totalnewcustomers').html('0');
        }
});


// var total_sale_result='';
//  $.post(SITE_URL+'/retailer/get_total_sale_value', { }, function (responsedata, status) {
//         var response = JSON.parse(responsedata);
//         if(response.status=='1'){
         
//             total_sale_result+='<tr>';
//             total_sale_result+='<td class="text-center">'+j+'</td>';
//             total_sale_result+='<td>'+res.RetailerName+'</td>';
//             retail_result+='<td class="text-center">';
//             retail_result+='<span class="label label-primary">'+res.amount+'</span>';
//             retail_result+='</td>';
//             retail_result+='</tr>';


//           $('#topperfomingretailer').html(retail_result);
//         }else{
//           $('#topperfomingretailer').html('');
//         }
// });

function showorderslist(type){
   $.post(SITE_URL+'/superadmin/dashboard/get_orders_list', { UserRole:type }, function (responsedata, status) {
        var response = JSON.parse(responsedata);
        if(response.status=='1'){
          $('#orderdetails').html(response.data);
        }else{
          $('#orderdetails').html('');
        }
        $('#OrderModal').modal('show');
  });
}

  

