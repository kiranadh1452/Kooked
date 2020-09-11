<?php
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["adm_loggedin"]) || $_SESSION["adm_loggedin"] !== true){
    header("location: 1_main.php");
    exit;
}

require_once "config_main.php";
$e_id = 0;
$e_name = $e_email = $e_pwd = $e_phn = "";
$e_error = "";
$e_success = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $e_id = trim($_POST["eid"]);
  $e_name = trim($_POST["e_name"]);
  $e_email = trim($_POST["e_email"]);
  $e_pwd = trim($_POST["e_pwd"]);
  $e_cpwd = trim($_POST["e_cpwd"]);
  $e_phn = trim($_POST["e_phn"]);

  $sql = "SELECT emp_id FROM employee WHERE emp_email = '$e_email' OR emp_id = $e_id " ;
  $result = $conn->query($sql);


  if( $result ){
    $res = $result->num_rows ;
    if( $res > 0){
        $e_error .= "<h3>!!! User Already Exists with same id or email. !!<br><h3>";
    }
  }
  else{
      echo "<script> alert(\"Something went worng.\"); </script> ";
  }

  if($e_pwd != $e_cpwd ){
    $e_error .= "<h3> !!!Passwords didn't match.!!! <br></h3> ";
    //echo "<script> alert(\"Two passwords donot match.\"); </script> ";
  }
  if(empty($e_error)){
    $stmt = $conn->prepare("INSERT INTO employee (emp_id, emp_name, emp_email, emp_pwd, emp_phn, emp_act) VALUES(?,?,?,?,?,1) ");
    $stmt->bind_param("isssi", $e_id, $e_name , $e_email , $e_hashpwd , $e_phn );
    $e_hashpwd = password_hash($e_pwd, PASSWORD_DEFAULT);

    if($stmt->execute()){
      $e_success .= "<h3> Done! Employee has been added.<br> </h3>";
    }
    $stmt->close();
  }


}
$conn->close();

?>
<html>
 <head> <title> Kooked - Admin Home </title> <link rel="stylesheet" type="text/css" href="CSS/abc.css" >  </head>

<body class="admin_home_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
<ul class="general admin_menu" >
  <li><a href="3_admin_home.php" class="general_active_menu_opt active_adm">Admin Home</a></li>
  <li><a href="4_admin_settings.php">Admin Settings</a></li>
  <li style="float: right ;"><a href="logout.php">Log out</a></li>
</ul>
<div style="margin-left:3%;">
  <button onclick="myFunction()" class="btn4 admin_page_buttons" id="add_emp_btn">Add Employee</button>
  <button onclick="myFunction2()" class="btn4 admin_page_buttons" id="remove_emp_btn">Remove Employee</button>
  <button onclick="myFunction3()" class="btn4 admin_page_buttons" id="remove_usr_btn ">Remove User</button>
</div><br><br>
<div style="text-align: center;  color:red; background-color: grey;">
   <?php echo $e_error ; ?> <?php echo $e_success ; ?>
 </div> <br>
<div  style="margin-left: 3%;">
  <form id="add_emp" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >
    <span onclick="myFunction()" class="close" title="Close Modal" style="position: relative; float:right;">&times;</span>
    <h2>Add an employee</h2><br>

    <label for="e_name"><b>Employee Name:</b></label> <br>
      <input type="text" placeholder="Employee Name" name="e_name" required><br>

	  <label for="e_email"><b>Employee Email</b></label><br>
	     <input type="email" placeholder="Enter your email address" name="e_email" required><br>

    <label for="e_pwd"><b>Create a Password</b></label><br>
	 	    <input type="password" pattern=".{6,15}" title="6 to 15 characters" placeholder="Enter Password" name="e_pwd" required><br>

    <label for="e_cpwd"><b>Confirm Password</b></label><br>
        <input type="password" pattern=".{6,15}" title="6 to 15 characters" placeholder="Re-enter Password" name="e_cpwd" required><br>

	  <label for="e_phn"><b>Employee Phone Number</b></label><br>
	      <input type="number" max="9999999999" min="1000000000" placeholder="Enter Your Phone Number" name="e_phn" required ><br>

    <label for="eid"><b>Employee Id<b></label><br>
        <input type="number" placeholder="Staff Id" name="eid" required><br>

    <button type="submit" class="btn4 admin_page_buttons">Add</button><br><br>
  </form>
</div>
<div style="margin-left: 3%;">
  <form id="remove_emp">
    <span onclick="myFunction2()" class="close" title="Close Modal" style="position: relative; float:right;">&times;</span>
    <h2>Remove an employee</h2><br>

    <label for="e_name"><b>Employee Name:</b></label> <br>
      <input type="text" placeholder="Employee Name" name="e_name" required><br>

    <label for="eid"><b>Employee Id<b></label><br>
        <input type="number" placeholder="Staff Id" name="eid" required><br>

    <button type="submit" class="btn4 admin_page_buttons">Remove</button><br><br>
  </form>
</div>

<div style="margin-left: 3%;">
  <form id="remove_usr">
    <span onclick="myFunction3()" class="close" title="Close Modal" style="position: relative; float:right;">&times;</span>
    <h2>Remove a user</h2><br>

    <label for="c_name"><b>User Name:</b></label> <br>
      <input type="text" placeholder="Customer Name" name="c_name" required><br>

    <label for="cid"><b>Customer Id<b></label><br>
        <input type="number" placeholder="User Id" name="cid" required><br>

    <button type="submit" class="btn4 admin_page_buttons">Remove</button><br><br>
  </form>
</div>

<script>
var x = document.getElementById("add_emp");
var y = document.getElementById("remove_emp");
var z = document.getElementById("remove_usr");
function myFunction() {
  dropdown(x,y,z);
}
function myFunction2() {
  dropdown(y,x,z);
}
function myFunction3() {
  dropdown(z,x,y);
}
function dropdown(x,y,z){
  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  y.style.display = "none";
  z.style.display = "none";
}
  </script>
</body>
</html>
