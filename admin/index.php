<?php
    require_once("../order/output/mk_order_function.php");
                
                
?>
<html>
    <head>
        <meta charset="UTF-8"/> 
        <title>ADMIN OF LIBRARY CAFE</title>
        <script src="../jquery-2.1.3.min.js"></script>
        <script>
            $( document ).ready(function() {
                loadTable();
            });
            function loadTable()
            {
                 $("#table").load("../order/output/mk_order_show_all_table.php",function(responseTxt,statusTxt,xhr)
		    {
                    });
            }
            function confirm_delete(id)
            {
                var r = confirm("คุณจะลบ id " + id + "จริงๆ เหรอ");
                if (r == true)
                {
                    //window.open("delete_customer.php?id="+id, "_self");
                    //ajax
                    $("#data").load("../order/output/mk_order_delete.php?id="+id,function(responseTxt,statusTxt,xhr)
                    {
                        console.log("b");
                        if(statusTxt=="success")
                        {
                            loadTable();
                        }
                        else if(statusTxt=="error")
                        {
                             alert("Error: "+xhr.status+": "+xhr.statusText);
                        }
                    });
                }
                else
                {
                    
                }
            }
        </script>
    </head>
    <body>
        <h1>LIBRARY CAFE ALL ORDER</h1>
        <div id="data"></div>
        <div id="table">
            
        </div>
        <br/>
    <body>
</html>