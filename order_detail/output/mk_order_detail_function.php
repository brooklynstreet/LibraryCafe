<?php
    function createMysqlConnection()
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
    
    
    function updatemk_order_detail(
         $id, $food_id, $order_id, $qty, $status
                )
    {
        $conn= createMysqlConnection();
        
        $sql = "UPDATE mk_order_detail SET
                    food_id =      ?, order_id =      ?, qty =      ?, status =      ?
                    WHERE id =  ?";
                    
        echo  $sql."<br/>";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("iiisi", 
                            $food_id, $order_id, $qty, $status
                           
                           ,$id);
        
        $isSuccess = false;
        if ($stmt->execute()  === TRUE)
        {
            $isSuccess = true;
        } else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();
        return $isSuccess;

    }
    function deletemk_order_detail($id)
    {
        $conn= createMysqlConnection();
        
        $sql = "DELETE FROM mk_order_detail WHERE id = ?" ;
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",$id);
        
        if ($stmt->execute() === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
        $conn->close();

    }
       
    function getAllmk_order_detail()
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM mk_order_detail ORDER BY id";
        $result = $conn->query($sql);
        
        $mk_order_details = array();
        if ($result->num_rows > 0)
        {
            // output data of each row
            while($row = $result->fetch_assoc())
            {
                $mk_order_details_row = array(
                            "id"=>$row["id"],
                                "food_id"=>$row["food_id"],
                                "order_id"=>$row["order_id"],
                                "qty"=>$row["qty"],
                                "status"=>$row["status"],
                                "insert_time"=>$row["insert_time"]
                                       );
                array_push($mk_order_details,$mk_order_details_row);
            }
        } else {
            echo "0 results";
        }
        
        $conn->close();
        return   $mk_order_details;
    }

    function getmk_order_detailByid($id)
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM mk_order_detail WHERE id = ?"; //////////////////////
        
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("i",$id);
        $stmt->execute();
        
        
        $stmt->bind_result(
                           
                            $id, $food_id, $order_id, $qty, $status, $insert_time
                          );
       
        
        $mk_order_details = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_order_details_row = array(
                            "id"=>$id,
                                "food_id"=>$food_id,
                                "order_id"=>$order_id,
                                "qty"=>$qty,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                    
                                   );
            array_push($mk_order_details,$mk_order_details_row);
        }
       $stmt->close();
        $conn->close();
        return   $mk_order_details;
    }

//%' AND  '1' =  '1' UNION SELECT * , 1, 1, 1 FROM  `users`  WHERE '1' = '1
    function searchmk_order_detail($name_search,$column_name_to_search)
    {
        $conn= createMysqlConnection();
        
        $sql = "SELECT *  FROM mk_order_detail WHERE `$column_name_to_search` LIKE ?   "; //////////////////////
        echo "$sql";
        $stmt = $conn->prepare( $sql);
        $stmt-> bind_param("s",$name_search);
        $stmt->execute();
        //$result = $stmt->get_result();
        
        $stmt->bind_result(
                           
                            $id, $food_id, $order_id, $qty, $status, $insert_time
                          );
       
        
        $mk_order_details = array();
       
        // output data of each row
        while($stmt->fetch())
        {
            $mk_order_details_row = array(
                            "id"=>$id,
                                "food_id"=>$food_id,
                                "order_id"=>$order_id,
                                "qty"=>$qty,
                                "status"=>$status,
                                "insert_time"=>$insert_time
                                    
                                   );
            array_push($mk_order_details,$mk_order_details_row);
        }
        $stmt->close();
        $conn->close();
        return   $mk_order_details;
    }
?>