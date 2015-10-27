<?php
	
	include 'opendb.php';
	session_start();
	$db_socket = initSocket();
	$currentID = $_SESSION['curr_id'];
	$searchData = $_GET['searchData'];
	if(empty($searchData))
	{ 
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
	}
	else
	{
		//search for a specific user if input
		$query = "select * from ".$configValue['DB_USER_TABLE']." where user='".$searchData."'";
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
	}
	include 'closedb.php';
?>
