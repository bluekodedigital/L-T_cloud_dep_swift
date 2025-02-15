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
?>
<style>
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
#pd {
        margin-top: -4%;
        margin-left: 63.8% !important;
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
                <h5 class="font-medium text-uppercase mb-0">Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type" onchange="proj_type_Filter_proj(this.value, '4')"
                    required="">
                    <?php if (isset($_SESSION['proj_type']) && $_SESSION['proj_type'] == 0) { ?>
                        <option value="-" <?php echo ($ptid == '-') ? 'selected' : ''; ?>>Both</option>
                    <?php } ?>
                    <?php
                    foreach ($proj_type as $key => $value) {
                        ?>
                        <option value="<?php echo $value['id'] ?>" <?php echo (!empty($res) /* count($res) == 1 */ || $ptid == $value['id']) ? 'selected' : ''; ?>>
                            <?php echo $value['type_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="proj_id" id="proj_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if ($_SESSION['milcom'] == '1') {
                        $seg = '38';
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
                        <li class="breadcrumb-item"><a href="tech_spoc">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Repository</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Current Status</th>
                                        <!-- <th>ORG Schedule</th> -->
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th>
                                        <th>Stage Actual</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                        <th>Attachments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_swift_repository($pid, $_SESSION['uid'], $seg);

                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['cs_projid']);
                                        $packname = $cls_comm->package_name($value['cs_packid']);
                                        $sendername = $cls_comm->get_username($value['to_uid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['cs_actualdate'], 'Y-m-d'));
                                        $except_date1 = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                        $rdate = $cls_comm->datechange(formatDate($value['cs_sentdate'], 'Y-m-d'));
                                        $status = $cls_comm->cur_status_name($value['cs_packid']);
                                        $getid = $value['rsid'];
                                        $stageid = $value['from_stage_id'];
                                        $name = $cls_comm->newname($_SESSION['uid'], $value['cs_packid']);

                                        $current_status = $cls_comm->current_status($value['cs_packid'],$value['cs_projid']);

                                        if (strtotime($rev_planned_date) > strtotime($actual_date)) { ?>
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
                                            <td><?php echo $projname ?>
                                            <?php if($value['proj_type'] !=''){  ?> 
                                                <span class="blink">
                                                <span class='type_sty <?php echo $ptype_col; ?>'>
                                                <?php echo $ptype; ?></span>
                                                <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                            </span>
                                            
                                                <?php  } ?>
                                            </td>
                                            <td>
                                                <?php echo $packname ?>
                                            </td>
                                            <td><span style=" background-color: rgb(44, 36, 158) !important ; color:white !important;" class="badge badge-pill badge-info font-medium text-white ml-1 recfrm"><?php echo $current_status; ?></span></td>
                                            <!-- <td><?php echo $schedule_date; ?></td> -->
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date; ?></td>
                                            <td><?php echo $except_date; ?></td>
                                            <td><?php echo $actual_date; ?></td>
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" onclick="swal('<?php echo $name['txp_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>
                                            <td>
                                            <span onclick="view_reports('<?php echo $value['cs_packid']; ?>','<?php echo $value['cs_projid']; ?>')"
                                                    class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title="Current Package Status Stage wise"><i
                                                        class="fas fa-eye"></i> </span>
                                            </td>
                                            <!-- <td><span class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-eye"></i> View</span></td> -->
                                            <td>
                                                <?php
                                                $sql = "select * from swift_comman_uploads where up_packid='" . $value['cs_packid'] . "'";
                                                $projname = $cls_comm->project_name($value['cs_projid']);
                                                $packname = $cls_comm->package_name($value['cs_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['cs_projid']; ?>', '<?php echo $value['cs_packid']; ?>','<?php echo $stageid; ?>','<?php echo $ptype ?>')" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sample modal content -->
            <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1">Project - <small>Package Name </small></h4> 

                            <div class="row" id="daterow">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-dark font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                                </div> -->
            <!--                                <div class=" col-md-6" id="ps">
                                                <small>Sending Date:- <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                          
                                            </div>-->
            <!-- </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form>  
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="expected_date">Expected</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-calender"></i></span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="end_date" name="expected_date" required="" placeholder="dd/mm/yyyy">

                        </div>
                        <div class="invalid-feedback">

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="actual_date">Actual</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-calender"></i></span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="revend_date" name="actual_date" required="" placeholder="dd/mm/yyyy">

                        </div>
                        <div class="invalid-feedback">

                        </div>
                    </div>

                </div>      
                <div class="form-group">
                    <label for="message-text" class="control-label">Enter Remarks:</label>
                    <textarea class="form-control" id="message-text1"></textarea>
                </div>
            </form> -->
            <?php
            // $msg = '';
            // for ($i = 0; $i <= 5; $i++) {
            //     $msg .= 'Date' - 'This is the remarks from CTO\n';
            // }
            //echo $msg;
            ?>
            <!-- </div>
            <div class="modal-footer"> -->

            <!--                            <a href="javacript:void(0)"  class="btn btn btn-rounded btn-outline-success mr-2 btn-sm" data-toggle="tooltip"  data-original-title="Send to O&M"><i class="ti-check mr-1"></i>Submit</a>
            -->
            <!--                            <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane"></i> Send to CTO</button>
            -->
            <!-- <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
        </div>
    </div>
</div>
</div> -->
            <!-- /.modal -->

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
    <script src="code/js/technical.js" type="text/javascript"></script>
    <script src="code/js/ops.js" type="text/javascript"></script>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script>
    function swift_proj(Proid) {
        var tid = $('#proj_type').val();
        window.location.href = "swift_workflow_repository?pid=" + Proid + "&ptid=" + tid;
    }

</script>

<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>