<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];

$result = $cls_comm->get_lc_data($pack_id);
$res = json_decode($result, true);

foreach ($res as $key => $value) {
    $planned_date = date('d-M-Y', strtotime($value['planned_date']));
    $mat_req_date = date('d-M-Y', strtotime($value['pm_revised_material_req']));
    if ($value['ps_expdate'] == "") {
        $exp_date = date('Y-m-d');
    } else {
        $exp_date = $value['ps_expdate'];
    }
    $expected_date = date('d-M-Y', strtotime($exp_date));
    $proj_name = $value['proj_name'];
    $pm_packagename = $value['pm_packagename'];
    $po_num = $value['po_number'];
    $wo_num = $value['wo_number'];
    $proj_id = $value['proj_id'];
}
?>
<?php
$vendor_details = $cls_user->vendor_details($pack_id);
$ven_id = $vendor_details['vq_venid'];
$fetch_lcnumber = $cls_user->fetch_lcnumber($ven_id);
$fetch_lc = json_decode($fetch_lcnumber, true);
foreach ($fetch_lc as $key => $value) {
    $lc_date = date('d-M-y', strtotime($value['lcm_date']));
    $lc_from = date('d-M-y', strtotime($value['lcm_from']));
    $lc_to = date('d-M-y', strtotime($value['lcm_to']));
    $lc_value = $value['lcm_value'];
    $lc_balance = $value['lcm_balance'];
    $lcm_id = $value['lcm_id'];
}
?>

<div class="modal-header" style="padding-bottom: 3%;">

    <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj"><?php echo $proj_name; ?></span> - <small id="pack"><?php echo $pm_packagename; ?></small></h4> 
    <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
    <h5 id="pack"><small></small></h5> -->
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="row">
    <div class="container-fluid">
        <div class=" col-md-6" id="pd">
            <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"><?php echo $planned_date; ?></span></small>                           
        </div>

        <div class=" col-md-6" id="ps">
            <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"><?php echo $expected_date; ?></span></small>                          
        </div>
    </div>
</div>
<div class="modal-body">
    <div class=" col-md-offset-1 col-xs-9">
        <center>
            <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle"><?php echo $vendor_details['sup_name']; ?></span></small>                
        </center>
    </div><br>
    <form method="post" class="needs-validation" action="functions/lc_apply.php" onsubmit=" return confirm('Are you sure you want to apply?');" autocomplete="off">      

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="revend_date">Po Number</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-calender"></i></span>
                        </div>
                        <input type="text" value="<?php echo $po_num; ?>" class="form-control" id="lpo_number" name="lpo_number" readonly="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>

                    </div>
                </div>
                <div class="col-md-6">
                    <label for="revend_date">LC Number</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-calender"></i></span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo $value['lcm_num']; ?>" id="lc_number" name="lc_number" readonly oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>

<!--                        <select class="custom-select" >
                            <option value="">-- Select LC Number --</option>
                        <?php
                        foreach ($fetch_lc as $key => $value) {
                            ?>
                                                        <option value="<?php echo $value['lcm_id']; ?>"><?php echo $value['lcm_num']; ?></option>
                        <?php }
                        ?>


                        </select>-->
                    </div>
                </div>
                <div class="col-md-6" style=" display: none;">
                    <label for="revend_date">Wo Number</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-calender"></i></span>
                        </div>
                        <input type="text" class="form-control" id="lwo_number" name="lwo_number" readonly oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>

                    </div>
                </div>

            </div><br>
            <div class="row">

                <div class="col-md-6">
                    <label for="revend_date">LC Date</label>
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="icon-calender"></i></span>
                        </div>
                        <input type="text" class="form-control mydatepicker" readonly="" id="lc_date" name="lc_date" value=" <?php echo $lc_date; ?>" required="" placeholder="mm/dd/yyyy">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="revend_date">Valid From & Valid To</label>
                    <div class="input-daterange input-group" id="date-range">
                        <input type="text " class="form-control mydatepicker" readonly="" name="start_lc" value=" <?php echo $lc_from; ?>" />
                        <div class="input-group-append">
                            <span class="input-group-text bg-info b-0 text-white">TO</span>
                        </div>
                        <input type="text" class="form-control mydatepicker" readonly name="end_lc" value=" <?php echo $lc_to; ?>" />
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="message-text" class="control-label">LC Value:</label>
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="icon-credit-card"></i></span>
                    </div>
                    <input type="text" name="lc_value" id="lc_value" value="<?php echo $lc_value; ?>"  onchange=" validate_lcvalue(this.value, '<?php echo $ven_id; ?>')" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="message-text" class="control-label">LC Balance:</label>
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="icon-credit-card"></i></span>
                    </div>
                    <input type="text" name="lc_balance" id="lc_balance" value="<?php echo $lc_balance; ?>"  readonly class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="message-text" class="control-label">Enter Remarks:</label>
            <textarea class="form-control" id="remarks" name="remarks" required></textarea>
        </div>
        <span id="error" class=" text-danger">

        </span> 
        <input type="hidden" id="lc_ttl" name="lc_ttl" value="<?php echo $lc_value; ?>">
        <input type="hidden" id="lc_venid" name="lc_venid" value="<?php echo $ven_id; ?>">
        <input type="hidden" id="lc_pack_id" name="lc_pack_id" value="<?php echo $pack_id; ?>">
        <input type="hidden" id="lc_proj_id" name="lc_proj_id" value="<?php echo $proj_id; ?>">
        <input type="hidden" id="lc_mst_id" name="lc_mst_id" value="<?php echo $lcm_id; ?>">
        <input type="hidden" id="expe_date" name="expe_date" value="<?php echo $expected_date; ?>">

        <div class="modal-footer">
                     <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
            <button type="submit" class="btn btn-outline-primary btn-rounded" name="lc_apply" id="submitbtn" ><i class="fas fa-paper-plane"></i> Apply LC </button>
        </div>
    </form>
</div>