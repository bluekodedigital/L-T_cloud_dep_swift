<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
$gr_result = $cls_lc->lc_dasboard_graph1();

//$gr_res = json_decode($gr_result, true);
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }

</style>
<style>
    .custom-select:disabled {
        color: #000;
    }
    #zero_config_lc th,td {
        white-space: nowrap;
        padding: 8px;
    }
    .repoCard {
    padding-top: 0px !important;
    /*height: 600px;*/
    overflow-x: scroll;
}
</style>
<style>
    #chartdiv {
        width: 100%;
        height: 600px;
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
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Dashboard </h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center " >                
                <select class="custom-select none" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->dash_filter();
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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

        <div class="col-12 ">


            <div class="col-lg-2 col-md-2">

                <div class="card bg-info">
                    <div class="d-flex flex-row">
                        <div class="p-2">
                            <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                        </div>
                        <div class="text-white align-self-center p-2">
                            <span class="dascount">
                                <h3 class="mb-0">
                                    <?php
                                    $result = $cls_lc->count_lc($pid);
                                    echo $result;
                                    ?>
                                </h3>
                            </span>
                            <span class="text-white">Total LCs</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-2 col-md-2 none">
                <a href="#">
                    <!--<a href="lc_page">-->
                    <div class="card bg-info">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $result = $cls_count->select_lc_count($pid);
                                        echo $result;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">LC Workflow</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-2 col-md-2 none">
                <!--<a href="lc_repository">-->
                <a href="#">
                    <div class="card bg-warning">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
