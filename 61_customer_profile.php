<?php
session_start();
require_once "config_main.php";
if(!isset($_SESSION["c_loggedin"]) || $_SESSION["c_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
$c_id = $_SESSION["c_loggedin_id"];
$c_name = $_SESSION["c_loggedin_name"];
$c_email = $_SESSION["c_loggedin_email"];
$c_phn = $_SESSION["c_loggedin_phn"];
$c_strt_name = $_SESSION["c_strt_name"];
$c_strt_num = $_SESSION["c_strt_num"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['update_user'])){
    $c_nemail = trim($_POST['c_email']);
    $c_nname = trim($_POST['c_name']);
    $c_nphn = trim($_POST['c_phn']);
    $c_nstrt_num = trim($_POST['c_strt_num']);
    $c_nstrt_name = trim($_POST['c_strt_name']);
    $sql1 = "SELECT  c_name, c_phn FROM customer WHERE (c_email = '$c_nemail' OR c_phn = '$c_nphn') AND c_id != '$c_id'" ;
    $result = $conn->query($sql1) ;
    if($result){
      $res = $result->num_rows ;
      if($res>0){
        echo " <script> alert(\"Some other user exists with the same email or phone number you have entered.\"); </script> ";
      }
      else{
        $sql = "UPDATE customer SET c_name='$c_nname', c_email='$c_nemail', c_phn='$c_nphn', c_strt_name='$c_nstrt_name', c_strt_num='$c_nstrt_num' WHERE c_id = '$c_id' ";
        $result = $conn->query($sql) ;
        if($result){
          $_SESSION["c_loggedin_name"] = $c_nname;
          $_SESSION["c_loggedin_email"] = $c_nemail;
          $_SESSION["c_loggedin_phn"] = $c_nphn;
          $_SESSION["c_strt_num"] = $c_nstrt_num;
          $_SESSION["c_strt_name"] = $c_nstrt_name;
          echo "<script> window.alert(\"Successfully Updated.\");</script> ";
        }
        else{
          echo "<script> alert(\"Couldn't update now.\") </script> ";
        }
      }
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

<body class="main1">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
  <ul class="general" >
    <li><a href="6_customer_home.php">Customer Home</a></li>
    <li><a href="7_orders.php">MyOrders</a></li>
    <li><a href="61_customer_profile.php" class="general_active_menu_opt active_adm">Edit Profile</a></li>
    <li style="float: right ;"><a href="logout.php">Log out</a></li>
  </ul> <br>
  <h2> <?php echo " Hello ".$_SESSION["c_loggedin_name"].", you can change your personal info here. "; ?> </h2><hr style="position: relative; top: 15px; border: none; height: 12px; background: white;  margin-bottom: 50px;">

  <form class="" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="color:white;">
    <h2>Update Profile</h2>

		<div class="user_icon">
      <img src="Pictures/user_icon.png" alt="Avatar" class="avatar1">
	  </div>

	  <label for="c_name"><b>Your name</b></label> <br>
      <input type="text" placeholder="<?php echo $c_name; ?>" name="c_name" value="<?php echo $c_name; ?>" required><br>

	  <label for="c_email"><b>Email</b></label><br>
	     <input type="email" placeholder="Enter your email address" value="<?php echo $c_email; ?>" name="c_email" required><br>

	  <label for="c_phn"><b>Phone Number</b></label><br>
	      <input type="number" max="9880000000" min="9800000000" placeholder="Enter Your Phone Number" value="<?php echo $c_phn; ?>" name="c_phn" required><br>

	  <label for="c_adrs"><b>Street Name</b></label><br>
	      <input type="text" placeholder="Street Name , Pokhara" value="<?php echo $c_strt_name; ?>" name="c_strt_name" required><br>

    <label for="c_strt_num"><b>Street No:</b></label><br>
        <input type="number" max="100" min="0" placeholder="Street Number" value="<?php echo $c_strt_num; ?>" name="c_strt_num" required><br>


	  <button type="submit" class="create_user_btn" name="update_user"> Update </button> <br>
	</form>



</body>
</html>
