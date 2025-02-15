<?php
include_once("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$generate_token = generate_token();
$pack_id = $_POST['pack_id'];
$projid = $_POST['projid'];
$flag = $_POST['flag'];
$result = $cls_comm->distributor_check($pack_id, $projid);
$result2 = $cls_comm->distributor_files($pack_id, $projid);


// $check_status = $cls_comm->po_wo_check($pack_id);
// $flag = $check_status['flag'];
// $po_wo_satus = $check_status['po_wo_status'];
// $proj_id = $check_status['pw_projid'];
// $pack_id = $check_status['pw_packid'];
// $po_uploadcheck = $cls_comm->check_pouploaded($pack_id);
$today_date = date("d-M-y");
?>
<style>
    span#viewpob {
        margin-top: 16px;
    }

    .tooltip-inner {
        max-width: 100% !important;
        background-color: #09aef7 !important;
        color: #fff;
        white-space: pre-line;
        text-align: left;
        font-size: 15px;
    }

    .bs-tooltip-top .arrow::before,
    .bs-tooltip-auto[x-placement^="top"] .arrow::before {
        border-top-color: #09aef7 !important;
    }

    .bs-tooltip-right .arrow::before,
    .bs-tooltip-auto[x-placement^="right"] .arrow::before {
        border-right-color: #09aef7 !important;
    }


    .bs-tooltip-bottom .arrow::before,
    .bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
        border-bottom-color: #09aef7 !important;
    }


    .bs-tooltip-left .arrow::before,
    .bs-tooltip-auto[x-placement^="left"] .arrow::before {
        border-left-color: #09aef7 !important;
    }
</style>
<script>
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',
        //        startDate: date,
        orientation: 'top',
    });
</script>

