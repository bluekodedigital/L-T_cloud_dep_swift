<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Files For Tech Approval</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '9')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects_seg($segment);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="ops_dashboard">Home</a></li>                         
                        <li class="breadcrumb-item active" aria-current="page">Tech Approval</li>
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
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th> 
                                        <th>Received From</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th> 
<!--                                        <th>Stage Actual</th> -->
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_user->files_for_techapp_clearance($pid, $segment);
//                                    print_r($result);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        if ($value['expected'] == "") {
                                            $exp_date = date('Y-m-d');
                                        } else {
                                            $exp_date = $value['expected'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $value['proj_name'] ?></td>
                                            <td>
                                                <?php if (strtotime($value['planned']) > strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify" ></span>
                                                        <span class="point greenpoint" ></span>
                                                    </div>

                                                <?php } elseif (strtotime($value['planned']) < strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['planned']) == strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint" ></span>
                                                    </div>
                                                <?php }
                                                ?>
                                                <?php echo $value['pm_packagename'] ?></td>
                                            <td>
                                                <span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">

                                                    <?php
                                                    if ($value['tech_status'] == 0) {
                                                        echo 'PO Approved';
                                                    } else if ($value['tech_status'] == 1) {
                                                        echo 'Drawing Sample/POC Submission';
                                                    } else if ($value['tech_status'] == 3) {
                                                        echo 'Engg.to Ops for Vendor Design Approval';
                                                    }
                                                    ?>
                                                    <br>(<?php echo formatDate($value['tech_sentdate'], 'd-M-Y'); ?>)
                                                </span>
                                            </td>
                                            <td><?php echo formatDate($value['pm_material_req'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['planned'], 'd-M-Y'); ?></td>
                                            <td><?php // echo formatDate($value['ps_expdate'], 'd-M-Y');    ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo formatDate($exp_date, 'd-M-Y'); ?>"  class=" mydatepicker" id="dasexpected_date<?php echo $value['tech_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['tech_packid'] ?>', '<?php echo $value['stage_id'] ?>')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>

                                            </td>
                                            <!--<td><?php // echo formatDate($value['actual'], 'd-M-Y');    ?></td>-->
                                            <td><label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $value['tech_remarks']; ?>'});"><i class="fas fa-comment"></i>Remarks</label></td>
                                            <td>                                               
                                                <span onclick="filesfor_techapp('<?php echo $value['tech_packid'] ?>', '<?php echo $value['tech_status'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send for Tech approval">
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="margin-top: 0px;">                          
                            <h4 class="modal-title" id="exampleModalLabel1"><span id="project">Project</span> - <small id="pack">Package Name</small></h4> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid" >
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="pdate"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps" >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <form action="functions/ops_form" method="post" onsubmit="return confirm('Are you sure you want to submit?');" > 
                            <div class="modal-body">
                                <div class=" col-md-offset-1 col-xs-9">
                                    <center>
                                        <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">Vendor to Ops Drawing Sample/POC Submission</span></small>                
                                    </center>
                                </div><br>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3" style=" display: none;">
                                        <label for="expected_date">Expected</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>

                                            <!--<input type="text"  class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">-->

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <input type="hidden"  class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">

                                    <input type="hidden" value="" name="planneddate" id="planneddate">
                                    <input type="hidden" value="" name="senderid" id="senderid">
                                    <input type="hidden" value="" name="projectid" id="projectid">
                                    <input type="hidden" value="" name="packageid" id="packageid">
                                    <input type="hidden" value="" name="flag" id="flag">
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">Action</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" disabled="" id="actual_date" onchange="get_expected('7')" name="actual_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="form-group" id="change_expert" style=" display: none;">
                                        <label for="message-text" class="control-label">Technical Expert:</label>
                                        <select class="custom-select" name="expert_id" id="expert_id">
                                            <option value="">--Select Tech Expert--</option>
                                            <?php
                                            // user type 11 is tech expert
                                            $result = $cls_comm->select_user('11');
                                            $res = json_decode($result, true);
                                            foreach ($res as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['uid'] ?>"><?php echo $value['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                </div> 
                                <div class="row" id="ctor">

                                </div><br>
                                <div class="form-group" id="dre">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="opstospocremarks" name="opstospocremarks"></textarea>
                                </div>


                            </div>
                            <div class="modal-footer">                
                                <button type="submit" id="sent_to_tech_expert" name="sent_to_tech_expert" class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i> Submit</button>
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
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
