<?php
	//check if they are already friends first
	session_start();
	include 'opendb.php';
	$senderID = $_SESSION['curr_id'];
	$receiverID = $_GET['userID'];
	echo $receiverID;
	$db_socket = initSocket();

	include 'closedb.php';
?>
