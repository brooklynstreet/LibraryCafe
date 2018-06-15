<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Tabs - Default functionality</title>
  <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
  <script src="jquery-2.1.3.min.js"></script>
  <script src="jquery-ui/jquery-ui.js"></script>
  <!--Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="library.css" rel="stylesheet">
  <script>
  var all_foods;
  var categories;
  var count;
  var ordertablenow;
  var orderDetailWaitConfirm; // keep data DetailWaitConfirm
  var orderDetailConfirm;
  ///POP UP
  function showPopup()
  {
    $(".popupBackground").css("visibility","visible");
    $(".popup").css("visibility","visible");
  }
  function closePopup()
  {
    $(".popupBackground").css("visibility","hidden");
    $(".popup").css("visibility","hidden");
  }
  ///END POP UP
  
  ///ORDER DETAIL(ORDER FOOD)
  
  function getOrderDetail()
  {
    setTimeout(
          function()
          { 
            $(function()
            {
              //$( "#tabs" ).tabs();
              getOrderDetailToShow_wait_confirm();
              getOrderDetailToShow_confirmed();
            });
          }, 1000
        );
      getOrderDetailAuto();
  }
  function getOrderDetailAuto()
  {
    setInterval(
      function()
      {
        getOrderDetailToShow_wait_confirm();
        getOrderDetailToShow_confirmed();
      }, 3000
      );
  }
  function orderFood(food_id_x)
  {
    $.post("create_order_detail.php",
      {
        food_id: food_id_x,
        order_id: ordertablenow[0].id
      })
      .done(function(data){
        //alert("Data Loaded: "+data);
        console.log("POST ORDER DETAIL FINISH"+data);
        getOrderDetailToShow_wait_confirm();
      });
  }
  function getOrderDetailToShow_wait_confirm()
  {
    $.post("get_all_order_detail_by_order_id.php",
      {
        status: "wait_confirm",
        order_id: ordertablenow[0].id
      })
      .done(function(data){
        //alert("Data Loaded: "+data);
        console.log("POST ORDER DETAIL FINISH"+data);
        showOrderDetailWaitConfirm(data);
      });
  }
  function getOrderDetailToShow_confirmed()
  {
    $.post("get_all_order_detail_by_order_id.php",
      {
        status: "confirmed|served",
        order_id: ordertablenow[0].id
      })
      .done(function(data){
        //alert("Data Loaded: "+data);
        console.log("POST ORDER DETAIL FINISH"+data);
        showOrderDetailConfirm(data);
      });
  }
  function confirmOrderDetail(OrderDetailID)
  {
    $.post("confirm_order_detail.php",
      {
        order_detail_id: OrderDetailID
      })
      .done(function(data){
        //alert("Data Loaded: "+data);
        console.log("POST CONFIRMED ORDER DETAIL FINISH"+data);
        getOrderDetailToShow_wait_confirm();
        getOrderDetailToShow_confirmed();
      });
  }
  function showOrderDetailWaitConfirm(data)
  {
    orderDetailWaitConfirm = JSON.parse(data);
    /*
                                "id"=>$id,
                                "food_id"=>$food_id,
                                "order_id"=>$order_id,
                                "qty"=>$qty,
                                "status"=>$status,
                                "insert_time"=>$insert_time,
                                "food_id_x"=>$food_id_x,
                                "food_name"=>$food_name,
                                "food_description"=>$food_description,
                                "food_price"=>$food_price,
                                "food_image"=>$food_image,
                                "food_cat_id"=>$food_cat_id
    */
    var template =
      "<tr> \
        <td> \
          {{[[--id--]]}} \
        </td>\
        <td> \
          {{[[--food_id--]]}} \
        </td> \
        <td> \
          {{[[--order_id--]]}} \
        </td> \
        <td> \
          {{[[--qty--]]}} \
        </td> \
        <td> \
          {{[[--status--]]}} \
        </td> \
        <td> \
          {{[[--insert_time--]]}} \
        </td> \
        <td> \
          {{[[--food_id_x--]]}} \
        </td> \
        <td> \
          {{[[--food_name--]]}} \
        </td> \
        <td> \
          {{[[--food_description--]]}} \
        </td> \
        <td> \
          {{[[--food_price--]]}} \
        </td> \
        <td> \
          {{[[--food_image--]]}} \
        </td> \
        <td> \
          {{[[--food_cat_id--]]}} \
        </td> \
        <td> \
         <button id = 'food_confirm_{{[[--id--]]}}' order-detail-id = '{{[[--id--]]}}'>confirm</button> \
        </td> \
      </tr> \
      ";
      $("#wait_confirm_table").empty();
      for(var i = 0; i < orderDetailWaitConfirm.length; i++)
      {
        row_now = template;
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailWaitConfirm[i].id);
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailWaitConfirm[i].id);
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailWaitConfirm[i].id);
        row_now = row_now.replace("{{[[--food_id--]]}}", orderDetailWaitConfirm[i].food_id);
        row_now = row_now.replace("{{[[--order_id--]]}}", orderDetailWaitConfirm[i].order_id);
        row_now = row_now.replace("{{[[--qty--]]}}", orderDetailWaitConfirm[i].qty);
        row_now = row_now.replace("{{[[--status--]]}}", orderDetailWaitConfirm[i].status);
        row_now = row_now.replace("{{[[--insert_time--]]}}", orderDetailWaitConfirm[i].insert_time);
        row_now = row_now.replace("{{[[--food_id_x--]]}}", orderDetailWaitConfirm[i].food_id_x);
        row_now = row_now.replace("{{[[--food_name--]]}}", orderDetailWaitConfirm[i].food_name);
        row_now = row_now.replace("{{[[--food_description--]]}}", orderDetailWaitConfirm[i].food_description);
        row_now = row_now.replace("{{[[--food_price--]]}}", orderDetailWaitConfirm[i].food_price);
        row_now = row_now.replace("{{[[--food_image--]]}}", orderDetailWaitConfirm[i].food_image);
        row_now = row_now.replace("{{[[--food_cat_id--]]}}", orderDetailWaitConfirm[i].food_cat_id);
        $("#wait_confirm_table").append(row_now);
        
        // add event to confirm button
        $("#food_confirm_"+orderDetailWaitConfirm[i].id).click(
          function foodconfirmBtn()
          {
            var OrderDetailID = $(this).attr('order-detail-id');
            confirmOrderDetail(OrderDetailID);
          }
        );
      }
      //$("#wait_confirm_table").append(row_now);
  }
  function showOrderDetailConfirm(data)
  {
    orderDetailConfirm = JSON.parse(data);
    /*
                                "id"=>$id,
                                "food_id"=>$food_id,
                                "order_id"=>$order_id,
                                "qty"=>$qty,
                                "status"=>$status,
                                "insert_time"=>$insert_time,
                                "food_id_x"=>$food_id_x,
                                "food_name"=>$food_name,
                                "food_description"=>$food_description,
                                "food_price"=>$food_price,
                                "food_image"=>$food_image,
                                "food_cat_id"=>$food_cat_id
    */
    var template =
      "<tr> \
        <td> \
          {{[[--id--]]}} \
        </td>\
        <td> \
          {{[[--food_id--]]}} \
        </td> \
        <td> \
          {{[[--order_id--]]}} \
        </td> \
        <td> \
          {{[[--qty--]]}} \
        </td> \
        <td> \
          {{[[--status--]]}} \
        </td> \
        <td> \
          {{[[--insert_time--]]}} \
        </td> \
        <td> \
          {{[[--food_id_x--]]}} \
        </td> \
        <td> \
          {{[[--food_name--]]}} \
        </td> \
        <td> \
          {{[[--food_description--]]}} \
        </td> \
        <td> \
          {{[[--food_price--]]}} \
        </td> \
        <td> \
          {{[[--food_image--]]}} \
        </td> \
        <td> \
          {{[[--food_cat_id--]]}} \
        </td> \
      </tr> \
      ";
      $("#confirmed_table").empty();
      for(var i = 0; i < orderDetailConfirm.length; i++)
      {
        row_now = template;
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailConfirm[i].id);
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailConfirm[i].id);
        row_now = row_now.replace("{{[[--id--]]}}", orderDetailConfirm[i].id);
        row_now = row_now.replace("{{[[--food_id--]]}}", orderDetailConfirm[i].food_id);
        row_now = row_now.replace("{{[[--order_id--]]}}", orderDetailConfirm[i].order_id);
        row_now = row_now.replace("{{[[--qty--]]}}", orderDetailConfirm[i].qty);
        row_now = row_now.replace("{{[[--status--]]}}", orderDetailConfirm[i].status);
        row_now = row_now.replace("{{[[--insert_time--]]}}", orderDetailConfirm[i].insert_time);
        row_now = row_now.replace("{{[[--food_id_x--]]}}", orderDetailConfirm[i].food_id_x);
        row_now = row_now.replace("{{[[--food_name--]]}}", orderDetailConfirm[i].food_name);
        row_now = row_now.replace("{{[[--food_description--]]}}", orderDetailConfirm[i].food_description);
        row_now = row_now.replace("{{[[--food_price--]]}}", orderDetailConfirm[i].food_price);
        row_now = row_now.replace("{{[[--food_image--]]}}", orderDetailConfirm[i].food_image);
        row_now = row_now.replace("{{[[--food_cat_id--]]}}", orderDetailConfirm[i].food_cat_id);
        $("#confirmed_table").append(row_now);
      }
      //$("#wait_confirm_table").append(row_now);
  }
  
  function addListenerToFoodTile(id)
  {
    var id_x = "#food_tile_id_"+id;
    //$(document).ready(function(){
      $(id_x).css('cursor','pointer');
      
      $(id_x).off();
      $(id_x).mouseover(function(){
        $(this).css("background-color","#aaa");
      });
      $(id_x).mouseout(function(){
        $(this).css("background-color","#FFF");
      });
      $(id_x).mousedown(function(){
        $(this).css("background-color","#aaf");
      });
      $(id_x).mouseup(function(){
        $(this).css("background-color","#aaa");
      });
      $(id_x).click(function(){
        
        var food_id_x = $(this).attr('food_id');
        console.log(food_id_x);
        orderFood(food_id_x);
        /*$(this).css("background-color","#aaf");
        setTimeout(function()
        {
          $(this).css("background-color","#aaa");
        }, 500);*/
      });
    //});  
  }
  function loadCategory()
  {
    console.log("a");
    $.get("category/output/ajax_get_all_category.php", function(data, status){
       console.log("b");
       var categorys = JSON.parse(data);
       categories = categorys;
       for(var i = 0 ; i < categorys.length ; i ++)
       {
          var x = "<li><a href='#food_category_"+categorys[i].id+"'>"+categorys[i].name+"</a></li>";
          $("#category_tab").append(x);
          var y = "<div id='food_category_"+categorys[i].id+"'>    \
                        <div style='height:350px;'>       \
                        </div>     \
                     </div>";
          $("#tabs").append(y);
       }
       ///

      loadFood();
    });
  }

  function loadFood()
  {
    count = 0;
    for(var i = 0 ; i < categories.length ; i ++)
    {
      $.ajax({
              url: "food/output/ajax_get_all_food.php?cat_id="+categories[i].id,
              context: (i+1)
            }).done(function(data) {
                  
                  var foods =  JSON.parse(data);
                  //all_foods.add(foods);
                  console.log("food");
                  for(var j =0 ; j < foods.length ; j++)
                  {
                    var tempalate_food = "<div id='food_tile_id_{{[[--ID--]]}}' class= 'foot_tile col-md-4' food_id= '{{[[--ID--]]}}' > \
                                <div class= 'foot_title'> \
                                  <img src='{{[[--IMAGE_PATH--]]}}'/> \
                                  <div class='headline'> \
                                    {{[[--NAME--]]}} \
                                  <div class='description'> \
                                    {{[[--DESCRIPTION--]]}} \
                                  </div> \
                                  <div class='price'> \
                                    {{[[--PRICE--]]}} baht\
                                  </div> \
                                </div> \
                              </div>";
                    var food = tempalate_food;
                    food = food.replace("{{[[--ID--]]}}", foods[j].id);
                    food = food.replace("{{[[--ID--]]}}", foods[j].id);
                    food = food.replace("{{[[--NAME--]]}}", foods[j].name);
                    food = food.replace("{{[[--DESCRIPTION--]]}}", foods[j].description);
                    food = food.replace("{{[[--IMAGE_PATH--]]}}", foods[j].image);
                    food = food.replace("{{[[--PRICE--]]}}", foods[j].price);
                    console.log(this-1);
                    console.log("categories[i].id" + categories[this-1].id);
                    
                    $("#food_category_"+categories[this-1].id + ">div").append(food);
                    addListenerToFoodTile(foods[j].id);
                  }
                  count++;
                  $(function() {
                     $( "#tabs" ).tabs();
                  });
            });
    }
  }
  $( document ).ready(function() {
        loadCategory();
        showPopup();
        
        //ให้มันรออันอื่นโหลดให้เสร็จก่อน
        
        $("#btn_open_table").click(function()  
            {
              ///validate
              var table_no_x = $("#table_number").val();
              if(!isNaN(parseInt(table_no_x)))
              {
                
              }
              else
              {
                $("#popup_numberOnly").show();
                return;
              }
              ///end validate
              console.log("post to create_order.php, table_no: "+table_no_x);
              ///send http POST to create new table or open exist table
              $.post("create_order.php",
                     {table_no:table_no_x})
                      .done(function(data){
                        //alert("Data Loaded: "+data);
                        console.log("POST FINISH"+data);
                        ordertablenow = JSON.parse(data);
                        var c = "id : "+ordertablenow[0].id +
                        " ,table_no : "+ordertablenow[0].table_no +
                        " ,status : "+ordertablenow[0].status +
                        " ,insert_time : "+ordertablenow[0].insert_time;
                        $("#ordertablenow").html(c);
                          //getOrderDetailToShow_wait_confirm();
                          closePopup();
                          getOrderDetail();
                      });
                 
            });
         
  });
  </script>
