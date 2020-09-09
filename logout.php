<?php
// Initialize the session

session_id("session1");
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: 1_main.php");
exit;
?>