<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
$uid= $_SESSION['uid'];
?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Files From smartsignoff</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techspoc_proj_filter();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="scm_dash">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Work Flow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>WO Creation</th>
                                        <th>Current Status</th>
                                        <th>PO / WO</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th>
                                        <!--<th>Stage Actual</th>-->
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_user->select_files_opswoentry($pid, $segment);
//                                    $result = $cls_comm->select_files_opswoentry($pid, $segment);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['so_proj_id']);
                                        $packname = $cls_comm->package_name($value['so_pack_id']);
                                        $sendername = $cls_comm->get_username($value['sc_senderuid']);
                                        $schedule_date = $cls_comm->datechange($value['schedule_date']);
                                        $mat_req = $cls_comm->datechange($value['mat_req_date']);
                                        $planned_date = $cls_comm->datechange($value['planned_date']);
                                        $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        $actual_date = $cls_comm->datechange($value['ps_actualdate']);
                                        $rdate = $cls_comm->datechange($value['so_package_approved_date']);
                                        $check_wo = $cls_user->get_loidetails($value['so_id']);
                                        $check_user = $cls_user->check_user($value['so_id'],$uid);
                                        $get_wocrdate = $cls_user->get_wodate($value['so_pack_id'],22);
                                        $getid = $value['so_id'];
                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange($except_date);
                                        } else {
                                            $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        }
                                        if ($check_wo['work_order'] == 1 && $check_user['sc_senderuid'] == $uid) {
                                            ?>
                                            <tr>
                                                <td><?php echo $projname ?></td>
                                                <?php
                                                if ($actual_date > $planned_date) {
                                                    $alert = "";
                                                    $point = "";
                                                } elseif ($actual_date < $planned_date) {
                                                    $alert = "greenotify";
                                                    $point = "greenpoint";
                                                } else {
                                                    $alert = "bluenotify";
                                                    $point = "bluepoint";
                                                }
                                                ?>
                                                <td>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit <?php echo $alert; ?>"></span>
                                                        <span class="point <?php echo $point ?>"></span>
                                                    </div><?php echo $packname ?>
                                                </td>
                                                <td><?php echo date('d-m-y',strtotime($get_wocrdate['ps_actualdate'])); ?></td>
                                                <td><span class="badge badge-pill badge-info font-12 text-white ml-1 recfrm"><?php
                                                        if ($value['ps_stageid'] != 22) {
                                                            echo 'WO Approval';
//                                                            echo 'WO Creation';
                                                        } else {
                                                            echo $value['stage_name'];
                                                        }
                                                        ?> <br> (<?php echo $rdate; ?>)</span></td>
                                                <td>
                                                    <?php
                                                    if ($value['so_hw_sw'] == 1) {
                                                        echo "WO Only";
                                                    } elseif ($value['so_hw_sw'] == 2) {
                                                        echo "PO Only";
                                                    } else {
                                                        echo "PO + WO";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $schedule_date; ?></td>
                                                <td><?php echo $mat_req; ?></td>
                                                <td><?php echo $planned_date; ?></td>
                                                <!--<td><?php // echo $actual_date;    
                                                    ?></td>-->
                                                <td><?php // echo $except_date;   
                                                    ?>
                                                    <div>
                                                        <div class="input-group" id="expdiv" style=" float: left;">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                                            </div>
                                                            <input type="text" value="<?php echo $except_date; ?>" class=" mydatepicker" id="dasexpected_date<?php echo $value['so_pack_id'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                        </div>
                                                        <div class=" saveexp" style=" float: right;">
                                                            <span class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['so_pack_id'] ?>', '<?php echo $value['ps_stageid'] ?>')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Save Expected date">
                                                                <i class="fas fa-save"></i>
                                                            </span>
                                                        </div>


                                                    </div>


                                                </td>
                                                <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip" data-placement="bottom" data-original-title="OPS Remarks" style=" cursor: pointer;" onclick="swal('<?php echo $value['ps_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label> </td>
                                                <!-- <td><span onclick="alert(<?php echo $value['so_pack_id']; ?>)">dd</span></td> -->
                                                <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getsid('<?php echo $getid; ?>', '<?php echo $projname; ?>', '<?php echo $value['so_pack_id']; ?>', '<?php echo $value['ps_stageid'] ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>
                                                <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width: 160%;margin-left: -110px;">
                        <div class="modal-header" style="padding-bottom: 3%;">
                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack_name">Package Name</small></h4>
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h5 id="pack"><small></small></h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <!-- <span class="badge badge-pill badge-primary font-12 text-white ml-1">Planned Date</span>   
                                    <span class="badge badge-pill badge-info font-12 text-white ml-1">Actual Date</span>                       -->
                                </div>
                                <div class=" col-md-6" id="ps">
                                    <small>ORG/REV Material Required:- <span class="badge badge-pill badge-warning font-12 text-white ml-1" id="mat_req_date"></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <!-- <form method="post" class="needs-validation" action="functions/move_spoc_to_expert.php" autocomplete="off">                             -->
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-md-4">
                                        <center>Package Sent<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="ps_plandate">21-06-2019</span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="ps_actdate">21-06-2019</span>
                                        </center>

                                        <small>Package send Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="ps_plandate">21-06-2019</span></small>
                                        <small>Package send Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small>
                                    </div>
                                    <div class="col-md-4">
                                        <center>Package Approval<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="pa_plandate">21-06-2019</span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="pa_actdate">21-06-2019</span>
                                        </center>
                                        <small>Package Approval Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="pa_plandate">21-06-2019</span></small>
                                        <small>Package Approval Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small>
                                    </div> -->
                                    <div class="col-md-6">
                                        <label for="loi_number">LOI Number : </label>

                                        <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="loi_number">dfa</span>
                                        <!-- <span class="badge badge-pill badge-info font-medium text-white ml-1" id="loi_actdate">21-06-2019</span> -->

    <!-- <small>LOI Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="loi_plandate">21-06-2019</span></small><br>
    <small>LOI Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small> -->
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label for="loi_actdate">LOI Date : </label>
                                      <!--<span class="badge badge-pill badge-primary font-medium text-white ml-1" id="loi_plandate">21-06-2019</span>-->
                                        <span class="badge badge-pill badge-info font-medium text-white ml-1" id="loi_actdate">21-06-2019</span>

    <!-- <small>LOI Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="loi_plandate">21-06-2019</span></small><br>
    <small>LOI Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small> -->
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="po_wo_app">PO/WO Applicable : </label>
                                        <span class="badge badge-pill badge-primary  font-12 text-white ml-1" id="po_wo_app" name="po_wo_app"> </span>
                                    </div>
                                    <div class="col-md-12 mb-6">
                                        <label for="actual_date">LOI Remarks : </label>
                                            <!-- <span class="badge badge-pill badge-primary  font-12 text-white ml-1" id="loi_remarks" name="loi_remarks"> </span> -->
                                        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ></span>   
                                        <span id="moreew" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer; display: none" ></span>
                                        <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
                                        <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>
                                    </div>
                                </div>
                                <br>
                                <div class=" row" id="uptable">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row" id="powo">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
                            <!-- <button type="submit" class="btn btn-outline-primary btn-rounded" name="approve_package" id="submitbtn" ><i class="fas fa-paper-plane"></i>  Send</button> -->
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </div>
    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>



<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script src="code/js/technical.js" type="text/javascript"></script>
<script>
                                            function getsid(a, b, c, d) {

                                                var sid = a;
                                                var project = b;
                                                var pack_id = c;
                                                $("#proj").text(project);
                                                $.post("functions/ss_getplandate.php", {
                                                    key: pack_id
                                                }, function (data) {
                                                    var ps_plandate = JSON.parse(data).ps_plandate;
                                                    var pa_plandate = JSON.parse(data).pa_plandate;
                                                    var loi_plandate = JSON.parse(data).loi_plandate;
                                                    var ps_actdate = JSON.parse(data).ps_actdate;
                                                    var pa_actdate = JSON.parse(data).pa_actdate;
                                                    var loi_actdate = JSON.parse(data).loi_actdate;
                                                    var pack = JSON.parse(data).pack_name;
                                                    var mat_req = JSON.parse(data).mat_req;
                                                    var loi_number = JSON.parse(data).loi_number;
                                                    var loi_remarks = JSON.parse(data).loi_remarks;

                                                    var half_remarks = loi_remarks.substring(0, 60);
                                                    var po_wo_app = JSON.parse(data).po_wo_app;
                                                    $('#ps_plandate').html(ps_plandate);
                                                    $('#pa_plandate').html(pa_plandate);
                                                    $('#loi_plandate').html(loi_plandate);
                                                    $('#ps_actdate').html(ps_actdate);
                                                    $('#pa_actdate').html(pa_actdate);
                                                    $('#loi_actdate').html(loi_actdate);
                                                    $('#pack_name').html(pack);
                                                    $('#mat_req_date').html(mat_req);
                                                    $('#loi_number').text(loi_number);
                                                    $('#less').text(half_remarks);
                                                    $('#moreew').text(loi_remarks);
                                                    $('#po_wo_app').text(po_wo_app);
                                                    $("#po_planned").disabled = true;
                                                    document.getElementById("wo_expected").disabled = true;
                                                    document.getElementById("wo_planned").disabled = true;
                                                    document.getElementById("po_expected").disabled = true;
                                                    document.getElementById("po_expected1").disabled = true;
                                                    document.getElementById("po_planned").disabled = true;
                                                });
                                                $.post("functions/po_wo_checking_1.php", {
                                                    key: pack_id,
                                                    stageid: d
                                                }, function (data) {
                                                    $('#powo').html(data);
                                                });
                                                fetch_loi_uploaddocument_view('', pack_id);
//                                                  fetch_loi_uploaddocument_view(b, pack_id);
                                            }

                                            function fetch_loi_uploaddocument_view(proj_id, pack_id) {
                                                // alert(proj_id);
                                                $('#uptable').html('<center><img src="images/loading.gif" alt=""/></center>');
                                                $.post("code/fetch_loi_uploaddocument_view.php", {
                                                    key: pack_id,
                                                    proj_id: proj_id
                                                }, function (data) {
                                                    // alert(data);
                                                    $('#uptable').html(data);

                                                });
                                            }

                                            function samedate($id) {
                                                $("#exp_date").datepicker("setDate", $id);
                                            }

                                            function swift_proj(Proid) {
                                                window.location.href = "files_for_ops_wo_entry?pid=" + Proid;
                                            }
</script>