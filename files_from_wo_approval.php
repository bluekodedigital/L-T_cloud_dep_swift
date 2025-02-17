<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');

if($_SESSION['milcom']==1)
{
 $seg='38';   
}else
{
  $seg="";  
}
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
                <h5 class="font-medium text-uppercase mb-0">WO Approval Update</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techspoc_proj_filter($seg);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="scm_dash">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PO Approval Update</li>
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
                                        <th>Received From</th>
                                        <th>EMR Number</th>
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
                                    $uid = $_SESSION['uid'];
                                    $utype = $_SESSION['usertype'];
                                   // $result = $cls_comm->select_smartsignoff1($pid, $uid, $utype,$seg);
                                    $result = $cls_comm->select_swiftwo_app($pid, $uid, $utype,$seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['pm_projid']);
                                        $packname = $cls_comm->package_name($value['pm_packid']);
                                        $sendername = $cls_comm->get_username($value['from_uid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $planned_date = $cls_comm->datechange(formatDate($value['planned_date'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['ps_actualdate'], 'Y-m-d'));
                                        $rdate = $cls_comm->datechange(formatDate($value['cs_created_date'], 'Y-m-d'));

                                        $getid = $value['pw_id'];

                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange(formatDate($except_date, 'Y-m-d'));
                                        } else {
                                            $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        }
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
                                                    <span class="point <?php echo $point ?>" ></span>
                                                </div><?php echo $packname ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-info font-12 text-white ml-1 recfrm"><?php echo $value['stage_name']; ?> <br> (<?php echo $rdate; ?>)</span></td>
                                            <td>
                                                <?php
                                                $check_emr = $cls_user->emr_check($value['pm_packid']);
                                                echo $check_emr;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($value['po_wo_status'] == 1) {
                                                    echo "PO Only";
                                                } elseif ($value['po_wo_status'] == 2) {
                                                    echo "WO Only";
                                                } else {
                                                    echo "PO + WO";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $planned_date; ?></td>
                                            <!--<td><?php // echo $actual_date;         ?></td>-->
                                            <td><?php // echo $except_date;        ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>"  class=" mydatepicker" id="dasexpected_date<?php echo $value['pm_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['pm_packid'] ?>', '<?php echo $value['ps_stageid'] ?>')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>  
                                                    </span>
                                                </div>


                                            </td>
                                            <td><?php echo $value['ps_remarks'] ?><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['ps_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label>    </td>
                                                       <!-- <td><span onclick="alert(<?php echo $value['pm_packid']; ?>)">dd</span></td> -->
                                            <td>
                                                <?php
                                                $em = $cls_user->emr_check($value['pm_packid']);
                                                if ($em == "") {
                                                    ?>
                                                    <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="swal('EMR Not Created Yet')" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span>

                                                <?php } else { ?>
                                                    <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getsid('<?php echo $getid; ?>', '<?php echo $projname; ?>', '<?php echo $value['pm_packid']; ?>', '<?php echo $value['ps_stageid'] ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span>

                                                <?php }
                                                ?>


                                            </td>
                                            <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
                                        </tr>
                                    <?php } ?>
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
                                    <div class="col-md-4">
                                        <center>Package Sent<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="ps_plandate">21-06-2019</span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="ps_actdate">21-06-2019</span>
                                        </center>

<!-- <small>Package send Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="ps_plandate">21-06-2019</span></small>
<small>Package send Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small> -->
                                    </div>
                                    <div class="col-md-4">
                                        <center>Package Approval<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="pa_plandate">21-06-2019</span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="pa_actdate">21-06-2019</span>
                                        </center>
                                        <!-- <small>Package Approval Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="pa_plandate">21-06-2019</span></small>
                                        <small>Package Approval Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small> -->
                                    </div>
                                    <div class="col-md-4">
                                        <center>LOI <br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="loi_plandate">21-06-2019</span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="loi_actdate">21-06-2019</span>
                                        </center>
                                        <!-- <small>LOI Planned <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="loi_plandate">21-06-2019</span></small><br>
                                        <small>LOI Actual <span class="badge badge-pill badge-info font-12 text-white ml-1">21-06-2019</span></small> -->
                                    </div>
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

            <div class="modal fade bs-example-modal-lg" id="model_view" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content" id="podetailvie" style="width:116%;margin-left:-8%;margin-top:-2%;">

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
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
                                                            $.post("functions/ss_getplandate.php", {key: pack_id}, function (data) {
                                                                var ps_plandate = JSON.parse(data).ps_plandate;
                                                                var pa_plandate = JSON.parse(data).pa_plandate;
                                                                var loi_plandate = JSON.parse(data).loi_plandate;
                                                                var ps_actdate = JSON.parse(data).ps_actdate;
                                                                var pa_actdate = JSON.parse(data).pa_actdate;
                                                                var loi_actdate = JSON.parse(data).loi_actdate;
                                                                var pack = JSON.parse(data).pack_name;
                                                                var mat_req = JSON.parse(data).mat_req;
                                                                $('#ps_plandate').html(ps_plandate);
                                                                $('#pa_plandate').html(pa_plandate);
                                                                $('#loi_plandate').html(loi_plandate);
                                                                $('#ps_actdate').html(ps_actdate);
                                                                $('#pa_actdate').html(pa_actdate);
                                                                $('#loi_actdate').html(loi_actdate);
                                                                $('#pack_name').html(pack);
                                                                $('#mat_req_date').html(mat_req);
                                                                // $("#po_planned").disabled = true;
                                                                // document.getElementById("wo_expected").disabled = true;
                                                                // document.getElementById("wo_planned").disabled = true;
                                                                // document.getElementById("po_expected").disabled = true;
                                                                // document.getElementById("po_expected1").disabled = true;
                                                                // document.getElementById("po_planned").disabled = true;
                                                            });
                                                            $.post("functions/po_wo_checking1.php", {key: pack_id, stageid: d}, function (data1) {
                                                               // console.log(data1);
                                                                $('#powo').html(data1);
                                                            });
                                                        }
                                                        function samedate($id) {
                                                            $("#exp_date").datepicker("setDate", $id);
                                                        }
                                                        function swift_proj(Proid) {
                                                            window.location.href = "files_from_smartsignoff?pid=" + Proid;
                                                        }
                                                        function podetailviewscm(pack_id) {
//    alert(pack_id);
                                                            $.post("code/podetailviewscmremove.php", {key: pack_id}, function (data) {
                                                                $('#podetailvie').html(data);
                                                            });
                                                        }
                                                        function remove_po(id, pack_id) {
                                                            var result = confirm('Are you sure want to delete this Item?');
                                                            if (result) {
                                                                $.post("code/remove_po.php", {key: id, packid: pack_id}, function (data) {
                                                                    if ($.trim(data) == 1) {
                                                                        alert('Item Removed');
                                                                        podetailviewscm(pack_id);

                                                                    } else {
                                                                        alert('Someting Went Wrong');
                                                                    }
                                                                });
                                                            }

                                                        }

</script>
