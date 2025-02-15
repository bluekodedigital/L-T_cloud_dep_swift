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
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '7')" required="">
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
                    <?php
                    if (isset($_GET['msg'])) {
                        $msg = $_GET['msg'];
                    } else {
                        $msg = '';
                    }if ($msg == '0') {
                        ?>
                        <div class="alert alert-danger alert-rounded">  
                            <i class="fa fa-exclamation-triangle"></i> Something went Wrong!! Please Login Again & Try!!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                        </div>
                    <?php }
                    ?>
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->

                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th> 
                                        <th>Received From</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th> 
                                        <!--<th>Stage Actual</th>--> 
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_user->files_inom($pid,$seg);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        if ($value['ps_expdate'] == "") {
                                            $exp_date = date('Y-m-d');
                                        } else {
                                            $exp_date = $value['ps_expdate'];
                                        }
                                        ?>
                                        <tr>
                                            <td class=" pkwidth"><?php echo $value['proj_name'] ?></td>
                                            <td class=" pkwidth">
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">OPS-<?php echo $value['name'] ?><br> (<?php echo date('d-M-Y', strtotime($value['om_sentdate'])); ?>)</span></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['planned'])); ?></td>
                                            <td><?php // echo date('d-M-Y', strtotime($value['actual']));      ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo date('d-M-Y', strtotime($exp_date)); ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['om_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['om_packid'] ?>', '9')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>

                                            </td>



                    <!--                                            <td><?php // echo date('d-M-Y', strtotime($value['actual']));      ?></td>-->
                                            <td><label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange" data-toggle="tooltip" data-original-title="OPS Remarks" style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $value['om_remarks']; ?>'});"><i class="fas fa-comment"></i> OPS Remarks</label></td>
                                            <td>                                               
                                                <span onclick="filesinom('<?php echo $value['om_packid'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to OPS">
                                                    <i class="fas fa-paper-plane"></i> 
                                                </span>
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
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal_resize" style="width:200% !important; margin-left: -50% !important">
                        <div class="modal-header" style="margin-top: 0px;">                          
                            <h4 class="modal-title" id="exampleModalLabel1"><span id="project">Project</span> - <small id="pack">Package Name</small></h4> 
							<span id="proj" style="display:none;">Project</span> - <small id="pack1" style="display:none;">Package Name</small>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <br>
                        <div class="row">
                            <div class="container-fluid" >
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="pdate"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps" >
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <form method="post" action="functions/ops_form"  onsubmit="return confirm('Are you sure you want to submit?');"> 
                            <div class="modal-body" >
                                <center>
                                    <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">O&M Approval</span></small>                
                                </center>
                                <!--                                <div class="form-row">
                                                                    <small><b>From:- </b><span class="badge badge-pill badge-primary font-12 text-white ml-1" id="sentfrom">From: <?php echo date('d-M-y'); ?></span></small>                
                                                                </div>-->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3" style=" display: none;">
                                        <label for="expected_date">Expected</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>

                                                    <!--  <input type="text" class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">-->

                                        </div>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">

                                    <input type="hidden" value="" name="planneddate" id="planneddate">
                                    <input type="hidden" value="" name="senderid" id="senderid">
                                    <input type="hidden" value="" name="projectid" id="projectid">
                                    <input type="hidden" value="" name="packageid" id="packageid">
									
									<input type="hidden" value="" name="projid" id="projid">
                                    <input type="hidden" value="" name="packid" id="packid">
									
                                    <input type="hidden"  name="user_id" id="user_id" value="<?php echo $_SESSION['uid'];?>">
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">Action Date</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker"  disabled=""  id="actual_date" onchange="get_expected('7')" name="actual_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                </div>  
                                 <div id="modalbody"></div><br>
                                <div class="row" id="ctor">
                                   
                                </div> <br>
                                <div class="form-group" id="dre">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="opstospocremarks" name="opstospocremarks"></textarea>
                                </div>
                                <div class="form-group" id="om_uploads">
                                    <div class="form-row">
                                        <div class="col-md-4 mb-4">
                                            <label for="doc_name">Doc No</label>
                                            <input type="text" readonly="" class="form-control" id="doc_name" name="doc_name" value="O&M SignOff"   placeholder="O&M SignOff">


                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="proj_location">Upload File</label>
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label " for="inputGroupFile01">Choose file</label>
                                                </div>
                                                <div class="invalid-feedback">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <!-- <div class="input-group-append"> -->
                                            <button class="btn btn-success expert_filesup1" type="button" id="om_filesup" onclick="om_filesuplod()" style="    margin-top: 19% !important;">Upload</button>
                                            <!-- </div> -->
                                        </div>
                                    </div> 
                                    <div class="form-row">
                                        <div class="col-md-3 mb-6">

                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <div id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
                                            <div id="output"> <!-- error or success results --> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div style="width:60%;margin-left:5%;">
                                            <center style="margin-left:33%"><b>O&M Attachments:</b></center>
                                            <table  class="table1 table-bordered text-center" >
                                                <thead>
                                                <th>SI.No</th>
                                                <th>Version</th>
                                                <th>Doc No</th>
                                                <th>File Name</th>
                                                <th>Action</th>
                                                </thead>
                                                <tbody id="uptable">
                                                    <tr>
                                                        <td colspan="4" class=" text-center"> No Data Available</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="exp_uptable" style="width:60%;margin-left:5%;"></div>
                                        <!--<div class=" row" id="ops_exp_uptable" style="width:60%;margin-left:5%;"></div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">                           
                                <button type="submit" id="sent_to_back_ops" onclick="sent_to_back_opsloader();" name="sent_to_back_ops" class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i> Send to OPS</button>
                            </div>
                        </form>
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
    function sent_to_back_opsloader()
{
   
    $('#exampleModal').css('opacity','0.6');
    $('#exampleModal').css('background','#434748');
    $('#modalbody').html('<div class="lds-ripple" style="opacity:1.5 !important;"><div class="lds-pos"></div>\n\
                <div class="lds-pos"></div></div>');
       
    
    
}
    </script>