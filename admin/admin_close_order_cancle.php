<?php
    require_once('../library_function.php');
    $order_id = $_GET['order_id'];
    
    $new_status = "cancle";
    change_order_status($order_id, $new_status);
?>