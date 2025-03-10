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
// $generate_token= generate_token();
$userid = $_SESSION['uid'];
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
                <h5 class="font-medium text-uppercase mb-0">Tech Reviewer Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techcto_proj_filter($_SESSION['uid']);
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
                        <li class="breadcrumb-item active" aria-current="page">Tech Reviewer Repository</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" style=" white-space: nowrap !important;     " class="table table-striped border">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;" >Project</th>
                                        <th style="padding-right: 13px !important;" >Package</th>
                                        <th style="padding-right: 13px !important;" >Received From</th>
                                        <th style="padding-right: 13px !important;" >ORG Schedule</th>                                      
                                        <th style="padding-right: 13px !important;" >Material Req</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Planned</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Expected</th>                                      
                                        <!--<th>Stage Actual</th>-->                                      
                                        <th style="padding-right: 13px !important;" >Remarks</th>
                                        <th style="padding-right: 13px !important;" >View</th>
                                        <th style="padding-right: 13px !important;" ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  

                                    $result = $cls_admin->select_techReviewer_repository($pid,$userid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                      
                                        $projname = $cls_comm->project_name($value['techRev_projid']);
                                        $packname = $cls_comm->package_name($value['techRev_packid']);
                                        $sendername = $cls_comm->get_username($value['techRev_senderuid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['ps_actualdate'], 'Y-m-d'));
                                        $planned_date = $cls_comm->datechange(formatDate($value['planned_date'], 'Y-m-d'));
                                        $expedted = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $sentdte = $cls_comm->datechange(formatDate($value['techRev_sentdate'], 'Y-m-d'));
                                        $getid = $value['techRev_id'];
                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange(formatDate($except_date, 'Y-m-d'));
                                        } else {
                                            $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        }
                                        ?>
                                        <tr>
                                            <td class="pkwidth"><?php echo $projname ?></td>
                                            <?php
//                                            if ( strtotime($actual_date) >  strtotime($planned_date)) {
//                                                $alert = "";
//                                                $point = "";
//                                            } elseif ( strtotime($actual_date) <  strtotime($planned_date)) {
//                                                $alert = "greenotify";
//                                                $point = "greenpoint";
//                                            } else {
//                                                $alert = "bluenotify";
//                                                $point = "bluepoint";
//                                            }
                                            ?>
                                            <td class="pkwidth">
                                                <?php if (strtotime($planned_date) > strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify" ></span>
                                                        <span class="point greenpoint" ></span>
                                                    </div>

                                                <?php } elseif (strtotime($planned_date) < strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($planned_date) == strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint" ></span>
                                                    </div>
                                                <?php }
                                                ?><?php echo $packname; ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">ENG.<?php echo $sendername; ?> <br> (<?php echo $sentdte; ?>)</span></td>
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $planned_date; ?></td>
                                            <td style=" min-width: 130px !important;" ><?php // echo $expedted;        ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $expedted; ?>"  class=" mydatepicker" id="dasexpected_date<?php echo $value['techRev_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['techRev_packid'] ?>', '5')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>


                                            </td>
                                            <!--<td><?php // echo $actual_date       ?></td>-->
                                            <td><label class="badge badge-pill font-medium text-white ml-1 orange"     style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['techRev_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>  
                                                <?php
                                                $projname = $cls_comm->project_name($value['techRev_projid']);
                                                $packname = $cls_comm->package_name($value['techRev_packid']);
                                                ?>
                                            <td><span onclick="view_reports('<?php echo $value['techRev_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;"><i class="fas fa-eye"></i> View</span></td>
                                            <td>
                                                <?php
                                                $sql = "select * from swift_expert_uploads where exp_up_packid='" . $value['techRev_packid'] . "'";
                                                $projname = $cls_comm->project_name($value['techRev_projid']);
                                                $packname = $cls_comm->package_name($value['techRev_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                    ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['techRev_projid']; ?>', '<?php echo $value['techRev_packid']; ?>')" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                                <?php }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            
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
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/technical.js" type="text/javascript"></script>
<script src="code/js/docsetting.js" type="text/javascript"></script>
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
<script>
                                                    function getctoid(a, b, c, d) {
                                                        var project = a;
                                                        var pack_id = b;
                                                        var cto_id = c;
                                                        $("#proj").text(project);
                                                        $("#cto_id").val(cto_id);
                                                        $("#exp_date").datepicker("setDate", new Date());
                                                        $("#act_date").datepicker("setDate", new Date());
//            document.getElementById("exp_date").disabled = true;
                                                        $.post("functions/filesforops.php", {key: pack_id}, function (data) {
                                                            var planned_date = JSON.parse(data).planned_date;
                                                            var mat_req_date = JSON.parse(data).mat_req_date;
                                                            var pm_packagename = JSON.parse(data).pm_packagename;
                                                            $('#planned_date').html(planned_date);
                                                            $('#mat_req_date').html(mat_req_date);
                                                            $("#pack").html(pm_packagename);
                                                            $('#exp_date').val(mat_req_date);
                                                            fetch_exp_uploaddocument_view(d, b);
                                                        });
                                                        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
                                                            $('#expr').html(data);
                                                        });

                                                    }
                                                    function samedate($id) {
                                                        $("#exp_date").datepicker("setDate", $id);
                                                    }
                                                    function swift_proj(Proid) {
                                                        window.location.href = "tech_cto_workflow?pid=" + Proid;
                                                    }
                                                    
</script>

<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 