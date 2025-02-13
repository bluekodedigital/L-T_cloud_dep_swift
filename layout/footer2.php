<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<script src="dist/js/app.min.js"></script>
<script src="dist/js/app.init.mini-sidebar.js"></script>
<script src="dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<script src="dist/js/swift.js"></script>
<!-- This Page JS -->
<script src="assets/libs/chartist/dist/chartist.min.js"></script>
<script src="dist/js/pages/chartist/chartist-plugin-tooltip.js"></script>

<!-- This Page JS -->
<script src="assets/libs/flot/jquery.flot.js"></script>
<script src="assets/libs/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js"></script>

<script src="assets/extra-libs/c3/d3.min.js"></script>
<script src="assets/extra-libs/c3/c3.min.js"></script>
<script src="assets/libs/raphael/raphael.min.js"></script>
<script src="assets/libs/morris.js/morris.min.js"></script>
<script src="dist/js/pages/dashboards/dashboard1.js"></script>
<script src="assets/libs/moment/min/moment.min.js"></script>
<script src="assets/libs/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="dist/js/pages/calendar/cal-init.js"></script>

<!-- p notify -->
<script src="vendors/pnotify/dist/pnotify.js"></script>
<script src="vendors/pnotify/dist/pnotify.buttons.js"></script>
<script src="vendors/pnotify/dist/pnotify.nonblock.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- This datepicker JS -->
<script src="assets/libs/moment/moment.js"></script>
<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- data table plugins -->
<script src="assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script src="dist/js/pages/datatable/datatable-basic.init.js"></script>
<script src="dist/js/pages/datatable/datatable-advanced.init.js" type="text/javascript"></script>
<script src="bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="bootbox/bootbox.js" type="text/javascript"></script>

<!-- Animated skill bar -->
<script src=" assets/extra-libs/AnimatedSkillsDiagram/js/animated-bar.js"></script>
<script src=" assets/libs/gaugeJS/dist/gauge.min.js"></script>
<script src="dist/js/pages/dashboards/dashboard2.js"></script>

<!-- Jquery Smart Wizards-->
<script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

<script src="assets/pnotify/dist/pnotify.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.buttons.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.nonblock.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.tooltip.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.animate.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.callbacks.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.confirm.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.desktop.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.history.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.tooltip.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.mobile.js" type="text/javascript"></script>
<script src="assets/pnotify/dist/pnotify.reference.js" type="text/javascript"></script>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script>
    $('#calendar').fullCalendar('option', 'height', 650);

</script>
<script>
    // Date Picker
    var date = new Date();
    date.setDate(date.getDate());
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',

    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range,#date-range1').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
</script>



</html>