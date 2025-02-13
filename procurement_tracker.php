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
}  else {
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
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}


$uid = $_SESSION['uid'];
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    #zero_con th,td {
        white-space: nowrap;
        padding: 6px;
        vertical-align: middle;
        text-align: center;
    }
    .cell_width{
        min-width: 200px !important;
        max-width: 200px !important;
    }
    .cell_width1{
        min-width: 15px !important;
        max-width: 15px !important;
    }
    .cell_width2{
        min-width: 350px !important;
        max-width: 350px !important;
    }
    .cell_width3{
        min-width: 250px !important;
        max-width: 250px !important;
    }
    .divheight{
        max-height: 600px;
        overflow-y: scroll;
    }
    .theadPr {
        background-color: #304356 !important;
        color: white !important;
        /*vertical-align: middle;*/
    }
    .vmiddle{
        vertical-align: middle;
    }

    /*    .topfreeze {
            position: sticky;
            top: 0;
            
        }
        .topfreeze1 {
            position: sticky;
            top: 30px;
             
        }
        .topfreeze2 {
            position: sticky;
            top: 60px;
           
        }*/
    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
    .freeze_pt{
        left: -0.5px;
        position: sticky;
        top: auto;    
        z-index: 5 !important;
        border-top: 1px solid rgba(120,130,140,.13) !important;
        background-color: #c4e8f9 !important;


    }
    th ,td{
        white-space: nowrap !important;

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
                <h5 class="font-medium text-uppercase mb-0">Procurement Tracker</h5>
            </div>
            <div class="col-lg-2 col-md-3 col-xs-12 align-self-center" >                
                <select class="custom-select" style=" cursor: pointer;" name="proj_Filter" id="proj_Filter" onchange="proj_Filterpage(this.value, '1')" required="">
                    <option value="">--Select Project--</option>
                    <option value="all">--All--</option>
                    <?php
                    $result = $cls_report->select_allprojects_seg1_swift($segment);
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
                        <li class="breadcrumb-item active" aria-current="page">Procurement Tracker</li>
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

        <!-- basic table -->
        <div class="row" id="thirdrow">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <?php
                        $package_fetch = $cls_user->package_fetch($pid);
                        $fetch = json_decode($package_fetch, true);
                        if (sizeof($fetch) > 0) {
                            ?>
                            <button class=" btn btn-success pull-right"type="button" id="btnExport" style=" float: right;" title=" Export as Excel">Export Excel</button>

                            <div class="table-responsive divheight" id="dvData">
                                <?php
                                if ($pid != "") {
                                    ?>
                                    <table id="zero_connb" class="table_pr table-bordered handsontable nowrap   ">
                                        <thead class="theadPr" >
                                            <tr>
                                                <th colspan="4" class="freeze vmiddle" style="  background: #304356 !important; color: #fff;">PACKAGE DETAILS</th>
                                                <th colspan="5" class="topfreeze vmiddle">PROCUREMENT STATUS</th>
                                                <th colspan="3" class="topfreeze vmiddle">DELIVERY</th>
                                                <th colspan="5" class="topfreeze vmiddle">SIGN OFF DATES - SWIFT</th>
                                                <th colspan="4"  class="topfreeze vmiddle">APPROVAL STATUS</th>
                                                <th colspan="7" class="topfreeze vmiddle">SYSTEM ORDERING STATUS</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="freeze "   style="  background: #304356 !important; color: #fff; white-space: nowrap;  " >SI.NO</th>
                                                <th rowspan="2" class="freeze1 topfreeze1" style="  background: #304356 !important; color: #fff;">Buyer</th>
                                                <th rowspan="2" class="freeze2 topfreeze1" style="  background: #304356 !important; color: #fff;">Description</th>
                                                <th rowspan="2" class="freeze3 topfreeze1" style="  background: #304356 !important; color: #fff;">Vendor</th>

                                                <th colspan="2" class="topfreeze1">Current Status</th>
                                                <th colspan="2" class="topfreeze1">Last Week Status</th>
                                                <th rowspan="2" class="topfreeze1"><?php echo wordwrap('Current Owner / Action By', 15, "<br>\n"); ?></th>

                                                <th rowspan="2"><?php echo wordwrap('Mtls Required at site as per project requirement', 30, "<br>\n"); ?></th>
                                                <th rowspan="2">Delivery Lead Time (No of Days)</th>
                                                <th rowspan="2"><?php echo wordwrap('Actual expected delivery date confirmed by Vendors', 30, "<br>\n"); ?></th>


                                                <th colspan="2">Technical - Solution Sign off Date</th>
                                                <th rowspan="2">O&M Sign off date</th>
                                                <th colspan="2">Package sent to SCM - Date</th>


                                                <th rowspan="2"><?php echo wordwrap('Smart Sign off Initiation Date', 30, "<br>\n"); ?></th>
                                                <th rowspan="2"><?php echo wordwrap('Smart Sign off - Current Approval Flow/Status', 30, "<br>\n"); ?></th>
                                                <th rowspan="2"><?php echo wordwrap('Last Approved - Flow in SS with Date', 30, "<br>\n"); ?></th>
                                                <th rowspan="2"><?php echo wordwrap('SS - Final Approval date', 30, "<br>\n"); ?></th>


                                                <th rowspan="2" >LOI Ref No</th>
                                                <th rowspan="2" >LOI date</th>
                                                <th rowspan="2" >EMR No</th>
                                                <th rowspan="2" >EMR Date</th>
                                                <th rowspan="2" ><?php echo wordwrap('PO Status (Released/Not released)', 30, "<br>\n"); ?></th>
                                                <th rowspan="2" >WO Status</th>
                                                <th rowspan="2" >Remarks</th>

                                            </tr>
                                            <tr>
                                                <th class="topfreeze2 cell_width">Status</th>
                                                <th class="topfreeze2">Exp date of order closing</th>
                                                <th class="topfreeze2">Status</th>
                                                <th class="topfreeze2">Exp date of order closing</th>

                                                <th>Initial</th>
                                                <th><?php echo wordwrap('Final  post rejection of package by SCM/Ops in Swift', 30, "<br>\n"); ?></th>
                                                <th>Initial</th>
                                                <th>Actual (Final Acceptance)</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($fetch as $key => $value) {
                                                $packid = $value['pm_packid'];
                                                $buyer = $cls_user->fetch_buyername($packid);
                                                $all = $cls_user->fetch_alldatils($packid);
                                                $current_status = $cls_user->current_status($packid);
                                                $current_status_1 = $cls_user->current_status_1($packid);
                                                $get_techsignoff = $cls_user->get_techsignoffdate($packid, '6');
                                                $omsignoff = $cls_user->get_techsignoffdate($packid, '9');
                                                $scm_initial = $cls_user->get_techsignoffdate($packid, '12');
                                                $scm_accpted = $cls_user->get_techsignoffdate($packid, '14');
                                                $approval_initiate = $cls_user->get_techsignoffdate($packid, '16');
                                                $smartsign_approved = $cls_user->smart_approve($packid, '1');
                                                $smartsign_status = $cls_user->smart_approve($packid, '0');
                                                $sytem_details = $cls_user->system_details($packid);
                                                $target_date = $cls_user->target_date($packid);
                                                ?>
                                                <tr>
                                                    <td class=" freezetd vmiddle" width="15"   ><b><?php echo $key + 1; ?></b></td>
                                                    <td class=" freeze1td cell_width vmiddle"><b><?php echo wordwrap($buyer, 20, "<br>\n"); ?></b></td>
                                                    <td class=" freeze2td cell_width vmiddle"><b><?php echo wordwrap($value['pm_packagename'], 20, "<br>\n"); ?></b></td>
                                                    <td class=" freeze3td cell_width vmiddle"><b><?php echo wordwrap($all['sup_name'], 20, "<br>\n"); ?></b></td>
                                                    <td class="vmiddle cell_width2"><span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm"><?php echo $current_status; ?></span></td>
                                                    <td class="vmiddle cell_width"><?php echo date('d-M-Y', strtotime($value['pm_material_req'])); ?></td>
                                                    <td contenteditable="true" class="cell_width bg-light-custom last_status<?php echo $packid; ?>"  onkeyup="last_week_status('<?php echo $packid; ?>')"> <?php echo wordwrap($value['last_week_status'], 20, "<br>\n"); ?> </td>
                                                    <td class=""> <?php
                                                        if ($target_date['sm_target'] != "") {
                                                            echo date('d-M-Y', strtotime($target_date['sm_target']));
                                                        }
                                                        ?></td>
                                                    <td ><?php echo wordwrap($current_status_1, 30, "<br>\n"); ?></td>
                                                    <td ><?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                                                    <td><?php echo $value['pm_revised_lead_time']; ?></td>
                                                    <td contenteditable="true" class=" bg-light-custom"  >
                                                        
                                                        <input onchange="last_week_status('<?php echo $packid; ?>')" type="date" value="<?php   if (trim($value['expDateVendor']) != "") { echo date('Y-m-d', strtotime($value['expDateVendor']));  }  ?>" id="expDateVendor<?php echo $packid; ?>">

                                                    </td>
                                                    <td><?php echo date('d-M-Y', strtotime($value['pm_createdate'])); ?></td>
                                                    <td><?php
                                                        if ($get_techsignoff['ps_actualdate'] != "") {
                                                            echo date('d-M-Y', strtotime($get_techsignoff['ps_actualdate']));
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($omsignoff['ps_actualdate'] != "") {
                                                            echo date('d-M-Y', strtotime($omsignoff['ps_actualdate']));
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($scm_initial['ps_actualdate'] != "") {
                                                            echo date('d-M-Y', strtotime($scm_initial['ps_actualdate']));
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($scm_accpted['ps_actualdate'] != "") {
                                                            echo date('d-M-Y', strtotime($scm_accpted['ps_actualdate']));
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <?php
//                                                    if ($approval_initiate['ps_actualdate'] != "") {
//                                                        echo date('d-M-Y', strtotime($approval_initiate['ps_actualdate']));
//                                                    }
                                                        if ($target_date['sm_target'] != "") {
                                                            echo date('d-M-Y', strtotime($target_date['sm_target']));
                                                        }
                                                        ?>

                                                    </td>
                                                    <td><?php
                                                        if ($smartsign_status['s_date'] != "") {
                                                            echo $smartsign_status['receiver'];
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($smartsign_approved['s_date'] != "") {
                                                            echo $smartsign_approved['dep_name'] . ' - ' . date('d-M-Y', strtotime($smartsign_approved['s_date']));
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($smartsign_approved['s_date'] != "") {
                                                            echo $smartsign_approved['dep_name'] . ' - ' . date('d-M-Y', strtotime($smartsign_approved['s_date']));
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        if ($sytem_details['so_loi_date'] != "") {
                                                            echo date('d-M-Y', strtotime($sytem_details['so_loi_date']));
                                                        }
                                                        ?></td>
                                                    <td><?php echo $sytem_details['loi_number'] ?></td>
                                                    <td><?php echo $sytem_details['emr_number'] ?></td>
                                                    <td><?php
                                                        if ($sytem_details['emr_createddate'] != "") {
                                                            echo date('d-M-Y', strtotime($sytem_details['emr_createddate']));
                                                        }
                                                        ?></td>
                                                    <td >
                                                        <?php
                                                        if ($sytem_details['so_hw_sw'] == 2) {
                                                            if ($sytem_details['po_number'] != "") {
                                                                echo 'PO Not Relased';
                                                            } else {
                                                                echo 'PO  Relased';
                                                            }
                                                        } else if ($sytem_details['so_hw_sw'] == 3) {
                                                            if ($sytem_details['po_number'] != "") {
                                                                echo 'PO Not Relased';
                                                            } else {
                                                                echo 'PO  Relased';
                                                            }
                                                        } else {
                                                            
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($sytem_details['so_hw_sw'] == 1) {
                                                            if ($sytem_details['wo_number'] != "") {
                                                                echo 'WO Not Relased';
                                                            } else {
                                                                echo 'WO  Relased';
                                                            }
                                                        } else if ($sytem_details['so_hw_sw'] == 3) {
                                                            if ($sytem_details['po_number'] != "") {
                                                                echo 'WO Not Relased';
                                                            } else {
                                                                echo 'WO  Relased';
                                                            }
                                                        } else {
                                                            
                                                        }
                                                        ?>
                                                    </td>
                                                    <td contenteditable="true" class=" bg-light-custom repo_remarks<?php echo $packid; ?>"  onkeyup="last_week_status('<?php echo $packid; ?>')"><?php echo $value['repo_remarks']; ?></td>


                                                </tr>  
                                            <?php }
                                            ?>

                                        </tbody>
                                    </table>
                                <?php } else {
                                    ?>
                                    <p class=" text-center"> Please select project & Proceed!!!</p> 
                                    <?php
                                }
                            } else {
                                ?>
                                <br>
                                <p class=" text-center"> No Data Found!!!</p> 
                            <?php }
                            ?>

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
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
                                            function proj_Filterpage(id) {
                                                window.location.href = "procurement_tracker?pid=" + id;
                                            }
                                            $("#btnExport").click(function (e) {
                                                //  window.open(MIMEtype,replace);
//        $('.view1').hide();

                                                var a = document.createElement('a');
                                                //getting data from our div that contains the HTML table
                                                var data_type = 'data:application/vnd.ms-excel';
                                                var table_div = document.getElementById('dvData');
                                                var table_html = table_div.outerHTML.replace(/ /g, '%20');
                                                a.href = data_type + ', ' + table_html;
                                                //setting the file name
                                                a.download = 'procurement_tracker.xls';
                                                //triggering the function
                                                a.click();
                                                //just in case, prevent default behaviour
                                                e.preventDefault();
                                            });
                                            function last_week_status(id) {
                                                var last_status = $('.last_status' + id).text();
                                                var repo_remarks = $('.repo_remarks' + id).text();
                                                var expDateVendor = $('#expDateVendor' + id).val();
                                                $.post("code/last_week_status.php", {key: id, last_status: last_status, repo_remarks: repo_remarks, expDateVendor: expDateVendor}, function (data) {

                                                });
                                            }
</script>
