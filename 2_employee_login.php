<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    header("location: 3_admin_home.php");
    exit;
}
$_SESSION["loggedin"] = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
     if(($_POST['a_email'] == 'kiranadh1452@gmail.com') && ($_POST['a_pwd'] == 'password') ){
	$_SESSION["loggedin"] = true;
        header("location: 3_admin_home.php");
     }
     else{
        echo "<script> alert(\"Incorrect Admin Details.\"); </script> "; 
     }
}
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
  <form class="emp_log"> <h2 class="info">EMPLOYEE LOGIN</h2> <br>
    <img src="Pictures/employee_icon.png" alt="Avatar" class="img_employee"> <br>
  Employee Email ID<br><label for="e_email"><input type="email" placeholder="Email Id" name="e_email" required style="width: 40%;"></label> <br><br>
  Password <br><label for="e_pwd"> <input type ="password" placeholder = "Password" name="e_pwd" required style="width: 40%;"> <br>
  <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
  <button type="Submit" class="btn5">LogIn</button>
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

    <button type="submit" style="width: 20%;">
     LogIn As Admin</button>
    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancel_btn" style="width: 10%;"> Cancel </button><br><br>

  </form>
</div>

</body>
</html>
