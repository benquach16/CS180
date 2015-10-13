<!doctype html>
<body>
  <?php include('./library/nav-bar.html'); ?>
  <?php
	 //pull information from database
	 include './library/opendb.php';
	 $db_socket = initSocket();
	 $user = $_SESSION['curr_user'];
	 $query = "SELECT user FROM auth_list";
	 $statement = $db_socket->prepare($query);
  $statement->execute();
  if($statement->rowCount() == 1)
  {
  
  }
  include './library/closedb.php';
  ?>
</body>
</html>
