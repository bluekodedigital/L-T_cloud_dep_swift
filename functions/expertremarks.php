<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$current_remarks = $cls_comm->exp_cto_cur_remarks($pack_id);
?>
<div id="expcurrentre" style="margin_left:0%">
    <!--<label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="Expert Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $current_remarks['cto_remarks']; ?>'});"><i class="fas fa-comment"></i>Expert Remarks</label>-->
<!--    <span id="less" data-toggle="tooltip" data-original-title="SPOC Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Remarks:</span> <?php echo substr($current_remarks['cto_remarks'], 0, 62) . '....'; ?></span>   
    <span id="moreew" data-toggle="tooltip" data-original-title="SPOC Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder"> Remarks:</span> <?php echo $current_remarks['cto_remarks']; ?></span>
    <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
    <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>-->

  <?php if (strlen($current_remarks['cto_remarks'])< 25) { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Tech Expert Remarks:</span> <?php echo $current_remarks['cto_remarks']; ?></span>   
    <?php } else { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Tech Expert Remarks:</span> <?php echo substr($current_remarks['cto_remarks'], 0, 62) . '....'; ?></span>   
        <span id="moreew" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder">Tech Expert Remarks:</span> <?php echo $current_remarks['cto_remarks']; ?></span>
        <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
        <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>
    <?php }
    ?>
</div>
<?php
$prev_remarks = $cls_comm->exp_cto_pre_remarks($pack_id);
$res = json_decode($prev_remarks, true);
if ($res == 0) {
    ?>
    <?php
} else {
    $msg = '';
    foreach ($res as $key => $value) {
        $sentdate = formatDate($value['cto_sentdate'], 'd-M-Y');
        $msg .= $sentdate . ':-' . $value['cto_remarks'] . '\n';
    }
    ?>
    <div id="expprevious" class="pull-right" >
        <label class="badge badge-pill badge-secondary font-medium text-white ml-1 pull-left custom-bg" data-toggle="tooltip" data-original-title="Expert Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-comment"></i>Expert Previous Remarks</label>
    </div>
<?php }
?>




