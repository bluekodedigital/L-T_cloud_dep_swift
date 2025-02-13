<?php
include_once ('layout/header.php');
include_once ('layout/nav.php');
include_once ('layout/leftsidebar.php');
include 'config/inc.php';
$segment = $_SESSION['swift_dep'];
$generate_token = generate_token();
if (isset ($_GET['pid'])) {
    $pid = $_GET['pid'];
    echo '<script>var pid=' . $_GET['pid'] . ';</script>';
} else {
    $pid = "";
}
?>
<style>
    tr {
        cursor: pointer
    }

    .selected {
        background-color: lemonchiffon;
        color: black;
        font-weight: bold
    }

    button {
        margin-top: 5px;
        background-color: #eee;
        border: 2px solid #00F;
        color: #17bb1c;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer
    }
</style>
<style>
    .card-body {
        flex: 1 1 auto;
        padding: 1.57rem;
    }

    div#fileuploader {
        margin-top: 20px;
    }

    /* 
    .checkbox {
        width: 100%;
        
        position: relative;
        display: block;
        margin-top: -31px !important;
    }

    .checkbox input[type="checkbox"] {
        width: auto;
        opacity: 0.00000001;
        position: absolute;
        left: 0;
        margin-left: -20px;
    }

    .checkbox label {
        position: relative;
    }

    .checkbox label:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        margin: 4px;
        width: 22px;
        height: 22px;
        transition: transform 0.28s ease;
        border-radius: 3px;
        border: 2px solid #ff9900;
        background-color: #ff9900;
    }

    .checkbox label:after {
        content: '';
        display: block;
        width: 10px;
        height: 5px;
        border-bottom: 2px solid #fff;
        border-left: 2px solid #fff;
        -webkit-transform: rotate(-45deg) scale(0);
        transform: rotate(-45deg) scale(0);
        transition: transform ease 0.25s;
        will-change: transform;
        position: absolute;
        top: 12px;
        left: 10px;

    }

    .checkbox input[type="checkbox"]:checked~label::before {
        color: #ff9900;
    }

    .checkbox input[type="checkbox"]:checked~label::after {
        -webkit-transform: rotate(-45deg) scale(1);
        transform: rotate(-45deg) scale(1);
    }

    .checkbox label {
        min-height: 34px;
        display: block;
        padding-left: 40px;
        margin-bottom: 0;
        font-weight: normal;
        cursor: pointer;
        vertical-align: sub;
    }

    .checkbox label span {
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .checkbox input[type="checkbox"]:focus+label::before {
        outline: 0;
    } */
    .round {
        c width: 50px !important;
        height: 20px !important;
        ;
    }

    .switch {
        display: inline-block;
        height: 5px;
        position: relative;
        width: 60px;
    }

    .switch input {
        display: none;
    }

    .slider {
        background-color: #ccc;
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: #fff;
        bottom: 4px;
        content: "";
        height: 13px;
        left: 3px;
        position: absolute;
        transition: .4s;
        width: 17px;
    }


    input:checked+.slider {
        background-color: #66bb6a;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-light">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0">Work Flow Master</h5>
            </div>
            <!-- <div class="col-lg-3 col-md-3 col-xs-12 align-self-center">
                <select class="custom-select" name="proj_Filter" id="proj_Filter"
                    onchange="proj_Filter(this.value, '4')" required="">
                    <option value="">--Select Project--</option>
                    <?php
                    $result = $cls_comm->select_allprojects_seg($segment);
                    $res = json_decode($result, true);
                    foreach ($res as $key => $value) {
                        ?>
                        <option value="<?php echo $value['proj_id'] ?>" <?php echo ($pid == $value['proj_id']) ? 'selected' : ''; ?>><?php echo $value['proj_name'] ?></option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">

                </div>
            </div> -->
            <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Package Category Master</li>
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

        <div class="row" id="workflow_master" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="tab_select">
                        <!-- <h4 class="card-title">Package Creation Form</h4> -->

                        <div class="tab-content border p-4" style=" margin-top: 3%">

                            <div class="row" style='display:flex;justify-content:center;'>
                                <form class="needs-validation" novalidate method="post" action="functions/work_flow.php"
                                    autocomplete="off">
                                    <input type="hidden" name="page_name" value="masters">
                                    <input type="hidden" id="csrf_token" name="csrf_token"
                                        value="<?php echo $generate_token; ?>" />

                                    <div class="form-row">
                                        <input type="hidden" name="epage_name" value="admin">
                                        <input type="hidden" name="pc_id" id="pc_id" value="">
                                        <div class="col-md-6 mb-12">
                                            <label for="proj_name">Work Flow Name</label>
                                            <input type="text" class="form-control" id="workflow_name"
                                                name="workflow_name" placeholder="Work Flow Name" value="" required>
                                            <div class="invalid-feedback">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 mb-12">
                                            <label for="active_flag"> Active</label></br>
                                            <input style="margin-left: 6%;" type="checkbox" id="active_flag"
                                                name="active_flag">
                                        </div> -->

                                    </div>
                                    <br>
                                    <table class="table table-bordered border" id="view_table">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Stage name</th>
                                                <th>Days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered border" id="table">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Stage name</th>
                                                <th>Days</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            $result1 = $cls_comm->stage_master();
                                            $res1 = json_decode($result1, true);

                                            // Sort the stages array by stage_id
                                            usort($res1, function ($a, $b) {
                                                return $a['stage_id'] - $b['stage_id'];
                                            });

                                            foreach ($res1 as $key => $value1) {
                                                if ($key == 0) {
                                                    $rowStyle = 'style="display: none;"';
                                                    $readonly = 'readonly';
                                                    $checked = 'checked';
                                                    $val = '1';
                                                } else {
                                                    $rowStyle = '';
                                                    $readonly = '';
                                                    $val = '';
                                                    $checked = '';
                                                }
                                                ?>
                                                <tr <?php echo $rowStyle; ?>>
                                                    <td>
                                                        <?php echo $count; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value1['stage_name'] ?>
                                                    </td>
                                                    <td style="width: 28%;">
                                                        <input style="width: 50%;" class='readonly' type='text' <?php echo $readonly ?>
                                                            onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"
                                                            id="days<?php echo $value1['stage_id']; ?>" name='details[]'
                                                            value='<?php echo $val; ?>' />
                                                        <input type='hidden' value='<?php echo $value1['stage_id']; ?>'
                                                            name='stage[]' />
                                                        <input type='hidden' value='' name='did'
                                                            id="did<?php echo $value1['stage_id']; ?>" />
                                                    </td>
                                                    <td>
                                                        <input <?php echo $checked; ?> class='readonly' type="checkbox"
                                                            id="check<?php echo $value1['stage_id']; ?>"
                                                            onclick="change('<?php echo $value1['stage_id']; ?>')"
                                                            name="check[]" value="<?php echo $value1['stage_id']; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $count = $count + 1;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <button type="button" id='btndisable1'
                                        onclick="upNdown('up');">&ShortUpArrow;</button>
                                    <button type="button" id='btndisable2'
                                        onclick="upNdown('down');">&ShortDownArrow;</button>

                                    <br>
                                    <br>
                                    <br>
                                    <button class="btn btn-success" style=" display: none;" type="submit"
                                        id="package_wf_update" name="package_wf_update">Update</button>
                                    <button class="btn btn-primary" type="submit" id="package_work_flow"
                                        name="submit">Submit</button>
                                    <button class="btn btn-warning" type="reset" id="reset" name="reset">Clear</button>
                                    <button class="btn btn-danger" type="button" id="cancelbtn"
                                        onclick="cancelpackage()" name="cancel_form">Cancel</button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- basic table -->
        <div class="row">

            <div class="col-12">
                <div class="material-card card">
                    <div class="card-body">
                        <h4 class="card-title">WorkFlow Details</h4>
                        <div class=" pull-right" id="proj_button"><button class="btn btn-primary" type="button"
                                onclick="create_newproj();"><i class="icon-plus"></i> &nbsp;Create New</button></div>


                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered border">
                                <thead>
                                    <tr>
                                        <th>Si No</th>
                                        <th>WorkFlow Name</th>
                                        <th>Active/Inactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $cls_comm->workflow_details();
                                    $res = json_decode($result, true);
                                    foreach ($res as $key => $value) {
                                        ?>
                                        <tr>
                                            <td>

                                                <?php echo $key + 1; ?>

                                            </td>
                                            <td>

                                                <?php echo $value['workflow_Master'] ?>


                                            </td>
                                            <td>
                                                <?php
                                                if ($value['active'] == '1') { ?>
                                                    <label class="switch"><input type="checkbox" value="1"
                                                            id="updatestatus<?php echo $value['Id']; ?>"
                                                            onchange="updatestatus('<?php echo $value['Id']; ?>');"
                                                            checked><span class="slider round"></span></label>
                                                    <!--<input type="checkbox" data-plugin="switchery" data-color="#9261c6" data-size="small" checked>-->
                                                <?php } else { ?>
                                                    <label class="switch"><input type="checkbox" value="0"
                                                            id="updatestatus<?php echo $value['Id']; ?>"
                                                            onchange="updatestatus('<?php echo $value['Id']; ?>');"><span
                                                            class="slider round"></span></label>
                                                    <!--<input type="checkbox" data-plugin="switchery" data-color="#9261c6" data-size="small"/>-->
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <span onclick="view_detail('<?php echo $value['Id']; ?>')"
                                                    class="badge badge-pill badge-primary font-medium text-white ml-1"
                                                    style=" cursor: pointer;" data-toggle="tooltip"> view</span>
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
    include_once ('layout/foot_banner.php');
    ?>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->


<?php
include_once ('layout/rightsidebar.php');
include_once ('layout/footer.php');
?>
<script src="code/js/ops.js" type="text/javascript"></script>
<script>
    var index; // variable to set the selected row index
    function getSelectedRow() {
        var table = document.getElementById("table");
        for (var i = 1; i < table.rows.length; i++) {
            table.rows[i].onclick = function () {
                // clear the selected from the previous selected row
                // the first time index is undefined
                if (typeof index !== "undefined") {
                    table.rows[index].classList.toggle("selected");
                }

                index = this.rowIndex;
                this.classList.toggle("selected");

            };
        }

    }


    getSelectedRow();

    function create_newproj() {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('#workflow_master').show()
        $('#table').show()
        $('#view_table').hide()
    }

    function cancelpackage() {
        $('#workflow_master').hide()
    }

    // function view_detail(id) {

    //     $.post("code/workflow.php", {
    //         key: id
    //     }, function (data) {
    //         var cat_name = JSON.parse(data).name;
    //         var days = JSON.parse(data).days;
    //         var active = JSON.parse(data).active;
    //         if (active = 1) {
    //             $("#active_flag").prop("checked", true);
    //         } else {
    //             $("#active_flag").prop("checked", false);
    //         }
    //         $('#workflow_master').show();
    //         $('#pc_id').val(id);
    //         $('#package_work_flow').hide();
    //         $('#package_wf_update').hide();
    //         $('#reset').hide();
    //         $('#cancelbtn').hide();
    //         $('#btndisable1').hide();
    //         $('#btndisable2').hide();
    //         $('#workflow_name').val(cat_name);
    //         $("#workflow_name ").attr("readonly", true);
    //         $(".readonly ").attr("disabled", true);
    //         days.sort(function (a, b) {
    //             return a.stage_id - b.stage_id;
    //         });
    //         $(days).each(function (key, value) {
    //             console.log(value);
    //             $('#days' + value.stage_id).val(value.days);
    //             $('#did' + value.stage_id).val(value.did);

    //             $("#check" + value.stage_id).prop("checked", true);
    //             $("#days" + value.stage_id).attr("disabled", true);
    //             $("#check" + value.stage_id).attr("disabled", true);
    //             //  $("#check"+value.stage_id).prop("checked", $(this).prop("checked"));
    //         });
    //     });

    // }


    function view_detail(id) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        $('#table').hide()
        $('#view_table').show()
        $.post("code/workflow.php", { key: id }, function (data) {
            var cat_name = JSON.parse(data).name;
            var days = JSON.parse(data).days;
            var active = JSON.parse(data).active;

            if (active === 1) {
                $("#active_flag").prop("checked", true);
            } else {
                $("#active_flag").prop("checked", false);
            }

            $('#workflow_master').show();
            $('#pc_id').val(id);
            $('#package_work_flow').hide();
            $('#package_wf_update').hide();
            $('#reset').hide();
            $('#cancelbtn').hide();
            $('#btndisable1').hide();
            $('#btndisable2').hide();
            $('#workflow_name').val(cat_name);
            $("#workflow_name").attr("readonly", true);
            $(".readonly").attr("disabled", true);
            // Hide the table with ID 'table'

            // Clear existing rows from the table body
            $("#view_table tbody").empty();

            // Append sorted stages to the table body
            $(days).each(function (index, value) {
                $('#view_table tbody').append(
                    `<tr>
                    <td>${index + 1}</td>
                    <td>${value.stage_name}</td>
                    <td>${value.days}</td>
                </tr>`
                );
            });
        });
    }



    function upNdown(direction) {
        var rows = document.getElementById("table").rows,
            parent = rows[index].parentNode;
        if (direction === "up") {
            if (index > 1) {
                parent.insertBefore(rows[index], rows[index - 1]);
                // when the row go up the index will be equal to index - 1
                index--;
            }
        }

        if (direction === "down") {
            if (index < rows.length - 1) {
                parent.insertBefore(rows[index + 1], rows[index]);
                // when the row go down the index will be equal to index + 1
                index++;
            }
        }
    }
    function change(id) {
        var Days = $('#days' + id).val();
        if (Days == '') {
            alert("Please Enter Days");
            $('#check' + id).prop("checked", false);
            return false;
        }
    }
    function updatestatus(id) {
        if ($('#updatestatus' + id).is(':checked')) {
            var active = '1'; // checked
        } else {
            active = '0'; // unchecked
        }
        $.post("code/workflow_status.php", {
            id: id, active: active
        }, function (data) {
            alert("Updated Successfully");
        });
    }
</script>