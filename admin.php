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
$sql = "SELECT id, title, start, _end, color FROM events ";
$query = mssql_query($sql);
//$req = $con->prepare($sql);
//$req->execute();
//$events = mssql_fetch_array($query);
$events = array();
while ($row = mssql_fetch_array($query)) {
    $events[] = $row;
}
//print_r($events);
?>
<style>
    .col-lg-2{
        padding-right:5px;
        padding-left:0px;
    }
    /*    .d-flex.flex-row {
            padding-top: 14px;
            padding-bottom: 15px;
        }*/
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
                <!--<h5 class="font-medium text-uppercase mb-0">Calendar - <?php // echo  $_SESSION["csrf_token1"];?></h5>-->
                <h5 class="font-medium text-uppercase mb-0">Dashboard </h5>
            </div>
            <div class="col-lg-2 col-md-3 col-xs-12 align-self-center" >                
              
            </div>
            <div class="col-lg-6 col-md-8 col-xs-12 align-self-center">
                <!-- <button class="btn btn-danger text-white float-right ml-3 d-none d-md-block">Buy Ample Admin</button> -->
                <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                    <ol class="breadcrumb mb-0 justify-content-end p-0 bg-light">
                        <li class="breadcrumb-item"><a href="admin">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
        <!-- Card Group  -->
        <!-- ============================================================== -->

        <div class="row">

            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <!-- <div class="calender-sidebar">
                        <div id="calendar"></div>
                    </div> -->
                    <!-- BEGIN MODAL -->

                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="addEvent.php">

                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add Event</h4>     
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            </div>
                            <div class="modal-body">

                                <div class="form-row">
                                    <label for="title" class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                    </div>
                                </div><br>
                                <div class="form-row">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Choose</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                            <option style="color:#000;" value="#000">&#9724; Black</option>

                                        </select>
                                    </div>
                                </div><br>
                                <div class="form-row">
                                    <label for="start" class="col-sm-2 control-label">Start date</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="start" class="form-control" id="start" readonly>
                                    </div>
                                </div><br>
                                <div class="form-row">
                                    <label for="end" class="col-sm-2 control-label">End date</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="end" class="form-control" id="end" readonly>
                                    </div>
                                </div><br>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form class="form-horizontal" method="POST" action="editEventTitle.php">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Edit Event</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                            </div>
                            <div class="modal-body">

                                <div class="form-row">
                                    <label for="title" class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title" class="form-control" id="title" placeholder="Title">
                                    </div>
                                </div><br>
                                <div class="form-row">
                                    <label for="color" class="col-sm-2 control-label">Color</label>
                                    <div class="col-sm-10">
                                        <select name="color" class="form-control" id="color">
                                            <option value="">Choose</option>
                                            <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                            <option style="color:#008000;" value="#008000">&#9724; Green</option>						  
                                            <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                            <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                            <option style="color:#000;" value="#000">&#9724; Black</option>

                                        </select>
                                    </div>
                                </div><br>
                                <div class="form-row"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" class="form-control" id="id">


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                    $(document).ready(function () {
                        var today = new Date($.now());
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,basicWeek,basicDay'
                            },
                            defaultDate: today,
                            editable: true,
                            eventLimit: true, // allow "more" link when too many events
                            selectable: true,
                            selectHelper: true,
                            select: function (start, end) {

                                $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                                $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                                $('#ModalAdd').modal('show');
                            },
                            eventRender: function (event, element) {
                                element.bind('dblclick', function () {
                                    $('#ModalEdit #id').val(event.id);
                                    $('#ModalEdit #title').val(event.title);
                                    $('#ModalEdit #color').val(event.color);
                                    $('#ModalEdit').modal('show');
                                });
                            },
                            eventDrop: function (event, delta, revertFunc) { // si changement de position

                                edit(event);

                            },
                            eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                                edit(event);

                            },
                            events: [
<?php
foreach ($events as $event):

    $start = explode(" ", $event['start']);
    $end = explode(" ", $event['_end']);
    if ($start[1] == '00:00:00.000') {
        $start = $start[0];
    } else {
        $start = $event['start'];
    }
    if ($end[1] == '00:00:00.000') {
        $end = $end[0];
    } else {
        $end = $event['_end'];
    }
    ?>
                                    {
                                        id: '<?php echo $event['id']; ?>',
                                        title: '<?php echo $event['title']; ?>',
                                        start: '<?php echo date('Y-m-d', strtotime($start)); ?>',
                                        end: '<?php echo date('Y-m-d', strtotime($end)); ?>',
                                        color: '<?php echo $event['color']; ?>',
                                    },
<?php endforeach; ?>
                            ]
                        });

                        function edit(event) {

                            start = event.start.format('YYYY-MM-DD HH:mm:ss');
                            if (event.end) {
                                end = event.end.format('YYYY-MM-DD HH:mm:ss');
                            } else {
                                end = start;
                            }

                            id = event.id;

                            Event = [];
                            Event[0] = id;
                            Event[1] = start;
                            Event[2] = end;

                            $.ajax({
                                url: 'editEventDate.php',
                                type: "POST",
                                data: {Event: Event},
                                success: function (rep) {
//                                    alert(rep);
                                    if ($.trim(rep) == 'OK') {
                                        swal('Saved');
                                    } else {
                                        swal('Could not be saved. try again.');
                                    }
                                }
                            });
                        }

                    });
</script>
<script>
            function login() {
                var user='SWIFTUSERS';
                $.post("assets/insertlog.php", {key: user}, function (data) {                    

                });
            }
            login();
        </script>