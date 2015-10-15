<?php
	include '../library/opendb.php';
	$pet_name = $_POST['pet_name'];

	//find out if we already have a pet of the same name
	$db_socket = initSocket();
	$curr_id = $_SESSION['curr_id'];
	$curr_user = $_SESSION['curr_user'];
	$query = "INSERT INTO ".$configValue['DB_USER_PET_TABLE']." (user_id, name)"."  VALUES (:curr_id, :curr_user)";
	$statement = $db_socket->prepare($query);
	$statement->bindParam(':curr_id', $curr_id);
	$statement->bindParam(':curr_user', $curr_user);
	$statement->execute();
	header('Location: index.html');
	include '../library/closedb.php';
?>
