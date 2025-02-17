<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$package_details = $cls_user->package_details_version1($pack_id);
$vendor_details = $cls_user->vendor_details_version1($pack_id);
$check_poc = $cls_user->check_poc_version1($pack_id);
$poc = $check_poc['cm_poc_required'];
$stageid = $package_details['ps_stageid'];
$projid = $package_details['ps_projid'];
$get_deviations = $cls_report->get_deviations_version1($pack_id, $stageid, $projid);
$deviations = $get_deviations['daysdif'];
//$deviations = $package_details['daysdif'];

/* $getExpectedSSApproval = $cls_user->getExpectedSSApproval_v1($pack_id);
$SSApprovalDate = $getExpectedSSApproval['revised_planned_date'];



$getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval_v1($pack_id);
$InitiateSSApprovalDate = $getExpectedInitiateSSApproval['revised_planned_date']; */

$getExpectedSSApproval = $cls_user->getExpectedSSApproval($pack_id);
$SSApprovalDate = formatDate($getExpectedSSApproval['revised_planned_date'], 'Y-m-d');
$psActualDate = formatDate($getExpectedSSApproval['ps_actualdate'], 'Y-m-d');


$getExpectedInitiateSSApproval = $cls_user->getExpectedInitiateSSApproval($pack_id);
$InitiateSSApprovalDate = formatDate($getExpectedInitiateSSApproval['revised_planned_date'], 'Y-m-d');
$psActualInitiateDate = formatDate($getExpectedInitiateSSApproval['ps_actualdate'], 'Y-m-d');

$pcrdate = formatDate($package_details['pm_createdate'], 'd-M-Y');
if (strtotime($pcrdate) >= strtotime("24-Aug-2021")) {
    $flg = 1;
} else {
    $flg = 0;
}

if ($psActualDate == "") {
    $expdelivery = date('d-M-Y', strtotime($SSApprovalDate . ' -' . abs($deviations) . ' days'));
} else {
    $expdelivery = formatDate($psActualDate, 'd-M-Y');
}

if ($psActualInitiateDate == "") {
    $ssInidate = date('d-M-Y', strtotime($InitiateSSApprovalDate . ' -' . abs($deviations) . ' days'));
} else {
    $ssInidate = formatDate($psActualInitiateDate, 'd-M-Y');
}


/* if ($deviations < 0) {

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
} */

