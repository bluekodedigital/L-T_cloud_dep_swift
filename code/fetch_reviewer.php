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
if($_SESSION['milcom']=='1')
{
    $seg="38";
}else
{
   $seg=$seg;
}
$result = $cls_user->fetchreviewer($seg,$_SESSION['milcom']);
$res = json_decode($result, true);
?>
<label for="doc_name">Select Reviewer</label>
<select class="custom-select" name="reviewer" id="reviewer"  required=""> 
<?php 
foreach ($res as $key => $value) { ?>
    <option value="<?php echo $value['uid']; ?>"><?php echo $value['name']; ?></option>
<?php }
?>
</select>
