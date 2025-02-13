<?php
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pid = $_POST['key'];
$stage = $_POST['stage'];
$segment = $_POST['seg'];
if ($stage == 0) {
    $repo = $cls_report->repo_dash2($pid, $stage, $segment);
} else if ($stage == 'empty') {
    $repo = $cls_report->techspoc_dash11($pid, $segment);
} else {
    $repo = $cls_report->repo_dash11($pid, $stage, $segment);
}
?>
<table id="file_export" class="table table-bordered display compact">
    <thead>
        <tr>
            <th>Project</th>
            <th>Package</th>
            <th>Department</th>
            <th>Current Status</th>                                       
            <th>Weightage</th>                                       
            <th>Material Req @ Site</th>
            <th>Lead time(Days)</th>
            <th>Exp. Delivery</th>
            <th>Deviations (Days)</th>
            <th>View</th>                                      
        </tr>
    </thead>
    <tbody>
        <?php
        $res = json_decode($repo, true);
        foreach ($res as $key => $value) {
            $deviations = $value['daysdif'];
            $expdelivery = date('d-M-Y', strtotime($value['pm_revised_material_req'] . ' +' . $deviations . 'days'));
            $current_status = $cls_comm->current_status($value['ps_packid']);
            $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
            $pack_id = $value['ps_packid'];
            $stageid = $value['ps_stageid'];
            $projid = $value['proj_id'];
            ?>
            <tr>
                <td><?php echo $value['proj_name'] ?></td>
                <td>
                    <?php if (strtotime($value['pm_revised_material_req']) < strtotime($expdelivery)) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit"></span>
                            <span class="point" ></span>
                        </div>
                    <?php } elseif (strtotime($value['pm_revised_material_req']) > strtotime($expdelivery)) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit greenotify" ></span>
                            <span class="point greenpoint" ></span>
                        </div>
                    <?php } elseif (strtotime($value['pm_revised_material_req']) == strtotime($expdelivery)) { ?>
                        <div class="notify pull-left">
                            <span class="heartbit bluenotify"></span>
                            <span class="point bluepoint" ></span>
                        </div>
                    <?php }
                    ?>
                    <?php echo $value['pm_packagename'] ?></td>
                <td><?php
                    // echo $fetch_usertype;;
                    if ($fetch_usertype == 2) {
                        echo 'SCM';
                    } else if ($fetch_usertype == 14) {
                        echo 'OPS';
                    } else if ($fetch_usertype == 5) {
                        echo 'OPS';
                    } else if ($fetch_usertype == 10) {
                        echo 'TECHNICAL';
                    } else if ($fetch_usertype == 11) {
                        echo 'TECHNICAL';
                    } else if ($fetch_usertype == 12) {
                        echo 'TECHNICAL';
                    } else if ($fetch_usertype == 15) {
                        echo 'O&M';
                    }
                    ?></td>
                <td><span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm "><?php echo $current_status; ?></span></td>

                <td><span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm" style=" background-color: #8e1f1f !important;"><?php
                        $get_weightage = $cls_report->get_weightage($pack_id, $stageid, $projid);
                        echo $get_weightage . ' %';
                        ?>


                    </span></td>
                <td><?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                <td><?php echo $value['pm_revised_lead_time']; ?></td>
                <td><?php echo $expdelivery; ?></td>
                <td>
                    <?php
                    $sdate = date('Y-m-d', strtotime($value['pm_revised_material_req']));
                    $ltime = date('Y-m-d', strtotime($expdelivery));
                    $start = new DateTime($sdate);
                    $end = new DateTime($ltime);
                    $bdate = round(($end->format('U') - $start->format('U')) / (60 * 60 * 24)) . '';

                    if ($bdate < 0) {
                        ?>
                        <span class=" text-primary"><?php echo $bdate; ?></span>
                         <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                    <?php } else { ?>
                        <span class=" text-danger"><?php echo $bdate; ?></span>
                         <!--<span class=" badge badge-pill badge-primary" onclick="view_delay('<?php echo $value['ps_packid']; ?>')"  data-toggle="modal" data-target="#delaymodal" data-weportshatever="@mdo" style=" cursor: pointer;"><i class=" fas fa-eye"></i></span>-->
                    <?php } ?>

                </td>
                <td><span onclick="view_reports('<?php echo $value['ps_packid']; ?>','<?php echo $projid; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip" ><i class="fas fa-eye"></i> View</span>
                <span onclick="view_reports_table('<?php echo $value['ps_packid']; ?>','<?php echo $projid; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  ><i class="fas fa-file-excel"></i> </span>
                
                </td>
            </tr>
        <?php }
        ?>

    </tbody>

</table>


