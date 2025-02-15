<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$stageid = $_POST['stageid'];
$check_status = $cls_comm->po_wo_check($pack_id);
$so_satus = $check_status['so_hw_sw'];
$po_wo_satus = $check_status['work_order'];
$proj_id = $check_status['so_proj_id'];
$pack_id = $check_status['so_pack_id'];

$today_date = date("d-M-y");
?>
<script>
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',
//        startDate: date,
        orientation: 'top',
    });
</script>
<?php if (($so_satus == 1 && $po_wo_satus == 0) || ($so_satus == 3 && $po_wo_satus == 0)) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off"  onsubmit="return confirm('Are you sure you want to submit?');">
        <div class="row" style="width:120%">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Work Order Creation</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Wo Number</span>
                            </div>
                            <input type="text" class="form-control" id="wo_number" name="wo_number" >
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Wo Value</span>
                            </div>
                            <input type="text" class="form-control" id="wo_value" name="wo_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Planned</span>
                            </div>
                            <?php
                            $results = $cls_comm->select_planned_date($proj_id, $pack_id, $stageid);
//                            echo date('d-M-y', strtotime(str_replace('/', '-', $results['ps_expdate']))); 
                            $plan_date = date('d-M-y', strtotime(str_replace('/', '-', $results['revised_planned_date'])));
                            if ($results['ps_expdate'] == "") {
                                $Pexpdate = date('d-M-y');
                            } else {
                                $Pexpdate = $results['ps_expdate'];
                            }
                            ?>
                            <input type="text" class="form-control mydatepicker" id="wo_planned" name="wo_planned" value="<?php echo $plan_date ?>" aria-describedby="basic-addon1" disabled="true">
                            <input type="hidden" class="form-control mydatepicker" id="wo_expected" name="wo_expected" value="<?php echo date('d-M-y', strtotime(str_replace('/', '-', $Pexpdate))); ?>">
                        </div>
                        <div class="input-group mb-3 none">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Expected</span>
                            </div>
                            <!--<input type="text" class="form-control mydatepicker" id="wo_expected" name="wo_expected" value="<?php echo date('d-M-y', strtotime(str_replace('/', '-', $Pexpdate))); ?>">-->
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual"   name="wo_actual" value="<?php echo $today_date; ?>" onchange="wocreatesamedate(this.value)" aria-describedby="basic-addon1">
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
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" id="wo_create" name="wo_create"><i class="fas fa-paper-plane"></i>  Submit</button>
            </div>
        </div>
    </form>
<?php } else if ($so_satus == 3 AND $po_wo_satus == 1) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off"  onsubmit="return confirm('Are you sure you want to submit?');">
        <div class="row" style="width:110%">
            <div class=" col-md-1"></div>
            <div class=" col-md-5">
             
               
                        <h4 class="card-title">WO Approval</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Planned</span>
                            </div>
                            <?php
                            $results = $cls_comm->select_planned_date($proj_id, $pack_id, $stageid);
                            $plan_date = date('d-M-y', strtotime(str_replace('/', '-', $results['revised_planned_date'])));
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
                            <input type="text" class="form-control mydatepicker" id="wo_expected1" name="wo_expected" value="<?php
                            echo date('d-M-y', strtotime(str_replace('/', '-', $Pexpdate)));
                            ;
                            ?>"  aria-describedby="basic-addon1">
                        </div>
                        <input type="hidden" class="form-control mydatepicker" id="wo_actual"   name="wo_actual" value="<?php echo $today_date; ?>" onchange="woapp1samedate(this.value)" aria-describedby="basic-addon1">

                        <div class="input-group mb-3 none">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual"   name="wo_actual" value="<?php echo $today_date; ?>" onchange="woapp1samedate(this.value)" aria-describedby="basic-addon1">

                        </div>
                   
            
            </div>
            <div class="col-md-6 ">

                <h4 class="card-title">Remarks</h4>
                <div class="form-group">
                    <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                    <textarea class="form-control" rows="4" id="wo_remarks" name="wo_remarks" required></textarea>
                </div>

            </div>
            <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
            <input type="hidden" name="proj_id" value="<?php echo $proj_id ?>">
            <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" id="wo_approve" name="wo_approve"><i class="fas fa-paper-plane"></i>  Submit</button>
        </div>
    </div>
    </form>
<?php } else if ($so_satus == 1 AND $po_wo_satus == 1) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off"  onsubmit="return confirm('Are you sure you want to submit?');">
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
                            $plan_date = date('d-M-y', strtotime(str_replace('/', '-', $results['revised_planned_date'])));
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
                            echo date('d-M-y', strtotime(str_replace('/', '-', $Pexpdate)));
                            ;
                            ?>" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="wo_actual"  name="wo_actual" value="<?php echo $today_date; ?>" onchange="woapp2samedate(this.value)" aria-describedby="basic-addon1">
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
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" name="wo_approve_only"><i class="fas fa-paper-plane"></i>  Send</button>
            </div>
        </div>
    </form>
<?php } ?>



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







