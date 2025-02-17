<?php
include 'config/inc.php';
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

    #zero_config th,td {
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
                <h5 class="font-medium text-uppercase mb-0">LC Creation</h5>
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
                        <li class="breadcrumb-item active" aria-current="page">LC Creation</li>
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

                        <div class="form-row">
                            <div class="col-md-3 mb-3"></div>

                            <div class="col-md-3 mb-3">
                                <label for="m_project">Project</label>
                                <select class="custom-select" name="m_project" id="m_project" required="" >
                                    <option value="">--Select Project --</option>
                                    <?php
                                    $result = $cls_comm->select_allprojects();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['proj_id'] ?>" name="<?php echo $value['proj_name'] ?>"><?php echo $value['proj_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">

                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="m_package">Package</label>
                                <input type="text" list="browsers" class="form-control" id="m_package"  name="m_package" placeholder="Package" value="" required>
                                <datalist id="browsers">
                                    <?php
                                    $result = $cls_lc->select_package();
                                    $res = json_decode($result, true);
                                    //echo $res['proj_id'];
                                    foreach ($res as $key => $values) {
                                        ?>
                                        <option value="<?php echo $values['sol_name']; ?>"></option>
                                    <?php } ?>
                                </datalist>
                            </div>
                            <div class="col-md-3 mb-3">

                                <button class="btn btn-primary"   style=" margin-top: 10%;" type="button" id="m_add" onclick="manual_add()" name="m_add">ADD</button>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered  ">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>PO Number</th>
                                        <th>Projects</th>
                                        <th>Package Name</th>
                                        <th>PO Value</th>
                                        <th>PO Type</th>
                                        <th>Pay Terms in days</th>

                                    </tr>
                                </thead>
                                <tbody id="zerobody" >
                                    <?php
                                    $total_po = 0;
                                    $result = $cls_lc->select_lc_creation($vid);
