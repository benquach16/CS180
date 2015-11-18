<?php
	include('opendb.php');
	session_start();
	$id = $_SESSION['curr_id'];
	$selection = $_GET['selection'];


	$db_socket = initSocket();
	$query = "update ".$configValue['DB_USER_TABLE']." set select_pet ='".$selection."' where id='".$id."'";
	$statement = $db_socket->prepare($query);
	$statement->execute();
	
	echo 'success';
	
	include('closedb.php');
?>
