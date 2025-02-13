<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];


$uid = $_SESSION['uid'];
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

$generate_token = generate_token();
?>
<style>
    @-webkit-keyframes blinker {
        from {
            opacity: 1.0;
        }

        to {
            opacity: 0.0;
        }
    }

    .blink {
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.6s;
        -webkit-animation-iteration-count: infinite;
        -webkit-animation-timing-function: ease-in-out;
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
                <h5 class="font-medium text-uppercase mb-0">Files For EMR Creation</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter(this.value, '4')" required="">
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
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_Filter" id="proj_Filter"
                    onchange="swift_proj(this.value)" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    // $result = $cls_comm->select_allprojects_seg($segment);
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
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="ops_dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">EMR Creation</li>
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
        <!-- Start Page Content -->
        <!-- ============================================================== -->



        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <!-- <div class="pull-right" id="emr_repo"><a href="emr_repository"><button class="btn btn-primary"
                                type="button"><i class="fa fa-eye"></i> View EMR Repository</button></a></div> -->

                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Status</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th>
                                        <!--<th>Stage Actual</th>-->
                                        <!--<th>Remarks</th>-->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //                                    $result = $cls_user->files_for_emrcreation($pid, $segment);
                                    $result = $cls_user->files_for_emrcreation_afterloi($pid, $uid, $segment);
                                    //print_r($result);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        if ($value['ps_expdate'] == "") {
                                            $exp_date = date('Y-m-d');
                                        } else {
                                            $exp_date = $value['ps_expdate'];
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
                                        <tr>
                                            <td>
                                                <?php echo $value['proj_name'] ?>
                                                <?php if ($value['proj_type'] != '') { ?>
                                                    <span class="blink">
                                                        <span class='type_sty <?php echo $ptype_col; ?>'>
                                                            <?php echo $ptype; ?>
                                                        </span>
                                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $value['planned'] = formatDate($value['planned'], 'Y-m-d');
                                                if (strtotime($value['planned']) > strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify"></span>
                                                        <span class="point greenpoint"></span>
                                                    </div>

                                                <?php } elseif (strtotime($value['planned']) < strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point"></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['planned']) == strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint"></span>
                                                    </div>
                                                <?php }
                                                ?>
                                                <?php echo $value['pm_packagename'] ?>
                                            </td>
                                            <td><span
                                                    class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">EMR
                                                    Creation</span></td>
                                            <td>
                                                <?php echo formatDate($value['pm_material_req'], 'd-M-Y'); ?>
                                            </td>
                                            <td>
                                                <?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?>
                                            </td>
                                            <td>
                                                <?php echo formatDate($value['planned'], 'd-M-Y'); ?>
                                            </td>
                                            <td style=" min-width: 130px !important;">
                                                <?php // echo date('d-M-Y', strtotime($value['actual']));       
                                                    ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text"
                                                        value="<?php echo formatDate($exp_date, 'd-M-Y'); ?>"
                                                        class="mydatepicker"
                                                        id="dasexpected_date<?php echo $value['pm_packid'] ?>"
                                                        name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span
                                                        class="badge badge-pill badge-success font-medium text-white ml-1 sicon"
                                                        onclick="save_expected('<?php echo $value['cs_packid'] ?>', '<?php echo $stageid; ?>')"
                                                        data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;"
                                                        data-toggle="tooltip" data-original-title="Save Expected date">
                                                        <i class="fas fa-save "></i>
                                                    </span>
                                                </div>

                                            </td>

                                            </td>
                                            <!--                                            <td><?php //  echo date('d-M-Y', strtotime($value['actual']));        
                                                ?></td>-->
                                            <td>
                                                <!--                                                <span onclick="filesfrom_smartsign('<?php echo $value['so_pack_id'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages">
                                                    <i class="fas fa-paper-plane"></i> 
                                                </span>-->
                                                <span onclick="filesforemr('<?php echo $value['pm_packid'] ?>')"
                                                    class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"
                                                    style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title="Send Packages">
                                                    <i class="fas fa-paper-plane"></i>
                                                </span>
                                            </td>
                                        </tr>

                                    <?php }
                                    ?>


                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- sample modal content -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal_resize" style=" width: 120%;">
                        <div class="modal-header" style="margin-top: 0px;">
                            <h4 class="modal-title" id="exampleModalLabel1"><span style="color: #09aef7;"
                                    id="project">Project</span> - <small id="pack">Package Name</small></h4>
                            <input type="hidden" name="projid" id="projid">
                            <input type="hidden" name="packid" id="packid">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">


                                <div class=" col-md-12" id="ps" style="margin-top: -3%;margin-left: 57%;">
                                    <label style="margin-left: -37.5%;" for="message-text"
                                        class="control-label bold">Planned Date : </label> <span
                                        class="badge badge-pill badge-info font-12 text-white ml-1" id="pdate">
                                        <?php echo date('d-M-y'); ?>
                                    </span>

                                    <label style="margin-left: 55%;" for="message-text"
                                        class="control-label bold">Expected Date : </label><span
                                        class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred">
                                        <?php echo date('d-M-y'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <form method="post" action="functions/po_wo_entry" autocomplete="off"
                            onsubmit="return confirm('Are you sure you want to submit?');">
                            <input type="hidden" id="csrf_token" name="csrf_token"
                                value="<?php echo $generate_token; ?>" />
                            <div class="modal-body">
                                <center>
                                    <small> <span
                                            class="badge badge-pill badge-secondary orange font-12 text-white ml-1"
                                            id="senttitle">EMR Creation </span></small>
                                </center>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="loi_number" class="col-4 col-form-label">LOI Number </label>
                                        <span class="badge badge-pill badge-primary  font-12 text-white ml-1"
                                            id="loi_number" name="loi_number"> </span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="loi_date" class="col-4 col-form-label">LOI Date </label>
                                        <span class="badge badge-pill badge-primary  font-12 text-white ml-1"
                                            id="loi_date" name="loi_date"> </span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="po_wo_app" class="col-4 col-form-label">PO/WO Applicable </label>
                                        <span class="badge badge-pill badge-primary  font-12 text-white ml-1"
                                            id="po_wo_app" name="po_wo_app"> </span>
                                    </div>
                                    <div class="col-md-6 mb-6">
                                        <label for="actual_date" class="col-4 col-form-label">LOI Remarks </label>
                                        <!-- <span class="badge badge-pill badge-primary  font-12 text-white ml-1" id="loi_remarks" name="loi_remarks"> </span> -->
                                        <span id="less" data-toggle="tooltip" data-original-title="Remarks"
                                            style=" cursor: pointer;"></span>
                                        <span id="moreew" data-toggle="tooltip" data-original-title="Remarks"
                                            style=" cursor: pointer; display: none"></span>
                                        <span id="rmore" style="color: #007bff;  cursor: pointer;"
                                            onclick="readmore()">Read more</span>
                                        <span id="rless" style="color: #007bff; cursor: pointer; display: none;"
                                            onclick="readless()">Read Less</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3" style=" display: none;">
                                        <label for="expected_date">EMR Expected</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>

                                            <!--                                            <input type="text"  class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">-->

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control mydatepicker" id="expected_date"
                                        name="expected_date" required="" placeholder="dd/mmm/yyyy">

                                    <input type="hidden" value="" name="planneddate" id="planneddate">
                                    <input type="hidden" value="" name="senderid" id="senderid">
                                    <input type="hidden" value="" name="projectid" id="projectid">
                                    <input type="hidden" value="" name="packageid" id="packageid">


                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label for="emr_no" class="col-4 col-form-label">EMR Number</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="emr_no" name="emr_no"
                                                    required="" placeholder="Enter EMR Number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group row">
                                            <label for="actual_date" class="col-4 col-form-label">EMR Action
                                                Date</label>
                                            <div class="col-md-6">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control mydatepicker"
                                                        id="actual_date" onchange="get_expected('7')" name="actual_date"
                                                        required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>

                                <div class="row" id="ctor">

                                </div>
                                <div class=" row" id="uptable">
                                </div>
                                <div class="form-group" id="dre">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="opstospocremarks"
                                        name="opstospocremarks"></textarea>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="create_emr" name="create_emr"
                                    class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i
                                        class="fa fa-paper-plane mr-1"></i> EMR Creation</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal -->




        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
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
<script>
    function swift_proj(Proid) {
        var tid = $('#proj_type').val();
        window.location.href = "files_from_loi?pid=" + Proid + "&ptid=" + tid;
    }
</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>