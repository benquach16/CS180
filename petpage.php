<!doctype html>
<body>
  <?php include('./library/nav-bar.html'); ?>
  <?php
	 //pull information from database
	 include './library/opendb.php';
	 $db_socket = initSocket();
	 $user = $_SESSION['curr_user'];
	 $query = "SELECT user FROM ".$configValue['DB_USER_TABLE']." WHERE user = '".$user."'";
	 $statement = $db_socket->prepare($query);
  $statement->execute();
  if($statement->rowCount() == 1)
  {
  echo 'test'; 
  }
  include './library/closedb.php';
  ?>
</body>
</html>
