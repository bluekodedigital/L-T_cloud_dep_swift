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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">WO Completion Entry</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center" >                
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '15')" required="">
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
            <div class="col-lg-6 col-md-8 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="ops_dashboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>WO Creation</th>
                                        <th>WO Approval</th>
                                        <th>WO Number</th>                                       
                                        <th>Completion Percentage(%) out of 100</th>
                                        <th>Total Completed (%)</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $repo = $cls_user->files_forwoentry($pid, $segment);
                                    $res = json_decode($repo, true);
                                    foreach ($res as $key => $value) {
                                        $get_wocrdate = $cls_user->get_wodate($value['pm_packid'],22);
                                        $get_woappdate = $cls_user->get_wodate($value['pm_packid'],23);
                                        ?>
                                        <tr>
                                            <td><?php echo $value['proj_name']; ?></td>
                                            <td><?php echo wordwrap($value['pm_packagename'], 30, "<br>\n"); ?></td>
                                            <td><?php echo formatDate($get_wocrdate['ps_actualdate'], 'd-m-y'); ?></td>
                                             <td><?php echo formatDate($get_woappdate['ps_actualdate'], 'd-m-y'); ?></td>
                                            <td><span class="badge badge-pill badge-info font-medium text-black ml-1"><?php echo $value['wo_number']; ?></span></td>
                                            <td>
                                                <div class="input-group" id="expdiv" style=" float: left;">

                                                    <input type="text" value="" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control  " id="wo_percentage<?php echo $value['pm_packid'] ?>" name="dasexpected_date" required="" placeholder="Enter Percentage">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1" onclick="save_wocompletion('<?php echo $value['pm_packid']; ?>', '<?php echo $value['proj_id']; ?>')"   style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save WO Percentage">
                                                        <i class="fas fa-save"></i> Save
                                                    </span>
                                                </div>

                                            </td>
                                            <td id="completed">

                                                <?php
                                                $repos = $cls_user->get_completed($value['pm_packid']);
                                                echo $repos.'%';
                                                ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $repos;?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div> 
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
 
