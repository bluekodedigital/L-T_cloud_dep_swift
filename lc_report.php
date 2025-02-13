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
                <h5 class="font-medium text-uppercase mb-0">LC Report</h5>
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
                        <li class="breadcrumb-item active" aria-current="page">Report</li>
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
                                        <th>LC Number</th>
                                        <th>Vendor</th>
                                        <!--<th>Credit Period</th>-->
                                        <th>Days Left</th>

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

                                        <th>Inco Terms</th>                                     
                                        <th>Country</th>                                     
                                        <th>LC Supply Value</th>                                     
                                        <th>LC Payment Value</th>   
                                        <th>LC Balance</th>    
                                        <th>View</th>    

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_lc->select_lcmaster_report($vid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td id="lcm<?php echo $key; ?>"><?php echo $value['lcm_num']; ?></td>
                                            <td><?php echo $value['sup_name']; ?></td>   
                                            <!--<td><?php // echo $value['cp_period'];    ?></td>-->
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

                                            <td><?php echo date('d-M-y', strtotime($value['lcm_date'])); ?></td>
                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    From:- <?php echo date('d-M-y', strtotime($value['lcm_from'])); ?>
                                                </span>
                                                <span class="badge badge-pill badge-danger font-medium text-white ml-1"  style=" cursor: pointer;" >
                                                    To:- <?php echo date('d-M-y', strtotime($value['lcm_to'])); ?>
                                                </span>
                                            </td>
                                            <td><?php echo $value['lcm_appname']; ?></td>
                                            <td><?php echo $value['bank_name'] . '-' . $value['bank_address']; ?></td>
                                            <td><?php echo $value['lcm_venbank']; ?></td>
                                            <td><?php echo $value['lcm_venbankaddress']; ?></td>

                                            <td class=" text-right"><?php echo number_format($value['lcm_value'], 2); ?></td>
                                            <td><?php echo $value['currency_hname']; ?></td>
                                            <td><?php echo $value['lcm_forex']; ?></td>
                                            <td><?php echo number_format($value['lcm_valueinr'], 2); ?></td>


                                            <td><?php echo $value['lcm_incoterms']; ?></td>
                                            <td><?php echo $value['lcm_country']; ?></td>

                                            <td><?php echo number_format($value['lcm_supplied_value'], 2); ?> </td>
                                            <!--<td><?php // echo number_format($value['lcm_valueinr']- $value['lcm_supply_value'], 2);    ?> </td>-->
                                            <td><?php echo number_format($value['lcm_payment'], 2); ?> </td>
                                            <td class=" text-right"><?php echo number_format($value['lcm_balance'], 2); ?></td> 
                                            <td>
                                                <span onclick="get_lc_history('<?php echo $value['lcm_lcid'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="View Details">
                                                    <i class="fas fa-eye"></i> 
                                                </span>
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
    <!--MOdal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
        <div class="modal-dialog" role="document">
            <div class="modal-content modal_resize" style="width:200% !important; margin-left: -50% !important">
                <div class="modal-header" style="margin-top: 0px;">                          
                    <h4 class="modal-title" id="exampleModalLabel1"><span id="project">LC DETAILS</span>  </h4> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
              

                <div class="modal-body">
                    <div class="row" id="get_lc_history">
                        
                    </div>

                </div>
                <div class="modal-footer">                           
                    
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
                                                window.location.href = "lc_report?vid=" + Proid;
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
                                            function get_lc_history(lc){
                                                  $.post("code/get_lc_history.php", {key: lc}, function (dataa) {
                                                        $('#get_lc_history').html(dataa);
                                                    });
                                            }

</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 