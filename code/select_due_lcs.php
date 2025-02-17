<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");
$uid = $_SESSION['uid'];

$date = mssql_escape($_POST['key']);
$start = new DateTime(formatDate($date, 'd-M-Y'));
$ltime = date('d-M-Y');
$end = new DateTime($ltime);
$days = round(($start->format('U') - $end->format('U')) / (60 * 60 * 24));

$due = formatDate($date, 'Y-m-d');

$select_lcmaster_bydue = $cls_lc->select_lcmaster_bydue_filter($due);
$lc_detl = json_decode($select_lcmaster_bydue, true);
if ($date != 'all') {
    ?>
    <option value="">-- Select LC Number--</option>
    <?php foreach ($lc_detl as $key => $value) { ?>
        <option value="<?php echo $value['lcm_id'] ?>"  ><?php echo $value['lcm_num'] ?></option>
    <?php }
    ?>  
    <?php
} else {
    $select_lcmaster_bydueall = $cls_lc->select_lcmaster_bydue_filter_all();
    $lc_detlall = json_decode($select_lcmaster_bydueall, true);
    ?>
    <option value="">-- Select LC Number--</option>
    <?php foreach ($lc_detlall as $key => $value) { ?>
        <option value="<?php echo $value['lcm_id'] ?>"  ><?php echo $value['lcm_num'] ?></option>
    <?php }
    ?> 
<?php }
?>
