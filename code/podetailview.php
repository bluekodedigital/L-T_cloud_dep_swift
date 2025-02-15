<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
//check custom clearance involved or not
$result = $cls_user->check_cusinvolved($pack_id);
$cus = $result['cm_domestic_import'];
$po_details = $cls_user->get_po_details($pack_id);
$po = json_decode($po_details, true);
foreach ($po as $key => $val) {
    $po_n = $val['po_number'];
}
$pack_name = $cls_user->get_packdetails($pack_id);
$manuclr = $cls_user->manuclr($pack_id);
$insclr = $cls_user->insclr($pack_id);
$mdcclr = $cls_user->mdcclr($pack_id);
$cusclr = $cls_user->cusclr($pack_id);
$mtrecvclr = $cls_user->mtrecvclr($pack_id);
$mrnclr = $cls_user->mrnclr($pack_id);

if ($pack_name['proj_type'] == 1) {
    $ptype = "CO";
    $ptype_col = "type_gr";
} else if ($pack_name['proj_type'] == 2) {
    $ptype = "NCO";
    $ptype_col = "type_or";
} else {
    $ptype = "";
    $ptype_col = "";
}
?>

<style>
    .table1{
        width: 150%;
        margin-bottom: 1rem;
        color: #313131;
    } 
    .table1 td {
        padding:5px 0px 0px 18px;    
        vertical-align: top;
        border-top: 1px solid rgba(120,130,140,.13);
    }
    .table1 thead {
        padding:0.3%;
        vertical-align: top;
        border-top: 1px solid rgba(120,130,140,.13);
        background: linear-gradient(to right, #086560 100%, #17ABCC 100%);
        color: #fff;
        
    }
    .table1 td, .table1 th {
        border: 1px solid rgba(8, 8, 8, 0.13);
        font-weight: normal !important;
    

    }
    .table1 td{
        text-align: center;
    }
    .smalltextbox{
        width:50%;

    }
    .smalldate{
        width:50% !important;
        /*        background: #0cc2c4 !important;
                border: none !important;
                outline: none !important;
                padding: Opx Opx Opx Opx !important;*/

    }
    /*    .smalldate{
            width:70%;
        }*/
    .s_icon{
        margin-top: 6%;
        margin-bottom: 0%;
    }
     .valign{
        position: relative;
        bottom: -12px;
    }
</style>

<div class="modal-header">
    <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6> 
    <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; "><?php echo $pack_name['proj_name']; ?>asa
    <?php  if($pack_name['proj_type'] !=''){  ?> 
            <span class="blink">
            <span class='type_sty <?php echo $ptype_col; ?>'> <?php echo $ptype; ?> </span>
            <!-- <img src="assets/images/tradeicon/Trademark-Symbol-Icon.jpg" alt="user" class="rounded-circle" width="25"> -->
        </span>
        <?php  } ?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
</h3>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <input type="hidden" id="cus" value="<?php echo $cus; ?>">
    <?php if ($cus ==1) { ?>
        <div class="table-responsive" style="height:500px">
            <table class="table1   compact" id="modeltable">
                <thead class="bg-info text-white">
                        <tr>
                        <th rowspan="2" colspan="5" valign="center" style=" background-color:goldenrod;width: 17%;"><span class="valign"><?php echo $pack_name['pm_packagename']; ?></span></th>
                        <th colspan="16">Po Number: <?php echo $po_n; ?></th>
                    </tr>

                    <tr>
                        <th class=" bg-primary"> <span class="badge badge-pill  font-12 bold m1 " >Plan: <?php echo date('d-M-y', strtotime($manuclr['planned'])); ?></span></th>
                        <th class=" bg-primary"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($manuclr['expected']==''){ echo date('d-M-y');}else{echo date('d-M-y', strtotime($manuclr['expected']));} ?></span></th>
                        <th class=" bg-success"> <span class="badge badge-pill   font-12 text-white ml-1">Plan: <?php echo date('d-M-y', strtotime($insclr['planned'])); ?></span></th>
                        <th class=" bg-success"> <span class="badge badge-pill   font-12 text-white ml-1">Exp:<?php if($insclr['expected']==''){ echo date('d-M-y'); }else{ echo date('d-M-y', strtotime($insclr['expected']));} ?></span></th>
                        <th class=" bg-cyan"> <span class="badge badge-pill   font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mdcclr['planned'])); ?></span></th>
                        <th class=" bg-cyan"> <span class="badge badge-pill  font-12 text-white ml-1">Exp:<?php if($mdcclr['expected']==''){echo date('d-M-y');}else{ echo date('d-M-y', strtotime($mdcclr['expected']));} ?></span></th>
                        <th class=" bg-secondary"> <span class="badge badge-pill   font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($cusclr['planned'])); ?></span></th>
                        <th class=" bg-secondary"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($cusclr['expected']==''){ echo date('d-M-y');}else{ echo date('d-M-y', strtotime($cusclr['expected']));} ?></span></th>
                        <th class=" bg-warning"> <span class="badge badge-pill  font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mtrecvclr['planned'])); ?></span></th>
                        <th class=" bg-warning"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($mtrecvclr['expected']==''){echo date('d-M-y');} else{echo date('d-M-y', strtotime($mtrecvclr['expected']));} ?></span></th>
                        <th class=" orange"> <span class="badge badge-pill   font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mrnclr['planned'])); ?></span></th>
                        <th class=" orange"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($mrnclr['expected']==''){echo date('d-M-y');}else{ echo date('d-M-y', strtotime($mrnclr['expected']));} ?></span></th>

                    </tr>
                    <tr>
                        <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">S.No</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;" ><span class="valign">Description</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;" ><span class="valign">Po Qty</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">Bal Qty</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">View</span></th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-primary">Manufacturing Clear Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-success">Inspection Qty</th>                        
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class="bg-cyan">MDCC Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-secondary">Custom Clear Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-warning">Mat Rec Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" orange">MRN Details</th>
                    </tr>
                    <tr>

                        <th   style="text-align: center;" class=" bg-primary"><span class="badge badge-pill   font-12 text-white ml-1  ">Qty</span </th>
                        <th  style="text-align: center;" class=" bg-primary"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" bg-success"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class=" bg-success"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class="bg-cyan"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class="bg-cyan"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" bg-secondary"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class=" bg-secondary"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" bg-warning"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class=" bg-warning"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" orange">MRN No. </th>
                        <th  style="text-align: center;" class=" orange">Date </th>

                    </tr>
                </thead>
                <tbody class="border border-info">
                    <?php foreach ($po as $key => $value) {
                        $value['swid'] = $value['po_id']; ?>                        
                        <tr>
                            <td><?php echo $key + 1; ?></td>                                
                            <td>
                                <?php if (strlen($value['po_mat_desc']) < 30) { ?>
                                    <span class="font-14" id="po_mat_desc"><?php echo wordwrap($value['po_mat_desc'], 30, "<br>\n"); ?></span>
                                <?php } else { ?>
                                    <span id="less<?php echo $key . 'pm'; ?>" class="  font-14 lessshow" style=" cursor: pointer;"><span style="font-weight: bolder"> </span> <?php echo substr(wordwrap($value['po_mat_desc'], 20, "<br>\n"), 0, 40) . '....'; ?></span>
                                    <span id="moreew<?php echo $key . 'pm'; ?>" class=" font-14 allshow" style=" cursor: pointer; display: none"><span style="font-weight: bolder"></span> <?php echo wordwrap($value['po_mat_desc'], 40, "<br>\n"); ?></span>
                                    <span id="rmore<?php echo $key . 'pm'; ?>" class="allshow1" style="color: #007bff;  cursor: pointer;" onclick="readmore('<?php echo $key . 'pm'; ?>')">Read more</span>
                                    <span id="rless<?php echo $key . 'pm'; ?>" class="lessshow1" style="color: #007bff; cursor: pointer; display: none;" onclick="readless('<?php echo $key . 'pm'; ?>')">Read Less</span>
                                <?php } ?>
                            </td>
                            <td style="text-align: center;"><?php echo $value['po_scope_qty']; ?></td>
                            <td style="text-align: center;"><?php echo $value['bal_qty']; ?></td>
                           <td style=" text-align: center;"><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" onclick="pohistoryview('<?php echo $value['swid']; ?>','<?php echo $value['swe_qte']; ?>')" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                           
                            <td style="text-align: center;"><?php echo $value['mqty']; ?></td>
                            <td><?php if($value['mqty_date']==''){}else {echo date('d-M-y',strtotime($value['mqty_date'])); } ?></td> 
                            
                            <td style="text-align: center;"><?php echo $value['iqty']; ?></td> 
                            <td><?php if($value['iqty_date']==''){}else {echo date('d-M-y',strtotime($value['iqty_date']));} ?> </td>
                           
                            <td style="text-align: center;"><?php echo $value['mdccqty']; ?></td>
                            <td><?php if($value['mdccqty_date']==''){}else {echo date('d-M-y',strtotime($value['mdccqty_date'])); }?></td>
                            
                            <td style="text-align: center;"> <?php echo $value['cclr_qty']; ?></td>
                            <td><?php if($value['cclr_qty_date']==''){}else {echo date('d-M-y',strtotime($value['cclr_qty_date'])); }?></td>
                            
                            <td style="text-align: center;"><?php echo $value['mrqty']; ?></td>
                            <td><?php if($value['mrqty_date']==''){}else {echo date('d-M-y',strtotime($value['mrqty_date']));} ?></td>
                            
                            <td><?php echo $value['mrn_num']; ?></td>
                            <td><?php if($value['mrn_date']==''){}else {echo date('d-M-y',strtotime($value['mrn_date']));} ?></td>
                        
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else if ($cus == 0) { ?>
        <div class="table-responsive" style="height:500px">
            <table class="table1   compact" id="modeltable">
                <thead class="bg-info text-white">
                  <tr>
                        <th rowspan="2" colspan="5" style=" background-color:goldenrod;width: 17%;"><span class="valign"><?php echo $pack_name['pm_packagename']; ?></span></th>
                        <th colspan="10">Po Number: <?php echo $po_n; ?></th>
                    </tr>


                    <tr>

                        <th style="text-align:center" class=" bg-primary"> <span class="badge badge-pill   font-12 text-white ml-1">Plan: <?php echo date('d-M-y', strtotime($manuclr['planned'])); ?></span></th>
                        <th style="text-align:center" class=" bg-primary"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($manuclr['expected']==''){ echo date('d-M-y');}else{echo date('d-M-y', strtotime($manuclr['expected']));} ?></span></th>
                        <th style="text-align:center" class=" bg-success"> <span class="badge badge-pill   font-12 text-white ml-1">Plan: <?php  echo date('d-M-y', strtotime($insclr['planned'])); ?></span></th>
                        <th class=" bg-success"> <span class="badge badge-pill   font-12 text-white ml-1">Exp:<?php if($insclr['expected']==''){ echo date('d-M-y'); }else{ echo date('d-M-y', strtotime($insclr['expected']));} ?></span></th>
                        <th style="text-align:center" class=" bg-cyan"> <span class="badge badge-pill   font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mdcclr['planned'])); ?></span></th>
                        <th class=" bg-cyan"> <span class="badge badge-pill  font-12 text-white ml-1">Exp:<?php if($mdcclr['expected']==''){echo date('d-M-y');}else{ echo date('d-M-y', strtotime($mdcclr['expected']));} ?></span></th>
                        <th style="text-align:center"  class=" bg-warning"> <span class="badge badge-pill  font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mtrecvclr['planned'])); ?></span></th>
                        <th class=" bg-warning"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($mtrecvclr['expected']==''){echo date('d-M-y');} else{echo date('d-M-y', strtotime($mtrecvclr['expected']));} ?></span></th>
                        <th style="text-align:center"  class=" orange"> <span class="badge badge-pill   font-12 text-white ml-1">Plan:<?php echo date('d-M-y', strtotime($mrnclr['planned'])); ?></span></th>
                        <th class=" orange"> <span class="badge badge-pill   font-12 text-white ml-1">Exp: <?php if($mrnclr['expected']==''){echo date('d-M-y');}else{ echo date('d-M-y', strtotime($mrnclr['expected']));} ?></span></th>

                    </tr>
                    <tr>
                        <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">S.No</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;" ><span class="valign">Description</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;" ><span class="valign">Po Qty</span></th>
                        <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">Bal Qty</span></th>
                           <th rowspan="2" style=" background-color:goldenrod;"><span class="valign">View</span></th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-primary">Manufacturing Clear Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-success">Inspection Qty</th>                        
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" bg-cyan">MDCC Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;"  class=" bg-warning">Mat Rec Qty</th>
                        <th colspan="2" style="text-align:center;font-weight: 600 !important;" class=" orange">MRN Details</th>
                    </tr>
                    <tr>

                        <th   style="text-align: center;" class=" bg-primary"><span class="badge badge-pill   font-12 text-white ml-1">Qty</span </th>
                        <th  style="text-align: center;" class=" bg-primary"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" bg-success"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class=" bg-success"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" bg-cyan"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;" class=" bg-cyan"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;"  class=" bg-warning"><span class="badge badge-pill   font-12 text-white ml-1">Qty </span</th>
                        <th  style="text-align: center;"  class=" bg-warning"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>
                        <th  style="text-align: center;" class=" orange"><span class="badge badge-pill   font-12 text-white ml-1">MRN No. </span</th>
                        <th  style="text-align: center;" class=" orange"><span class="badge badge-pill   font-12 text-white ml-1">Actual Dates</span</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($po as $key => $value) { ?>   
                    <tr class="border border-info">
                            <td><?php echo $key + 1; ?></td>                                 
                            <td><?php echo $value['sdesc']; ?></td>
                            <td style=" text-align: center;"><?php echo $value['po_scope_qty']; ?></td>
                            <td style=" text-align: center; "><?php echo $value['bal_qty']; ?></td>
                             <td style=" text-align: center;"><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" onclick="pohistoryview('<?php echo $value['swid']; ?>','<?php echo $value['swe_qte']; ?>')" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                           
                            <td><?php echo $value['mqty']; ?> </td>
                            <td><?php if($value['mqty_date']==''){}else {echo date('d-M-y',strtotime($value['mqty_date'])); } ?></td> 
                            
                            <td><?php echo $value['iqty']; ?></td> 
                            <td><?php if($value['iqty_date']==''){}else {echo date('d-M-y',strtotime($value['iqty_date']));} ?></td>
                           
                            <td><?php echo $value['mdccqty']; ?></td>
                            <td><?php if($value['mdccqty_date']==''){}else {echo date('d-M-y',strtotime($value['mdccqty_date'])); }?></td>
                            
                            <td><?php echo $value['mrqty']; ?></td>
                            <td><?php if($value['mrqty_date']==''){}else {echo date('d-M-y',strtotime($value['mrqty_date']));} ?></td>
                            
                            <td><?php echo $value['mrn_num']; ?></td>
                            <td><?php if($value['mrn_date']==''){}else {echo date('d-M-y',strtotime($value['mrn_date']));} ?></td>
                        
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php }
    ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
</div>


<script>
    // Date Picker
    var date = new Date();
    date.setDate(date.getDate());
    jQuery('.mydatepicker, #datepicker, .input-group.date').datepicker({
        format: 'dd-M-yy',
       
        orientation: 'bottom',

    });
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range,#date-range1').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
</script>

<script src="code/js/technical.js" type="text/javascript"></script>