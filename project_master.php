<?php
include 'config/inc.php';
if (isset($_GET['id'])) {
    $eid = $_GET['id'];
} else {
    $eid = "";
}
if (isset($_GET['del'])) {

}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
$generate_token = generate_token();
?>
<style>

    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }
    
/* Blink for Webkit and others
(Chrome, Safari, Firefox, IE, ...)
*/

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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Project Master</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Project Master</li>
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

        <div class="row" id="project_create" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Validation Form</h4>-->
                        <form class="needs-validation" method="post" action="functions/conhead_form.php">
                            <div class=" col-md-12 mb-3" style="    margin-left: -7px;   border: 1px solid #B2C0CE;     padding: 10px;">

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="proj_name">Project Short name</label>
                                        <input type="text" class="form-control" id="proj_name"  name="proj_name" placeholder="Short Name" value="" required>
                                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $generate_token; ?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="proj_shrtname">Project  name</label>
                                        <input type="text" class="form-control" id="proj_shrtname" name="proj_shrtname" placeholder="Project Name" value="" required>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="segment">Project Segment</label>
                                        <select class="custom-select" name="segment" id="segment" required="">
                                            <option value="">--Select Segment--</option>
                                            <?php
                                            if ($_SESSION['milcom'] == '1') {
                                                $seg = "38";
                                            } else {
                                                $seg = "";
                                            }
                                            $result = $cls_comm->select_segment($seg);


                                            $res = json_decode($result, true);
                                            foreach ($res as $key => $value) {
                                                ?>
                                                                <option value="<?php echo $value['seg_pid'] ?>"><?php echo $value['seg_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="proj_location">Project Location</label>
                                        <div class="input-group">

                                            <input type="text" class="form-control" id="proj_location" name="proj_location" placeholder="Project Location" aria-describedby="inputGroupPrepend" required>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="proj_address">Project Address</label>
                                        <input type="text" class="form-control" id="proj_address" name="proj_address" placeholder="Project Address" value="" required>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="proj_jobcode">Job Code</label>
                                        <input type="text" class="form-control" id="proj_jobcode" name="proj_jobcode" placeholder="Job Code" value="" required>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>



                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="start_date">Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="start_date" name="start_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="end_date">End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="end_date" name="end_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="revend_date">Revised End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="revend_date" name="revend_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="handing_over_remarks">Handing Over Remarks</label>
                                        <input type="text" class="form-control" id="handing_over_remarks" name="h_o_remarks" placeholder="Handing Over Remarks" value="" required>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="segment">Project Type</label>
                                        <select class="custom-select" name="proj_type" id="proj_type"
                                            required="">
                                            <option value="">--Select Project Type--</option>
                                            <?php
                                            $result4 = $cls_comm->select_swiftpacktype();
                                            $res4 = json_decode($result4, true);
                                            foreach ($res4 as $key => $value) {
                                                ?>
                                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['type_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div> 

                            </div>


                            <div    >
                                <div class=" col-md-12 mb-3" style=" float: left;         margin-left: -7px;  border: 1px solid #B2C0CE;">

                                    <div class=" form-row" style=" padding: 10px;">
                                        <div class="col-md-4 mb-3">
                                            <label for="start_date">Client LOI Date </label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="client_loi" name="client_loi"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="end_date">Contract Agreement Date </label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="cont_agree" name="cont_agree"  placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3" style=" display: none">
                                            <label for="revend_date">Kick Off Meeting Date </label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="kick_meet" name="kick_meet"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3" style=" display: none">
                                            <label for="start_date">Techno Commercial Handing Over to Operations</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="tech_comer" name="tech_comer"  placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="end_date">Tender Costing Handing Over to Operations  </label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="tech_cost" name="tech_cost"   placeholder="dd/mmm/yyyy">

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>


                                    </div>


                                </div>
                                <div class=" col-md-4 mb-3" style=" float: right;  ">
                                </div>
                                <div class=" col-md-4 mb-3" style=" display: none; float: right; height: 14.45em; border: 1px solid #B2C0CE;">

                                    <div class="col-md-12 mb-3" style=" padding: 2px;">
                                        <label for="start_date">ACE Sheet Submission   for Mgmt.</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="ace_sub" name="ace_sub"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="end_date">ACE Sheet Approved   by Bu Head</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="ace_sheet" name="ace_sheet"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>


                                </div>
                            </div>


                            <button class="btn btn-primary" type="submit" name="project_create">Submit</button>
                            <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelproj()" name="cancel_form">Cancel</button>
                            <br> <br><div class=" col-md-12 mb-3"  style=" float: left;         margin-left: -7px; ">
                                <div class=" col-md-12 mb-3" >
                                    <span class="pull-left">Handing over Start Date:  </span>
                                    <span class="pull-right"> Handing over End Date:  </span>
                                </div>
                                <table class=" table table-bordered">
                                    <thead>
                                    <th> S.No</th>
                                    <th> Documents</th>
                                    <th>Handing Over Completed</th>
                                    <th>Date of Handing Over</th>
                                    <th>Attachments</th>
                                    <th>View</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $cls_comm->select_ckaddon();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                                            <tr>
                                                                <td><?php echo $key + 1; ?></td>
                                                                <td><?php echo $value['ck_name']; ?></td>
                                                                <td>
                                                                    <div class="form-check form-check-inline ">
                                                                        <div class="custom-control custom-radio ">
                                                                            <input type="radio" class="custom-control-input pointer" disabled="" id="customControlValidation<?php echo $value['ck_id']; ?>" name="radio<?php echo $value['ck_id']; ?>">
                                                                            <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation<?php echo $value['ck_id']; ?>">Yes</label>
                                                                        </div>

                                                                        <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                            <input type="radio" class="custom-control-input pointer" disabled id="customControlValidation<?php echo $value['ck_id']; ?>" name="radio<?php echo $value['ck_id']; ?>">
                                                                            <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation<?php echo $value['ck_id']; ?>">No</label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td> 
                                                                </td>
                                                                <td>

                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>
<?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

<?php if ($eid != "") { ?>

                            <div class="row" id="project_edit">
                                <div class="col-12" >
                                    <div class="card">
                                        <div class="card-body" >
                                            <!--                        <h4 class="card-title">Validation Form</h4>-->
                                            <form class="needs-validation" method="post" action="functions/conhead_form.php">
                                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $generate_token; ?>" />

                    <?php
                    $result = $cls_comm->select_projects($eid);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                                                                    <div class=" col-md-12 mb-3" style="    margin-left: -7px;   border: 1px solid #B2C0CE;     padding: 10px;">

                                                                        <div class="form-row">
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="proj_name">Project Short name</label>
                                                                                <input type="text" class="form-control" id="proj_name"  name="proj_name"  value="<?php echo $value['proj_name'] ?>" required>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="proj_shrtname">Project name</label>
                                                                                <input type="text" class="form-control" id="proj_shrtname" name="proj_shrtname" value="<?php echo $value['shortcode'] ?>" required>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="segment">Project Segment</label>
                                                                                <select class="custom-select" name="segment" id="segment" required="">
                                                                                    <option value="">--Select Segment--</option>
                                        <?php
                                        if ($_SESSION['milcom'] == '1') {
                                            $seg = "38";
                                        } else {
                                            $seg = "";
                                        }
                                        $result = $cls_comm->select_segment($seg);
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $val) {
                                            if ($val['seg_pid'] == $value['cat_id']) {
                                                $msg = "selected";
                                            } else {
                                                $msg = "";
                                            }
                                            ?>
                                                                                                        <option value="<?php echo $val['seg_pid'] ?>" <?php echo $msg ?>><?php echo $val['seg_name'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="proj_location">Project Location</label>
                                                                                <div class="input-group">

                                                                                    <input type="text" class="form-control" id="proj_location" name="proj_location"  value="<?php echo $value['location'] ?>" required>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="proj_address">Project Address</label>
                                                                                <input type="text" class="form-control" id="proj_address" name="proj_address" value="<?php echo $value['address'] ?>" required>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="proj_jobcode">Job Code</label>
                                                                                <input type="text" class="form-control" id="proj_jobcode" name="proj_jobcode" placeholder="Job Code" value="<?php echo $value['proj_jobcode'] ?>" required>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="start_date">Start Date</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                    </div>
                                        <?php
                                        $sdate = formatDate($value['proj_created_date'], 'd-M-Y');
                                        $sdate = formatDate($sdate, 'd-M-Y');
                                        ?>
                                                                                    <input type="text" class="form-control mydatepicker" id="start_date" name="start_date" required="" value="<?php echo $sdate ?>">

                                                                                </div>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="end_date">End Date</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                    </div>
                                        <?php
                                        $edate = formatDate($value['proj_edate'], 'd-M-Y');
                                        $edate = formatDate($edate, 'd-M-Y');
                                        ?>
                                                                                    <input type="text" class="form-control mydatepicker" id="end_date" name="end_date" required="" value="<?php echo $edate ?>">

                                                                                </div>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                                <label for="revend_date">Revised End Date</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                    </div>
                                        <?php
                                        $rdate = formatDate($value['proj_revised_edate'], 'd-M-Y');
                                        $rdate = formatDate($rdate, 'd-M-Y');
                                        ?>
                                                                                    <input type="text" class="form-control mydatepicker" id="revend_date" name="revend_date" required="" value="<?php echo $rdate ?>">

                                                                                </div>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-8 mb-3">
                                                                                <label for="handing_over_remarks">Handing Over Remarks</label>
                                                                                <input type="text" class="form-control" id="handing_over_remarks" name="h_o_remarks" value="<?php echo $value['hand_over_remarks'] ?>" required>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 mb-3">
                                                                <label for="segment">Project Type</label>
                                                                <select class="custom-select" name="proj_type" id="proj_type"
                                                                    required="">
                                                                    <option value="">--Select Project Type--</option>
                                                                    <?php
                                                                    $result4 = $cls_comm->select_swiftpacktype();
                                                                    $res4 = json_decode($result4, true);
                                                                    foreach ($res4 as $key => $val) {
                                                                        if ($val['id'] == $value['proj_type']) {
                                                                            $msg = "selected";
                                                                        } else {
                                                                            $msg = "";
                                                                        }
                                                                        ?>
                                                                                        <option <?php echo $msg ?> value="<?php echo $val['id'] ?>"><?php echo $val['type_name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <div class="invalid-feedback">

                                                                </div>
                                                            </div>

                                                                        </div>  
                                                                    </div>
                                                                    <div class=" col-md-12 mb-3" >
                                                                        <div class=" col-md-12 mb-3" style=" float: left;      margin-left: -22px;   border: 1px solid #B2C0CE;">

                                                                            <div class=" row" style=" padding: 10px;">
                                                                                <div class="col-md-4 mb-3">
                                                                                    <label for="start_date">Client LOI Date </label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                        </div>
                                        <?php
                                 
                                        $client_loi = formatDate($value['client_loi'], 'd-M-Y');
                                        $client_loi = formatDate($client_loi, 'd-M-Y');
                                        ?>
                                                                                        <input type="text" value="<?php echo $client_loi; ?>" class="form-control mydatepicker" id="client_loi" name="client_loi"   placeholder="dd/mmm/yyyy">

                                                                                    </div>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <label for="end_date">Contract Agreement Date  </label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                        </div>
                                        <?php
                                        $cont_agree = formatDate($value['cont_agree'], 'd-M-Y');
                                        $cont_agree = formatDate($cont_agree, 'd-M-Y');

                                        ?>
                                                                                        <input type="text" value="<?php echo $cont_agree; ?>" class="form-control mydatepicker" id="cont_agree" name="cont_agree"  placeholder="dd/mmm/yyyy">

                                                                                    </div>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3" style="display:none;">
                                                                                    <label for="revend_date">Kick Off Meeting Date </label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                        </div>
                                        <?php
                                        
                                        $kick_meet =  formatDate($value['kick_meet'], 'd-M-Y');
                                        $kick_meet = formatDate($kick_meet, 'd-M-Y');
                                        ?>
                                                                                        <input type="text"  value="<?php echo $kick_meet; ?>" class="form-control mydatepicker" id="kick_meet" name="kick_meet"   placeholder="dd/mmm/yyyy">

                                                                                    </div>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3" style="display:none;">
                                                                                    <label for="start_date">Techno Commercial Handing Over to Operations</label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                        </div>
                                        <?php
                                        $tech_comer = formatDate($value['tech_comer'], 'd-M-Y');
                                        $tech_comer = formatDate($tech_comer, 'd-M-Y') ;
                                        ?>
                                                                                        <input type="text" value="<?php echo $tech_comer; ?>" class="form-control mydatepicker" id="tech_comer" name="tech_comer"  placeholder="dd/mmm/yyyy">

                                                                                    </div>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <label for="end_date">Tender Costing Handing Over to Operations  </label>
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-append">
                                                                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                        </div>
                                        <?php
                                        $tech_cost = formatDate($value['tech_cost'], 'd-M-Y');
                                        $tech_cost = formatDate($tech_cost, 'd-M-Y') ;
                                        ?>
                                                                                        <input type="text" value="<?php echo $tech_cost; ?>" class="form-control mydatepicker" id="tech_cost" name="tech_cost"   placeholder="dd/mmm/yyyy">

                                                                                    </div>
                                                                                    <div class="invalid-feedback">

                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                        <div class=" col-md-4 mb-3" style=" float: right;   ">
                                                                        </div>
                                                                        <div class=" col-md-4 mb-3" style=" display: none; float: right; height: 13.45em; border: 1px solid black;">


                                                                            <div class="col-md-12 mb-3" style=" padding: 2px;">
                                                                                <label for="start_date">ACE Sheet Submission Date for Mgmt.</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                    </div>
                                        <?php
                                        
                                        $ace_sub = formatDate($value['ace_sub'], 'd-M-Y');
                                        $ace_sub = formatDate($ace_sub, 'd-M-Y') ;
                                        ?>
                                                                                    <input type="text" value="<?php echo $ace_sub; ?>" class="form-control mydatepicker" id="ace_sub" name="ace_sub"   placeholder="dd/mmm/yyyy">

                                                                                </div>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 mb-3">
                                                                                <label for="end_date">ACE Sheet Approved Date by Bu Head</label>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-append">
                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                    </div>
                                        <?php
                                        $ace_sheet = formatDate($value['ace_sheet'], 'd-M-Y');
                                        $ace_sheet = formatDate($ace_sheet, 'd-M-Y') ;
                                        ?>
                                                                                    <input type="text" value="<?php echo $ace_sheet; ?>" class="form-control mydatepicker" id="ace_sheet" name="ace_sheet"   placeholder="dd/mmm/yyyy">

                                                                                </div>
                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="proj_id" id="proj_id" value="<?php echo $eid ?>">
                    <?php } ?> 

                                                <button class="btn btn-primary" type="submit" name="project_update">Update</button>
                                                <!-- <button class="btn btn-warning" type="reset" name="reset">Clear</button> -->
                                                <button class="btn btn-danger" type="button" id="cancelbtn" onclick="proj_editclose()" name="cancel_form">Cancel</button>
                                                <br><br>
                                                <div class=" col-md-12 mb-3"  style=" float: left; margin-left: -7px; ">
                                                    <div class=" col-md-12 mb-3" >
                                                        <span class="pull-left">Handing over Start Date: <span class="badge badge-success orange"><?php
                                                        $filldates = $cls_comm->filldates(1, $eid);
                                                        if ($filldates['cd_date'] != "") {
                                                            echo date('d-M-Y', strtotime($filldates['cd_date']));
                                                        }
                                                        ?></span></span>
                                                        <span class="pull-right"> Handing over End Date:<label class="badge badge-success brown"> <?php
                                                        $filldates = $cls_comm->filldates(10, $eid);
                                                        if ($filldates['cd_date'] != "") {
                                                            echo date('d-M-Y', strtotime($filldates['cd_date']));
                                                        }
                                                        ?></label></span>
                                                    </div>
                                                    <table class=" table table-bordered">
                                                        <thead>
                                                        <th> S.No</th>
                                                        <th> Documents</th>
                                                        <th>Handing Over Completed</th>
                                                        <th>Date of Handing Over</th>
                                                        <th>Attachments</th>
                                                        <th>View</th>
                                                        <th>Status</th>
                                                        </thead>
                                                        <tbody>
                    <?php
                    $result = $cls_comm->select_ckaddon();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        $filldates = $cls_comm->filldates($value['ck_id'], $eid);
                        ?>
                                                                                <tr>
                                                                                    <td><?php echo $key + 1; ?></td>
                                                                                    <td><?php echo $value['ck_name']; ?></td>
                                                                                    <td>
                                        <?php if ($filldates['cd_completed'] != "") { ?>
                                                                                                            <div class="form-check form-check-inline ">
                                                            <?php if ($filldates['cd_completed'] == 1) { ?>
                                                                                                                                    <div class="custom-control custom-radio ">
                                                                                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="1" checked id="customControlValidation1<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                        <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation1<?php echo $value['ck_id']; ?>">Yes</label>
                                                                                                                                    </div>
                                                                                                                                    <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="0" id="customControlValidation2<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                        <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation2<?php echo $value['ck_id']; ?>">No</label>
                                                                                                                                    </div>
                                                            <?php }
                                                            if ($filldates['cd_completed'] == 0) { ?>
                                                                                                                                    <div class="custom-control custom-radio ">
                                                                                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="1"  id="customControlValidation1<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                        <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation1<?php echo $value['ck_id']; ?>">Yes</label>
                                                                                                                                    </div>
                                                                                                                                    <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                                                                                        <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="0" checked id="customControlValidation2<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                                        <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation2<?php echo $value['ck_id']; ?>">No</label>
                                                                                                                                    </div>
                                                            <?php } ?>
                                                                                                            </div>
                                        <?php } else { ?>
                                                                                                            <div class="form-check form-check-inline ">
                                                                                                                <div class="custom-control custom-radio ">
                                                                                                                    <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="1" id="customControlValidation1<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                    <label class="custom-control-label" onclick="handover_show('<?php echo $value['ck_id']; ?>')" for="customControlValidation1<?php echo $value['ck_id']; ?>">Yes</label>
                                                                                                                </div>
                                                                                                                <div class="custom-control custom-radio" style="margin-left:18% !important;">
                                                                                                                    <input type="radio" class="custom-control-input pointer ra_but<?php echo $value['ck_id']; ?>" value="0" id="customControlValidation2<?php echo $value['ck_id']; ?>" name="radioname<?php echo $value['ck_id']; ?>">
                                                                                                                    <label class="custom-control-label" onclick="handover_hide('<?php echo $value['ck_id']; ?>')" for="customControlValidation2<?php echo $value['ck_id']; ?>">No</label>
                                                                                                                </div>
                                                                                                            </div>
                                        <?php }
                                        ?>

                                                                                    </td>
                                                                                    <td> 
                                                                                        <?php if ($filldates['cd_date'] != "") { ?>
                                                            <?php if ($filldates['cd_status'] == "1" || $filldates['cd_status'] == "0") { ?> 
                                                                                                                                <input type="text" disabled="" value="<?php echo date('d-M-Y', strtotime($filldates['cd_date'])); ?>" style="    width: 65%;" class="mydatepicker " id="date_hover<?php echo $value['ck_id']; ?>" name="date_hover<?php echo $value['ck_id']; ?>"   placeholder="dd/mmm/yyyy">

                                                                                                            <?php } else { ?>
                                                                                                                                <input type="text"   value="<?php echo date('d-M-Y', strtotime($filldates['cd_date'])); ?>" style="    width: 65%;" class="mydatepicker " id="date_hover<?php echo $value['ck_id']; ?>" name="date_hover<?php echo $value['ck_id']; ?>"   placeholder="dd/mmm/yyyy">

                                                                                                            <?php } ?>

                                        <?php } else { ?>
                                                                                                            <input type="text" style="    width: 65%;" class="mydatepicker none" id="date_hover<?php echo $value['ck_id']; ?>" name="date_hover<?php echo $value['ck_id']; ?>"   placeholder="dd/mmm/yyyy">

                                                                                        <?php }
                                                                                        ?>


                                                                                    </td>
                                                                                    <td>
                                        <?php if ($filldates['cd_attah'] != "") { ?>
                                                            <?php if ($filldates['cd_status'] == "1") { ?> 

                                                                                                            <?php } else { ?>
                                                                                                                                <div class=" " id="ffile<?php echo $value['ck_id']; ?>">
                                                                                                                                    <input class="" type="file" id="file<?php echo $value['ck_id']; ?>" name="file<?php echo $value['ck_id']; ?>" >
                                                                                                                                    <span id="savebb<?php echo $value['ck_id']; ?>"   class="badge badge-pill badge-success font-medium text-white ml-1 savebu pointer" onclick="upload_checlist('<?php echo $value['ck_id']; ?>')"  style="position: absolute; margin-left: -6% !important;" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                                                                                                        <i class="fas fa-save"></i>
                                                                                                                                    </span>
                                                                                                                                </div>
                                                            <?php } ?>

                                        <?php } else { ?>
                                                                                                            <div class=" none" id="ffile<?php echo $value['ck_id']; ?>">
                                                                                                                <input class="" type="file" id="file<?php echo $value['ck_id']; ?>" name="file<?php echo $value['ck_id']; ?>" >
                                                                                                                <span id="savebb<?php echo $value['ck_id']; ?>"   class="badge badge-pill badge-success font-medium text-white ml-1 savebu pointer" onclick="upload_checlist('<?php echo $value['ck_id']; ?>')"  style="position: absolute; margin-left: -6% !important;" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                                                                                    <i class="fas fa-save"></i>
                                                                                                                </span>
                                                                                                            </div>
                                        <?php }
                                        ?>

                                                                                    </td>
                                                                                    <td class=" doc_view<?php echo $value['ck_id']; ?>">
                                                                                        <?php if ($filldates['cd_attah'] != "") { ?>
                                                                                                            <span class="badge badge-primary text-center"><a href="uploads/checklists/<?php echo $filldates['cd_attah']; ?>" class=" text-white" target="_blank"><i class="fas fa-eye"></i></a></span>

                                                                                        <?php } else { ?>
                                                                                        <?php }
                                                                                        ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php if ($filldates['cd_status'] == "1") { ?>
                                                                                                            <span class="badge badge-success text-center pointer">  Completed</span>
                                                                                                            <i class="fas fa-comment pointer" onclick="swal('<?php echo $filldates['cd_remarks']; ?>')"></i>
                                                                                        <?php } else if ($filldates['cd_status'] == "2") { ?>
                                                                                                                            <span class="badge badge-warning text-center pointer">  Sent Back</span>
                                                                                                                            <i class="fas fa-comment pointer" onclick="swal('<?php echo $filldates['cd_remarks']; ?>')"></i>
                                                                                        <?php } else if ($filldates['cd_status'] == "0") { ?>
                                                                                                                                            <span class="badge badge-warning orange text-center pointer">  Approval Progress</span>
                                        <?php }
                                                                                        ?>  

                                                                                    </td>
                                                                                </tr>
                                                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
<?php } ?>
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <h4 class="card-title">Project Master</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();" ><i class="icon-plus"></i> &nbsp;Create New</button></div>

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered table-striped border">
                                <thead>
                                    <tr>
                                        <th >Project Name</th>

<!--                                        <th>Location</th>-->
                                        <!--<th>Address</th>-->
                                        <th>Segments</th>
                                        <th>Start</th>
                                        <th>End </th>
                                        <th>Revised</th>
                                        <th>Hand. Over Status</th>
                                        <th>Hand. Over. Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if ($_SESSION['milcom'] == '1') {
                                    $seg = "38";
                                } else {
                                    $seg = "";
                                }
                                $result = $cls_comm->select_allprojects($seg);
                                $res = json_decode($result, true);
                                foreach ($res as $key => $value) {
                                    //echo $value['proj_type'];
                                   // $select_projtype = $cls_comm->projtype($value['proj_type']);
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
                                    <?php echo $value['proj_name']; ?>  
                                    <?php if ($value['proj_type'] != '') { ?> 
                                        <span class="blink">
                                        <span class='type_sty <?php echo $ptype_col; ?>'><?php echo $ptype; ?></span>
                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                        </span>

                                    <?php } ?>
                                    </td>                                         
                                    <!--<td><?php echo $value['location'] ?></td>-->
                                    <!--<td><?php // echo $value['address']                                                              ?></td>-->
                                    <td><?php echo $value['catagories'] ?></td>
                                    <td><?php echo formatDate($value['proj_created_date'], 'd-M-Y') ?> </td>
                                    <td><?php echo formatDate($value['proj_edate'], 'd-M-Y') ?></td>
                                    <td><?php echo formatDate($value['proj_revised_edate'], 'd-M-Y') ?> </td>
                                    <td>
                                    <?php
                                    $select_ckstatus = $cls_comm->select_ckstatus($value['proj_id']);
                                    if ($select_ckstatus == '1') {
                                        ?>
                                        <label  class="badge badge-pill badge-primary font-medium text-white ml-1">Completed</label>
                                    <?php } else if ($select_ckstatus == '0') { ?>
                                                    <label  class="badge badge-pill badge-danger font-medium text-white ml-1">Progress</label>
                                    <?php }
                                    ?>
                                    </td>
                                    <td>
                                    <label  class="badge badge-pill badge-success font-medium text-white ml-1" onclick="swal('<?php echo $value['hand_over_remarks'] ?>');"><i class=" mdi mdi-comment-check-outline"> </i> View</label></td>
                                    <!-- <td>a</td> -->
                                    <td>
                                    <a href="?id=<?php echo $value['proj_id'] ?>" onclick="return confirm('Are you sure want to Edit this project?')"><i class="mdi mdi-pencil"></i></a>  
                                    <a href="functions/conhead_form?del_proj_id=<?php echo $value['proj_id'] ?>" onclick="return confirm('Are you sure want to delete this project?')"><i class="mdi mdi-delete-forever"></i></a>  
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
    </div>
<?php
include_once('layout/foot_banner.php');
?>
</div>


    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
<script>
    function create_newproj() {
        $('#project_create').show();
    }
    function cancelproj() {
        $('#project_create').hide();
    }
    function proj_editclose() {
        $('#project_edit').hide();
    }
    function handover_show(id) {
        $('#date_hover' + id).show();
        if (id == 3 || id == 6 || id == 7 || id == 9) {
            $('#ffile' + id).show();
            $('#file' + id).hide();
            $('#savebb' + id).show()
        } else {
            $('#ffile' + id).show();
        }
    }
    function handover_hide(id) {
        $('#date_hover' + id).hide();
        $('#ffile' + id).hide();
    }
    function upload_checlist(id) {
//        alert(id);
        var projid = $('#proj_id').val();
        var doc_name = $('#file' + id).val();
        var file_name = $('#file' + id).val();
        var file_data = $('#file' + id).prop('files')[0];
        var date = $('#date_hover' + id).val();
        var complete;
        if ($('#customControlValidation1' + id).is(':checked')) {
            complete = $('#customControlValidation1' + id).val();
        } else {
            complete = '0';
        }

        if (id == 3 || id == 6 || id == 7 || id == 9) {
            $.post("code/save_checklist.php", {projid: projid, id: id, complete: complete, date: date}, function (data) {

                alert('saved');
            });
        } else {
            if (file_name == "") {
                swal('Please Choose file');
            } else {

                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('projid', projid);
                form_data.append('doc_name', doc_name);
                form_data.append('id', id);
                form_data.append('complete', complete);
                form_data.append('date', date);

                $.ajax({
                    url: 'code/checkklist_filesuplod.php', // point to server-side PHP script 
                    dataType: 'text', // what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function (php_script_response) {
                        swal(php_script_response);
                        if ($.trim(php_script_response) === "success") {
                            fetch_checklist(projid, id);
                        }

                    }
                });
            }
        }
    }
    function fetch_checklist(projid, id) {
//      alert(id); 
//      exit();
//        $('.doc_view' + id).html('<img src="images/loading.gif" alt=""/>');
        $.post("code/fetch_checklist.php", {proj_id: projid, key: id}, function (data) {
            $('.doc_view' + id).html(data);

        });
    }
//    for (var i = 0; i < 10; i++) {
//        var projid = $('#proj_id').val();
//        if (projid != '') {
//            fetch_checklist(projid, i);
//        }
//
//    }

</script>
<script>
    function login() {
        var user = 'SWIFTUSERS';
        $.post("assets/insertlog.php", {key: user}, function (data) {

        });
    }
    login();
</script>