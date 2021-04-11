<?php
session_start();
require_once "config_main.php";
if(!isset($_SESSION["emp_loggedin"]) || $_SESSION["emp_loggedin"] != true){
    header("location: 1_main.php");
    exit;
}
$emp_id = $_SESSION["emp_loggedin_id"];
$sql1 = "SELECT p_id, p_name, price, total_orders FROM product ORDER BY date_created DESC" ;

$result = $conn->query($sql1) ;
$food=array();
while($row = $result -> fetch_assoc()){
  $food[] = $row;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['my_btn'])){
    $p_id = (int)trim($_POST['my_btn']);

    $sql = "DELETE FROM product WHERE p_id = '$p_id' ";
    $result = $conn->query($sql) ;
    if($result){
      echo "<script> console.log(\"Successfully Deleted Order.?>\");</script> ";
      header("location: 10_emp_product_manage.php");

    }
    else{
      echo "<script> alert(\"Couldn't delete the product now.\") </script> ";
    }
    $sql->close();
  }
  if(isset($_POST['btn'])){
    $p_name = trim($_POST['p_name']) ;
    $price = trim($_POST['price']) ;
    $sql = "INSERT INTO product (p_name,price) VALUES('$p_name','$price')";
    $result = $conn->query($sql) ;
    if($result){
      header("location: 10_emp_product_manage.php");
    }
    else{
      echo "<script> alert(\"Couldn't add the product. Maybe another product with same name exists.\") </script> ";
    }
  }
  for($i = 0; $i < count($food); $i++){
    $sett = "my_btn1".$i ;
    if(isset($_POST[$sett])){
      $p_id = (int)trim($_POST[$sett]);
      $p_name = trim($_POST['p_name']);
      $price = trim($_POST['price']);
      $sql = "UPDATE product SET p_name='$p_name', price='$price' WHERE p_id = '$p_id' ";
      $result = $conn->query($sql) ;
      if($result){
        header("location: 10_emp_product_manage.php");
      }
      else{
        echo "<script> alert(\"Couldn't update the product. Maybe another product with same name exists.\") </script> ";
      }
    }
  }
}

?>
<html>
<head>
  <title>Kooked - Employee Home</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="CSS/customer_home.css">
  <link rel="stylesheet" type="text/css" href="CSS/abc.css">
</head>

<body class="sec2 employee_page">
  <div class="topp" style=" text-align: center;" > <h1><u><b> Kooked</b></u> </h1><span class="text_n" style:"position: fixed;" >"Eat while it's hot"</span>
  </div> <hr>
  <ul class="general no_logged2" >
    <li><a href="5_employee_home.php" >Employee Home</a></li>
    <li><a href="8_emp_completed_orders.php">Confirmed</a></li>
    <li><a href="9_emp_delivered_orders.php">Completed</a></li>
    <li><a href="10_emp_product_manage.php"  class="general_active_menu_opt active_adm">Products</a></li>
    <li style="float: right ;"><a href="logout.php">Log out</a></li>
  </ul>
<h2> <?php echo " Welcome to \"KOOKED\" ".$_SESSION["emp_loggedin_name"]." (".$_SESSION["emp_loggedin_id"].")"; ?> </h2>

<div class="card" style="margin-left: 5%; margin-right: 10%; padding:1%;">
  <button onclick="document.getElementById('new').style.display='block'">+New</button><br>
  <table class="table">
  <tr>
    <th><h2>Item</h2></th>
    <th><h2>Price</h2></th>
    <th><h2>Delete</h2></th>
    <th><h2>Edit</h2></th>
  </tr>
  <?php for ($i = 0; $i < count($food); $i++) { ?>
  <tr>
   <td> <?php echo $food[$i]['p_name']; $pid = $food[$i]['p_id']; ?> </td>
   <td> <?php echo $food[$i]['price'];?> </td>
   <td><form style="margin-left:15%;" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <button style="width:45%;" value="<?php echo $pid ;?>" name="my_btn">Delete &#9986;</button>
    </form></td>
   <td><button style="width:45%;" onclick="document.getElementById('edit_p<?php echo $i; ?>').style.display='block'">Edit &#9998;</button></td>
 </tr>
  <?php } ?>
</table> <br>
</div>

<div class="card" style="margin-left: 5%; margin-right: 10%;">
  <?php for ($i = 0; $i < count($food); $i++) {
    $p_name = $food[$i]['p_name'];
    $price = $food[$i]['price'];
    $pid = $food[$i]['p_id'];
    ?>
    <div id="edit_p<?php echo $i ; ?>" style="background-color:white; margin: 5% 5% 5% 10%; width:70%; height:70%;" class="popup_create_user">
      <span onclick="document.getElementById('edit_p<?php echo $i; ?>').style.display='none'" class="close" title="Close Modal">&times;</span>
      <form style="height:30%;" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
        <label for="p_name"><b>Product Name</b></label> <br><br>
          <input type="text" placeholder="<?php echo $p_name ?>" name="p_name" value="<?php echo $p_name; ?>" required><br> </div><br><hr>

        <label for="p_name"><b>Product Price</b></label> <br>
          <input type="number" max="4500" placeholder="<?php echo $price ?>" name="price" value="<?php echo $price; ?>" required><br><br><hr><hr>

        <button style="width: 30%;" value="<?php echo $pid ;?>" name="my_btn1<?php echo $i ; ?>">Update Product</button>

        </form>
      </div>
  <?php } ?>

  <div class="card" style="margin-left: 5%; margin-right: 10%;">
    <div id="new" style="background-color:white; margin: 5% 5% 5% 10%; width:70%; height:70%;" class="popup_create_user">
      <span onclick="document.getElementById('new').style.display='none'" class="close" title="Close Modal">&times;</span>
      <form style="height:30%;" action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div>
        <label for="p_name"><b>Product Name</b></label> <br><br>
          <input type="text" placeholder="Enter Product Name" name="p_name" required><br> </div><br><hr>

        <label for="p_name"><b>Product Price</b></label> <br>
          <input type="number" max="4500" placeholder="Enter Amount Per Unit(<4500)" name="price" required><br><br><hr><hr>

        <button style="width: 30%;" name="btn">Add Product</button>

        </form>
      </div>
  </div>
  </div>

</body>
</html>
