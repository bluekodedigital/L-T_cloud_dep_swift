<?php
include 'config/inc.php';
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
} else {
    $pid = "";
}
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
                <h5 class="font-medium text-uppercase mb-0">RPA Repository</h5>
            </div>
            <div class="col-lg-3 col-md-3">
                <!-- <label for="message-text" class="control-label">Technical Expert:</label> -->
                <select class="custom-select" name="expert_id" id="expert_id" onchange="swift_proj(this.value)">
                    <option value="">-- Select project --</option>
                    <?php
                    $result = $cls_comm->techspoc_proj_filter();
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id'] ) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-5 col-md-5 col-xs-12 align-self-center">              
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="finance">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Work Flow</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="page-content container-fluid">
        <!-- Start Page Content -->
        <!-- basic table -->
        <div class="row">
            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <!--<h4 class="card-title">Work Flow</h4>-->
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Project</th>
                                        <th>Package</th>
                                        <th>PO Number</th>
                                        <th>WO Number</th>
                                        <th>RPA Number</th>
                                        <th>RPA Value</th>
                                        <th>Valid From</th>  
                                        <th>Valid To</th>   
                                        <th>Days Left</th>
<!--                                        <th>Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->select_rpa_repository($pid);
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        $projname = $cls_comm->project_name($value['lr_projid']);
                                        $packname = $cls_comm->package_name($value['lr_packid']);
                                        $valid_from = $cls_comm->datechange($value['rpa_valid_from']);
                                        $valid_to = $cls_comm->datechange($value['rpa_valid_to']);
                                        $getid = $value['lr_id'];
                                        $po_num = $value['po_number'];
                                        $wo_num = $value['wo_number'];
                                        ?>
                                        <tr>
                                            <td><?php echo $projname ?></td>
                                            <td>
                                                <?php echo $packname ?>
                                            </td>
                                             <td><?php echo $po_num; ?></td>
                                            <td><?php echo $wo_num; ?></td>
                                            <td><?php echo $value['rpa_number'] ?></td>
                                            <td><?php echo $value['rpa_value'] ?></td>
                                            <td><?php echo $valid_from; ?></td>
                                            <td><?php echo $valid_to; ?></td>
                                            <td>
                                                <?php
                                                $result = $cls_count->days_left($value['rpa_valid_to'], 'rpa_valid_to');
                                                $daycount = $result['days'];
                                                if (7 >= $daycount) {
                                                    $alert = "";
                                                    $point = "";
                                                } elseif ($daycount > 7) {
                                                    $alert = "greenotify";
                                                    $point = "greenpoint";
                                                }
                                                ?>
                                                <div class="notify pull-left">
                                                    <span class="heartbit <?php echo $alert; ?>"></span>
                                                    <span class="point <?php echo $point ?>" ></span>
                                                </div><?php echo $daycount ?>
                                            </td>
<!--                                            <td>
                                                <span class="badge badge-pill badge-primary font-medium text-white ml-1" onclick="alert('test ok')" style=" cursor: pointer;"><i class="fas fa-paper-plane"></i>  View </span>
                                            </td>-->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sample modal content -->  
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style=" width: 120%;">
                        <div class="modal-header" style="padding-bottom: 3%;">

                            <h4 class="modal-title" id="exampleModalLabel1"> <span id="proj1">Project Name</span> - <small id="pack1">Package Name</small></h4> 
                            <!-- <h4 id="proj"></h4> &nbsp;&nbsp;-&nbsp;&nbsp; 
                            <h5 id="pack"><small></small></h5> -->
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class=" col-md-6" id="pd">
                                    <small>Target Date:- <span class="badge badge-pill badge-info font-12 text-white ml-1" id="planned_date1"></span></small>                           
                                </div>
                                <div class=" col-md-6" id="ps">
                                    <small>ORG/REV Material Required:- <span class="badge badge-pill badge-primary font-12 text-white ml-1" id="mat_req_date1"></span></small>                          
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="needs-validation" action="functions/lc_rpa_entry.php" autocomplete="off">                            
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="revend_date">RPA Number</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="rpa_number" name="rpa_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="revend_date">RPA Date</label>
                                            <div class="input-group">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="icon-calender"></i></span>
                                                </div>
                                                <input type="text" class="form-control mydatepicker" id="rpa_date" name="rpa_date"  required="" placeholder="mm/dd/yyyy">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="example">
                                        <h4 class="card-title mt-4">Valid From & Valid To</h4>
                                        <!-- <h6 class="card-subtitle">just add id <code>#date-range</code> to create it.</h6> -->
                                        <div class="input-daterange input-group" id="date-range1">
                                            <input type="text" class="form-control" name="start_rpa" />
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-info b-0 text-white">TO</span>
                                            </div>
                                            <input type="text" class="form-control" name="end_rpa" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">RPA Value:</label>
                                    <input type="text" name="rpa_value" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Enter Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" required></textarea>
                                </div>
                                <!-- <div class="row" id="opsr" style="margin-left:0%;">
                                    
                                </div>  -->
                                <input type="hidden" id="rpa_row_id" name="rpa_row_id">
                                <input type="hidden" id="rpa_pack_id" name="rpa_pack_id">
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="submit" class="btn btn-outline-danger btn-rounded" name="reject_package"  style="position:relative;left:-53%;">  data-dismiss="modal"  <i class="fas fa-times"></i> Reject</button> -->
                                    <button type="submit" class="btn btn-outline-primary btn-rounded" name="rpa_create" id="submitbtn" ><i class="fas fa-paper-plane"></i> Lc Save </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.modal -->

            </div>
        </div>
        <?php
        include_once('layout/foot_banner.php');
        ?>
    </div>
    <script>
        function getrpa(a, b) {
            var getid = a;
            var pack_id = b;
            $("#rpa_row_id").val(getid);
            $("#rpa_pack_id").val(pack_id);
            $.post("functions/getrpadatas.php", {key: pack_id}, function (data) {
                var planned_date1 = JSON.parse(data).planned_date1;
                var mat_req_date1 = JSON.parse(data).mat_req_date1;
                var proj_name1 = JSON.parse(data).proj_name1;
                var packagename1 = JSON.parse(data).packagename1;
                $('#planned_date1').html(planned_date1);
                $('#mat_req_date1').html(mat_req_date1);
                $("#proj1").html(proj_name1);
                $("#pack1").html(packagename1);
            });
        }

        function swift_proj(Proid) {
            window.location.href = "rpa_repository?pid=" + Proid;
        }

    </script>


    <?php
    include_once('layout/rightsidebar.php');
    include_once('layout/footer.php');
    ?>
 