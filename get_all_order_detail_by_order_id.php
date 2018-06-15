<?php
    require_once('library_function.php'); 
    $status = $_POST['status'];
    $order_id = $_POST['order_id'];
    $status = explode("|", $status);  
    //printr($status); use $_GET
    $data = get_all_orderDetail_by_order_id($status, $order_id);
    $orderDetail_json = json_encode($data);
    echo $orderDetail_json;
?>