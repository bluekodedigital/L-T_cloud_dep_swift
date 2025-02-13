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
                <h5 class="font-medium text-uppercase mb-0">Tech Expert Repository</h5>
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
                        <li class="breadcrumb-item active" aria-current="page">Tech Expert Repository</li>
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
                            <table id="file_export" class="table table-bordered">
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
                                        <th>View</th>
                                        <th>Attachments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_techexpert_repository($pid, $_SESSION['uid']);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['txp_projid']);
                                        $packname = $cls_comm->package_name($value['txp_packid']);
                                        $sendername = $cls_comm->get_username($value['txp_senderuid']);
                                        $schedule_date = $cls_comm->datechange($value['schedule_date']);
                                        $mat_req = $cls_comm->datechange($value['mat_req_date']);
                                        $actual_date = $cls_comm->datechange($value['txp_actual']);
                                        $except_date = $cls_comm->datechange($value['ps_expdate']);
                                        $org_plandate = $cls_comm->datechange($value['org_plandate']);
                                        $rev_planned_date = $cls_comm->datechange($value['rev_planned_date']);
                                        $status = $cls_comm->cur_status_name($value['txp_packid']);
                                        $getid = $value['txp_id'];
                                              $current_status=$cls_comm->current_status($value['txp_packid']);
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm"><?php echo $current_status; ?></span></td>
                                            <td><?php echo $schedule_date ?></td>
                                            <td><?php echo $mat_req ?></td>
                                            <td><?php echo $rev_planned_date ?></td>
                                            <td><?php echo $except_date ?></td>
                                            <td><?php echo $actual_date ?></td>
                                            <td><label class="badge badge-pill font-medium text-white ml-1 orange"    data-toggle="tooltip"  data-original-title="SPOC Remarks" style=" cursor: pointer;" 
                                                       onclick="swal('<?php echo $value['txp_remarks'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>  

                                            <td><span onclick="view_reports('<?php echo $value['txp_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;"><i class="fas fa-eye"></i> View</span></td>
                                            <td>
                                                <?php

                                                $sql = "select * from swift_expert_uploads where exp_up_packid='".$value['txp_packid']."'";
                                                $projname = $cls_comm->project_name($value['txp_projid']);
                                                $packname = $cls_comm->package_name($value['txp_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                    ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['txp_projid']; ?>', '<?php echo $value['txp_packid']; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                                <?php }else{
                                                    echo $value['txp_packid'];
                                                }
                                                ?>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

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
                                        <input type="hidden" value="" name="projectid" id="projectid">
                                        <input type="hidden" value="" name="packageid" id="packageid">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="doc_name">Doc Name</label>

                                            <select class="custom-select" name="doc_name" id="doc_name"  required="">
                                                <option value="Compliances">Compliances</option>
                                                <option value="Sol Document">Sol Document</option>
                                                <option value="Cross References">Cross References</option>
                                                <option value="BOM">BOM</option>
                                                <option value="BOQ">BOQ</option>
                                                <option value="Data sheet">Data sheet</option>
                                                <option value="Others">Others</option>
                                            </select>
                                                    <!-- <input type="text" class="form-control" id="doc_name" name="doc_name"    placeholder="Enter Document Name">-->
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="proj_location">Upload File</label>
                                            <div class="input-group mb-3">

                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label " for="inputGroupFile01">Choose file</label>
                                                </div>
                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="input-group-append">
                                                <button class="btn btn-success expert_filesup1" type="button" id="expert_filesup" onclick="expert_filesuplod('expert')" style="margin-top: 28px !important;">Upload</button>
                                            </div>
                                        </div>
                                    </div> 

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
        var exp_id = a;
        var project = b;
        var pack_id = c;
        $("#proj").text(project);
        $("#exp_id").val(exp_id);
        $("#act_date").datepicker("setDate", new Date());
        document.getElementById("exp_date").disabled = true;
        $.post("functions/filesforcto.php", {key: pack_id}, function (data) {
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $("#pack").html(pm_packagename);
        });
        $.post("functions/spocremarks.php", {key: pack_id}, function (data) {
            $('#spocr').html(data);
        });
    }
    function samedate($id) {
        $("#exp_date").datepicker("setDate", $id);
    }
    function swift_proj(Proid) {
        window.location.href = "tech_expert_repository?pid=" + Proid;
    }
</script>
<script src="code/js/technical.js" type="text/javascript"></script>




<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
    function view_attachments(a, b, c, d) {
        $("#proj").text(a);
        $("#pack").html(b);
        $("#projectid").val(c);
        $("#packageid").val(d);
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