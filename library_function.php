<?php
    require_once('order/output/mk_order_function.php');
    //require_once('order_detail/output/mk_order_detail_function.php');
    function createTable($table_no)
    {
        $order = isTableAlreadyOpenBill($table_no);
        if($order === FALSE)
        {
            $status = "open";
            insertNewmk_order($table_no, $status);
            searchmk_open_order($table_no);
        }
        return $order;
    }
    function order_food($food_id, $order_id)
    {
        $qty = 1;
        $status = "wait_confirm";
        insertNewmk_order_detail($food_id, $order_id, $qty, $status);
    }
    function isTableAlreadyOpenBill($table_no)
    {
        $order = searchmk_open_order($table_no);
        if(count($order) == 0)
        {
            return FALSE;
        }
        return $order;
    }
    function createMyConnection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test_librarycafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->query('SET NAMES UTF8;');
        return $conn;
    }
    function get_all_orderDetail_by_order_id($status, $order_id)
    {
        return getmk_order_detailByid_and_status($order_id, $status);
    }
    function confirm_orderDetail($orderDetail_id)
    {
        $mk_order_details = getmk_order_detailByid($orderDetail_id);
		//print_r($mk_order_details);
        if(count($mk_order_details) == 0)
        {
            echo "ERROR orderDatail ID dose not EXIT...!";
            exit;
        }
        if($mk_order_details[0]['status'] != 'wait_confirm')
        {
            exit;
        }
        $id = $orderDetail_id;
        $food_id = $mk_order_details[0]['food_id'];
        $order_id = $mk_order_details[0]['order_id'];
        $qty = $mk_order_details[0]['qty'];
        $status = "confirmed";
        echo "id= $id food_id= $food_id order_id=$order_id qty=$qty";
        updatemk_order_detail($id, $food_id, $order_id, $qty, $status);
    }
    function change_orderDetail_status($orderDetail_id, $new_status)
    {
        $mk_order_details = getmk_order_detailByid($orderDetail_id);
		print_r($mk_order_details);
        
        $id = $orderDetail_id;
        $food_id = $mk_order_details[0]['food_id'];
        $order_id = $mk_order_details[0]['order_id'];
        $qty = $mk_order_details[0]['qty'];
        $status = $new_status;
        echo "id= $id food_id= $food_id order_id=$order_id qty=$qty";
        updatemk_order_detail($id, $food_id, $order_id, $qty, $status);
    }
    function change_order_status($order_id, $new_status)
    {
        $mk_order = getmk_order_Byid($order_id);
		//print_r($order_id);
        
        $id = $order_id;
        $table_no = $order_id;//$mk_order[0]['table_no'];
        $status = $new_status;
        echo "id= $id, table_no= $table_no, status=$status";
        updatemk_order($id, $table_no, $status);
    }
    function searchmk_open_order($table_no)
    {
        $conn= createMyConnection();
        
        $sql = "SELECT *
                FROM mk_order
                WHERE `table_no` = ?
                AND `status` = 'open'
                ORDER BY id desc"; //////////////////////
        //echo "$sql";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$table_no);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result($id, $table_no, $status, $insert_time);
       
        
        $mk_orders = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_orders_row = array(
                            "id"=>$id,
                                "table_no"=>$table_no,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                    
                                   );
            array_push($mk_orders,$mk_orders_row);
        }
        $stmt->close();
        $conn->close();
        return $mk_orders;
    }
    function insertNewmk_order_detail($food_id, $order_id, $qty, $status)
    {
        $conn= createMysqlConnection();
        $sql = "INSERT INTO mk_order_detail(id, food_id, order_id, qty, status)
                VALUES (0,
                ?, ?, ?, ?
                )";

        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("iiis",$food_id, $order_id, $qty, $status);
        
        $isSuccess = false;
        if ($stmt->execute() === TRUE)
        {
            $isSuccess = true;
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();
        return $isSuccess;
    }
?>