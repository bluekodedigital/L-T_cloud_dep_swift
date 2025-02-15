<?php
include 'config/inc.php';
if (isset($_GET['lc'])) {
    $lc = $_GET['lc'];
} else {
    $lc = "";
}
if (isset($_GET['due'])) {
    $due = $_GET['due'];
} else {
    $due = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
?>
<style>

    #zero_confi th,td {
        white-space: nowrap;
        padding: 8px;
    }
    .cpointer{
        cursor: pointer;
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
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">LC Payment Updation</h5>
            </div>
            <?php $today = date('Y-m-d'); ?>


            <div class="col-lg-3 col-md-3">
                <select class="custom-select" id="due_in" onchange="select_due_lcs(this.value);" >
                    <option value="">--Select Payment due in--</option>
                    <option value="all" <?php echo ($due == 'all' ) ? 'selected' : ''; ?> >--All--</option>
                    <option value="<?php echo $today; ?>" <?php echo ($due == $today ) ? 'selected' : ''; ?>>Today</option>
                    <option value="<?php echo date('Y-m-d', strtotime($today . '+1 days')); ?>" <?php echo ($due == date('Y-m-d', strtotime($today . '+1 days')) ) ? 'selected' : ''; ?>>Tomorrow</option>
                    <option value="<?php echo date('Y-m-d', strtotime($today . '+5 days')); ?>" <?php echo ($due == date('Y-m-d', strtotime($today . '+5 days')) ) ? 'selected' : ''; ?>> in 5 days</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3">

                <select class="custom-select" name="vendor" id="vendor" required=""  onchange="swift_proj(this.value)">
                    <option value="">--Select LC Number--</option>
                    <?php
                    if ($lc == "") {
                        $result = $cls_lc->select_lcmaster();
                    } else {
                        $result = $cls_lc->select_lcmaster_bylc($lc);
                    }

                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['lcm_id'] ?>" <?php echo ($lc == $value['lcm_id'] ) ? 'selected' : ''; ?>><?php echo $value['lcm_num'] ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">LC Payment Updation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- basic table -->

        <div class="row">
            <?php if ($lc != "") { ?>
                <div class="col-12 ">
                    <div class="material-card card">
                        <div class="card-body">
                            <!--<h4 class="card-title">Work Flow</h4>-->
                            <div class="table-responsive">
                                <table id="zero_confi" class="table table-bordered  ">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>PO Number</th>
                                            <th>Projects</th>
                                            <th>Package Name</th>
                                            <th>PO Value</th>
                                            <th>PO Type</th>
                                            <th>Pay Terms</th>
                                            <th>Supply Value</th>
                                            <th>Enter Payment Value</th>
                                            <th>Supply Date</th>
                                            <th>Supply Exchange Rate</th>
                                            <th>Payment due in days</th>
                                            <th>Payment due date</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php
                                        $total_po = 0;
                                        $total_supply = 0;
                                        $get_lc = $cls_lc->get_lc($lc);

//                                        $result = $cls_lc->select_created_pos_by_lc_due($lc);
                                        $result = $cls_lc->select_created_pos_by_lc_due_latest($lc, $due);
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <tr class="ty">
                                                <td>
                                                    <div class="custom-control custom-checkbox ">
                                                        <input type="checkbox" class="custom-control-input" value="<?php echo $value['lcr_id']; ?>"    id="customCheck<?php echo $value['lcr_id']; ?>">
                                                        <label class="custom-control-label cpointer" for="customCheck<?php echo $value['lcr_id']; ?>" onclick="enable_cell('<?php echo $value['lcr_id']; ?>')"> </label>
                                                    </div>
                                                </td>
                                                <td class="po_number"   id="po_number<?php echo $value['lcr_id']; ?>"><?php echo $value['lcr_ponumber']; ?></td>
                                                <td><?php echo $value['proj_name']; ?></td> 
                                                <td class="solutions"><?php echo $value['sol_name']; ?>
                                                    <input type="hidden" id="packid<?php echo $value['lcr_id']; ?>" value="<?php echo $value['lcr_packid']; ?>">
                                                    <input type="hidden" id="projectid<?php echo $value['lcr_id']; ?>" value="<?php echo $value['proj_id']; ?>"> 
                                                    <input type="hidden" class="quoteid" value="<?php echo $value['lcr_id']; ?>"> 

                                                </td>
                                                <td class=" text-right po_value"  id="po_value<?php echo $value['lcr_id']; ?>" ><?php echo $value['lcr_povalue']; ?></td>
                                                <td class="po_type">
                                                    <select id="po_type<?php echo $value['lcr_id']; ?>" disabled="">
                                                        <option value="">--Select--</option>
                                                        <option value="0" <?php echo (0 == $value['lcr_potype'] ) ? 'selected' : ''; ?>>Domestic</option>
                                                        <option value="1" <?php echo (1 == $value['lcr_potype'] ) ? 'selected' : ''; ?>>Import</option>
                                                    </select>                                             
                                                </td>
                                                <td  class="pay_term"   id="pay_term<?php echo $value['lcr_id']; ?>"><?php echo $value['lcr_payterms']; ?></td>
                                                <td class="supply_value text-right" id="supply_value<?php echo $value['lcr_id']; ?>" > <?php echo $value['lcr_supply']; ?></td>
                                                <td class="popay_value text-right" onkeyup="cal_total_po('<?php echo $value['lcr_id']; ?>')" onkeypress="return isNumberKey(event)" id="popay_value<?php echo $value['lcr_id']; ?>" > <?php // echo $value['lcr_supply'];       ?></td>
                                                <td class="supply_date"    ><input disabled type="date" id="supply_date<?php echo $value['lcr_id']; ?>"  value="<?php echo date('Y-m-d', strtotime($value['lcr_supply_date'])); ?>"></td>
                                                <td class="exchage_rate "  id="exchage_rate<?php echo $value['lcr_id']; ?>"><?php echo $value['lcr_supply_exchange']; ?></td>
                                                <td><?php
                                                    if ($value['payment_due'] == 0) {
                                                        echo 'Today';
                                                    } else {
                                                        echo $value['payment_due'];
                                                    }
                                                    ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($value['DateAdd'])); ?></td>
                                            </tr>
                                            <?php
                                            $total_po += $value['lcr_povalue'];
                                            $total_supply += $value['lcr_supply'];
                                        }
                                        ?>                                    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" class=" text-right font-24"> Total Supply Value  </td>
                                            <td    class=" text-right font-24" id="total_po"> <?php echo $total_supply; ?> </td>
                                            <td   colspan="4" class=" text-right font-24">   <input type="hidden" id="po_total" value="0"> </td>

                                        </tr>
                                        <tr>
                                            <td colspan="7" class=" text-right font-24"> Already Paid Value  </td>
                                            <td    class=" text-right font-24"  > <?php
                                                echo $get_paid = $cls_lc->get_paid($lc);
                                                ?> </td>
                                            <td   colspan="4" class=" text-right font-24">

                                                <input type="hidden" id="max_pay" value="<?php echo $total_supply - $get_paid; ?>"></td>

                                        </tr>
                                        <tr>
                                            <td colspan="11">
                                                <div class="form-row">
                                                    <div class="col-md-3 mb-3">
                                                        <label for="lc_payment_value" id="sel_cur"> LC Payment Value</label>
                                                        <input type="text"  class="form-control" readonly=""   id="lc_payment_value" name="lc_payment_value" placeholder="LC Payment Value" value="" onkeypress="return isNumberKey(event)" required>

                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="lc_payment_date" id="sel_cur"> LC Payment Date</label>
                                                        <input type="date"  class="form-control"   id="lc_payment_date" name="lc_payment_date" placeholder="LC Payment Date" value="" onkeypress="return isNumberKey(event)" required>

                                                    </div>
                                                    <div class="col-md-3 mb-3">
                                                        <label for="lc_exchange_rate" id="sel_cur"> LC Exchange Rate</label>
                                                        <input type="text"  class="form-control"   id="lc_exchange_rate" name="lc_exchange_rate" placeholder="LC Exchange Rate" value="" onkeypress="return isNumberKey(event)" required>

                                                    </div>
                                                    <div class="col-md-3 mb-3"></div>

                                                    <div class="col-md-3 mb-3 none">
                                                        <label for="lc_balance_value" id="sel_cur"> LC Balance Value in <?php echo $get_lc['currency_hname'] ?></label>
                                                        <input type="text" readonly="" class="form-control"   id="lc_balance_value" name="lc_balance_value" placeholder="LC Value" value="<?php echo ($get_lc['lcm_balance'] / $get_lc['lcm_forex']); ?>" onkeypress="return isNumberKey(event)" required>
                                                        <input type="hidden" id="bal_forex" value="<?php echo $get_lc['lcm_forex']; ?>">
                                                        <input type="hidden" id="lc_value" value="<?php echo $get_lc['lcm_valueinr']; ?>">
                                                        <input type="hidden" id="lcnum_id" value="<?php echo $get_lc['lcm_id']; ?>">

                                                    </div>
                                                    <div class="col-md-3 mb-3 none">
                                                        <label for="forex">Forex</label>
                                                        <input type="text" class="form-control" onkeyup="calculate()" id="forex"  name="forex" placeholder="Forex" value=""  onkeypress="return isNumberKey(event)" required>
                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-3 none">
                                                        <label for="inr_val">Value in INR</label>
                                                        <input type="text" class="form-control" id="inr_val"  name="inr_val" placeholder="Value in INR" value="" readonly="" required>
                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=" text-left" colspan="10">
                                                <button class=" btn btn-github" id="save_lcreation" style="margin:5px;" onclick="save_payment()"> Submit</button> 
                                                <button class=" btn btn-github none" id="saving_lcreation" style="margin:5px;" > <i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</button> 
                                                <button class=" btn btn-github none" id="redirecting" style="margin:5px;" > <i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Redirecting...</button>
                                            </td>
                                        </tr>

                                    </tfoot>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>





        </div>




    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/technical.js" type="text/javascript"></script>
