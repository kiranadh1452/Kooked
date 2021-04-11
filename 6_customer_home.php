<?php
session_start();
require_once "config_main.php";
if(!isset($_SESSION["c_loggedin"]) || $_SESSION["c_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
$sql1 = "SELECT p_name, price, total_orders FROM product ORDER BY p_name ASC" ;

$result = $conn->query($sql1) ;
$food=array();
while($row = $result -> fetch_assoc()){
  $food[] = $row;
}
if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['my_btn'])){
    $data = trim($_POST['my_btn']);
    $total_amount = 0;
    $c_id = $_SESSION["c_loggedin_id"];
    /* To display the data in tabular form */
    $arr = json_decode($data, true);
    if(empty($arr)){
      echo "<script> window.alert('Select at least one item.') </script>";
    }
    else{
      foreach ($arr as $key => $value) {
        $total_amount = $total_amount + $value[0]*$value[1] ;
      }
      $stmt = $conn->prepare("INSERT INTO order_table (o_value, total , c_id , confirmed , delivered) VALUES(?,?,?,0,0) ");
      $stmt->bind_param("sii", $data, $total_amount, $c_id);

      if($stmt->execute()){
        echo "<script> window.alert('Order has been made. You will be receiving a confirmation call soon.') </script>";
      }
      else{
        echo "<script> window.alert('Order couldnot be made.') </script>";
      }
      $stmt->close();
    }

  }

  if(isset($_POST['search_btn'])){
    $search = trim($_POST['search']);
    $val = "%".$search."%" ;
    $sql2 = "SELECT p_name, price, total_orders FROM product WHERE p_name LIKE '$val' ORDER BY p_name ASC" ;

    $result1 = $conn->query($sql2) or die("Last error: {$conn->error}\n") ;
    $food= [];
  //  if($result1){
      while($row1 = $result1 -> fetch_assoc() ){
        $food[] = $row1;
  //    }
    }
  }

}
?>
<html>
<head>
  <title>Kooked - Customer Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="CSS/customer_home.css">
  <link rel="stylesheet" type="text/css" href="CSS/abc.css">
</head>

<body class="">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
  <ul class="general" >
    <li><a href="6_customer_home.php" class="general_active_menu_opt active_adm">Customer Home</a></li>
    <li><a href="7_orders.php">MyOrders</a></li>
    <li><a href="61_customer_profile.php">Edit Profile</a></li>
    <li style="float: right ;"><a href="logout.php">Log out<?php echo substr(" (".$_SESSION["c_loggedin_name"],0,7).")"; ?></a></li>
  </ul> <br>
  <h2 style="text-align: center; margin-left:2%; color:red; width:97%;" class="card"> </h2> <br>

  <div id="my" class="card" style="width: 30%; margin-top: 4%; margin-left: 10%; margin-right: 2%; padding:1%; color:red; float:right;  z-index: 1;">
    <div id="mycart">
      <p style="font-size:120%; left-margin:15%;" class="font-weight-bold">CART<hr style="color:red; border: 1px solid red;"></p>
    </div> <hr style="color:red;">
    <div id="check_out" class="card" style="background-color: grey; text-align:center; color:white;">Add items to cart
    </div>
    <p></p>
    <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <button id="pay" value="" name="my_btn" class="card" style="text-align:center; background-color: red; color:white; width:100%; height:6%;" onclick="localStorage.removeItem('my_dict');">
        Check Out
    </form>
    <script>
/*      var my_string_cart = "{}";
/*      if(localStorage.getItem('my_dict') !== null){
       my_string_cart = localStorage.getItem('my_dict');
      }
      var dict = JSON.parse(my_string_cart); */
      var dict = {};
      var xy;
      var total = 0;
      function calTotal(){
        total = 0;
        for(var key in dict){
          var quan = Number(dict[key][1]);
          var am = Number(dict[key][0]);
          total = total + (quan*am);
        }
      }
  //     function checkout(){
     //   json = JSON.stringify(dict);
   //   }
      function count_dict(){ //function to check if cart is empty
        var count=0;
        for(var key in dict){
          count = count + 1;
        }
        return count;
      }
      function AddToCart(x,y){
        //Object.keys(dict).length === 0 && dict.constructor === Object;
        var z = document.getElementById('mycart').innerHTML;
        y = Number(y);
        if(x in dict){
          var temp = dict[x][1];
          dict[x] = [y,temp+1];
        }
        else{
          dict[x] = [y,1];
        }
        xy = x + "  :  " + dict[x][0] + " ";
        var textnode = document.createTextNode(xy);
        var btn = document.createElement("BUTTON");
        var t = document.createTextNode("");
        btn.appendChild(t);
        btn.className = "btns_in_cart";
        document.getElementById('mycart').appendChild(textnode);
        document.getElementById('mycart').appendChild(btn);
        calTotal();
        var br = document.createElement("br");
        document.getElementById('mycart').appendChild(br);
        var hr = document.createElement("hr");
        document.getElementById('mycart').appendChild(hr);
        btn.addEventListener ("click", function() {
          if(Number(dict[x][1]) === 1){
            delete dict[x];
          }
          else{
            dict[x][1]--;
          }
          textnode.remove();
          btn.remove();
          br.remove();
          hr.remove();
          calTotal();
          document.getElementById('check_out').innerHTML = "";
          var textTotal = document.createTextNode("Total: "+total+" ");
          document.getElementById('check_out').appendChild(textTotal);
          var data = JSON.stringify(dict) ;
          document.getElementById('pay').value = data;
        });
        document.getElementById('check_out').innerHTML = "";
        var textTotal = document.createTextNode("Total: "+total+" ");
        document.getElementById('check_out').appendChild(textTotal);
        var data = JSON.stringify(dict) ;
        document.getElementById('pay').value = data;
        }

    </script>
    </div>

    <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="margin-left:5%">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="search" style="width:42%;">
            <button type="submit" style="width:10%;" name="search_btn" onclick="document.getElementById('clr').style.display='block'">Search</button>
        </div>
      </form>

        <div class="card" style="margin-left: 5%; margin-right: 10%; padding:1%; width:50%;">
          <table class="table">
          <tr>
            <th><h2>Item</h2></th>
            <th><h2>Price</h2></th>
            <th><h2>Add Items</h2></th>
          </tr>
          <?php for ($i = 0; $i < count($food); $i++) { ?>
          <tr>
           <td> <?php echo $food[$i]['p_name']; $x = $food[$i]['p_name']; ?> </td>
           <td> <?php echo $food[$i]['price']; $y = $food[$i]['price']; ?> </td>
           <td> <button style="width: 50%;" onclick="AddToCart('<?php echo $x; ?>', '<?php echo $y; ?>');"> Add </button></td>
         </tr>
          <?php } ?>
        </table> <br>
      </div> <br>


         <br><br><br>
         <button onclick="window.alert(JSON.stringify(dict))">View Data In JSON Format</button>
</body>
</html>
