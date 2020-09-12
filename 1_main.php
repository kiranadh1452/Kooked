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

function hide_banner(){
  echo "<script type=\"text/JavaScript\">
     document.getElementById('id01').style.display='block';
     </script>" ;
;
}

require_once "config_main.php";
$c_name = $c_email = $c_pwd = $c_cpwd = $c_adrs = "";
$c_uname_error = $c_pw_error = $c_success = $c_err =  "";
$c_sign_pw_err = $c_sign_usr_err = $c_sign_phn_err = "" ;
if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(isset($_POST['login_user'])){

    $c_email = trim($_POST['c_email']);
    $c_pwd = trim($_POST['c_pwd']);
    $sql1 = "SELECT c_id, c_name, c_email, c_pwd, c_phn FROM customer WHERE c_email = '$c_email' AND c_act = 1" ;
    $result = $conn->query($sql1) ;

    if($result){
      $res = $result->num_rows ;
      if( $res == 1){
         $row = $result->fetch_assoc() ;
         $hash_pwd = $row["c_pwd"];
         if(password_verify($c_pwd , $hash_pwd)){
           session_start();
           $_SESSION["c_loggedin"] = true;
           $_SESSION["c_loggedin_id"] = $row["c_id"];
           $_SESSION["c_loggedin_name"] = $row["c_name"];
           $_SESSION["c_loggedin_email"] = $row["c_email"];
           $_SESSION["c_loggedin_phn"] = $row["c_phn"];
           header("location: 6_customer_home.php");
         }
         else{
            //echo "<script> alert(\"Incorrect password.\"); </script> ";
            $c_pw_error .= "Incorrect Password !";
         }
      }
      else{
         //echo "<script> alert(\"No such customer.\"); </script> ";
         $c_uname_error .= "Enter a registered email please.";
      }
    }
    else{
      echo " <script> alert(\"Something went wrong, please try again.\"); </script> ";
    }
  }

  elseif(isset($_POST['create_user'])){

    $c_name = trim($_POST["c_name"]);
    $c_email = trim($_POST["c_email"]);
    $c_pwd = trim($_POST["c_pwd"]);
    $c_cpwd = trim($_POST["c_cpwd"]);
    $c_phn = trim($_POST["c_phn"]);
    $c_adrs = trim($_POST["c_adrs"]);
    $c_strt_num = trim($_POST["c_strt_num"]);

    $sql = "SELECT c_id FROM customer WHERE c_email = '$c_email'  " ;
    $result = $conn->query($sql);

    if( $result ){
      $res = $result->num_rows ;
      if( $res > 0){
          // echo "<script> alert(\"User Already Exists with same email or phone number.\"); </script> ";
          $c_sign_usr_err .=  "User Already Exists with same email.<br>";
      }
    }
    else{
        echo "<script> alert(\"Something went worng.\"); </script> ";
    }
if(empty($c_sign_usr_err)){
    if($c_pwd != $c_cpwd ){
      $c_sign_pw_err .= "Passwords didn't match.<br>";
      //echo "<script> alert(\"Two passwords donot match.\"); </script> ";
    }

    if(empty($c_sign_pw_err)){
      $stmt21= $conn->prepare("INSERT INTO customer (c_name, c_email, c_pwd, c_phn, c_strt_name, c_strt_num, c_act) VALUES(?,?,?,?,?,?,1)");
      if(! $stmt21){
        echo "<script> alert(\"Prepare retured false. '. $conn->error'\"); </script> ";
      }
else{
      $stmt21->bind_param("sssisi", $c_name , $c_email , $c_hash_pwd , $c_phn , $c_adrs , $c_strt_num);
      $c_hash_pwd = password_hash($c_pwd , PASSWORD_DEFAULT);
      if($stmt21->execute()){
        $c_success .= "<h3> Done! Your account has been created. Now login.<br> </h3>";
        echo "<script> alert(\"Done! Your account has been created. Now login.\"); </script> ";
      }
      else{
        // mistake in query echo "<script> alert(\"Couldn't create it at this moment.\"); </script> ";
      }
    }
      $stmt21->close();
    }

  }
  }
}
$conn->close();
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
<div style="text-align: center;  color:red; background-color: grey;">
 </div> <br>
<div class="loginf" > <br>
<form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <img src="Pictures/customer_icon.png" alt="Avatar" class="img_customer"> <br><br>
Customer Email ID<br><label for="c_email">
  <input type="email" placeholder="Email Id" name="c_email" value="<?php echo $c_email; ?>" required style="width: 40%;"></label>
     <span style="text-color:red ;"> <?php if(!empty($c_uname_error )){echo "<br>".$c_uname_error ; echo "<br>";}?> </span>
   <br><br>

Password <br><label for="c_pwd">
   <input type ="password" placeholder = "Password" name="c_pwd" value="<?php echo $c_pwd; ?>" required style="width: 40%;"> <br>
   <span style="text-color:red ;"> <?php if(!empty($c_pw_error )){echo $c_pw_error ; echo "<br>";}?> </span>

<label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
<button type="Submit" class="btn1" name="login_user">LogIn</button>
</form >
<p>
<button type="button" id="btn2" onclick="window.location='2_employee_login.php'" >Employee Login</button>
<button type="button" onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn3">New User</button></p> <br>
</div>

<div id="id01" class="popup_create_user">
  <form class="usr_creation animate" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <h2>Create a new Account</h2>

		<div class="user_icon">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="Pictures/user_icon.png" alt="Avatar" class="avatar1">
	  </div>

	  <label for="c_name"><b>Your name</b></label> <br>
      <input type="text" placeholder="Enter Your Name" name="c_name" value="<?php echo $c_name; ?>" required><br>

	  <label for="c_email"><b>Email</b></label><br>
	     <input type="email" placeholder="Enter your email address" value="<?php echo $c_email; ?>" name="c_email" required><br>
        <span style="text-color:red ;"> <?php if(!empty($c_sign_usr_err )){echo $c_sign_usr_err ; echo "<br>"; hide_banner();}?> </span>

    <label for="c_pwd"><b>Password</b></label><br>
	 	    <input type="password" pattern=".{6,15}" title="6 to 15 characters" value="<?php echo $c_pwd; ?>" placeholder="Enter Password" name="c_pwd" required><br>

    <label for="c_cpwd"><b>Confirm Password</b></label><br>
        <input type="password" pattern=".{6,15}" title="6 to 15 characters" value="<?php echo $c_cpwd; ?>" placeholder="Re-enter Password" name="c_cpwd" required><br>
        <span style="text-color:red ;"> <?php if(!empty($c_sign_pw_err )){echo $c_sign_pw_err ; echo "<br>"; hide_banner();}?> </span>


	  <label for="c_phn"><b>Phone Number</b></label><br>
	      <input type="number" max="9880000000" min="9800000000" placeholder="Enter Your Phone Number" value="<?php echo $c_phn; ?>" name="c_phn" required><br>

	  <label for="c_adrs"><b>Address</b></label><br>
	      <input type="text" placeholder="Street Name , Pokhara" value="<?php echo $c_adrs; ?>" name="c_adrs" required><br>

    <label for="c_strt_num"><b>Street No:</b></label><br>
        <input type="number" max="100" min="0" placeholder="Street Number" value="<?php echo $c_strt_num; ?>" name="c_strt_num" required><br>


	  <button type="submit" class="create_user_btn" name="create_user"> Create Account </button> <br>
		<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancel_btn" > Cancel </button>
	</form>
</div>
<a href="http://pdfcrowd.com/url_to_pdf/">Save this page to a PDF</a>

</body>
</html>
