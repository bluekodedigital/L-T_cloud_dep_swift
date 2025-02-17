<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$package_details = $cls_user->package_details($pack_id);
$vendor_details  = $cls_user->vendor_details($pack_id);
$check_poc = $cls_user->check_poc($pack_id);
$poc = $check_poc['cm_poc_required'];
$stageid = $package_details['ps_stageid'];
$projid = $package_details['ps_projid'];
$get_deviations = $cls_report->get_deviations($pack_id, $stageid, $projid);
$deviations = $get_deviations['daysdif'];
//$deviations = $package_details['daysdif'];

$getExpectedSSApproval = $cls_user->getExpectedSSApproval($pack_id);
$SSApprovalDate = $getExpectedSSApproval['revised_planned_date'];



$getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval($pack_id);
$InitiateSSApprovalDate = $getExpectedInitiateSSApproval['revised_planned_date'];

$pcrdate = formatDate($package_details['pm_createdate'], 'd-M-Y');
if (strtotime($pcrdate) >= strtotime("24-Aug-2021")) {
    $flg = 1;
} else {
    $flg = 0;
}


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
    h4#exampleModalLabel1 {
        position: absolute;
        top: 12px;
        left: 2.5%;
        font-weight: bolder;
    }

    .pt-100 {
        padding-top: 20px;
    }

    .pb-100 {
        padding-bottom: 100px;
    }

    .section-title {
        margin-bottom: 60px;
    }

    .section-title p {
        color: #777;
        font-size: 16px;
    }

    .section-title h4 {
        text-transform: capitalize;
        font-size: 40px;
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .section-title h4:before {
        position: absolute;
        content: "";
        width: 60px;
        height: 2px;
        background-color: #ff3636;
        bottom: 0;
        left: 50%;
        margin-left: -30px;
    }

    .section-title h4:after {
        position: absolute;
        background-color: #ff3636;
        content: "";
        width: 10px;
        height: 10px;
        bottom: -4px;
        left: 50%;
        margin-left: -5px;
        border-radius: 50%;
    }

    ul.timeline-list {
        position: relative;
        margin: 0;
        padding: 0
    }

    ul.timeline-list:before {
        position: absolute;
        content: "";
        width: 2px;
        height: 100%;
        background-color: #17ABCC;
        left: 50%;
        top: 0;
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
    }

    ul.timeline-list li {
        position: relative;
        clear: both;
        list-style: none;
        /*        display: table;*/
    }

    .timeline_content {
        border: 2px solid #0bc3c3;
        background-color: #fff
    }

    ul.timeline-list li .timeline_content {
        width: 52%;
        color: #333;
        padding: 0px;
        float: left;
        text-align: center;
    }

    ul.timeline-list li:nth-child(2n) .timeline_content {
        float: right;
        text-align: center;
    }

    .timeline_content h4 {
        font-size: 14px;
        font-weight: 600;
        margin: 3px 0;
    }

    ul.timeline-list li:before {
        position: absolute;
        content: "";
        width: 25px;
        height: 25px;
        background-color: #0bc3c3;
        left: 50%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .timeline_content span {
        font-size: 12px;
        font-weight: 500;
        font-family: poppins;
        color: #fff;
    }

    .green {
        background: #0bc3c3;
    }

    .oranged {
        background: #ef8d14;
    }

    .timeline-breaker {

        color: #333;
        font-weight: 600;
        border-radius: 2px;
        margin: 0 auto;
        text-align: center;
        padding: .1em;
        line-height: 1;
        display: block;
        width: 100%;
        max-width: 55em;
        clear: both
    }

    .modal-body {
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }
    .timeline_content>table td {
    padding: 4px 2px 3px 2px !important;
    }
    .timeline_content> table th {
        background: #fff !important;
        border-top: 1px solid rgb(120 123 125 / 13%)!important;
    }
    
.timeline_content > .table-bordered td, .table-bordered th {
    border: 1px solid rgb(122 125 129 / 57%) !important;
}
.timeline_content >table.dataTable {
  margin-left: 26px !important;
}
</style>
<div class="modal-header" id="view_mh">
    <h4 class="modal-title" id="exampleModalLabel1"><?php echo $package_details['proj_name']; ?> <?php if($package_details['proj_type'] !=''){  ?> 
            <span class="blink">
            <span class='type_sty <?php echo $ptype_col; ?>'><?php echo $ptype; ?> </span>
            <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
        </span>
        <?php  } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       - <small><?php echo $package_details['pm_packagename']; ?></small>
    </h4>
    <div class="row" id="daterow" style=" font-size: 16px;">
        <div class=" col-md-3" id="pdc">
            <small>Current Status:- <span class="badge badge-pill badge-success font-12 text-white ml-1"><?php echo $package_details['shot_name']; ?></span></small>
        </div>
        <div class=" col-md-3" id="pdv" style=" margin-top: -0.8% !important; margin-left: 50% !important; ">
            <?php if ($vendor_details['sup_name'] != '') { ?><small>Vendor:- <span class="badge badge-pill badge-primary font-12 text-white ml-1"><?php echo $vendor_details['sup_name']; ?></span></small><?php } ?>
        </div>
        <div class=" col-md-3" id="pdm" style=" margin-left: 14% !important;">
            <small>Order Closing Date:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1">
                    <?php
                    echo $ssInidate;
                    ?>

                </span>
            </small>
            <!--<small>Material Req. @Site:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1"><?php //  echo formatDate($package_details['pm_revised_material_req'], 'd-M-y');      
                                                                                                                            ?></span></small>-->
        </div>
        <div class=" col-md-3" id="pde" style=" margin-left: 38% !important">
            <small>SS Approval Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1">
                    <?php
                    echo $expdelivery;
                    //                    $expe_delidate = $cls_user->expe_delidate($pack_id);
                    //                    if ($expe_delidate['ps_actualdate'] == "") {
                    //
                    //                        echo $expdelivery;
                    //                    } else {
                    //                        echo formatDate($expe_delidate['ps_actualdate'], 'd-M-y');
                    //                    }
                    ?></span></small>
        </div>
        <div class=" col-md-3" id="pdd">
            <small>Deviations:- <span class="badge badge-pill badge-dark font-12 text-white ml-1">
                    <?php
                    //    $sdate = formatDate($package_details['pm_revised_material_req'], 'Y-m-d');
                    //     $ltime = formatDate($expdelivery, 'Y-m-d');
                    //     $start = new DateTime($sdate);
                    //     $end   = new DateTime($ltime);
                    //     $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';

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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <section class="experience pt-100 pb-100" id="experience">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <ul class="timeline-list">
                                    <?php
                                    $poc = 1;
                                    // echo $flg;
                                    // echo '<br>';
                                    // echo $pack_id;
                                    // echo '<br>';
                                    // echo $poc;
                                    $repo_firstrow = $cls_user->repo_table1($pack_id, $poc, $flg, $projid);
                                    $plantarget = "";
                                    $Actualtarget = "";
                                    $tble = json_decode($repo_firstrow, true);
                                    $devi = $deviations;
                                    foreach ($tble as $key => $value) {


                                        $uid = $value['st_uid'];
                                        $pre_to_stage = $value['rs_to_stage'];
                                        //$utype = $cls_comm->fetch_usertype($uid);
                                        $uname    = $cls_user->fetch_uname($uid);

                                        $prestage = $cls_user->pre_fetch_stage($pack_id,$pre_to_stage);

                                        $sent_back = $value['st_status'];
                                        $target_day = $value['target_day'];
                                        $pack_created = formatDate($value['pm_createdate'], 'Y-m-d');
                                        $material_req = formatDate($value['pm_material_req'], 'Y-m-d');
                                        $rev_planDate = formatDate($value['revised_planned_date'], 'Y-m-d');
                                        // $rev_planDate = formatDate($value['ps_actualdate'], 'Y-m-d');
                                        if ($sent_back == 1) {
                                            $bgcolor = "oranged";
                                            $sent   = $value['shot_name'];
                                            $current_status = 'Sent back by ' . $sent . ' To ' . $prestage;
                                        } else {
                                            $bgcolor = "green";
                                            $current_status = $value['shot_name'];
                                        }
                                    ?>
                                        <li>
                                            <div class="timeline_content" style="font-size: 13px;margin-left:-61px; margin-right:-64px;">
                                                <div class="timeline-breaker <?php echo $bgcolor; ?>">
                                                    <h4> <?php echo $current_status; ?> <br />
                                                        <h4 style="color: white;">( <?php echo $uname; ?> )</h4>
                                                    </h4>
                                                </div>
                                              
                                                <h4></h4>
                                                <?php if ($value['st_stageid'] == 2) { ?>
                                                    <p>Plan Receipt:
                                                        <?php  // echo $value['st_stageid'];
                                                        $get_planrec = $cls_user->get_stage1plan($pack_id, $value['st_stageid']);
                                                        $res = json_decode($get_planrec);
                                                        //  print_r($res[0]->ps_planneddate);
                                                        if ($get_planrec == '0') {
                                                        } else {

                                                        ?>
                                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                                <?php echo $rec =  formatDate($res[0]->ps_planneddate, 'd-M-y'); ?></span>
                                                        <?php } ?>
                                                    </p>
                                                    <p style='color: orange;'>
                                                        Actual Receipt :

                                                        <?php //$plan_target  = formatDate($rec . ' + ' . $target_day . ' days', 'Y-m-d'); 
                                                        ?>
                                                        <span class="badge badge-pill badge-warning font-medium text-white ml-1">
                                                            <?php echo formatDate($res[0]->ps_actualdate, 'd-M-y'); ?>
                                                        </span>
                                                    </p>
                                                <?php } else {
                                                    if ($key >= 1) {
                                                        $preStageId = $tble[$key - 1]['st_stageid'];
                                                    }
                                                    //For Plan
                                                    $get_planreceive = $cls_user->get_planreceive($pack_id, $value['st_stageid']);
                                                    if ($get_planreceive == '0') {
                                                    } else {
                                                        if ($plantarget == '') {
                                                            $rec2 =  formatDate($get_planreceive, 'd-M-y');
                                                            $print_plan_recipt = $rec2;
                                                        } else {
                                                            $print_plan_recipt = $plantarget;
                                                        }
                                                    }
                                                    $plan_target = $cls_user->get_actualreceive($pack_id, $value['st_stageid']);

                                                   // $plan_target  = formatDate($rec2 . ' + ' . $target_day . ' days', 'Y-m-d');
                                                    $p_date = formatDate($plan_target, 'd-M-y');
                                                    $plantarget = formatDate($plan_target, 'd-M-y');
                                                    //For Actual
                                                    $get_actualreceive = $cls_user->get_actualreceive($pack_id, $value['st_stageid']);
                                                    if ($get_actualreceive == '0') {
                                                    } else {
                                                        if ($acutualtarget == '') {
                                                            $rec3 = formatDate($get_actualreceive, 'd-M-y');
                                                        } else {
                                                            $rec3 = $acutualtarget;
                                                        }
                                                    }
                                                    $get_actualtarget = $cls_user->get_actualtarget($pack_id, $value['st_stageid']);
                                                    if ($get_actualtarget == '0') {
                                                    } else {
                                                        $act_target = formatDate($get_actualtarget, 'd-M-y');
                                                    }
                                                    $acutualtarget = formatDate($act_target, 'd-M-y');


                                                ?>
                                                    <?php // for  Against Plan

                                                    if ($get_planreceive != "") {


                                                        $sdate = formatDate($p_date, 'Y-m-d');
                                                        $ltime = formatDate($act_target, 'Y-m-d');
                                                        $start = new DateTime($sdate);
                                                        $end = new DateTime($ltime);
                                                        $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';


                                                        if ($bdate < 0) {
                                                            $devi = $bdate;
                                                    ?>
                                                            <?php
                                                            $Planday = "<span class='badge badge-pill badge-success  font-medium text-white '>  $bdate </span>"; ?>
                                                        <?php
                                                        } else if ($bdate > 0) {
                                                            $devi = $bdate;
                                                        ?>
                                                            <?php
                                                            $Planday = " <span class='badge badge-pill badge-danger font-medium text-white '> + $bdate</span>"; ?>
                                                        <?php
                                                        } else if ($bdate == 0) {
                                                            $devi = $bdate;
                                                        ?>
                                                            <?php
                                                            $Planday = "<span class='badge badge-pill badge-inverse font-medium text-white '>  $bdate </span>"; ?>
                                                    <?php
                                                        } else {
                                                            $devi = $deviations;
                                                        }
                                                    }
                                                    ?>

                                                    <?php   // for  stage delay 
                                                    if ($get_actualreceive != "") {


                                                        $sdate = formatDate($rec3, 'Y-m-d');
                                                        $ltime = formatDate($act_target, 'Y-m-d');
                                                        $start = new DateTime($sdate);
                                                        $end = new DateTime($ltime);
                                                        $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';


                                                        if ($bdate < 0) {
                                                            $devi = $bdate;
                                                    ?>
                                                            <?php $staydelay = "<span class='badge badge-pill badge-success font-medium text-white'> $bdate </span>"; ?>
                                                        <?php
                                                        } else if ($bdate > 0) {
                                                            $devi = $bdate;
                                                        ?>
                                                            <?php $staydelay = "<span class='badge badge-pill badge-danger font-medium text-white'>+ $bdate </span>"; ?>
                                                        <?php
                                                        } else if ($bdate == 0) {
                                                            $devi = $bdate;
                                                        ?>
                                                            <?php $staydelay = "<span class='badge badge-pill badge-inverse font-medium text-white '> $bdate </span>"; ?>
                                                    <?php
                                                        } else {
                                                            $devi = $deviations;
                                                        }
                                                    }

                                                    ?>
                                               

                                                    <table class='table-bordered display compact dataTable no-footer'>
                                                    <tr>
                                                      <th colspan="4">Planned</th>
                                                      <th colspan="">Delay</th>
                                                    <tr>
                                                    <tr>
                                                      <td>Receipt </td><td><span class="badge badge-pill badge-primary font-medium text-white"><?php echo $print_plan_recipt ?></span> </td>
                                                      <td>Target  </td><td><span class="badge badge-pill badge-primary font-medium text-white "><?php echo $p_date; ?></span> </td>
                                                      <td ></td>
                                                    </tr>
                                                   <tr>
                                                      <th colspan="4" style='color: orange;' >Actual</th>
                                                      <th colspan=""></th>
                                                    <tr>
                                                   <tr >
                                                      <td>Receipt </td><td><span class="badge badge-pill badge-info font-medium text-white"><?php echo $rec3; ?></span> </td>
                                                      <td>Complete </td><td><span class="badge badge-pill badge-info font-medium text-white "><?php echo $act_target; ?></span> </td> <td> <?php echo $Planday; ?></td>
                                                  
                                                    </tr>
                                                
                                                </table>
                                                <div style="margin-left: 8%;text-align: left;">
                                                <p > <?php
                                                        if ($value['st_remarks'] == "") {
                                                            echo '-';
                                                        } else {
                                                        ?>
                                                            <b>Remarks</b> :
                                                        <?php echo $remarks = $value['st_remarks'];
                                                        } ?>
                                                    </p>
                                                    </div>
                                            </div>
                                        </li>
                                <?php }
                                            } ?>


                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>