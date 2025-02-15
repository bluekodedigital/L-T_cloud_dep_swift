<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$package_details = $cls_user->package_details($pack_id);
$vendor_details = $cls_user->vendor_details($pack_id);
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

$pcrdate = date('d-M-Y', strtotime($package_details['pm_createdate']));
if (strtotime($pcrdate) >= strtotime("24-Aug-2021")) {
    $flg = 1;
} else {
    $flg = 0;
}


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
}

//if ($deviations < 0) {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' -' . abs($deviations) . 'days'));
//} else {
//    $expdelivery = date('d-M-Y', strtotime($package_details['pm_revised_material_req'] . ' +' . abs($deviations) . 'days'));
//}
?>
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
            <!--<small>Material Req. @Site:- <span class="badge badge-pill badge-warning orange font-12 text-white ml-1"><?php //  echo date('d-M-y', strtotime($package_details['pm_revised_material_req']));    ?></span></small>-->                           
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
                    $sdate = date('Y-m-d', strtotime($package_details['pm_revised_material_req']));
                    $ltime = date('Y-m-d', strtotime($expdelivery));
                    $start = new DateTime($sdate);
                    $end = new DateTime($ltime);
                    $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';

                    echo $bdate;
                    ?>
                </span></small>                           
        </div>
        <div class=" col-md-3" id="pdp">
            <small><span class="badge badge-pill badge-secondary font-medium text-white ml-1" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="View Package Details" onclick="view_quoteDetails('<?php echo $vendor_details['Quote_id']; ?>')"><i class="fas fa-eye"></i> View Package Details</span></small>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body" >
    <div class="table-responsive">
        <table id="file_export" class="table table-bordered">
            <thead>
                <tr>
                    <th>SI.No</th>
                    <th>Stage Name</th>
                    <th>Receiver Name</th> 
                    <th>Planned</th>
                    <th>Actual Stage Received</th>
                    <th>Actual</th>                                      
                    <th>Delay</th>                                     
                    <th>Remarks</th>  
                    <!--<th>All Remarks</th>-->                                    
                </tr>
            </thead>
            <tbody>
                <?php
                $poc = 1;
