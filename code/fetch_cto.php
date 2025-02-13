<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once ("../config/inc_function.php");

$pack_id = mssql_escape($_POST['pack']);
$projid = mssql_escape($_POST['proj']);

$sql =  "select * from Project where proj_id='".$projid."'";
$qry= mssql_query($sql);
$row = mssql_fetch_array($qry);
$seg = $row['cat_id'];

$result = $cls_user->fetchcto($seg,$_SESSION['milcom']);
$res = json_decode($result, true);
?>
<label for="doc_name">Select CTO</label>
<select class="custom-select" name="cto_user_id" id="cto_user_id"  required=""> 
<?php 
foreach ($res as $key => $value) { ?>
    <option value="<?php echo $value['uid']; ?>"><?php echo $value['name']; ?></option>
<?php }
?>
</select>