//                                        $result = $cls_count->select_lc_repository_count($pid);
//                                        echo $result;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">LC Repository</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-2 col-md-2 none ">
                <a href="#">
                    <!--<a href="rpa_master">-->
                    <div class="card bg-primary">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-themify-favicon-alt"></i></h3>
                            </div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">

                                    </h3>
                                </span>
                                <span class="text-white">RPA Master</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <div class="col-lg-2 col-md-2 none ">
                <a href="#"> 
                    <!--<a href="rpa_page">--> 
                    <div class="card bg-success">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-signal"></i></h3></div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $result = $cls_count->select_rpa_count($pid);
                                        echo $result;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">RPA Workflow</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-2 col-md-2 none">
                <!--<a href="rpa_repository">-->
                <a href="#">
                    <div class="card bg-inverse">
                        <div class="d-flex flex-row">
                            <div class="p-2">
                                <h3 class="text-white box mb-0"><i class="ti-timer"></i></h3></div>
                            <div class="text-white align-self-center p-2">
                                <span class="dascount">
                                    <h3 class="mb-0">
                                        <?php
                                        $result = $cls_count->select_rpa_repository_count($pid);
                                        echo $result;
                                        ?>
                                    </h3>
                                </span>
                                <span class="text-white">RPA Repository</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Column -->

            <div class="row ">
                <div class="col-lg-12 col-md-12">
                    <div class="material-card card">
                        <div class="card-body repoCard">
                            <center><h4>Dashboard</h4>
                            <p>All values in Lakhs</p></center>
                            <div style=" min-width: 1500px;">
                            <div id="chartdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 ">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive">
                            <table id="zero_config_lc" class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th>SI.No</th>
                                        <th>Vendor</th>                                     
                                        <th>Item</th>
                                        <th>Credit Days</th>
                                        <th>Applicant Bank</th>
                                        <th>Currency</th>
                                        <th>Job Code</th>
                                        <th>Job Desc</th>
                                        <th>PO/WO No.</th>                                        
                                        <th>Order Value</th>                                      
                                        <th>FLC no.</th>                                      
                                        <th>LC Value</th>                                      
                                        <th>Date of Issue </th>                                  
                                        <th>LC Expiry</th>                                     
                                        <th>Last date for Shipment</th>                                     
                                        <th>Total Shipment Value</th>                                     
                                        <th>Balance Material Value to be shipped (LC-Shipment)</th>   
                                        <th>Paid Value</th>    


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_lc->lc_dasboard();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $value['sup_name']; ?></td>
                                            <td><?php echo $value['sol_name']; ?></td>
                                            <td><?php echo $value['credit_days']; ?></td>
                                            <td><?php echo $value['bank_name']; ?></td>
                                            <td><?php echo $value['currency_hname']; ?></td>
                                            <td><?php echo $value['proj_jobcode']; ?></td>
                                            <td><?php echo $value['proj_name']; ?></td>
                                            <td><?php echo $value['lcr_ponumber']; ?></td>
                                            <td><?php echo $value['lcr_povalue']; ?></td>
                                            <td><?php echo $value['lcm_num']; ?></td>
                                            <td><?php echo $value['lcm_value']; ?></td>
                                            <td><?php echo formatDate($value['lcm_from'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['lcm_to'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['lcr_supply_date'], 'd-M-Y'); ?></td>
                                            <td><?php echo $value['lcr_supply']; ?></td>
                                            <td><?php echo $value['balance_ship']; ?></td>
                                            <td><?php echo $value['paid_value']; ?></td>



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
                        window.location.href = "finance?pid=" + Proid;
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
<script>
    am4core.ready(function () {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end



        var chart = am4core.create('chartdiv', am4charts.XYChart)
        chart.colors.step = 2;

        chart.legend = new am4charts.Legend()
        chart.legend.position = 'top'
        chart.legend.position = 'center'
        chart.legend.paddingBottom = 20
        chart.legend.paddingRight = 300
        chart.legend.labels.template.maxWidth = 95

        var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
        xAxis.dataFields.category = 'Vendor'
        xAxis.renderer.cellStartLocation = 0.1
        xAxis.renderer.cellEndLocation = 0.9
        xAxis.renderer.grid.template.location = 0;
        xAxis.renderer.labels.template.wrap = true;
        xAxis.renderer.labels.template.maxWidth = 200;
        xAxis.renderer.labels.template.fontSize = 12;

        var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
        yAxis.min = 0;

        function createSeries(value, name) {
            var series = chart.series.push(new am4charts.ColumnSeries())
            series.dataFields.valueY = value
            series.dataFields.categoryX = 'Vendor'
            series.name = name
//            series.tooltipText = "{categoryX}: {valueY}";
            series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
            series.columns.template.height = am4core.percent(100);
            series.events.on("hidden", arrangeColumns);
            series.events.on("shown", arrangeColumns);

            var bullet = series.bullets.push(new am4charts.LabelBullet())
            bullet.interactionsEnabled = false
            bullet.dy = 20;
            bullet.label.text = '{valueY}'
            bullet.label.rotation = 270;
            bullet.label.truncate = false;
            bullet.label.hideOversized = false;
            bullet.label.fill = am4core.color('#000');


            return series;
        }

        chart.data = JSON.parse('<?php echo $gr_result; ?>')


        createSeries('LC_Value', 'LC Value');
        createSeries('supply', 'Supply');
        createSeries('paid', 'Paid');

        function arrangeColumns() {

            var series = chart.series.getIndex(0);

            var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
            if (series.dataItems.length > 1) {
                var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
                var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
                var delta = ((x1 - x0) / chart.series.length) * w;
                if (am4core.isNumber(delta)) {
                    var middle = chart.series.length / 2;

                    var newIndex = 0;
                    chart.series.each(function (series) {
                        if (!series.isHidden && !series.isHiding) {
                            series.dummyData = newIndex;
                            newIndex++;
                        } else {
                            series.dummyData = chart.series.indexOf(series);
                        }
                    })
                    var visibleCount = newIndex;
                    var newMiddle = visibleCount / 2;

                    chart.series.each(function (series) {
                        var trueIndex = chart.series.indexOf(series);
                        var newIndex = series.dummyData;

                        var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                        series.animate({property: "dx", to: dx}, series.interpolationDuration, series.interpolationEasing);
                        series.bulletsContainer.animate({property: "dx", to: dx}, series.interpolationDuration, series.interpolationEasing);
                    })
                }
            }
        }

    }); // end am4core.ready()
</script>