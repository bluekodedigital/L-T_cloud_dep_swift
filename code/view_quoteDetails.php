<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$qid = mssql_escape($_POST['key']);

$q_pid = mssql_query("select distinct vqd_projid from dbo.vendorquotedetl where vqd_docid='" . $qid . "'");
$rPid = mssql_fetch_array($q_pid);
$pid = $rPid['vqd_projid'];
//echo $pid;
$result = $cls_user->get_app_quote($qid, $pid);
$res = json_decode($result, true);
?>
<?php
foreach ($res as $key => $value) {
    $sol_id = $value['vq_solid'];
    ?>
    <div class="modal-header" style="margin-top: 0px;">                          
        <h4 class="modal-title" id="exampleModalLabel1"><span id="project"><?php echo $value['proj_name']; ?></span> - <small id="pack"><?php echo $value['sol_name']; ?></small></h4> 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body" >
        <div> 


                                                <!--        <input type="text" id="userq_id" value="<?php echo $_SESSION['uid']; ?>">-->
            <center><span style=" font-size: 16px; text-transform: uppercase; margin-left:-35px;"><b><u></u></b></span></center>        



            <p  style=" font-size: 15px; margin-top: -10px"><b>Vendor:</b>&nbsp;<div style="position: relative; left:65px; top:-37px;">
                <div class="table-responsive">
                    <address>
                        <?php
                        $result = $cls_user->get_final_app_quote($qid);
                        $res = json_decode($result, true);
                        foreach ($res as $key => $values) {
                            $sol_id = $value['vq_solid'];
                            ?>
                            <strong>&nbsp;&nbsp;<?php echo $values['sup_name']; ?></strong>

                        <?php } ?>


                    </address>
                </div>

            </div> </p>



        <?php }
        ?>


        <div class="row" style="margin-left:0px !important;">
            <div class="col-xs-9 table" style=" margin-top: -50px">
                <table id="demoone" class="table table-bordered table-striped" style="width: 96% !important;">
                    <thead>
                        <tr>
                            <th  style=" text-align:  left;">Description </th>
                            <th style=" text-align:  left;">Unit</th>
        <!--                    <th style=" text-align:  center;">Scope Qty </th>-->
                            <th style=" text-align:  center;">Vendor Qty </th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $cls_user->get_qcmst($qid);
                        $res = json_decode($result, true);
                        foreach ($res as $key => $value) {
                            ?>
                            <tr class='tx'>
                                <td style=" text-align:  left;"><?php echo $value['qcd_desc']; ?></td>
                                <td style=" text-align:  left;"><?php echo $value['qcd_unit']; ?></td>
                                <td class="quantity" style=" text-align:  center;"><?php echo $value['qcd_qty']; ?></td>   

                            </tr>
                        <?php }
                        ?>

                    </tbody>
                </table>



            </div>



        </div>
    </div>
</div>
<div class="modal-footer">

</div>