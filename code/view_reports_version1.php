<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = mssql_escape($_POST['key']);
$package_details = $cls_user->package_details_version1($pack_id);
$vendor_details = $cls_user->vendor_details_version1($pack_id);
$check_poc = $cls_user->check_poc_version1($pack_id);
 $poc = $check_poc['cm_poc_required'];
 $stageid = $package_details['ps_stageid'];
$projid = $package_details['ps_projid'];

//$get_deviations = $cls_report->get_deviations_latest($pack_id, $stageid, $projid);
$get_deviations = $cls_report->get_deviations_version1($pack_id, $stageid, $projid);

$deviations = $get_deviations['daysdif'];
$get_po_wo_app = $cls_user->get_po_wo_app_version1($pack_id);

if ($get_po_wo_app != "") {
    $po_wo = $get_po_wo_app['po_wo_status'];
} else {
    $po_wo = 0;
}

$pcrdate = formatDate($package_details['pm_createdate'], 'd-M-Y');

if (strtotime($pcrdate) >= strtotime("24-Aug-2021")) {
    $flg = 1;
} else {
    $flg = 0;
}

// echo $po_wo;
//  if ($value1['so_hw_sw'] == 1) {
//        $po_wo = 'WO';
//    } else if ($value1['so_hw_sw'] == 2) {
//        $po_wo = 'PO';
//    } else {
//        $po_wo = 'PO+WO';
//    }
//$deviations = $package_details['daysdif'];
// modification

$getExpectedSSApproval = $cls_user->getExpectedSSApproval($pack_id);
$SSApprovalDate = formatDate($getExpectedSSApproval['revised_planned_date'], 'Y-m-d');
$psActualDate = formatDate($getExpectedSSApproval['ps_actualdate'], 'Y-m-d');


$getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval($pack_id);
$InitiateSSApprovalDate = formatDate($getExpectedInitiateSSApproval['revised_planned_date'], 'Y-m-d');
$psActualInitiateDate = formatDate($getExpectedInitiateSSApproval['ps_actualdate'], 'Y-m-d');

if ($psActualDate == "") {
    $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' -' . abs($deviations) . ' days'));
} else {
    $expdelivery = date('d-M-Y', strtotime($psActualDate));
}

if ($psActualInitiateDate == "") {
    $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' -' . abs($deviations) . ' days'));
} else {
    $ssInidate = date('d-M-Y', strtotime($psActualInitiateDate));
}

/* $getExpectedSSApproval = $cls_user->getExpectedSSApproval_v1($pack_id);
$SSApprovalDate = $getExpectedSSApproval['revised_planned_date'];


$getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval_v1($pack_id);
$InitiateSSApprovalDate = $getExpectedInitiateSSApproval['revised_planned_date'];


if ($deviations < 0) {

    if (trim($getExpectedSSApproval['ps_actualdate']) == "") {
        $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' -' . abs($deviations) . 'days'));
    } else {
        $expdelivery = date('d-M-Y', strtotime($getExpectedSSApproval['ps_actualdate']));
    }

    if (trim($getExpectedInitiateSSApproval['ps_actualdate']) == "") {
        $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' -' . abs($deviations) . 'days'));
    } else {
        $ssInidate = date('d-M-Y', strtotime($getExpectedInitiateSSApproval['ps_actualdate']));
    }
} else {


    if (trim($getExpectedSSApproval['ps_actualdate']) == "") {
        $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' +' . abs($deviations) . 'days'));
    } else {
        $expdelivery = date('d-M-Y', strtotime($getExpectedSSApproval['ps_actualdate']));
    }

    if (trim($getExpectedInitiateSSApproval['ps_actualdate']) == "") {
        $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' +' . abs($deviations) . 'days'));
    } else {
        $ssInidate = date('d-M-Y', strtotime($getExpectedInitiateSSApproval['ps_actualdate']));
    }
} */
//if ($deviations < 0) {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' -' . abs($deviations) . 'days'));
//} else {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' +' . abs($deviations) . 'days'));
//}
if ($package_details['proj_type'] == 1) {
    $ptype = "CO";
    $ptype_col = "type_gr";
} else if ($package_details['proj_type'] == 2) {
    $ptype = "NCO";
    $ptype_col = "type_or";
} else {
    $ptype = "";
    $ptype_col = "";
}
?>
<style>
    .badge-info {
        background-color: #2cabe3 !important;
    }
