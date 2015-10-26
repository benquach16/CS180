<?php
	include './opendb.php';
	session_start();

	$db_socket = initSocket();
	$query = "select * from ".$configValue['DB_USER_TABLE'];
	$statement = $db_socket->prepare($query);
	$statement->execute();
	$result = statement->fetchAll(PDO::FETCH_COLUMNS,1);
	echo "wer"
	include './closedb.php';
?>
