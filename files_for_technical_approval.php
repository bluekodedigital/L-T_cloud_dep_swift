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
                <h5 class="font-medium text-uppercase mb-0">Technical Approval</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techexpert_proj_filter($_SESSION['uid']);
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
                        <li class="breadcrumb-item"><a href="tech_expert">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Technical Approval Work Flow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Received From</th>                                      
                                        <th>ORG Schedule</th>                                      
                                        <th>Material Req</th>                                      
                                        <th>Stage Planned</th>                                      
                                        <th>Stage Expected</th>                                      
                                        <!--<th>Stage Actual</th>-->                                      
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_technical_approval($pid, $_SESSION['uid']);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['tech_projid']);
                                        $packname = $cls_comm->package_name($value['tech_packid']);
                                        $sendername = $cls_comm->get_username($value['tech_senderuid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['ps_actualdate'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                         $rdate = $cls_comm->datechange(formatDate($value['tech_sentdate'], 'Y-m-d'));
                                           if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange(formatDate($except_date, 'Y-m-d'));
                                        } else {
                                            $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        }
                                        $getid = $value['tech_id'];
                                        ?>
                                        <tr>
                                            <td><?php echo $projname ?></td>
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">OPS-<?php echo $sendername; ?> <br>(<?php echo $rdate; ?>)</span></td>
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date ?></td>
                                            <td><?php // echo $except_date      ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>"  class="  mydatepicker" id="dasexpected_date<?php echo $value['tech_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['tech_packid'] ?>', '27')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>  
                                                    </span>
                                                </div>

                                            </td>
                                            <!--<td><?php // echo date("d-M-Y")        ?></td>-->
                                            <td><label class="badge badge-pill font-medium text-white ml-1 orange"    data-toggle="tooltip"  data-original-title="SPOC Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['tech_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>  

                            <!-- <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getexpertdata(<?php $value['txp_packid'] ?>)" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i></span></td> -->
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getexpid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['tech_packid']; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i></span></td>
                                            <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sample modal content -->                     
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal_resize" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack">Package Name</small></h4> 
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h4 id="pack"></h4> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps" >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                             <center>
                                        <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">Drawing Approval</span></small>                
                                    </center>
                            <form method="post" class="needs-validation" action="functions/technical_approval.php" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">     
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6" style=" display: none;">
                                            <label for="revend_date">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
<!--                                                <input type="text" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">

                                        <div class="col-md-6">
                                            <label for="revend_date">Actual Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled="" id="act_date" name="act_date"   required="" placeholder="mm/dd/yyyy">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="spocr" style="margin-left:0%;">

                                </div> <br>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>

                                <input type="hidden" id="tech_id" name="tech_id">

                                <div class="modal-footer">
                                    <!-- <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-danger" name="reject_package"  data-toggle="tooltip" data-placement="top" title="Send back to Tech SPOC"> <i class="fas fa-times"></i> Reject </button> -->
                                    <button type="submit" class="btn btn-outline-danger btn-rounded" id="leftbtn" name="reject">&times; Send Back to OPS</button>
                                    <button type="submit" class="btn btn-outline-primary btn-rounded" name="approve" data-toggle="tooltip" data-placement="top" title="Send to Ops"><i class="fas fa-paper-plane"></i> Approval</button>
                                </div>
                            </form>
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
<script>
                            function getexpertdata($id) {
                                $.ajax({
                                    type: "POST", //type of method
                                    url: "code/filesfortechexcp.php", //your page
                                    data: {pack_id: $id}, // passing the values
                                    success: function (res) {
                                        $('#proj').text(res[0].proj_name);
                                        // $("#proj").text(proj_name);
                                    }
                                });
                                $('#exampleModal').modal('show');
                            }
                            function getexpid(a, b, c) {
                                var getid = a;
                                var project = b;
                                var pack_id = c;
                                $("#proj").text(project);
                                $("#tech_id").val(getid);
//                                                        $("#act_date").datepicker("setDate", new Date());
//            document.getElementById("exp_date").disabled = true;
                                $.post("functions/technical_approvals.php", {key: pack_id}, function (data) {
                                    var planned_date = JSON.parse(data).planned_date;
                                    var mat_req_date = JSON.parse(data).mat_req_date;
                                    var pm_packagename = JSON.parse(data).pm_packagename;
//                                                            alert(mat_req_date);
                                    $('#planned_date').html(planned_date);
                                    $('#mat_req_date').html(mat_req_date);
                                    $("#pack").html(pm_packagename);
                                    $('#exp_date').val(mat_req_date);

                                    $("#act_date").datepicker("setDate", new Date());
                                });
                                $.post("functions/spocremarks.php", {key: pack_id}, function (data) {
                                    $('#spocr').html(data);
                                });
                            }
                            function samedate($id) {
                                $("#exp_date").datepicker("setDate", $id);
                            }
                            function swift_proj(Proid) {
                                window.location.href = "files_for_technical_approval?pid=" + Proid;
                            }
</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 