</style>
<div class="modal-header" id="view_mh">
    <h4 class="modal-title" id="exampleModalLabel1"><?php echo $package_details['proj_name']; ?>
    <?php if($package_details['proj_type'] !=''){  ?> 
            <span class="blink">
            <span class='type_sty <?php echo $ptype_col; ?>'> <?php echo $ptype; ?> </span>
            <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
        </span>
        <?php  } ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        - <small><?php echo $package_details['pm_packagename']; ?></small>
    </h4>
    <div class="row" id="daterow" style=" font-size: 16px;">
        <div class=" col-md-3" id="pdc">
            <small>Current Status:- <span class="badge badge-pill badge-success font-12 text-white ml-1"><?php echo $package_details['shot_name']; ?></span></small>
        </div>
        <?php if ($vendor_details['sup_name'] != "") { ?>
            <div class=" col-md-3" id="pdv" style=" margin-top: -0.8% !important; margin-left: 50% !important; ">
                <small>Vendor:- <span class="badge badge-pill badge-primary font-12 text-white ml-1"><?php echo $vendor_details['sup_name']; ?></span></small>
            </div>
        <?php }
        ?>

        <div class=" col-md-3" id="pdm" style=" margin-left: 14% !important;">
            <small>Expected order closing:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1">
                    <!--<small>Material Req. @Site:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1">-->
                    <?php
                    echo $ssInidate;
                    //                echo date('d-M-y', strtotime($package_details['pm_revised_material_req'])); 

                    ?>
                </span></small>
        </div>
        <div class=" col-md-3" id="pde" style=" margin-left: 38% !important">
            <small>Expected SS Approval:- <span class="badge badge-pill badge-info font-12 text-white ml-1">
                    <?php

                    echo $expdelivery;
                    //                    $expe_delidate = $cls_user->expe_delidate($pack_id);
                    //                    if ($expe_delidate['ps_actualdate'] == "") {
                    //
                    //                        echo $expdelivery;
                    //                    } else {
                    //                        echo date('d-M-y', strtotime($expe_delidate['ps_actualdate']));
                    //                    }
                    ?></span></small>
        </div>
        <div class=" col-md-3" id="pdd">
            <small>Deviations:- <span class="badge badge-pill badge-dark font-12 text-white ml-1">
                    <?php
                    // $sdate = date('Y-m-d', strtotime($package_details['pm_revised_material_req']));
                    // $ltime = date('Y-m-d', strtotime($expdelivery));
                    // $start = new DateTime($sdate);
                    // $end = new DateTime($ltime);
                    // $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';

                    echo $deviations;
                    ?>
                </span></small>
        </div>
        <!-- <div class=" col-md-3" id="pdp">
            <small><span class="badge badge-pill badge-secondary font-medium text-white ml-1" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="View Package Details" onclick="view_quoteDetails('<?php echo $vendor_details['Quote_id']; ?>')"><i class="fas fa-eye"></i> View Package Details</span></small>
        </div> -->
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <!-- Smart Wizard -->
    <div id="wizard" class="form_wizard wizard_horizontal">
        <ul class="wizard_steps">
            <?php
            $repo_firstrow = $cls_user->repo_firstrow_version1($pack_id, $flg);
            $first = json_decode($repo_firstrow, true);
            $devi = $deviations;
            foreach ($first as $key => $value) {
                if($value['active']==0 && $value['ps_actualdate']!='') {
                    $completed='completed';
                }else{
                    $completed='';
                }
                 ?>
                <li>
                    <a href="#step-<?php echo $key + 1; ?>">
                    <?php $sent_back = $value['ps_stback'];
                                if ($sent_back == 1) {
                                    $sent = $value['shot_name'];
                                   
                                    $status = 'Sent back by ' . $sent;
                                    $bgcolclass='sendback';
                                    //echo $status;
                                } else {
                                    // if ($value['stage_id'] == 5) {
                                    if ($flg == 0) {
                                        $status =  $value['altShortName'];
                                    } else {
                                        $status =  $value['shot_name'];
                                    }
                                    // } else {
                                    //     echo $value['shot_name'];
                                    // }
                                   // echo   $value['stage_id'];
                                    $bgcolclass='active';
                                }
                                ?>
                        <span class="step_no  <?php echo $completed;?> <?php echo $bgcolclass ?>" id="stage_<?php echo $value['active'] ?>"><?php echo $key + 1;   ?></span>
                        <div class="container" style=" font-size: 12px;">
                            <span class="step_descr">
                            <?php echo  $status ;?>
                            </span>
                        </div>
                        <div class="container">
                            <p class="palnned">
                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php formatDate($value['revised_planned_date'], 'd-M-y'); ?></span>
                            </p>
                            <?php $get_actualreceive = $cls_user->get_actualreceive_version1($pack_id, $value['ps_stageid']);
                            if ($get_actualreceive == '0') {
                            } else { ?>
                                <p class="actual_rec"><span class="badge badge-pill badge-warning font-medium text-white ml-1">
                                        <?php echo formatDate($get_actualreceive, 'd-M-y'); ?>
                                    </span>
                                </p>
                            <?php } ?>
                            <p class="actual">

                                <?php if ($value['ps_actualdate'] != "") { ?>
                                    <span class="badge badge-pill badge-info font-medium text-white ml-1">
                                       <?php echo formatDate($value['ps_actualdate'], 'd-M-y'); ?>
                                    <?php } ?>

                            </p>
                            <p class="deviations">
                                <?php
                                if ($stageid >= $value['ps_stageid']) {
                                    if ($value['days'] < 0) {
                                        $devi = $value['days'];
                                ?>
                                        <span class="badge badge-pill badge-success font-medium text-white ml-1"> <?php echo $value['days'];
                                                                                                                    ?></span>
                                    <?php
                                    } else if ($value['days'] > 0) {
                                        $devi = $value['days'];
                                    ?>
                                        <span class="badge badge-pill badge-danger font-medium text-white ml-1"><?php echo '+ ' . $value['days']; ?></span>
                                    <?php
                                    } else if ($value['days'] = 0) {
                                        $devi = $value['days'];
                                    ?>
                                        <span class="badge badge-pill badge-inverse font-medium text-white ml-1"><?php echo '+ ' . $value['days']; ?></span>
                                <?php
                                    } else {
                                        $devi = $deviations;
                                    }
                                }
                                ?>


                            </p>
                            <?php
                            $get_actualreceive = $cls_user->get_actualreceive_version1($pack_id, $value['ps_stageid']);
                            if ($get_actualreceive == '0') {
                            ?>

                            <?php } else { ?>
                                <p class="deviations1">
                                    <?php
                                    $sdate = formatDate($get_actualreceive, 'Y-m-d');
                                    $ltime = formatDate($value['ps_actualdate'], 'Y-m-d');
                                    $start = new DateTime($sdate);
                                    $end = new DateTime($ltime);
                                    $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . '';

                                    if ($bdate > 0) {
                                    ?>
                                        <span class=" text-danger"><?php echo $bdate; ?></span>
                                        <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                                    <?php } ?>

                                </p>


                            <?php } ?>


                        </div>

                    </a>
                </li>

            <?php
            }
            ?>

        </ul>

    </div>

    <div id="wizard" class="form_wizard wizard_horizontal">
        <ul class="wizard_steps">

            <?php
            $repo_secondrow = $cls_user->repo_secondrow_version1($pack_id, $poc);
            // if ($po_wo == 0) {
            //     $repo_secondrow = $cls_user->repo_secondrow($pack_id, $poc);
            // } else if ($po_wo == 1) {
            //     $repo_secondrow = $cls_user->repo_secondrow_wo($pack_id, $poc);
            // } else if ($po_wo == 2) {
            //     $repo_secondrow = $cls_user->repo_secondrow_po($pack_id, $poc);
            // } else if ($po_wo == 3) {
            //     $repo_secondrow = $cls_user->repo_secondrow($pack_id, $poc);
            // } else {
            //     $repo_secondrow = $cls_user->repo_secondrow($pack_id, $poc);
            // }

            $second = json_decode($repo_secondrow, true);

            foreach ($second as $key => $value) {
                if($value['active']==0 && $value['ps_actualdate']!='') {
                    $completed='completed';
                }else{
                    $completed='';
                }
            ?>
                <li>
                    <a href="#step-<?php echo $key + 10 + 1; ?>">
                    <?php $sent_back = $value['ps_stback'];
                                if ($sent_back == 1) {
                                    $sent = $value['shot_name'];
                                   
                                    $status = 'Sent back by ' . $sent;
                                    $bgcolclass='sendback';
                                    //echo $status;
                                } else {
                                    // if ($value['stage_id'] == 5) {
                                    if ($flg == 0) {
                                        $status =  $value['altShortName'];
                                    } else {
                                        $status =  $value['shot_name'];
                                    }
                                    // } else {
                                    //     echo $value['shot_name'];
                                    // }
                                  
                                    $bgcolclass='active';
                                }
                                ?>
                        <span class="step_no <?php echo $completed; ?> <?php echo $bgcolclass ?>" id="stage_<?php echo $value['active'] ?>"><?php echo $key + 10 + 1; ?></span>
                        <div class="container" style=" font-size: 12px;">
                            <span class="step_descr">
                            <?php echo  $status ;?>
                            </span>
                        </div>
                        <div class="container">
                            <p class="palnned">
                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo formatDate($value['revised_planned_date'], 'd-M-y'); ?></span>
                            </p>
                            <?php $get_actualreceive = $cls_user->get_actualreceive_version1($pack_id, $value['ps_stageid']);
                            if ($get_actualreceive == '0') {
                            } else { ?>
                                <p class="actual_rec"><span class="badge badge-pill badge-warning font-medium text-white ml-1">
                                        <?php echo formatDate($get_actualreceive, 'd-M-y'); ?>
                                    </span>
                                </p>
                            <?php } ?>
                            <p class="actual">

                                <?php if ($value['ps_actualdate'] != "") { ?>
                                    <span class="badge badge-pill badge-info font-medium text-white ml-1">
                                       <?php echo formatDate($value['ps_actualdate'], 'd-M-y'); ?>
                                    <?php } ?>

                            </p>
                            <p class="deviations">
                                <?php
                                if ($stageid >= $value['ps_stageid']) {
                                    if ($value['days'] < 0) {
                                        $devi = $value['days'];
                                ?>
                                        <span class="badge badge-pill badge-success font-medium text-white ml-1"> <?php echo $value['days'];
                                                                                                                    ?></span>
                                    <?php
                                    } else if ($value['days'] > 0) {
                                        $devi = $value['days'];
                                    ?>
                                        <span class="badge badge-pill badge-danger font-medium text-white ml-1"><?php echo '+ ' . $value['days']; ?></span>
                                    <?php
                                    } else if ($value['days'] = 0) {
                                        $devi = $value['days'];
                                    ?>
                                        <span class="badge badge-pill badge-inverse font-medium text-white ml-1"><?php echo '+ ' . $value['days']; ?></span>
                                <?php
                                    } else {
                                        $devi = $deviations;
                                    }
                                }
                                ?>


                            </p>
                            <?php
                            $get_actualreceive = $cls_user->get_actualreceive_version1($pack_id, $value['ps_stageid']);
                            if ($get_actualreceive == '0') {
                            ?>

                            <?php } else { ?>
                                <p class="deviations1">
                                    <?php
                                    $sdate = formatDate($get_actualreceive, 'Y-m-d');
                                    $ltime = formatDate($value['ps_actualdate'], 'Y-m-d');
                                    $start = new DateTime($sdate);
                                    $end = new DateTime($ltime);
                                    $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . '';

                                    if ($bdate > 0) {
                                    ?>
                                        <span class=" text-danger"><?php echo $bdate; ?></span>
                                        <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                                    <?php } ?>

                                </p>


                            <?php } ?>


                        </div>
                    </a>
                </li>
            <?php
            }
            ?>

        </ul>

    </div>

    <!-- End SmartWizard Content -->


</div>
<div class="modal-footer">
    <div style="left: 0% !important;    position: absolute;">
        <!--<div style="margin-left: -33% !important;    position: absolute;">-->
        <img src="images/l1.PNG" alt="" />Planned
        <img src="images/l2.PNG" alt="" />Actual
        <img src="images/i5.PNG" alt="" />Expected
        <img src="images/l3.PNG" alt="" />Delay
        <img src="images/a1.PNG" alt="" /> Actual Stage Received
    </div>
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>

</div>
<script>
    $('.step_no').css("background-color", "#2C249E");
    $('#stage_1').css("background-color", "#FF751A");
    $('.sendback').css("background-color", "#ff5050");
   //  $('.active').css("background-color", "#179255");
   $('.completed').css("background-color", "#179255");
    $('#stage_1').css('text-decoration', 'underline');
</script>