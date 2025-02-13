<?php
include_once("../config/inc_function.php");
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
<style>
    .table1 {
        width: 100%;
        margin-bottom: 1rem;
        color: #313131;
    }

    .table1 td {
        padding: 5px 0px 0px 18px;
        vertical-align: top;
        border-top: 1px solid rgba(120, 130, 140, .13);


    }

    .table1 thead {
        padding: 0.3%;
        vertical-align: top;
        border-top: 1px solid rgba(120, 130, 140, .13);
        background: linear-gradient(to right, #0bc3c3 10%, #17ABCC 70%);
        color: #fff;
    }

    .table1 td,
    .table1 th {
        border: 1px solid rgba(8, 8, 8, 0.13);
    }
</style>
<div class="modal-header">
    <h6 class="modal-title" id="myLargeModalLabel">PO Details Entry</h6>
    <h3 style=" margin-left:35%; font-size: 16px; text-transform: uppercase; "><?php echo $pack_name['proj_name']; ?></h3>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <input type="hidden" id="cus" value="<?php echo $cus; ?>">

    <div class="table-responsive" style="height:500px;">
        <table class="table1 table-bordered display compact" id="modeltable" style="width:100%;">
            <thead class="bg-info text-white">
                <tr>
                    <th colspan="3">Package: <?php echo $pack_name['pm_packagename']; ?></th>
                    <th colspan="3">Po Number: <?php echo $po_n; ?></th>
                </tr>
                <tr>
                    <th>S.No</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Rate</th>
                    <th>Po Qty</th>

                </tr>
            </thead>
            <tbody class="border border-info">
                <?php foreach ($po as $key => $value) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td id="p_num<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'p_num', '<?php echo $value['swid']; ?>')"><?php echo $value['po_mat_code']; ?></td>
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
                        <td><?php echo $value['po_rate']; ?></td>
                        <td style=" text-align: center;"><?php echo $value['po_scope_qty']; ?></td>
                        <!-- <td style=" text-align: center;"><span class=" badge badge-danger" style=" cursor: pointer;" onclick="remove_po('<?php echo $value['swid']; ?>',<?php echo $pack_id; ?>)"><i class="fas fa-trash"></i></span></td> -->
                        <!--                            <td style=" text-align: center;"><label class="badge badge-pill badge-info font-medium text-white ml-1 pull-left" onclick="pohistoryview('<?php echo $value['swid']; ?>','<?php echo $value['swe_qte']; ?>')" data-toggle="modal" data-target="#myModal1"><i  class=" fa fa-eye"></i></label></td>
                        <td style=" text-align: center;" id="mqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mqty']; ?></td>
                        <td style=" text-align: center;" id="iqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'iqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['iqty']; ?></td>
                        <td style=" text-align: center;" id="mdccqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mdccqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mdccqty']; ?></td>
                        <td style=" text-align: center;" id="cclr_qty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'cclr_qty', '<?php echo $value['swid']; ?>')" ><?php echo $value['cclr_qty']; ?></td>
                        <td style=" text-align: center;" id="mrqty<?php echo $value['swid']; ?>" onkeyup="po_detail_save('<?php echo $qid; ?>', 'mrqty', '<?php echo $value['swid']; ?>')" ><?php echo $value['mrqty']; ?></td>
                        -->
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
</div>