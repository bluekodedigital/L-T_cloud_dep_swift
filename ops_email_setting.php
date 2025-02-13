<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
//$segment = $_SESSION['swift_dep'];
$generate_token= generate_token();
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
?>
<style>

    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->

    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">OPS Email Setting</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type" onchange="proj_type_Filter_email(this.value, '4')" required="">
                    <option value="-" <?php echo ($ptid == '-') ? 'selected' : ''; ?>>Both</option>
                    <option value="1" <?php $ptid == 1 ? 'selected' : ''; ?>>CO</option>
                    <option value="2" <?php $ptid == 2 ? 'selected' : ''; ?>>NCO</option>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center"  style="z-index:1;">                
                <select class="custom-select" style=" cursor: pointer;" name="sadminproj_Filter" id="sadminproj_Filter" onchange="sadminproj_Filter(this.value)" required="">
                    <option value="">--All Project--</option>
                    <?php
                    // $result = $cls_comm->select_allprojects();
                    $result = $cls_report->select_filterprojects_seg2($seg, $ptid);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">OPS Email Setting</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->


        <!-- basic table -->
        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">OPS & OM-Users  </h4>
                         <small> To Email Address</small>
                        <?php
                        $get_ops_users = $cls_admin->get_ops_users();
                        $ops_users = json_decode($get_ops_users, true);
                        foreach ($ops_users as $key => $value) {
                            $ops_id = $value['uid'];
                            $check_opssetting = $cls_admin->check_opssetting($ops_id, $pid);
                            if ($check_opssetting > 0) {
                                ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '0')"  id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                         <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $generate_token; ?>" />
                                        <input type="checkbox" class="custom-control-input" value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '0')"  id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php }
                            ?>                               


                        <?php }
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Project Manager</h6>
                         <small> CC Address</small>
                        <?php
                        $get_ops_users = $cls_admin->get_projmanger();
//                        $get_ops_users = $cls_admin->get_approvers();
                        $ops_users = json_decode($get_ops_users, true);
                        foreach ($ops_users as $key => $value) {
                            $ops_id = $value['uid'];
                            $check_opssetting_cc = $cls_admin->check_opssetting_cc($ops_id, $pid);
                            if ($check_opssetting_cc > 0) {
                                ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '1')" id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '1')" id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php }
                            ?> 

                        <?php }
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Project Users</h4>
                         <small> CC Address</small>
                        <?php
                        $get_ops_users = $cls_admin->get_projusers();
//                        $get_ops_users = $cls_admin->get_generalusers();
                        $ops_users = json_decode($get_ops_users, true);
                        foreach ($ops_users as $key => $value) {
                            $ops_id = $value['uid'];
                            $check_opssetting_cc = $cls_admin->check_opssetting_cc($ops_id, $pid);
                            if ($check_opssetting_cc > 0) {
                                ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" checked value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '1')" id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-check ">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" value="<?php echo $value['uid']; ?>" onclick="ops_setting(this.value, '1')" id="customCheck<?php echo $value['uid']; ?>">
                                        <label class="custom-control-label" for="customCheck<?php echo $value['uid']; ?>"><?php echo $value['uname']; ?></label>
                                    </div>
                                </div>
                            <?php }
                            ?> 
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>


        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>

    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php
    include_once('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
                                            function sadminproj_Filter(id) {
                                                var tid = $('#proj_type').val();
                                                window.location.href = "ops_email_setting?pid=" + id + "&ptid=" + tid;
                                            }
                                            function create_newproj() {
                                                $('#package_create').show()
                                            }
                                            function cancelpackage() {
                                                $('#package_create').hide()
                                            }

                                            function edit_smtp(id) {
                                                $.post("code/edit_smtp.php", {key: id}, function (data) {
//alert(data);
                                                    var smtp_email = JSON.parse(data).smtp_email;
                                                    var smtp_sendermail = JSON.parse(data).smtp_sendermail;
                                                    var smtp_password = JSON.parse(data).smtp_password;
                                                    var smtp_portno = JSON.parse(data).smtp_portno;
                                                    var smtp_status = JSON.parse(data).smtp_status;

                                                    $('#smptp_email_id').val(smtp_email);
                                                    $('#email_id').val(smtp_sendermail);
                                                    $('#password').val(smtp_password);
                                                    $('#port').val(smtp_portno);
                                                    $('#status').val(smtp_status);
                                                    $('#ma_id').val(id);
                                                    $('#smtp_update').show();
                                                    $('#smtp_create').hide();
                                                    $('#package_create').show();

                                                });
                                            }
                                            function  ops_setting(id, ty) {
                                                var csrf_token = $('#csrf_token').val();
                                                var projid = $('#sadminproj_Filter').val();
                                                if (projid == "") {
                                                    $('#customCheck' + id).prop('checked', false);
                                                    alert('Please Select Project & Prooced');
                                                } else {
                                                    if ($('#customCheck' + id).prop('checked') == true) {

                                                        $.post("code/save_ops_id.php", {key: id, projid: projid, ty: ty, csrf_token:csrf_token}, function (data) {
//                                                            alert(data);
                                                            if ($.trim(data) == "1") {
                                                                new PNotify({
                                                                    title: 'Email Setting',
                                                                    text: 'Saved Successfully',
                                                                    type: 'info',
                                                                    buttons: {
                                                                        closer: true,
                                                                        sticker: true
                                                                    }
                                                                });
                                                            } else {
                                                                new PNotify({
                                                                    title: 'Email Setting',
                                                                    text: 'Something Went Wrong',
                                                                    type: 'warning',
                                                                    buttons: {
                                                                        closer: true,
                                                                        sticker: true
                                                                    }
                                                                });
                                                            }
                                                        });
                                                    } else {
                                                        $.post("code/delete_ops_id.php", {key: id, projid: projid, ty: ty}, function (data) {
                                                            if ($.trim(data) == "1") {
                                                                new PNotify({
                                                                    title: 'Email Setting',
                                                                    text: 'Removed Successfully',
                                                                    type: 'warning',
                                                                    buttons: {
                                                                        closer: true,
                                                                        sticker: true
                                                                    }
                                                                });
                                                            } else {
                                                                new PNotify({
                                                                    title: 'Email Setting',
                                                                    text: 'Something Went Wrong',
                                                                    type: 'info',
                                                                    buttons: {
                                                                        closer: true,
                                                                        sticker: true
                                                                    }
                                                                });
                                                            }
                                                        });

                                                    }
                                                }
                                            }
</script>