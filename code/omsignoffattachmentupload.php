<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once ("../config/inc_function.php");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Count # of uploaded files in array
// echo $total = count($_FILES['myfile']['name']);
$errors= array();
$filename= array();
// Loop through each file

      $file_name = rand().'-'.$_FILES['myfile']['name'];
      $file_size =$_FILES['myfile']['size'];
      $file_tmp =$_FILES['myfile']['tmp_name'];
      $file_type=$_FILES['myfile']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['myfile']['name'])));
      
      $target_dir = "uploads/";
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
     
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,'../uploads/op_exp/'.$file_name);
		 $filename[] = $file_name;
      }
echo $file_name;
// print_r($filename);

?>

