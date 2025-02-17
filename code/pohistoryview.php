<?php
include_once("../config/inc_function.php");
$rowid = $_POST['rowid'];
$packid = $_POST['packid'];
//$result = $cls_comm->itemname($rowid);
$result = $cls_comm->po_master($rowid);
$name = $result['po_mat_desc'];
$code = $result['po_mat_code'];
?>
<center>

    <span class=" badge badge-pill badge-primary orange font-16"><?php echo $code; ?></span>
    <br>
    <?php if (strlen($name) < 50) { ?>
        <span class="font-14" id="po_mat_desc"><?php echo wordwrap($name, 50, "<br>\n"); ?></span>
    <?php } else { ?>
        <span id="less<?php echo $key . 'pm'; ?>" class="  font-14 lessshow" style=" cursor: pointer;"><span style="font-weight: bolder"> </span> <?php echo substr(wordwrap($name, 50, "<br>\n"), 0, 70) . '....'; ?></span>
        <span id="moreew<?php echo $key . 'pm'; ?>" class=" font-14 allshow" style=" cursor: pointer; display: none"><span style="font-weight: bolder"></span> <?php echo wordwrap($name, 80, "<br>\n"); ?></span>
        <span id="rmore<?php echo $key . 'pm'; ?>" class="allshow1" style="color: #007bff;  cursor: pointer;" onclick="readmore('<?php echo $key . 'pm'; ?>')">Read more</span>
        <span id="rless<?php echo $key . 'pm'; ?>" class="lessshow1" style="color: #007bff; cursor: pointer; display: none;" onclick="readless('<?php echo $key . 'pm'; ?>')">Read Less</span>
    <?php } ?>


</center>
<br>
<table class="table table-bordered display compact" id="modeltable">
    <thead class="bg-info text-white">
        <tr>
            <th>SI.No</th>
            <th>Actions</th>
            <th>Qty</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody class="border border-info">
        <?php
        // $sql = "SELECT * FROM swift_poentryhistory where swhid='$rowid' AND swh_qte='$packid'";
        $sql = "select disorder,actions,SUM(h_qty) as h_qty,CAST(e_date AS DATE) as e_date from swift_poentryhistory  where swhid='$rowid' AND swh_qte='$packid' and actions not in ('Mrn') GROUP BY CAST(e_date AS DATE),actions,disorder order by disorder ASC";
        $query = mssql_query($sql);
        $i = 0;
        //        echo $sql;
        while ($row = mssql_fetch_array($query)) {
            $i = $i + 1;
            $actions = $row['actions'];
            $qty = $row['h_qty'];
            $date = $row['e_date'];
            $date = formatDate($date, 'd-M-y');
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $actions; ?></td>
                <td><?php echo $qty; ?></td>
                <td><?php echo $date; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>