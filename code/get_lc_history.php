<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$uid = $_SESSION['uid'];
$lc = mssql_escape($_POST['key']);
?>
<div class="table-responsive">
    <table id="zero_config_lc" class="table table-bordered  ">
        <thead>
            <tr>
                <th></th>
                <th>LC Number</th>
                <th>Vendor</th>  
                <th>PO Number</th>                                                                            
                <th>PO Value</th>                                                                            
                <th>Supply Date</th>
                <th>Supply Value</th>
                <th>Supply Exchange Rate</th>
                <th>Payment Date</th>
                <th>Payment Value</th>                                     
                <th>Payment Exchange Rate</th>                                     

            </tr>
        </thead>
        <tbody>
            <?php
            $result = $cls_lc->select_supply_payment_report_view($lc);
            $res = json_decode($result, true);
            foreach ($res as $key => $value) {
                ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['lcm_num']; ?></td>
                    <td><?php echo $value['sup_name']; ?></td>
                    <td><?php echo $value['lcr_ponumber']; ?></td>
                    <td class=" text-right"><?php echo $value['lcr_povalue']; ?></td>
                    
                    <td><?php echo formatDate($value['lc_sdate'], 'd-M-Y'); ?></td>
                    <td class=" text-right"><?php echo $value['lc_sup_val']; ?></td>
                    <td><?php echo $value['lc_sup_ex_rate']; ?></td>
                    <td><?php
                        if ($value['paymet_date'] != "") {
                            echo formatDate($value['paymet_date'], 'd-M-Y');
                        }
                        ?></td>
                    <td class=" text-right"><?php echo $value['paymet_value']; ?></td>                                           
                    <td class=" text-right"><?php echo $value['paymet_exrate']; ?></td>                                           

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php ?>
