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
?>
<div class="modal-header">
    <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6> 
    <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; "><?php echo $pack_name['proj_name']; ?></h3>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <input type="hidden" id="cus" value="<?php echo $cus; ?>">
    <?php if ($cus == 1) { ?>
        <div class="table-responsive" style="height:500px">
            <table class="table table-bordered display compact" id="modeltable">
                <thead class="bg-info text-white">
                    <tr>
                        <th colspan="6">Package: <?php echo $pack_name['pm_packagename']; ?></th>
                        <th colspan="5">Po Number: <?php echo $po_n; ?></th>
                    </tr>
                    <tr>
                        <th>S.No</th>
                        <th>Item Code</th>
                        <th>Description</th>                      
                        <th>Rate</th>
                        <th>Po Qty</th>
                        <th>View</th>
                        <th>Manufacture Clear Qty</th>
                        <th>Ins Qty</th>
                        <th>MDCC Qty</th>
                        <th>Custom Clr. Qty</th>
                        <th>Mat Rec Qty</th>
                    </tr>
                </thead>
                <tbody class="border border-info">
                    <?php foreach ($po as $key => $value) { ?>                        
                        <tr>
                            <td><?php echo $key + 1; ?></td>                                
                            <td  id="p_num<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'p_num', '<?php echo $value['swid']; ?>')"><?php echo $value['sdesc']; ?></td>
                            <td><?php echo $value['itemcode']; ?></td>
                            <td><?php echo $value['srate']; ?></td>
                            <td style=" text-align: center;"><?php echo $value['sqty']; ?></td>
                            <td style=" text-align: center;"><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" onclick="pohistoryview('<?php echo $value['swid']; ?>','<?php echo $value['swe_qte']; ?>')" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                            <td style=" text-align: center;" id="mqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mqty']; ?></td>
                            <td style=" text-align: center;" id="iqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'iqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['iqty']; ?></td>
                            <td style=" text-align: center;" id="mdccqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mdccqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mdccqty']; ?></td>
                            <td style=" text-align: center;" id="cclr_qty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'cclr_qty', '<?php echo $value['swid']; ?>')" ><?php echo $value['cclr_qty']; ?></td>
                            <td style=" text-align: center;" id="mrqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mrqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mrqty']; ?></td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } else if ($cus == 0) { ?>
        <div class="table-responsive" style="height:500px">
            <table class="table table-bordered display compact" id="modeltable">
                <thead class="bg-info text-white">
                    <tr>
                        <th colspan="6">Package name Name</th>
                        <th colspan="5">Po Number</th>
                    </tr>
                    <tr>
                        <th>S.No</th>
                        <th>Item Code</th>
                        <th>Description</th>                      
                        <th>Rate</th>
                        <th>Po Qty</th>
                        <th>View</th>
                        <th>Manufacture Clear Qty</th>
                        <th>Ins Qty</th>                        
                        <th>MDCC Qty</th>
                        <th>Mat Rec Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($po as $key => $value) { ?>                        

                         <tr>
                                <td><?php echo $key + 1; ?></td>                                 
                                <td  id="p_num<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'p_num', '<?php echo $value['swid']; ?>')"><?php echo $value['sdesc']; ?></td>
                                <td><?php echo $value['itemcode']; ?></td>
                                <td><?php echo $value['srate']; ?></td>
                                <td style=" text-align: center;"><?php echo $value['sqty']; ?></td>
                                <td style=" text-align: center;"><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" onclick="pohistoryview('<?php echo $value['swid']; ?>','<?php echo $value['swe_qte']; ?>')" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                                <td style=" text-align: center;" id="mqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mqty']; ?></td>
                                <td style=" text-align: center;" id="iqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'iqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['iqty']; ?></td>
                                <td style=" text-align: center;" id="mdccqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mdccqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mdccqty']; ?></td>
                                <td style=" text-align: center;" id="mrqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mrqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mrqty']; ?></td>
                            </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    <?php }
    ?>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
</div>
