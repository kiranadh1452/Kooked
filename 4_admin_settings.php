<?php
session_start();
require_once "pw-change.php";

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

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $cur = $_SESSION['adm_loggedin_id'] ;

  if(isset($_POST['email_change_adm'])){
    $new = trim($_POST['a_n_email']);
    $confirm = trim($_POST['a_nc_email']);
    check_value($cur, $new, $confirm, $conn, 'adm_email', 'adm_email', 'Email') ;
  }
  if(isset($_POST['pw_change_adm'])){
    $new = trim($_POST['a_n_pwd']);
    $confirm = trim($_POST['a_nc_pwd']);
    check_value($cur, $new, $confirm, $conn, 'adm_pwd', 'adm_email', 'Password') ;
  }
}
?>
<html>
 <head> <title> Kooked - Admin Home </title> <link rel="stylesheet" type="text/css" href="CSS/abc.css" >  </head>

<body class="admin_home_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
<ul class="general admin_menu" >
  <li><a href="3_admin_home.php">Admin Home</a></li>
  <li><a href="4_admin_settings.php" class="general_active_menu_opt active_adm">Admin Settings</a></li>
  <li style="float: right ;"><a href="logout.php">Log out</a></li>
</ul>

<div style="margin-left: 3%;">
  <button onclick="myFunction()" class="btn4 admin_page_buttons" id="change_admin_email_btn ">Change Email</button>
  <button onclick="myFunction1()" class="btn4 admin_page_buttons" id="change_admin_pwd_btn ">Change Password</button>
</div><br><br>

<div style="color:green; background-color: white; margin-left:20% ;margin-right:20%;text-align:center;">
   <?php if(!empty($_SESSION['success'] )){echo $_SESSION['success'] ; echo "<br>";}?> </div>

<div style="margin-left: 3%;">
  <form id="change_admin_email" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <span onclick="myFunction()" class="close" title="Close Modal" style="position: relative; float:right;">&times;</span>
    <h2>Change Admin Email Address</h2><br>

    <label for="a_n_email"><b>New Email Address:</b></label> <br>
      <input type="email" placeholder="New Email Address" name="a_n_email" required><br>

    <label for="a_nc_email"><b>Confirm Email Address<b></label><br>
        <input type="email" placeholder="Confirm Email Address" name="a_nc_email" required><br>

    <button type="submit" name="email_change_adm" class="btn4 admin_page_buttons">Change</button><br><br>
  </form>
</div>

<div style="margin-left: 3%;">
  <form id="change_admin_pwd" action=action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <span onclick="myFunction1()" class="close" title="Close Modal" style="position: relative; float:right;">&times;</span>
    <h2>Change Admin Password</h2><br>

    <label for="a_n_pwd"><b>New Password:</b></label> <br>
      <input type="password" placeholder="Enter new password here.." name="a_n_pwd" pattern=".{6,15}" required><br>

    <label for="a_nc_pwd"><b>Confirm Password<b></label><br>
        <input type="password" placeholder="Confirm new password here.." name="a_nc_pwd" pattern=".{6,15}" required><br>

    <button type="submit" name="pw_change_adm" class="btn4 admin_page_buttons">Change</button><br><br>
  </form>
</div>

<script>
var x = document.getElementById("change_admin_email");
var y = document.getElementById("change_admin_pwd");
function myFunction(){
  dropdown(x,y);
}
function myFunction1(){
  dropdown(y,x);
}
function dropdown(x,y){
  if( x.style.display == "none" ) x.style.display = "block";
  else x.style.display = "none";
  y.style.display = "none"; // so that whenever one option is selected , another minimizes
}
</script>
</body>
</html>
