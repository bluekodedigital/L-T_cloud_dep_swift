<?php require_once("../dbcon.php"); ?>

<table class="table" style="margin-top: 10px;">
    <thead>
      <tr>
        <th>Module</th>
        <th style="text-align: center;">Visiters</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $fdate = strtotime($_POST['from']); $from = date('Y-m-d',$fdate); $tdate = strtotime($_POST['to']." +1 day"); $to = date('Y-m-d',$tdate); 
      $logq = mssql_query("SELECT L_module, COUNT(L_module) AS cot FROM Log_log WHERE L_date>'$from' AND L_date<'$to'  GROUP BY L_module");
      while($logs =mssql_fetch_array($logq)){
            //$ddate = strtotime($logs['L_date']);
      ?>
      <tr>
        <td><a href="javascript:void(0);" onclick="fullstatistic('<?php echo $logs['L_module']; ?>');"><?php echo $logs['L_module']; ?></a></td>
        <td style="text-align: center;"><?php echo $logs['cot']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>