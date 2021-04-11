<?php
session_start();
require "pw-change.php";

$_SESSION['success']= '' ;
$new = $cur = $confirm = '';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adm_loggedin"]) || $_SESSION["adm_loggedin"] !== true){
    header("location: 1_main.php");
    exit;
}
if(isset($_SESSION["emp_loggedin"]) && $_SESSION["emp_loggedin"] == true){
    header("location: 5_employee_home.php");
    exit;
}
if(isset($_SESSION["c_loggedin"]) && $_SESSION["c_loggedin"] == true){
    header("location: 6_customer_home.php");
    exit;
}

$sql1 = "SELECT o_id, o_value, total, c_id, date_of_order, confirmed, delivered FROM order_table WHERE confirmed=1 and delivered=1 ORDER BY date_of_order DESC" ;
$result = $conn->query($sql1) ;
$food=array();
while($row = $result -> fetch_assoc()){
  $food[] = $row;
}

?>
<html>
 <head> <title> Kooked - Admin Home </title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="CSS/customer_home.css">
   <link rel="stylesheet" type="text/css" href="CSS/abc.css">
 </head>
<body class="admin_home_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
<ul class="general admin_menu" >
  <li><a href="3_admin_home.php">Admin Home</a></li>
  <li><a href="4_admin_settings.php">Admin Settings</a></li>
  <li><a href="4_admin_orders.php" class="general_active_menu_opt active_adm">Orders</a></li>
  <li><a href="4_admin_user.php">Users</a></li>
  <li><a href="4_admin_banned.php">Banned Acc</a></li>
  <li style="float: right ;"><a href="logout.php">Log out</a></li>
</ul>

<div class="card" style="margin-left: 1%; margin-right: 1%; text-align:center;">
  <hr><h3 style="color:black;">Orders Made.</h3> <hr>
    <table class="table">
    <tr>
      <th><h2>Id</h2></th>
      <th><h2>Amount</h2></th>
      <th><h2>Date</h2></th>
      <th><h2>Details</h2></th>
    </tr>
    <?php for ($i = 0; $i < count($food); $i++) { ?>
    <tr>
     <td> <?php echo $food[$i]['o_id']; $order_value = $food[$i]['o_value']; $ord = $food[$i]['o_id']; ?> </td>
     <td> <?php echo $food[$i]['total'];?> </td>
     <td> <?php echo $food[$i]['date_of_order']; ?> </td>
     <td> <button style="width: 50%;" onclick="document.getElementById('details<?php echo $i; ?>').style.display='block'">Details </button></td>
   </tr>
    <?php } ?>
  </table> <br>
</div>
<div class="card" style="margin-left: 5%; margin-right: 10%;">
  <?php for ($i = 0; $i < count($food); $i++) { ?>
    <div id="details<?php echo $i ; ?>" style="background-color:white; margin: 5% 5% 5% 10%; width:70%; height:70%;" class="popup_create_user">
      <span onclick="document.getElementById('details<?php echo $i; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
      <?php $data = $food[$i]['o_value']; $c_id = $food[$i]['c_id'];
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
      <p class="card" style="margin-left:3%; margin-right: 3%; width:94%; background-color:grey; font-size:200%;">Net Amount : <?php echo $tot?> </p>

      <p class="card" style="margin-left:3%; margin-right: 3%; width:94%; background-color:grey; font-size:100%;">
          <?php
              $sql1 = "SELECT c_name, c_email, c_phn, c_strt_name, c_strt_num, c_act FROM customer WHERE c_id = '$c_id'" ;
              $result = $conn->query($sql1) ;
              $row = $result->fetch_assoc() ;
              $c_strt_num = $row["c_strt_num"];
              $c_strt_name = $row["c_strt_name"];
              $c_name = $row["c_name"];
              $c_email = $row["c_email"];
              $c_phn = $row["c_phn"];
              $c_act = $row["c_act"];
              if($c_act == 0){
                echo "User No Longer Exists. You can delete this order. <br>";
              }
              echo "SHIPPING DETAILS<br><br>";
              echo "Ordered By : ".$c_name."<br> Email Id : ".$c_email;
              echo "<br> Phone Number : ".$c_phn."<br> Street Name : ".$c_strt_name."<br> Street No. : ".$c_strt_num."<br>";
          ?>

      </p>
    </div>
  <?php } ?>
</div>
</body>
</html>
