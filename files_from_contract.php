<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';

//$generate_token = generate_token();
$segment = $_SESSION['swift_dep'];

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

ini_set('display_errors', 'Off');
// define("HOST","BLK-WEBPWV01");
//define("HOST","103.154.252.98");
//define("USERNAME","lntsa");
//define("PASSWORD","Lnt@123?");
//define("DBNAME","lnt_track");


//print_r($con);

?>
<style>
    tr {
        cursor: pointer
    }

    .selected {
        background-color: lemonchiffon;
        color: black;
        font-weight: bold
    }

    button {
        margin-top: 5px;
        background-color: #eee;
        border: 2px solid #00F;
        color: #17bb1c;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer
    }
</style>
<style>
    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }

    div#fileuploader {
        margin-top: 20px;
    }

    /* 
    .checkbox {
        width: 100%;
        
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
    } */
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
                <h5 class="font-medium text-uppercase mb-0"> <a href="ops_dashboard"> Projects From Contracts</a></h5>
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
                    onchange="proj_Filter(this.value, '3')" required="">
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
                        <li class="breadcrumb-item active" aria-current="page">Projects From Contracts</li>
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

        <div class="row" id="package_create" style="display: none ;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="tab_select">
                        <!-- <h4 class="card-title">Package Creation Form</h4> -->
                        <ul class="nav nav-pills mt-4 mb-1">
                            <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab"
                                    aria-expanded="false">Manual Entry</a> </li>
                            <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab"
                                    aria-expanded="false">Excel Upload</a> </li>
                        </ul>
                        <div class="tab-content border p-4">
                            <div id="navpills-1" class="tab-pane active">
                                <div class="row">

                                    <form id="packform" class="needs-validation" novalidate method="post"
                                        action="functions/package_master_form.php" autocomplete="off"
                                        enctype="multipart/form-data">

                                        <input type="hidden" name="page_name" value="files">
                                        <input type="hidden" name="omsegs" id="omsegs" value="">
                                        <div class="form-row">
                                            <!--                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?php // echo $generate_token; 
                                            ?>" />-->
                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Project Name</label>
                                                <select class="custom-select" name="proj_name" id="proj_name"
                                                    required="" onchange="omflowvalidate(this.value);">
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


                                            <div class="col-md-2 mb-3">
                                                <label for="org_schedule">Original Schedule</label>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i
                                                                class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control org_schedule"
                                                        id="org_schedule" name="org_schedule" required=""
                                                        placeholder="dd/mmm/yyyy">

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

                                            <div class="col-md-3 mb-3">
                                                <label for="segment">Work Flow</label>
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
                                            <div class="col-md-4 mb-3">
                                                <label for="ops_remarks">Remarks</label>
                                                <div class="input-group">

                                                    <input type="text" class="form-control" id="opstospocremarks"
                                                        name="opstospocremarks" required="" placeholder="Enter Remarks">

                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 omflow none">
                                                <br><br>
                                                <div class="checkbox">
                                                    &nbsp; <input type="checkbox" id="tech_skip" name="tech_skip">
                                                    <label for="tech_skip">Technical SignOff Required</label>
                                                </div>

                                            </div>
                                            <div class="col-md-4 mb-3 none">
                                                <label for="doc_name">Doc Name</label>
                                                <input type="text" class="form-control" id="doc_name" name="doc_name"
                                                    value="OM SignOff" placeholder="OM SignOff">
                                            </div>
                                            <div class="col-md-4 mb-3 none">
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

                                            </div>
                                            <div class="col-md-8 mb-3 omflow none">
                                                <div id="fileuploader">Upload</div>
                                                <!-- <input type="file" name="ptwattachment[]" id="ptwattachment" multiple="multiple" onchange="javascript:updateList()" >  -->
                                                <input type="hidden" name="ptwattachment" id="uploadimage" />
                                                <input type="hidden" name="imgcount" id="imgcount" value="0" />
                                                <input type="hidden" name="imgrow" id="imgrow" value="" />
                                                <br />
                                                <ul id="fileList" style="text-align: left;">
                                                </ul>

                                            </div>

                                        </div>
                                        <div id="table-responsive">

                                        </div>
                                        <button class="btn btn-primary" type="submit"
                                            name="package_create">Submit</button>
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
                                            <input type="hidden" name="epage_name" value="files">
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

                                        <button class="btn btn-primary" type="submit"
                                            name="package_excel_upload">Submit</button>
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
                        <h4 class="card-title">Files From Contract</h4>
                        <!-- <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();"><i class="icon-plus"></i> &nbsp;Create New Package</button></div> -->
                        <div class=" pull-right" id="pack_button"><a href="package_master"><button
                                    class="btn btn-primary" type="button"><i class="icon-eye"></i> &nbsp;View
                                    Packages</button></a></div>
                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered border">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Segment</th>
                                        <th>Creator</th>
                                        <th>Hand. Over. Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id='clear_data'>
                                    <?php
                                    $result = $cls_comm->select_project_notpackage($pid, $segment);
                                    $res = json_decode($result, true);

                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><span style="display: none">
                                                    <?php echo $value['proj_id']; ?>
                                                </span>
                                                <?php echo $value['proj_name'] . '(' . $value['shortcode'] . ')' ?>
                                            </td>
                                            <td>
                                                <?php echo $value['catagories']; ?>
                                            </td>
                                            <td><label class="badge badge-pill badge-primary font-medium text-white ml-1"><i
                                                        class=" mdi mdi-account-key"> </i>
                                                    <?php echo $value['name']; ?>
                                                </label></td>
                                            <td> <label class="badge badge-pill badge-success font-medium text-white ml-1"
                                                    onclick="swal('<?php echo $value['hand_over_remarks'] ?>');"><i
                                                        class=" mdi mdi-comment-check-outline"> </i> View</label></td>
                                            <td> <a href="project_ops_master?id=<?php echo $value['proj_id']; ?>"><span
                                                        class=" badge badge-primary brown" style=" cursor: pointer;"
                                                        data-toggle="tooltip" data-original-title="Approve Checklist"><i
                                                            class="fas fa-pencil-alt"></i>Con. docs View/Accept</span>
                                                </a>
                                                <!--<span onclick="create_newpackage(<?php echo $value['proj_id']; ?>);" class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Create Packages"><i class="fas fa-plus-circle"></i> Create Packages</span>-->

                                                <a href="project_ops_master?id=<?php echo $value['proj_id']; ?>"><span
                                                        class=" badge badge-primary orange" style=" cursor: pointer;"
                                                        data-toggle="tooltip" data-original-title="Update Project"><i
                                                            class="fas fa-pencil-alt"></i> Update ACE Details</span>
                                                </a>

                                            </td>

                                        </tr>
                                    <?php } ?>
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
    include_once('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>

<script type="text/javascript">
    $(document).ready(function () {
        var someDate = new Date();
        var numberOfDaysToAdd = 15;
        var result = someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
        console.log(new Date(result))
        $('#org_schedule').datepicker({
            format: "dd-M-yy",
            startDate: new Date(result)
        });
        $('#mat_req_site').datepicker({
            format: "dd-M-yy",
            startDate: new Date(result)
        });

    });
</script>
<script src="code/js/ops.js" type="text/javascript"></script>

<script>
    var index;

    function create_newproj() {
        $('#package_create').show()
    }
    // function org_change() {
    //     $("#clear_data").html("");
    //     document.getElementById("pack_work_flow").selectedIndex = "0"; 
    // }
    function mat_change() {
        $("#clear_data").html("");
        document.getElementById("pack_work_flow").selectedIndex = "0";
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
        var tech_skip = $('#tech_skip').val();
        var omsegs = $('#omsegs').val();
        var img = $('#uploadimage').val();
        var y = img.split(',');
        //                                                var attach = $('#inputGroupFile01').val();
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
        $.post("code/omflowvalidate.php", {
            proj_id: pid
        }, function (data) {
            if ($.trim(data) == 35) {
                $('.omflow').show();
                $('#omsegs').val(35);
            } else if ($.trim(data) == 39) {
                $('.omflow').show();
                $('#omsegs').val(35);
            } else {
                $('.omflow').hide();
                $('#omsegs').val('');

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
                var html = "<div><b>Doc Name:</b><input type='text' name='tags[]' value='OM SignOff' /> <br/>";

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
    /*function changecheck(ids) {
        var proj_name=document.getElementById('proj_name').value;
        var pack_name=document.getElementById('pack_name').value;
        var pack_cat_name=document.getElementById('pack_cat_name').value;
        var org_schedule=document.getElementById('org_schedule').value;
        //alert(ids);
        var mat_req_site=document.getElementById('mat_req_site').value;
        var org_schedule=document.getElementById('org_schedule').value;
            var lead_time=document.getElementById('lead_time').value;
            var sum=document.getElementById('sum').value;
            
            var id=ids;
            if(proj_name==''){
                 alert('Please Select Project Name');
                      document.getElementById("check"+id).checked = false;
            }
            else if(pack_name==''){
                 alert('Please Select Project Name');
                 document.getElementById("check"+id).checked = false;
                
            }
            else if(pack_cat_name==''){
                  alert('Please Select Package Catagory');
                   document.getElementById("check"+id).checked = false;
                
            }
            else if(org_schedule==''){
                    alert('Please Select Original Schedule date');
                        document.getElementById("check"+id).checked = false;
                
                
            }
            else if(mat_req_site==''){
                
                alert('Please Select Material Reuire at Site');
                document.getElementById("check"+id).checked = false;
                
            }
            
            else if(lead_time==''){
                
                alert('Please Fill Lead Time');
                document.getElementById("check"+id).checked = false;
            }
            
            else {
        $.ajax({
                url:'check.php',
                method:'POST',
                data:{
                    mat:mat_req_site,
                    org:org_schedule,
                    lead:lead_time,
                    id:id
                },
                 dataType: 'json',
                success:function(response){
                
            
            
                document.getElementById('result'+id).value=response.date.toString();
                    
                    }
        });
            }
        //var lead_time=document.getElementById("myText").value;
        
    }*/
    function change(id) {
        if (document.getElementById("check" + id).checked == false) {

            document.getElementById('result' + id).value = '';

        } else if (document.getElementById("check" + id).checked == true) {
            var mat_req_site = document.getElementById('mat_req_site').value;
            var lead_time = document.getElementById('lead_time').value;
            $.ajax({
                url: 'check.php',
                method: 'POST',
                data: {
                    mat: mat_req_site,

                    lead: lead_time,
                    id: id
                },
                dataType: 'json',
                success: function (response) {



                    document.getElementById('result' + id).value = response.date.toString();

                }
            });



        }



    }
    // variable to set the selected row index
    function getSelectedRow() {
        var table = document.getElementById("table");
        for (var i = 1; i < table.rows.length; i++) {
            table.rows[i].onclick = function () {
                // clear the selected from the previous selected row
                // the first time index is undefined
                if (typeof index !== "undefined") {
                    table.rows[index].classList.toggle("selected");
                }

                index = this.rowIndex;
                this.classList.toggle("selected");

            };
        }

    }


    getSelectedRow();

    function up() {
        var rows = document.getElementById("table").rows,
            parent = rows[index].parentNode;
        if (index > 1) {
            parent.insertBefore(rows[index], rows[index - 1]);

            index--;
        }



    }

    function down() {
        if (index < rows.length - 1) {
            parent.insertBefore(rows[index + 1], rows[index]);
            index++;
        }



    }

    // function calculatechange(date) {

    //     var matrequired = date;
    //     var lead = document.getElementById('lead_time').value;
    //     var proj_name = document.getElementById('proj_name').value;
    //     if (proj_name == '') {
    //         alert('Please Select Project Name');
    //         document.getElementById("mat_req_site").value = '';

    //     } else if (lead != '') {

    //         $.ajax({
    //             url: 'calculate.php',
    //             method: 'POST',
    //             data: {
    //                 mat: matrequired,
    //                 lead: lead,



    //             },

    //             success: function(response) {



    //                 document.getElementById('table-responsive').innerHTML = response;

    //             }
    //         });
    //     }

    // }

    function wf_onchange(id) {
        //alert(id);
        var matrequired = document.getElementById('mat_req_site').value;
        var org = document.getElementById('org_schedule').value;
        var lead = document.getElementById('lead_time').value;
        var proj_name = document.getElementById('proj_name').value;
        if (proj_name == '') {
            alert('Please Select Project Name');
            document.getElementById("mat_req_site").value = '';
            document.getElementById("org_schedule").value = '';
        } else if (lead != '') {
            $.ajax({
                url: 'calculate.php',
                method: 'POST',
                data: {
                    mat: matrequired,
                    lead: lead,
                    org: org,
                    id: id,
                },
                success: function (response) {
                    document.getElementById('table-responsive').innerHTML = response;

                }
            });
        }
    }
</script>