<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
if ($_SESSION['milcom'] == '1') {
    $segment = '38';
} else {
    $segment = $_SESSION['tech_seg'];
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
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
                <h5 class="font-medium text-uppercase mb-0">SPOC WorkFlow</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if ($_SESSION['milcom'] == '1') {
                        $seg = "38";
                    } else {
                        $seg = "";
                    }
                    $result = $cls_comm->techspoc_proj_filter($seg);
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
                        <li class="breadcrumb-item"><a href="swift_workflow_approval">Home</a></li>
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
                            <table id="zero_config" style=" white-space: nowrap !important;     " class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <th style="padding-right: 13px !important;">Received From</th>
                                        <th style="padding-right: 13px !important;">ORG Schedule</th>
                                        <th style="padding-right: 13px !important;">Material Req</th>
                                        <th style="padding-right: 13px !important;">Stage Planned</th>
                                        <th style="padding-right: 13px !important;">Stage Expected</th>
                                        <!--                                        <th>Stage Actual</th>                                      -->
                                        <th style="padding-right: 13px !important;">Remarks</th>
                                        <th style="padding-right: 13px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = $cls_comm->select_techspoc_workflow($pid, $segment);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['cs_projid']);
                                        $packname = $cls_comm->package_name($value['cs_packid']);
                                        $sendername = $cls_comm->get_username($value['from_uid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['cs_actualdate'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                        $rdate     = $cls_comm->datechange(formatDate($value['cs_sentdate'], 'Y-m-d'));
                                        $getid     = $value['cs_packid'];
                                        $stageid   = $value['to_stage_id'];
                                        $pm_stages = $value['pm_stages'];
                                       
                                        $stage_array = explode(",",$pm_stages); 

                                        $key = array_search ($stageid, $stage_array);
                                        $Next_stage = $stage_array[$key+1];
                                        //$i = array_search('3', array_keys($array));
                                        // $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
                                        // echo $key = array_search('green', $stage_array); // $key = 2;
                                        // $key = array_search('red', $stage_array);   // $key = 1;
                                    //     $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
                                    //     $array1 = array(0 => '1', 1 => '2', 2 => '3', 3 => '5',4 => '6',5 => '7');
                                    //   // echo  $key = array_search('green', $array); // $key = 2;
                                    //  // print_r($array1);echo "<br>";
                                    //    $key = array_search('3', $array1);   // $key = 1;
                                    //     echo   $nkey = $key+1;
                                    //     $key2 = array_search($nkey, $array1);   // $key = 1;
                                      
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
                                            //                                            if (strtotime($actual_date) > strtotime($planned_date)) {
                                            //                                                $alert = "";
                                            //                                                $point = "";
                                            //                                            } elseif (strtotime($actual_date) < strtotime($planned_date)) {
                                            //                                                $alert = "greenotify";
                                            //                                                $point = "greenpoint";
                                            //                                            } else {
                                            //                                                $alert = "bluenotify";
                                            //                                                $point = "bluepoint";
                                            //                                            }
                                            ?>
                                            <td>
                                                <?php if (strtotime($rev_planned_date) > strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify"></span>
                                                        <span class="point greenpoint"></span>
                                                    </div>

                                                <?php } elseif (strtotime($rev_planned_date) < strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point"></span>
                                                    </div>
                                                <?php } elseif (strtotime($rev_planned_date) == strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint"></span>
                                                    </div>
                                                    <?php }
                                                    ?><?php echo $packname; ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">Ops-<?php echo $sendername ?> <br> (<?php echo $rdate; ?>)</span></td>
                                            <!-- <td><?php echo $cls_comm->datechange(formatDate($value['ts_sentdate'], 'Y-m-d')) ?></td> -->
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date; ?></td>
                                            <!--<td><?php echo $except_date; ?></td>-->
                                            <td style=" min-width: 130px !important;">

                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>" class=" mydatepicker" id="dasexpected_date<?php echo $value['cs_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['cs_packid'] ?>', '3')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Save Expected date">
                                                        <i class="fas fa-save "></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <!--                                        <td><?php echo $actual_date ?></td>-->
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange " data-toggle="tooltip" data-original-title="OPS Remarks" data-placement="bottom" style=" cursor: pointer;" onclick="swal('<?php echo $value['cs_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>

                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getspocid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['cs_packid'] ?>','<?php echo $Next_stage ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>
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
                    <div class="modal-content modal_resize" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack">Package Name</small></h4>
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h5 id="pack"><small></small></h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span></small>
                                </div>

                                <div class=" col-md-6" id="ps">
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span></small>
                                    

                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <center>
                                <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">Tech SPOC to Tech. Expert</span></small>
                            </center>
                            <form method="post" class="needs-validation" action="functions/move_spoc_to_expert.php" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6" style="display:none;">
                                            <label for="revend_date" class="bold">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <!--                                                <input type="text" class="form-control mydatepicker"  id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">
                                        <div class="col-md-6">
                                            <label for="revend_date" class=" bold">Action Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled="" id="act_date" name="act_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label bold">Technical Expert:</label>
                                    <select class="custom-select" name="expert_id" id="expert_id" required>
                                        <option value="">--Select Tech Expert--</option>
                                        <?php
                                        // user type 11 is tech expert
                                        if ($_SESSION['milcom'] == '1') {
                                            $mil = "1";
                                        } else {
                                            $mil = "";
                                        }
                                        $result = $cls_comm->select_user('11', $mil);
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                        ?>
                                            <option value="<?php echo $value['uid'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row" id="opsr" style="margin-left:0%;">

                                </div><br>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>
                                <input type="hidden" name="next_stage" id="next_stage">
                                <input type="hidden" id="spoc_id" name="spoc_id">

                                <div class="modal-footer">
                                    <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
                                    <button type="submit" class="btn btn-outline-primary btn-rounded" name="approve_package" id="submitbtn"><i class="fas fa-paper-plane"></i> Send to Tech Expert </button>
                                </div>


                            </form>
                        </div>
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
<script src="code/js/technical.js" type="text/javascript"></script>
<script>
    function getspocid(a, b, c,d) {
       
        var spocid = a;
        var project = b;
        var pack_id = c;
        $("#proj").text(project);
        $("#spoc_id").val(spocid);
        $("#next_stage").val(d);
        //            $("#exp_date").disabled = true;
        $("#act_date").datepicker("setDate", new Date());
        //            document.getElementById("exp_date").disabled = true;
        $.post("functions/filesforexpert.php", {
            key: pack_id
        }, function(data) {
            console.log(data);
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $("#pack").html(pm_packagename);
            $("#exp_date").val(mat_req_date);
            
        });
        $.post("functions/opsremarks.php", {
            key: pack_id
        }, function(data) {
            $('#opsr').html(data);
        });
    }

    function samedate($id) {
        $("#exp_date").datepicker("setDate", $id);
    }

    function swift_proj(Proid) {
        window.location.href = "swift_workflow_approval?pid=" + Proid;
    }

    function save_expected(pack_id, stage_id) {
        //alert(pack_id);
        var exp_date = $('#dasexpected_date' + pack_id).val();
        $.post("code/save_expected.php", {
            key: pack_id,
            stage_id: stage_id,
            exp_date: exp_date
        }, function(data) {
            swal('Updated Sucessfully');
        });

    }
</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>