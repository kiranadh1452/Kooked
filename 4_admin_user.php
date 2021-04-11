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

$sql1 = "SELECT c_id, c_name, c_email, c_phn FROM customer  WHERE c_act=1 ORDER BY c_name DESC" ;
$result = $conn->query($sql1) ;
$food=array();
while($row = $result -> fetch_assoc()){
  $food[] = $row;
}

$sql2 = "SELECT emp_id, emp_name, emp_email, emp_phn FROM employee" ;
$result1 = $conn->query($sql2) ;
$food1=array();
while($row1 = $result1 -> fetch_assoc()){
  $food1[] = $row1;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  for($i = 0; $i < count($food); $i++){
    $sett = "bann".$i ;
    if(isset($_POST[$sett])){
      $c_id = (int)trim($_POST[$sett]);
      $sql = "UPDATE customer SET c_act=0 WHERE c_id = '$c_id' ";
      $result = $conn->query($sql) ;
      if($result){
        header("location: 4_admin_user.php");
      }
      else{
        echo "<script> alert(\"Couldn't bann the user.\") </script> ";
      }
    }
  }
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
  <li><a href="4_admin_orders.php">Orders</a></li>
  <li><a href="4_admin_user.php" class="general_active_menu_opt active_adm">Users</a></li>
  <li><a href="4_admin_banned.php">Banned Acc</a></li>
  <li style="float: right ;"><a href="logout.php">Log out</a></li>
</ul>

<div class="card" style="margin-left: 1%; margin-right: 1%; text-align:center;">
  <hr><h3 style="color:black;">Employee List</h3> <hr>
    <table class="table">
    <tr>
      <th><h2>Staff Id</h2></th>
      <th><h2>Name</h2></th>
      <th><h2>Email</h2></th>
      <th><h2>Phone</h2></th>
    </tr>
    <?php for ($i = 0; $i < count($food1); $i++) { ?>
    <tr>
     <td> <?php echo $food1[$i]['emp_id'];  ?> </td>
     <td> <?php echo $food1[$i]['emp_name'];?> </td>
     <td> <?php echo $food1[$i]['emp_email']; ?> </td>
     <td> <?php echo $food1[$i]['emp_phn']; ?> </td>
   </tr>
    <?php } ?>
  </table>
</div> <br><br> <hr><hr><br><br>

<div class="card" style="margin-left: 1%; margin-right: 1%; text-align:center;">
  <hr><h3 style="color:black;">Users List</h3> <hr>
    <table class="table">
    <tr>
      <th><h2>User Id</h2></th>
      <th><h2>Name</h2></th>
      <th><h2>Email</h2></th>
      <th><h2>Phone</h2></th>
      <th><h2>Action</h2></th>
    </tr>
    <?php for ($i = 0; $i < count($food); $i++) { ?>
    <tr>
     <td> <?php $cid = $food[$i]['c_id']; echo $cid; ?> </td>
     <td> <?php echo $food[$i]['c_name'];?> </td>
     <td> <?php echo $food[$i]['c_email']; ?> </td>
     <td> <?php echo $food[$i]['c_phn']; ?> </td>
     <td> <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
             <button style="width: 50%;" value="<?php echo $cid ;?>" name="bann<?php echo $i ; ?>">Bann</button>
       </form> </td>
   </tr>
    <?php } ?>
  </table> <br>
</div>

<br><br><hr><br>

</body>
</html>
