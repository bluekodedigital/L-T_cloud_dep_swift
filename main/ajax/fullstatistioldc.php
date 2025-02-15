<?php require_once("../dbcon.php"); 
$archart = array(array("Date","Visits")); $archart1 = array(array("Project","Visits")); ?>
<div style=" border: 1px solid #003f72;border-top: 0;float: left;width: 100%;">
<h4 style="text-align: center;font-weight: 600; color: #1f66ad;padding: 10px 0;border-bottom: 1px solid;margin-top: 0"> <?php echo $mod = $_POST['mod']; ?></h4>
<div class="col-md-7" style="height: 400px; overflow-y: auto;">
<table class="table">
    <thead>
      <tr>
        <th>UserName</th>
        <th>Project</th>
        <th>Ip</th>
        <th>Date</th>
        <th>Time</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $fdate = strtotime($_POST['from']); $from = date('Y-m-d',$fdate); $tdate = strtotime($_POST['to']." +1 day"); $to = date('Y-m-d',$tdate); 
      $logq = mssql_query("SELECT * FROM Log_log WHERE L_date>'$from' AND L_date<'$to' AND L_module = '$mod' ORDER BY L_date DESC");
      while($logs =mssql_fetch_array($logq)){
            $ddate = strtotime($logs['L_date']);
            
      ?>
      <tr>
        <td><?php echo $logs['L_name']; ?></td>
        <td><?php echo $logs['L_projid']; ?></td>
        <td><?php echo $logs['L_Ip']; ?></td>
        <td><?php echo date('d-M-Y', $ddate); ?></td>
        <td><?php echo date('h:i:s a', $ddate); ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
  <?php 
  $ctq1 = mssql_query("SELECT COUNT(L_projid) AS qty, L_projid FROM log_log WHERE L_date>'$from' AND L_date<'$to' AND L_module = '$mod' GROUP BY L_projid ORDER BY L_projid ASC");
    
    if(mssql_num_rows($ctq1) > 0){
      while($arr1 = mssql_fetch_array($ctq1)){
        array_push($archart1, array(
          $arr1['L_projid'],
          $arr1['qty']
        )); 
      } 
    }

  while (strtotime($from) <= strtotime($to)) {
    $dt = date("Y-m-d", strtotime($from));
    $ctq = mssql_query("SELECT COUNT(L_module) AS qty,CONVERT(DATE,L_date) AS tdate FROM Log_log WHERE CONVERT(DATE,L_date) = '".$dt."' AND L_module = '$mod' 
GROUP BY CONVERT(DATE,L_date)");
    
    if(mssql_num_rows($ctq) > 0){
      $arr = mssql_fetch_array($ctq); 
      array_push($archart, array(
              date ("Y-M-d", strtotime($arr['tdate'])),
              $arr['qty']
            )); 
    }
    

    $from = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
  }
  
  //print_r($archart1);
   ?>
   <div style="text-align: center;">
      <input type="button" name="chart-btn" onclick="drawChart();"  class="btn btn-info" id="chart-btn" value="Daywise">
      <input type="button" name="chart-btn" style="background: rgb(255, 153, 0); border-color: rgb(255, 153, 0);" onclick="drawChart1();" class="btn btn-danger" id="chart-btn" value="Projectwise">
   </div>
   
  <div class="col-md-5" id="area-chart" style="height: 400px;"></div>
  </div>
  <div class="col-md-12 hidden">
    <input type="button" name="back-stat" id="back-stat" class="btn btn-info " style="float:right" value="Back">
  </div>
  <script type="text/javascript">

    $("#back-stat").on("click", function(){
          var from = $("#from").val();
          var to   = $("#to").val();
          var req  = $.ajax({
                type : "post",
                url  : "ajax/statistic.php",
                data : {from : from , to : to}
          });
          req.done(function(data){
                $("#myModal4 #mod4-cont").html(data);
          });
    });
  </script>
  <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($archart); ?>);

        // create data view
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, {
          calc: 'stringify',
          role: 'annotation',
          sourceColumn: 1,
          type: 'string'
        }]);

        var options = {
          chartArea: {
            left: 60,
            right:20
          },
          title: 'Daywise Visit',
          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'},
            minTextSpacing: 0,
            showTextEvery: 1,
            slantedText: true
          },
          annotations: {
            textStyle: {
              color: '#333',
            }
          },
          "legend":"none","colors":['rgb(91, 192, 222)'],
          vAxis: {minValue: 0},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('area-chart'));
        chart.draw(view, options);
      }

      function drawChart1() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($archart1); ?>);

        // create data view
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1, {
          calc: 'stringify',
          role: 'annotation',
          sourceColumn: 1,
          type: 'string'
        }]);

        var options = {
          chartArea: {
            left: 60,
            right:20
          },
          title: 'Projectwise Visit',
          hAxis: {title: 'Project',  titleTextStyle: {color: '#333'},
            minTextSpacing: 0,
            showTextEvery: 1,
            slantedText: true
          },
          annotations: {
            textStyle: {
              color: '#333',
            }
          },
          "legend":"none","colors":['rgb(255, 153, 0)'],
          vAxis: {minValue: 0},
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('area-chart'));
        chart.draw(view, options);
      }
    </script>