<?php
ini_set('max_execution_time', '0'); // for infinite time of execution 
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];
$depid = $_SESSION['deptid'];
$usertype = $_SESSION['usertype'];
$uid = $_SESSION['uid'];
if ($depid == 33) {
    $segment = 'and cat_id=33';
    $segment1 = 'cat_id=33';
} else if ($depid == 35) {
    $segment = 'and cat_id=35';
    $segment1 = 'cat_id=35';
} else if ($depid == 36) {
    $segment = 'and cat_id=36';
    $segment1 = 'cat_id=36';
} else if ($depid == 37) {
    $segment = 'and cat_id=37';
    $segment1 = 'cat_id=37';
} else if ($depid == 38) {
    $segment = 'and cat_id=38';
    $segment1 = 'cat_id=38';
} else {
    if ($usertype == '6') {
        $result = $cls_report->select_user1($uid);
        $prosps_id = $result['proj_ids'];
        $segment = ' and proj_id in(' . $prosps_id . ')';
        $segment1 = 'proj_id in(' . $prosps_id . ')';
    } else {
        $segment = '';
        $segment1 = '';
    }
}

if (isset($_GET['pid']) || isset($_GET['ptid'])) {
    $pid = $_GET['pid'];
    $ptid = $_GET['ptid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
    echo '<script>var ptid=' . $_GET['ptid'] . ';</script>';
} else {
    $pid = "";
    $ptid = "";
}
$final_status = $cls_report->final_status($pid);
?>
<style>
    .col-lg-2 {
        padding-right: 5px;
        padding-left: 0px;
    }

    .p-2 {
        padding: .6rem !important;
    }

    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
</style>
<style>
    #chartdiv {
        width: 100%;
        height: 400px;
    }

    #chartdiv1 {
        width: 100%;
        height: 400px;
    }

    #chartdiv2 {
        width: 100%;
        height: 300px;
    }

    .new_font_normal {
        font-size: 16px !important;
    }

    #ps1 {
        position: absolute;
        margin-top: -4%;
        margin-left: 75%;
        padding-top: 4px;
    }

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
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Dashboard
                </h5>

            </div>
            <!-- <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter(this.value, '4')" required="">
                    <option value="-" <?php echo ($ptid == '-') ? 'selected' : ''; ?>>Both</option>
                    <option value="1" <?php $ptid == 1 ? 'selected' : ''; ?>>Carved Out</option>
                    <option value="2" <?php $ptid == 2 ? 'selected' : ''; ?>>Non Carved Out</option>
                </select>
                <div class="invalid-feedback">

                </div>
            </div> -->
            <!-- <div class="col-lg-3 col-md-3 col-xs-12 align-self-center" style="z-index:1;">
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter"
                    onchange="proj_Filter(this.value, '17')" required="">
                    <option value="">--All Project--</option>
                    <?php
                    // $result = $cls_report->select_allprojects_seg1($segment1);
                    $result = $cls_report->select_filterprojects_seg2( /* $seg, */$ptid);
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
            </div> -->
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
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



        <div class="row" id="dashtbl">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive" id="repo_dash">
                            <table id="file_export" style=" white-space: nowrap !important;"
                                class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <!-- <th style="padding-right: 13px !important;">Department</th> -->
                                        <th style="padding-right: 13px !important;">Current Status</th>
                                        <!-- <th style="padding-right: 13px !important;">Weightage</th> -->
                                        <th style="padding-right: 13px !important;">Material Req @ Site</th>
                                        <th style="padding-right: 13px !important;">Lead time(Days)</th>
                                        <!-- <th style="padding-right: 13px !important;">Exp. Order Closing</th> -->
                                        <th style="padding-right: 13px !important;">SS Plan & Actual</th>
                                        <th style="padding-right: 13px !important;">Po/Wo Plan & Actual</th>
                                        <th style="padding-right: 13px !important;">Deviations (Days)</th>
                                        <th style="padding-right: 13px !important;">History & View</th>
                                        <th style="padding-right: 13px !important;">Attachments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $repo = $cls_report->dash2($pid, $segment);

                                    $res = json_decode($repo, true);

                                    foreach ($res as $key => $value) {
                                        //                                        $deviations = $value['daysdif'];
//                                        echo $deviations;
                                        $pack_id = $value['ps_packid'];
                                        $stageid = $value['ps_stageid'];
                                        $projid = $value['proj_id'];
                                        $packname = $value['pm_packagename'];
                                        $projname = $value['proj_name'];
                                        $procount = strlen($projname);
                                        $packcount = strlen($packname);
                                        // $department = $value['dept'];
                                        $deviations = $value['daysdif'];
                                        $sent_back = $value['ps_stback'];
                                        $ps_expdate = $value['ps_expdate'];

                                        if ($procount > 50) {
                                            $stylepro = "style='white-space: pre-line;' ";
                                        } else {
                                            $stylepro = "";
                                        }
                                        if ($packcount > 50) {
                                            $stylepack = "style='white-space: pre-line;' ";
                                        } else {
                                            $stylepack = "";
                                        }
                                        // $get_deviations = $cls_report->get_deviations($pack_id, $stageid, $projid);
                                        // $deviations = $get_deviations['daysdif'];
                                    
                                        if ($sent_back == 1) {
                                            $sent = $value['shot_name'];
                                            $current_status = 'Sent back by ' . $sent . '<br>(' . $value['sname'] . ' / ' . $value['nodays'] . ' Days )';
                                        } else {
                                            $current_status = $value['shot_name'] . '<br>(' . $value['name'] . ' / ' . $value['nodays'] . ' Days )';
                                        }
                                        if ($value['po_actdate'] == '') {
                                            $po_act = "";
                                        } else {
                                            $po_actdate = formatDate($value['po_actdate'], 'd-M-y');
                                            $po_act = "<span class='badge badge-pill badge-info font-medium text-white ml-1'>$po_actdate</span>";
                                        }
                                        if ($value['po_planneddate'] == '') {
                                            $po_plan = "";
                                        } else {
                                            $po_plandate = formatDate($value['po_planneddate'], 'd-M-y');
                                            $po_plan = "<span class='badge badge-pill badge-primary font-medium text-white ml-1'>$po_plandate</span>";
                                        }
                                        if ($value['ss_app_actualdate'] == '') {
                                            $ss_act = '';
                                        } else {
                                            $ss_actdate = formatDate($value['ss_app_actualdate'], 'd-M-y');
                                            $ss_act = "<span class='badge badge-pill badge-info font-medium text-white ml-1'>$ss_actdate</span>";
                                        }
                                        if ($value['ss_app_plandate'] == '') {
                                            $ss_plan = '';
                                        } else {
                                            $ss_planneddate = formatDate($value['ss_app_plandate'], 'd-M-y');
                                            $ss_plan = "<span class='badge badge-pill badge-primary font-medium text-white ml-1'>$ss_planneddate</span>";
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
                                            <td <?php echo $stylepro; ?>>
                                                <?php echo $projname; ?>
                                                <?php if ($value['proj_type'] != '') { ?>
                                                    <span class="blink">
                                                        <span class='type_sty <?php echo $ptype_col; ?>'>
                                                            <?php echo $value['id'];
                                                            echo $ptype; ?>
                                                        </span>
                                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                            <?php
                                                // Extract and format the revised material request date
                                                $pmRevisedReqDate = formatDate($value['pm_revised_material_req'], 'Y-m-d');

                                                // Ensure $expdelivery is formatted correctly
                                                $expDeliveryDate = strtotime($expdelivery);

                                                // Check conditions only once
                                                if (!empty($pmRevisedReqDate)) {
                                                    $pmRevisedReqTimestamp = strtotime($pmRevisedReqDate);

                                                    if ($pmRevisedReqTimestamp < $expDeliveryDate) {
                                                        // Before expdelivery
                                                        ?>
                                                        <div class="notify pull-left">
                                                            <span class="heartbit"></span>
                                                            <span class="point"></span>
                                                        </div>
                                                        <?php
                                                    } elseif ($pmRevisedReqTimestamp > $expDeliveryDate) {
                                                        // After expdelivery
                                                        ?>
                                                        <div class="notify pull-left">
                                                            <span class="heartbit greenotify"></span>
                                                            <span class="point greenpoint"></span>
                                                        </div>
                                                        <?php
                                                    } else {
                                                        // Same as expdelivery
                                                        ?>
                                                        <div class="notify pull-left">
                                                            <span class="heartbit bluenotify"></span>
                                                            <span class="point bluepoint"></span>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                // Display the wrapped pack name
                                                echo wordwrap($packname, 50, "<br>\n");
                                                ?>
                                            </td>
                                            <!-- <td><?php echo $department; ?></td> -->
                                            <td>
                                                <span style=" background-color: rgb(44, 36, 158); color:white;"
                                                    class="badge badge-pill  font-medium text-black ml-1 recfrm">
                                                    <?php echo $current_status; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo formatDate($value['pm_revised_material_req'], 'd-M-y'); ?>
                                            </td>

                                            <td>
                                                <?php echo $value['pm_revised_lead_time']; ?>
                                            </td>
                                            <td>
                                                <?php echo $ss_plan; ?>
                                                <?php echo $ss_act; ?>
                                            </td>
                                            <td>
                                                <?php echo $po_plan; ?>
                                                <?php echo $po_act; ?>
                                            </td>
                                            <td>
                                                <?php echo $deviations; ?>
                                            </td>

                                            <td>
                                               
                                                <span onclick="view_reports_version1('<?php echo $value['ps_packid']; ?>')"
                                                    class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title="Current Package Status Stage wise"><i
                                                        class="fas fa-eye"></i> </span>
                                                <span
                                                onclick="view_reports_table_version1('<?php echo $value['ps_packid']; ?>')"
                                                    style="background-color: #8e1f1f !important;"
                                                    class="badge badge-pill badge-info font-medium text-white ml-1"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg"
                                                    data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title=" Packages WorkFlow  "><i
                                                        class="fa fa-database"></i> </span>
                                            </td>
                                            <td>
                                                <?php
                                                // Ensure dates are properly formatted and handle empty values
                                                $pmRevisedMaterialReq = formatDate($value['pm_revised_material_req'], 'd-M-Y');

                                                $psExpDate = formatDate($ps_expdate, 'd-M-Y');
                                                ?>

                                                <span class="pointer"
                                                    onclick="view_allattachments(
                                                        '<?php echo addslashes($value['proj_name']); ?>',
                                                        '<?php echo addslashes($value['pm_packagename']); ?>',
                                                        '<?php echo $value['proj_id']; ?>',
                                                        '<?php echo $value['ps_packid']; ?>',
                                                        '<?php echo $pmRevisedMaterialReq; ?>',
                                                        '<?php echo $psExpDate; ?>'
                                                    )"
                                                    data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo">
                                                    <i class="fas fa-paperclip text-black"></i>
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
                <!-- sample modal content -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style=" width: 200%; margin-left: -43%">
                            <div class="modal-header" style="padding-bottom: 3%;">
                                <input type="hidden" name="projid" id="projid">
                                <input type="hidden" name="packid" id="packid">

                                <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span>
                                    <span class="blink">
                                        <span class='type_sty <?php echo $ptype_col; ?>'>
                                            <?php echo $ptype; ?>
                                        </span>
                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    -
                                    <small id="pack1">Package Name</small>
                                </h4>


                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="row">
                                <div class="container-fluid">
                                    <div class=" col-md-5" id="pd" style="margin-left: 1.2% !important;">
                                        <small>Planned Date:- <span
                                                class="badge badge-pill badge-info font-12 text-white ml-1"
                                                id="planned_date"></span></small>
                                    </div>
                                    <div class=" col-md-5" id="ps">
                                        <small>Expected Date:- <span
                                                class="badge badge-pill badge-primary font-12 text-white ml-1"
                                                id="exp_date"></span></small>
                                    </div>
                                    <div class=" col-md-2" id="ps1">
                                        <small><span class="badge badge-pill badge-success font-12 text-white ml-1"
                                                id="exp_date" onclick="downloadallv1('0');">Download All</span></small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body">
                                    <form>
                                        <div id="exp_uptable" style="width:80%"></div>
                                        <div id="uptable" style="width: 80%"></div>
                                        <div id="ops_exp_uptable" style="width: 80%"></div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->
                </div>
            </div>
            <?php
            $partial = $cls_count->partial($pid);
            $deliverd = $cls_count->deliverd($pid);
            ?>

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
    <script src="code/js/technical.js" type="text/javascript"></script>
    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
    <script src="code/js/report.js" type="text/javascript"></script>
    <script>
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [{
                label: "On Track",
                value: <?php echo $final_status['on_track'] ?>,
            }, {
                label: "Delayed",
                value: <?php echo $final_status['delayed'] ?>,
            }, {
                label: "Critical",
                value: <?php echo $final_status['critical'] ?>,
            }],
            resize: true,
            colors: ['#53e69d', '#7bcef3', '#ff7676']
        });
        Morris.Donut({
            element: 'morris-donut-chart1',
            data: [{
                label: "Deliverd",
                value: <?php echo $deliverd; ?>,
            }, {
                label: "UnDelivered",
                value: <?php echo $ttl_package; ?>,
            }, {
                label: "Partialy Deliverd ",
                value: <?php echo $partial ?>,
            }],
            resize: true,
            colors: ['#53e69d', '#ff7676', '#7bcef3']
        });

        $(document).ready(function () {
            $('#file_export').dataTable()
                .columnFilter({
                    aoColumns: [{
                        type: "select",
                        values: ['Gecko', 'Trident', 'KHTML', 'Misc', 'Presto', 'Webkit', 'Tasman']
                    },
                    {
                        type: "text"
                    },
                        null,
                    {
                        type: "number"
                    },
                    {
                        type: "select"
                    }
                    ]

                });
        });
        load_project_report('<?php echo $segment; ?>');
        load_weightage();



        am4core.ready(function () {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create chart instance
            var chart = am4core.create("chartdiv1", am4charts.XYChart);

            // Add data
            //                                                    chart.data = [{"package": "swift pack-1", "complete": 30, "incomplete": 70}, {"package": "test bks", "complete": 25, "incomplete": 75}, {"package": "tech Expert attach demo", "complete": 10, "incomplete": 90}, {"package": "tech exp attached files demo- 2", "complete": 10, "incomplete": 90}, {"package": "technical expert attachment demo -3", "complete": 10, "incomplete": 90}, {"package": "Testing email package", "complete": 10, "incomplete": 90}, {"package": "testing email pack2", "complete": 5, "incomplete": 95}, {"package": "testing email pack2", "complete": 5, "incomplete": 95}, {"package": "Testing email pack 4", "complete": 30, "incomplete": 70}, {"package": "Test Email", "complete": 10, "incomplete": 90}, {"package": "Under Testing email-0", "complete": 10, "incomplete": 90}, {"package": "Test SPOC", "complete": 25, "incomplete": 75}, {"package": "Testing Remarks-01", "complete": 25, "incomplete": 75}, {"package": "Testing Remarks-02", "complete": 60, "incomplete": 40}, {"package": "Radio Station", "complete": 30, "incomplete": 70}, {"package": "Radio Station-1", "complete": 25, "incomplete": 75}, {"package": "Stage Name Corrections", "complete": 10, "incomplete": 90}, {"package": "Test Current Stage Name -01", "complete": 60, "incomplete": 40}, {"package": "Testing OPS Attachments", "complete": 25, "incomplete": 75}, {"package": "Test Stage Active", "complete": 30, "incomplete": 70}, {"package": "Email Trigger", "complete": 25, "incomplete": 75}, {"package": "email Setting", "complete": 5, "incomplete": 95}, {"package": "test techincal upload demo pack-4", "complete": 10, "incomplete": 90}, {"package": "testing table back groud color", "complete": 10, "incomplete": 90}, {"package": "fdsa df gdfg fdgfd gfdg fdgfdgfd", "complete": 10, "incomplete": 90}, {"package": "test Email track", "complete": 10, "incomplete": 90}, {"package": "Testing Stage Active -01", "complete": 60, "incomplete": 40}, {"package": "testing email pack 5", "complete": 10, "incomplete": 90}, {"package": "testing email pack 6", "complete": 10, "incomplete": 90}]
            chart.data = <?php echo $load_package_report = $cls_report->load_package_report($pid, $segment); ?>;
            chart.legend = new am4charts.Legend();
            chart.legend.position = "bottom";
            chart.scrollbarY = new am4core.Scrollbar();
            chart.scrollbarY.parent = chart.leftAxesContainer;


            // Create axes
            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "package";
            categoryAxis.renderer.grid.template.opacity = 0;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.min = 0;
            valueAxis.renderer.grid.template.opacity = 0;
            valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
            valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
            valueAxis.renderer.ticks.template.length = 10;
            valueAxis.renderer.line.strokeOpacity = 0.5;
            valueAxis.renderer.baseGrid.disabled = true;
            valueAxis.renderer.minGridDistance = 40;

            // Create series
            function createSeries(field, name, color) {
                var series = chart.series.push(new am4charts.ColumnSeries3D());
                series.dataFields.valueX = field;
                series.dataFields.categoryY = "package";
                series.stacked = true;
                series.name = name;
                series.stroke = am4core.color(color);
                series.fill = am4core.color(color);

                var labelBullet = series.bullets.push(new am4charts.LabelBullet());
                labelBullet.locationX = 0.5;
                labelBullet.label.text = "{valueX}";
                labelBullet.label.fill = am4core.color("#fff");
            }
            //                                                    function zoomAxis() {
            //                                                        categoryAxis.zoomToCategories("swift pack-1", "tech exp attached fi");
            //                                                    }
            createSeries("incomplete", "Incomplete", "#f18032");
            createSeries("complete", "Complete", "#5c9cd6");

            chart.events.on("ready", function () {
                categoryAxis.zoomToCategories(
                    '<?php echo $start_z; ?>',
                    '<?php echo $end_z; ?>',
                    false,
                    true
                );
            });



        }); // end am4core.ready()
    </script>
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