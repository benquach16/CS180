<?php
	session_start();
	include ("./opendb.php");
	$db_socket = initSocket();
	$user = $_GET['id'];

	// query post database for the curr users data
	$query = "SELECT * FROM ".$configValue['DB_POST_TABLE']." WHERE userid='".$user."'";
	$statement = $db_socket->prepare($query);
	$statement->execute();

	$arrayOfPosts=$statement->fetchAll();
	$postDataArray = array();

	// Fills the postDataArray with username and post data, repectively
	for ( $i = 0; $i < count($arrayOfPosts); $i++ ) {
	
		$postDataArray[] = array();
		$postDataArray[$i][0] = $arrayOfPosts[$i][2];
		$postDataArray[$i][1] = $arrayOfPosts[$i][3];

	}

	echo json_encode($postDataArray);
?>
