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
if($_SESSION['milcom']=='1')
{
   $seg='38'; 
}else
{
  $seg="";    
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
                <h5 class="font-medium text-uppercase mb-0">SCM WorkFlow</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->scm_proj_filter($_SESSION['uid'],$seg);
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
                        <li class="breadcrumb-item"><a href="scm_dash">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SCM Work Flow</li>
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
    <div class="page-content container-fluid" id="mycontainer">
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
<!--                                        <th>Stage Actual</th>                                      -->
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_frombuyer($pid,$seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['bu_projid']);
                                        $packname = $cls_comm->package_name($value['bu_packid']);
                                        $sendername = $cls_comm->get_username($value['sender_id']);
                                        $schedule_date = $cls_comm->datechange($value['schedule_date']);
                                        $mat_req = $cls_comm->datechange($value['mat_req_date']);
                                        $planned_date = $cls_comm->datechange($value['planned_date']);
                                        $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        $actual_date = $cls_comm->datechange($value['ps_actualdate']);
                                        $rdate = $cls_comm->datechange($value['bu_sentdate']);
                                        $getid = $value['bu_id'];
                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange($except_date);
                                        } else {
                                            $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        }
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">SCM-<?php echo $sendername; ?><br>(<?php echo $rdate; ?>)</span></td>
                                            <td><?php echo $schedule_date ?></td>
                                            <td><?php echo $mat_req ?></td>
                                            <td><?php echo $planned_date ?></td>
                                            <td><?php // echo $except_date               ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['bu_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['bu_packid'] ?>', '13')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>

                                            </td>
                                            <!--<td><?php // echo $actual_date               ?></td>-->
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="OPS Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['sb_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label>    </td>                                    
                                            <!--<td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="alocatepackid(<?php echo $value['bu_id'] ?>)" onclick="getspocid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['sc_packid'] ?>')"   data-toggle="modal" data-target="#myModal1" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>-->
                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1"  onclick="getspocid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['bu_packid'] ?>')"   data-toggle="modal" data-target="#myModal1" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>


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
            <!-- Modal -->
            <div class="modal fade" id="myModal1" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">
                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack">Package Name</small></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps">
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                              <center>
                                <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">SCM Approval -(sent back from buyer) </span></small>                
                            </center>
                            <form method="post" class="needs-validation" id="form" action="functions/move_scm_to_ops.php"  onsubmit="return confirm('Are you sure you want to submit?');"   autocomplete="off">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6"  style=" display: none;">
                                            <label for="revend_date">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <!--<input type="text" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="revend_date">Action Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled=""   id="actt_date" name="actt_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">

                                                <input type="hidden"   id="act_date" name="act_date" value="<?php echo date('d-M-Y') ?>" required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">

                                <div class="form-group">
                                    <label for="message-text" class="control-label">Buyer:</label>
                                    <select class="custom-select" name="buyer_id" id="buyer_id" required>
                                        <option value="">--Select Buyer--</option>
                                        <?php
                                        $result = $cls_user->select_buyer();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['uid'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row" id="opsr" style="margin-left:0%;">

                                </div> <br>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>

                                <input type="hidden" id="row_id" name="row_id">

                                <input type="hidden" id="spoc_id" name="scm_id">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-danger btn-rounded" id="leftbtn" name="scmbuyerreject">&times; Sent Back to OPS</button>
                                    <button type="submit" name="buyer_realocate" class="btn btn-outline-success btn-rounded">Allocate to Buyer</button>

<!--<button type="button" id="pack_id_btn" class="btn btn-outline-success btn-rounded" onclick="alocatepackid(this.value, document.getElementById('act_date').value, document.getElementById('remarks').value)" data-toggle="modal" data-target="#myModal11"><i class="fas fa-paper-plane"></i>  Allocate to Buyer</button>-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          
      
            
            <div class="modal fade" id="myModal11" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">

                    <div class="modal-content" style="width:120%;">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Allocated to Buyer</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="needs-validation" action="functions/move_scm_to_buyer.php" autocomplete="off">
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Buyer:</label>
                                    <select class="custom-select" name="buyer_id" id="buyer_id" required>
                                        <option value="">--Select Buyer--</option>
                                        <?php
                                        $result = $cls_user->select_buyer();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['uid'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                                <!--                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="proj_name">ACE Value</label>
                                                                            <input type="text" class="form-control" id="ace_value"  name="ace_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Enter ACE Value" required>
                                                                            <div class="invalid-feedback">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="proj_name">Sales Value</label>
                                                                            <input type="text" class="form-control" id="sales_value"  name="sales_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Enter Sales Value" required>
                                                                            <div class="invalid-feedback">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>

                        </div>
<!--                        <input type="hidden" id="row_id" name="row_id">-->
                        <div class="modal-footer">
                            <!--<button type="button" class="btn btn-outline-danger btn-rounded" id="leftbtn" data-dismiss="modal"> &times; Close</button>-->
                            <button type="submit" name="buyer_realocate" class="btn btn-outline-success btn-rounded">Allocate to Buyer</button>
                        </div>
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
                    function alocatepackid(a) {
//                                    var row_id = a;
//                                    $("#row_id").val(row_id);
                    }
                    function swift_proj(Proid) {
                        window.location.href = "files_from_buyer?pid=" + Proid;
                    }
                    function getspocid(a, b, c) {

                        var scmid = a;
                        var project = b;
                        var pack_id = c;
//                                    alert(c);
                        $("#proj").text(project);
                        $("#spoc_id").val(scmid);
                        $("#row_id").val(scmid);
                        $("#scmbu_id").val(scmid);
                        $("#pack_id_btn").val(pack_id);
                        $("#exp_date").disabled = true;
//                                    $("#act_date").datepicker("setDate", new Date());
//        document.getElementById("exp_date").disabled = true;
                        $.post("functions/filesforscm_to_ops.php", {key: pack_id}, function (data) {
                            //alert(data);
                            var planned_date = JSON.parse(data).planned_date;
                            var mat_req_date = JSON.parse(data).mat_req_date;
                            var pm_packagename = JSON.parse(data).pm_packagename;
                            $('#planned_date').html(planned_date);
                            $('#mat_req_date').html(mat_req_date);
                            $("#pack").html(pm_packagename);
                            $('#exp_date').val(mat_req_date);
                            $("#actt_date").datepicker("setDate", new Date());

                        });
//                                    $.post("functions/opstoscm_remarks.php", {key: pack_id}, function (data) {
//                                        $('#opsr').html(data);
//                                    });
                    }
</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>