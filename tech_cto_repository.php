<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
$userid = $_SESSION['uid'];
if ($_SESSION['milcom'] == '1') {
    $seg = "38";
} else {
    $seg = "";
}
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
                <h5 class="font-medium text-uppercase mb-0">Tech CTO Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <select class="custom-select" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techcto_proj_filter($_SESSION['uid'], $seg);
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
                        <li class="breadcrumb-item"><a href="tech_cto">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tech CTO Repository</li>
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
                            <table id="file_export" style=" white-space: nowrap !important;     " class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;" >Project</th>
                                        <th style="padding-right: 13px !important;" >Package</th>
                                        <th style="padding-right: 13px !important;" >Current Status</th>                                      
                                        <th style="padding-right: 13px !important;" >ORG Schedule</th>                                      
                                        <th style="padding-right: 13px !important;" >Material Req</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Planned</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Expected</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Actual</th>                                      
                                        <th style="padding-right: 13px !important;" >Remarks</th>
                                        <th>View</th>   
                                        <th></th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_admin->select_techCTO_repositoryM($pid, $userid, $seg);
// $result = $cls_comm->select_techCTO_repository($pid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['cto_projid']);
                                        $packname = $cls_comm->package_name($value['cto_packid']);
                                        $sendername = $cls_comm->get_username($value['cto_senderuid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['ps_actualdate'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['planned_date'], 'Y-m-d'));
                                        $status = $cls_comm->cur_status_name($value['cto_packid']);
                                        $getid = $value['cto_id'];
                                        $current_status = $cls_comm->current_status($value['cto_packid']);
                                        ?>
                                        <tr>
                                            <td><?php echo $projname ?></td>
                                            <!-- <td>
                                                <div class="notify pull-left">
                                                    <span class="heartbit greenotify" ></span>
                                                    <span class="point greenpoint" ></span>
                                                </div><?php echo $packname ?>
                                            </td> -->
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
                                            <!--<td><span class="badge badge-pill badge-info font-medium text-white ml-1"><?php echo $status; ?></span></td>-->
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm"><?php echo $current_status; ?></span></td>

                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date; ?></td>
                                            <td><?php echo $except_date; ?></td>
                                            <td><?php echo $actual_date; ?></td>
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="OPS Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['cto_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>
                                            <td><span onclick="view_reports('<?php echo $value['cto_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;"><i class="fas fa-eye"></i> View</span></td>
                                            <td>
                                                <?php
                                                $sql = "select * from swift_expert_uploads where exp_up_packid='" . $value['cto_packid'] . "'";
                                                $projname = $cls_comm->project_name($value['cto_projid']);
                                                $packname = $cls_comm->package_name($value['cto_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                    ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['cto_projid']; ?>', '<?php echo $value['cto_packid']; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
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
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>

<script>
    function swift_proj(Proid) {
        window.location.href = "tech_cto_repository?pid=" + Proid;
    }

</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script src="code/js/technical.js" type="text/javascript"></script>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
    function view_attachments(a, b, c, d) {
        $("#proj").text(a);
        $("#pack").html(b);
        $("#projid").val(c);
        $("#packid").val(d);
        $.post("functions/filesforops.php", {key: d}, function (data) {
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