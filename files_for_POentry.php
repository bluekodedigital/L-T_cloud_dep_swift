<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
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
?>
<style>
    #modeltable.display thead th {
        padding: 8px 18px 8px 10px;
        border: 1px solid black;
        font-weight: bold;
        cursor: pointer;
        /* background-color:#2cabe3; */
        background-color: #0284c0;
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
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Files For PO Entry</h5>
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
                    onchange="proj_Filter(this.value, '10')" required="">
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
                        <li class="breadcrumb-item active" aria-current="page">PO Details Entry</li>
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
                            <!-- <table id="file_export" class="table table-bordered display compact"> -->
                            <table id="file_export" style=" white-space: nowrap !important;"
                                class="table table-bordered display compact">

                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <th style="padding-right: 13px !important;">PO Number</th>
                                        <th style="padding-right: 13px !important;">Material Req</th>
                                        <th style="padding-right: 13px !important;">Vendor</th>
                                        <th style="padding-right: 13px !important;">No of Items</th>
                                        <th style="padding-right: 13px !important;">Manf.Clearance (%)</th>
                                        <th style="padding-right: 13px !important;">Inspection (%)</th>
                                        <th style="padding-right: 13px !important;">MDCC/Custom Clearance (%)</th>
                                        <th style="padding-right: 13px !important;">Material Rec@site (%)</th>
                                        <th style="padding-right: 13px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_user->files_for_podetailsalter($pid, $segment);
                                    //                                     print_r($result);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
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
                                                <?php echo $value['proj_name'] ?>
                                                <?php if ($value['proj_type'] != '') { ?>
                                                    <span class="blink">
                                                        <span class='type_sty <?php echo $ptype_col; ?>'>
                                                            <?php echo $ptype; ?>
                                                        </span>
                                                        <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo $value['pm_packagename'] ?>
                                            </td>
                                            <td>
                                                <?php echo $value['po_number'] ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-success font-medium text-white ml-1">
                                                    <?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?>
                                                </span></td>
                                            <td>
                                                <?php
                                                $pack_id = $value['po_pack_id'];
                                                $vendor_details = $cls_user->vendor_details($pack_id);
                                                echo $vendor_details['sup_name'];
                                                ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                    <?php echo number_format($value['count'], 2); ?>
                                                </span></td>
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                    <?php echo number_format($value['manuQty'], 2); ?>
                                                </span></td>
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                    <?php echo number_format($value['insQty'], 2); ?>
                                                </span></td>
                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                    <?php echo number_format($value['mdccQty'], 2); ?>
                                                </span>
                                                <?php if ($value['cclrQty'] != 0) { ?>
                                                    <span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                        <?php echo number_format($value['cclrQty'], 2) ?>
                                                    </span>
                                                <?php }
                                                ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1">
                                                    <?php echo number_format($value['mrecQty'], 2) ?>
                                                </span></td>
                                            <td>
                                                <span style="background-color: #1ABC9C!important;"
                                                    class="badge badge-pill badge-danger font-medium text-white ml-1"
                                                    alt="default" data-toggle="modal" data-target="#model_edit"
                                                    class="model_img img-fluid"
                                                    onclick="po_detailsenter('<?php echo $value['po_pack_id']; ?>')"><i
                                                        class="fas fa-pencil-alt"></i></span>
                                                <span
                                                    class="badge badge-pill badge-danger orange font-medium text-white ml-1"
                                                    alt="default" data-toggle="modal" data-target="#model_view"
                                                    class="model_img img-fluid"
                                                    onclick="podetailview('<?php echo $value['po_pack_id']; ?>')"><i
                                                        class="fas fa-eye"></i></span>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade bs-example-modal-lg" id="model_edit" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content" id="po_content" style="width:116%;margin-left:-8%;margin-top:-2%; ">

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade bs-example-modal-lg" id="model_view" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content" id="podetailvie" style="width:116%;margin-left:-8%;margin-top:-2%;">
                        <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6>
                            <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; ">Project name</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive" style="height:500px">
                                <table class="table table-bordered display compact" id="modeltable">
                                    <thead class="bg-info text-white">
                                        <tr>
                                            <th colspan="6">Package name Name</th>
                                            <th colspan="5">Po Number</th>
                                        </tr>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Description</th>
                                            <th>Item Code</th>
                                            <th>Rate</th>
                                            <th>Po Qty</th>
                                            <th>View</th>
                                            <th>Manufacture Clear Qty</th>
                                            <th>Ins Qty</th>
                                            <th>MDCC Qty</th>
                                            <th>Custom Clr. Qty</th>
                                            <th>Mat Rec Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border border-info">
                                        <?php for ($i = 1; $i <= 30; $i++) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $i ?>
                                                </td>
                                                <td>
                                                    <?php echo "desc" . $i ?>
                                                </td>
                                                <td>
                                                    <?php echo "Code" . $i ?>
                                                </td>
                                                <td>
                                                    <?php echo $i + 1000 ?>
                                                </td>
                                                <td>
                                                    <?php echo $i + 10 ?>
                                                </td>
                                                <td><label
                                                        class="badge badge-pill badge-info font-medium text-white ml-1 pull-left"
                                                        data-toggle="modal" data-target="#myModal1"><i
                                                            class=" fa fa-eye"></i></label></td>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                                <td style="text-align:center"></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect text-left"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div class="modal fade" id="myModal1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style="width:120%;">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Entry Dates</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <div id="pohistory"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger btn-rounded" data-dismiss="modal">
                                &times; Close</button>
                            <!-- <button type="button" class="btn btn-outline-success btn-rounded">Allocate</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>

<script src="code/js/ops.js" type="text/javascript"></script>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

<script>
    function getspocid(a, b, c) {
        var spocid = a;
        var project = b;
        var pack_id = c;
        $("#proj").text(project);
        $("#spoc_id").val(spocid);
        $("#exp_date").disabled = true;
        $("#act_date").datepicker("setDate", new Date());
        document.getElementById("exp_date").disabled = true;
        $.post("functions/filesforexpert.php", {
            key: pack_id
        }, function (data) {
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $("#pack").html(pm_packagename);
        });
        $.post("functions/opsremarks.php", {
            key: pack_id
        }, function (data) {
            $('#opsr').html(data);
        });
    }
</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>