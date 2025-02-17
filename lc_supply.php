<?php
include 'config/inc.php';
if (isset($_GET['lc'])) {
    $lc = $_GET['lc'];
} else {
    $lc = "";
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
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">LC Supply Update</h5>
            </div>
            <div class="col-lg-3 col-md-3">

                <select class="custom-select" name="vendor" id="vendor" required=""  onchange="swift_proj(this.value)">
                    <option value="">--Select LC Number--</option>
                    <?php
                    $result = $cls_lc->select_lcmaster();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['lcm_id'] ?>" <?php echo ($lc == $value['lcm_id'] ) ? 'selected' : ''; ?>><?php echo $value['lcm_num'] ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">LC Supply Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- basic table -->

        <div class="row">
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
                                        <th>Supply Date</th>
                                        <th>Supply Exchange Rate</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $total_po = 0;
                                    $total_supply = 0;
                                    $get_lc = $cls_lc->get_lc($lc);

                                    $result = $cls_lc->select_created_pos_by_lc($lc);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        // $forex = $cls_lc->getForex($value['lcr_lcid']);
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
                                            <td class="supply_value text-right" onkeyup="cal_total_po('<?php echo $value['lcr_id']; ?>')" onkeypress="return isNumberKey(event)" id="supply_value<?php echo $value['lcr_id']; ?>" > <?php echo $value['lcr_supply']; ?></td>
                                            <td class="supply_date"    ><input disabled type="date" id="supply_date<?php echo $value['lcr_id']; ?>"  value="<?php
                                                if ($value['lcr_supply_date'] != "") {
                                                    echo formatDate($value['lcr_supply_date'], 'Y-m-d');
                                                }
                                                ?>"></td>
                                            <td class="exchage_rate "  id="exchage_rate<?php echo $value['lcr_id']; ?>"><?php echo $value['lcr_supply_exchange']; ?></td>

                                        </tr>
                                        <?php
                                        $total_po += $value['lcr_povalue'];
                                        $total_supply += $value['lcr_supply'];
                                      $inr=   $get_lc['lcm_forex']*$get_lc['lcm_balance'];
                                    }
                                    ?>                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7" class=" text-right font-24"> Total Supply Value  </td>
                                        <td    class=" text-right font-24" id="total_po"> <?php echo $total_supply; ?> </td>
                                        <td   colspan="2" class=" text-right font-24">   <input type="hidden" id="po_total" value="0"> </td>

                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <div class="form-row">
                                                <div class="col-md-3 mb-3 none">
                                                    <label for="lc_value" id="sel_cur"> Select Currency</label><br>
                                                    <select class="custom-select" name="currency" id="currency" required=""  onchange="sel_cur(this.value)">
                                                        <option value="">--Select Currency --</option>
                                                        <?php
                                                        $result = $cls_lc->select_currency();
                                                        $res = json_decode($result, true);
                                                        foreach ($res as $key => $value) {
                                                            ?>
                                                            <option value="<?php echo $value['id'] ?>" name="<?php echo $value['currency_hname'] ?>"><?php echo $value['currency_hname']; ?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mb-3">
                                                    <label for="lc_balance_value" id="sel_cur"> LC Balance Value in <?php echo $get_lc['currency_hname'] ?></label>
                                                    <input type="text" readonly="" class="form-control"   id="lc_balance_value" name="lc_balance_value" placeholder="LC Value" value="<?php echo ($get_lc['lcm_balance'] ); ?>" onkeypress="return isNumberKey(event)" required>
                                                    <input type="hidden" id="bal_forex" value="<?php echo $get_lc['lcm_forex']; ?>">
                                                    <input type="hidden" id="lc_value" value="<?php echo $get_lc['lcm_valueinr']; ?>">
                                                    <input type="hidden" id="lcnum_id" value="<?php echo $get_lc['lcm_id']; ?>">
                                                    <input type="hidden" id="lc_balance_value_cal" value="<?php echo ($get_lc['lcm_balance'] ); ?>">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="forex">Forex</label>
                                                    <input type="text" class="form-control" onkeyup="calculate()" id="forex"  name="forex" placeholder="Forex" value="<?php echo $get_lc['lcm_forex'] ?>"  onkeypress="return isNumberKey(event)" required  readonly="">
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="inr_val">Value in INR</label>
                                                    <input type="text" class="form-control" id="inr_val"  name="inr_val" placeholder="Value in INR"   readonly="" value="<?php echo $inr; ?>" required>
                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class=" text-right" colspan="10">
                                            <button class=" btn btn-github" id="save_lcreation" style="margin:5px;" onclick="save_lcreation()"> Submit</button> 
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
                                                    window.location.href = "lc_supply?lc=" + Proid;
                                                }
                                                function enable_cell(id) {
                                                    if (!$('input#customCheck' + id).is(':checked')) {
                                                        $('#supply_value' + id).addClass('bg-lc');
                                                        $('#supply_value' + id).attr('contenteditable', true);
                                                        $('#exchage_rate' + id).addClass('bg-lc');
                                                        $('#exchage_rate' + id).attr('contenteditable', true);
                                                        $('#supply_date' + id).attr('disabled', false);
                                                        total_po(id);
                                                    } else {
                                                        $('#supply_value' + id).removeClass('bg-lc');
                                                        $('#supply_value' + id).attr('contenteditable', false);
                                                        $('#exchage_rate' + id).removeClass('bg-lc');
                                                        $('#exchage_rate' + id).attr('contenteditable', false);
                                                        $('#supply_date' + id).attr('disabled', true);
                                                        total_po_minus(id);
                                                    }
                                                }
                                                function total_po(id) {
                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#supply_value' + id).text();
                                                    var total_po = po_total + po_value;
                                                    $('#total_po').text(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function total_po_minus(id) {
                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#supply_value' + id).text();
                                                    var total_po = po_total - po_value;
                                                    $('#total_po').text(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function cal_total_po() {
                                                    var j = 0;

                                                    var quoteid = new Array();
                                                    var po_value = new Array();


                                                    $('#zero_confi tr.ty').each(function () {
                                                        quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                        if ($('input#customCheck' + quoteid[j]).is(':checked')) {

                                                            po_value[j] = +$(this).find('td#supply_value' + quoteid[j]).text();


                                                        }
                                                        j++;
                                                    });

                                                    var total = 0;
                                                    for (var i = 0; i < po_value.length; i++) {
                                                        total += po_value[i] << 0;
                                                    }
                                                    $('#total_po').text(total.toFixed(2));
                                                    $('#po_total').val(total);

                                                    var balance = +$('#lc_balance_value_cal').val();
//                                                    var balance = +$('#lc_balance_value').val();
                                                    var forex = +$('#bal_forex').val();

                                                    var lc_value = +$('#lc_value').val();
                                                    var total_wo = total / forex;
                                                    var total_wo_as = total;

//                                                    var balance_value = (lc_value / forex) - total_wo;
                                                    var balance_value = (balance) - total_wo_as;
                                                    $('#lc_balance_value').val(balance_value.toFixed(2));
                                                    calculate();
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
                                                    var balance = +$('#lc_balance_value').val();


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
                                                            supply_value: supply_value, supply_date: supply_date, exchage_rate: exchage_rate, lc_id: lc_id,balance:balance}, function (dataa) {
                                                            if ($.trim(dataa) == 1) {
                                                                $('#save_lcreation').hide();
//                                                                $('#redirecting').show();
                                                                $('#saving_lcreation').hide();

//                                                                            $('#redirecting').hide();
                                                                window.location.reload(true);





                                                            } else {
                                                                alert('Something went wrong!!!');
                                                                $('#save_lcreation').show();
                                                                $('#saving_lcreation').hide();
                                                            }
                                                        });


                                                    }
                                                }


</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 