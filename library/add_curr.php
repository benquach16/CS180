<?php
	session_start();
	include ("./opendb.php");
	$db_socket = initSocket();
	$user = $_SESSION['curr_id'];
    $incAmt = 50;
    echo $user;
	// query user database for the curr users money
	$query = "SELECT currency FROM auth_list WHERE id='".$user."'";
	$statement = $db_socket->prepare($query);
	$statement->execute();
    // Add some currency!
	$tmp = $statement->fetchAll();
    $curr = $tmp[0][0] + $incAmt;
    $db_socket = initSocket();
    $query = "UPDATE auth_list SET currency=".$curr." WHERE id=".$user;
	$statement = $db_socket->prepare($query);
	$statement->execute();

    //close db
    include 'closedb.php';
	echo json_encode($curr);
?>