//                echo $flg;
//                  echo '<br>';
//                echo $pack_id;
//                echo '<br>';
//                echo $poc;
                $repo_firstrow = $cls_user->repo_table1($pack_id, $poc, $flg);
                $tble = json_decode($repo_firstrow, true);
                $devi = $deviations;
                foreach ($tble as $key => $value) {
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td> <?php
                            $sent_back = $value['ps_stback'];
                            if ($sent_back == 1) {
                                $uid = $value['ps_sbuid'];

                                $utype = $cls_comm->fetch_usertype($uid);
                                $uname = $cls_user->fetch_uname($uid);

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
                                        echo $value['altShortName'];
                                    } else {
                                        echo $value['shot_name'];
                                    }
                                } else {
                                    echo $value['shot_name'];
                                }

                                $user_id = $value['ps_userid'];
                                $uname = $cls_user->fetch_uname($user_id);
                            }
                            ?>
                        </td>
                        <td> <?php
                            if ($value['ps_remarks'] == "") {
                                if ($value['ps_stageid'] == 17) {
                                    $check_hpc = $cls_user->check_hpc($pack_id);
                                    if ($check_hpc > 0) {

                                        echo 'MD-CEO';
                                    } else {
                                        $get_approver_name = $cls_user->get_approver_name($pack_id);


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
                                if ($value['ps_stageid'] == 17) {
                                    $check_hpc = $cls_user->check_hpc($pack_id);
                                    if ($check_hpc > 0) {

                                        echo 'MD-CEO';
                                    } else {
                                        $get_approver_name = $cls_user->get_approver_name($pack_id);


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
                            ?>
                        </td>

                        <td><span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo date('d-M-y', strtotime($value['revised_planned_date'])); ?></span></td>
                        <td>
                            <?php
                            $get_actualreceive = $cls_user->get_actualreceive($pack_id, $value['ps_stageid']);
                            if ($get_actualreceive == '0') {
                                
                            } else {
                                ?>
                                <span class="badge badge-pill badge-warning font-medium text-white ml-1">
                                    <?php echo date('d-M-y', strtotime($get_actualreceive)); ?>
                                </span>

                            <?php }
                            ?>

                        </td>
                        <td>
                            <?php
                            if ($value['ps_actualdate'] == "") {
                                if ($get_actualreceive != "") {
                                    ?>
                                    <span class="badge badge-pill badge-info brown font-medium text-white ml-1">
                                        <?php
                                        if ($devi < 0) {

                                            echo date('d-M-y', strtotime($value['revised_planned_date'] . ' - ' . abs($devi) . 'days')); //1Contracts to Ops
                                            $actual_rec = date('d-M-y', strtotime($value['revised_planned_date'] . ' - ' . abs($devi) . 'days'));
                                        } else if ($devi > 0) {
                                            $actual_rec = date('d-M-y', strtotime($value['revised_planned_date'] . ' + ' . $devi . 'days')); //1Contracts to Ops
                                            echo date('d-M-y', strtotime($value['revised_planned_date'] . ' + ' . $devi . 'days')); //1Contracts to Ops
                                        } else if ($devi == 0) {
                                            $actual_rec = date('d-M-y', strtotime($value['revised_planned_date']));
                                            echo date('d-M-y', strtotime($value['revised_planned_date']));
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
                                        echo date('d-M-y', strtotime($value['ps_actualdate']));
                                    }
                                    $actual_rec = date('d-M-y', strtotime($value['ps_actualdate']));
                                    ?>
                                </span>
                            <?php }
                            ?> 


                        </td>
                        <td>
                            <?php
                            if ($get_actualreceive != "") {


                                $sdate = date('Y-m-d', strtotime($get_actualreceive));
                                $ltime = date('Y-m-d', strtotime($actual_rec));
                                $start = new DateTime($sdate);
                                $end = new DateTime($ltime);
                                $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . ' days';


                                if ($bdate < 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-success font-medium text-white ml-1"> <?php echo $bdate;
                                    ?></span> 
                                    <?php
                                } else if ($bdate > 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-danger font-medium text-white ml-1"><?php echo '+ ' . $bdate; ?></span>
                                    <?php
                                } else if ($bdate == 0) {
                                    $devi = $bdate;
                                    ?>
                                    <span class="badge badge-pill badge-inverse font-medium text-white ml-1"><?php echo $bdate; ?></span>
                                    <?php
                                } else {
                                    $devi = $deviations;
                                }
                            }
                            ?>

                        </td>

                        <td>
                            <?php
                            if ($value['ps_remarks'] == "") {
                                echo'-';
                            } else {
//                                echo $value['ps_remarks'];
                                echo $remarks = $cls_report->prev_reamrks($value['ps_stageid'], $pack_id);
                            }
                            ?>

                        </td>
                        <td class="none">
                <center><img class="pointer" src="images/remarks.png" onclick="  new PNotify({
                                title: '<?php echo $uname . '- Remarks' ?>',
                                text: '<?php $remarks = $cls_report->prev_reamrks($value['ps_stageid'], $pack_id); ?>',
                                type: 'info',
                                buttons: {
                                    closer: true,
                                    sticker: true
                                }
                            });" ></center>
                </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>



</div>
<div class="modal-footer">
    <!--<div style="margin-left: -33% !important;    position: absolute;">-->
    <div style="left: 0% !important;    position: absolute;">
        <img src="images/l1.PNG" alt=""/>Planned
        <img src="images/l2.PNG" alt=""/>Actual
        <img src="images/i5.PNG" alt=""/>Expected
        <img src="images/l3.PNG" alt=""/>Delay
        <img src="images/a1.PNG" alt=""/> Actual Stage Received
    </div>
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>

</div>
<script>
    $('.step_no').css("background-color", "#2C249E");
    $('#stage_1').css("background-color", "#179255");
    $('#stage_1').css('text-decoration', 'underline');
    $('#file_export').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                footer: true,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },

            {
                extend: 'csv',
                footer: true,
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
        ]
    });


</script>