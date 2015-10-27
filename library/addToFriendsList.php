<?php
	include './opendb.php';
	session_start();
	$currID = $_SESSION['curr_id'];
	$senderID = $_GET['senderID'];
	$messageID = $_GET['messageID'];
	//echo $senderID;

	//add these two to the current friends list
	//make sure that they dont already exist first
	$db_socket = initSocket();
	$query = "SELECT * FROM ".$configValue['DB_FRIENDS_LIST']." WHERE id_A ='".$senderID."'";
	$statement = $db_socket->prepare($query);
	$statement->execute();
	if($statement->rowCount() == 0)
	{
		//ok good not friends already
		//insert pairs <currID,senderID> and <senderID,currID> into the database
		$insert_query_a = "insert into ".$configValue['DB_FRIENDS_LIST']." (id_A,id_B) values (:id_a,:id_b)";
		$statement_query_a = $db_socket->prepare($insert_query_a);
		$statement_query_a->bindParam(':id_a', $currID);
		$statement_query_a->bindParam(':id_b', $senderID);
		$statement_query_a->execute();

		//round 2
		$insert_query_b = "insert into ".$configValue['DB_FRIENDS_LIST']." (id_A,id_B) values (:id_a,:id_b)";
		$statement_query_b = $db_socket->prepare($insert_query_a);
		$statement_query_b->bindParam(':id_a', $senderID);
		$statement_query_b->bindParam(':id_b', $currID);
		$statement_query_b->execute();

		//remove notification from notificationslist
		$delete_query = "delete from ".$configValue['DB_NOTIFICATIONS_LIST']." where id='".$messageID."'";
		$delete_statement = $db_socket->prepare($delete_query);
		$delete_statement->execute();
	}
	else
	{
		//already a friend so do nothing
		echo 'Already a friend';
	}
	include './closedb.php';
?>
