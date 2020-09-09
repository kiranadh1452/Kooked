<?php
session_id("session1");
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    header("location: 3_admin_home.php");
    exit;
}
$_SESSION = array();
session_destroy();
?>

<html>
<head> <title> Kooked - Deliverying Happiness </title>
<link rel="stylesheet" type="text/css" href="CSS/abc.css" > </head>


<body class="main1">

  <ul class="general">
    <li><a class="general_active_menu_opt" href="1_main.php">Customer Login</a></li>
    <li><a href="2_employee_login.php">Employee Login</a></li>
    <li style="float: right;"><a href="about_us.php">About us</a></li>
  </ul>
<div class="topp" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" >"Eat while it's hot"</span>
</div>
<div class="loginf" > <br>
<form>
  <img src="Pictures/customer_icon.png" alt="Avatar" class="img_customer"> <br><br>
Customer Email ID<br><label for="c_email"><input type="email" placeholder="Email Id" name="c_email" required style="width: 40%;"></label> <br><br>
Password <br><label for="c_pwd"> <input type ="password" placeholder = "Password" name="c_pwd" required style="width: 40%;"> <br>
<label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
<button type="Submit" class="btn1">LogIn</button>
</form >
<p>
<button type="button" id="btn2" onclick="window.location='2_employee_login.php'" >Employee Login</button>
<button type="button" onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn3">New User</button></p> <br>
</div>

<div id="id01" class="popup_create_user">
  <form class="usr_creation animate">
    <h2>Create a new Account</h2>

		<div class="user_icon">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="Pictures/user_icon.png" alt="Avatar" class="avatar1">
	  </div>

	  <label for="c_name"><b>Username</b></label> <br>
      <input type="text" placeholder="Enter Your Name" name="c_name" required><br>

	  <label for="c_email"><b>Email</b></label><br>
	     <input type="email" placeholder="Enter your email address" name="c_email" required><br>

    <label for="c_pwd"><b>Password</b></label><br>
	 	    <input type="password" placeholder="Enter Password" name="c_pwd" required><br>

	  <label for="c_phn"><b>Phone Number</b></label><br>
	      <input type="tel" placeholder="Enter Your Phone Number" name="c_phn" required><br>

	  <label for="adrs"><b>Address</b></label><br>
	      <input type="text" placeholder="Location - Tole Number , Pokhara" name="adrs" required><br>

	  <button type="submit" class="create_user_btn"> Create Account </button> <br>
		<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancel_btn" > Cancel </button>
	</form>
</div>


</body>
</html>
