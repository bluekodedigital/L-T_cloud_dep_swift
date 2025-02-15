<?php 
if(isset($_POST['pass']) && $_POST['pass'] != ""){
  $pass = $_POST['pass'];

  $myfile = fopen("pass.txt", "r") or die("Unable to open file!");
  $opass  = fread($myfile, filesize("pass.txt"));
  fclose($myfile);

  if($pass == $opass){
    echo 1;
  }
  else{
    echo 2;
  }

}
else{
  echo 0;
}