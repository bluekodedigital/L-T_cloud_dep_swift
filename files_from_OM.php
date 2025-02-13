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
                <h5 class="font-medium text-uppercase mb-0">Files From O&M</h5>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">                
                <select class="custom-select" name="proj_Filter" id="proj_Filter" onchange="proj_Filter(this.value, '6')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects_seg($segment);
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>                         
                        <li class="breadcrumb-item active" aria-current="page">Ops Work Flow</li>
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
                                    $result = $cls_user->files_from_om($pid, $segment);
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
                                            <td><span class="badge badge-pill badge-info font-medium text-white ml-1 recfrm">O&M-<?php echo $value['name']; ?><br>(<?php echo date('d-M-Y', strtotime($value['omop_sentdate'])); ?>)</span></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['pm_revised_material_req'])); ?></td>
                                            <td><?php echo date('d-M-Y', strtotime($value['planned'])); ?></td>
                                            <td><?php // echo date('d-M-Y', strtotime($value['actual']));    ?>
                                                <div class="input-group" id="expdiv" style=" float: left;">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="icon-calender"></i></span>
                                                    </div>
                                                    <input type="text" value="<?php echo date('d-M-Y', strtotime($exp_date)); ?>"  class="mydatepicker" id="dasexpected_date<?php echo $value['omop_packid'] ?>" name="dasexpected_date" required="" placeholder="dd/mmm/yyyy">

                                                </div>
                                                <div class=" saveexp" style=" float: right;">
                                                    <span   class="badge badge-pill badge-success font-medium text-white ml-1 sicon" onclick="save_expected('<?php echo $value['omop_packid'] ?>', '8')" data-toggle="modal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Save Expected date">
                                                        <i class="fas fa-save"></i>  
                                                    </span>
                                                </div>

                                            </td>


                <!--<td><?php // echo date('d-M-Y', strtotime($value['actual']));     ?></td>-->


                                            <td><label class="badge badge-pill badge-warning font-medium text-white ml-1 pull-left orange"   style=" cursor: pointer;" onclick="swal({html: true, title: 'Remarks', text: '<?php echo $value['omop_remarks']; ?>'});"><i class="fas fa-comment"></i> O&M Remarks</label></td>
                                            <td>                                               
                                                <span onclick="filesfrom_om('<?php echo $value['omop_packid'] ?>')" class="badge badge-pill badge-primary font-medium text-white ml-1" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style=" cursor: pointer;" data-toggle="tooltip"  data-original-title="Send Packages to Tech Spoc">
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
                    <div class="modal-content modal_resize" style=" width: 120%;">
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
                                    <small>Expected Date:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mtred"><?php echo date('d-M-y'); ?></span></small>                          
                                </div>
                            </div>
                        </div>
                        <form method="post" action="functions/ops_form"  onsubmit="return confirm('Are you sure you want to submit?');"> 
                            <div class="modal-body">

                                <center>
                                    <small> <span class="badge badge-pill badge-secondary orange font-12 text-white ml-1" id="senttitle">Operation  to SCM </span></small>                
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

<!--                                            <input type="text"  class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">-->

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <input type="hidden"  class="form-control mydatepicker" id="expected_date" name="expected_date" required="" placeholder="dd/mmm/yyyy">

                                    <input type="hidden" value="" name="planneddate" id="planneddate">
                                    <input type="hidden" value="" name="senderid" id="senderid">
                                    <input type="hidden" value="" name="projectid" id="projectid">
                                    <input type="hidden" value="" name="packageid" id="packageid">
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">Action</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" disabled="" id="actual_date" onchange="get_expected('7')" name="actual_date" required="" placeholder="dd/mmm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>

                                </div>  
                                <div class="col-md-12 table-responsive" id="ctor">

                                </div>   
                                <div class=" col-md-12 table-responsive" id="uptable">


                                </div>
                                <div class=" col-md-12 table-responsive" id="exp_uptable">


                                </div>

                                <div class="form-group" id="expert_uploads">


                                    <div class="form-row">

                                        <div class="col-md-4 mb-4">
                                            <label for="doc_name">Doc No</label>
                                            <input type="text" readonly="" class="form-control" id="doc_name" name="doc_name" value="Ops SignOff"   placeholder="Ops SignOff">


<!--                                            <select class="custom-select" name="doc_name" id="doc_name"  required="">
                                                <option value="Compliances">Compliances</option>
                                                <option value="Sol Document">Sol Document</option>
                                                <option value="Cross References">Cross References</option>
                                                <option value="BOM">BOM</option>
                                                <option value="BOQ">BOQ</option>
                                                <option value="Data sheet">Data sheet</option>
                                                <option value="Others">Others</option>

                                            </select>-->

<!--                                            <input type="text" class="form-control" id="doc_name" name="doc_name"    placeholder="Enter Document Name">-->


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
                                            <input type="hidden" id="ops_rem" value="1">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="button" id="ops_expert_filesup" onclick="ops_expert_filesuplod()">Upload</button>
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

                                    <div class=" row" id="ops_exp_uptable">


                                    </div>

                                </div>

                                <br>
                                <div class="form-group" id="dre">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="opstospocremarks" name="opstospocremarks"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <!--<button type="submit" id="sent_back_spocom" name="sent_back_spocom" class="btn-rounded btn btn-outline-danger btn-sm pull-left"><i class="ti-close mr-1"></i> Send Back To Tech SPOC</button>-->
                                <button type="submit" id="sent_back_expertom" name="sent_back_expertom" class="btn-rounded btn btn-outline-danger btn-sm pull-left"><i class="ti-close mr-1"></i> Send Back To Tech Expert</button>

                                <button type="submit" id="sent_toomom" name="sent_toomom" class="btn btn btn-rounded btn-outline-danger mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i> Send Back to O&M</button>
                                <button type="submit" id="sent_toscmom" name="sent_toscmom" class="btn btn btn-rounded btn-outline-primary mr-2 btn-sm"><i class="fa fa-paper-plane mr-1"></i> Send to SCM</button>
                            </div>
                    </div>
                    </form>
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