<form action="functions/po_wo_entry" style="width: 90%;" method="post" autocomplete="off">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $generate_token; ?>" />

    <div class="row">

        <?php $res = json_decode($result, true);

        foreach ($res as $key => $value) {
            //echo $key;
        
            $md_id = $value['md_id'];
            $flag = $value['flag'];
            $buyerapp = $value['buyer_app'];
            //$send_back          = $value['send_back'];
            $oem_flag = $value['oem_flag'];
            $remark = $value['remark'];
            $approved_on = $value['approved_on'];
            $send_back = $value['send_back'];
            $doc_details = $cls_comm->doc_dist($md_id);

            $doc_name = $doc_details['df_filename'];
            $doc_path = $doc_details['df_filepath'];
            // $supplier    = $cls_comm->cur_status_supp($packid, $projid);
            // $count      = $status['fcount'];
            // $flag       = $status['flag'];
            // if($i==$flag){
            //   echo $i;
            // }else{
            //     echo "ee";
            // }
            if ($flag == 0) {
                $current_status = 'Site Operation';
            } else if ($flag == 1) {
                $current_status = 'Distributor';
            } else {
                $current_status = 'OEM';
            }
            ?>
            <div class="col-lg-3 col-md-3" style=" margin-left: 5%;">

                <div class="card" style="margin-left: 10%;color:#000;">
                    <div class="d-flex flex-row" style="width: 1000px;">
                        <div class="align-self-center p-2">
                            <b> <span>
                                    <?php echo $current_status; ?> :
                                </span>
                                <span style="color:#ad0404;">
                                    <?php echo $value['contact_name'] ?>
                                </span>
                                </br />
                                <?php if ($flag != '2') { ?>
                                    <span> Filled in Details : </span>
                                    <i style="color: #09aef7;" class="fa fa-info-circle" aria-hidden="true"
                                        data-toggle="tooltip"
                                        data-original-title="Name : <?php echo $value['contact_name'] ?> &#010; Mobile No: <?php echo $value['mobile_no'] ?>&#010;Email id: <?php echo $value['email_id'] ?> "></i></br />
                                <?php } else { ?>
                                    <span> Order Placed Qty : </span>
                                    <span>
                                        <?php echo $oem_flag; ?>
                                    </span></br />
                                <?php } ?>
                                <span>Remark : </span>
                            </b> <span>
                                <?php echo $remark; ?>
                            </span></br />
                            <b><span>Approved On : </span></b> <span>
                                <?php echo date('d-M-Y', strtotime($approved_on)); ?>
                            </span></br /></br />
                            <b><span>Attachment : </span>
                                <?php if ($doc_path != '') { ?> <span><a
                                    href="uploads/order_document/<?php echo $doc_path; ?>" class=" text-purple"
                                    target="_blank"><i style="color: #f99b13;" class="fa fa-paperclip"
                                        data-toggle="tooltip" data-original-title="Doc Name : <?php echo $doc_name; ?>">
                                    </i></a>
                                <?php } ?>
                                </span>
                            </b>
                        </div>
                    </div>
                </div>

            </div>


        <?php }

        $res2 = json_decode($result2, true);

        if (count($res2) > 0) {
            ?>
            <div class="col-lg-3 col-md-3" style=" margin-left: 5%;">
                <div class="card" style="margin-left: 10%;color:#000;">
                    <div class="d-flex flex-row" style="width: 1000px;">
                        <div class="align-self-center p-2">
                            <b>
                                <span>Revised Details From Distributor <span></br />
                                        <span>Attachments : </span> </br />
                                        <?php foreach ($res2 as $key => $value2) {
                                            $remark = $value2['remark'];
                                            $doc_name = $value2['df_filename'];
                                            $doc_path = $value2['df_filepath']; ?>
                                            <span style="color:#09aef7;">
                                                <?php echo $doc_name; ?>
                                            </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span><a href="uploads/order_document/<?php echo $doc_path; ?>" class=" text-purple"
                                                    target="_blank"><i style="color: #f99b13;" class="fa fa-paperclip"
                                                        data-toggle="tooltip"
                                                        data-original-title="Doc Name : <?php echo $doc_name; ?>">
                                                    </i></a></span>
                                            &nbsp;&nbsp;&nbsp;
                                            <?php if ($key == 1) { ?>
                                                <br />
                                            <?php } ?>
                                        <?php } ?>
                                        <br />
                                        <span>Remark : </span> </b><span>
                                <?php echo $remark; ?>
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row">
        <div class=" col-md-1"></div>
        <div class="  col-md-5 ">
            <h4 class="card-title">Approve Date</h4>
            <div class="input-group mb-3">
                <!-- <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Approved On</span>
                </div> -->
                <input type="text" class="form-control mydatepicker" id="po_expected1" name="po_expected"
                    value="<?php echo date('d-M-y', strtotime(str_replace('/', '-', $today_date))); ?>"
                    aria-describedby="basic-addon1">
            </div>
            <input type="hidden" class="form-control mydatepicker" id="po_actual" name="po_actual"
                value="<?php echo $today_date; ?>" onchange="poapprovalsamedate(this.value)"
                aria-describedby="basic-addon1">
        </div>

        <div class="col-md-6">
            <h4 class="card-title">Remarks</h4>
            <div class="form-group">
                <textarea class="form-control" rows="3" id="remarks" name="remarks"></textarea>
            </div>
        </div>

        <div class=" col-md-1"></div>
        <div class="col-md-5 backto" style="display:none;">
            <h4 class="card-title">Send Back To</h4>
            <div class="input-group mb-3">
                <select class="custom-select" name="senbackDist" id="senbackDist">
                    <option value="">--Select Send Back--</option>
                    <?php $result = $cls_comm->Distributer($projid, $pack_id);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['md_id'] ?>"><?php echo $value['contact_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group mb-3">

                <input type="hidden" name="pack_id" value="<?php echo $pack_id ?>">
                <input type="hidden" name="proj_id" value="<?php echo $projid ?>">
                <?php if ($flag == 2) {
                    $supplier = $cls_comm->cur_status_supp($pack_id, $projid);
                    $orderconfirm = $cls_comm->cur_status_supp($pack_id, $projid);
                    //print_r(count($orderconfirm));
                    $send_back = $orderconfirm['send_back'];
                    if (count($orderconfirm) == 0) { ?>
                        <button type="submit" style="margin-top:7%;"
                            class="btn btn-outline-primary btn-rounded btn-pull-right click" id="order_approve"
                            name="order_approve"><i class="fas fa-paper-plane"></i> Approve </button>
                            <button style="display:block;margin-left: 6%;margin-top:7%;" type="submit"
                            class="btn waves-effect waves-light btn-rounded btn-outline-danger pull-left click"
                            id='buyersend_back' name="buyersend_back"> <i class="fas fa-times"></i> Send Back</button>
                    <?php }
                    if ((count($orderconfirm) == 1) && ($send_back == 1)) {
                        ?>
                        <button type="submit" style="margin-top:7%;"
                            class="btn btn-outline-primary btn-rounded btn-pull-right click" id="order_approve"
                            name="order_approve"><i class="fas fa-paper-plane"></i> Approve </button>
                        <button style="display:block;margin-left: 6%;margin-top:7%;" type="submit"
                            class="btn waves-effect waves-light btn-rounded btn-outline-danger pull-left click"
                            id='buyersend_back' name="buyersend_back"> <i class="fas fa-times"></i> Send Back</button>
                    <?php }
                } ?>

            </div>
        </div>
    </div>


    </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top'
        });
    });
</script>
<script>
    const num1 = 1000;
    const num2 = 129943;
    const num3 = 76768798.00;
    const toIndianCurrency = (num) => {
        const curr = num.toLocaleString('en-IN', {
            style: 'currency',
            currency: 'INR'
        });
        return curr;
    };
    console.log(toIndianCurrency(num1));
    console.log(toIndianCurrency(num2));
    console.log(toIndianCurrency(num3));
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
<script>
    $(function () {
        var buttonpressed;
        $('.click').click(function () {
            buttonpressed = $(this).attr('name');
        })
        $('form').submit(function () {
            var sendback = $('#senbackDist').val();
            if (buttonpressed == 'buyersend_back') {
                $('.backto').show();
                if (sendback == "") {
                    alert('Please Select Send Back To');
                    return false;
                } else {
                    confirm('Are you sure you want to submit?');
                }
            } else {
                // alert('button clicked was ' + buttonpressed)
                confirm('Are you sure you want to submit?');
            }
            buttonpressed = ''
        });
    });
</script>