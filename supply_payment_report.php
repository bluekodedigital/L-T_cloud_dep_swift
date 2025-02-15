<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
if (isset($_GET['vid'])) {
    $vid = $_GET['vid'];
} else {
    $vid = "";
}
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
?>
<style>
    .custom-select:disabled {
        color: #000;
    }
    #zero_config_lc th,td {
        white-space: nowrap;
        padding: 8px;
    }
</style>
<!-- Page wrapper  -->
<!-- ===================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Supply & Payment Report</h5>
            </div>
            <div class="col-lg-3 col-md-3">

                <select class="custom-select" name="vendor" id="vendor" required=""  onchange="swift_proj(this.value)">
                    <option value="">--Select vendor--</option>
                    <?php
                    $result = $cls_lc->vendor_select();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['sup_id'] ?>" <?php echo ($vid == $value['sup_id'] ) ? 'selected' : ''; ?>><?php echo $value['sup_name'] ?></option>
                    <?php } ?>
                </select>

            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Supply & Payment Report</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- Row -->







        <!-- basic table -->
        <div class="row">
            <div class="col-12 ">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive">
                            <table id="zero_config_lc" class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>LC Number</th>
                                        <th>Vendor</th>  
                                        <th>PO Number</th>                                                                            
                                        <th>PO Value</th>                                                                            
                                        <th>Supply Date</th>
                                        <th>Supply Value</th>
                                        <th>Supply Exchange Rate</th>
                                        <th>Payment Date</th>
                                        <th>Payment Value</th>  
                                        <th>Payment Exchange Rate</th>                                   

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_lc->select_supply_payment_report($vid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value['lcm_num']; ?></td>
                                            <td><?php echo $value['sup_name']; ?></td>
                                            <td><?php echo $value['lcr_ponumber']; ?></td>
                                            <td class=" text-right"><?php echo $value['lcr_povalue']; ?></td>
                                            <td><?php echo date('d-M-Y',strtotime($value['lc_sdate'])); ?></td>
                                            <td  class=" text-right"><?php echo $value['lc_sup_val']; ?></td>
                                            <td><?php echo $value['lc_sup_ex_rate']; ?></td>
                                            <td><?php if($value['paymet_date']!=""){   echo date('d-M-Y',strtotime($value['paymet_date'])); } ?></td>
                                            <td  class=" text-right"><?php echo $value['paymet_value']; ?></td>   
                                            <td class=" text-right"><?php echo $value['paymet_exrate']; ?></td>                                        

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
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/finance.js" type="text/javascript"></script>
<script src="code/js/technical.js" type="text/javascript"></script>
<script>
                    function isNumberKey(evt) {
                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                        if (charCode != 46 && charCode > 31 &&
                                (charCode < 48 || charCode > 57))
                            return false;
                        return true;
                    }
                    function getlc(a, b) {
                        var getid = a;
                        var pack_id = b;
                        $("#lc_row_id").val(getid);
                        $("#lc_pack_id").val(pack_id);
                        $.post("functions/getlcdatas.php", {key: pack_id}, function (data) {
                            var planned_date = JSON.parse(data).planned_date;
                            var mat_req_date = JSON.parse(data).mat_req_date;
                            var proj_name = JSON.parse(data).proj_name;
                            var packagename = JSON.parse(data).packagename;
                            var po_num = JSON.parse(data).po_num;
                            var wo_num = JSON.parse(data).wo_num;
                            $('#planned_date').html(planned_date);
                            $('#mat_req_date').html(mat_req_date);
                            $("#proj").html(proj_name);
                            $("#pack").html(packagename);
                            $("#lpo_number").val(po_num);
                            $("#lwo_number").val(wo_num);
                        });
                    }

                    function swift_proj(Proid) {
                        window.location.href = "supply_payment_report?vid=" + Proid;
                    }
                    function select_bank(id) {
                        $('#app_address').val(id);
                    }
                    function sel_cur(id) {
                        var name = $('#currency').find('option:selected').attr("name");
                        $('#sel_cur').html('LC Value in ' + name);
//    alert(name);
                    }
                    function calculate() {
                        var currency = $('#currency').val();
                        var name = $('#currency').find('option:selected').attr("name");
                        var rate_wo = $('#lc_value').val();
                        var forex = +$('#forex').val();
                        if (currency == "") {
                            alert('Please Select Currency');
                            $('#lc_value').val('');
                            $('#forex').val('');
                            $('#inr_val').val('');
                        } else if (rate_wo == "") {
                            alert('Please fill LC Value in ' + name);

                        } else {
                            var rate_with = rate_wo * forex;
                            $('#inr_val').val(rate_with.toFixed(2));
                        }
                    }

</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 