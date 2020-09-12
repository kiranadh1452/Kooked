<?php
session_start();
if(isset($_SESSION["adm_loggedin"]) && $_SESSION["adm_loggedin"] == true){
    header("location: 3_admin_home.php");
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

require_once "config_main.php";
$amail = $apwd = $e_email = $e_pwd = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['admin_login'])){
    $amail = trim($_POST['a_email']);
    $apwd = trim($_POST['a_pwd']);
    $sql1 = "SELECT adm_email, adm_pwd FROM admin WHERE adm_email = '$amail' " ;

    $result = $conn->query($sql1) ;
    if($result){
      $res = $result->num_rows ;
      if( $res == 1){
         $row = $result->fetch_assoc() ;
         $hash_pwd = $row["adm_pwd"];
         if(password_verify($apwd , $hash_pwd)){
           session_start();
           $_SESSION["adm_loggedin"] = true;
           $_SESSION["adm_loggedin_id"] = $amail;
           header("location: 3_admin_home.php");
         }
         else{
            echo "<script> alert(\"Incorrect Admin Details.\"); </script> ";
         }
      }
      elseif($res >1 ){
         echo "<script> alert(\"Multiple admin found. Please contact service provider.\"); </script> ";
      }
    }
    else{
      echo " <script> alert(\"Something went wrong, please try again.\"); </script> ";
    }
  }
  elseif(isset($_POST['emp_login'])){
    $e_email = trim($_POST['e_email']);
    $e_pwd = trim($_POST['e_pwd']);
    $sql1 = "SELECT emp_id, emp_name, emp_email, emp_pwd FROM employee WHERE emp_email = '$e_email' " ;

    $result = $conn->query($sql1) ;
    if($result){
      $res = $result->num_rows ;
      if( $res == 1){
         $row = $result->fetch_assoc() ;
         $hash_pwd = $row["emp_pwd"];
         if(password_verify($e_pwd , $hash_pwd)){
           session_start();
           $_SESSION["emp_loggedin"] = true;
           $_SESSION["emp_loggedin_id"] = $row["emp_id"];
           $_SESSION["emp_loggedin_name"] = $row["emp_name"];
           $_SESSION["emp_loggedin_email"] = $row["emp_email"];
           header("location: 5_employee_home.php");
         }
         else{
            echo "<script> alert(\"Incorrect Employee Details.\"); </script> ";
         }
      }
      else{
         if($res = 0) echo "<script> alert(\"No such employee. Please contact admin to add you.\"); </script> ";
         echo "<script> alert(\"Multiple employee found. Please contact service provider.\"); </script> ";
      }
    }
    else{
      echo " <script> alert(\"Something went wrong, please try again.\"); </script> ";
    }
  }
}
$conn->close();
?>

<html> <head> <title> Kooked - Employee LogIn </title> <link rel="stylesheet" type="text/css" href="CSS/abc.css" >  </head>
<body class="sec2">

  <ul class="general no_logged2">
    <li><a href="1_main.php">Customer Login</a></li>
    <li><a class="general_active_menu_opt active_login_page2" href="2_employee_login.php">Employee Login</a></li>
    <li style="float: right ;"><a href="about_us.php">About us</a></li>
  </ul>

  <div class="topp" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" >"Eat while it's hot"</span>
  </div>
  <div class="adm">
    <button type="button" onclick="window.location='1_main.php'" style="margin-left:2%; width: 10%;" class="btn5">
      <b>&#8592; Return</b></button></div>
  <div class="loginf login_emp" > <br>
  <form class="emp_log" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <h2 class="info">EMPLOYEE LOGIN</h2> <br>
    <img src="Pictures/employee_icon.png" alt="Avatar" class="img_employee"> <br>
  Employee Email ID<br>
  <label for="e_email">
    <input type="email" placeholder="Email Id" name="e_email" required style="width: 40%;"></label> <br><br>
  Password <br>

  <label for="e_pwd">
     <input type ="password" placeholder = "Password" name="e_pwd" required style="width: 40%;"></label> <br>
  <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
  <button name = "emp_login" type="Submit" class="btn5">LogIn</button>
  </form >
</div>
<br>
<div class="adm" > <p>
<button type="button" class ="btn4 btn5" onclick="document.getElementById('id02').style.display = 'block'" >Admin Panel</button> </p> </div>
<div id="id02" class="popup_create_user popup_admin_login">
  <form class="admin_login animate" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <h2>Admin Login Panel</h2>

    <div class="user_icon admin_icon">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="Pictures/admin_icon.png" alt="Avatar" class="avatar1 avatar2">
	  </div>

    <label for="a_email"><b>Email</b></label><br>
	     <input type="email" placeholder="Enter your email address" name="a_email" required><br>

    <label for="a_pwd"><b>Password</b></label><br>
	 	    <input type="password" placeholder="Enter Password" name="a_pwd" required><br>

    <button name="admin_login" type="submit" style="width: 20%;">
     LogIn As Admin</button>
    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancel_btn" style="width: 10%;"> Cancel </button><br><br>

  </form>
</div>

</body>
</html>
