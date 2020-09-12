<?php
session_start();
if(!isset($_SESSION["emp_loggedin"]) || $_SESSION["emp_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
?>
<html>
<head>
  <title>Kooked - Employee Home</title>
  <link rel="stylesheet" type="text/css" href="CSS/abc.css" >
</head>

<body class="sec2 employee_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
  <ul class="general no_logged2" >
    <li><a href="5_employee_home" class="general_active_menu_opt active_adm">Employee Home</a></li>
    <li><a href="#settings">Settings</a></li>
    <li style="float: right ;"><a href="logout.php">Log out</a></li>
  </ul>
<h2> <?php echo " Welcome to \"KOOKED\" ".$_SESSION["emp_loggedin_name"]; ?> </h2>
</body>
</html>
