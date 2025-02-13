 
<?php

require_once("../dbcon.php");
$year=$_POST['year'];
$sql="select * from ehs_alert_docs where year(created_date)='".$year."' order by created_date DESC ";
$query= mssql_query($sql);
$i=0;
while ($row = mssql_fetch_array($query)) { ?>
    <tr id="roeid<?php echo $row['ehs_docid'];?>">
        <td><?php echo $i+1;?></td>
        <td><?php echo $row['doc_name'];?></td>
        <td><?php echo date('d-M-y', strtotime($row['created_date']));?></td>
      <td><a href="ehs_pdf/<?php echo $row['ehs_file_name']; ?>" target="_blank"> <img src="image/icon_pdf.png" style=" width:25px; height:25px; border-radius:50%;" alt=""/></a></td>
    </tr>
<?php $i++; }

?>
 