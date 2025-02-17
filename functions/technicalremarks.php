<?php
    include_once ("../config/inc_function.php");
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    $pack_id = $_POST['key'];
    $current_remarks = $cls_comm->technical_cur_remarks($pack_id);
?>
<div id="currentre" style="margin_left:0%">
    <label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $current_remarks['tech_remarks']; ?>'});"><i class="fas fa-comment"></i>Remarks</label>
</div>
<?php
    $prev_remarks = $cls_comm->technical_pre_remarks($pack_id);
    $res = json_decode($prev_remarks, true);
    if ($res == 0) {
?>
<?php
    } else {
        $msg = '';    
        foreach ($res as $key => $value) {
            $sentdate = formatDate($value['tech_sentdate'], 'd-M-Y');
        $msg .= $sentdate . ':-' . $value['tech_remarks'] . '\n';
    }
    ?>
    <div id="previous" class="pull-right" >
        <label class="badge badge-pill badge-secondary font-medium text-white ml-1 pull-left" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-comment"></i>Previous Remarks</label>
    </div>
<?php }
?>




