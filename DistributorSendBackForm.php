<?php
include 'config/inc.php';
include_once("../config/inc_function.php");
$mdidval   = base64_decode($_GET['mdid']);
$projidval = base64_decode($_GET['projid']);
$packidval = base64_decode($_GET['packid']);
$generate_token= generate_token();
if (isset($mdidval)) {
   echo $mdid   = base64_decode($_GET['mdid']);
}
if (isset($projidval)) {
   $projid = base64_decode($_GET['projid']);
}
if (isset($packidval)) {
   $packid = base64_decode($_GET['packid']);
}
$check_powo = $cls_comm->po_wo_check($packid);
$check_pack = $cls_comm->pack_details($packid, $projid);
$check_log  = $cls_comm->check_dist_sendlog($packid, $projid, $mdid);
$check_mail = $cls_comm->check_Mail_flag($packid, $projid, $mdid);
 $dis_log    = $check_log['logcount'];
$mail_flag    = $check_mail['flag'];
$send_back    = $check_mail['send_back'];
$pack_name  = $check_pack['pm_packagename'];
$proj_name  = $check_pack['proj_name'];
$pono       = $check_powo['po_no'];
$wono       = $check_powo['wo_no'];
$podate     = date('d-M-y', strtotime($check_powo['po_approved_on']));
$wodate     = date('d-M-y', strtotime($check_powo['wo_approved_on']));
include_once('layout/header2.php');
include_once('layout/nav2.php');

?>
<style>
    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
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
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper" style="margin-left:0% !important;">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Distributor Order details Entry</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distributor</li>
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

        <div class="row" id="stage_create" style="display: block;">

            <div class="col-12">
                <div class="col-md-12 mb-6" style="margin-left: 15%;">
                    <label for="message-text" class="control-label bold">Project Name : </label>
                    <span style="background-color: #FF7200 !important;" class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"><?php echo $proj_name; ?></span>
                    <label for="message-text" class="control-label bold">Pack Name : </label>
                    <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="planned_date"><?php echo $pack_name; ?></span>
                    <label for="message-text" class="control-label bold">PO/WO No : </label>
                    <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"><?php echo $pono; ?><?php if ($wono != '') { ?> / <?php echo $wono;
                                                                                                                                                        } ?></span>
                    <label for="message-text" class="control-label bold">PO/WO Date : </label>
                    <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"><?php echo $podate; ?><?php if ($check_powo['wo_approved_on'] != '') { ?> / <?php echo $wodate;
                                                                                                                                                                                    } ?></span>
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php if (($dis_log == 1)) { ?>
                            <form class="needs-validation" method="post" action="functions/distributor_save.php">
                            <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

                            <div class="form-row" style="margin-left: 22%;">
                                    <input type="hidden" name="projectid" id="projectid" value="<?php echo $projid; ?>">
                                    <input type="hidden" name="packageid" id="packageid" value="<?php echo $packid; ?>">
                                    <input type="hidden" name="mdid" id="mdid" value="<?php echo $mdid; ?>">
                                    <input type="hidden" name="sendback" id="sendback" value="1">

                                    <div class="col-md-4" id='distributor' style="display:block;">
                                        <div class="form-group">
                                            <label for="message-text" class="control-label bold"> Type :</label>
                                            <?php if ($send_back == 1) {  ?>
                                                <input type="text" class="form-control" id="sendbackdist" name="sendbackdist" readonly value="Distributor">
                                                <input type="hidden" class="form-control" id="distributor" name="distributor" readonly value="<?php echo $mail_flag; ?>">
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3"></div>
                                </div>
                                <div class="form-row" style="margin-left: 22%;">
                                    <div class="col-md-4 mb-4">
                                        <label for="doc_name">Doc Name</label>
                                        <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Enter Document Name">

                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-5 mb-6">
                                    <div class="input-group">
                                    </div>
                                </div> -->
                                    <div class="col-md-5 mb-6">
                                        <label for="proj_location">Proof of order copy </label>
                                        <div class="input-group mb-3">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                <label class="custom-file-label " for="inputGroupFile01">Choose file</label>
                                            </div>
                                            <div class="invalid-feedback"> </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mb-2">
                                        <div class="input-group-append">
                                            <button style="margin-top: 37.5% !important;" class="btn btn-success" type="button" id="ops_expert_filesup" onclick="ordercopy_filesuplod()">Upload</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="dist_uptable">
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="card-title">Remarks</h4>
                                        <div class="form-group">
                                            <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                                            <textarea class="form-control" rows="3" id="remarks" name="remarks" required></textarea>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-6">

                                        </div>
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


                                </div>


                                <button style="margin-left: 30.5%;" class="btn btn-primary" type="submit" name="distributor_update">Submit</button>
                                <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                                <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelstage()" name="cancel_form">Cancel</button>
                            </form>
                        <?php } else { ?>
                            <div style="text-align: center;" class="col-md-12 mb-6">You Are Submitted SuccessFully </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- basic table -->



    </div>
    <?php //include_once('layout/foot_banner.php'); 
    ?>
</div>
<?php
//include_once('layout/rightsidebar.php');
include_once('layout/footer2.php');
?>
<script src="code/js/ops.js" type="text/javascript"></script>
<script type="text/javascript">
    $(".button_check").change(function() {
        var selValue = $(this).val();
        if (selValue != '') {
            $('#Dist_show').show()
        } else {
            $("#Dist_show").hide();
        }
    });
</script>