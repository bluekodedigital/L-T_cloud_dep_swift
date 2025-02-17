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
                <h5 class="font-medium text-uppercase mb-0">Tech Expert Work Flow</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    if ($_SESSION['milcom'] == '1') {
                        $seg = '38';
                    } else {
                        $seg = '';
                    }
                    $result = $cls_comm->techexpert_proj_filter($_SESSION['uid'], $seg);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                    ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
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
                            <table id="zero_config" style=" white-space: nowrap !important;     " class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="padding-right: 13px !important;">Project</th>
                                        <th style="padding-right: 13px !important;">Package</th>
                                        <th style="padding-right: 13px !important;">Received From</th>
                                        <th style="padding-right: 13px !important;">ORG Schedule</th>
                                        <th style="padding-right: 13px !important;">Material Req</th>
                                        <th style="padding-right: 13px !important;">Stage Planned</th>
                                        <th style="padding-right: 13px !important;">Stage Expected</th>
                                        <!--<th>Stage Actual</th>-->
                                        <th style="padding-right: 13px !important;">Remarks</th>
                                        <th style="padding-right: 13px !important;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = $cls_comm->sentbackfromreviewer($pid, $_SESSION['uid'], $seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['cs_projid']);
                                        $packname = $cls_comm->package_name($value['cs_packid']);
                                        $fromname = $cls_comm->get_username($value['from_uid']);
                                        $sendername = $cls_comm->get_username($value['to_uid']);
                                        $schedule_date = $cls_comm->datechange(formatDate($value['schedule_date'], 'Y-m-d'));
                                        $mat_req = $cls_comm->datechange(formatDate($value['mat_req_date'], 'Y-m-d'));
                                        $actual_date = $cls_comm->datechange(formatDate($value['cs_actualdate'], 'Y-m-d'));
                                        $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        $org_plandate = $cls_comm->datechange(formatDate($value['org_plandate'], 'Y-m-d'));
                                        $rev_planned_date = $cls_comm->datechange(formatDate($value['rev_planned_date'], 'Y-m-d'));
                                        $rdate     = $cls_comm->datechange(formatDate($value['cs_sentdate'], 'Y-m-d'));
                                        $getid     = $value['cs_packid'];
                                        $stageid   = $value['to_stage_id'];
                                        $fstageid   = $value['from_stage_id'];
                                        $pm_stages = $value['pm_stages'];

                                        $stage_array = explode(",", $pm_stages);

                                        $key = array_search($stageid, $stage_array);
                                        $Next_stage = $stage_array[$key + 1];
                                        //$i = array_search('3', array_keys($array));
                                        // $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
                                        // echo $key = array_search('green', $stage_array); // $key = 2;
                                        // $key = array_search('red', $stage_array);   // $key = 1;
                                        //     $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
                                        //     $array1 = array(0 => '1', 1 => '2', 2 => '3', 3 => '5',4 => '6',5 => '7');
                                        //   // echo  $key = array_search('green', $array); // $key = 2;
                                        //  // print_r($array1);echo "<br>";
                                        //    $key = array_search('3', $array1);   // $key = 1;
                                        //     echo   $nkey = $key+1;
                                        //     $key2 = array_search($nkey, $array1);   // $key = 1;

                                        if ($value['ps_expdate'] == "") {
                                            $except_date = date('Y-m-d');
                                            $except_date = $cls_comm->datechange(formatDate($except_date, 'Y-m-d'));
                                        } else {
                                            $except_date = $cls_comm->datechange(formatDate($value['ps_expdate'], 'Y-m-d'));
                                        }
                                    ?>
                                        <tr>

                                            <td><?php echo $projname ?></td>
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
                                            <td>
                                                <?php if (strtotime($rev_planned_date) > strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify"></span>
                                                        <span class="point greenpoint"></span>
                                                    </div>

                                                <?php } elseif (strtotime($rev_planned_date) < strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point"></span>
                                                    </div>
                                                <?php } elseif (strtotime($rev_planned_date) == strtotime($actual_date)) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint"></span>
                                                    </div>
                                                    <?php }
                                                    ?><?php echo $packname; ?>
                                            </td>
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm"> <?php echo $fromname ?> - <?php echo $sendername ?> <br> (<?php echo $rdate; ?>)</span></td>
                                            <!-- <td><?php echo $cls_comm->datechange(formatDate($value['ts_sentdate'], 'Y-m-d')) ?></td> -->
                                            <td><?php echo $schedule_date; ?></td>
                                            <td><?php echo $mat_req; ?></td>
                                            <td><?php echo $rev_planned_date; ?></td>
                                            <!--<td><?php echo $except_date; ?></td>-->
                                            <td style=" min-width: 130px !important;">

                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo $except_date; ?>" class=" mydatepicker" id="dasexpected_date<?php echo $value['cs_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['cs_packid'] ?>', '<?php echo $stageid; ?>')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Save Expected date">
                                                        <i class="fas fa-save "></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <!--                                        <td><?php echo $actual_date ?></td>-->
                                            <td><label class="badge badge-pill  font-medium text-white ml-1 orange " data-toggle="tooltip" data-original-title="From Remarks" data-placement="bottom" style=" cursor: pointer;" onclick="swal('<?php echo $value['to_remark'] ?>');"><i class="fas fa-comment"></i> Remarks</label></td>

                                            <td><span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="getexpid('<?php echo $getid ?>', '<?php echo $projname ?>', '<?php echo $value['cs_packid'] ?>','<?php echo $stageid; ?>','<?php echo $fstageid ?>','<?php echo $value['cs_projid']; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" data-original-title="Send Packages to Tech Spoc"> <i class="fas fa-paper-plane"></i> </span></td>
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
                            <h5 id="pack"><small></small></h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <label for="message-text" class="control-label bold">Planned Date : </label> <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span>
                                </div>

                                <div class=" col-md-6" id="ps">
                                    <label for="message-text" class="control-label bold">Expected Date : </label><span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span>


                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <center>
                                <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle"></span></small>
                            </center>
                            <form id='approve_validate' method="post" class="needs-validation" novalidate action="functions/move_to_next_stage.php" autocomplete="off">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6" style="display:none;">
                                            <label for="revend_date" class="bold">Expected Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <!--                                                <input type="text" class="form-control mydatepicker"  id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">-->

                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control mydatepicker" id="exp_date" name="exp_date" required="" placeholder="mm/dd/yyyy">
                                        <div class="col-md-6">
                                            <input type="hidden" value="" name="projectid" id="projectid">
                                            <input type="hidden" value="" name="packageid" id="packageid">
                                            <label for="revend_date" class=" bold">Action Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" disabled="" id="act_date" name="act_date" onchange="samedate(this.value)" required="" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="message-text" class="control-label bold">To:</label>
                                                <select class="custom-select" name="forward" id="forward" disabled='disabled'>
                                                    <option value="">--Select Forward--</option>

                                                </select>
                                                <input type="hidden" name="forwardto" id="forwardto" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group" id="expert_uploads" style="display:none;">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="doc_name">Doc Name</label>

                                            <select class="custom-select" name="doc_name" id="doc_name" required="">
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
                                                    <option value="<?php echo $value['stDoCName'];  ?>"><?php echo $value['stDoCName'] . '-' . $value['stMajMin'];  ?></option>
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
                                            <div id="progress-wrp">
                                                <div class="progress-bar"></div>
                                                <div class="status">0%</div>
                                            </div>
                                            <div id="output">
                                                <!-- error or success results -->
                                            </div>
                                        </div>
                                    </div>
                                    <center><b>Attachments:</b></center>
                                    <div class=" row table-responsive">
                                        <table class="table1 table-bordered text-center">
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
                                <div class="row" id="opsr" style="margin-left:0%;"></div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="revend_date" class=" bold">Send Back To</label>
                                        <select class="custom-select" name="senbackstage" id="senbackstage" onchange="appendName();">
                                            <option value="">--Select Send Back--</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="message-text" class="control-label bold">Back To:</label>
                                            <input type="text" name="senbackuid" id="senbackuid" class="form-control" readonly>
                                            <input type="hidden" name="hiddenid" id="hiddenid" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="next_stage" id="next_stage">
                                <input type="hidden" name="cur_stage" id="cur_stage">
                                <!-- <input type="hidden" id="pack_id" name="pack_id"> -->

                                <div class="modal-footer">

                                    <button type="submit" value='1' class="btn waves-effect waves-light btn-rounded btn-outline-danger pull-left click" name="sent_back_to_previous" data-toggle="tooltip" data-placement="top" title="Send Back"> <i class="fas fa-times"></i> Send Back</button>
                                    <!-- <button type="submit" class="btn btn-outline-primary btn-rounded" name="approve_package" id="submitbtn"><i class="fas fa-paper-plane"></i> Send to Tech Expert </button> -->
                                    <button type="submit" value='0' class="btn btn-outline-primary btn-rounded click" name="approve_package" id="button_check" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fas fa-paper-plane"></i>Approve</button>

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
            data: {
                pack_id: $id
            }, // passing the values
            success: function(res) {
                $('#proj').text(res[0].proj_name);
                // $("#proj").text(proj_name);
            }
        });
        $('#exampleModal').modal('show');
    }


    function getexpid(a, b, c, from, to, proj) {

        var spocid = a;
        var project = b;
        var pack_id = c;
        $("#proj").text(project);
        // $("#pack_id").val(spocid);
        $('#projectid').val(proj);
        $('#packageid').val(spocid);
        $("#cur_stage").val(from);
        $("#next_stage").val(to);
        //            $("#exp_date").disabled = true;
        $("#act_date").datepicker("setDate", new Date());
        //            document.getElementById("exp_date").disabled = true;
        // $.post("functions/filesforexpert.php", {
        $.post("functions/filesfromBack.php", {
            key: pack_id,
            from: from,
            to: to,
        }, function(data) {
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            var file_attach = JSON.parse(data).file_attach;
            var remark = JSON.parse(data).remark;
            var current_stage = JSON.parse(data).current_stage;
            var next_stage = JSON.parse(data).next_stage;
            var from_uid = JSON.parse(data).from_uid;
            var users = JSON.parse(data).userlist;
            var a = JSON.stringify(users);
            var userlist = JSON.parse(users);
            var stages = JSON.parse(data).stagelist;
            var b = JSON.stringify(stages);
            var stagelist = JSON.parse(stages);

            var option = '<option value="" >---Select Forward--</option>';
            $(userlist).each(function(key, value) {

                if (from_uid == value.uid) {
                    var sel = "selected";

                    $("#forwardto").val(value.uid);
                } else {
                    var sel = '';
                    $("#forwardto").val();
                }
                option += '<option value="' + value.uid + '" ' + sel + '>' + value
                    .name + '</option>';
            });
            var option2 = '<option value="" >---Select Back To--</option>';
            $(stagelist).each(function(key, value) {
                option2 += '<option value="' + value.stage_id + '" >' + value
                    .shot_name + '</option>';
            });


            if (file_attach == 1) {
                $("#expert_uploads").show();
            } else {
                $("#expert_uploads").hide();
            }
            fetch_exp_uploaddocument_view(project, pack_id);
            $('#forward').html('');
            $('#forward').append(option);
            $('#senbackstage').html('');
            $('#senbackstage').append(option2);
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $("#pack").html(pm_packagename);
            $("#exp_date").val(mat_req_date);
            $("#senttitle").text(current_stage + '-' + next_stage);
            $('#opsr').html(remark);
        });
        // $.post("functions/opsremarks.php", {
        //     key: pack_id
        // }, function(data) {
        //     $('#opsr').html(data);
        // });
    }

    function samedate($id) {
        $("#exp_date").datepicker("setDate", $id);
    }

    function swift_proj(Proid) {
        window.location.href = "tech_expert_sentbackfromcto?pid=" + Proid;
    }

    function fetch_reviewer(c, d) {
        $.post("code/fetch_reviewer.php", {
            proj: d,
            pack: c
        }, function(data) {
            $('#fetch_reviewer').html(data);
        });
    }
</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>