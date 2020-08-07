
</div>


   <!-- Mainly scripts -->
    <script src="<?php echo base_url('assets/js/jquery-2.1.1.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js');?>"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url('assets/js/inspinia.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js');?>"></script>
    <!-- jQuery UI -->
    <script src="<?php echo base_url('assets/js/plugins/jquery-ui/jquery-ui.min.js');?>"></script>
    
    <!-- Jquery Validate -->
    <script src="<?php echo base_url('assets/js/plugins/validate/jquery.validate.min.js');?>"></script>
<!--     <?php /* 
    if(isset($js_custom)){
        foreach($js_custom as $js){?>
    <script src="<?php echo base_url($js);?>"></script>
    <?php } } */ ?> -->
    <?php if(isset($js_script)){?>
    <script src="<?php echo base_url('assets/js/pages/');?><?=$js_script?>.js"></script>
    <?php } ?>
   

        <!-- Chosen -->
    <script src="<?php echo base_url('assets/js/plugins/chosen/chosen.jquery.js');?>"></script>

   <!-- JSKnob -->
   <script src="<?php echo base_url('assets/js/plugins/jsKnob/jquery.knob.js');?>"></script>

   <!-- Input Mask-->
    <script src="<?php echo base_url('assets/js/plugins/jasny/jasny-bootstrap.min.js');?>"></script>

   <!-- Data picker -->
   <script src="<?php echo base_url('assets/js/plugins/datapicker/bootstrap-datepicker.js');?>"></script>

   <!-- NouSlider -->
   <script src="<?php echo base_url('assets/js/plugins/nouslider/jquery.nouislider.min.js');?>"></script>

   <!-- Switchery -->
   <script src="<?php echo base_url('assets/js/plugins/switchery/switchery.js');?>"></script>

    <!-- IonRangeSlider -->
    <script src="<?php echo base_url('assets/js/plugins/ionRangeSlider/ion.rangeSlider.min.js');?>"></script>

    <!-- iCheck -->
    <script src="<?php echo base_url('assets/js/plugins/iCheck/icheck.min.js');?>"></script>

    <!-- MENU -->
    <script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>

    <!-- Color picker -->
    <script src="<?php echo base_url('assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js');?>"></script>

    <!-- Clock picker -->
    <script src="<?php echo base_url('assets/js/plugins/clockpicker/clockpicker.js');?>"></script>

    <!-- Image cropper -->
    <script src="<?php echo base_url('assets/js/plugins/cropper/cropper.min.js');?>"></script>

    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo base_url('assets/js/plugins/fullcalendar/moment.min.js');?>"></script>

    <!-- Date range picker -->
    <script src="<?php echo base_url('assets/js/plugins/daterangepicker/daterangepicker.js');?>"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url('assets/js/plugins/select2/select2.full.min.js');?>"></script>

    <!-- TouchSpin -->
    <script src="<?php echo base_url('assets/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js');?>"></script>

    <!-- Tags Input -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js');?>"></script>

    <!-- Dual Listbox -->
    <script src="<?php echo base_url('assets/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js');?>"></script>
    
    <script src="<?php echo base_url('assets/js/plugins/dataTables/jquery.dataTables.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/dataTables/datatables.min.js');?>"></script>

    <script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.select.js');?>"></script>
    <!-- Alertify -->
    <script src="<?php echo base_url('assets/js/plugins/alertify/alertify.min.js');?>"></script>

    <script>
        $(document).ready(function(){

            $('.tagsinput').tagsinput({
                tagClass: 'label label-primary'
            });


  var loadFile = function(event,target) {
    var output = document.getElementById(target);
    output.src = URL.createObjectURL(event.target.files[0]);

  };


   $(document).ready(function() {

        $('.dataTables-example').DataTable({
                pageLength: 10,
                lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        $(document).ready(function() {
    $('#checkboxss').DataTable( {
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]]
    } );
} );

    
    if (window.File && window.FileList && window.FileReader) {
      $("#inputImage").on("change", function(e) {
        $(".pip").remove();
        var files = e.target.files,
        filesLength = files.length;
        for (var i = 0; i < filesLength; i++) {
          var f = files[i]
          var fileReader = new FileReader();
          fileReader.onload = (function(e) {
            var file = e.target;
            $("<div class=\"pip\">" +
              "<img style='width:100px;height:100px;float:left;padding:10px;' class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
              "" +
              "</div>").insertAfter("#img-preview");

            // $("<div class=\"pip col-md-3\">" +
            //   "<img style='width:100px;height:100px;float:left;' class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            //   "<br/><span class=\"remove btn-xs btn-danger\">Remove image</span>" +
            //   "</div>").insertAfter("#food_images");
            // $(".remove").click(function(){
            //   $(this).parent(".pip").remove();
            // });
          });
          fileReader.readAsDataURL(f);
        }
      });
    } else {
      alert("Your browser doesn't support to File API")
    }
  });

            $( '.mydatepicker' ).datepicker({
                        todayBtn: "linked",
                        keyboardNavigation: false,
                        forceParse: false,
                        calendarWeeks: false,
                        autoclose: true,
                        format: "dd-mm-yyyy"
                    
            });


            // $('.input-group .date').datepicker({
            //     todayBtn: "linked",
            //     keyboardNavigation: false,
            //     forceParse: false,
            //     calendarWeeks: false,
            //     autoclose: true,
            //     format: "dd-mm-yyyy"
            // });

            $('#data_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "dd/mm/yyyy"
            });

            $('#data_3 .input-group.date').datepicker({
                startView: 2,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            $('#data_4 .input-group.date').datepicker({
                minViewMode: 1,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true
            });

            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });

            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, { color: '#1AB394' });

            var elem_2 = document.querySelector('.js-switch_2');
            var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

            var elem_3 = document.querySelector('.js-switch_3');
            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });


            $('.clockpicker').clockpicker();

            $('input[name="daterange"]').daterangepicker();

            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange').daterangepicker({
                format: 'MM/DD/YYYY',
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: { days: 60 },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                drops: 'down',
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-primary',
                cancelClass: 'btn-default',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            }, function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });

            $(".select2_demo_1").select2();
            $(".select2_demo_2").select2();
            $(".select2_demo_3").select2({
                placeholder: "Select a state",
                allowClear: true
            });



        });

    </script>
</body>
</html>
