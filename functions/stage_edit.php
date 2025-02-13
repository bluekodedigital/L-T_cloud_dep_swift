<?php 
    include_once ("../config/inc_function.php");

    print_r($_REQUEST);
    $id = $_REQUEST['id'];
    $value=$_REQUEST['value'];

    $stage_name = "sakthi_stage";
    $stage_flag = 0;
    $display_order = 500;

    $data = array(
        'stage_id' => $id,
        'display_order' => $value
    );

    $result = $super_admin->disp_order_change($data);


?>
