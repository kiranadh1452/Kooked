<?php
//file linking with database
require_once "config_main.php";

//function to update
function change_value($cur, $new, $conn , $field1 , $field2 , $id){

  $sql = "UPDATE admin SET `$field1`='$new' WHERE `$field2` = '$cur' ";
  $result = $conn->query($sql) ;
  if($result){
    echo "<script> alert(\"Successfully Changed\"); </script> ";
    $_SESSION['success'] = $id." has been changed.";
    $_SESSION["adm_loggedin_id"] = $new ;
  }
  else{
    echo "<script> alert(\"Couldn't complete query\") </script> ";
  }
}

//function to confirm if the confirm value iscorrect and execute the update
function check_value($cur, $new, $confirm, $conn, $field1 , $field2 , $id){
  if($new != $confirm){
    echo "<script> alert(\"Confirm value doesnot match.\"); </script> "; //Entered two values donot match.
  }
  else{
    if(strcmp($id,'Password') == 0){
      $new = password_hash($new , PASSWORD_DEFAULT);
    }
    change_value($cur, $new, $conn, $field1, $field2, $id) ;
  }
}
//echo "<script> window.history.go(-1);
//     </script>";

?>
