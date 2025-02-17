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
                            <table id="file_export" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Received From</th>
                                        <th>Buyer</th>
                                        <th>ORG Schedule</th>                                      
                                        <th>Material Req</th>                                      
                                        <th>Stage Planned</th>                                      
                                        <th>Stage Expected</th>                                      
                                        <th>View PO</th>                                      
                                        <th>Remarks</th>
                                        <th>Attachments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_scmspoc_repo($pid,$seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['sc_projid']);
                                        $packname = $cls_comm->package_name($value['sc_packid']);
                                        $sendername = $cls_comm->get_username($value['sc_senderuid']);
                                        $schedule_date = $cls_comm->datechange(formatDate(formatDate($value['schedule_date'], 'Y-m-d', 'Y-m-d')));
                                        $mat_req = $cls_comm->datechange(formatDate(formatDate($value['mat_req_date'], 'Y-m-d', 'Y-m-d')));
                                        $actual_date = $cls_comm->datechange(formatDate(formatDate($value['cs_actualdate'], 'Y-m-d', 'Y-m-d')));
                                        $except_date = $cls_comm->datechange(formatDate(formatDate($value['ps_expdate'], 'Y-m-d', 'Y-m-d')));
                                        $org_plandate = $cls_comm->datechange(formatDate(formatDate($value['org_plandate'], 'Y-m-d', 'Y-m-d')));
                                        $rev_planned_date = $cls_comm->datechange(formatDate(formatDate($value['rev_planned_date'], 'Y-m-d', 'Y-m-d')));
                                        $rdate = $cls_comm->datechange(formatDate(formatDate($value['cs_sentdate'], 'Y-m-d', 'Y-m-d')));
                                        $getid = $value['sc_id'];
                                        $buyer_name = $cls_report->fetch_buyername($value['sc_packid']);
                                        ?>
                                        <tr>
                                            <td><?php echo $projname ?></td>
                                            <td>
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
                                                ?>
                                                <?php echo $packname ?>
                                            </td>

                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">OPS-<?php echo $sendername; ?><br><?php echo $rdate; ?></span></td>
                                            <td><span class="badge badge-pill badge-success font-medium text-white ml-1"> <?php echo $buyer_name; ?> </span>


                                            </td>
                                            <td><?php echo $schedule_date ?></td>
                                            <td><?php echo $mat_req ?></td>
                                            <td><?php echo $planned_date ?></td>
                                            <td><?php echo $except_date ?>
                                                <!--                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                                                                    <div class="input-group-append">
                                                                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                                                                    </div>
                                                                                                    <input type="text" value="<?php echo $except_date; ?>"  class="form-control mydatepicker" id="dasexpected_date<?php echo $value['sc_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">
                                                
                                                                                                </div>
                                                                                                <div class=" saveexp" style=" float: right;">
                                                                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1" onclick="save_expected('<?php echo $value['sc_packid'] ?>', '13')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                                                                        <i class="fas fa-save"></i> Save
                                                                                                    </span>
                                                                                                </div>-->

                                            </td>


                                            <td>
                                                <?php
                                                $checkpo = $cls_comm->checkpo($value['sc_packid']);
                                                if ($checkpo == 1) {
                                                    ?>
                                                    <span class="badge badge-pill badge-primary font-medium text-white ml-1" style=" cursor: pointer;" alt="default" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" onclick="podetailviewscm('<?php echo $value['sc_packid']; ?>')" ><i class="fas fa-eye"></i></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-pill badge-primary font-medium text-white ml-1" style=" cursor: pointer;"  class="model_img img-fluid" onclick="swal('PO Not Created Yet')" ><i class="fas fa-eye"></i></span>
                                                <?php }
                                                ?>


                                            </td>
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange" data-toggle="tooltip"  data-original-title="OPS Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['sc_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label>    </td>                                    
                                            <!--<td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getspocid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['sc_packid'] ?>')" data-toggle="modal" data-target="#myModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>-->
                                            <!--<td><span class=" badge badge-info" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-send"></i></span></td>-->
                                            <td><span class="pointer" onclick="view_allattachments('<?php echo $projname ?>', '<?php echo $packname; ?>', ' <?php echo $value['sc_projid'] ?>', ' <?php echo $value['sc_packid'] ?>', '<?php echo $mat_req; ?>', '<?php echo $except_date; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" id="model_view" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content" id="podetailvie" style="width:116%;margin-left:-8%;margin-top:-2%;">

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
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
                                <div class=" col-md-6" id="ps" >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="needs-validation" action="functions/move_scm_to_ops.php"  onsubmit="return confirm('Are you sure you want to submit?');" autocomplete="off">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6" style=" display:  none;">
                                            <label for="revend_date">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <!--<input type="text" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="revend_date">Actual Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled="" id="act_date" name="act_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">
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

                                <input type="hidden" id="al_pack_id" name="al_pack_id">
                                <input type="hidden" id="scmbu_id" name="scmbu_id">
<!--                                <input type=" " id="al_act_date" name="al_act_date">
                                <input type=" " id="al_remarks" name="al_remarks">-->
                                </div>
                                <input type="hidden" id="scm_id" name="scm_id">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-danger btn-rounded" id="leftbtn" name="scmreject">&times; Sent back to OPS</button>

                                    <button type="submit" name="allocatingtobuyer"  class="btn btn-outline-success btn-rounded"  ><i class="fas fa-paper-plane"></i>  Allocate to Buyer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="myModal1" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <!-- Modal content-->
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
                                    <!-- <div class="row">
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

                            </div>
                            <input type="hidden" id="al_pack_id" name="al_pack_id">
                            <input type="hidden" id="scmbu_id" name="scmbu_id">
                            <input type="hidden" id="al_act_date" name="al_act_date">
                            <input type="hidden" id="al_remarks" name="al_remarks">
                            <div class="modal-footer">
                                <!--<button type="button" class="btn btn-outline-danger btn-rounded" id="leftbtn" data-dismiss="modal"> &times; Close</button>-->
                                <button type="submit" class="btn btn-outline-success btn-rounded">Allocate to Buyer</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
          <!-- sample modal content -->                     
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 180%; margin-left: -25%">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack1">Package Name</small></h4> 


                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="plndate"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps"  >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="expndate"></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">

                            <div  id="exp_uptable" style=" width: 60%"></div> 
                            <div  id="uptable" style=" width: 60%"></div>
                            <div  id="ops_exp_uptable" style=" width: 60%"></div>




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
<script src="code/js/ops.js" type="text/javascript"></script>
<script src="code/js/technical.js" type="text/javascript"></script>
<script>
                                                    function getspocid(a, b, c) {
                                                        var scmid = a;
                                                        var project = b;
                                                        var pack_id = c;
                                                        $("#proj").text(project);
                                                        $("#scm_id").val(scmid);
                                                        $("#scmbu_id").val(scmid);
                                                        $("#pack_id_btn").val(pack_id);
                                                        $("#al_pack_id").val(pack_id);
                                                        $("#exp_date").disabled = true;
                                                        $("#act_date").datepicker("setDate", new Date());
//        document.getElementById("exp_date").disabled = true;
                                                        $.post("functions/filesforscm_to_ops.php", {key: pack_id}, function (data) {
                                                            var planned_date = JSON.parse(data).planned_date;
                                                            var mat_req_date = JSON.parse(data).mat_req_date;
                                                            var pm_packagename = JSON.parse(data).pm_packagename;
                                                            $('#planned_date').html(planned_date);
                                                            $('#mat_req_date').html(mat_req_date);
                                                            $("#pack").html(pm_packagename);
                                                            $('#exp_date').val(mat_req_date);
                                                        });
                                                        $.post("functions/opstoscm_remarks.php", {key: pack_id}, function (data) {
                                                            $('#opsr').html(data);
                                                        });
                                                    }
                                                    function samedate($id) {
                                                        $("#exp_date").datepicker("setDate", $id);
                                                    }
                                                    function alocatepackid(a, b, c) {
                                                        var al_pack_id = a;
                                                        var expdates = b;
                                                        var remarks1 = c;
                                                        $("#al_pack_id").val(al_pack_id);
                                                        $("#al_act_date").val(expdates);
                                                        $("#al_remarks").val(remarks1);
                                                    }
                                                    function swift_proj(Proid) {
                                                        window.location.href = "scm_repository?pid=" + Proid;
                                                    }





</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>