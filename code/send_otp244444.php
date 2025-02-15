<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
include_once ("../config/inc_function.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid = $_SESSION['uid'];
$old_uname = $_POST['old_uname'];
$uname = $_POST['uname'];

$date = date('Y-m-d H:i:s');
$otp = generateNumericOTP(6);
$sql = "select * from usermst where uid='" . $uid . "' and uname='" . $old_uname . "'";
$query = mssql_query($sql);
$count = mssql_num_rows($query);
if ($count > 0) {
    $up=mssql_query("update uname_log set status='1' where  uid='" . $uid . "' ");
    if($up){
        $sql = "insert into uname_log(uid, old_uname, uname, otp, created_date) values('" . $uid . "','" . $old_uname . "','" . $uname . "','" . $otp . "','" . $date . "')";
        $query = mssql_query($sql);
        sendmail($uname, $otp);
        if($query){
            echo 1;
        }
    }
} else {
    echo 0;
}

// Function to generate OTP
function generateNumericOTP($n)
{
  $generator = "1357902468";
  $result = "";
  for ($i = 1; $i <= $n; $i++) {
    $result .= substr($generator, rand() % strlen($generator), 1);
  }
  return $result;
}

function sendmail($email, $otp){

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1:8000/api/MailSendOtp");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$email&otp=$otp");

  // In real life you should use something like:
  // curl_setopt($ch, CURLOPT_POSTFIELDS, 
  //          http_build_query(array('postvar1' => 'value1')));

  // Receive server response ...
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $server_output = curl_exec($ch);

  curl_close($ch);

  //echo $server_output; exit;
}

?>