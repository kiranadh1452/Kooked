<?php
session_start();
require_once "config_main.php";
if(!isset($_SESSION["c_loggedin"]) || $_SESSION["c_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
$c_id = $_SESSION["c_loggedin_id"];
$sql1 = "SELECT o_id, o_value, total, date_of_order, confirmed, delivered FROM order_table WHERE c_id='$c_id' ORDER BY date_of_order DESC" ;

$result = $conn->query($sql1) ;
$food = array();
while($row = $result -> fetch_assoc()){
  $food[] = $row;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['my_btn1'])){
    $o_id = (int)trim($_POST['my_btn1']);
    $sql2 = "SELECT confirmed FROM order_table WHERE o_id='$o_id' " ;
    $result1 = $conn->query($sql2) ;
    $row2 = $result1 -> fetch_assoc();
    $can_accept = (int)$row2['confirmed'];

    if($can_accept == 0){
      echo "<script> window.alert(\"Let the order be confirmed first.\");</script> ";
    }
    else{
      $sql = "UPDATE order_table SET delivered=1 WHERE o_id = '$o_id' ";
      $result = $conn->query($sql) ;
      if($result){
        echo "<script> window.alert(\"Successfully Confirmed Order.?>\");</script> ";
        header("location: 7_orders.php");
      }
      else{
        echo "<script> alert(\"Couldn't confirm the order now.\") </script> ";
      }
      $sql->close();
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

<body style="">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
  <ul class="general" >
    <li><a href="6_customer_home.php">Customer Home</a></li>
    <li><a href="7_orders.php" class="general_active_menu_opt active_adm">MyOrders</a></li>
    <li><a href="61_customer_profile.php">Edit Profile</a></li>
    <li style="float: right ;"><a href="logout.php">Log out</a></li>
  </ul> <br>
  <h2 style="text-align: center; margin-left:2%; color:red; width:97%;" class="card"> <?php echo " Hello ".$_SESSION["c_loggedin_name"].", these are your orders till date."; ?> </h2> <br>

<div class="card" style="margin-left: 2%; margin-right: 1%;">
    <table class="table">
    <tr>
      <th><h2>Order Id</h2></th>
      <th><h2>Net Amount</h2></th>
      <th><h2>Date Of Order</h2></th>
      <th><h2>Status</h2></th>
      <th><h2>Details</h2></th>
      <th><h2>Received</h2></th>
    </tr>
    <?php for ($i = 0; $i < count($food); $i++) { ?>
    <tr>
      <?php $stats = " Created ";
            $ord = $food[$i]['o_id'];
            $deliver = $food[$i]['delivered'];
            $confirm = $food[$i]['confirmed'];
            if($confirm == 1){
              if($deliver == 1){
                $stats = " Delivered ";
              }
              else{
                $stats = " Confirmed ";
              }
            }
            ?>
     <td> <?php echo $food[$i]['o_id']; $order_value = $food[$i]['o_value']; ?> </td>
     <td> <?php echo $food[$i]['total']; ?> </td>
     <td> <?php echo $food[$i]['date_of_order']; ?> </td>
     <td> <?php echo $stats; ?> </td>
     <td> <button style="width: 50%;" onclick="document.getElementById('details<?php echo $i; ?>').style.display='block'">More</button></td>
     <td><form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
         <?php if($deliver == 1){ ?>
           <p style="margin-left: 20%; margin-top: 8%;">&#9989; </p>
           <button type="submit" style="width: 50%;" value="" hidden>Yes</button>
         <?php }
       else{ ?>
         <button type="submit" style="width: 50%;" value="<?php echo $ord ;?>" name="my_btn1">Yes</button>
       <?php } ?>
       </form></td>
   </tr>
    <?php } ?>
  </table> <br>
</div>
<div class="card" style="margin-left: 5%; margin-right: 10%;">
  <?php for ($i = 0; $i < count($food); $i++) { ?>
    <div id="details<?php echo $i ; ?>" style="background-color:white; margin: 5% 5% 5% 10%; width:70%; height:70%;" class="popup_create_user">
      <span onclick="document.getElementById('details<?php echo $i; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
      <?php $data = $food[$i]['o_value'];
      $arr = json_decode($data, true); ?>
      <table class="table" style="margin-left:3%; margin-right: 3%; width:94%;">
        <tr>
          <th><h2>Item</h2></th>
          <th><h2>Unit Cost</h2></th>
          <th><h2>Quantity</h2></th>
          <th><h2>Net Cost</h2></th>
        </tr>
      <?php $tot = 0;
      foreach ($arr as $key => $value) {
        $total_amount = 0 ;?>
        <tr>
           <td> <?php echo $key;?> </td>
           <td> <?php echo $value[0];?> </td>
           <td> <?php echo $value[1]; $total_amount = $total_amount + $value[0]*$value[1] ;?> </td>
           <td> <?php echo $total_amount ?> </td>
           <?php $tot = $tot + $total_amount;
            }  ?>
        </tr>
      </table> <hr style="color:red;">
      <p class="card" style="margin-left:3%; margin-right: 3%; width:94%; background-color:grey; font-size:200%;">Net Amount : <?php echo $tot?>
    </div>
  <?php } ?>
</div>

  </body>
  </html>
