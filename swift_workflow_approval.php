<?php
include 'config/inc.php';

if ($_SESSION['milcom'] == '1') {
    $segment = '38';
} else {
    $segment = $_SESSION['tech_seg'];
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
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
$generate_token= generate_token();
?>
<style>
    .form-control {
        height: calc(1em + 0.75rem + 6px) !important;
        margin-bottom: 3px !important;
    }

    .flag_checkbox:after {
        content: " ";
        background-color: #2cd07e;
        display: inline-block;
        border: 1px solid #087e11;
        visibility: visible;
    }

    .flag_checkbox:checked:after {
        content: "\2714";
        box-shadow: 0px 2px 4px rgba(155, 155, 155, 0.15);
        border-radius: 3px;
        height: 15px;
        display: block;
        width: 15px;
        text-align: center;
        font-size: 11px;
        color: white;
    }

    input[type=checkbox]+label {
        display: block;
        margin: 0.2em;
        cursor: pointer;
        padding: 0.2em;
        margin-top: -3px;
        margin-left: -3px;
    }

    input[type=checkbox] {
        display: none;
    }

    input[type=checkbox]+label:before {
        content: "\2714";
        border: 0.1em solid #000;
        border-radius: 0.2em;
        display: inline-block;
        width: 1.5em;
        height: 1.5em;
        padding-left: 0.2em;
        padding-bottom: 0.3em;
        margin-right: 0.2em;
        vertical-align: bottom;
        color: transparent;
        transition: .2s;
    }

    input[type=checkbox]+label:active:before {
        transform: scale(0);
    }

    input[type=checkbox]:checked+label:before {
        background-color: MediumSeaGreen;
        border-color: MediumSeaGreen;
        color: #fff;
    }

    input[type=checkbox]:disabled+label:before {
        transform: scale(1);
        border-color: #aaa;
    }

    input[type=checkbox]:checked:disabled+label:before {
        transform: scale(1);
        background-color: #bfb;
        border-color: #bfb;
    }
</style>
<style>
    ._table {
        width: 100%;
        border-collapse: collapse;
        margin-left: -7%;
    }

    ._table :is(th, td) {
        border: 1px solid #0002;
        padding: 3px 5px;
    }

    /* form field design start */
    .form_control {
        border: 1px solid #0002;
        background-color: transparent;
        outline: none;
        padding: 8px 12px;
        font-family: 1.2rem;
        width: 100%;
        color: #333;
        font-family: Arial, Helvetica, sans-serif;
        transition: 0.3s ease-in-out;
    }

    .form_control::placeholder {
        color: inherit;
        opacity: 0.5;
    }

    .form_control:is(:focus, :hover) {
        box-shadow: inset 0 1px 6px #0002;
    }

    /* form field design end */


    .success {
        background-color: #24b96f !important;
    }

    .warning {
        background-color: #ebba33 !important;
    }

    .primary {
        background-color: #259dff !important;
    }

    .secondery {
        background-color: #00bcd4 !important;
    }

    .danger {
        background-color: #ff5722 !important;
    }

    .action_container {
        display: inline-flex;
    }

    .action_container>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 2px 5px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container>*+* {
        border-left: 1px solid #fff5;
    }

    .action_container>*:hover {
        filter: hue-rotate(-20deg) brightness(0.97);
        transform: scale(1.05);
        border-color: transparent;
        box-shadow: 0 2px 10px #0004;
        border-radius: 2px;
    }

    .action_container>*:active {
        transition: unset;
        transform: scale(.95);
    }
    
@-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
    text-decoration: blink;
    -webkit-animation-name: blinker;
    -webkit-animation-duration: 0.6s;
    -webkit-animation-iteration-count:infinite;
    -webkit-animation-timing-function:ease-in-out;
    -webkit-animation-direction: alternate;
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
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">WorkFlow</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter_wf(this.value, '4')" required="">
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
                    // $result = $cls_comm->techspoc_proj_filter($seg);
                    $result = $cls_report->select_filterprojects_seg2($seg, $ptid);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                            <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
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
                    <div class="card-body" >
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" style=" white-space: nowrap !important;     " class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <th style="padding-right: 13px !important;">Current Status</th>
                                        <th style="padding-right: 13px !important;">Next Stage</th>
                                      
                                        <!-- <th style="padding-right: 13px !important;">ORG Schedule</th> -->
                                        <th style="padding-right: 13px !important;">Material Req</th>
                                        <th style="padding-right: 13px !important;">Stage Planned</th>
                                        <th style="padding-right: 13px !important;">Stage Expected</th>
                                        <!--                                        <th>Stage Actual</th>                                      -->
                                        <th style="padding-right: 13px !important;">Remarks</th>
                                        <th style="padding-right: 13px !important;">Action</th>
                                        <th style="padding-right: 13px !important;">History & View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = $cls_comm->select_swift_workflow($pid, $segment);
                                   
                                    $res = json_decode($result, true);

                                    foreach ($res as $key => $value) {
                                        $sent_back = $value['ps_stback'];
                                        $projname = $cls_comm->project_name($value['cs_projid']);
                                        $packname = $cls_comm->package_name($value['cs_packid']);
                                        $fromname = $cls_comm->get_username($value['from_uid']);

                                        $sendername = $cls_comm->get_username($value['to_uid']);
                                        $schedule_date = $cls_comm->datechange(formatDate(formatDate($value['schedule_date'], 'Y-m-d', 'Y-m-d')));
                                        $mat_req = $cls_comm->datechange(formatDate(formatDate($value['mat_req_date'], 'Y-m-d', 'Y-m-d')));
                                        $actual_date = $cls_comm->datechange(formatDate(formatDate($value['cs_actualdate'], 'Y-m-d', 'Y-m-d')));
                                        $except_date1 = $cls_comm->datechange(formatDate(formatDate($value['ps_expdate'], 'Y-m-d', 'Y-m-d')));
                                        //echo   $except_date1 = date("Y-m-d", strtotime($cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'))));
                                        // echo date("Y-m-d", strtotime($cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'))));
                                        // echo "<br>" ;
                                        //   echo $except_date;
                                     
                                        $org_plandate = $cls_comm->datechange(formatDate(formatDate($value['org_plandate'], 'Y-m-d', 'Y-m-d')));
                                        $rev_planned_date = $cls_comm->datechange(formatDate(formatDate($value['rev_planned_date'], 'Y-m-d', 'Y-m-d')));
                                        $rdate = $cls_comm->datechange(formatDate(formatDate($value['cs_sentdate'], 'Y-m-d', 'Y-m-d')));
                                     
                                        $getid = $value['cs_packid'];
                                        $scmbu_id = $value['sc_id'];
                                        $stageid = $value['to_stage_id'];
                                        $pm_stages = $value['pm_stages'];
                                        $lt_flag = $value['lt_flag'];
                                        $hold_flag = $value['hold_on'];
                                        $stage_array = explode(",", $pm_stages);
                                        
                                        $key = array_search($stageid, $stage_array);
                                        $Next_stage = $stage_array[$key + 1];
                                        $stage_names = $cls_comm->get_stagenames($getid, $stageid, $Next_stage);
                                        
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

                                            $except_date = formatDate($except_date, 'd-m-Y');
                                        } else {
                                            $except_date = formatDate($value['ps_expdate'], 'd-m-Y');
                                        }

                                        if ($lt_flag == 1) {
                                            $hight_light = 'style="background: #fffdd0;"';
                                        } else {
                                            $hight_light = '';
                                        }
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
                                            <tr <?php echo $hight_light; ?>>

                                                <td><?php echo $projname ?> 
                                                 <?php if($value['proj_type'] !=''){  ?> 
                                                        <span class="blink">
                                                        <span class='type_sty <?php echo $ptype_col; ?>'><?php echo $ptype; ?></span>
                                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                                    </span>
                                                    
                                                        <?php  } ?>
                                                </td>
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
                                                    ?>    <?php echo $packname; ?>
                                                </td>
                                            
                                                <td>
                                                <span style=" background-color: rgb(44, 36, 158); color:white;" class="badge badge-pill  font-medium text-black ml-1 recfrm">
                                                       <?php if ($sent_back == 1) {
                                                           $sent = $stage_names['cur_stage'];
                                                           echo $current_status = 'Sent back by ' . $sent . '<br>(' . $fromname . ' / ' . $value['nodays'] . ' Days )';
                                                       } else {
                                                           echo $current_status = $stage_names['cur_stage'] . '<br>(' . $sendername . ' / ' . $value['nodays'] . ' Days )';
                                                       } ?>
                                                </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-pill font-medium text-white ml-1 recfrm fromtostage">
                                                        <?php if ($Next_stage == 13) {
                                                            echo "Smart Signoff";
                                                        } else { ?>         <?php echo $stage_names['cur_stage'];
                                                        } ?> - <?php echo  $stage_names['next_stage'] ?>
                                                    </span>
                                                </td>

                                                <!-- <td><?php echo formatDate($value['ts_sentdate'], 'd-m-Y'); ?></td> -->
                                                <!-- <td><?php echo $schedule_date; ?></td> -->
                                                <td><?php echo $mat_req; ?></td>
                                                <td><?php echo $rev_planned_date; ?></td>
                                                <!--<td><?php echo $except_date; ?></td>-->
                                                <td style=" min-width: 130px !important;">

                                                    <div class="input-group" id="expdiv" style=" float: left;">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <input type="text" value="<?php echo $except_date; ?>" class="mydatepicker" id="dasexpected_date<?php echo $value['cs_packid'] ?>" name="dasexpected_date" onchange="samedate1(this.value,<?php echo $value['cs_packid'] ?>)" ; required="" placeholder="yyyy/mmm/dd">

                                                    </div>
                                                    <div class=" saveexp" style=" float: right;">
                                                        <span class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['cs_packid'] ?>', '<?php echo $stageid; ?>')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Save Expected date">
                                                            <i class="fas fa-save "></i>
                                                        </span>
                                                    </div>
                                                </td>
                                                <!--                                        <td><?php echo $actual_date ?></td>-->
                                                <td><label class="badge badge-pill  font-medium text-white ml-1 orange " data-toggle="tooltip" data-original-title="From Remarks" data-placement="bottom" style=" cursor: pointer;" onclick="swal('<?php echo $value['to_remark'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>

                                                <td>
                                                <?php  if($hold_flag!=1)  { ?>
                                                    <span style="background-color:#5abf76;" class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getspocid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['cs_packid'] ?>','<?php echo $stageid; ?>','<?php echo $Next_stage ?>','<?php echo $value['cs_projid']; ?>','<?php echo $scmbu_id; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span>
                                                 <?php }else{ ?>   
                                                    <span class="badge badge-pill badge-danger font-medium  ml-1"style=" cursor: pointer;color: #212529;background-color: #ffc36d;">On
                                                    Hold</span>
                                                    <?php  } ?>
                                                </td>
                                                <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
                                                <td>
                                                    <span onclick="view_reports('<?php echo $value['cs_packid']; ?>','<?php echo $value['cs_projid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Current Package Status Stage wise"><i class="fas fa-eye"></i> </span>
                                                    <span onclick="view_reports_table('<?php echo $value['cs_packid']; ?>','<?php echo $value['cs_projid']; ?>')" style="background-color: #8e1f1f !important;" class="badge badge-pill badge-info font-medium text-white ml-1" data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title=" Packages WorkFlow  "><i class="fa fa-database"></i> </span>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal_resize" style=" width: 120%;">
                        <!-- <div class="modal-header" style="padding-bottom: 1% !important;    margin-right: 3%;">
                            <div class=" col-md-12" class="modal-title" id="exampleModalLabel1">
                                <span class="control-label bold" style="color: #09aef7;font-weight: 500;"><b>Package Name : </b></span>
                                <span class="control-label bold" style="font-weight: 500;" id="pack"></span>
                                <label for="message-text" class="control-label bold" style="margin-left: 31%;">Planned Date : </label> <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span>
                                <label for="message-text" class="control-label bold">Expected Date : </label><span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span>
                                <center>
                                    <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" style="font-weight: bold !important;font-size:14px;" id="senttitle"></span></small>
                                </center>
                            </div>

                           
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div> -->
                        <div class="modal-header " style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span style="color: #09aef7;font-weight: 500;">Package Name</span> - <small id="pack">Package Name</small></h4> 
                           <h4 id="proj" style="display:none;"></h4>
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h4 id="pack"></h4> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid" style="margin-left: 37%;">
                              
                                <div class=" col-md-6" id="pd">
                                <label for="message-text" class="control-label bold" >Planned Date : </label><span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span>                         
                                </div>
                                <div class=" col-md-6" id="ps" >
                                <label for="message-text" class="control-label bold">Expected Date : </label> <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span>                         
                                </div>
                            </div>
                        </div>

                        <div class="row">
                              
                            <div class="container-fluid">
                                <!-- <div class=" col-md-3" id="pd">
                                    <label for="message-text" class="control-label bold">Planned Date : </label> <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span>
                                </div> -->
                                <div class=" col-md-6" id="ps" style="margin-top: -3%;margin-left: 57%;">

                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                        <center>
                                <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" style="font-weight: bold !important;font-size:14px;"  id="senttitle">Tech. Expert to CTO for approval</span></small>                
                            </center>
                            <form style="margin-left: 1%" id='approve_validate' method="post" class="needs-validation" novalidate action="functions/move_to_next_stage.php" autocomplete="off">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />
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
                                        <input type="hidden" value="" name="projectid" id="projectid">
                                        <input type="hidden" value="" name="packageid" id="packageid">
                                        <input type="hidden" name="next_stage" id="next_stage">
                                        <input type="hidden" name="cur_stage" id="cur_stage">
                                        <input type="hidden" id="scmbu_id" name="scmbu_id">
                                        <input type="hidden" value="" name="hpc_app" id="hpc_app">

                                    </div>
                                    <div class="row" id='loi_inputs' style="display:none;">


                                        <div class="col-md-12 mb-3">


                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label for="loi" class="col-4 col-form-label">LOI Number</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="loi_number" name="loi_number" placeholder="Enter LOI Number">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label for="loi" class="col-4 col-form-label">LOI Date</label>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control mydatepicker" style=" margin-bottom: 0px !important;" id="loi_date" name="loi_date" placeholder="dd/mmm/yyyy">

                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-md-6 mb-3">
                                            <div class="form-group row">
                                                <label for="po_wo" class="col-4 col-form-label">PO/WO Applicable </label>
                                                <div class="col-md-6">
                                                    <input style=" cursor: pointer;margin-left: 2%;" type="radio" name="po_wo" value="1" /> PO

                                                    <input style=" cursor: pointer;margin-left: 2%" type="radio" name="po_wo" value="2" /> WO

                                                    <input style=" cursor: pointer;margin-left: 2%" type="radio" name="po_wo" value="3" /> PO+WO
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <input type="checkbox" id="deal" class="button_check" name="deal_checkbox">
                                            <label for="deal" class="col-5 col-form-label">Distributor/ OEM Deal Path</label>
                                        </div>

                                        <div class="col-md-5 mb-3">

                                            <label for="name" class="col-12 col-form-label" style="margin-left: -3%;">Site Planning / Business</label>
                                            <div class="form-group row">
                                                <label for="site_name" class="col-4 col-form-label">Contact Name</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="site_name" name="site_name" placeholder="Enter Contact Name">
                                                </div>
                                                <label for="site_mobno" class="col-4 col-form-label">Mobile No </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="site_mobno" name="site_mobno" placeholder="Enter Mobile Number" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="10">
                                                </div>
                                                <label for="site_mailid" class="col-4 col-form-label">Mail Id </label>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control" id="site_mailid" name="site_mailid" placeholder="Enter Mail id">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-3 mb-3" id='Dist_show' style="display:none;">
                                            <div class="form-group row">
                                                <label for="dist1_name" class="col-4 col-form-label">Distributor Name</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="dist1_name" name="dist1_name" placeholder="Enter Contact Name">
                                                </div>
                                                <label for="site_mobno" class="col-4 col-form-label">Mobile No </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="dist1_mobno" name="dist1_mobno" placeholder="Enter Mobile Number">
                                                </div>
                                                <label for="site_mailid" class="col-4 col-form-label">Mail Id </label>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control" id="dist1_mailid" name="dist1_mailid" placeholder="Enter Mail id">
                                                </div>
                                                <div class="invalid-feedback"> </div>
                                            </div>
                                        </div> -->


                                        <!-- <div class="col-md-6 mb-3" id='Dist_show' style="display:none;">

                                            <label for="name" class="col-12 col-form-label" style="margin-left: -3%;"></label>
                                            <div class="form-group row">
                                                <label for="dist1_name" class="col-4 col-form-label">Distributor Name</label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="dist1_name" name="dist1_name" placeholder="Enter Contact Name">
                                                </div>
                                                <label for="site_mobno" class="col-4 col-form-label">Mobile No </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="dist1_mobno" name="dist1_mobno" placeholder="Enter Mobile Number" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="10">
                                                </div>
                                                <label for="site_mailid" class="col-4 col-form-label">Mail Id </label>
                                                <div class="col-md-6">
                                                    <input type="email" class="form-control" id="dist1_mailid" name="dist1_mailid" placeholder="Enter Mail id">
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-7 mb-3" id='Dist_show' style="display:none;">
                                            <label for="name" class="col-12 col-form-label" style="margin-left: -3%;"></label>
                                            <div class="form-group row">
                                                <table class="_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                            <th>Contact Name</th>
                                                            <th>Mobile No</th>
                                                            <th>Mail Id</th>
                                                            <th width="50px">
                                                                <div class="action_container">
                                                                    <button id="btnAdd" type="button" class="success" onclick="create_tr('table_body')">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="table_body">
                                                        <tr>
                                                            <td>
                                                                <select class="custom-select" name="type[]" id="type">
                                                                    <option value="">--type--</option>
                                                                    <option value="1">--Distributor--</option>
                                                                    <option value="2">--OEM--</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="dist_name" name="dist_name[]" placeholder="Enter Contact Name">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="dist_mobno" name="dist_mobno[]" placeholder="Enter Mobile Number" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="10">
                                                            </td>
                                                            <td>
                                                                <input type="email" class="form-control" id="dist_mailid" name="dist_mailid[]" placeholder="Enter Mail id">
                                                            </td>
                                                            <td>
                                                                <div class="action_container">
                                                                    <button type="button" class="danger remove" onclick="remove_tr(this)">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <!-- <div class="form-group row">
                                            <label for="dist1_name" class="col-4 col-form-label">Distributor Name</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="dist1_name" name="dist1_name" placeholder="Enter Contact Name">
                                            </div>
                                            <label for="site_mobno" class="col-4 col-form-label">Mobile No </label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="dist1_mobno" name="dist1_mobno" placeholder="Enter Mobile Number">
                                            </div>
                                            <label for="site_mailid" class="col-4 col-form-label">Mail Id </label>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control" id="dist1_mailid" name="dist1_mailid" placeholder="Enter Mail id">
                                            </div>
                                        </div> -->



                                        <!-- <div class="col-md-3 mb-3">
                                            <label for="deal"> Deal Path </label>
                                            <input style=" cursor: pointer;" class="deal_checkbox button_check" type="checkbox" name="deal_checkbox" />
                                        </div> -->




                                        <!-- <div class="col-md-3 mb-3" style="display:none;">
                                            <label for="dist2_name">Distributor 2: (If Applicable)</label>
                                            <input style=" cursor: pointer;" checked type="checkbox" class="flag_checkbox" name="flag[]" value="3" />

                                            <div class="input-group">
                                                <input type="text" class="form-control" id="dist2_name" name="dist2_name" placeholder="Enter Contact Name">
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="dist2_mobno" name="dist2_mobno" placeholder="Enter Mobile Number">
                                            </div>
                                            <div class="input-group">
                                                <input type="email" class="form-control" id="dist2_mailid" name="dist2_mailid" placeholder="Enter Mail id">
                                            </div>
                                            <div class="invalid-feedback"> </div>
                                        </div> -->
                                        <!-- <div class="col-md-3 mb-3" style="display:none;">
                                            <label for="oem_name">OEM</label>
                                            <input style=" cursor: pointer;" checked type="checkbox" class="flag_checkbox" name="flag[]" value="4" />
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="oem_name" name="oem_name" placeholder="Enter Contact Name">
                                            </div>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="oem_mobno" name="oem_mobno" placeholder="Enter Mobile Number">
                                            </div>
                                            <div class="input-group">
                                                <input type="email" class="form-control" id="oem_mailid" name="oem_mailid" placeholder="Enter Mail id">
                                            </div>
                                            <div class="invalid-feedback"> </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="table-responsive" id="exp_uptable"> </div>
                                <div class="form-group" id="expert_uploads" style="display:expert_uploadsnone;">
                                    <div class="form-row">
                                        <div class="col-md-3 mb-4" id="doc_names">
                                            
                                          
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="proj_location">Upload File</label>
                                            <div class="input-group mb-3">

                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label " for="inputGroupFile01">Choose file</label>
                                                </div>

                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <input type="hidden" id="ops_rem" value="1">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <input type="checkbox" id="keyattach" name="keyattach">
                                            <label for="keyattach" style="margin-top:20%;">Key Attachment</label>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="ops_expert_filesup" onclick="common_filesuplod()">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-6"></div>
                                        <div class="col-md-6 mb-6">
                                            <div id="progress-wrp">
                                                <div class="progress-bar"></div>
                                                <div class="status">0%</div>
                                            </div>
                                            <div id="output">
                                                <!-- error or success results -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="ops_exp_uptable"></div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6" id="opsr" style="margin-left:0%;">
                                        <label for="" class=" bold"></label>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-4 " style="margin-top: 20px;">
                                    <div class="form-group row">
                                        <label for="act_date" class="col-6 col-form-label">Action Date</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" style=" margin-bottom: 0px !important;" disabled="" id="act_date" name="act_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                   <div class="col-md-4" id='finalstage' style="display:block;margin-top: 20px;">
                                    <div class="form-group row forward">
                                        <label for="act_date" class="col-4 col-form-label" style="text-align: right;">To</label>
                                        <div class="col-md-6">
                                        <select class="custom-select" name="forward" id="forward" style="width: 225px;">
                                                <option value="">--Select Forward--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                  

                                    <!-- <div class="col-md-4" id='finalstage' style="display:block;margin-top: 20px;">
                                        <div class="form-group forward">
                                            <label for="message-text" class="control-label bold">To:</label>
                                            <select class="custom-select" name="forward" id="forward">
                                                <option value="">--Select Forward--</option>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 " style="margin-top: 12px;">
                                    <div class="form-group row">
                                        <label for="remarks" class="col-6 col-form-label">Enter Remarks</label>
                                        <div class="col-md-6">
                                        <textarea class="form-control" rows="6" id="remarks" name="remarks" style="height: calc(1em + 3.75rem + 6px) !important; width: 538px !important;"></textarea>

                                        </div>
                                    </div>
                                    </div>

                                </div>
                                <div class="row backto" style="display:none;">
                                   

                                    <div class="col-md-4 ">
                                    <div class="form-group row">
                                        <label for="senbackstage" class="col-6 col-form-label">Send Back To</label>
                                        <div class="col-md-6">
                                        <select style="width: 218px;" class="custom-select" name="senbackstage" id="senbackstage" onchange="appendName();">
                                            <option value="">--Select Send Back--</option>

                                        </select>
                                        </div>
                                    </div>
                                    </div>


                                    <div class="col-md-4 ">
                                    <div class="form-group row">
                                        <label for="senbackstage" class="col-4 col-form-label" style="text-align: right;">Back To</label>
                                        <div class="col-md-6">
                                        <select style="width: 229px;" class="custom-select" name="senbackuid" id="senbackuid">
                                                <option value="">--Select Send Back User--</option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>


                                   
                                </div>
                                <!-- <input type="hidden" id="pack_id" name="pack_id"> -->
                                <div class="modal-footer">
                                    <button style="display:none;" type="submit" value='1' class="btn waves-effect waves-light btn-rounded btn-outline-danger pull-left click" id='backEnable' name="sent_back_to_previous" data-toggle="tooltip" data-placement="top" title="Send Back"> <i class="fas fa-times"></i> Send Back</button>
                                    <button type="submit" value='0' class="btn btn-outline-primary btn-rounded click" name="approve_package" id="button_check" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fas fa-paper-plane"></i>Approve</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </div>
    </div>
    <script src="code/js/ops.js" type="text/javascript"></script>
    <script src="code/js/docsetting.js" type="text/javascript"></script>
    <script src="code/js/technical.js" type="text/javascript"></script> 
    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>


<script>
    function getspocid(a, b, c, from, to, proj, scmid) {

        var spocid = a;
        var project = b;
        var pack_id = c;
        $("#proj").text(project);
        // $("#pack_id").val(spocid);
        $('#projectid').val(proj);
        $('#packageid').val(spocid);
        $("#cur_stage").val(from);
        $("#next_stage").val(to);
        $("#scmbu_id").val(scmid);
        //            $("#exp_date").disabled = true;
        $("#act_date").datepicker("setDate", new Date());
        //            document.getElementById("exp_date").disabled = true;
        // $.post("functions/filesforexpert.php", {
        $.post("functions/filesfrom.php", {
            key: pack_id,
            from: from,
            to: to,
        }, function(data) {
        //console.log(data)
            var hpc_app = JSON.parse(data).hpc_app;
            var sendback = JSON.parse(data).sendback;
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            var file_attach = JSON.parse(data).file_attach;
            var remark = JSON.parse(data).remark;
            var current_stage = JSON.parse(data).current_stage;
            var next_stage = JSON.parse(data).next_stage;
            var users = JSON.parse(data).userlist;
            var a = JSON.stringify(users);
            var userlist = JSON.parse(users);
            var stages = JSON.parse(data).stagelist;
            var doclist = JSON.parse(data).doclist;

            var b = JSON.stringify(stages);
            var c = JSON.stringify(doclist);
            var stagelist = JSON.parse(stages);
            var docname = JSON.parse(doclist);
            console.log(stagelist);
            if (sendback != null) {
                $("#backEnable").show();
            } else {
                $("#backEnable").hide();
            }
            var option = '<option value="" >---Select Forward--</option>';
            $(userlist).each(function(key, value) {
                option += '<option value="' + value.uid + '" >' + value
                    .name + '</option>';
            });
            var option2 = '<option value="" >---Select Back To--</option>';
            $(stagelist).each(function(key, value) {
                option2 += '<option value="' + value.stage_id + '" >' + value
                    .shot_name + '</option>';
            });
            if (file_attach == 1) {
                $("#expert_uploads").show();
                    if (from == 4) {
                    var option3 = '<label for="doc_name">Doc Type</label>';
                    option3 += ' <select class="custom-select" name="doc_name" id="doc_name">';
                    option3 += '<option value="" >---Select Doc Type--</option>';
                    option3 += ' <option value="Compliances">Compliances</option>';
                    option3 += '<option value="Sol Document">Sol Document</option>';
                    option3 += '<option value="Cross References">Cross References</option>';
                    option3 += '<option value="BOM">BOM</option>';
                    option3 += '<option value="BOQ">BOQ</option>';
                    option3 += '<option value="Data sheet">Data sheet</option>';
                    option3 += '<option value="Others">Others</option>';
                    $(docname).each(function(key, value) {
                        option3 += '<option value="' + value.stDoCName + '" >' + value
                            .stDoCName + '</option>';
                    });
                    $('#doc_names').html('');
                    $('#doc_names').append(option3);
                }else{
                    var option6 = '<label for="doc_name">Doc Type</label>';
                     option6 +='<input type="text" class="form-control" id="doc_name" name="doc_name"  readonly value="'+current_stage+' signoff">';
                    $('#doc_names').html('');
                    $('#doc_names').append(option6);
                }
                
            } else {
                $("#expert_uploads").hide();
                
            }
            // backEnable
            if (from == 13) {
                $("#loi_inputs").show();
                $("#button_check").text('LOI Creation');
            } else {
                fetch_pre_uploaded_document_view(proj, pack_id);
                $("#button_check").text('Send To ' + next_stage);
            }
            if (to != '') {
                $('#forward').html('');
                $('#forward').append(option);
            } else {
                $("#finalstage").hide();
            }
            $('#hpc_app').val(hpc_app);
            $('#senbackstage').html('');
            $('#senbackstage').append(option2);
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $("#pack").html(pm_packagename);
            $("#exp_date").val(mat_req_date);
            $("#senttitle").text(current_stage + '-' + next_stage);

            $('#opsr').html(remark);

        });
    }




    // function samedate1($pkid,$id) {
    //     $("#dasexpected_date"+$pkid).datepicker("setDate", $id);
    // }
    function samedate($id) {
        $("#exp_date").datepicker("setDate", $id);
    }


    function swift_proj(Proid) {
        var tid = $('#proj_type').val();
        window.location.href = "swift_workflow_approval?pid=" + Proid + "&ptid=" + tid;
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
    //     $(function(){
    //   $("#approve_validate").click(function(e){
    //     alert($(this).attr("name"));
    //   });
    // });​
    //     $('#approve_validate').on('submit', function() {
    //       //  var btn= $(this).find("input[type=submit]:focus").val();
    // // alert('you have clicked '+ btn);
    // buttonpressed = $(this).attr('name')
    //          alert(buttonpressed);

    //         if (button == 'approve_package') {
    //             var forward = $('#forward').val();
    //             var sendback = $('#senbackstage').val();
    //             var remarks = $('#remarks').val();
    //             if (forward == "") {
    //                 alert('Please Select Forward To');
    //                 return false;

    //             } else if (remarks == "") {
    //                 alert('Please Enter Remark');
    //                 return false;
    //             }
    //         } else {
    //             if (sendback =="") {
    //                 alert('Please Select Send Back To');
    //                 return false;

    //             } else if (remarks == "") {
    //                 alert('Please Enter Remark');
    //                 return false;

    //             }
    //         }
    //     });

    function appendName() {
    var packageid = $('#packageid').val();
    var projectid = $('#projectid').val();
    var stageid = $('#senbackstage').val();

    $.post("functions/name_append.php", {
        pack_id: packageid,
        stageid: stageid,
        projectid: projectid
    }, function(response) {
        try {
            var parsedData = JSON.parse(response); // First parse
            var userlist = JSON.parse(parsedData.userlist); // Second parse
            
            if (!Array.isArray(userlist)) {
                console.error("Invalid userlist format:", parsedData.userlist);
                return;
            }

            console.log(userlist);

            var options = '<option value="">--- Select Send Back User ---</option>';
            $.each(userlist, function(index, value) {
                options += `<option value="${value.uid}">${value.name}</option>`;
            });
             $('#senbackuid').html('');
             $('#senbackuid').html(options);
        } catch (error) {
            console.error("Error parsing response:", error);
        }
    });
}


</script>

<script>
    $(".button_check").click(function() {
        if ($(this).is(":checked")) {
            $('#Dist_show').show()
        } else {
            $("#Dist_show").hide();
        }
    });
    $(function() {
        var buttonpressed;
        $('.click').click(function() {
            buttonpressed = $(this).attr('name')
        })
        $('form').submit(function() {

            var next_stage = $('#next_stage').val();
            if ($('#deal_checkbox').is(":checked")) {
                var deal = 1;
            } else {
                var deal = 0;
            }
            // if (deal == 1) {
            //     $('#Dist_show').show()
            // }
            var forward = $('#forward').val();
            var sendback = $('#senbackstage').val();

            var remarks = $('#remarks').val();
            var senbackuid = $('#senbackuid').val();
            if (buttonpressed == 'approve_package') {
                $('.forward').show();
                 $('.backto').hide();
                if (deal == '1') {
                    var dist1_name = $('#dist1_name').val();
                    var dist1_mobno = $('#dist1_mobno').val();
                    var dist1_mailid = $('#dist1_mailid').val();
                    if ((dist1_name = '') && (dist1_mobno = '') && (dist1_mailid = '')) {
                        alert('Please Fill Distributor Details');
                        return false;
                    } else {
                        return (true)
                    }
                } else if (next_stage != '' && forward == "") {
                    alert('Please Select Forward To');
                    return false;
                } else if (remarks == "") {
                    alert('Please Enter Remark');
                    return false;
                } else {
                    return (true)
                }
            } else {
                // alert('button clicked was ' + buttonpressed)

                $('.backto').show();
                $('.forward').hide();
                if (sendback == "") {
                    alert('Please Select Send Back To');
                    return false;
                } else if (senbackuid == "") {
                    alert('Please Select User Name');
                    return false;
                } else if (remarks == "") {
                    alert('Please Enter Remark');
                    return false;
                } else {
                    return (true)
                }
            }

            buttonpressed = ''
        })
    })
</script>
<script>
    // function create_tr(table_id) {
    //     let table_body = document.getElementById(table_id),
    //         first_tr = table_body.firstElementChild
    //     tr_clone = first_tr.cloneNode(true);

    //     table_body.append(tr_clone);

    //     clean_first_tr(table_body.firstElementChild);
    // }

    // function clean_first_tr(firstTr) {
    //     let children = firstTr.children;

    //     children = Array.isArray(children) ? children : Object.values(children);
    //     children.forEach(x => {
    //         if (x !== firstTr.lastElementChild) {
    //             x.firstElementChild.value = '';
    //         }
    //     });
    // }



    // function remove_tr(This) {
    //     if (This.closest('tbody').childElementCount == 1) {
    //         alert("You Don't have Permission to Delete This ?");
    //     } else {
    //         This.closest('tr').remove();
    //     }
    // }


    $(function () {
    $("#btnAdd").bind("click", function () {
        var div = $("<tr />");
        div.html(GetDynamicTextBox(""));
        $("#table_body").append(div);
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("tr").remove();
    });
});
function GetDynamicTextBox(value) {
    return '<td><select class="custom-select" name="type[]" id="type"><option value="">--type--</option><option value="1">--Distributor--</option><option value="2">--OEM--</option></select></td>' + '<td><input type="text" class="form-control" id="dist_name" name="dist_name[]" placeholder="Enter Contact Name"></td>' + '<td> <input type="text" class="form-control" id="dist_mobno" name="dist_mobno[]" placeholder="Enter Mobile Number" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="10"></td>' + '<td><input type="email" class="form-control" id="dist_mailid" name="dist_mailid[]" placeholder="Enter Mail id"></td>' + '<td> <div class="action_container"><button type="button" class="danger remove" onclick="remove_tr(this)"><i class="fa fa-times"></i></button></div></td>'
}
</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        var someDate = new Date();
        //var numberOfDaysToAdd = 15;
        //var result = someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
        //console.log(new Date(result))
        $('#org_schedule').datepicker({
            format: "dd-M-yy",
            //startDate: new Date(result)
        });
       

    });
</script>
