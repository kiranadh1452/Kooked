<?php

require_once "config_main.php";
$e_id = 0;
$e_name = $e_email = $e_pwd = $e_phn = "";
$e_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $e_id = trim($_POST["eid"]);
  $e_name = trim($_POST["e_name"]);
  $e_email = trim($_POST["e_email"]);
  $e_pwd = trim($_POST["e_pwd"]);
  $e_cpwd = trim($_POST["e_cpwd"]);
  $e_phn = trim($_POST["e_phn"]);

  $stmt = $conn->prepare("SELECT emp_id FROM employee WHERE ( emp_id = ? OR emp_email = ?)");
  $stmt->bind_param("is",$eid,$e_email);

  $res = $stmt->execute();
  if($res->num_rows > 0){
    $e_error .= "!! A user found with same id or email !!<br>";
  }
  $stmt->close();

  if($e_pwd != $e_cpwd ){
    $e_error .= " Passwords donot match. <br> ";
  }

  if(empty($e_error)){
    $stmt = $conn->prepare("INSERT INTO employee (emp_id, emp_name, emp_email, emp_pwd, emp_phn, emp_act) VALUES(?,?,?,?,?,1) ");
    $stmt->bind_param("isssi", $e_id, $e_name , $e_email , $e_hashpwd , $e_phn );
    $e_hashpwd = password_hash($e_pwd, PASSWORD_DEFAULT);

    if($stmt->execute()){
      echo "Done! Employee Has Been Added." ;
    }
  }


}
echo $e_error;

?>
