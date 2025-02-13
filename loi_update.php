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
                <h5 class="font-medium text-uppercase mb-0">Files For LOI Generation</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '14')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects_loi($seg);
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
                        <li class="breadcrumb-item"><a href="buyer_dash">Home</a></li>                         
                        <li class="breadcrumb-item active" aria-current="page">LOI</li>
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
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="col-md-6 mb-3"><label style=" cursor: pointer; position: relative; left:74%;" >
                                &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                                <input style=" cursor: pointer;" type="radio" name="hpc_nhpc" value="0" onclick="filter_hpc(this.value)" required="" /> Regular Files  
                                                             
                                &nbsp; &nbsp;  
                                <input style=" cursor: pointer;" type="radio" name="hpc_nhpc"  value="1" onclick="filter_hpc(this.value)" required="" /> CEO HPC Files

                            </label></div>

                        <div class="table-responsive" id="loi_datas">

                            <table id="zero_config" class="table table-bordered display compact">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th> 
                                        <th>Received FROM</th>
                                        <th>ORG Schedule</th>
                                        <th>Material Req</th>
                                        <th>Stage Planned</th>
                                        <th>Stage Expected</th> 
<!--                                        <th>Stage Actual</th>                                         -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $uid = $_SESSION['uid'];
                                    $utype = $_SESSION['usertype'];
                                    $result = $cls_user->files_from_smartsignloi($pid, $uid, $utype,$seg);
//                                    print_r($result);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        if ($value['ps_expdate'] == "") {
                                            $exp_date = date('Y-m-d');
                                        } else {
                                            $exp_date = $value['ps_expdate'];
                                        }
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">Smart Signoff <br> (<?php echo date('d-M-Y', strtotime($value['so_package_approved_date'])); ?>)</span></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['planned'])); ?></td>
                                            <td><?php // echo date('d-M-Y', strtotime($value['actual']));      ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo date('d-M-Y', strtotime($exp_date)); ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['so_pack_id'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['so_pack_id'] ?>', '18')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>
                                                    </span>
                                                </div>

                                            </td>
    <!--                                            <td><?php // echo date('d-M-Y', strtotime($value['actual']));       ?></td>-->
                                            <td>                                               
                                                <span onclick="filesfrom_smartsign_loi('<?php echo $value['so_pack_id'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages">
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
                    <div class="modal-content" style="width: 200%; margin-left: -42%;">
                        <div class="modal-header" style="margin-top: 0px;">                          
                            <h4 class="modal-title" id="exampleModalLabel1"><span id="project">Project</span> - <small id="pack">Package Name</small></h4> 
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid" >
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="pdate"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps" >
                                    <small>Expected:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <form method="post" action="functions/ops_form" autocomplete="off"> 
                            <div class="modal-body">
                                <center>
                                    <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">LOI Date(Smart signoff) </span></small>                
                                </center>
                                <!--                                <div class="form-row">
                                                                    <small><b>From:- </b><span class="badge badge-pill badge-primary font-12 text-white ml-1" id="sentfrom">From: <?php echo date('d-M-y'); ?></span></small>                
                                                                </div>-->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3" >
                                        <label for="expected_date">LOI Number</label>
                                        <div class="input-group">


                                            <input type="text" class="form-control" id="loi_number" name="loi_number" required="" placeholder="Enter LOI Number">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">

                                    <input type="hidden" value="" name="planneddate" id="planneddate">
                                    <input type="hidden" value="" name="senderid" id="senderid">
                                    <input type="hidden" value="" name="projectid" id="projectid">
                                    <input type="hidden" value="" name="packageid" id="packageid">
                                    <input type="hidden" value="" name="hpc_app" id="hpc_app">
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">LOI Action</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text"    class="form-control mydatepicker" id="actual_date" onchange="get_expected('7')" name="actual_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3 hpc_div"  style="display:none;">
                                        <label for="smartini_date">SmartSignOff Initiated Date:</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text"    class="form-control mydatepicker" id="smartini_date"  name="smartini_date"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3  hpc_div"  style="display:none;" >
                                        <label for="smartapp_date">SmartSignOff Approval Date:</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text"    class="form-control mydatepicker" id="smartapp_date"  name="smartapp_date"   placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label  style="margin-top: 1%;"> PO/WO Applicable :  </label>
                                        <!--                                        <div class="col-md-8 col-sm-9 col-xs-9" id="lc" style="margin-top: 1%;">
                                                                                    
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6 mb-3"><label style=" cursor: pointer;" >
                                            <input style=" cursor: pointer;" type="radio" name="po_wo"  value="2" required="" /> PO
                                            <input style=" cursor: pointer;" type="radio" name="po_wo" value="1" required="" /> WO   
                                            <input style=" cursor: pointer;" type="radio" name="po_wo" value="3" required="" /> PO+WO   
                                        </label></div>

                                </div> 

                                <div class="form-group" id="dre">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="opstospocremarks" name="opstospocremarks"></textarea>
                                </div>
                                <div class="row" id="ctor">

                                </div> 

                                <div class="form-group" id="loi_uploads">
                                    <div class="form-row">

                                        <div class="col-md-4 mb-4">
                                            <label for="doc_name">Doc Name</label>

                                            <input type="text" class="form-control" id="doc_name" name="doc_name"    placeholder="Enter Document Name">


                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-6">
                                            <label for="proj_location">Upload File</label>
                                            <div class="input-group mb-3">

                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile01">
                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                </div>

                                                <div class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="loi_filesup" onclick="loi_filesuplod()">Upload</button>
                                            </div>


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
                                    <center> <b> LOI Attachments:</b></center> 
                                    <div class=" row table-responsive">
                                        <table  class="table1 table-bordered text-center">
                                            <thead>
                                            <th>SI.No</th>
                                            <th>Doc Name</th>
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
                                </div>

                            </div>
                            <div class="modal-footer">                               
                                <button type="submit" id="update_loi" name="update_loi" class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i>Submit LOI</button>
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
