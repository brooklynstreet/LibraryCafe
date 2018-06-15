<?php
    require_once('../library_function.php');
    $order_detail_id = $_GET['order_detail_id'];
    $new_status = "served";
    change_orderDetail_status($order_detail_id, $new_status)
?>