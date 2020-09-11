
<?php
$DB_SERVER = "kook.mysql.database.azure.com";
$DB_USERNAME = "kiranadh@kook";
$DB_PASSWORD = "Kooked@db" ;
$DB_NAME =  "kooked";

/* Attempt to connect to MySQL database */
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if($conn->connect_error){
    die("ERROR: Could not connect. " . $conn->connect_error);
}
?>