</head>
<body>

  <div class="container-fluid" style= "margin:0px;padding:0px;">
    <div class="popupBackground">
      <div class="popup">
        <h1>WELCOME TO LIBRARY CAFE</h1>
          
            <div class="form-group">
              <label for="table_number">Table no.</label>
                <div id="popup_numberOnly" style="color: red; display: none;">Please input table no.</div>
                <input type="text" class="form-control" id="table_number" placeholder="Enter Table no">
            </div>
            <button id = "btn_open_table" class="btn btn-default">Submit</button>
      </div>
    </div>
  </div>
  <div id="tabs">
    <ul id="category_tab">
      <li><a href = "#1" >รายการที่สั่ง</a></li>
    </ul>
    <div id="order_list">
                  
      <br/>
      <div id="ordertablenow"></div>
      
      <br/>
      <h1>รอการยืนยัน</h1>
      <br/>
      <div class="wait_confirm">
        <table class="table table-bordered thead-dark">
          <tbody id = "wait_confirm_table"> 
            <tr>
              <th>id</th>           
              <th>food_id</th>             
              <th>order_id</th>            
              <th>qty</th>                 
              <th>status</th>              
              <th>insert_time</th>         
              <th>food_id_x</th>           
              <th>food_name</th>           
              <th>food_description</th>    
              <th>food_price</th>          
              <th>food_image</th>          
              <th>food_cat_id</th>
              <th>submit</th>
            </tr>
          </tbody>
        </table>
      </div>
      
      <br/>
      <br/>
      <h1>ได้รับการยืนยันแล้ว</h1>
      <br/>
      <br/>
      
      <div class="confirmed">
        <table class="table table-bordered thead-dark">
          <tbody id = "confirmed_table"> 
            <tr>
              <th>id</th>           
              <th>food_id</th>             
              <th>order_id</th>            
              <th>qty</th>                 
              <th>status</th>              
              <th>insert_time</th>         
              <th>food_id_x</th>           
              <th>food_name</th>           
              <th>food_description</th>    
              <th>food_price</th>          
              <th>food_image</th>          
              <th>food_cat_id</th>                    
            </tr>
          </tbody>
        </table>
      </div>
    
    </div>
  </div>
  
                                
  <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>