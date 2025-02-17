 
<?php

require_once("../dbcon.php");
$sql="select * from dbo.ehs_alert_docs  order by created_date DESC";
$query= mssql_query($sql);

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    $ip = get_client_ip();



    $max_logq = mssql_query("SELECT MAX(L_id) as log FROM Log_log");
    if (mssql_num_rows($max_logq) > 0) {
        $max_log_arr = mssql_fetch_array($max_logq);
        $max_log = $max_log_arr['log'] + 1;
    } else {
        $max_log = 1;
    }

    $ins = mssql_query("INSERT INTO Log_log (L_id, L_module, L_projid, L_name, L_date, L_Ip) VALUES (" . $max_log . ",'EHS ALERT', 'EHS ALERT', 'USER', getdate(), '" . $ip . "')");
    
$i=0;
while ($row = mssql_fetch_array($query)) { ?>
    <tr id="roeid<?php echo $row['ehs_docid'];?>">
        <td><?php echo $i+1;?></td>
        <td><?php echo $row['doc_name'];?></td>
        <td><?php echo formatDate($row['created_date'], 'd-M-y');?></td>
        <td><a href="ehs_pdf/<?php echo $row['ehs_file_name']; ?>" target="_blank"> <img src="image/icon_pdf.png" style=" width:25px; height:25px; border-radius:50%;" alt=""/></a></td>
    </tr>
<?php $i++; }

?>
    