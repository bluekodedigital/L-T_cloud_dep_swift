<?php
include 'config/inc.php';
if (isset($_GET['id'])) {
    $eid = $_GET['id'];
} else {
    $eid = "";
}
if (isset($_GET['del'])) {
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
$generate_token= generate_token();
?>
<style>
    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }

    button {
        margin-top: 5px;
        background-color: #eee;
        border: 2px solid #00F;
        color: #17bb1c;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer
    }
</style>
<link rel="stylesheet" type="text/css" href="assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Stage Master</h5>
            </div>
            <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stage Master</li>
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

        <div class="row" id="stage_create" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" method="post" action="functions/conhead_form.php">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

                        <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="stage_new">Stage name</label>
                                    <input type="text" class="form-control" id="stage_new" name="stage_new" placeholder="Stage Name" required>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="short_new">Short Name</label>
                                    <input type="text" class="form-control" id="short_new" name="short_new" placeholder="Short Name" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="weightage_new">Weightage</label>
                                    <input type="text" class="form-control" id="weightage_new" name="weightage_new" placeholder="Weightage" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="user_type">Role / User Type</label>
                                    <select class="custom-select" name="user_type" id="user_type" required="">
                                        <option value="">--Select User Type --</option>
                                        <?php
                                        $result2 = $cls_comm->select_AllUsertype();
                                        $res2 = json_decode($result2, true);
                                        foreach ($res2 as $key => $value2) {
                                        ?>
                                            <option value="<?php echo $value2['id'] ?>"><?php echo $value2['type_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-2 mb-2">
                                    <label for="Received">Received Back</label>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <!-- <div class="col-md-2 mb-2">
                                    <?php $result2 = $cls_comm->select_AllUsertype();
                                    $res2 = json_decode($result2, true);
                                    foreach ($res2 as $key => $value2) { ?>
                                        <input type="checkbox" id="send_usertype" name="send_usertype[]" value="<?php echo $value2['id'] ?>"> <?php echo $value2['type_name'] ?> </br>
                                    <?php } ?>
                                </div> -->
                                <div class="col-md-2 mb-2">
                                    <?php $result2 = $cls_comm->select_stageone();
                                    $res2 = json_decode($result2, true);

                                    foreach ($res2 as $key => $value2) {
                                        $key + 1;  ?>
                                        <input type="checkbox" name="send_usertype[]" value="<?php echo $value2['stage_id'] ?>"> <?php echo $value2['shot_name'] ?> </br>
                                    <?php } ?>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <?php $result2 = $cls_comm->select_stagetwo();
                                    $res2 = json_decode($result2, true);

                                    foreach ($res2 as $key => $value2) {
                                        $key + 10 + 1;;  ?>
                                        <input type="checkbox"  name="send_usertype[]" value="<?php echo $value2['stage_id'] ?>"> <?php echo $value2['shot_name'] ?> </br>
                                    <?php } ?>
                                </div>
                                <div class="col-md-1 mb-2">
                                    <label for="Attachments">Attachments</label>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="checkbox" id="attach_flag" name="attach_flag"> Yes </br>
                                    <!-- <input type="checkbox" id="send_flag" name="send_flag"> LOI </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> PR (EMR Creation) </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> PO Creation </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> MDCC </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> Material Received at Site</br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> Material Receipt Note</br>
                                    <br> -->

                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit" name="stage_create">Submit</button>
                            <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelstage()" name="cancel_form">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="stage_edit" style="display: none;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" method="post" action="functions/conhead_form.php" autocomplete="off">
                        <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="stage_name">Stage name</label>
                                    <input type="text" class="form-control" id="stage_name" name="stage_name" placeholder="Stage Name">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="stage_flag">Short Name</label>
                                    <input type="text" class="form-control" id="short_name" name="short_name" placeholder="Short Name" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="weightage">Weightage</label>
                                    <input type="text" class="form-control" id="weightage" name="weightage" placeholder="Weightage" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="segment">User Type</label>
                                    <select class="custom-select" name="user_type_edit" id="user_type_edit" required="">
                                        <option value="">--Select User Type --</option>
                                        <?php
                                        $result2 = $cls_comm->select_AllUsertype();
                                        $res2 = json_decode($result2, true);
                                        foreach ($res2 as $key => $value2) {
                                        ?>
                                            <option value="<?php echo $value2['id'] ?>"><?php echo $value2['type_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-2 mb-2">
                                    <label for="Received">Received Back</label>
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <?php $result2 = $cls_comm->select_stageone();
                                    $res2 = json_decode($result2, true);

                                    foreach ($res2 as $key => $value2) {
                                        $key + 1;  ?>
                                        <input type="checkbox" class = 'checkedit' id="send_usertype_edit-<?php echo $value2['stage_id'] ?>" name="send_usertype_edit[]" value="<?php echo $value2['stage_id'] ?>"> <?php echo $value2['shot_name'] ?> </br>
                                    <?php } ?>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <?php $result2 = $cls_comm->select_stagetwo();
                                    $res2 = json_decode($result2, true);

                                    foreach ($res2 as $key => $value2) {
                                        $key + 10 + 1;;  ?>
                                        <input type="checkbox" class = 'checkedit' id="send_usertype_edit-<?php echo $value2['stage_id'] ?>" name="send_usertype_edit[]" value="<?php echo $value2['stage_id'] ?>"> <?php echo $value2['shot_name'] ?> </br>
                                    <?php } ?>
                                </div>

                                <div class="col-md-1 mb-2">
                                    <label for="Attachments">Attachments</label>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="checkbox" id="attach_flag_edit" name="attach_flag_edit"> Yes </br>
                                    <!-- <input type="checkbox" id="send_flag" name="send_flag"> LOI </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> PR (EMR Creation) </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> PO Creation </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> MDCC </br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> Material Received at Site</br>
                                    <input type="checkbox" id="send_flag" name="send_flag"> Material Receipt Note</br>
                                    <br> -->

                                </div>
                            </div>
                            <input type="hidden" name="stage_id" id="stage_id">
                            <button class="btn btn-primary" type="submit" name="stage_update">Update</button>
                            <!-- <button class="btn btn-warning" type="reset" name="reset">Clear</button> -->
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="edit_close()" name="cancel_form">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <h4 class="card-title">Stage Master</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button" onclick="create_newproj();"><i class="icon-plus"></i> &nbsp;Create New</button></div>

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped border">
                                <thead>
                                    <tr>
                                        <th>Stage Id</th>
                                        <th>Stage Name</th>
                                        <th>Short Name</th>
                                        <th>Weightage</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_table('swift_stage_master');
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $stage_id = $value['stage_id'];
                                        $stage_name = $value['stage_name'];
                                        $weightage = $value['weightage'];
                                        $shot_name = $value['shot_name'];
                                        $usertype = $value['usertype'];
                                        $fileflag = $value['file_attach'];
                                        $sendback = $value['sendback'];
                                    ?>
                                        <tr>
                                            <td><?php echo $value['stage_id'] ?></td>
                                            <td><?php echo $value['stage_name'] ?></td>
                                            <td>
                                                <?php
                                                if ($value['shot_name'] != "") {
                                                    echo $value['shot_name'];
                                                } else {
                                                    echo "-";
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $value['weightage'] ?></td>
                                            <td>
                                                <span class="badge badge-primary" onclick="edit_shortname('<?php echo $stage_id; ?>','<?php echo $stage_name; ?>','<?php echo $shot_name; ?>','<?php echo $usertype; ?>','<?php echo $weightage; ?>','<?php echo $fileflag; ?>','<?php echo $sendback; ?>')" style="cursor:pointer"> <i class="icon-pencil"></i> Edit</span>
                                            </td>
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
    <?php include_once('layout/foot_banner.php'); ?>
</div>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');

?>
<script>
    function edit_shortname(stage_id, stage_name, short_name, usertype, weightage, fileflag, sendback) {
        $('#stage_create').hide();
        $('#stage_edit').show();

        $('#stage_id').val(stage_id);
        $('#stage_name').val(stage_name);
        $('#short_name').val(short_name);
        $('#user_type_edit').val(usertype);
        $('#weightage').val(weightage);
      
        if (fileflag == 1) {
            $("#attach_flag_edit").prop("checked", true);
        } else {
            $("#attach_flag_edit").prop("checked", false);
        }
        var myStr = sendback;
        var strArray = myStr.split(",");
        $(".checkedit").prop("checked", false);
        for (var i = 0; i < strArray.length; i++) {
            document.getElementById("send_usertype_edit-" + strArray[i]).checked = true;
        }
    }

    function edit_close() {
        $('#stage_edit').hide();
    }

    function create_newproj() {
        $('#stage_create').show();
        $('#stage_edit').hide();
    }

    function cancelproj() {
        $('#stage_create').hide();
    }

    function proj_editclose() {
        $('#project_edit').hide();
    }

    function add(a, b) {
        // var sum = parseInt(a) + parseInt(b);
        // alert(sum);
        $.ajax({
            type: "POST", //type of method
            url: "functions/stage_edit.php", //your page
            data: {
                id: a,
                value: b
            }, // passing the values
            success: function(res) {
                //    alert(res);s
            }
        });
    }
</script>

<script src="assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<script>
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
</script>