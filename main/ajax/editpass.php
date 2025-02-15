<?php 
if(isset($_POST['npass'])){
  $opass = $_POST['opass']; $npass = $_POST['npass']; $cpass = $_POST['cpass'];

  $myfile = fopen("pass.txt", "w") or die("Unable to open file!");
  $wrt  = fwrite($myfile, $npass);
  fclose($myfile);

  if($wrt == true){
    echo 1;
  }
  else{
    echo 2;
  }

}
else{
  echo 0;
}