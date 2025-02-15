<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pack_id = $_POST['key'];
$current_remarks = $cls_comm->spoc_exp_cur_remarks($pack_id);
$sender_stage = $cls_comm->spoc_exp_pre_remarks_sent_back($pack_id);
if($sender_stage==5){  
     $sname='Reviewer';
}else if($sender_stage==6){  
     $sname='CTO';
}else if($sender_stage==7){
    $sname='OPS';
}else{  
       $sname='SPOC';
  }
?>
<div id="spoccurrentre" style="margin_left:0%">
    <!--<label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="SPOC Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $current_remarks['txp_remarks']; ?>'});"><i class="fas fa-comment"></i>SPOC Remarks</label>-->

<!--    <span id="less" data-toggle="tooltip" data-original-title="SPOC Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> Remarks:</span> <?php echo substr($current_remarks['txp_remarks'], 0, 55) . '....'; ?></span>   
    <span id="moreew" data-toggle="tooltip" data-original-title="SPOC Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder"> Remarks:</span> <?php echo $current_remarks['txp_remarks']; ?></span>
    <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
    <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>-->

    <?php if (strlen($current_remarks['txp_remarks']) < 25) { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> <?php echo $sname; ?> Remarks:</span> <?php echo $current_remarks['txp_remarks']; ?></span>   
    <?php } else { ?>
        <span id="less" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" ><span style="font-weight: bolder"> <?php echo $sname; ?>  Remarks:</span> <?php echo substr($current_remarks['txp_remarks'], 0, 62) . '....'; ?></span>   
        <span id="moreew" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer; display: none" ><span style="font-weight: bolder"> <?php echo $sname; ?>   Remarks:</span> <?php echo $current_remarks['txp_remarks']; ?></span>
        <span id="rmore" style="color: #007bff;  cursor: pointer;" onclick="readmore()">Read more</span>
        <span id="rless" style="color: #007bff; cursor: pointer; display: none;" onclick="readless()">Read Less</span>
    <?php }
    ?>

</div>
<?php
$prev_remarks = $cls_comm->spoc_exp_pre_remarks($pack_id);

$res = json_decode($prev_remarks, true);
if ($res == 0) {
    ?>
    <?php
} else {
    $msg = '';
    foreach ($res as $key => $value) {
        $sentdate = date('d-M-Y', strtotime($value['txp_sentdate']));
        $msg .= $sentdate . ':-' . $value['txp_remarks'] . '\n';
    }
    ?>
 
    <div id="spocprevious" class="pull-right" >
        <label class="badge badge-pill badge-info custom-bg font-medium text-white ml-1 pull-left" data-toggle="tooltip" data-original-title="Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $msg; ?>'});"><i class="fas fa-comment"></i> Previous Remarks</label>
    </div>
 
    
<?php }
?>




