<?php
session_start();
require_once "config_main.php";
if(!isset($_SESSION["c_loggedin"]) || $_SESSION["c_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
$json = $_POST['data'];
$cart = json_decode($json, true);
?>
