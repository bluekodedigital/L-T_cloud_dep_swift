<?php
ini_set('max_execution_time', '0'); // for infinite time of execution 
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
if($_SESSION['milcom']=='1')
{
  $segment='38';  
}else
{
$segment = $_SESSION['tech_seg'];
}


$depid = $_SESSION['deptid'];
$usertype = $_SESSION['usertype'];
$uid = $_SESSION['uid'];
$get_userSeg = $cls_report->get_userSeg($uid);
$userSeg = $get_userSeg['user_seg']; 

//if ($userSeg == 33) {
//    $segment = 'and cat_id=33';
//    $segment1 = 'cat_id=33';
//}
if($_SESSION['milcom']!='1')
{
if ($userSeg == 33) {
    $segment = 'and cat_id in (33,35,36)';
    $segment1 = 'cat_id in (33,35,36)';
} 
else if ($userSeg == 35) {
    $segment = 'and cat_id=35';
    $segment1 = 'cat_id=35';
} else if ($userSeg == 36) {
    $segment = 'and cat_id=36';
    $segment1 = 'cat_id=36';
} else if ($userSeg == 37) {
    $segment = 'and cat_id=37';
    $segment1 = 'cat_id=37';
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
}else
{
  $segment = 'and cat_id=38';
    $segment1 = 'cat_id=38';    
}

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
$final_status = $cls_report->final_status($pid);
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    .p-2{
        padding: .6rem!important;
    }
    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
</style>
<style>
    #chartdiv {
        width: 100%;
        height: 400px;
    }
    #chartdiv1 {
        width: 100%;
        height: 400px;
    }
    #chartdiv2 {
        width: 100%;
        height: 300px;
    }
    .new_font_normal{
        font-size:16px !important;
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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Dashboard
                </h5>

            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center" style="z-index:1;" >                
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter" onchange="techproj_Filter(this.value, '16')" required="">
                    <option value="">--All Project--</option>
                    <?php
                    $result = $cls_report->select_allprojects_seg1($segment1);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-6 col-md-8 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <div class="row">

            <div class="col-md-6 col-lg-3">
                <?php
                $load_package_report = $cls_report->load_package_report($pid, $segment);
                $res_das = json_decode($load_package_report, true);
                $start_z = $res_das[0]['package'];
                $end_z = $res_das[3]['package'];
                ?>
                <a href="dashboard"> <div class="card">
                        <div class="card-body text-center ">
                            <h5 class="card-title text-uppercase text-center" style=" color: #000;   margin-bottom: -1.25rem;">Total</h5>
                            <div class="d-flex align-items-center mb-2 mt-4 text-center total "  >

                                <div class="ml-auto">
                                    <h2 class=" text-center ">
                                        <span class="font-normal new_font_normal">
                                            <?php
                                            $ttl_package = $cls_count->ttl_package($pid, $segment);
                                            $app_completed = $cls_report->app_completedfinal($pid, $segment);
                                            echo sprintf("%02d", $app_completed);

                                            $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                            ?>/<?php
                                            echo sprintf("%02d", $ttl_package);
                                            ?>
                                        </span>
                                    </h2>
                                    <span><?php echo $app_uPer; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#repo_dash">   <div class="card" style=" cursor: pointer;" onclick=" repo_dash('<?php echo $pid; ?>', '2,3,4,5,6', '<?php echo $segment; ?>');">
                        <div class="card-body text-center ">
                            <h5 class="card-title text-uppercase text-center" style=" color: #000;    margin-bottom: -1.25rem;">Technical </h5>
                            <div class="d-flex align-items-center mb-2 mt-4 text-center technical">

                                <div class="ml-auto" >
                                    <h2 class=" text-center "><span class="font-normal new_font_normal"> <?php
                                            $ttl_tech_cleared = $cls_count->ttl_tech_cleared($pid, $segment);
                                            $result = $ttl_package - $ttl_tech_cleared;
                                            echo sprintf("%02d", $result);
                                            ?>/<?php echo sprintf("%02d", $ttl_package); ?></span></h2>
                                    <span><?php
//                                    $result = $cls_count->tech_cto_workflow_count($pid);
                                        echo sprintf("%02d", $ttl_tech_cleared);
                                        ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#repo_dash"> 
                    <div class="card"  style=" cursor: pointer;" onclick=" repo_dash('<?php echo $pid; ?>', '7,8,9,10,19,22,23,25,26,28', '<?php echo $segment; ?>');">
                        <div class="card-body text-center ">
                            <h5 class="card-title text-uppercase text-center" style=" color: #000;    margin-bottom: -1.25rem;">Operations</h5>
                            <div class="d-flex align-items-center mb-2 mt-4 text-center operations " >

                                <div class="ml-auto">
                                    <h2 class=" text-center ">
                                        <span class="font-normal new_font_normal">
                                            <?php
                                            $files_contract = $cls_user->ops_count($pid, $segment);
                                            $app_inprogress = $cls_count->app_inprogress($pid, $segment);

                                            echo sprintf("%02d", $app_inprogress);
                                            $ops_postcleared = $cls_report->ops_count_cleared($pid, $segment);

                                            $oppoPer = number_format(round(($ops_postcleared / $ttl_package) * 100), 2);
                                            ?>/<?php
                                            echo sprintf("%02d", $ttl_package);
                                            ?>
                                        </span>

                                    </h2>
                                    <span> 
                                        <?php
                                        echo sprintf("%02d", $ops_postcleared);
                                        ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card" style=" cursor: pointer;" onclick=" repo_dash('<?php echo $pid; ?>', '13,14', '<?php echo $segment; ?>');">
                    <a href="#repo_dash"> 
                        <div class="card-body text-center ">
                            <h5 class="card-title text-uppercase text-center" style=" color: #000;   margin-bottom: -1.25rem;">SCM</h5>
                            <div class="d-flex align-items-center mb-2 mt-4 text-center scmappr " >

                                <div class="ml-auto">
                                    <h2 class=" text-center ">
                                        <span class="font-normal new_font_normal">
                                            <?php
                                            $app_inprogress = $cls_count->app_inprogress($pid, $segment);
//                                            echo sprintf("%02d", $app_inprogress);
                                            $app_completed = $cls_report->app_completedfinal($pid, $segment);
                                            echo sprintf("%02d", $app_completed);
                                            $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                            ?>/<?php
                                            echo sprintf("%02d", $ttl_package);
                                            ?>
                                        </span>
                                    </h2>
                                    <span>
                                        <?php
                                        $app_p = $app_inprogress - $app_completed;
                                        echo sprintf("%02d", $app_p);
                                        ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>


        <div class="row none" >
            <div class="col-lg-6" id="pschart">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Progress Status</h5>
                        <div class="mt-3">
                            <div id="morris-donut-chart" style="height:265px;"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <div>
                                <h3 class="font-medium text-uppercase"><?php echo $ttl_package; ?> </h3>
                                <h5 class="text-muted">Total Packages</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-lg-6" id="dechart">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Delivery Status</h5>
                        <div class="mt-3">
                            <div id="morris-donut-chart1" style="height:265px;"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <div>
                                <h3 class="font-medium text-uppercase"><?php echo $ttl_package; ?> </h3>
                                <h5 class="text-muted">Total Packages</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
 
        </div>
        <div class="row" >
            <div class="col-lg-4" id="pschart">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Project Report</h5>
                        <div class="mt-3">
                            <div id="chartdiv"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">


                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-lg-8" id="dechart">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Package Report</h5>
                        <div class="mt-3">

                            <div id="chartdiv1"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">


                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-lg-12" id="dechart">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Weightage Derivatives</h5>
                        <div class="mt-3">

                            <div id="chartdiv2"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">


                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="row none">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Completed Status</h5>
                        <ul class="list-style-none country-state mt-4">

                            <!--                            <li class="mb-4">
                                                            <h2 class="mb-0"> 
                            <?php
                            $ops_initiated = $cls_report->repo_files_fortechspoc_initiated($pid, $segment);
                            echo $ops_initiated;
                            $opsPer = number_format(round(($ops_initiated / $ttl_package) * 100), 2);
                            ?>
                            
                                                            </h2>
                                                             Operation Initiated  
                                                            <div class="float-right"><?php echo $opsPer; ?>%</div>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $opsPer; ?>%; height: 6px;    background-color: #b33a99;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </li>-->
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
//                                    $ttl_tech_cleared = $cls_count->ttl_tech_cleared($pid);
//                                    echo $ttl_tech_cleared;
                                    $ttl_tech_cleared = $cls_count->ttl_tech_cleared($pid, $segment);
                                    $result = $ttl_package - $ttl_tech_cleared;
                                    echo $result;
                                    $techPer = number_format(round(($ttl_tech_cleared / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Technical 
                                <div class="float-right"><?php echo $techPer; ?>% </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $techPer; ?>%; height: 6px; backgroud-color:#707CD2;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $ops_postcleared = $cls_report->om_count_cleared($pid, $segment);
                                    echo $app_inprogress;
                                    $oppoPer = number_format(round(($app_inprogress / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Operation
                                <div class="float-right"><?php echo $oppoPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $oppoPer; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $scm_underfinal = $cls_report->scm_underfinal($pid, $segment);
                                    echo $app_p;
                                    $scm_uPer = number_format(round(($app_p / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                SCM Under Finalization (Order) 
                                <div class="float-right"><?php echo $scm_uPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $scm_uPer; ?>%; height: 6px; background-color:#2CD07E;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $app_completed = $cls_report->app_completedfinal($pid, $segment);
                                    echo $app_completed;
                                    $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                SCM Finalized (Order) 
                                <div class="float-right"><?php echo $app_uPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $app_uPer; ?>%; height: 6px; background-color:#4C5667;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>

                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $app_completed = $cls_report->app_completed($pid, $segment);
                                    echo $app_completed;
                                    $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                SmartSignoff- Approved files 
                                <div class="float-right"><?php echo $app_uPer; ?>% </div>
                                <div class="progress">
                                    <div class="progress-bar  " role="progressbar" style="width: <?php echo $app_uPer; ?>%; height: 6px; background-color:#287B05;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Completed Status</h5>
                        <ul class="list-style-none country-state mt-4">

                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $po_completed = $cls_count->po_completed($pid, $segment);
                                    echo $po_completed;
                                    $poPer = number_format(round(($po_completed / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                PO Completed 
                                <div class="float-right"><?php echo $poPer; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $poPer; ?>%; height: 6px; background-color:#2CABE3;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $wo_completed = $cls_count->wo_completed($pid, $segment);
                                    echo $wo_completed;
                                    $woPer = number_format(round(($wo_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                WO Completed 
                                <div class="float-right"><?php echo $woPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $woPer; ?>%; height: 6px; background-color:#0044CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $manf_completed = $cls_count->manf_completed($pid, $segment);
                                    echo $manf_completed;
                                    $mfPer = number_format(round(($manf_completed / $ttl_package) * 100), 2);
                                    ?> 


                                </h2>
                                Manf. Clearance 
                                <div class="float-right"><?php echo $mfPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $mfPer; ?>%; height: 6px;  background-color:#9000CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $mtr_received = $cls_count->mtr_received($pid, $segment);
                                    echo $mtr_received;
                                    $mrPer = number_format(round(($manf_completed / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Material Received 
                                <div class="float-right"><?php echo $mrPer; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $mrPer; ?>%; height: 6px; background-color:#176FF3;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>

                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="dashtbl">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive" id="repo_dash">
                            <table id="file_export" style=" white-space: nowrap !important;"  class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;" >Project</th>
                                        <th style="padding-right: 13px !important;" >Package</th>
                                        <th style="padding-right: 13px !important;" >Department</th>
                                        <th style="padding-right: 13px !important;" >Current Status</th>
                                        <th style="padding-right: 13px !important;" >Weightage</th>
                                        <th style="padding-right: 13px !important;" >Material Req @ Site</th>
                                        <th style="padding-right: 13px !important;" >Lead time(Days)</th>
                                        <th style="padding-right: 13px !important;" >Exp. Order Closing</th>
                                        <th style="padding-right: 13px !important;" >Exp. SS Approval</th>
                                        <!--<th>Exp. Delivery</th>-->
                                        <th style="padding-right: 13px !important;" >Deviations (Days)</th>
                                        <th style="padding-right: 13px !important;" >View</th>                                      
                                        <th style="padding-right: 13px !important;" >Attachments</th>                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $repo = $cls_report->techspoc_dash1($pid, $segment);
                                    $res = json_decode($repo, true);
                                    foreach ($res as $key => $value) {
//                                        $deviations = $value['daysdif'];
//                                        echo $deviations;
                                        $pack_id = $value['ps_packid'];
                                        $stageid = $value['ps_stageid'];
                                        $projid = $value['proj_id'];
                                        $get_deviations = $cls_report->get_deviations($pack_id, $stageid, $projid);
                                        $deviations = $get_deviations['daysdif'];
//                                        $expdelivery = formatDate($value['pm_revised_material_req'] . ' +' . $deviations . 'days', 'd-M-Y');
                                        $current_status = $cls_comm->current_status($value['ps_packid']);

                                        $sent_back = $value['ps_stback'];
                                        if ($sent_back == 1) {
                                            $fetch_usertype = $cls_comm->fetch_usertype($value['ps_sbuid']);
                                        } else {
                                            $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
//                                             $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
                                        }

//                                        $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
                                        $get_po_wo_app = $cls_user->get_po_wo_app($value['ps_packid']);
                                        
                                        $getExpectedSSApproval = $cls_user->getExpectedSSApproval($pack_id);
                                        $SSApprovalDate = $getExpectedSSApproval['revised_planned_date'];

                                        $getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval($pack_id);
                                        $InitiateSSApprovalDate = $getExpectedInitiateSSApproval['revised_planned_date'];

                                        if ($deviations < 0) {

                                            if (trim($getExpectedSSApproval['ps_actualdate']) == "") {
                                                $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' -' . abs($deviations) . 'days'));
                                            } else {
                                                $expdelivery = formatDate($getExpectedSSApproval['ps_actualdate'], 'd-M-Y');
                                            }

                                            if (trim($getExpectedInitiateSSApproval['ps_actualdate']) == "") {
                                                $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' -' . abs($deviations) . 'days'));
                                            } else {
                                                $ssInidate = formatDate($getExpectedInitiateSSApproval['ps_actualdate'], 'd-M-Y');
                                            }
                                        } else {


                                            if (trim($getExpectedSSApproval['ps_actualdate']) == "") {
                                                $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' +' . abs($deviations) . 'days'));
                                            } else {
                                                $expdelivery = formatDate($getExpectedSSApproval['ps_actualdate'], 'd-M-Y');
                                            }

                                            if (trim($getExpectedInitiateSSApproval['ps_actualdate']) == "") {
                                                $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' +' . abs($deviations) . 'days'));
                                            } else {
                                                $ssInidate = formatDate($getExpectedInitiateSSApproval['ps_actualdate'], 'd-M-Y');
                                            }
                                        }

                                        if ($get_po_wo_app != "") {
                                            $po_wo = $get_po_wo_app['so_hw_sw'];
                                        } else {
                                            $po_wo = 0;
                                        }
                                        if ($po_wo == 1 && $stageid == 23) {
                                            $current_status = 'WO Approval Completed';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $value['proj_name'] ?></td>
                                            <td>
                                                <?php if (strtotime($value['pm_revised_material_req']) < strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['pm_revised_material_req']) > strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify" ></span>
                                                        <span class="point greenpoint" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['pm_revised_material_req']) == strtotime($expdelivery)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint" ></span>
                                                    </div>
                                                <?php }
                                                ?>
                                                <?php echo wordwrap($value['pm_packagename'], 50, "<br>\n"); ?></td>
                                            <td><?php
                                                // echo $fetch_usertype;;
                                                if ($fetch_usertype == 2) {
                                                    echo 'SCM';
                                                } else if ($fetch_usertype == 14) {
                                                    echo 'OPS';
                                                } else if ($fetch_usertype == 5) {
                                                    echo 'OPS';
                                                } else if ($fetch_usertype == 10) {
                                                    echo 'TECHNICAL';
                                                } else if ($fetch_usertype == 11) {
                                                    echo 'TECHNICAL';
                                                } else if ($fetch_usertype == 12) {
                                                    echo 'TECHNICAL';
                                                } else if ($fetch_usertype == 15) {
                                                    echo 'O&M';
                                                }
                                                ?></td>
                                            <td><span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm"><?php echo $current_status; ?></span></td>
                                            <td>
                                                <span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm" style=" background-color: #8e1f1f !important;"><?php
                                                    $get_weightage = $cls_report->get_weightage($pack_id, $stageid, $projid);
                                                    echo $get_weightage . ' %';
                                                    ?>
                                                </span>
                                            </td>
                                            <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                                            <td><?php echo $value['pm_revised_lead_time']; ?></td>
                                            <!--<td><?php // echo $expdelivery; ?></td>-->
                                            <td><?php echo $ssInidate; ?></td>
                                            <td><?php echo $expdelivery; ?></td>
                                            <td>
                                                <?php
                                                $sdate = formatDate($value['pm_revised_material_req'], 'Y-m-d');
                                                $ltime = formatDate($expdelivery, 'Y-m-d');
                                                $start = new DateTime($sdate);
                                                $end = new DateTime($ltime);
                                                $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . '';

                                                if ($bdate < 0) {
                                                    ?>
                                                    <span class=" text-primary"><?php echo $bdate; ?></span>
                                                     <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                                                <?php } else { ?>
                                                    <span class=" text-danger"><?php echo $bdate; ?></span>
                                                     <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                                                <?php } ?>

                                            </td>
                                            <td>
                                                <span   onclick="view_reports('<?php echo $value['ps_packid']; ?>','<?php echo $projid; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-eye"></i> </span>
                                                <span onclick="view_reports_table('<?php echo $value['ps_packid']; ?>','<?php echo $projid; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-file-excel"></i> </span>

                                            </td>
                                            <td><span class="pointer" onclick="view_allattachments('<?php echo $value['proj_name'] ?>', '<?php echo $value['pm_packagename'] ?>', ' <?php echo $value['proj_id'] ?>', ' <?php echo $value['ps_packid'] ?>', '<?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?>', '<?php echo $expdelivery; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                            </td>

                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- sample modal content -->                     
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style=" width: 180%; margin-left: -25%">
                            <div class="modal-header" style="padding-bottom: 3%;">

                                <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack1">Package Name</small></h4> 


                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="row">
                                <div class="container-fluid">
                                    <div class=" col-md-6" id="pd">
                                        <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="plndate"></span></small>                           
                                    </div>
                                    <div class=" col-md-6" id="ps"  >
                                        <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="expndate"></span></small>                          
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">

                                <div  id="exp_uptable" style=" width: 60%"></div> 
                                <div  id="uptable" style=" width: 60%"></div>
                                <div  id="ops_exp_uptable" style=" width: 60%"></div>




                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary"  data-dismiss="modal" >Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->
            </div>
        </div>
        <?php
        $partial = $cls_count->partial($pid);
        $deliverd = $cls_count->deliverd($pid);
        ?>

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
<script src="code/js/ops.js" type="text/javascript"></script>

<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script src="code/js/report.js" type="text/javascript"></script>
<script>
    function techproj_Filter(id){
         window.location.href = "tech_dashboard?pid=" + id;
        
    }
                                            Morris.Donut({
                                                element: 'morris-donut-chart',
                                                data: [{
                                                        label: "On Track",
                                                        value: <?php echo $final_status['on_track'] ?>,
                                                    }, {
                                                        label: "Delayed",
                                                        value: <?php echo $final_status['delayed'] ?>,
                                                    }, {
                                                        label: "Critical",
                                                        value: <?php echo $final_status['critical'] ?>,
                                                    }],
                                                resize: true,
                                                colors: ['#53e69d', '#7bcef3', '#ff7676']
                                            });
                                            Morris.Donut({
                                                element: 'morris-donut-chart1',
                                                data: [{
                                                        label: "Deliverd",
                                                        value: <?php echo $deliverd; ?>,
                                                    }, {
                                                        label: "UnDelivered",
                                                        value: <?php echo $ttl_package; ?>,
                                                    }, {
                                                        label: "Partialy Deliverd ",
                                                        value: <?php echo $partial ?>,
                                                    }],
                                                resize: true,
                                                colors: ['#53e69d', '#ff7676', '#7bcef3']
                                            });

                                            $(document).ready(function () {
                                                $('#file_export').dataTable()
                                                        .columnFilter({
                                                            aoColumns: [{type: "select", values: ['Gecko', 'Trident', 'KHTML', 'Misc', 'Presto', 'Webkit', 'Tasman']},
                                                                {type: "text"},
                                                                null,
                                                                {type: "number"},
                                                                {type: "select"}
                                                            ]

                                                        });
                                            });
                                            load_project_report('<?php echo $segment; ?>');
                                            load_weightage();



                                            am4core.ready(function () {

// Themes begin
                                                am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
                                                var chart = am4core.create("chartdiv1", am4charts.XYChart);

// Add data
//                                                    chart.data = [{"package": "swift pack-1", "complete": 30, "incomplete": 70}, {"package": "test bks", "complete": 25, "incomplete": 75}, {"package": "tech Expert attach demo", "complete": 10, "incomplete": 90}, {"package": "tech exp attached files demo- 2", "complete": 10, "incomplete": 90}, {"package": "technical expert attachment demo -3", "complete": 10, "incomplete": 90}, {"package": "Testing email package", "complete": 10, "incomplete": 90}, {"package": "testing email pack2", "complete": 5, "incomplete": 95}, {"package": "testing email pack2", "complete": 5, "incomplete": 95}, {"package": "Testing email pack 4", "complete": 30, "incomplete": 70}, {"package": "Test Email", "complete": 10, "incomplete": 90}, {"package": "Under Testing email-0", "complete": 10, "incomplete": 90}, {"package": "Test SPOC", "complete": 25, "incomplete": 75}, {"package": "Testing Remarks-01", "complete": 25, "incomplete": 75}, {"package": "Testing Remarks-02", "complete": 60, "incomplete": 40}, {"package": "Radio Station", "complete": 30, "incomplete": 70}, {"package": "Radio Station-1", "complete": 25, "incomplete": 75}, {"package": "Stage Name Corrections", "complete": 10, "incomplete": 90}, {"package": "Test Current Stage Name -01", "complete": 60, "incomplete": 40}, {"package": "Testing OPS Attachments", "complete": 25, "incomplete": 75}, {"package": "Test Stage Active", "complete": 30, "incomplete": 70}, {"package": "Email Trigger", "complete": 25, "incomplete": 75}, {"package": "email Setting", "complete": 5, "incomplete": 95}, {"package": "test techincal upload demo pack-4", "complete": 10, "incomplete": 90}, {"package": "testing table back groud color", "complete": 10, "incomplete": 90}, {"package": "fdsa df gdfg fdgfd gfdg fdgfdgfd", "complete": 10, "incomplete": 90}, {"package": "test Email track", "complete": 10, "incomplete": 90}, {"package": "Testing Stage Active -01", "complete": 60, "incomplete": 40}, {"package": "testing email pack 5", "complete": 10, "incomplete": 90}, {"package": "testing email pack 6", "complete": 10, "incomplete": 90}]
                                                chart.data = <?php echo $load_package_report = $cls_report->load_package_report($pid, $segment); ?>;
                                                chart.legend = new am4charts.Legend();
                                                chart.legend.position = "bottom";
                                                chart.scrollbarY = new am4core.Scrollbar();
                                                chart.scrollbarY.parent = chart.leftAxesContainer;


// Create axes
                                                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                                                categoryAxis.dataFields.category = "package";
                                                categoryAxis.renderer.grid.template.opacity = 0;

                                                var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
                                                valueAxis.min = 0;
                                                valueAxis.renderer.grid.template.opacity = 0;
                                                valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
                                                valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
                                                valueAxis.renderer.ticks.template.length = 10;
                                                valueAxis.renderer.line.strokeOpacity = 0.5;
                                                valueAxis.renderer.baseGrid.disabled = true;
                                                valueAxis.renderer.minGridDistance = 40;

// Create series
                                                function createSeries(field, name, color) {
                                                    var series = chart.series.push(new am4charts.ColumnSeries3D());
                                                    series.dataFields.valueX = field;
                                                    series.dataFields.categoryY = "package";
                                                    series.stacked = true;
                                                    series.name = name;
                                                    series.stroke = am4core.color(color);
                                                    series.fill = am4core.color(color);

                                                    var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                                                    labelBullet.locationX = 0.5;
                                                    labelBullet.label.text = "{valueX}";
                                                    labelBullet.label.fill = am4core.color("#fff");
                                                }
//                                                    function zoomAxis() {
//                                                        categoryAxis.zoomToCategories("swift pack-1", "tech exp attached fi");
//                                                    }
                                                createSeries("incomplete", "Incomplete", "#f18032");
                                                createSeries("complete", "Complete", "#5c9cd6");

                                                chart.events.on("ready", function () {
                                                    categoryAxis.zoomToCategories(
                                                            '<?php echo $start_z; ?>',
                                                            '<?php echo $end_z; ?>',
                                                            false,
                                                            true
                                                            );
                                                });



                                            }); // end am4core.ready()

</script>
<script>
    function login() {
        var user = 'SWIFTUSERS';
        $.post("assets/insertlog.php", {key: user}, function (data) {

        });
    }
    login();
</script>