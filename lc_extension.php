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
    #zero_config th,td {
        white-space: nowrap;
        padding: 8px;
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
                <h5 class="font-medium text-uppercase mb-0">LC Extension</h5>
            </div>
            <div class="col-lg-3 col-md-3">

                <select class="custom-select"    onchange="swift_proj(this.value)">
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
                        <li class="breadcrumb-item active" aria-current="page">Extension</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- Row -->

        <?php if ($vid != "") { ?>
            <div class="row" id="po_details">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero_config1" class="table table-bordered  ">
                                    <thead>
                                        <tr>

                                            <th>PO Number</th>
                                            <th>Projects</th>
                                            <th>Package Name</th>
                                            <th>PO Value</th>
                                            <th>PO Type</th>
                                            <th>Pay Terms</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php
                                        $total_po = 0;
                                        $result = $cls_lc->select_created_pos($vid);
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <tr class="ty">                                           
                                                <td class="po_number"><?php echo $value['lcr_ponumber']; ?></td>
                                                <td><?php echo $value['proj_name']; ?></td> 
                                                <td class="solutions"><?php echo $value['sol_name']; ?></td>
                                                <td class=" text-right po_value"  id="po_value<?php echo $value['lcr_qid']; ?>"  ><?php echo $value['lcr_povalue']; ?></td>
                                                <td class="po_type">
                                                    <select id="po_type<?php echo $value['lcr_qid']; ?>" disabled="">
                                                        <option value="">--Select--</option>
                                                        <option value="0" <?php echo (0 == $value['lcr_potype'] ) ? 'selected' : ''; ?>>Domestic</option>
                                                        <option value="1" <?php echo (1 == $value['lcr_potype'] ) ? 'selected' : ''; ?>>Import</option>
                                                    </select>                                            
                                                </td>
                                                <td  class="pay_term"   id="pay_term<?php echo $value['lcr_qid']; ?>"><?php echo $value['lcr_payterms']; ?></td>


                                            </tr>
                                            <?php
                                            $total_po += $value['lcr_povalue'];
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>

                                            <td colspan="3" class=" text-right"> 
                                                Total PO Value
                                            </td>
                                            <td id="total_po" class=" text-right"><?php echo $total_po; ?></td>
                                            <td colspan="2"></td>

                                        </tr>
                                    </tfoot>


                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php }
        ?>



        <div class="row" id="project_create">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Validation Form</h4>-->
                        <form class="needs-validation" method="post" action="functions/lc_form" autocomplete="off">
                            <div class="form-row">
                                <div class="col-md-3 mb-3 none">
                                    <label for="segment">Select Credit Period</label>
                                    <select class="custom-select" name="lcm_cpid" id="lcm_cpid"  >
                                        <option value="">--Select Credit Period--</option>
                                        <?php
                                        $result = $cls_lc->credit_period();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['cp_id'] ?>"><?php echo $value['cp_period'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="proj_name">LC Number</label>
                                    <input type="text" class="form-control" id="lc_num" readonly="" name="lc_num" placeholder="LC Number" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>



                                <div class="col-md-3 mb-3">
                                    <label for="proj_shrtname">LC Opening Date</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="icon-calender"></i></span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="lc_date" name="lc_date" required="" placeholder="dd/mmm/yyyy">

                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="start_date">Validity Date</label>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text " class="form-control mydatepicker" id="from_lc" name="from_lc" placeholder="dd/mmm/yyyy"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-info b-0 text-white">TO</span>
                                        </div>
                                        <input type="text" class="form-control mydatepicker" id="to_lc" name="to_lc" placeholder="dd/mmm/yyyy"/>
                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3"></div>
                                <div class="col-md-3 mb-3">
                                    <label for="applicant">Applicant Name</label>
                                    <input type="text" class="form-control" readonly id="applicant"  name="applicant" placeholder="Applicant Name" value="L&T" readonly="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="app_bank">Applicant bank</label>
                                    <select class="custom-select" name="app_bank" id="app_bank" required="" onclick="select_bank(this.value)">
                                        <option value="">--Select applicant bank --</option>
                                        <?php
                                        $result = $cls_lc->select_bank();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['bid'] ?>"><?php echo $value['bank_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="app_address">Applicant bank address</label>
                                    <select class="custom-select" name="app_address" disabled="" id="app_address" >
                                        <option value="">--Select bank address--</option>
                                        <?php
                                        $result = $cls_lc->select_bank();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['bid'] ?>"><?php echo $value['bank_address'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3"></div>
                                <div class="col-md-3 mb-3">
                                    <label for="segment">Beneficiary Name</label>
                                    <select class="custom-select" name="vendor" id="vendor" required="">
                                        <option value="">--Select Beneficiary Name--</option>
                                        <?php
                                        $result = $cls_lc->vendor_select();
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['sup_id'] ?>"><?php echo $value['sup_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="bf_bank">Beneficiary Bank</label>
                                    <input type="text" class="form-control" readonly id="bf_bank"  name="bf_bank" placeholder="Benificiary Bank" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="bf_bank_address">Beneficiary Bank Address</label>
                                    <input type="text" class="form-control" readonly id="bf_bank_address"  name="bf_bank_address" placeholder="Beneficiary Bank Address" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3"></div>

                                <div class="col-md-3 mb-3">
                                    <label for="segment">Select Currency</label>
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
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="lc_value" id="sel_cur"> LC Value</label>
                                    <input type="text" class="form-control" onkeyup="calculate()" id="lc_value" name="lc_value" placeholder="LC Value" value="" onkeypress="return isNumberKey(event)" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="forex">Forex</label>
                                    <input type="text" class="form-control" onkeyup="calculate()" id="forex"  name="forex" placeholder="Forex" value=""  onkeypress="return isNumberKey(event)" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="inr_val">Value in INR</label>
                                    <input type="text" class="form-control" id="inr_val"  name="inr_val" placeholder="Value in INR" value="" readonly="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="inco_terms">Inco Terms</label>
                                    <input type="text" class="form-control" readonly id="inco_terms"  name="inco_terms" placeholder="Inco Terms" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="country">Country Of Supply </label>
                                    <input type="text" class="form-control" readonly id="country"  name="country" placeholder="Country Of Supply" value="" required>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3" >
                                    <br>
                                     <div class="alert alert-danger alert-rounded" id="errordiv" style=" display: none">  
                                                    <i class="fa fa-exclamation-triangle"></i> 
                                                    LC value should be less than Total PO Value
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                                </div>
                                </div>


                            </div>

                            <div class="form-row">                            


                                <input type="hidden" value="" id="lcid" name="lcid">
                                <input type="hidden" value="1" id="page" name="page">
                                <input type="hidden" value="" id="total_poVal" name="total_poVal">
                            </div>  
                            <button   class="btn btn-success" type="submit" id="lcmst_update" name="lcmst_update">Update</button>
                            <!--<button class="btn btn-primary" type="submit" id="lcmst_create" name="lcmst_create">Submit</button>-->
                            <button class="btn btn-warning" type="reset" name="reset">Clear</button>
                            <button class="btn btn-danger" type="button" id="cancelbtn" onclick="cancelproj()" name="cancel_form">Cancel</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- End Row -->
        <div class="form-group row">
            <div class="col-md-12">
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                } else {
                    $msg = '';
                }if ($msg == '0') {
                    ?>
                    <div class="alert alert-danger alert-rounded">  
                        <i class="fa fa-exclamation-triangle"></i> Same LC number already exists 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                <?php } else if ($msg == '1') { ?>
                    <div class="alert alert-danger alert-rounded">  
                        <i class="fa fa-exclamation-triangle"></i> Same LC number does not exists 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    </div>
                <?php }
                ?>
            </div>
        </div>
        <!-- basic table -->
        <div class="row none">
            <div class="col-12 ">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Credit Period</th>
                                        <th>Days Left</th>
                                        <th>LC Number</th>
                                        <th>LC Opening Date</th>
                                        <th>Validity</th>
                                        <th>Applicant name</th>
                                        <th>Applicant bank & address</th>
                                        <th>Beneficiary bank</th>
                                        <th>Beneficiary bank address</th>                                        
                                        <th>LC Value</th>                                      
                                        <th>LC Currency</th>                                      
                                        <th>LC Forex</th>                                      
                                        <th>LC Value in INR</th>                                      
                                        <th>LC Balance</th>                                     
                                        <th>Inco Terms</th>                                     
                                        <th>Country</th>                                     
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_lc->select_lcmaster($vid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td><?php echo $value['sup_name']; ?></td>   
                                            <td><?php echo $value['cp_period']; ?></td>
                                            <td>
                                                <?php
                                                $daycount = $value['validity'];
                                                if ($daycount <= 7) {
                                                    $alert = "";
                                                    $point = "";
                                                } elseif ($daycount > 7) {
                                                    $alert = "greenotify";
                                                    $point = "greenpoint";
                                                }
                                                ?>
                                                <div class="notify pull-left">
                                                    <span class="heartbit <?php echo $alert; ?>"></span>
                                                    <span class="point <?php echo $point ?>" ></span>
                                                </div>
                                                <?php echo $value['validity']; ?>  
                                            </td>
                                            <td id="lcm<?php echo $key; ?>"><?php echo $value['lcm_num']; ?></td>
                                            <td><?php echo formatDate($value['lcm_date'], 'd-M-y'); ?></td>
                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    From:- <?php echo formatDate($value['lcm_from'], 'd-M-y'); ?>
                                                </span>
                                                <span class="badge badge-pill badge-danger font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    To:- <?php echo formatDate($value['lcm_to'], 'd-M-y'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $value['lcm_appname']; ?></td>
                                            <td><?php echo $value['bank_name'] . '-' . $value['bank_address']; ?></td>
                                            <td><?php echo $value['lcm_venbank']; ?></td>
                                            <td><?php echo $value['lcm_venbankaddress']; ?></td>

                                            <td class=" text-right"><?php echo number_format($value['lcm_value'], 2); ?></td>
                                            <td><?php echo $value['currency_hname']; ?></td>
                                            <td><?php echo $value['lcm_forex']; ?></td>
                                            <td><?php echo $value['lcm_valueinr']; ?></td>

                                            <td class=" text-right"><?php echo number_format($value['lcm_balance'], 2); ?></td> 
                                            <td><?php echo $value['lcm_incoterms']; ?></td>
                                            <td><?php echo $value['lcm_country']; ?></td>

                                            <td>
                                                <span class="badge badge-pill badge-danger font-medium text-white ml-1" onclick="changelc('<?php echo $value['lcm_id']; ?>')"    style=" cursor: pointer;" > <i class=" fas fa-pencil-alt"></i></span>
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
                                                        var page = 1;
                                                        changelc(Proid, page);
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
                                                            var total_poVal = +$('#total_poVal').val().replace(/,/g, "");
                                                        var lcid =$('#lcid').val();
                                                         
                                                         
                                                            if(total_poVal < rate_with ){
                                                                 
                                                                    $('#lcmst_update').hide();
                                                                    $('#errordiv').show();

                                                                 
                                                            }else{
                                                                 
                                                                    $('#lcmst_update').show();
                                                                    $('#errordiv').hide();
        
                                                             }
                                                        }
                                                    }

</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 