<script src="code/js/lc_rpa.js" type="text/javascript"></script>
<script>


                                                function swift_proj(Proid) {

                                                    var due_in = $('#due_in').val();
                                                    if (due_in == "") {
                                                        alert('Please select due in days');
                                                    } else {
                                                        window.location.href = "lc_payment?lc=" + Proid + "&due=" + due_in;
                                                    }

                                                }
                                                function enable_cell(id) {
                                                    if (!$('input#customCheck' + id).is(':checked')) {
                                                        $('#popay_value' + id).addClass('bg-lc');
                                                        $('#popay_value' + id).attr('contenteditable', true);
//                                                            $('#exchage_rate' + id).addClass('bg-lc');
//                                                            $('#exchage_rate' + id).attr('contenteditable', false);
//                                                            $('#supply_date' + id).attr('disabled', false);
                                                        total_po(id);
                                                    } else {
                                                        $('#popay_value' + id).removeClass('bg-lc');
                                                        $('#popay_value' + id).attr('contenteditable', false);
//                                                            $('#exchage_rate' + id).removeClass('bg-lc');
//                                                            $('#exchage_rate' + id).attr('contenteditable', false);
//                                                            $('#supply_date' + id).attr('disabled', true);
                                                        total_po_minus(id);
                                                    }
                                                }
                                                function total_po(id) {
                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#popay_value' + id).text();
                                                    var total_po = po_total + po_value;
                                                    $('#lc_payment_value').val(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function total_po_minus(id) {
                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#popay_value' + id).text();
                                                    var total_po = po_total - po_value;
                                                    $('#lc_payment_value').val(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function cal_total_po() {
                                                    var j = 0;

                                                    var quoteid = new Array();
                                                    var po_value = new Array();


                                                    $('#zero_confi tr.ty').each(function () {
                                                        quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                        if ($('input#customCheck' + quoteid[j]).is(':checked')) {

                                                            po_value[j] = +$(this).find('td#popay_value' + quoteid[j]).text();


                                                        }
                                                        j++;
                                                    });

                                                    var total = 0;
                                                    for (var i = 0; i < po_value.length; i++) {
                                                        total += po_value[i] << 0;
                                                    }

                                                    $('#lc_payment_value').val(total.toFixed(2));
                                                    $('#po_total').val(total);



                                                }
                                                function calculate() {
                                                    var forex = +$('#forex').val();
                                                    var balance = +$('#lc_balance_value').val();
                                                    var inr_val = forex * balance;
                                                    $('#inr_val').val(inr_val.toFixed(2));
                                                }
                                                function save_lcreation() {
                                                    var IDs = new Array();
                                                    var vid = $('#vendor').val();
                                                    var total_po = +$('#total_po').text();

                                                    var final_forex = +$('#forex').val();
                                                    var final_val_inr = +$('#inr_val').val();
                                                    var lc_id = $('#lcnum_id').val();


                                                    IDs = $(".custom-control-input:checked").map(function () {
                                                        return this.value;
                                                    }).toArray();

                                                    var check = IDs.length - 2;
                                                    if (check == 0) {
                                                        alert('Please select anyone & Proceed');
                                                    } else {
                                                        var j = 0;
                                                        var po_number = new Array();
                                                        var quoteid = new Array();
                                                        var po_value = new Array();
                                                        var po_type = new Array();
                                                        var pay_term = new Array();
                                                        var project = new Array();
                                                        var package = new Array();
                                                        var sel_quote = new Array();
                                                        var supply_value = new Array();
                                                        var supply_date = new Array();
                                                        var exchage_rate = new Array();

                                                        $('#zero_confi tr.ty').each(function () {
                                                            quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                            if ($('input#customCheck' + quoteid[j]).is(':checked')) {
                                                                po_number[j] = $(this).find('td#po_number' + quoteid[j]).text();
                                                                po_value[j] = +$(this).find('td#po_value' + quoteid[j]).text();
                                                                po_type[j] = +$(this).find('td.po_type #po_type' + quoteid[j] + ' option:selected ').val();
                                                                pay_term[j] = +$(this).find('td#pay_term' + quoteid[j]).text();
                                                                project[j] = +$(this).find('td.solutions #projectid' + quoteid[j]).val();
                                                                package[j] = +$(this).find('td.solutions #packid' + quoteid[j]).val();

                                                                supply_value[j] = $(this).find('td#supply_value' + quoteid[j]).text();
                                                                supply_date[j] = $(this).find('td.supply_date #supply_date' + quoteid[j]).val();
                                                                exchage_rate[j] = $(this).find('td#exchage_rate' + quoteid[j]).text();

                                                                sel_quote[j] = quoteid[j];

                                                            }
                                                            j++;
                                                        });

                                                        $('#save_lcreation').hide();
                                                        $('#saving_lcreation').show();

                                                        $.post("code/save_lc_supply.php", {key: sel_quote, po_number: po_number, po_value: po_value,
                                                            po_type: po_type, pay_term: pay_term, project: project, package: package, vid: vid,
                                                            supplied_value: total_po, final_forex: final_forex, final_val_inr: final_val_inr,
                                                            supply_value: supply_value, supply_date: supply_date, exchage_rate: exchage_rate, lc_id: lc_id}, function (dataa) {
                                                            if ($.trim(dataa) == 1) {
                                                                $('#save_lcreation').hide();
                                                                $('#redirecting').show();
                                                                $('#saving_lcreation').hide();
                                                                setTimeout(
                                                                        function ()
                                                                        {

                                                                            $('#redirecting').hide();
//                                                                            window.location.href = 'lc_master?vid=' + vid;

                                                                        }, 5000);



                                                            } else {
                                                                alert('Something went wrong!!!');
                                                                $('#save_lcreation').show();
                                                                $('#saving_lcreation').hide();
                                                            }
                                                        });


                                                    }
                                                }
                                                function select_due_lcs(date) {
                                                    $.post("code/select_due_lcs.php", {key: date}, function (dataa) {
                                                        $('#vendor').html(dataa);
                                                    });
                                                }
                                                function save_payment() {
                                                    var IDs = new Array();
                                                    var vid = $('#vendor').val();
                                                    var lc_id = $('#lcnum_id').val();
                                                    var lc_payment_value = $('#lc_payment_value').val();
                                                    var lc_payment_date = $('#lc_payment_date').val();
                                                    var lc_exchange_rate = $('#lc_exchange_rate').val();
                                                    var total_supply = +$('#total_po').text();
                                                    var max_pay = +$('#max_pay').val();

                                                    IDs = $(".custom-control-input:checked").map(function () {
                                                        return this.value;
                                                    }).toArray();

                                                    var check = IDs.length - 2;
                                                    if (check == 0) {
                                                        alert('Please select anyone & Proceed');
                                                        exit();
                                                    } else if (lc_payment_value == 0.00) {
                                                        alert('Payment value should not Zero or Empty');
                                                    } else if (lc_payment_value == "") {
                                                        alert('Payment value should not be empty');
                                                    } else if (lc_payment_value > total_supply) {
                                                        alert('Payment value should not exceed Supply value');
                                                    } else if (lc_payment_value > max_pay) {
                                                        alert('Payment value should not exceed Supply value');
//                                                            alert('Payment value should not exceed ' + max_pay + ' Remaining entry already done');
                                                    } else {
                                                        var j = 0;

                                                        var quoteid = new Array();
                                                        var popay_value = new Array();
                                                        var sel_quote = new Array();


                                                        $('#zero_confi tr.ty').each(function () {
                                                            quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                            if ($('input#customCheck' + quoteid[j]).is(':checked')) {

                                                                popay_value[j] = +$(this).find('td#popay_value' + quoteid[j]).text();

                                                                sel_quote[j] = quoteid[j];

                                                            }
                                                            j++;
                                                        });
                                                        $.post("code/save_payment.php", {lc_id: lc_id, vid: vid, lc_payment_value: lc_payment_value, lc_payment_date: lc_payment_date, lc_exchange_rate: lc_exchange_rate,
                                                            total_supply: total_supply, sel_quote: sel_quote, popay_value: popay_value}, function (dataa) {
                                                            if ($.trim(dataa) == 1) {
                                                                alert('Payment saved !!!');
                                                                window.location.reload(true);
                                                            } else if ($.trim(dataa) == 2) {
                                                                alert('Payment Exceeds suplly value !!!');
                                                                window.location.reload(true);
                                                            } else {
                                                                alert('Someting went wrong !!!');
                                                                window.location.reload(true);
                                                            }
                                                        });
                                                    }
                                                }


</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 