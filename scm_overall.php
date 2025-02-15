<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}

if($_SESSION['milcom']==1)
{
 $seg='38';   
}else
{
  $seg="";  
}
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    div#dashtbl {
        margin-top: -1%;
    }
</style>
<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Over All</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center" >                
                <select class="custom-select" name="project_id" id="project_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->dash_filter($seg);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-6 col-md-8 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">

        </div>

        <div class="row" id="dashtbl">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="file_export" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>Department</th>
                                        <th>Current Status</th>                                       
                                        <th>Material Req @ Site</th>
                                        <th>Lead time(Days)</th>
                                        <th>Exp. Delivery</th>
                                        <th>Deviations (Days)</th>
                                        <th>View</th>                                      
                                        <th>Attachments</th>                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                  
                                    $repo = $cls_report->techspoc_dash($pid,$seg);
                                    $res = json_decode($repo, true);
                                    foreach ($res as $key => $value) {
//                                        $deviations = $value['daysdif'];

                                        $pack_id = $value['ps_packid'];
                                        $stageid = $value['ps_stageid'];
                                        $projid = $value['proj_id'];
                                        $get_deviations = $cls_report->get_deviations($pack_id, $stageid, $projid);
                                        $deviations = $get_deviations['daysdif'];
                                        $expdelivery = date('d-M-Y', strtotime($value['pm_revised_material_req'] . ' +' . $deviations . 'days'));
                                        $current_status = $cls_comm->current_status($value['ps_packid']);
//                                         $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
                                        $sent_back = $value['ps_stback'];
                                        if ($sent_back == 1) {
                                            $fetch_usertype = $cls_comm->fetch_usertype($value['ps_sbuid']);
                                        } else {
                                            $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
//                                             $fetch_usertype = $cls_comm->fetch_usertype($value['ps_userid']);
                                        }


                                        $get_po_wo_app = $cls_user->get_po_wo_app($value['ps_packid']);

                                        if ($get_po_wo_app != "") {
                                            $po_wo = $get_po_wo_app['so_hw_sw'];
                                        } else {
                                            $po_wo = 0;
                                        }
                                        if ($po_wo == 1 && $stageid == 23) {
                                            $current_status = 'WO Approval Completed';
                                        }
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
                                            <td><span class="badge badge-pill badge-info font-medium text-black ml-1 recfrm">            <?php echo $current_status; ?></span></td>
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
                                            <td>
                                                <span onclick="view_reports('<?php echo $value['ps_packid']; ?>','<?php echo $projid ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc"><i class="fas fa-eye"></i> View</span>
                                                <span onclick="view_reports_table('<?php echo $value['ps_packid']; ?>','<?php echo $projid ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="View Report"><i class="fas fa-file-excel"></i> </span>
                                            </td>
                                            <td><span class="pointer" onclick="view_allattachments('<?php echo $value['proj_name'] ?>', '<?php echo $value['pm_packagename'] ?>', ' <?php echo $value['proj_id'] ?>', ' <?php echo $value['ps_packid'] ?>', '<?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?>', '<?php echo $expdelivery; ?>')" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>

                                            </td>

                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sample modal content -->                     
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
            <div class="modal-dialog" role="document">
                <div class="modal-content" style=" width: 180%; margin-left: -25%">
                    <div class="modal-header" style="padding-bottom: 3%;">
					     <input type="hidden" name="projid" id="projid">
						<input type="hidden" name="packid" id="packid">
                        <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack1">Package Name</small></h4> 


                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="row">
                        <div class="container-fluid">
                            <div class=" col-md-6" id="pd">
                                <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="plndate"></span></small>                           
                            </div>
                            <div class=" col-md-6" id="ps"  >
                                <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="expndate"></span></small>                          
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">

                        <div  id="exp_uptable" style=" width: 60%"></div> 
                        <div  id="uptable" style=" width: 60%"></div>
                        <div  id="ops_exp_uptable" style=" width: 60%"></div>




                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary"  data-dismiss="modal" >Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </div>
    <?php
    include_once('layout/foot_banner.php');
    ?>
</div>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
                                                function swift_proj(Proid) {
                                                    window.location.href = "scm_overall?pid=" + Proid;
                                                }

</script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>