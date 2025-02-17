 
<?php

require_once("../dbcon.php");
$sql="select * from ehs_alert_docs order by created_date DESC ";
$query= mssql_query($sql);
$i=0;
while ($row = mssql_fetch_array($query)) { ?>
    <tr id="roeid<?php echo $row['ehs_docid'];?>">
        <td><?php echo $i+1;?></td>
        <td><?php echo $row['doc_name'];?></td>
        <td><?php echo formatDate($row['created_date'], 'd-M-y');?></td>
        <td><a href="ehs_pdf/<?php echo $row['ehs_file_name']; ?>" target="_blank"> <img src="image/icon_pdf.png" style=" width:25px; height:25px; border-radius:50%;" alt=""/></a></td>
        <td><button id="ehs<?php echo $row['ehs_docid'];?>" onclick="delete_ehs('<?php echo $row['ehs_docid'];?>');">Trash</button></td>
    </tr>
<?php $i++; }

?>
 