<?php
$DB_SERVER = "localhost:3306"; //Database server
$DB_USERNAME = ""; //username
$DB_PASSWORD = "" ; //password
$DB_NAME =  "kooked"; //name of database - use kooked if you're using default database designs in the "Database Creation and Designing"

/* Attempt to connect to MySQL database */
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if($conn->connect_error){
    die("ERROR: Could not connect. " . $conn->connect_error);
}




// while logging in, go to admin panel in the Employee login section -
// default parameters are email:kiranadh1452@gmail.com and password: kiranadh
// make sure to run all sql queries inside the "Database Creation and Designing" before trying to login to admin panel.
?>
