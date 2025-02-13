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
<script src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

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

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    function view_reports(pack_id,projid) {
        //alert(pack_id);
        $('#reports_content').html('<center><img src="images/loading.gif" alt="" style="width:40px;"/></center>');

        $.post("code/view_reports.php", {key: pack_id,projid:projid}, function (data) {
            //alert(data);
            $('#reports_content').html(data);
        });
    }
    function view_reports_version1(pack_id) {
        //alert(pack_id);
        $('#reports_content').html('<center><img src="images/loading.gif" alt="" style="width:40px;"/></center>');

        $.post("code/view_reports_version1.php", {key: pack_id}, function (data) {
            //alert(data);
            $('#reports_content').html(data);
        });
    }
 
    function view_reports_table(pack_id,projid) {
        //alert(pack_id);
        $('#reports_content').html('<center><img src="images/loading.gif" alt="" style="width:40px;"/></center>');
        $.post("code/view_reports_table_tl.php", {key: pack_id,projid:projid}, function (data) {
            //alert(data);
            $('#reports_content').html(data);
        });
    }
    function view_reports_table_version1(pack_id) {
        //alert(pack_id);
        $('#reports_content').html('<center><img src="images/loading.gif" alt="" style="width:40px;"/></center>');
        $.post("code/view_reports_table_version1.php", {key: pack_id}, function (data) {
            //alert(data);
            $('#reports_content').html(data);
        });
    }
    function view_quoteDetails(qid) {

        if (qid == "") {
            $('#exampleModal_vendetail').modal('show');
            $('#ven_details').html('<center><h2>For MD-CEO approved packages, details are not available !!!</h2></center>');
        } else {
            $.post("code/view_quoteDetails.php", {key: qid}, function (data) {
//         alert(data);
                $('#exampleModal_vendetail').modal('show');
                $('#ven_details').html(data);
            });
        }


    }
// function form_submit(id){
//    
//         document.querySelector('#'+id).addEventListener('submit', function(e) {
//      var form = this;
//      
//      e.preventDefault();
//      
//      swal({
//          title: "Are you sure?",
//          text: "You will not be able to recover this imaginary file!",
//          icon: "warning",
//          buttons: [
//            'No, cancel it!',
//            'Yes, I am sure!'
//          ],
//          dangerMode: true,
//        }).then(function(isConfirm) {
//          if (isConfirm) {
//            swal({
//              title: 'Shortlisted!',
//              text: 'Candidates are successfully shortlisted!',
//              icon: 'success'
//            }).then(function() {
//              form.submit();
//            });
//          } else {
//            swal("Cancelled", "Your imaginary file is safe :)", "error");
//          }
//        });
//    });
// }
    function JSalert() {
        bootbox.confirm('This is the default confirm!', function (result) {
            if (result) {

            }
        });
    }

    function validate(form) {

        // validation code here ...
        e.preventDefault();
        bootbox.confirm('This is the default confirm!', function (result) {
            if (result) {
                return true;
            } else {
                alert('Please correct the errors in the form!');
                return false;
            }

        });



//            return confirm('Do you really want to submit the form?');

//            return confirm('Do you really want to submit the form?');
    }
    function  validate_form(form, e, name) {
        e.preventDefault();
        $('#tooltipmodals').modal('show');

//        var check =return submitform(e);
//        alert(check);
//        if(check===true){
//            return true;
//        }else{
//             return false;
//        }
    }
    function submitform(e) {


    }
    function view_delay(pack_id) {
        //alert(pack_id);
        $.post("code/view_delays.php", {key: pack_id}, function (data) {
            //alert(data);
            $('#delaytable').html(data);
        });
    }

    function modal_close() {
        $('#checklistmodal').modal('hide');

    }

    $("#otp_cont").hide();

    function ValidateEmail(inputText) {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(inputText.match(mailformat)){
            return true
        }
        return false
    }
    var otp_count = 0;
  function send_otp(){
    $("#otp_cont").hide();
    $(".passError").html("");
    var uname = $("#c_uname").val();
    var old_uname = $("#old_uname").val();
    if(uname != undefined && uname != ''){
        if(ValidateEmail(uname)){
            bootbox.confirm({
                title:'Information !',
                message:'Confirm the Email ID before sending the OTP', 
                className:'customize', 
                buttons: {
                    confirm: {
                        label: 'Confirm'
                    },
                    cancel: {
                        label: 'Cancel'
                    }
                },
                callback:function  (result) {
                    if (result) {
                        $("#c_uname").attr('readonly', true);
                        $.post("code/send_otp2.php", {uname: uname, old_uname:old_uname}, function (data) {
                        //alert(data);
                        if ($.trim(data) === '0') {
                            $(".passError").html("Otp Not Sent");
                        } else {
                            $("#otp_cont").show();
                            $(".passError").html("Otp Sent Successfully");
                            otp_count++;
                            setTimeout(() => {
                                if(otp_count == 3){
                                    $("#send_otp").attr('disabled', true);
                                }
                                $(".passError").html("");
                            }, 1500);
                        }
                        });
                    }
                }
            });
        
            
        } else {
            $(".passError").html("Please Enter Valid New Username");
        }
        
    } else {
        $(".passError").html("Please Enter New Username");
    }
  }

  function change_uname(){
    //$("#otp_cont").hide();
    $(".passError").html("");
    var otp = $("#otp").val();
    var uname = $("#c_uname").val();
    var old_uname = $("#old_uname").val();
    if(otp != undefined && otp != ''){
        bootbox.confirm({
            title:'Information !',
            message:'This is Onetime Change Option - You can not Revert Back, Please Confirm', 
            className:'customize', 
            buttons: {
                confirm: {
                    label: 'Confirm'
                },
                cancel: {
                    label: 'Cancel'
                }
            },
            callback:function  (result) {
                if (result) {
                    $.post("code/change_uname.php", {otp: otp, uname: uname, old_uname:old_uname}, function (data) {
                        //alert(data);
                        if ($.trim(data) === '0') {
                            $(".passError").html("Invalid OTP Verification!");
                        } else {
                            //alert('Your Email id SuccessFully Changed');
                            bootbox.alert({
                                title:'Information !',
                                message:'Your Email id Successfully Changed', 
                                className:'customize',
                                callback:function  () {
                                    $(".passError").html("");
                                    document.location.href = "logout";
                                }
                            });
                        }
                    });
                }
            }
        });
        /* var confirm_box1 = confirm("This is Onetime Change Option - You can not Revert Back, Please Confirm   ?");
        if(confirm_box1){
            var confirm_box2 = confirm("By Changing this Email Id. you can't revert your Old Email Id. Are you sure to proceed ?");
            if(confirm_box2){
                
            }
        } */
        
    } else {
        $(".passError").html("Please Enter OTP.");
    }
  }

