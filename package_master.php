<?php

include_once ('layout/header.php');
include_once ('layout/nav.php');
include_once ('layout/leftsidebar.php');
include 'config/inc.php';
//$generate_token = generate_token();
$segment = $_SESSION['swift_dep'];
//$segment = $_SESSION['tech_seg'];
$generate_token = generate_token();

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
    .scrolldiv>.table td {
        padding: 0px 15px 0px 18px !important;
    }

    .scrolldiv {
        height: 250px;
        overflow: auto;
    }

    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }

    div#fileuploader {
        margin-top: 20px;
    }

    .checkbox {
        width: 100%;
        /*margin: 15px auto;*/
        position: relative;
        display: block;
        margin-top: -31px !important;
    }

    .checkbox input[type="checkbox"] {
        width: auto;
        opacity: 0.00000001;
        position: absolute;
        left: 0;
        margin-left: -20px;
    }

    .checkbox label {
        position: relative;
    }

    .checkbox label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        margin: 4px;
        width: 22px;
        height: 22px;
        transition: transform 0.28s ease;
        border-radius: 3px;
        border: 2px solid #ff9900;
        background-color: #ff9900;
    }

    .checkbox label:after {
        content: '';
        display: block;
        width: 10px;
        height: 5px;
        border-bottom: 2px solid #fff;
        border-left: 2px solid #fff;
        -webkit-transform: rotate(-45deg) scale(0);
        transform: rotate(-45deg) scale(0);
        transition: transform ease 0.25s;
        will-change: transform;
        position: absolute;
        top: 12px;
        left: 10px;

    }

    .checkbox input[type="checkbox"]:checked~label::before {
        color: #ff9900;
    }

    .checkbox input[type="checkbox"]:checked~label::after {
        -webkit-transform: rotate(-45deg) scale(1);
        transform: rotate(-45deg) scale(1);
    }

    .checkbox label {
        min-height: 34px;
        display: block;
        padding-left: 40px;
        margin-bottom: 0;
        font-weight: normal;
        cursor: pointer;
        vertical-align: sub;
    }

    .checkbox label span {
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .checkbox input[type="checkbox"]:focus+label::before {
        outline: 0;
    }
</style>
<style>
    .example button {
        float: left;
        background-color: #4E3E55;
        color: white;
        border: none;
        box-shadow: none;
        font-size: 17px;
        font-weight: 500;
        font-weight: 600;
        border-radius: 3px;
        padding: 15px 35px;
        margin: 26px 5px 0 5px;
        cursor: pointer;
    }

    .example button:focus {
        outline: none;
    }

    .example button:hover {
        background-color: #33DE23;
    }

    .example button:active {
        background-color: #81ccee;
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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Package Master </h5>
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
                        <option value="<?php echo $value['id'] ?>" <?php echo (!empty($res)/* count($res) == 1 */ || $ptid == $value['id']) ? 'selected' : ''; ?>>
                            <?php echo $value['type_name'] ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_Filter" id="proj_Filter"
                    onchange="proj_Filter(this.value, '4')" required="">
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Package Master</li>
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

        <div class="row" id="package_create" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="tab_select">
                        <!-- <h4 class="card-title">Package Creation Form</h4> -->
                        <ul class="nav nav-pills mt-4 mb-1">
                            <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab"
                                    aria-expanded="false">Manual Entry</a> </li>
                            <!-- <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab"
                                    aria-expanded="false">Excel Upload</a> </li> -->
                        </ul>
                        <div class="tab-content border p-4">
                            <div id="navpills-1" class="tab-pane active" style="position: relative;top: -16px;">
                                <div class="row">
                                    <form id="packform" class="needs-validation" novalidate method="post"
                                        action="functions/package_master_form.php" autocomplete="off"
                                        enctype="multipart/form-data">
                                        <!--<input type="hidden" id="csrf_token" name="csrf_token" value="<?php // echo $generate_token;  
                                        ?>" />-->
                                        <input type="hidden" id="csrf_token" name="csrf_token"
                                            value="<?php echo $generate_token; ?>" />

                                        <input type="hidden" name="page_name" value="masters">
                                        <input type="hidden" name="omsegs" id="omsegs" value="">
                                        <input type="hidden" name="lt_violation" id='lt_violation' value="masters">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Project Type</label>
                                                <select class="custom-select" name="proj_type_name" id="proj_type_name"
                                                    required="" onchange="load_proj_by_proj_type(this.value);">
                                                    <option value="">--Select Project Type--</option>
                                                    <?php if (isset($_SESSION['proj_type']) && $_SESSION['proj_type'] == 0) { ?>
                                                        <option value="-">Both</option>
                                                    <?php } ?>
                                                    <?php
                                                    foreach ($proj_type as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['id'] ?>">
                                                            <?php echo $value['type_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Project Name</label>
                                                <select class="custom-select" name="proj_name" id="proj_name"
                                                    required="" onchange="omflowvalidate(this.value);">
                                                    <option value="">--Select Project--</option>
                                                    <?php
                                                    // $result = $cls_comm->select_allprojects_seg($segment);
                                                    $result = $cls_report->select_filterprojects_seg2($seg, $ptid);
                                                    $res = json_decode($result, true);
                                                    foreach ($res as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['proj_id'] ?>">
                                                            <?php echo $value['proj_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="proj_name">Package name</label>
                                                <input type="text" class="form-control" id="pack_name" name="pack_name"
                                                    placeholder="package Name" value="" required>
                                                <div class="invalid-feedback">

                                                </div>

                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Package Category</label>
                                                <select class="custom-select" name="pack_cat_name" id="pack_cat_name"
                                                    onchange=" cat_onchange(this.value)" required="">
                                                    <option value="">--Select Package Category--</option>
                                                    <?php
                                                    $result = $cls_comm->select_allpackagescatte();
                                                    $res = json_decode($result, true);
                                                    foreach ($res as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['pc_id'] ?>">
                                                            <?php echo $value['pc_pack_cat_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-3 ">
                                                <label for="org_schedule">Original Schedule</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="org_schedule"
                                                        name="org_schedule" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="start_date">Lead Time in Day</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="lead_time"
                                                        name="lead_time"
                                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        required="" placeholder="Lead Time in Days">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="start_date">Material Required @ Site</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="mat_req_site"
                                                        onchange="mat_change();" ; name="mat_req_site" required=""
                                                        placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>

                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Workflow</label>
                                                <select class="custom-select" name="pack_work_flow" id="pack_work_flow"
                                                    onchange=" wf_onchange(this.value)" required="">
                                                    <option value="">--Select Work Flow--</option>
                                                    <?php
                                                    $result2 = $cls_comm->select_AllWorkFlow();
                                                    $res2 = json_decode($result2, true);
                                                    foreach ($res2 as $key => $value2) {
                                                        ?>
                                                        <option value="<?php echo $value2['Id'] ?>">
                                                            <?php echo $value2['workflow_Master'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3" id='ddd'>
                                                <label for="ops_remarks">Remarks (optional)</label>
                                                <div class="input-group">

                                                    <input type="text" class="form-control" id="opstospocremarks"
                                                        name="opstospocremarks" placeholder="Enter Remarks">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4 mb-3 omflow none ">
                                                <br><br>

                                                <div class="checkbox">
                                                    &nbsp; <input type="checkbox" id="tech_skip" name="tech_skip">
                                                    <label for="tech_skip"><b>Technical SignOff Required</b></label>
                                                </div>



                                            </div> -->
                                            <!-- <div class="col-md-4 mb-3   none">
                                                <label for="doc_name">Doc Name</label>
                                                <input type="text" readonly="" class="form-control" id="doc_name"
                                                    name="doc_name" value="OM SignOff" placeholder="OM SignOff">
                                            </div> -->
                                            <!-- <div class="col-md-4 mb-3   none">
                                                <label for="proj_location">Upload File</label>
                                                <div class="input-group mb-3">

                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="inputGroupFile01">
                                                        <label class="custom-file-label " for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>

                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>

                                            </div> -->
                                            <!-- <div class="row none">
                                                <label for="proj_location">Upload File</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-8 mb-3 omflow none">
                                                <div id="fileuploader">Upload</div>
                                                <input type="hidden" name="ptwattachment" id="uploadimage" />
                                                <input type="hidden" name="imgcount" id="imgcount" value="0" />
                                                <input type="hidden" name="imgrow" id="imgrow" value="" />
                                                <br />
                                                <ul id="fileList" style="text-align: left;">
                                                </ul>

                                            </div> -->
                                        </div>
                                        <div class="form-row omflow none">
                                            <div class="col-md-3 mb-3  ">
                                                <label for="doc_name">Doc Type</label>
                                                <input type="text" class="form-control" id="doc_name" name="doc_name"
                                                    readonly value="O&M signoff">
                                            </div>
                                            <div class="col-md-6 mb-6">
                                                <label for="proj_location">Upload File</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="inputGroupFile01">
                                                        <label class="custom-file-label " for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <input type="hidden" id="ops_rem" value="1">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input type="checkbox" id="keyattach" name="keyattach">
                                                <label for="keyattach" style="margin-top:20%;">Key
                                                    Attachment</label>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-1 mb-2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-success" type="button"
                                                            id="ops_expert_filesup"
                                                            onclick="common_filesuplod()">Upload</button>
                                                    </div>
                                                </div> -->


                                        <div id="table-responsive"></div>
                                        <input type="hidden" name="pck_id" id="pck_id">
                                        <button class="btn btn-primary" id="pck_create" type="submit"
                                            name="package_create">Submit</button>
                                        <button class="btn btn-success none" id="pck_update" type="submit"
                                            name="package_update">Update</button>
                                        <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                                        <button class="btn btn-danger" type="button" id="cancelbtn"
                                            onclick="cancelpackage()" name="cancel_form">Cancel</button>
                                    </form>
                                </div>
                            </div>
                            <div id="navpills-2" class="tab-pane">
                                <div class="row">
                                    <form class="needs-validation" novalidate method="post"
                                        action="functions/package_master_form.php" autocomplete="off"
                                        enctype="multipart/form-data">
                                        <div class="form-row">
                                            <input type="hidden" name="epage_name" value="masters">
                                            <div class="col-md-4 mb-4">
                                                <label for="eproj_name">Project Name</label>
                                                <select class="custom-select" name="eproj_name" id="eproj_name"
                                                    required="">
                                                    <option value="">--Select Project--</option>
                                                    <?php
                                                    $result = $cls_comm->select_allprojects_seg($segment);
                                                    $res = json_decode($result, true);
                                                    foreach ($res as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value['proj_id'] ?>">
                                                            <?php echo $value['proj_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                </select>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-8">
                                                <label for="proj_location">Upload Excel File</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="file" name="file" class="custom-file-input"
                                                            id="inputGroupFile01" required="">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                    <a href="downloads/Package upload sample.csv"> <img
                                                            src="images/ms_excel.png" alt="" height="35" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <button class="btn btn-primary" type="submit"
                                            name="package_excel_upload">Submit</button> -->
                                        <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                                        <button class="btn btn-danger" type="button" id="cancelbtn"
                                            onclick="cancelpackage()" name="cancel_form">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                } else {
                    $msg = '';
                }
                if ($msg == '0') {
                    ?>
                    <div class="alert alert-danger alert-rounded">
                        <i class="fa fa-exclamation-triangle"></i> Package Name Alreay Exists
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                aria-hidden="true">×</span> </button>
                    </div>
                <?php }
                ?>
            </div>
        </div>
        <!-- basic table -->
        <div class="row">

            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <h4 class="card-title">Package Master</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button"
                                onclick="create_newproj();"><i class="icon-plus"></i> &nbsp;Create New</button></div>
                        <div class=" pull-right" id="pack_button"><a href="files_from_contract"><button
                                    class="btn btn-primary" type="button"><i class="icon-eye"></i> &nbsp;View Files From
                                    Contract</button></a></div>

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered border">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Created Date</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Required</th>
                                        <th>Lead Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_allpackages($pid, $segment);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $picked_package = $cls_comm->select_packcount($pid, $value['pm_packid']);

                                        ?>
                                        <tr>
                                            <td>
                                                <?php echo $value['proj_name'] ?>
                                            </td>
                                            <td>
                                                <?php echo $value['pm_packagename'] ?>
                                            </td>
                                            <td>
                                                <?php echo formatDate($value['pm_createdate'], 'd-M-Y'); ?>
                                            </td>
                                            <td>
                                                <?php echo formatDate($value['pm_material_req'], 'd-M-Y'); ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo formatDate($value['pm_revised_material_req'], 'd-M-Y');
                                                $diff = ($value['pm_leadtime'] + 59);
                                                $start = formatDate($value['pm_revised_material_req'], 'Y-m-d'); 
                                                $end = date('Y-m-d', strtotime($start . '+' . $diff . 'days'));
                                                ?>


                                            </td>
                                            <td>
                                                <?php echo $value['pm_leadtime']; ?>
                                            </td>
                                            <td>
                                                <?php if ($picked_package < 2) { ?> <span
                                                        onclick="view_packdetails('<?php echo $value['pm_projid']; ?>', '<?php echo $value['pm_packid']; ?>')"
                                                        class="badge badge-pill badge-danger font-medium text-white ml-1"
                                                        style=" cursor: pointer;"><i class="icon-pencil"></i> Edit</span>
                                                <?php } ?>
                                                <span
                                                    onclick="onhold_packdetails('<?php echo $value['pm_projid']; ?>', '<?php echo $value['pm_packid']; ?>')"
                                                    class="badge badge-pill badge-danger font-medium  ml-1"
                                                    style=" cursor: pointer;color: #212529;background-color: #ffc36d;">On
                                                    Hold</span>
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
    include_once ('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<?php
include_once ('layout/rightsidebar.php');
include_once ('layout/footer.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        var someDate = new Date();
        //var numberOfDaysToAdd = 15;
        //var result = someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
        //console.log(new Date(result))
        $('#org_schedule').datepicker({
            format: "dd-M-yy",
            //startDate: new Date(result)
        });
        $('#mat_req_site').datepicker({
            format: "dd-M-yy",
            //startDate: new Date(result)
        });

    });
</script>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
    function create_newproj() {
        $('#package_create').show()
    }

    function cancelpackage() {
        $('#package_create').hide()
    }
    $('#packform').on('submit', function () {
        var proj_name = $('#proj_name').val();
        var pack_name = $('#pack_name').val();
        var pack_cat_name = $('#pack_cat_name').val();
        var org_schedule = $('#org_schedule').val();
        var mat_req_site = $('#mat_req_site').val();
        var lead_time = $('#lead_time').val();
        var opstospocremarks = $('#opstospocremarks').val();
        var user_filter = $('#user_filter').val();
        var tech_skip = $('#tech_skip').val();
        var omsegs = $('#omsegs').val();
        var img = $('#uploadimage').val();
        var y = img.split(',');
        if (proj_name == "") {
            alert('Please Select Project Name');
            return false;

        } else if (pack_name == "") {
            alert('Please Select Project Name');
            return false;

        } else if (pack_cat_name == "") {
            alert('Please Select Package Catagory');
            return false;

        } else if (org_schedule == "") {
            alert('Please Select Original Schedule date');
            return false;

        } else if (mat_req_site == "") {
            alert('Please Select Material Reuire at Site');
            return false;

        } else if (lead_time == "") {
            alert('Please Fill Lead Time');
            return false;

        } else if (opstospocremarks == "") {
            alert('Please Fill Remarks');
            return false;
        } else if (user_filter == "") {
            alert('Please Select User');
            return false;
        } else {
            if (!$('#tech_skip').is(":checked")) {
                if (omsegs == 35) {
                    if (y.length <= 1) {
                        alert('Attachment Mandatory');
                        return false;

                    } else {

                        return confirm('This Operation will skip Technical signoff!!! Are you sure you want to submit?');
                    }
                } else {
                    return true;
                }

            } else {
                return true;

            }

        }



    });

    $("#tech_skip").click(function () {
        if (!$('#tech_skip').is(":checked")) {
            return confirm('This Operation will skip Technical signoff!!! Are you sure you want to submit?');
        }
    });

    function omflowvalidate(pid) {
        $('#inputGroupFile01').replaceWith($('#inputGroupFile01').val('').clone(true));
        $.post("code/omflowvalidate.php", {
            proj_id: pid
        }, function (data) {
            // if ($.trim(data) == 35) {
            //     $('.omflow').attr('style','display:flex');
            //     $('#omsegs').val(35);
            //     $('#inputGroupFile01').val('');
            // } else if ($.trim(data) == 39) {
            //     $('.omflow').attr('style','display:flex');
            //     $('#inputGroupFile01').val('');
            //     $('#omsegs').val(35);
            // } else {
            //     $('.omflow').hide();
            // }
            if ($.trim(data) == 35 || $.trim(data) == 39) {
                $('.omflow').attr('style', 'display:flex');
                $('#omsegs').val(35);
            } else {
                $('.omflow').hide();
            }
        });

    }
    $(document).ready(function () {
        $("#fileuploader").uploadFile({
            url: 'code/omsignoffattachmentupload.php',
            fileName: "myfile",
            showDelete: true,
            onSuccess: function (files, data, xhr, pd) {
                var imgcount = parseInt($('#imgcount').val());

                imgcount = imgcount + 1;
                //row
                var imgrow = $('#imgrow').val();
                var imgrowres = imgrow.split(',');
                imgrowres.push(imgcount);
                var imgrow1 = imgrowres.toString();
                $('#imgrow').val(imgrow1);

                //imagename
                var img = $.trim($('#uploadimage').val());
                var res = img.split(',');
                res.push($.trim(data));
                var img1 = $.trim(res.toString());
                $('#uploadimage').val(img1);

                $('#imgcount').val(imgcount);
                //                                                        var html = '<li id="remove' + imgcount + '" >' + data + '<a href="javascript:;" style="color: red;" onclick="removeimg(' + imgcount + ')" > <i class="fa fa-times"></i></a></li>';
                //                                                        $('#fileList').append(html);
            },
            deleteCallback: function (data, pd, files) {

                //                                                    for (var i = 0; i < data.length; i++)
                //                                                    {
                $.post("code/omdelete.php", {
                    op: "delete",
                    name: data
                },
                    function (resp, textStatus, jqXHR) {
                        //Show Message    

                        alert("File Deleted");
                        remove($.trim(data));
                        //                                                                  
                    });
                //                                                    }
                pd.statusbar.hide(); //You choice to hide/not.

            },
            extraHTML: function () {
                var html = "<div><b>Doc Name:</b><input type='text' name='tags[]'   value='OM SignOff' /> <br/>";

                html += "</div>";
                return html;
            },
        });


    });

    function remove(data) {

        var removeItem = data;
        //                                                alert(removeItem);
        var img = $('#uploadimage').val();
        var y = img.split(',');

        y = jQuery.grep(y, function (value) {
            return value != removeItem;
        });
        var img1 = y.toString();
        //                                                alert(img1);
        $('#uploadimage').val(img1);
    }

    function wf_onchange(id) {
        //alert(id);
        var matrequired = document.getElementById('mat_req_site').value;
        // var org = document.getElementById('org_schedule').value;
        var lead = document.getElementById('lead_time').value;
        var proj_name = document.getElementById('proj_name').value;
        if (proj_name == '') {
            alert('Please Select Project Name');
            document.getElementById("mat_req_site").value = '';
        } else if (lead != '') {
            $.ajax({
                url: 'calculate.php',
                method: 'POST',
                data: {
                    mat: matrequired,
                    lead: lead,
                    id: id,
                },
                success: function (response) {
                    document.getElementById('table-responsive').innerHTML = response;
                }
            });
        }
    }
    function mat_change() {
        var mat_req_site = $('#mat_req_site').val();
        var lead_time = $('#lead_time').val();
        var today = new Date();
        var d = new Date();
        d.setDate(d.getDate() + 42);
        d1 = new Date(mat_req_site);
        if (d1 > d) {
            $("#lt_violation").val("0");
        } else {
            // var conf2 = confirm("Lead Time Violation Happening Do You Want to Continue");
            //  document.getElementById('mat_req_site').onclick = function () {
            swal({
                title: "Are you sure?",
                text: "Lead Time Violation Happening Do You Want to Continue!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                // confirmButtonColor: '#008000',
                confirmButtonText: 'OK',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
                function (isConfirm) {
                    swal("OK!", "Lead Time Violation Happening Do You Want to Continue!", "success");
                    if (isConfirm) {
                        $("#lt_violation").val("1");
                    } else {
                        $("#mat_req_site").val("");
                        $("#lt_violation").val("0");
                    }


                });

            //  };

            // if (!conf2) {
            //     $("#mat_req_site").val("");
            //     $("#lt_violation").val("0");
            //     return false;
            // } else {
            //     $("#lt_violation").val("1");
            // }
        }
        $("#clear_data").html("");
        document.getElementById("pack_work_flow").selectedIndex = "0";
    }
</script>



<script>


    function onhold_packdetails(projid, packid) {
        var flag = '';
        swal({
            title: "Are you sure?",
            text: "This Package Is On Hold Do You Want to Continue!!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            // confirmButtonColor: '#008000',
            confirmButtonText: 'OK',
            closeOnConfirm: false,
            //closeOnCancel: false
        },
            function (isConfirm) {
                swal("OK!", "his Package Is On Hold Do You Want to Continue!", "success");
                if (isConfirm) {
                    var flag = 1;
                    $.post("code/holdon_package.php", {
                        projid: projid,
                        packid: packid,
                        flag: flag,
                    }, function (data) {


                    });
                } else {
                    var flag = 0;
                }

            });

        // $.ajax({
        //     url: 'functions/package_master_form.php',
        //     method: 'POST',
        //     data: {
        //         projid: projid,
        //         packid: packid,
        //         flag: flag,
        //     },
        //     success: function (response) {
        //         //  document.getElementById('table-responsive').innerHTML = response;

        //     }
        // });
    }

    function load_proj_by_proj_type(id) {
        $.post("functions/proj_type_Filter.php", {
            key: id,
        }, function (data) {
            //console.log(data);
            var projectlist = JSON.parse(data).projectlist;
            var list = JSON.parse(projectlist);
            var option = '<option value="" >---Select Project --</option>';
            $(list).each(function (key, value) {
                option += '<option value="' + value.proj_id + '" >' + value.proj_name + '</option>';
            });

            $('#proj_name').html('');
            $('#proj_name').append(option);
        });
    }
</script>