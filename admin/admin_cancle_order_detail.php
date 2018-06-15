<?php
    require_once('../library_function.php');
    $order_detail_id = $_GET['order_detail_id'];
    $newStatus = "cancle";
    change_orderDetail_status($order_detail_id, $newStatus);

?>