<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$current_remarks = $cls_user->op_to_omremarks($pack_id);
?>
<div id="ctocurrentre" >
    <!--<label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="CTO Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $current_remarks['om_remarks']; ?>'});"><i class="fas fa-comment"></i>OPS Remarks</label>-->
<!--    <span id="less" data-toggle="tooltip" data-original-title="OPS Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Remarks:</span> <?php echo substr($current_remarks['om_remarks'], 0, 62) . '....'; ?></span>   
    <span id="moreew" data-toggle="tooltip" data-original-title="OPS Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder"> Remarks:</span> <?php echo $current_remarks['om_remarks']; ?></span>
    <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
    <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>
    -->
    <?php if (strlen($current_remarks['om_remarks'])< 25) { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Ops Remarks:</span> <?php echo $current_remarks['om_remarks']; ?></span>   
    <?php } else { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Ops Remarks:</span> <?php echo substr($current_remarks['om_remarks'], 0, 62) . '....'; ?></span>   
        <span id="moreew" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder"> Ops Remarks:</span> <?php echo $current_remarks['om_remarks']; ?></span>
        <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
        <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>
    <?php }
    ?>
</div>
<?php
$prev_remarks = $cls_user->op_to_omprevremarks($pack_id);
$res = json_decode($prev_remarks, true);
//print_r($res);
if ($res == 0) {
    ?>

    <?php
} else {
    $msg = '';
    foreach ($res as $key => $value) {
        $msg .= formatDate($value['om_sentdate'], 'd-M-Y') . ':-' . $value['om_remarks'] . '\n';
    }
    ?>

    <div id="ctoprevious" class="pull-right" >
        <label class="badge badge-pill badge-secondary custom-bg font-medium text-white ml-1 pull-left" data-toggle="tooltip" data-original-title="CTO Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-comment"></i>OPS Previous Remarks</label>
    </div>
<?php }
?>




