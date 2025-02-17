<?php
include_once('layout/header.php');
include_once('layout/nav.php');
include_once('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
if($_SESSION['milcom']=='1')
{
   $seg='38'; 
}else
{
  $seg="";    
}

?>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">O&M WorkFlow</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '13')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allomproject($seg);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="om_dasboard">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Work Flow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="page-content container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- basic table -->
        <!-- basic table -->
        <div class="row">
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
                                        <th>Sent</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th> 
                                        <th>Stage Actual</th> 
                                        <th>Remarks</th>
                                        <th>Action</th>
                                        <th>Attachments</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_user->files_inopsrepo($pid,$seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $get_remarks= $cls_user->get_omremarks($value['om_packid']);
                                        ?>
                                        <tr>
                                            <td><?php echo $value['proj_name'] ?></td>
                                            <td>
                                                <?php if (strtotime($value['planned']) > strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit greenotify" ></span>
                                                        <span class="point greenpoint" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['planned']) < strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit"></span>
                                                        <span class="point" ></span>
                                                    </div>
                                                <?php } elseif (strtotime($value['planned']) == strtotime($value['actual'])) { ?>
                                                    <div class="notify pull-left">
                                                        <span class="heartbit bluenotify"></span>
                                                        <span class="point bluepoint" ></span>
                                                    </div>
                                                <?php }
                                                ?>
                                                <?php echo $value['pm_packagename'] ?></td>
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">OPS-<?php echo $value['name']; ?> <br> (<?php echo formatDate($value['om_sentdate'], 'd-M-Y'); ?>)</span></td>
                                            <td><?php echo formatDate($value['pm_material_req'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['pm_revised_material_req'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['planned'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['ps_expdate'], 'd-M-Y'); ?></td>
                                            <td><?php echo formatDate($value['ps_actualdate'], 'd-M-Y'); ?></td>
                                            <td><label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="OPS Remarks" style=" cursor: pointer;" onclick="swal( '<?php echo $get_remarks['omop_remarks']; ?>');"><i class="fas fa-comment"></i> OM Remarks</label></td>
                                            <td>                                               
                                                <span onclick="view_reports('<?php echo $value['om_packid']; ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;" >
                                                    <i class="fas fa-eye"></i> View
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $sql = "select * from swift_expert_uploads where exp_up_packid='" . $value['om_packid'] . "'";
                                                $projname = $cls_comm->project_name($value['om_projid']);
                                                $packname = $cls_comm->package_name($value['om_packid']);
                                                $query = mssql_query($sql);
                                                $num_rows = mssql_num_rows($query);
                                                if ($num_rows > 0) {
                                                    ?>
                                                    <span class="pointer" onclick="view_attachments('<?php echo $projname; ?>', '<?php echo $packname; ?>', '<?php echo $value['om_projid']; ?>', '<?php echo $value['om_packid']; ?>')" data-toggle="modal" data-target="#exampleModal1" data-whatever="@mdo"> <i class="fas fa-paperclip text-black"></i> </span>
                                                <?php }
                                                ?>
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

            <!-- sample modal content -->                     
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="width: 160%;margin-left: -25%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj">Project Name</span> - <small id="pack">Package Name</small></h4> 

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps"  >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date"></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form>  
                                <div class="col-md-12 table-responsive" id="exp_uptable"></div>
                                <div class="col-md-12 table-responsive" id="uptable"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"  data-dismiss="modal" >Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->

        </div>

        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <?php
    include_once('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->

<script src="code/js/ops.js" type="text/javascript"></script>
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
<script>
function view_attachments(a, b, c, d) {
        // alert(d);
        // exit();
        $("#proj").text(a);
        $("#pack").html(b);
        $.post("functions/filesforcto.php", {key: d}, function (data) {
            var planned_date = JSON.parse(data).planned_date;
            var mat_req_date = JSON.parse(data).mat_req_date;
            var pm_packagename = JSON.parse(data).pm_packagename;
            $('#planned_date').html(planned_date);
            $('#mat_req_date').html(mat_req_date);
            $('#exp_date').val(mat_req_date);
            fetch_exp_uploaddocument_view(c, d);
            fetch_om_uploaddocument_view(c, d);
        });
        //        $.post("functions/expertremarks.php", {key: pack_id}, function (data) {
        //            $('#expr').html(data);
        //        });

    }
</script>
 