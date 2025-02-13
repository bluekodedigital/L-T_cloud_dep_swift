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
$pack_name=$cls_user->get_packdetails($pack_id);
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
                        <th colspan="4">Package: <?php echo $pack_name['pm_packagename']; ?></th>
                        <th colspan="5">Po Number: <?php echo $po_n; ?></th>
                    </tr>
                    <tr>
                        <th>S.No</th>
                        <th>Description</th>
                        <th>Po Qty</th>
                        <th>Bal Qty</th>
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
                            <td><?php echo $value['sdesc']; ?></td>
                            <td style=" text-align: center;"><?php echo $value['sqty']; ?></td>
                            <td style=" text-align: center;"><?php echo $value['bal_qty']; ?></td>
                            <td style=" text-align: center;"><input type="text" id="mqty<?php echo $value['swid']; ?>" class="em0<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mqty', '<?php echo $value['swid']; ?>', event,'1')" contenteditable="true" value="<?php echo $value['mqty']; ?>" ></td>
                            <td style=" text-align: center;"><input type="text" id="iqty<?php echo $value['swid']; ?>" class="em1<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'iqty', '<?php echo $value['swid']; ?>', event,'2')" contenteditable="true" value="<?php echo $value['iqty']; ?>"> </td> 
                            <td style=" text-align: center;"><input type="text"  id="mdccqty<?php echo $value['swid']; ?>" class="em2<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mdccqty', '<?php echo $value['swid']; ?>', event,'3')" contenteditable="true" value="<?php echo $value['mdccqty']; ?>"></td>
                            <td style=" text-align: center;"> <input type="text"  id="cclr_qty<?php echo $value['swid']; ?>" class="em3<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'cclr_qty', '<?php echo $value['swid']; ?>', event,'4')" contenteditable="true" value="<?php echo $value['cclr_qty']; ?>"></td>
                            <td style=" text-align: center;"><input type="text" id="mrqty<?php echo $value['swid']; ?>" class="em4<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mrqty', '<?php echo $value['swid']; ?>', event,'5')" contenteditable="true" value="<?php echo $value['mrqty']; ?>" ></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else if ($cus == 0) { ?>
        <div class="table-responsive" style="height:500px">
            <table class="table table-bordered display compact" id="modeltable">
                <thead class="bg-info text-white">
                    <tr>
                        <th colspan="4">Package: <?php echo $pack_name['pm_packagename']; ?></th>
                        <th colspan="5">Po Number: <?php echo $po_n; ?></th>
                    </tr>
                    <tr>
                        <th>S.No</th>
                        <th>Description</th>
                        <th>Po Qty</th>
                        <th>Bal Qty</th>
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
                            <td><?php echo $value['sdesc']; ?></td>
                            <td style=" text-align: center;"><?php echo $value['sqty']; ?></td>
                            <td style=" text-align: center; "><?php echo $value['bal_qty']; ?></td>
                            <td style=" text-align: center;"><input type="text" id="mqty<?php echo $value['swid']; ?>" class="em<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mqty', '<?php echo $value['swid']; ?>', event,'1')" contenteditable="true" value="<?php echo $value['mqty']; ?>" ></td>
                            <td style=" text-align: center;"><input type="text" id="iqty<?php echo $value['swid']; ?>" class="em<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'iqty', '<?php echo $value['swid']; ?>', event,'2')" contenteditable="true" value="<?php echo $value['iqty']; ?>"> </td> 
                            <td style=" text-align: center;"><input type="text"  id="mdccqty<?php echo $value['swid']; ?>" class="em<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mdccqty', '<?php echo $value['swid']; ?>', event,'6')" contenteditable="true" value="<?php echo $value['mdccqty']; ?>"></td>
                            <td style=" text-align: center;"><input type="text" id="mrqty<?php echo $value['swid']; ?>" class="em<?php echo $value['swid']; ?>"  onkeyup="po_detail_save('<?php echo $pack_id; ?>', 'mrqty', '<?php echo $value['swid']; ?>', event,'7')" contenteditable="true" value="<?php echo $value['mrqty']; ?>" ></td>
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