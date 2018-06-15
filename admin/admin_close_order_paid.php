<?php
    //$order_id = $_POST['order_id'];
    $table_no = $_GET['table_no'];
    require_once('../library_function.php');
    $new_status = "paid";
    
    change_order_status($table_no, $new_status);
?>