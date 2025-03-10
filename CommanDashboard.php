<?php
ini_set('max_execution_time', '0'); // for infinite time of execution 
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';


$uid = $_SESSION['uid'];

$segment = $_SESSION['swift_dep'];
echo $depid = $_SESSION['deptid'];
$usertype = $_SESSION['usertype'];

if ($depid == 33) {
    $segment = 'and cat_id=33';
    $segment1 = 'cat_id=33';
} else if ($depid == 35) {
    $segment = 'and cat_id=35';
    $segment1 = 'cat_id=35';
} else if ($depid == 36) {
    $segment = 'and cat_id=36';
    $segment1 = 'cat_id=36';
} else if ($depid == 37) {
    $segment = 'and cat_id=37';
    $segment1 = 'cat_id=37';
} else if ($depid == 38) {
    $segment = 'and cat_id=38';
    $segment1 = 'cat_id=38';
} else {

    if ($usertype == '6') {
        $result = $cls_report->select_user1($uid);
        $prosps_id = $result['proj_ids'];
        $segment = ' and proj_id in(' . $prosps_id . ')';
        $segment1 = 'proj_id in(' . $prosps_id . ')';
    } else {
        $segment = '';
        $segment1 = '';
    }
}
$proj_type = $cls_comm->select_project_type($segment);
$proj_type = json_decode($proj_type, true);
if (isset($_GET['pid']) || isset($_GET['ptid'])) {
    $pid = $_GET['pid'];
    $ptid = $_GET['ptid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
    echo '<script>var ptid=' . $_GET['ptid'] . ';</script>';
} else {
    $pid = "";
    $ptid = "";
    if (count($proj_type) > 1) {
        $ptid = "-";
    } else if (count($proj_type) == 1) {
        $ptid = $proj_type[0]['id'];
    }
}

?>
<style>
    #pd {
        margin-top: -4%;
        margin-left: 63.8% !important;
    }

    .col-lg-2 {
        padding-right: 5px;
        padding-left: 0px;
    }

    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .card {
        border-radius: 10px !important;
        margin-bottom: 39px !important;
    }

    .d-flex {
        border-radius: 10px !important;
    }

    @-webkit-keyframes blinker2 {
        from {
            opacity: 1.0;
        }

        to {
            opacity: 0.0;
        }
    }

    .blink {
        text-decoration: blink;
        -webkit-animation-name: blinker2;
        -webkit-animation-duration: 0.6s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
        -webkit-animation-direction: alternate;
    }
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Action Board</h5>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter(this.value, '4')" required="">
                    <?php if (isset($_SESSION['proj_type']) && $_SESSION['proj_type'] == 0) { ?>
                        <option value="-" <?php echo ($ptid == '-') ? 'selected' : ''; ?>>Both</option>
                    <?php } ?>
                    <?php
                    foreach ($proj_type as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id'] ?>" <?php echo (!empty($res)/* count($res) == 1 */ || $ptid == $value['id']) ? 'selected' : ''; ?>>
                            <?php echo $value['type_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter"
                    onchange="proj_Filter(this.value, '1')" required="">
                    <option value="">--All Project--</option>
                    <?php
                    // $result = $cls_report->select_allprojects_seg1($segment1);
                    $result = $cls_report->select_filterprojects_seg2($seg, $ptid);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>>
                            <?php echo $value['proj_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-2 col-md-2 pointer" style="left: 20%; z-index:9999;">
                <?php if ($_SESSION['report_access'] == 'checked') { ?>
                    <a href="procurement_tracker" class="text-primary pointer"><u> Procurement Tracker </u><label
                            style="position: relative; top:-25% "
                            class=" blink_me badge badge-success badge-rounded">New</label></a>
                <?php }
                ?>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="ops_dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Action Board</li>
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
        <!-- Card Group  -->
        <!-- ============================================================== -->



        <!-- basic table -->
        <div class="row" id="thirdrow" style="margin-top: 0% !important;">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive" id="repo_dash">
                            <table id="file_export" style=" white-space: nowrap !important;"
                                class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <th style="padding-right: 13px !important;">Department</th>
                                        <th style="padding-right: 13px !important;">Current Status</th>
                                        <!-- <th style="padding-right: 13px !important;">Weightage</th> -->
                                        <th style="padding-right: 13px !important;">Material Req @ Site</th>
                                        <th style="padding-right: 13px !important;">Lead time(Days)</th>
                                        <!-- <th style="padding-right: 13px !important;">Exp. Order Closing</th> -->
                                        <th style="padding-right: 13px !important;">SS Plan & Actual</th>
                                        <th style="padding-right: 13px !important;">Po/Wo Plan & Actual</th>
                                        <th style="padding-right: 13px !important;">Deviations (Days)</th>
                                        <th style="padding-right: 13px !important;">History & View</th>
                                        <th style="padding-right: 13px !important;">Attachments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $repo = $cls_report->main_dash1($pid, $segment);
                                    $res = json_decode($repo, true);
                                    foreach ($res as $key => $value) {
                                        $sent_back = $value['ps_stback'];
                                        $pack_id = $value['ps_packid'];
                                        $stageid = $value['ps_stageid'];
                                        $projid = $value['proj_id'];
                                        $utype = $value['usertype'];
                                        $packname = $value['pm_packagename'];
                                        $projname = $value['proj_name'];
                                        $procount = strlen($projname);
                                        $packcount = strlen($packname);
                                        if ($procount > 50) {
                                            $stylepro = "style='white-space: pre-line;' ";
                                        } else {
                                            $stylepro = "";
                                        }
                                        if ($packcount > 50) {
                                            $stylepack = "style='white-space: pre-line;' ";
                                        } else {
                                            $stylepack = "";
                                        }
                                        $deviations = $value['daysdif'];
                                        $department = $value['dept'];
                                        if ($sent_back == 1) {
                                            $sent = $value['shot_name'];
                                            $current_status = 'Sent back by ' . $sent . '<br>(' . $value['sname'] . ' / ' . $value['nodays'] . ' Days )';
                                        } else {
                                            $current_status = $value['shot_name'] . '<br>(' . $value['name'] . ' / ' . $value['nodays'] . ' Days )';
                                        }
                                        $po_act = $po_plan = $ss_act = $ss_plan = '';

                                        // Check if 'po_actdate' exists and is not empty
                                        if (!empty($value['po_actdate'])) {
                                            $po_actdate = formatDate($value['po_actdate'], 'd-M-Y');
                                            $po_act = "<span class='badge badge-pill badge-info font-medium text-white ml-1'>$po_actdate</span>";
                                        }
                                        
                                        // Check if 'po_planneddate' exists and is not empty
                                        if (!empty($value['po_planneddate'])) {
                                            $po_plandate = formatDate($value['po_planneddate'], 'd-M-Y');
                                            $po_plan = "<span class='badge badge-pill badge-primary font-medium text-white ml-1'>$po_plandate</span>";
                                        }
                                        
                                        // Check if 'ss_app_actualdate' exists and is not empty
                                        if (!empty($value['ss_app_actualdate'])) {
                                            $ss_actdate = formatDate($value['ss_app_actualdate'], 'd-M-Y');
                                            $ss_act = "<span class='badge badge-pill badge-info font-medium text-white ml-1'>$ss_actdate</span>";
                                        }
                                        
                                        // Check if 'ss_app_plandate' exists and is not empty
                                        if (!empty($value['ss_app_plandate'])) {
                                            $ss_planneddate = formatDate($value['ss_app_plandate'], 'd-M-Y');
                                            $ss_plan = "<span class='badge badge-pill badge-primary font-medium text-white ml-1'>$ss_planneddate</span>";
                                        }
                                        // $ss_planneddate  = formatDate($value['ss_app_plandate'], 'd-M-Y');
                                        // $ss_app_actualdate      = $value['ss_app_actualdate'];
                                        // $Ini_app_actualdate     = $value['Ini_app_actualdate'];
                                    
                                        // $SSApprovalDate         = $value['SSApprovalDate'];
                                        // $InitiateSSApprovalDate = $value['InitiateSSApprovalDate'];
                                    

                                        // $getExpectedSSApproval = $cls_user->getExpectedSSApproval($pack_id);
                                        // $SSApprovalDate = $getExpectedSSApproval['revised_planned_date'];
                                    
                                        // $getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval($pack_id);
                                        // $InitiateSSApprovalDate = $getExpectedInitiateSSApproval['revised_planned_date'];
                                    
                                        // if ($deviations < 0) {
                                    
                                        //     if (trim($ss_app_actualdate) == "") {
                                        //         $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' -' . abs($deviations) . 'days'));
                                        //     } else {
                                        //         $expdelivery = formatDate($ss_app_actualdate, 'd-M-Y');
                                        //     }
                                    
                                        //     if (trim($Ini_app_actualdate) == "") {
                                        //         $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' -' . abs($deviations) . 'days'));
                                        //     } else {
                                        //         $ssInidate = formatDate($Ini_app_actualdate, 'd-M-Y');
                                        //     }
                                        // } else {
                                    

                                        //     if (trim($ss_app_actualdate) == "") {
                                        //         $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' +' . abs($deviations) . 'days'));
                                        //     } else {
                                        //         $expdelivery = formatDate($ss_app_actualdate, 'd-M-Y');
                                        //     }
                                    
                                        //     if (trim($Ini_app_actualdate) == "") {
                                        //         $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' +' . abs($deviations) . 'days'));
                                        //     } else {
                                        //         $ssInidate = formatDate($Ini_app_actualdate, 'd-M-Y');
                                        //     }
                                        // }
                                        if ($value['proj_type'] == 1) {
                                            $ptype = "CO";
                                            $ptype_col = "type_gr";
                                        } else if ($value['proj_type'] == 2) {
                                            $ptype = "NCO";
                                            $ptype_col = "type_or";
                                        } else {
                                            $ptype = "";
                                            $ptype_col = "";
                                        }

                                        ?>
                                        <tr>
                                            <td <?php echo $stylepro; ?>>
                                                <?php echo $projname; ?>
                                                <?php if ($value['proj_type'] != '') { ?>
                                                    <span class="blink">
                                                        <span class='type_sty <?php echo $ptype_col; ?>'>
                                                            <?php echo $ptype; ?>
                                                        </span>
                                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td <?php echo $stylepack; ?>>
                                                <?php
                                                $value['pm_revised_material_req'] = formatDate($value['pm_revised_material_req'], 'Y-m-d'); 
                                                if (strtotime($value['pm_revised_material_req']) < strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point"></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['pm_revised_material_req']) > strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify"></span>
                                                        <span class="point greenpoint"></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['pm_revised_material_req']) == strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint"></span>
                                                    </div>
                                                <?php } ?>
                                                <?php echo wordwrap($packname, 50, "<br>\n"); ?>
                                            </td>
                                            <td>
                                                <?php echo $department; ?>
                                            </td>
                                            <td>
                                                <span style=" background-color: rgb(44, 36, 158); color:white;"
                                                    class="badge badge-pill  font-medium text-black ml-1 recfrm">
                                                    <?php echo $current_status; ?>
                                                </span>
                                            </td>
                                            <!-- <td>
                                                <span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm" style=" background-color: #8e1f1f !important;">
                                                    <?php //$get_weightage = $cls_report->get_weightage($pack_id, $stageid, $projid);
                                                        // echo $get_weightage . ' %';
                                                        ?>
                                                </span>
                                            </td> -->
                                            <td>
                                                <?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?>
                                            </td>
                                            <td>
                                                <?php echo $value['pm_revised_lead_time']; ?>
                                            </td>
                                            <!-- <td><?php echo $ssInidate; ?></td> -->
                                            <td>
                                                <?php echo $ss_plan; ?>
                                                <?php echo $ss_act; ?>
                                            </td>
                                            <td>
                                                <?php echo $po_plan; ?>
                                                <?php echo $po_act; ?>
                                            </td>
                                            <td>
                                                <?php echo $deviations; ?>
                                            </td>
                                            <td>
                                                <span onclick="view_reports('<?php echo $value['ps_packid']; ?>','<?php echo $projid ?>')"
                                                    class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title="Current Package Status Stage wise"><i
                                                        class="fas fa-eye"></i> </span>
                                                <span onclick="view_reports_table('<?php echo $value['ps_packid']; ?>','<?php echo $projid; ?>')"
                                                    style="background-color: #8e1f1f !important;"
                                                    class="badge badge-pill badge-info font-medium text-white ml-1"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title=" Packages WorkFlow  "><i
                                                        class="fa fa-database"></i> </span>
                                            </td>
                                            <td>
                                                <span class="pointer"
                                                    onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $projid; ?>', '<?php echo $pack_id; ?>','<?php echo $stageid; ?>','<?php echo $ptype ?>')"
                                                    data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo">
                                                    <i class="fas fa-paperclip text-black"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sample modal content -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 180%; margin-left: -25%">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span>
                                <span class="blink">
                                    <span class='type_sty <?php echo $ptype_col; ?>'>
                                        <?php echo $ptype; ?>
                                    </span>
                                    <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                - <small id="pack1">Package Name</small>
                            </h4>

                            <input type="hidden" name="projid" id="projid">
                            <input type="hidden" name="packid" id="packid">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span
                                            class="badge badge-pill badge-info font-12 text-white ml-1"
                                            id="planned_date"></span></small>
                                </div>
                                <div class=" col-md-6" id="ps">
                                    <small>Expected Date:- <span
                                            class="badge badge-pill badge-primary font-12 text-white ml-1"
                                            id="exp_date"></span></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <form>
                                    <div class="col-md-12" id="ops_exp_uptable">

                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->



        </div>

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
<script src="code/js/ops.js" type="text/javascript"></script>
<script src="code/js/technical.js" type="text/javascript"></script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
    function login() {
        var user = 'SWIFTUSERS';
        $.post("assets/insertlog.php", {
            key: user
        }, function (data) {

        });
    }
    login();
</script>