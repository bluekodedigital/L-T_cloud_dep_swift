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
$final_status=$cls_report->final_status($pid);
 
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    .p-2{
        padding: .6rem!important;
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
                <h5 class="font-medium text-uppercase mb-0">Dashboard</h5>
            </div>
            <div class="col-lg-2 col-md-3 col-xs-12 align-self-center" >                
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '16')" required="">
                    <option value="">--All Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects();
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
        <!-- Card Group  -->
        <!-- ============================================================== -->

        <div class="row">
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card" style=" background-color: #0cc2c4;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $ttl_package = $cls_count->ttl_package($pid);
                                        echo $ttl_package;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">Total Packages</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card " style=" background-color: #b33a99;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $ops_yetto = $cls_report->repo_files_fortechspoc($pid);
                                        echo $ops_yetto;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white ">Ops-yet to be Initiated</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-2">
                <a href="#"><div class="card bg-primary">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $result = $cls_count->tech_cto_workflow_count($pid);
                                        echo $result;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">Technical</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card bg-warning ">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $files_contract = $cls_user->om_count($pid);
                                        echo $files_contract;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">Ops-Post Technical</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
        <div class="row" id="sprog">
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#"> 
                    <div class="card bg-success">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-signal"></i></h3></div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $scm_underfinal = $cls_report->scm_underfinal_porgress($pid);
                                        echo $scm_underfinal;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">SCM under Finalization (Order)</span><br>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card bg-inverse">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-timer"></i></h3></div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $app_inprogress = $cls_count->app_yettoinitiated($pid);
                                        echo $app_inprogress;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">SCM Finalized (Order)</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card" style=" background-color: #287b05;;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $app_inprogress = $cls_count->app_inprogress($pid);
                                        echo $app_inprogress;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">SmartSignoff -Approval </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card bg-info">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $po_progress = $cls_count->po_progress($pid);
                                        echo $po_progress;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">PO Completion</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>


        </div>
        <div class=" row" id="tprog">
            <div class="col-lg-3 col-md-2">
                <a href="#"><div class="card " style=" background-color: #04c;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $wo_progress = $cls_count->wo_progress($pid);
                                        echo $wo_progress;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">WO Completion</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#">
                    <div class="card" style=" background-color: #9000cc;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $manf_progress = $cls_count->manf_progress($pid);
                                        echo $manf_progress;
                                        ?> 
                                    </h3>
                                </span>
                                <span class="text-white">Manf. Clearance</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-3 col-md-2">
                <a href="#"> 
                    <div class="card" style=" background-color: #176ff3;">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-signal"></i></h3></div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $mtr_progress = $cls_count->mtr_progress($pid);
                                        echo $manf_progress;
                                        ?> 
                                    </h3>
                                </span>
                                <span class="text-white">Material Received</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="row" id="salest">
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Status</h5>
                        <div class="mt-3">
                            <div id="morris-donut-chart" style="height:350px; padding-top: 50px;"></div>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <div>
                                <h3 class="font-medium text-uppercase"><?php echo $ttl_package; ?> </h3>
                                <h5 class="text-muted">Total Packages</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Completed Status</h5>
                        <ul class="list-style-none country-state mt-4">

                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $ops_initiated = $cls_report->repo_files_fortechspoc_initiated($pid);
                                    echo $ops_initiated;
                                    $opsPer = number_format(round(($ops_initiated / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                 Operation Initiated  
                                <div class="float-right"><?php echo $opsPer; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $opsPer; ?>%; height: 6px;    background-color: #b33a99;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $ttl_tech_cleared = $cls_count->ttl_tech_cleared($pid);
                                    echo $ttl_tech_cleared;
                                    $techPer = number_format(round(($ttl_tech_cleared / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Technical 
                                <div class="float-right"><?php echo $techPer; ?>% </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $techPer; ?>%; height: 6px; backgroud-color:#707CD2;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $ops_postcleared = $cls_report->om_count_cleared($pid);
                                    echo $ops_postcleared;
                                    $oppoPer = number_format(round(($ops_postcleared / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Ops- Post Technical 
                                <div class="float-right"><?php echo $oppoPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $oppoPer; ?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $scm_underfinal = $cls_report->scm_underfinal($pid);
                                    echo $scm_underfinal;
                                    $scm_uPer = number_format(round(($scm_underfinal / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                SCM Under Finalization (Order) 
                                <div class="float-right"><?php echo $scm_uPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $scm_uPer; ?>%; height: 6px; background-color:#2CD07E;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $app_completed = $cls_report->app_completedfinal($pid);
                                    echo $app_completed;
                                    $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                 SCM Finalized (Order) 
                                <div class="float-right"><?php echo $app_uPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $app_uPer; ?>%; height: 6px; background-color:#4C5667;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Completed Status</h5>
                        <ul class="list-style-none country-state mt-4">

                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $app_completed = $cls_report->app_completed($pid);
                                    echo $app_completed;
                                    $app_uPer = number_format(round(($app_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                SmartSignoff- Approved files 
                                <div class="float-right"><?php echo $app_uPer; ?>% </div>
                                <div class="progress">
                                    <div class="progress-bar  " role="progressbar" style="width: <?php echo $app_uPer; ?>%; height: 6px; background-color:#287B05;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $po_completed = $cls_count->po_completed($pid);
                                    echo $po_completed;
                                    $poPer = number_format(round(($po_completed / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                PO Completed 
                                <div class="float-right"><?php echo $poPer; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $poPer; ?>%; height: 6px; background-color:#2CABE3;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0"> 
                                    <?php
                                    $wo_completed = $cls_count->wo_completed($pid);
                                    echo $wo_completed;
                                    $woPer = number_format(round(($wo_completed / $ttl_package) * 100), 2);
                                    ?>

                                </h2>
                                WO Completed 
                                <div class="float-right"><?php echo $woPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $woPer; ?>%; height: 6px; background-color:#0044CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $manf_completed = $cls_count->manf_completed($pid);
                                    echo $manf_completed;
                                    $mfPer = number_format(round(($manf_completed / $ttl_package) * 100), 2);
                                    ?> 


                                </h2>
                                Manf. Clearance 
                                <div class="float-right"><?php echo $mfPer; ?>%  </div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $mfPer; ?>%; height: 6px;  background-color:#9000CC;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </li>
                            <li class="mb-4">
                                <h2 class="mb-0">
                                    <?php
                                    $mtr_received = $cls_count->mtr_received($pid);
                                    echo $mtr_received;
                                    $mrPer = number_format(round(($manf_completed / $ttl_package) * 100), 2);
                                    ?>
                                </h2>
                                Material Received 
                                <div class="float-right"><?php echo $mrPer; ?>%</div>
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" style="width: <?php echo $mrPer; ?>%; height: 6px; background-color:#176FF3;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>


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
<script>
                    Morris.Donut({
                        element: 'morris-donut-chart',
                        data: [{
                                label: "On Track",
                                value: <?php echo $final_status['on_track'] ?> ,
                            }, {
                                label: "Delayed",
                                value:  <?php echo $final_status['delayed'] ?>,
                            }, {
                                label: "Critical",
                                value:  <?php echo $final_status['critical'] ?>,
                            } ],
                        resize: true,
                        colors: ['#53e69d','#7bcef3','#ff7676']
                    });  
</script>