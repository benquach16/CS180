<?php
	include 'opendb.php';
	$db_socket = initSocket();
	$query = "select * from ".$configValue['DB_USER_TABLE'];
	$statement = $db_socket->prepare($query);
	$statement->execute();
	$resultant = $statement->fetchAll();
	$ret = array();
	for($i = 0; $i < count($resultant); $i++)
	{
		$ret[] = array();
	
		$ret[$i][0] = $resultant[$i][0];
		$ret[$i][1] = $resultant[$i][1];
	}
	//also send back ids
	//2d array
	echo json_encode($ret);
	include 'closedb.php';
?>