//if ($deviations < 0) {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' -' . abs($deviations) . 'days'));
//} else {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' +' . abs($deviations) . 'days'));
//}
?>
<style>
    h4#exampleModalLabel1 {
    position: absolute;
    top: 12px;
    left: 2.5%;
    font-weight: bolder;
}
    .pt-100{
        padding-top:20px;
    }
    .pb-100{
        padding-bottom:100px;
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
        background-color:#fff
    }
    ul.timeline-list li .timeline_content {
        width: 45%;
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
        margin: 5px 0;
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
    .timeline-breaker {
  background: #0bc3c3;
  color: #fff;
  font-weight: 600;
  border-radius: 2px;
  margin: 0 auto;
  text-align: center;
  padding: .6em;
  line-height: 1;
  display: block;
  width: 100%;
  max-width: 15em;
  clear: both
}
.modal-body {
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}
</style>
<div class="modal-header" id="view_mh">
    <h4 class="modal-title" id="exampleModalLabel1"><?php echo $package_details['proj_name']; ?> - <small><?php echo $package_details['pm_packagename']; ?></small></h4> 
    <div class="row" id="daterow" style=" font-size: 16px;">
        <div class=" col-md-3" id="pdc">
            <small>Current Status:- <span class="badge badge-pill badge-success font-12 text-white ml-1"><?php echo $package_details['shot_name']; ?></span></small>                           
        </div>
        <div class=" col-md-3" id="pdv" style=" margin-top: -0.8% !important; margin-left: 17% !important; ">
            <small>Vendor:- <span class="badge badge-pill badge-primary font-12 text-white ml-1"><?php echo $vendor_details['sup_name']; ?></span></small>                           
        </div>
        <div class=" col-md-3" id="pdm" style=" margin-left: 14% !important;">
            <small>Expected order closing:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1">
                    <?php
                    echo $ssInidate;
                    ?>

                </span>
            </small>                           
            <!--<small>Material Req. @Site:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1"><?php //  echo formatDate($package_details['pm_revised_material_req'], 'd-M-y');      ?></span></small>-->                           
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
//                        echo formatDate($expe_delidate['ps_actualdate'], 'd-M-y');
//                    }
                    ?></span></small>                           
        </div>
        <div class=" col-md-3" id="pdd">
            <small>Deviations:- <span class="badge badge-pill badge-dark font-12 text-white ml-1">
                    <?php
                    $sdate = formatDate($package_details['pm_revised_material_req'], 'Y-m-d');
                    $ltime = formatDate($expdelivery, 'Y-m-d');
                    $start = new DateTime($sdate);
                    $end = new DateTime($ltime);
                    $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';

                    echo $bdate;
                    ?>
                </span></small>                           
        </div>
        <!-- <div class=" col-md-3" id="pdp">
            <small><span class="badge badge-pill badge-secondary font-medium text-white ml-1" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="View Package Details" onclick="view_quoteDetails('<?php echo $vendor_details['Quote_id']; ?>')"><i class="fas fa-eye"></i> View Package Details</span></small>
        </div> -->
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body" >
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
//                echo $flg;
//                  echo '<br>';
//                echo $pack_id;
//                echo '<br>';
//                echo $poc;
                                    $repo_firstrow = $cls_user->repo_table1_version1($pack_id, $poc, $flg, $projid);
                                    $tble = json_decode($repo_firstrow, true);
                                    $devi = $deviations;
                                    foreach ($tble as $key => $value) {
                                        ?>
                                        <li>
                                            <div class="timeline_content">
                                                 <div class="timeline-breaker"><span><?php
                                                    $uid = $value['st_uid'];

                                                    $utype = $cls_comm->fetch_usertype_v1($uid);
                                                    $uname = $cls_user->fetch_uname_v1($uid);


                                                    if ($value['st_remarks'] == "") {
                                                        if ($value['st_stageid'] == 17) {
                                                            $check_hpc = $cls_user->check_hpc_version1($pack_id);
                                                            if ($check_hpc > 0) {

                                                                echo 'MD-CEO';
                                                            } else {
                                                                $get_approver_name = $cls_user->get_approver_name_v1($pack_id);


                                                                if ($get_approver_name['hpc_app'] == 1) {

                                                                    echo 'MD-CEO';
                                                                } else {
                                                                    echo $get_approver_name['dep_name'];
                                                                }
                                                            }
                                                        } else {
                                                            echo $uname;
                                                        }
                                                    } else {
                                                        if ($value['st_stageid'] == 17) {
                                                            $check_hpc = $cls_user->check_hpc_version1($pack_id);
                                                            if ($check_hpc > 0) {

                                                                echo 'MD-CEO';
                                                            } else {
                                                                $get_approver_name = $cls_user->get_approver_name_v1($pack_id);


                                                                if ($get_approver_name['hpc_app'] == 1) {

                                                                    echo 'MD-CEO';
                                                                } else {
                                                                    echo $get_approver_name['dep_name'];
                                                                }
                                                            }
                                                        } else {
                                                            echo $uname;
                                                        }
                                                    }
                                                    ?></span></div>
                                                <h4><?php
                                                    $sent_back = $value['ps_stback'];
                                                    if ($sent_back == 1) {


                                                        if ($utype == 10) {
                                                            $sent = 'Tech SPOC';
                                                        } else if ($utype == 11) {
                                                            $sent = 'Tech Expert';
                                                        } else if ($utype == 12) {
                                                            $sent = 'Tech CTO';
                                                        } else if ($utype == 14) {
                                                            $sent = 'SCM SPOC';
                                                        } else if ($utype == 15) {
                                                            $sent = 'OM SPOC';
                                                        } else if ($utype == 18) {
                                                            $sent = 'Tech Reviewer';
                                                        } else if ($utype == 5) {
                                                            $sent = 'OPS';
                                                        } else if ($utype == 2) {
                                                            $sent = 'Buyer';
                                                        }
                                                        $status = 'Sent back by ' . $sent;
                                                        echo $status;
                                                    } else {
//                                echo $value['shot_name'];

                                                        if ($value['stage_id'] == 5) {
                                                            if ($flg == 0) {
                                                                echo $value['shot_name'];
                                                            } else {
                                                                echo $value['shot_name'];
                                                            }
                                                        } else {
                                                            echo $value['shot_name'];
                                                        }

                                                        $user_id = $value['st_uid'];
                                                        $uname = $cls_user->fetch_uname($user_id);
                                                    }
                                                    ?></h4>
                                                
                                                <p>Planned : <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo formatDate($value['revised_planned_date'], 'd-M-y'); ?></span>
                                                     Received : <?php
                                                    $get_actualreceive = $cls_user->get_actualreceive_version1($pack_id, $value['st_stageid']);
                                                    if ($get_actualreceive == '0') {
                                                        
                                                    } else {
                                                        ?>
                                                        <span class="badge badge-pill badge-warning font-medium text-white ml-1">
                                                            <?php echo formatDate($get_actualreceive, 'd-M-y'); ?>
                                                        </span>

                                                    <?php }
                                                    ?>
                                                </p>
                                                <p>Actual :   <?php
                            if ($value['ps_actualdate'] == "") {
                                if ($get_actualreceive != "") {
                                    ?>
                                    <span class="badge badge-pill badge-info brown font-medium text-white ml-1">
                                        <?php
                                        if ($devi < 0) {

                                            echo date('d-M-y', strtotime(formatDate($value['revised_planned_date'], 'Y-m-d') . ' - ' . abs($devi) . 'days')); //1Contracts to Ops
                                            $actual_rec = date('d-M-y', strtotime(formatDate($value['revised_planned_date'], 'Y-m-d') . ' - ' . abs($devi) . 'days'));
                                        } else if ($devi > 0) {
                                            $actual_rec = date('d-M-y', strtotime(formatDate($value['revised_planned_date'], 'Y-m-d') . ' - ' . abs($devi) . 'days')); //1Contracts to Ops
                                            echo date('d-M-y', strtotime(formatDate($value['revised_planned_date'], 'Y-m-d') . ' - ' . abs($devi) . 'days')); //1Contracts to Ops
                                        } else if ($devi == 0) {
                                            $actual_rec = formatDate(formatDate($value['revised_planned_date'], 'Y-m-d', 'd-M-y'));
                                            echo formatDate(formatDate($value['revised_planned_date'], 'Y-m-d', 'd-M-y'));
                                        }
                                        ?> 
                                    </span>
                                    <?php
                                }
                            } else {
                                ?>
                                <span class="badge badge-pill badge-info font-medium text-white ml-1">
                                    <?php
                                    if ($value['ps_actualdate'] != "") {
                                        echo formatDate($value['ps_actualdate'], 'd-M-y');
                                    }
                                    $actual_rec = formatDate($value['ps_actualdate'], 'd-M-y');
                                    ?>
                                </span>
                            <?php }
                            ?> 
                                                    Delay :  <?php
                            if ($get_actualreceive != "") {


                                $sdate = formatDate($get_actualreceive, 'Y-m-d');
                                $ltime = formatDate($actual_rec, 'Y-m-d');
                                $start = new DateTime($sdate);
                                $end = new DateTime($ltime);
                                $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24));


                                if ($bdate < 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-success font-medium text-white ml-1"> <?php echo $bdate . ' days';
                                    ?></span> 
                                    <?php
                                } else if ($bdate > 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-danger font-medium text-white ml-1"><?php echo '+ ' . $bdate . ' days'; ?></span>
                                    <?php
                                } else if ($bdate == 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-inverse font-medium text-white ml-1"><?php echo $bdate . ' days'; ?></span>
                                    <?php
                                } else {
                                    $devi = $deviations;
                                }
                            }
                            ?></p>             
                                                <p> <?php
                            if ($value['st_remarks'] == "") {
                                echo'-';
                            } else {
                                    ?>
                                                    <b>Remarks</b>:<?php
                                echo $remarks = $value['st_remarks'];
                            }
                            ?></p>
                                                
                                                
                                            </div>
                                        </li>
                                    <?php } ?>

                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
