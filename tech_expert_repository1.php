<?php
    include 'config/inc.php' ;
    include_once('layout/header.php');
    include_once('layout/nav.php');
    include_once('layout/leftsidebar.php');
?>

<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Tech Expert Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" required>
                    <option value="">-- Select project --</option>
                </select>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tech Expert Repository</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
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
                                        <th>Current Status</th>                                       
                                        <th>Planned</th>
                                        <th>Expected</th>
                                        <th>Actual</th>
                                        <th>View</th>                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $result = $cls_comm->select_techexpert_repository($_SESSION['uid']);
                                        $res = json_decode($result, true);
                                        foreach ($res as $key => $value) {
                                            $i=$i+1;
                                            $projname = $cls_comm->project_name($value['st_projid']);
                                            $packname = $cls_comm->package_name($value['st_packid']);
                                            $getid = $value['st_id'];
                                    ?>
                                    <tr>
                                        <td><?php echo $projname?></td>
                                        <td><div class="notify pull-left">
                                                <span class="heartbit greenotify" ></span>
                                                <span class="point greenpoint" ></span>
                                        </div><?php echo $packname?></td>
                                        <td><span class="badge badge-pill badge-info font-medium text-white ml-1">Current Status</span></td>
                                        <td><?php echo $cls_comm->datechange($value['st_planneddate'])?></td>
                                        <td><?php echo $cls_comm->datechange($value['st_expdate'])?></td>
                                        <td><?php echo $cls_comm->datechange($value['st_actual'])?></td>
                                        <td><span onclick="view_reports('<?php echo $value['ts_packid'];?>')" class="badge badge-pill badge-primary font-medium text-white ml-1"  data-toggle="modal" data-target=".bs-example-modal-lg" data-whatever="@mdo" style=" cursor: pointer;"><i class="fas fa-eye"></i> View</span></td>
                                    </tr>
                                    <?php
                                     }
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
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1">Project - <small>Package Name </small></h4> 

                            <div class="row" id="daterow">
                                <div class=" col-md-6" id="pd">
                                    <small>Planned Date:- <span class="badge badge-pill badge-dark font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                           
                                </div>
                                <!--                                <div class=" col-md-6" id="ps">
                                                                    <small>Sending Date:- <span class="badge badge-pill badge-primary font-medium text-white ml-1"><?php echo date('d-M-y'); ?></span></small>                          
                                                                </div>-->
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form>  
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="expected_date">Expected</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="end_date" name="expected_date" required="" placeholder="dd/mm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="actual_date">Actual</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="icon-calender"></i></span>
                                            </div>
                                            <input type="text" class="form-control mydatepicker" id="revend_date" name="actual_date" required="" placeholder="dd/mm/yyyy">

                                        </div>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>

                                </div>      
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="message-text1"></textarea>
                                </div>
                            </form>
                            <?php
                            $msg = '';
                            for ($i = 0; $i <= 5; $i++) {
                                $msg .= 'Date' - 'This is the remarks from CTO\n';
                            }
                            //echo $msg;
                            ?>                     
                        </div>
                        <div class="modal-footer">

<!--                            <a href="javacript:void(0)"  class="btn btn btn-rounded btn-outline-success mr-2 btn-sm" data-toggle="tooltip"  data-original-title="Send to O&M"><i class="ti-check mr-1"></i>Submit</a>
                            -->

<!--                            <button type="submit" class="btn btn-danger"><i class="fas fa-paper-plane"></i> Send to CTO</button>
                            --> <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
          
        </div>
    </div>
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
<?php
include_once('layout/rightsidebar.php');
include_once('layout/footer.php');
?>
 