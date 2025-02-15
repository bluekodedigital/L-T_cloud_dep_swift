<?php
include 'config/inc.php';
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
$uid = $_SESSION['uid'];
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
?>
<style>
    .col-lg-2 {
        padding-right: 5px;
        padding-left: 0px;
    }

    .card {
        border-radius: 10px !important;
    }

    .d-flex {
        border-radius: 10px !important;
    }

    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
    .bg-green {
        background-color: #26C6DA !important;
        color: #fff !important;
    }

    .small-box {
        border-radius: 10px;
        position: relative;
        display: block;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
    }

    .small-box>.inner {
        padding: 10px;
    }

    .small-box p {
        font-size: 15px;
        margin-bottom: 10px;
    }

    .small-box h3 {
        font-size: 38px;
        font-weight: 700;
        margin: 0 0 10px;
        white-space: nowrap;
        padding: 0;
    }

    .small-box .icon {
        -webkit-transition: all .3s linear;
        -o-transition: all .3s linear;
        transition: all .3s linear;
        position: absolute;
        top: 5px;
        right: 10px;
        z-index: 0;
        font-size: 72px;
        color: rgba(0, 0, 0, .15);
    }

    .small-box>.small-box-footer {
        position: relative;
        text-align: right;
        padding: 3px 10px;
        color: #fff;
        color: rgba(255, 255, 255, .8);
        display: block;
        z-index: 10;
        background: rgba(0, 0, 0, .1);
        text-decoration: none;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .bg-blue {
        background-color: #095ba4;
        color: #fff !important;
    }

    .bg-red {
        background-color: #fc4b6c !important;
        color: #fff;
    }

    .fa-pie-chart:before {
        content: "\f200";
    }

    .fa-arrow-right:before {
        margin-left: 8px !important;
    }
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper ">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Action board</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter_tech(this.value, '4')" required="">
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
                <select class="custom-select" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if ($_SESSION['milcom'] == '1') {
                        $seg = '38';
                    } else {
                        $seg = "";
                    }
                    // $result = $cls_comm->dash_filter($seg);
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
            <div class="col-lg-3 col-md-8 col-xs-12 align-self-center">
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

            <div class="col-6 col-xl-3" style="margin-left:7%;">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            <?php
                            $result = $cls_count->select_Loi_workflow_count($pid, $segment);
                            echo $result;
                            ?>
                        </h3>
                        <p>LOI Creation</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                    <a href="swift_workflow_approval?pid=<?php echo $pid ?>" class="small-box-footer">More info <i
                            class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-6 col-xl-3" style="margin-left:6%;">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>
                            <?php
                            $files_contract = $cls_count->files_from_loipo($pid, $uid, $utype, $seg);
                            echo $files_contract;
                            ?>
                        </h3>
                        <p>PO Creation / Approval</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pie-chart"></i>
                    </div>
                    <a href="files_from_po?pid=<?php echo $pid ?>&ptid=<?php echo $ptid; ?>" class="small-box-footer">More info <i
                            class="fa fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-6 col-xl-3" style="margin-left:6%;">
                <!-- small box -->
                <div class="small-box bg-red" style="background-color: #4c5667!important;">
                    <div class="inner">
                        <h3>
                            </br>
                        </h3>
                        <p>Distributor-OEM Order Tracking</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-pie-chart"></i>
                    </div>
                    <a href="swift_distributor_history.php?pid=<?php echo $pid ?>&ptid=<?php echo $ptid; ?>" class="small-box-footer">More info <i
                            class="fa fa-arrow-right"></i></a>
                </div>
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
                                                        <td><span class="badge badge-pill badge-info font-medium text-black ml-1"><?php //echo $value['stage_name']; ?></span></td>
                                                        <td><?php //echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                                                        <td><?php //echo $value['pm_revised_lead_time']; ?></td>
                                                        <td><?php //echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
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
            var tid = $('#proj_type').val();
            window.location.href = "buyer_dash?pid=" + Proid + "&ptid=" + tid;
        }
    </script>
    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
    <script>
        function login() {
            var user = 'SWIFTUSERS';
            $.post("assets/insertlog.php", {
                key: user
            }, function (data) {

            });
        }
        login();
    </script>