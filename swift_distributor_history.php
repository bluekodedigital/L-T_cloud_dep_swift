<?php
include 'config/inc.php';


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

include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
?>
<style>
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
                <h5 class="font-medium text-uppercase mb-0">Distributor Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_type" id="proj_type"
                    onchange="proj_type_Filter_proj(this.value, '4')" required="">
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
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="proj_id" id="proj_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if ($_SESSION['milcom'] == '1') {
                        $seg = '38';
                    } else {
                        $seg = "";
                    }
                    // $result = $cls_comm->techspoc_proj_filter($seg);
                    $result = $cls_report->select_filterprojects_seg2($seg, $ptid);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>>
                            <?php echo $value['proj_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="tech_spoc">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Repository</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Current Status</th>
                                        <th>Distributor / OEM </th>
                                        <th>PO / WO Number</th>
                                        <th>PO /WO date</th>
                                        <th>Action</th>
                                        <!-- <th>Attachment</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_swift_distributor($pid, $_SESSION['uid'], $seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $packid = $value['pw_packid'];
                                        $projid = $value['pw_projid'];
                                        $projname = $value['proj_name'];
                                        $packname = $value['pm_packagename'];
                                        $po_no = $value['po_no'];

                                        $po_date = formatDate($value['po_approved_on'], 'd-M-y'); 
                                        $wo_no = $value['wo_no'];
                                        // echo $value['wo_approved_on'];
                                        if ($value['wo_approved_on'] != '') {
                                            $wo_date = formatDate($value['wo_approved_on'], 'd-M-y');
                                        } else {
                                            $wo_date = '';
                                        }
                                        $today = date('Y-m-d');


                                        $status_current = $cls_comm->cur_status_distflow($packid, $projid);
                                        $from_dist = $status_current['from_dist'];
                                        $to_dist = $status_current['to_dist'];
                                        $status_name = $cls_comm->cur_status_distname($packid, $projid, $to_dist);
                                        $cur_flag = $status_name['flag'];
                                        $contact_name = $status_name['contact_name'];
                                        $oem_flag = $status_name['oem_flag'];

                                        $status = $cls_comm->cur_status_dist($packid, $projid, $to_dist);
                                        $supplier = $cls_comm->cur_status_supp($packid, $projid);
                                        $send_back = $supplier['send_back'];
                                        $logdays = $cls_comm->logday($packid, $projid, $from_dist);
                                        // print_r($logdays['to_md_id']);echo "<br>";
                                        // $res2 = json_decode($logdays, true);
                                        //  echo count($res2);
                                        // $send        = $cls_comm->send_flag($packid, $projid);
                                    
                                        $approved_on = $logdays['approved_date'];

                                        if ($approved_on == '') {
                                            $date2 = date_create($today);
                                            $date1 = date_create(formatDate($value['po_approved_on'], 'y-m-d'));
                                            $diff = date_diff($date1, $date2);
                                            $Days = $diff->format("%a days");
                                        } else {
                                            $date2 = date_create($today);
                                            $date1 = date_create(formatDate($value['approved_date'], 'y-m-d'));
                                            $diff = date_diff($date1, $date2);
                                            $Days = $diff->format("%a days");
                                        }
                                        if ($cur_flag == '') {
                                            $flag = 1;
                                            $count = 1;
                                        } else {
                                            $flag = $cur_flag;
                                            $count = $status['fcount'];
                                        }
                                        if ($oem_flag == '') {
                                            $oem_status = '';
                                        } else {
                                            $oem_status = 'Order Accepted';
                                        }
                                        // echo count($res2);
                                        //print_r($res2);echo "<br>";
                                    
                                        //  foreach ($res2 as $key => $value2) {
                                        //     print_r($value2['dl_flag']);echo "<br>";
                                        //  }
                                        // if ($logdays['to_md_id'] == '') {
                                        //     $flags = 1;
                                        // } else {
                                        //     //$logdays['to_md_id'];
                                        //     $new  = $cls_comm->nextstage($packid, $projid, $logdays['to_md_id']);
                                        // }
                                    

                                        //$count      = $status['fcount'];
                                        //$flag       = $status['flag'];
                                        //$md_date    = $status['md_date'];
                                        // $approved_on       = $status['approved_on'];
                                        if ($send_back == 1) {
                                            $current_status = 'Send Back By Buyer';
                                        } else if ($send_back == 2) {
                                            $current_status = 'Revised From Distributor';
                                        } else if ($flag == 1) {
                                            $current_status = 'Distributor' . ' - ' . $count . ' / ' . $Days;
                                        } else if ($flag == 2) {
                                            $current_status = 'OEM' . ' ' . $oem_status . ' / ' . $Days;
                                        }

                                        // if ($flag == 2) {
                                        //     $current_status = 'OEM' . ' ' . $oem_com;
                                        // } else if ($flag == 1) {
                                        //     $current_status = 'Distributor' . ' - ' . $count;
                                        // } else if ($flag == 0) {
                                        //     $current_status = 'Site Operation';
                                        // }
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
                                                <?php echo $projname ?>
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
                                                <?php echo $packname ?>
                                            </td>
                                            <td><span
                                                    style=" background-color: rgb(44, 36, 158) !important ; color:white !important;"
                                                    class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">
                                                    <?php echo $current_status;
                                                    // if (($flag == '2') && ($send_back == 1)) {
                                                    //     echo $current_status = ' Send Back by Buyer';
                                                    // } else if (($flag == '2') && ($send_back == 0)) {
                                                    //    echo $current_status = 'Revised From Distributor';
                                                    // } else {
                                                
                                                    //}
                                                    ?>
                                                </span></td>
                                            <td>
                                                <?php echo $contact_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $po_no;
                                                if ($wo_no != '') { ?>/
                                                    <?php echo $wo_no;
                                                } ?>
                                            </td>
                                            <td>
                                                <?php echo $po_date;
                                                if ($wo_date != '') { ?>/
                                                    <?php echo $wo_date;
                                                } ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    onclick="getsid( '<?php echo $projid; ?>', '<?php echo $packid; ?>','<?php echo $projname; ?>','<?php echo $flag ?> ','<?php echo $current_status; ?>')"
                                                    data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"
                                                    style=" cursor: pointer;" data-toggle="tooltip"
                                                    data-original-title="Send Packages to Tech Spoc"> <i
                                                        class="fas fa-paper-plane"></i> </span>
                                            </td>
                                            <!-- <td>
                                                <span class="pointer" onclick="view_dist_files('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $projid; ?>', '<?php echo $packid; ?>','<?php echo $flag; ?>')" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo">
                                                    <i class="fas fa-paperclip text-black"></i>
                                                </span>
                                            </td> -->
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
                data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width: 218%;margin-left: -265px;">
                        <div class="modal-header" style="padding-bottom: 3%;">
                            <h4 class="modal-title" id="exampleModalLabel1">Distributor -OEM Tracking</span></h4>
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h5 id="pack"><small></small></h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-4" id="pd">
                                    <span class="badge badge-pill badge-primary font-12 text-white ml-1">Project Name :
                                    </span> <span id="proj"> </span>
                                </div>
                                <div class=" col-md-4" id="ps">
                                    <span class="badge badge-pill badge-info font-12 text-white ml-1">Package Name :
                                    </span> <span id="pack_name"></span>
                                </div>
                                <div class=" col-md-4" id="pc">
                                    <span class="badge badge-pill badge-warning font-12 text-white ml-1"> Current Status
                                        : </span> <span id="current_status"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <!-- <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <center>Package Sent<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="ps_plandate"></span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="ps_actdate"></span>
                                        </center>
                                    </div>
                                    <div class="col-md-4">
                                        <center>Package Approval<br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="pa_plandate"></span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="pa_actdate"></span>
                                        </center>
                                    </div>
                                    <div class="col-md-4">
                                        <center>LOI <br>
                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" id="loi_plandate"></span>
                                            <span class="badge badge-pill badge-info font-medium text-white ml-1" id="loi_actdate"></span>
                                        </center>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <div class="row" id="powo">

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
                            <!-- <button type="submit" class="btn btn-outline-primary btn-rounded" name="approve_package" id="submitbtn" ><i class="fas fa-paper-plane"></i>  Send</button> -->
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
            <!-- /.modal -->
            <!-- sample modal content -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 200%; margin-left: -43%">
                        <div class="modal-header" style="padding-bottom: 3%;">
                            <input type="hidden" name="projid" id="projid">
                            <input type="hidden" name="packid" id="packid">
                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> -
                                <small id="pack1">Package Name</small>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-5" id="pd">
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
                                            id="expndate" onclick="downloadall('0');">Download All</span></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <form>
                                    <div class="col-md-12" id="ops_exp_uptable">

                                    </div>
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

    </div>
    <script src="code/js/technical.js" type="text/javascript"></script>
    <script src="code/js/ops.js" type="text/javascript"></script>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script>
    function swift_proj(Proid) {
        var tid = $('#proj_type').val();
        window.location.href = "swift_distributor_history?pid=" + Proid + "&ptid=" + tid;
    }
</script>

<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
    function getsid(b, c, d, f, cs) {

        var project = b;
        var pack_id = c;
        $("#proj").text(d);
        $.post("functions/ss_getplandate.php", {
            key: pack_id
        }, function (data) {
            var ps_plandate = JSON.parse(data).ps_plandate;
            var pa_plandate = JSON.parse(data).pa_plandate;
            var loi_plandate = JSON.parse(data).loi_plandate;
            var ps_actdate = JSON.parse(data).ps_actdate;
            var pa_actdate = JSON.parse(data).pa_actdate;
            var loi_actdate = JSON.parse(data).loi_actdate;
            var pack = JSON.parse(data).pack_name;
            var mat_req = JSON.parse(data).mat_req;
            $('#ps_plandate').html(ps_plandate);
            $('#pa_plandate').html(pa_plandate);
            $('#loi_plandate').html(loi_plandate);
            $('#ps_actdate').html(ps_actdate);
            $('#pa_actdate').html(pa_actdate);
            $('#loi_actdate').html(loi_actdate);
            $('#pack_name').text(pack);
            $('#current_status').html(cs);
            // $("#po_planned").disabled = true;
            // document.getElementById("wo_expected").disabled = true;
            // document.getElementById("wo_planned").disabled = true;
            // document.getElementById("po_expected").disabled = true;
            // document.getElementById("po_expected1").disabled = true;
            // document.getElementById("po_planned").disabled = true;
        });
        $.post("functions/order_approve.php", {
            pack_id: pack_id,
            projid: project,
            flag: f
        }, function (data1) {
            // console.log(data1);
            $('#powo').html(data1);
        });
    }
</script>