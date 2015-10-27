<?php
	//check if they are already friends first
	session_start();
	include 'opendb.php';
	$senderID = $_SESSION['curr_id'];
	$receiverID = $_GET['tmp'];
	$receiverName = $_SESSION['curr_user'];
	//echo $receiverID;
	$db_socket = initSocket();
	//make sure they are not already friends
	$query = "select * from ".$configValue['DB_FRIENDS_LIST']." where id_A ='".$senderID."' and id_B='".$receiverID."'";
	$statement = $db_socket->prepare($query);
	$statement->execute();
	if($statement->rowCount() == 0)
	{
		//we're good
		//create notification request now
		$query_insert = "insert into ".$configValue['DB_NOTIFICATIONS_LIST']." (receiver_id,sender_id,notification_type,sender,message) values (:receiver_id,:sender_id,:notification_type,:sender,:message)";
		$statement_insert = $db_socket->prepare($query_insert);
		$statement_insert->bindParam(':receiver_id',$receiverID);
		$statement_insert->bindParam(':sender_id',$senderID);
		$noti_type = 0;
		$msg = "friend confirm";
		$statement_insert->bindParam(':notification_type', $noti_type);
		$statement_insert->bindParam(':sender',$receiverName);
		$statement_insert->bindParam(':message',$msg);;
		$statement_insert->execute();
		echo 'Success';
	}
	else
	{
		echo 'Already friends';
	}
	include 'closedb.php';
?>