//                                    $result = $cls_lc->select_lc($vid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $sr_id = $key + 1;
                                        ?>


                                        </select>

                                        <tr class="ty">
                                            <td>
                                                <div class="custom-control custom-checkbox ">
                                                    <input type="checkbox" class="custom-control-input" value="<?php echo $sr_id; ?>"    id="customCheck<?php echo $sr_id; ?>">
                                                    <label class="custom-control-label cpointer" for="customCheck<?php echo $sr_id; ?>" onclick="enable_cell('<?php echo $sr_id; ?>')"> </label>
                                                </div>
                                            </td>
                                            <td class="po_number"   id="po_number<?php echo $sr_id; ?>"></td>
                                            <td><?php echo $value['proj_name']; ?></td> 
                                            <td class="solutions"><?php echo $value['sol_name']; ?>
                                                <input type="hidden" id="packid<?php echo $sr_id; ?>" value="<?php echo $value['vq_solid']; ?>">
                                                <input type="hidden" id="projectid<?php echo $sr_id; ?>" value="<?php echo $value['proj_id']; ?>"> 
                                                <input type="hidden" class="quoteid" value="<?php echo $sr_id; ?>"> 

                                            </td>
                                            <td class=" text-right po_value"  id="po_value<?php echo $sr_id; ?>" onkeyup="cal_total_po('<?php echo $sr_id; ?>')" onkeypress="return isNumberKey(event)"><?php echo $value['po_value']; ?></td>
                                            <td class="po_type">
                                                <select id="po_type<?php echo $sr_id; ?>" disabled="">
                                                    <option value="">--Select--</option>
                                                    <option value="0">Domestic</option>
                                                    <option value="1">Import</option>
                                                </select>                                            
                                            </td>
                                            <td  class="pay_term" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  id="pay_term<?php echo $sr_id; ?>"><?php // echo wordwrap($value['vqd_paytrm'], "<br>\n");                         ?></td>


                                        </tr>
                                        <?php
                                        $total_po += $value['po_value'];
                                    }
                                    ?>


                                </tbody>

                                <tfoot>
                                    <tr>

                                        <td colspan="4" class=" text-right"> 
                                            Total PO Value
                                        </td>
                                        <td id="total_po" class=" text-right bg-lc">


                                        <td colspan="2" class=" text-right"> 
                                            <input type="hidden" id="po_total" value="0">
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="7" class=" text-right"> 
                                            <button class=" btn btn-github" id="save_lcreation" style="margin:5px;" onclick="save_lcreation()"> Link Selected PO/LOI to LC </button> 
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

        <?php
        if ($vid != "") {
            $result = $cls_lc->select_created_pos($vid);
            $res = json_decode($result, true);
            $rcount = sizeof($res);
            if ($rcount > 0) {
                ?>
                <div class="row" id="po_details">

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                                    <h5 class="font-medium text-uppercase mb-0">PO Mapped Details</h5>
                                </div>
                                <hr>
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
                <?php
            }
        }
        ?>
        <?php
        if ($vid != "") {
            $result = $cls_lc->select_lcmaster_report_das($vid);
            $res = json_decode($result, true);
            $nCount = sizeof($res);
            if ($nCount > 0) {
                ?> 

                <div class="row">
                    <div class="col-12 ">
                        <div class="material-card card">
                            <div class="card-body">
                                <a href="lc_master.php?vid=<?php echo $vid; ?>"> <button class=" btn btn-info pull-right"  > Extend LC</button> </a>
                                <br><div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                                    <h5 class="font-medium text-uppercase mb-0">LC Details</h5>
                                </div>
                                <hr>
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
                                                <th>LC Supply Value</th>                                     
                                                <th>LC Payment Value</th>                                     

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
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
                                                    <td><?php echo number_format($value['lcm_valueinr'], 2); ?></td>

                                                    <td class=" text-right"><?php echo number_format($value['lcm_balance'], 2); ?></td> 
                                                    <td><?php echo $value['lcm_incoterms']; ?></td>
                                                    <td><?php echo $value['lcm_country']; ?></td>

                                                    <td><?php echo number_format($value['lcm_supply_value'], 2); ?> </td>
                                                    <td><?php echo number_format($value['lcm_payment'], 2); ?> </td>

                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        <?php } ?>

    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/technical.js" type="text/javascript"></script>
<script src="code/js/lc_rpa.js" type="text/javascript"></script>
<script>
                                                function enable_cell(id) {

                                                    if (!$('input#customCheck' + id).is(':checked')) {

                                                        $('#po_number' + id).addClass('bg-lc');
                                                        $('#po_number' + id).attr('contenteditable', true);
                                                        $('#po_value' + id).addClass('bg-lc');
                                                        $('#po_value' + id).attr('contenteditable', true);
                                                        $('#po_type' + id).attr('disabled', false);
                                                        $('#pay_term' + id).addClass('bg-lc');
                                                        $('#pay_term' + id).attr('contenteditable', true);

                                                        total_po(id);

                                                    } else {
                                                        $('#po_number' + id).removeClass('bg-lc');
                                                        $('#po_number' + id).attr('contenteditable', false);
                                                        $('#po_value' + id).removeClass('bg-lc');
                                                        $('#po_value' + id).attr('contenteditable', false);
                                                        $('#po_type' + id).attr('disabled', true);
                                                        $('#pay_term' + id).removeClass('bg-lc');
                                                        $('#pay_term' + id).attr('contenteditable', false);
                                                        total_po_minus(id);


                                                    }

                                                }
                                                function total_po(id) {


                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#po_value' + id).text();


                                                    var total_po = po_total + po_value;

                                                    $('#total_po').text(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function total_po_minus(id) {


                                                    var po_total = +$('#po_total').val();
                                                    var po_value = +$('#po_value' + id).text();


                                                    var total_po = po_total - po_value;

                                                    $('#total_po').text(total_po.toFixed(2));
                                                    $('#po_total').val(total_po);
                                                }
                                                function cal_total_po() {
                                                    var j = 0;

                                                    var quoteid = new Array();
                                                    var po_value = new Array();


                                                    $('#zero_config tr.ty').each(function () {
                                                        quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                        if ($('input#customCheck' + quoteid[j]).is(':checked')) {

                                                            po_value[j] = +$(this).find('td#po_value' + quoteid[j]).text();


                                                        }
                                                        j++;
                                                    });
                                                    var total = 0;
                                                    for (var i = 0; i < po_value.length; i++) {
                                                        total += po_value[i] << 0;
                                                    }
                                                    $('#total_po').text(total.toFixed(2));
                                                    $('#po_total').val(total);
                                                }

                                                function swift_proj(Proid) {
                                                    window.location.href = "lc_creation?vid=" + Proid;
                                                }
                                                function save_lcreation() {
                                                    var IDs = new Array();
                                                    var vid = $('#vendor').val();
                                                    var total_po = +$('#total_po').text();
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

                                                        $('#zero_config tr.ty').each(function () {
                                                            quoteid[j] = +$(this).find('td.solutions .quoteid').val();
                                                            if ($('input#customCheck' + quoteid[j]).is(':checked')) {
                                                                po_number[j] = $(this).find('td#po_number' + quoteid[j]).text();
                                                                po_value[j] = +$(this).find('td#po_value' + quoteid[j]).text();
                                                                po_type[j] = +$(this).find('td.po_type #po_type' + quoteid[j] + ' option:selected ').val();
                                                                pay_term[j] = +$(this).find('td#pay_term' + quoteid[j]).text();
                                                                project[j] = +$(this).find('td.solutions #projectid' + quoteid[j]).val();
                                                                package[j] = +$(this).find('td.solutions #packid' + quoteid[j]).val();
                                                                sel_quote[j] = quoteid[j];

                                                            }
                                                            j++;
                                                        });
                                                        $('#save_lcreation').hide();
                                                        $('#saving_lcreation').show();

                                                        $.post("code/save_lcreation.php", {key: sel_quote, po_number: po_number, po_value: po_value, po_type: po_type, pay_term: pay_term, project: project, package: package, vid: vid, total_po: total_po}, function (dataa) {
                                                            if ($.trim(dataa) == 1) {
                                                                $('#save_lcreation').hide();
                                                                $('#redirecting').show();
                                                                $('#saving_lcreation').hide();
                                                                setTimeout(
                                                                        function ()
                                                                        {

                                                                            $('#redirecting').hide();
                                                                            window.location.href = 'lc_master?vid=' + vid;

                                                                        }, 5000);



                                                            } else {
                                                                alert('Something went wrong!!!');
                                                                $('#save_lcreation').show();
                                                                $('#saving_lcreation').hide();
                                                            }
                                                        });


                                                    }
                                                }
                                                function manual_add() {
                                                    var projid = $('#m_project').val();
                                                    var m_package = $('#m_package').val();
                                                    var proj_name = $('#m_project').find('option:selected').attr("name");
                                                    if (projid == "") {
                                                        alert('Please select Project');
                                                    } else if (m_package == "") {
                                                        alert('Please select Package');
                                                    } else {
                                                        $.post("code/package_manual_add.php", {projid: projid, m_package: m_package}, function (data) {
//                                                            if ($.trim(data) == 2) {
//                                                                alert("Same Packgename already exits in master for this project");
//                                                            }
                                                            if ($.trim(data) == 0) {
                                                                alert("Something went wrong");
                                                            } else {
                                                                append_table(projid, m_package, proj_name, data);
                                                            }
                                                        });
                                                    }


                                                }
                                                function append_table(projid, m_package, proj_name, sol_id) {
                                                    var Count = $('#zero_config tr').length;
                                                    var rowCount = Count - 2;
                                                    var html = '<tr class="ty"><td><div class="custom-control custom-checkbox "><input type="checkbox" class="custom-control-input" value="' + rowCount + '"    id="customCheck' + rowCount + '"><label class="custom-control-label cpointer" for="customCheck' + rowCount + '" onclick="enable_cell(' + rowCount + ')"> </label></div></td>\n\
                                                                <td class="po_number"   id="po_number' + rowCount + '"></td>\n\
                                                                <td>' + proj_name + '</td>\n\
                                                                <td class="solutions">' + m_package + ' <input type="hidden" id="packid' + rowCount + '" value="' + sol_id + '"><input type="hidden" id="projectid' + rowCount + '" value="' + projid + '"><input type="hidden" class="quoteid" value="' + rowCount + '"></td>\n\
                                                                <td class=" text-right po_value"  id="po_value' + rowCount + '" onkeyup="cal_total_po(' + rowCount + ')" onkeypress="return isNumberKey(event)"></td>\n\
                                                                <td class="po_type"><select id="po_type' + rowCount + '" disabled=""><option value="">--Select--</option><option value="0">Domestic</option><option value="1">Import</option></td>\n\
                                                                <td class="pay_term" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  id="pay_term' + rowCount + '"></td>\n\
                                                                </tr>';
                                                    $('#zerobody').append(html);
                                                    $('#m_project').val('');
                                                    $('#m_package').val('');
                                                }

</script>


<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 