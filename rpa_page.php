<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">RPA WorkFlow</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techspoc_proj_filter();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">RPA Work Flow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- basic table -->
        <div class="row" id="package_create" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="tab_select">
                        <!-- <h4 class="card-title">Package Creation Form</h4> -->
                        <ul class="nav nav-pills mt-4 mb-1">
                            <li class=" nav-item"> <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">RPA For POs</a> </li>
                            <li class="nav-item"> <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">RPA For WOs</a> </li>
                        </ul>
                        <div class="tab-content border p-4">
                            <div id="navpills-1" class="tab-pane active">

                                <!-- End Row -->
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <?php
                                        if (isset($_GET['msg'])) {
                                            $msg = $_GET['msg'];
                                        } else {
                                            $msg = '';
                                        }if ($msg == '0') {
                                            ?>
                                            <div class="alert alert-danger alert-rounded">  
                                                <i class="fa fa-exclamation-triangle"></i>RPA validity has been expired.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                            </div>
                                        <?php } else if ($msg == '1') { ?>
                                            <div class="alert alert-danger alert-rounded">  
                                                <i class="fa fa-exclamation-triangle"></i>RPA value exceeds PO value
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="material-card card">
                                            <div class="card-body">
                                                <!--<h4 class="card-title">Work Flow</h4>-->
                                                <div class="table-responsive">
                                                    <table id="zero_config" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <!--<th>Project</th>-->
                                                                <th>Package</th>
                                                                <th>PO Number</th>
                                                                <th>Vendor</th>
                                                                <th>Schedule</th>                                      
                                                                <th>Material Req</th>                                      
                                                                <th>Stage Planned</th>                                      
                                                                <th>Stage Expected</th>                                      
                                                                <!--<th>Stage Actual</th>-->                                      
                                                                <!--<th>Remarks</th>-->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $result = $cls_comm->select_rpa($pid);
                                                            $res = json_decode($result, true);
                                                            foreach ($res as $key => $value) {
                                                                $projname = $cls_comm->project_name($value['cm_proj_id']);
                                                                $packname = $cls_comm->package_name($value['cm_pack_id']);
                                                                $created_date = $cls_comm->datechange(formatDate($value['created_date'], 'Y-m-d'));
                                                                $sendername = $cls_comm->get_username($value['ts_senderuid']);
                                                                $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                                                $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                                                $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                                                $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                                                $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                                                $po_num = $value['po_number'];
                                                                $wo_num = $value['wo_number'];
                                                                $getid = $value['cm_id'];
                                                                ?>
                                                                <tr>
                                                                    <!--<td><?php echo $projname ?></td>-->
                                                                    <?php
                                                                    if ($actual_date > $planned_date) {
                                                                        $alert = "";
                                                                        $point = "";
                                                                    } elseif ($actual_date < $planned_date) {
                                                                        $alert = "greenotify";
                                                                        $point = "greenpoint";
                                                                    } else {
                                                                        $alert = "bluenotify";
                                                                        $point = "bluepoint";
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <div class="notify pull-left">
                                                                            <span class="heartbit <?php echo $alert; ?>"></span>
                                                                            <span class="point <?php echo $point ?>" ></span>
                                                                        </div><?php echo $packname ?>
                                                                    </td>
                                                                    <td><?php echo $po_num; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $pack_id = $value['cm_pack_id'];
                                                                        $vendor_details = $cls_user->vendor_details($pack_id);
                                                                        $vq_venid = $vendor_details['vq_venid'];
                                                                        echo '<span>' . $vendor_details['sup_name'] . '</span>';
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $schedule_date ?></td>
                                                                    <td><?php echo $mat_req ?></td>
                                                                    <td><?php echo $rev_planned_date ?></td>
                                                                    <td><?php // echo $except_date                  ?>
                                                                        <div class="input-group" id="expdiv" style=" float: left;">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                            </div>
                                                                            <input type="text" value="<?php echo $except_date; ?>"  class="form-control mydatepicker" id="dasexpected_date<?php echo $value['cm_pack_id'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                                        </div>
                                                                        <div class=" saveexp" style=" float: right;">
                                                                            <span   class="badge badge-pill badge-success font-medium text-white ml-1" onclick="save_expected('<?php echo $value['cm_pack_id'] ?>', '24')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                                                <i class="fas fa-save"></i> Save
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                    <!--<td><?php echo date('d-M-y'); ?></td>-->
    <!--                                                                    <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="OPS Remarks" style=" cursor: pointer;" 
                                                                               onclick="swal('<?php echo $value['ps_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>
                                                                    -->
                                                                    <td>
                                                                        <?php if ($po_num == "") { ?>
                                                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="swal('PO Not Created Yet')"   style=" cursor: pointer;" > <i class="fas fa-paper-plane"></i></span>

                                                                            <?php
                                                                        } else {
                                                                            $check_vendorlc = $cls_user->check_vendorrpa($vq_venid);
                                                                            ?>
                                                                            <?php if ($check_vendorlc == '') { ?>
                                                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="swal('RPA Number not created for this Vendor')"   style=" cursor: pointer;" > <i class="fas fa-paper-plane"></i></span>

                                                                            <?php } else { ?>
                                                                                <span class = "badge badge-pill badge-primary font-medium text-white ml-1" onclick = "getrpacontent('<?php echo $getid ?>', '<?php echo $value['cm_pack_id'] ?>')" data-toggle = "modal" data-target = "#exampleModal" style = " cursor: pointer;" > <i class = "fas fa-paper-plane"></i></span>
                                                                            <?php }
                                                                            ?>

                                                                        <?php }
                                                                        ?>
                                                                    </td>
                                                                    <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
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
                            <div id="navpills-2" class="tab-pane">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="material-card card">
                                            <div class="card-body">
                                                <!--<h4 class="card-title">Work Flow</h4>-->
                                                <div class="table-responsive">
                                                    <table id="zero_config1" class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <!--<th>Project</th>-->
                                                                <th>Package</th>
                                                                <!--<th>PO Number</th>-->
                                                                <th>WO Number</th>
                                                                <th>Vendor</th>
                                                                <th>Schedule</th>                                      
                                                                <th>Material Req</th>                                      
                                                                <th>Stage Planned</th>                                      
                                                                <th>Stage Expected</th>                                      
                                                                <!--<th>Stage Actual</th>-->                                      
<!--                                                                <th>Remarks</th>-->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $result = $cls_comm->select_rpa($pid);
                                                            $res = json_decode($result, true);
                                                            foreach ($res as $key => $value) {
                                                                $projname = $cls_comm->project_name($value['cm_proj_id']);
                                                                $packname = $cls_comm->package_name($value['cm_pack_id']);
                                                                $created_date = $cls_comm->datechange(formatDate($value['created_date'], 'Y-m-d'));
                                                                $sendername = $cls_comm->get_username($value['ts_senderuid']);
                                                                $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                                                $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                                                $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                                                $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                                                $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                                                $po_num = $value['po_number'];
                                                                $wo_num = $value['wo_number'];
                                                                $getid = $value['cm_id'];
                                                                ?>
                                                                <tr>
                                                                    <!--<td><?php echo $projname ?></td>-->
                                                                    <?php
                                                                    if ($actual_date > $planned_date) {
                                                                        $alert = "";
                                                                        $point = "";
                                                                    } elseif ($actual_date < $planned_date) {
                                                                        $alert = "greenotify";
                                                                        $point = "greenpoint";
                                                                    } else {
                                                                        $alert = "bluenotify";
                                                                        $point = "bluepoint";
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <div class="notify pull-left">
                                                                            <span class="heartbit <?php echo $alert; ?>"></span>
                                                                            <span class="point <?php echo $point ?>" ></span>
                                                                        </div><?php echo $packname ?>
                                                                    </td>
                                                                    <!--<td><?php echo $po_num; ?></td>-->
                                                                    <td><?php echo $wo_num; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        $pack_id = $value['cm_pack_id'];
                                                                        $vendor_details = $cls_user->vendor_details($pack_id);
                                                                        $vq_venid = $vendor_details['vq_venid'];
                                                                        echo '<span>' . $vendor_details['sup_name'] . '</span>';
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $schedule_date ?></td>
                                                                    <td><?php echo $mat_req ?></td>
                                                                    <td><?php echo $rev_planned_date ?></td>
                                                                    <td><?php // echo $except_date                  ?>
                                                                        <div class="input-group" id="expdiv" style=" float: left;">
                                                                            <div class="input-group-append">
                                                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                            </div>
                                                                            <input type="text" value="<?php echo $except_date; ?>"  class="form-control mydatepicker" id="dasexpected_date<?php echo $value['cm_pack_id'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                                        </div>
                                                                        <div class=" saveexp" style=" float: right;">
                                                                            <span   class="badge badge-pill badge-success font-medium text-white ml-1" onclick="save_expected('<?php echo $value['cm_pack_id'] ?>', '24')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                                                <i class="fas fa-save"></i> Save
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                    <!--<td><?php echo date('d-M-y'); ?></td>-->
    <!--                                                                    <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="OPS Remarks" style=" cursor: pointer;" 
                                                                               onclick="swal('<?php echo $value['ps_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>
                                                                    -->
                                                                    <td>
                                                                        <?php if ($wo_num == "") { ?>
                                                                            <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="swal('WO Not Created Yet')"   style=" cursor: pointer;" > <i class="fas fa-paper-plane"></i></span>

                                                                            <?php
                                                                        } else {
                                                                            $check_vendorlc = $cls_user->check_vendorrpa($vq_venid);
                                                                            ?>
                                                                            <?php if ($check_vendorlc == '') { ?>
                                                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="swal('RPA Number not created for this Vendor')"   style=" cursor: pointer;" > <i class="fas fa-paper-plane"></i></span>

                                                                            <?php } else { ?>
                                                                                <span class = "badge badge-pill badge-primary font-medium text-white ml-1" onclick = "getrpacontent_wo('<?php echo $getid ?>', '<?php echo $value['cm_pack_id'] ?>')" data-toggle = "modal" data-target = "#exampleModal" style = " cursor: pointer;" > <i class = "fas fa-paper-plane"></i></span>
                                                                            <?php }
                                                                            ?>
                                                                        <?php }
                                                                        ?>
                                                                    </td>
                                                                    <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- sample modal content -->                     
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style=" width: 120%;" id="lc_content">


                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style=" width: 120%;">
                    <div class="modal-header" style="padding-bottom: 3%;">

                        <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj1">Project Name</span> - <small id="pack1">Package Name</small></h4> 
                        <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                        <h5 id="pack"><small></small></h5> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class=" col-md-6" id="pd">
                                <small>Target Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date1"></span></small>                           
                            </div>

                            <div class=" col-md-6" id="ps">
                                <small>ORG/REV Material Required:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date1"></span></small>                          
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="needs-validation" action="functions/lc_rpa_entry.php" autocomplete="off">                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="revend_date">RPA Number</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="rpa_number" name="rpa_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="revend_date">RPA Date</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="rpa_date" name="rpa_date"  required="" placeholder="mm/dd/yyyy">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="example">
                                    <h4 class="card-title mt-4">Valid From & Valid To</h4>
                                    <!-- <h6 class="card-subtitle">just add id <code>#date-range</code> to create it.</h6> -->
                                    <div class="input-daterange input-group" id="date-range1">
                                        <input type="text" class="form-control" name="start_rpa" />
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info b-0 text-white">TO</span>
                                        </div>
                                        <input type="text" class="form-control" name="end_rpa" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">RPA Value:</label>
                                <input type="text" name="rpa_value" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Enter Remarks:</label>
                                <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                            </div>
                            <!-- <div class="row" id="opsr" style="margin-left:0%;">
                                
                            </div>  -->
                            <input type="hidden" id="rpa_row_id" name="rpa_row_id">
                            <input type="hidden" id="rpa_pack_id" name="rpa_pack_id">
                            </div>
                            <div class="modal-footer">
                                <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
                                <button type="submit" class="btn btn-outline-primary btn-rounded" name="rpa_create" id="submitbtn" ><i class="fas fa-paper-plane"></i> Lc Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </div>
        <?php
        include_once('layout/foot_banner.php');
        ?>
    </div>
    <script src="code/js/technical.js" type="text/javascript"></script>
    <script src="code/js/lc_rpa.js" type="text/javascript"></script>
    <script>
                                                                                    function getrpacontent(a, b) {
                                                                                        var getid = a;
                                                                                        var pack_id = b;
                                                                                        $("#lc_row_id").val(getid);
                                                                                        $("#lc_pack_id").val(pack_id);
                                                                                        $.post("functions/rpa_content.php", {key: pack_id}, function (data) {
                                                                                            $('#lc_content').html(data);
                                                                                        });
                                                                                    }
                                                                                    function getrpacontent_wo(a, b) {
                                                                                        var getid = a;
                                                                                        var pack_id = b;
                                                                                        $("#lc_row_id").val(getid);
                                                                                        $("#lc_pack_id").val(pack_id);
                                                                                        $.post("functions/rpa_content_wo.php", {key: pack_id}, function (data) {
                                                                                            $('#lc_content').html(data);
                                                                                        });
                                                                                    }
                                                                                    function getlc(a, b) {
                                                                                        var getid = a;
                                                                                        var pack_id = b;
                                                                                        $("#lc_row_id").val(getid);
                                                                                        $("#lc_pack_id").val(pack_id);
                                                                                        $.post("functions/getlcdatas.php", {key: pack_id}, function (data) {
                                                                                            var planned_date = JSON.parse(data).planned_date;
                                                                                            var mat_req_date = JSON.parse(data).mat_req_date;
                                                                                            var proj_name = JSON.parse(data).proj_name;
                                                                                            var packagename = JSON.parse(data).packagename;
                                                                                            var po_num = JSON.parse(data).po_num;
                                                                                            var wo_num = JSON.parse(data).wo_num;
                                                                                            $('#planned_date').html(planned_date);
                                                                                            $('#mat_req_date').html(mat_req_date);
                                                                                            $("#proj").html(proj_name);
                                                                                            $("#pack").html(packagename);
                                                                                            $("#lpo_number").val(po_num);
                                                                                            $("#lwo_number").val(wo_num);
                                                                                        });
                                                                                    }

                                                                                    function swift_proj(Proid) {
                                                                                        window.location.href = "lc_page?pid=" + Proid;
                                                                                    }

    </script>


    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
 