<?php
include 'config/inc.php';
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
if ($_SESSION['milcom'] == '1') {
    $segment = '38';
} else {
    $segment = $_SESSION['tech_seg'];
}
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    // echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Action board</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center" >                
                <select class="custom-select" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                        if ($_SESSION['milcom'] == '1') {
                            $seg = '38';
                        } else {
                            $seg = "";
                        }
                    $result = $cls_comm->dash_filter($seg);
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
                        <li class="breadcrumb-item"><a href="tech_spoc">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Action board</li>
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
        <!-- Card Group  -->
        <!-- ============================================================== -->

        <div class="row">
            <!-- Column -->
            <div class="col-lg-3 col-md-6"></div>
            <div class="col-lg-3 col-md-6">
                <a href="swift_workflow_approval?pid=<?php echo $pid ?>">
                    <div class="card bg-info">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-agenda"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
<?php
$result = $cls_count->select_techspoc_workflow_count($pid, $segment);
echo $result;
?>
                                    </h3>
                                </span>
                                <span class="text-white">Files From OPS / Expert</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="tech_spoc_repository?pid=<?php echo $pid ?>">
                    <div class="card bg-success">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-server"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
<?php
$result = $cls_count->select_techspoc_repository_count($pid, $segment);
echo $result;
?>
                                    </h3>
                                </span>
                                <span class="text-white">Repository </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6"></div>
            <!-- Column -->
        </div>
        <!--
                <div class="row" id="dashtbl">
                    <div class="col-12">
                        <div class="material-card card">
                            <div class="card-body">
                                <h4 class="card-title">Work Flow</h4>
        
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-bordered display compact">
                                        <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Package</th>
                                                <th>Current Status</th>                                       
                                                <th>Material Req @ Site</th>
                                                <th>Lead time(Days)</th>
                                                <th>Exp. Delivery</th>
                                                <th>View</th>                                      
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$repo = $cls_report->techspoc_dash($pid);
$res = json_decode($repo, true);
foreach ($res as $key => $value) {
    ?>
                                                    <tr>
                                                        <td><?php echo $value['proj_name'] ?></td>
                                                        <td>
            <?php if ($value['planned'] > $value['actual']) { ?>
                                                                    <div class="notify pull-left">
                                                                        <span class="heartbit"></span>
                                                                        <span class="point" ></span>
                                                                    </div>
    <?php } elseif ($value['planned'] < $value['actual']) { ?>
                                                                    <div class="notify pull-left">
                                                                        <span class="heartbit greenotify" ></span>
                                                                        <span class="point greenpoint" ></span>
                                                                    </div>
    <?php } elseif ($value['planned'] == $value['actual']) { ?>
                                                                    <div class="notify pull-left">
                                                                        <span class="heartbit bluenotify"></span>
                                                                        <span class="point bluepoint" ></span>
                                                                    </div>
    <?php }
    ?>
    <?php echo $value['pm_packagename'] ?></td>
                                                        <td><span class="badge badge-pill badge-info font-medium text-black ml-1"><?php echo $value['stage_name']; ?></span></td>
                                                        <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                                                        <td><?php echo $value['pm_revised_lead_time']; ?></td>
                                                        <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                                                        <td><span onclick="view_reports('<?php echo $value['ps_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-eye"></i> View</span></td>
                                                    </tr>
<?php }
?>
        
                                        </tbody>
        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->


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
                        window.location.href = "swift_workflow_approval?pid=" + Proid;
                    }
</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
    function login() {
        var user = 'SWIFTUSERS';
        $.post("assets/insertlog.php", {key: user}, function (data) {

        });
    }
    login();
</script>