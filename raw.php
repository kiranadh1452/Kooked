<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['my_btn'])){
      $data = trim($_POST['my_btn']);
      echo $data;
    }
  }
?>
<html>
<head>
  <title> </title>
</head>

<body class="">
    <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <button id="me" type="Submit" value="data" name="my_btn">Button Only</button>
    </form>
    <script>
        var data = "Kiran Adhikari";
        document.getElementById('me').value = data;
    </script>
</body>
</html>
