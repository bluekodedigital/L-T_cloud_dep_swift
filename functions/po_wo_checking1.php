<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$stageid = $_POST['stageid'];
$check_status = $cls_comm->po_wo_check($pack_id);
$flag = $check_status['wo_flag'];
$po_wo_satus = $check_status['po_wo_status'];
$proj_id = $check_status['pw_projid'];
$pack_id = $check_status['pw_packid'];
$po_uploadcheck = $cls_comm->check_pouploaded($pack_id);
$generate_token= generate_token();
$today_date = date("d-M-y");
?>
<style>
    span#viewpob {
        margin-top: 16px;
    }
</style>
<script>
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',
        //        startDate: date,
        orientation: 'top',
    });
</script>
<?php if (($flag == 1) && ($po_wo_satus == 2 || $po_wo_satus == 3)) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

    <div class="row" style="width:120%">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card" style="margin-left: 15px;">
                    <div class="card-body">
                        <h4 class="card-title">WO Create</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Wo Number</span>
                            </div>
                            <input type="text" class="form-control" id="wo_number" name="wo_number">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Planned</span>
                            </div>
                            <?php
                            $results = $cls_comm->select_planned_date($proj_id, $pack_id, $stageid);
                            //                            echo formatDate(str_replace('/', '-', $results['ps_expdate'], 'd-M-y')); 
                            $plan_date = formatDate($results['revised_planned_date'], 'd-M-y');
                            if ($results['ps_expdate'] == "") {
                                $Pexpdate = date('d-M-y');
                            } else {
                                $Pexpdate = $results['ps_expdate'];
                            }
                            ?>
                            <input type="text" class="form-control mydatepicker" id="wo_planned" name="wo_planned" value="<?php echo $plan_date ?>" aria-describedby="basic-addon1" disabled="true">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Expected</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_expected" name="wo_expected" value="<?php echo formatDate($Pexpdate, 'd-M-y'); ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual" name="wo_actual" value="<?php echo $today_date; ?>" onchange="wocreatesamedate(this.value)" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Remarks</h4>
                        <div class="form-group">
                            <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                            <textarea class="form-control" rows="6" id="wo_remarks" name="wo_remarks" required></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" value="<?php echo $proj_id ?>">
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" name="wo_approve_only"><i class="fas fa-paper-plane"></i> Wo Creation / Approval</button>
            </div>
        </div>
    </form>
<?php } else if (($flag == 2) && $po_wo_satus == 2 and $po_wo_satus == 3) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />
    <div class="row" style="width:110%">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">WO Approval</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Planned</span>
                            </div>
                            <?php
                            $results = $cls_comm->select_planned_date($proj_id, $pack_id, $stageid);
                            $plan_date = formatDate(str_replace('/', '-', $results['revised_planned_date'], 'd-M-y'));
                            if ($results['ps_expdate'] == "") {
                                $Pexpdate = date('d-M-y');
                            } else {
                                $Pexpdate = $results['ps_expdate'];
                            }
                            ?>
                            <input type="text" class="form-control mydatepicker" id="wo_planned" name="wo_planned" value="<?php echo $plan_date ?>" aria-describedby="basic-addon1" disabled="true">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Expected</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_expected1" name="wo_expected" value="<?php
                                                                                                                                echo formatDate(str_replace('/', '-', $Pexpdate, 'd-M-y'));;
                                                                                                                                ?>" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1" style="width: 100px;">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual" name="wo_actual" value="<?php echo $today_date; ?>" onchange="woapp1samedate(this.value)" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Remarks</h4>
                        <div class="form-group">
                            <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                            <textarea class="form-control" rows="6" id="wo_remarks" name="wo_remarks" required></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" value="<?php echo $proj_id ?>">
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" name="wo_approve"><i class="fas fa-paper-plane"></i> Send</button>
            </div>
        </div>
    </form>
<?php } else if (($flag == 2) && ($po_wo_satus == 2 || $po_wo_satus == 3)) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />
    <div class="row" style="width:110%">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">WO Approval</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Planned</span>
                            </div>
                            <?php
                            $results = $cls_comm->select_planned_date($proj_id, $pack_id, $stageid);
                            $plan_date = formatDate(str_replace('/', '-', $results['revised_planned_date'], 'd-M-y'));
                            if ($results['ps_expdate'] == "") {
                                $Pexpdate = date('d-M-y');
                            } else {
                                $Pexpdate = $results['ps_expdate'];
                            }
                            ?>
                            <input type="text" class="form-control mydatepicker" id="wo_planned" name="wo_planned" value="<?php echo $plan_date ?>" aria-describedby="basic-addon1" disabled="true">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Expected</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_expected2" name="wo_expected" value="<?php
                                                                                                                                echo formatDate(str_replace('/', '-', $Pexpdate, 'd-M-y'));;
                                                                                                                                ?>" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual" name="wo_actual" value="<?php echo $today_date; ?>" onchange="woapp2samedate(this.value)" aria-describedby="basic-addon1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Remarks</h4>
                        <div class="form-group">
                            <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                            <textarea class="form-control" rows="6" id="wo_remarks" name="wo_remarks" required></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" value="<?php echo $proj_id ?>">
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" name="wo_approve_only"><i class="fas fa-paper-plane"></i> WO Approval</button>
            </div>
        </div>
    </form>
<?php }  ?>
<script>
    $("#po_planned").disabled = true;
    //$("#po_expected").disabled = true;
    //$("#po_expected1").disabled = true;
    $("#wo_planned").disabled = true;
    //$("#wo_expected").disabled = true;
    //$("#wo_expected1").disabled = true;
    //$("#wo_expected2").disabled = true;
    document.getElementById("po_planned").disabled = true;
    //document.getElementById("po_expected").disabled = true;
    //document.getElementById("po_expected1").disabled = true;
    document.getElementById("wo_planned").disabled = true;
    //document.getElementById("wo_expected").disabled = true;
    //document.getElementById("wo_expected1").disabled = true;
    //document.getElementById("wo_expected2").disabled = true;

    function pocreatesamedate($id) {
        $("#po_expected").datepicker("setDate", $id);
    }

    function poapprovalsamedate($id) {
        $("#po_expected1").datepicker("setDate", $id);
    }

    function wocreatesamedate($id) {
        $("#wo_expected").datepicker("setDate", $id);
    }

    function woapp1samedate($id) {
        $("#wo_expected1").datepicker("setDate", $id);
    }

    function woapp2samedate($id) {
        $("#wo_expected2").datepicker("setDate", $id);
    }
</script>