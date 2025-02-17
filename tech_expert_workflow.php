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
<style>
    .modal_resize {
    width: 180% !important;
    margin-left: -31% !important;
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
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Tech Expert Work Flow</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if($_SESSION['milcom']=='1')
                    {
                    $seg="38";
                    }else
                    {
                     $seg="";  
                    }
                    $result = $cls_comm->techexpert_proj_filter($_SESSION['uid'],$seg);
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
                        <li class="breadcrumb-item active" aria-current="page">Tech Expert Work Flow</li>
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
                            <table id="zero_config" style=" white-space: nowrap !important;" class="table table-bordered">
                                <thead>
                                    <tr>            
                                        <th style="padding-right: 13px !important;" >Project</th>
                                        <th style="padding-right: 13px !important;" >Package</th>
                                        <th style="padding-right: 13px !important;" >Received From</th>                                      
                                        <th style="padding-right: 13px !important;" >ORG Schedule</th>                                      
                                        <th style="padding-right: 13px !important;" >Material Req</th>                                      
                                        <th style="padding-right: 13px !important;"   >Stage Planned</th>                                      
                                        <th style="padding-right: 13px !important;" >Stage Expected</th>                                      
                                        <!--<th>Stage Actual</th>-->                                      
                                        <th style="padding-right: 13px !important;" >Remarks</th>
                                        <th style="padding-right: 13px !important;" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_techexpert_workflow($pid, $_SESSION['uid']);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['txp_projid']);
                                        $packname = $cls_comm->package_name($value['txp_packid']);
                                        $sendername = $cls_comm->get_username($value['txp_senderuid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['txp_actual'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                        $sentdte = $cls_comm->datechange(formatDate($value['txp_sentdate'], 'Y-m-d'));
                                        $getid = $value['txp_id'];

                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange(formatDate($except_date, 'Y-m-d'));
                                        } else {
                                            $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        }
                                        ?>
                                        <tr>
                                            <td  class="pkwidth"><?php echo $projname ?></td>
                                            <?php
//                                            if (strtotime($actual_date) > strtotime($planned_date)) {
//                                                $alert = "";
//                                                $point = "";
//                                            } elseif (strtotime($actual_date) < strtotime($planned_date)) {
//                                                $alert = "greenotify";
//                                                $point = "greenpoint";
//                                            } else {
//                                                $alert = "bluenotify";
//                                                $point = "bluepoint";
//                                            }
                                            ?>
                                            <td class="pkwidth">
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">ENG.-<?php echo $sendername ?> <br> (<?php echo $sentdte; ?>)</span></td>
                                            <td><?php echo $schedule_date ?></td>
                                            <td><?php echo $mat_req ?></td>
                                            <td><?php echo $rev_planned_date ?></td>
                                            <td style=" min-width: 130px !important;">
                                                <?php // echo $except_date  ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['txp_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['txp_packid'] ?>', '5')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>



                                            </td>
                                            <!--<td><?php echo $actual_date ?></td>-->
                                            <td><label class="badge badge-pill font-medium text-white ml-1 orange"    data-toggle="tooltip"  data-placement="bottom" data-original-title="SPOC Remarks"  onclick="swal('<?php echo $value['txp_remarks']; ?>');"><i class="fas fa-comment"></i> Remarks</label></td>  

                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getexpid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['txp_packid']; ?>', '<?php echo $value['txp_projid']; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i></span></td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sample modal content -->                     
            <div class="modal fade   " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal_resize" style=" width: 120%;">
                        <div class="modal-header " style="padding-bottom: 3%;">

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
                                <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">Tech. Expert to CTO for approval</span></small>                
                            </center>

                            <form method="post" class="needs-validation" action="functions/move_expert_to_cto.php" autocomplete="off"  onsubmit="return confirm('Once Technical Documents uploded and moved to Ops & you can not add further Docs until sentback from Operations. Are you sure you want to submit?');">     
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6" style="display:none;">
                                            <label for="revend_date">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <!--<input type="text" class="form-control mydatepicker"  id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control mydatepicker"  id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">
<!--                                        <input type="hidden" value="" name="planneddate" id="planneddate">
                                        <input type="hidden" value="" name="senderid" id="senderid">-->
                                        <input type="hidden" value="" name="projectid" id="projectid">
                                        <input type="hidden" value="" name="packageid" id="packageid">
                                        <div class="col-md-6">
                                            <label for="revend_date">Action Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled="" id="act_date" name="act_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="spocr" style="margin-left:0%;">

                                </div> <br>

                                <div class="form-group" id="expert_uploads">
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
                                                <?php
                                                $result = $cls_user->swift_techDocMst();
                                                $res = json_decode($result, true);
                                                foreach ($res as $key => $value) {
                                                    ?>
                                                 <option value="<?php echo $value['stDoCName'];  ?>"><?php echo $value['stDoCName'].'-'.$value['stMajMin'];  ?></option>
                                                <?php } ?>

                                            </select>

<!--                                            <input type="text" class="form-control" id="doc_name" name="doc_name"    placeholder="Enter Document Name">-->


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
                                                <button class="btn btn-success expert_filesup1" type="button" id="expert_filesup" onclick="expert_filesuplod()">Upload</button>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-row">
                                        <div class="col-md-3 mb-6">

                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <div id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                                            <div id="output"> <!-- error or success results --> </div>
                                        </div>
                                    </div>
                                    <center><b>Tech Expert Attachments:</b></center>
                                    <div class=" row table-responsive">
                                        <table  class="table1 table-bordered text-center" >
                                            <thead>
                                            <th>SI.No</th>
                                            <th>Doc Name</th>
                                            <th>File Name</th>
                                            <th>Action</th>
                                            </thead>
                                            <tbody id="exp_uptable">
                                                <tr>
                                                    <td colspan="4" class=" text-center"> No Data Available</td>

                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class=" row table-responsive" id="ops_exp_uptable">


                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-6" id="fetch_reviewer">
                                        <label for="doc_name">Select Reviewer</label>

                                        <select class="custom-select" name="reviewer" id="reviewer"  required=""> </select>

                                    </div>

                                </div><br>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>
                                <input type="hidden" id="exp_id" name="exp_id">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-danger pull-left" name="sent_back_to_spoc" id="sent_back_to_spoc"  data-toggle="tooltip" data-placement="top" title="Send back to Tech SPOC"> <i class="fas fa-times"></i> Send back to SPOC </button> 
                                    <!--<button type="submit" class="btn btn-outline-primary btn-rounded" name="approve_package" data-toggle="tooltip" data-placement="top" title="Send to Tech CTO"><i class="fas fa-paper-plane"></i> Send to CTO</button>-->
                                    <button type="submit" class="btn btn-outline-primary btn-rounded" name="sendtoreviewer" data-toggle="tooltip" data-placement="top" title="Send to Tech Reviewer"><i class="fas fa-paper-plane"></i> Send to Reviewer</button>
                                </div>
                            </form>
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
                                                    function getexpid(a, b, c, d) {
                                                        var exp_id = a;
                                                        var project = b;
                                                        var pack_id = c;
//                                                        alert(d);
                                                        $('#projectid').val(d);
                                                        $('#packageid').val(c);
                                                        $("#proj").text(project);
                                                        $("#exp_id").val(exp_id);
                                                        $("#act_date").datepicker("setDate", new Date());
//                                                        document.getElementById("exp_date").disabled = true;
                                                        $.post("functions/filesforcto.php", {key: pack_id}, function (data) {
                                                            var planned_date = JSON.parse(data).planned_date;
                                                            var mat_req_date = JSON.parse(data).mat_req_date;
                                                            var pm_packagename = JSON.parse(data).pm_packagename;
                                                            $('#planned_date').html(planned_date);
                                                            $('#mat_req_date').html(mat_req_date);
                                                            $("#pack").html(pm_packagename);
                                                            $("#exp_date").val(mat_req_date);
                                                            fetch_exp_uploaddocument(d, c);
                                                            fetch_ops_exp_uploaddocument(d, c);
                                                            fetch_reviewer(c, d);
                                                        });
                                                        $.post("functions/spocremarks.php", {key: pack_id}, function (data) {
                                                            $('#spocr').html(data);
                                                        });
                                                    }
                                                    function samedate($id) {
                                                        $("#exp_date").datepicker("setDate", $id);
                                                    }
                                                    function swift_proj(Proid) {
                                                        window.location.href = "tech_expert_workflow?pid=" + Proid;
                                                    }
                                                    function fetch_reviewer(c, d) {
                                                        $.post("code/fetch_reviewer.php", {proj: d, pack: c}, function (data) {
                                                            $('#fetch_reviewer').html(data);
                                                        });
                                                    }
    </script>


    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
 