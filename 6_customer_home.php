<?php
 session_start();
if(!isset($_SESSION["c_loggedin"]) || $_SESSION["c_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
?>
<html>
<head>
  <title>Kooked - Customer Home</title>
  <link rel="stylesheet" type="text/css" href="CSS/abc.css" >
</head>

<body class="customer_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div>
  <ul class="general " >
    <li><a href="6_customer_home.php" class="general_active_menu_opt active_adm">Customer Home</a></li>
    <li><a href="#settings">Settings</a></li>
    <li style="float: right ;"><a href="logout.php">Log out</a></li>
  </ul>
  <h2> <?php echo " Welcome to \"KOOKED\" ".$_SESSION["c_loggedin_name"]; ?> </h2>

</body>
</html>
