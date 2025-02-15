<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
if ($_SESSION['milcom'] == '1') {
    $segment = '38';
} else {
    $segment = $_SESSION['tech_seg'];
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
                <h5 class="font-medium text-uppercase mb-0">Tech SPOC Repository</h5>
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
                    $result = $cls_comm->techspoc_proj_filter($seg);
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
                        <li class="breadcrumb-item"><a href="tech_spoc">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tech SPOC Repository</li>
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
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>    
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Current Status</th>                                      
                                        <th>ORG Schedule</th>                                      
                                        <th>Material Req</th>                                      
                                        <th>Stage Planned</th>                                      
                                        <th>Stage Expected</th>                                      
                                        <th>Stage Actual</th>                                      
                                        <th>Remarks</th>
                                        <th>Action</th>                                   
                                        <th>Attachments</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_techspoc_repository($pid, $_SESSION['uid'], $seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['ts_projid']);
                                        $packname = $cls_comm->package_name($value['ts_packid']);
                                        $sendername = $cls_comm->get_username($value['ts_senderuid']);
                                        $schedule_date = $cls_comm->datechange($value['schedule_date']);
                                        $mat_req = $cls_comm->datechange($value['mat_req_date']);
                                        $actual_date = $cls_comm->datechange($value['ts_actual']);
                                        $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        $org_plandate = $cls_comm->datechange($value['org_plandate']);
                                        $rev_planned_date = $cls_comm->datechange($value['rev_planned_date']);
                                        $status = $cls_comm->cur_status_name($value['ts_packid']);
                                        $getid = $value['ts_id'];
                                        $name = $cls_comm->name($_SESSION['uid'], $value['ts_packid']);
                                        $current_status = $cls_comm->current_status($value['ts_packid']);
                                        ?>
                                        <tr>
                                            <td><?php echo $projname ?></td>
                                            <!-- <td><div class="notify pull-left">
                                                    <span class="heartbit greenotify" ></span>
                                                    <span class="point greenpoint" ></span>
                                            </div><?php echo $packname ?></td> -->

                                            <td>
                                                <?php if (strtotime($rev_planned_date) > strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify" ></span>
                                                        <span class="point greenpoint" ></span>
                                                    </div>

                                                <?php } elseif (strtotime($rev_planned_date) < strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($rev_planned_date) == strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint" ></span>
                                                    </div>
                                                <?php }
                                                ?>
                                                <?php echo $packname ?>
                                            </td>

                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm"><?php echo $current_status; ?></span></td>
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date; ?></td>
                                            <td><?php echo $except_date; ?></td>
                                            <td><?php echo $actual_date; ?></td>
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="SPOC Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $name['txp_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>
                                            <td><span onclick="view_reports('<?php echo $value['ts_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;"><i class="fas fa-eye"></i> View</span></td>
                                            <!-- <td><span class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-eye"></i> View</span></td> -->
                                            <td>
                                                <?php
                                                $sql = "select * from swift_expert_uploads where exp_up_packid='" . $value['ts_packid'] . "'";
                                                $projname = $cls_comm->project_name($value['ts_projid']);
                                                $packname = $cls_comm->package_name($value['ts_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                    ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['ts_projid']; ?>', '<?php echo $value['ts_packid']; ?>')" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                                <?php }
                                                ?>
                                            </td>
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
            <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1">Project - <small>Package Name </small></h4> 

                            <div class="row" id="daterow">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-dark font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                                </div> -->
            <!--                                <div class=" col-md-6" id="ps">
                                                <small>Sending Date:- <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                          
                                            </div>-->
            <!-- </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form>  
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="expected_date">Expected</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-calender"></i></span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="end_date" name="expected_date" required="" placeholder="dd/mm/yyyy">

                        </div>
                        <div class="invalid-feedback">

                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="actual_date">Actual</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-calender"></i></span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="revend_date" name="actual_date" required="" placeholder="dd/mm/yyyy">

                        </div>
                        <div class="invalid-feedback">

                        </div>
                    </div>

                </div>      
                <div class="form-group">
                    <label for="message-text" class="control-label">Enter Remarks:</label>
                    <textarea class="form-control" id="message-text1"></textarea>
                </div>
            </form> -->
            <?php
            // $msg = '';
            // for ($i = 0; $i <= 5; $i++) {
            //     $msg .= 'Date' - 'This is the remarks from CTO\n';
            // }
            //echo $msg;
            ?>                     
            <!-- </div>
            <div class="modal-footer"> -->

<!--                            <a href="javacript:void(0)"  class="btn btn btn-rounded btn-outline-success mr-2 btn-sm" data-toggle="tooltip"  data-original-title="Send to O&M"><i class="ti-check mr-1"></i>Submit</a>
            -->
<!--                            <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane"></i> Send to CTO</button>
            --> 
            <!-- <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
        </div>
    </div>
</div>
</div> -->
            <!-- /.modal -->

            <!-- sample modal content -->                     
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">
                            <input type="hidden" name="projid" id="projid">
                            <input type="hidden" name="packid" id="packid">
                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack">Package Name</small></h4> 


                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps"  >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form>  
                                <div class=" row" id="exp_uptable">


                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal" >Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

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
                                                    window.location.href = "tech_spoc_repository?pid=" + Proid;
                                                }

                                                function view_attachments(a, b, c, d) {
                                                    // alert(d);
                                                    // exit();
                                                    $("#proj").text(a);
                                                    $("#pack").html(b);
                                                    $("#projid").val(c);
                                                    $("#packid").val(d);

                                                    $.post("functions/filesforcto.php", {key: d}, function (data) {
                                                        var planned_date = JSON.parse(data).planned_date;
                                                        var mat_req_date = JSON.parse(data).mat_req_date;
                                                        var pm_packagename = JSON.parse(data).pm_packagename;
                                                        $('#planned_date').html(planned_date);
                                                        $('#mat_req_date').html(mat_req_date);
                                                        $('#exp_date').val(mat_req_date);
                                                        fetch_exp_uploaddocument_view(c, d);
                                                    });
                                                    //        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
                                                    //            $('#expr').html(data);
                                                    //        });

                                                }
</script>

<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 