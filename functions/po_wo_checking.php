<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$stageid = $_POST['stageid'];
$check_status = $cls_comm->po_wo_check($pack_id);
$flag = $check_status['flag'];
$po_wo_satus = $check_status['po_wo_status'];
$proj_id = $check_status['pw_projid'];
$pack_id = $check_status['pw_packid'];
$po_uploadcheck = $cls_comm->check_pouploaded($pack_id);
$today_date = date("d-M-y");
$generate_token= generate_token();
?>
<style>
    .badge-pill {
        padding-top: 0.5em;
    }
</style>
<script>
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',
        //        startDate: date,
        orientation: 'top',
    });
</script>
<?php if (($flag == 1) && ($po_wo_satus == 1 || $po_wo_satus == 3)) {
?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

    <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card" style="margin-left: 3%;">
                    <div class="card-body">
                        <h4 class="card-title">PO Create</h4>
                        <!-- <h6 class="card-subtitle">Add span with <code>.input-group-text</code> class before <code>&lt;input&gt;</code></h6> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Po Number</span>
                            </div>
                            <input type="text" class="form-control" id="apo_num" name="apo_num" aria-describedby="basic-addon1" required>

                        </div>



                        <div class="input-group mb-3 ">
                            <div class="input-group">
                                <center>
                                    <span class="badge badge-pill badge-secondary brown font-medium text-white ml-1" id="viewpob" alt="default" style=" cursor: pointer;" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" onclick="podetailviewget('<?php echo $pack_id; ?>')"> GET </span>
                                </center>
                                <!-- <div class="custom-file">
                                     <input type="file" class="custom-file-input" name="ppo_attach" value="" id="ppo_attach">

                                    <label class="custom-file-label form-control" for="ppo_attach">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="q_pack_id" onclick="swift_upload(<?php echo $pack_id ?>,<?php echo $proj_id ?>)">Upload</button>
                                    &nbsp;&nbsp;
                              </div> -->
                                <!-- <a href="downloads/po_details.csv" data-toggle="tooltip" data-placement="top" title="Sample Document"> <i class="fas fa-file-excel" style=" color: green;font-size: 2em; margin-top: 5px;"></i></a> -->
                                <?php if ($po_uploadcheck == 1) { ?>
                                    <center><span class="badge badge-pill badge-secondary brown font-medium text-white ml-1" id="viewpob" alt="default" style=" cursor: pointer;" data-toggle="modal" data-target="#model_view" class="model_img img-fluid" onclick="podetailviewdata('<?php echo $pack_id; ?>')"> VIEW</span></center>

                                <?php } else { ?>
                                    <center><span class="badge badge-pill badge-secondary brown font-medium text-white ml-1" id="viewpob" alt="default" style=" cursor: pointer;" onclick=" swal('Please Upload and Continue')">VIEW</span></center>

                                <?php }
                                ?>

                            </div>

                        </div>
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
                            <input type="text" class="form-control mydatepicker" id="po_planned" name="po_planned" aria-describedby="basic-addon1" value="<?php echo $plan_date ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"  style="width: 100px;">Expected</span>
                            </div>

                            <input type="text" class="form-control mydatepicker" id="po_expected" name="po_expected" value="<?php
                                                                                                                            echo formatDate(str_replace('/', '-', $Pexpdate, 'd-M-y'));;
                                                                                                                            ?>" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"  style="width: 100px;">Actual</span>
                            </div>
                            <input type="text" class="form-control mydatepicker" id="po_actual" name="po_actual" onchange="pocreatesamedate(this.value)" value="<?php echo $today_date; ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <!-- <h4 class="card-title">PO Value</h4>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Po Value</span>
                            </div>
                            <input type="text" class="form-control" id="po_value" name="po_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" aria-describedby="basic-addon1">
                        </div> -->
                        <h4 class="card-title">Remarks</h4>
                        <div class="form-group">
                            <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                            <textarea class="form-control" rows="6" id="po_remarks" name="po_remarks" required></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="page" id="page" value="0" class="form-control">
                <input type="hidden" name="pack_id" id="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" id="proj_id" value="<?php echo $proj_id ?>">
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" id="po_approve" name="po_approve"><i class="fas fa-paper-plane"></i> PO Creation / Approval </button>
            </div>
        </div>
    </form>
<?php } else if (($flag == 2) && ($po_wo_satus == 1 || $po_wo_satus == 3)) { ?>
    <form action="functions/po_wo_entry" method="post" autocomplete="off" onsubmit="return confirm('Are you sure you want to submit?');">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php  echo $generate_token;  ?>" />

    <div class="form-group">
            <div class="row">
                <div class=" col-md-1"></div>
                <div class="  col-md-5  ">

                    <h4 class="card-title">PO Approval</h4>
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
                        <input type="hidden" name="pagename" id="pagename" value="popage">
                        <input type="text" class="form-control mydatepicker" id="po_planned" name="po_planned" aria-describedby="basic-addon1" value="<?php echo $plan_date ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Expected</span>
                        </div>
                        <input type="text" class="form-control mydatepicker" id="po_expected1" name="po_expected" value="<?php
                                                                                                                            echo formatDate(str_replace('/', '-', $Pexpdate, 'd-M-y'));

                                                                                                                            ?>" aria-describedby="basic-addon1">
                    </div>

                    <input type="hidden" class="form-control mydatepicker" id="po_actual" name="po_actual" value="<?php echo $today_date; ?>" onchange="poapprovalsamedate(this.value)" aria-describedby="basic-addon1">

                    <div class="input-group mb-3" style=" display: none;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Actual</span>
                        </div>
                        <!--<input type="hidden"  class="form-control mydatepicker" id="po_actual"   name="po_actual" value="<?php echo $today_date; ?>" onchange="poapprovalsamedate(this.value)" aria-describedby="basic-addon1">-->

                    </div>

                </div>

                <div class="col-md-6">

                    <h4 class="card-title">Remarks</h4>
                    <div class="form-group">
                        <!-- <label for="message-text" class="control-label">Enter Remarks:</label> -->
                        <textarea class="form-control" rows="4" id="po_remarks" name="po_remarks" required></textarea>
                    </div>

                </div>
                <br>
                <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" value="<?php echo $proj_id ?>">
                <button type="submit" class="btn btn-outline-primary btn-rounded btn-pull-right" id="po_approve" name="po_approve"><i class="fas fa-paper-plane"></i> Po Approval </button>

            </div>
        </div>
        </div>
    </form>

<?php
} ?>
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