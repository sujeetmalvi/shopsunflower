
function set_shopsettings(task){
    var taskvalue = $('#'+task).val();
    debugger;
    $.post(SITE_URL + '/superadmin/dashboard/set_shopsettings', {
        task:task,taskvalue:taskvalue
    }, function (responsedata, status) {
        console.log(responsedata);
    }); 
}