</script>
<script type="text/javascript">
    var IDLE_TIMEOUT = 10 * 60;  // 10 minutes of inactivity
    var _idleSecondsCounter = 0;
    document.onclick = function () {
        _idleSecondsCounter = 0;
        localStorage.setItem('sw_onclick-event', 'click' + Math.random());
    };
    document.onmousemove = function () {
        _idleSecondsCounter = 0;
        localStorage.setItem('sw_onmousemove-event', 'mousemove' + Math.random());
    };
    document.onkeypress = function () {
        _idleSecondsCounter = 0;
        localStorage.setItem('sw_onkeypress-event', 'keypress' + Math.random());
    };
    window.setInterval(CheckIdleTime, 1000);
    function CheckIdleTime() {
        _idleSecondsCounter++;
        var oPanel = document.getElementById("SecondsUntilExpire");
        if (oPanel)
            oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
        if (_idleSecondsCounter >= IDLE_TIMEOUT) {
            // destroy the session in logout.php 
            localStorage.setItem('sw_logout-event', 'logout' + Math.random());
            document.location.href = "logout.php";
        }
    }
    window.addEventListener('storage', function (event) {
        if (event.key == 'sw_logout-event') {            // ..
            document.location.href = "logout.php";
        }

    });
    window.addEventListener('storage', function (event) {
        if (event.key == 'sw_onclick-event') {
            _idleSecondsCounter = 0;
            console.log(_idleSecondsCounter);

        }

    });
//    
    window.addEventListener('storage', function (event) {
        if (event.key == 'sw_onmousemove-event') {            // ..
            _idleSecondsCounter = 0;

        }

    });
    window.addEventListener('storage', function (event) {
        if (event.key == 'sw_onkeypress-event') {            // ..
            _idleSecondsCounter = 0;
//           alert(_idleSecondsCounter);
        }

    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
                (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    

</script>

</html>