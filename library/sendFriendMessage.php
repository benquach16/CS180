<?php
	session_start();
	include 'opendb.php';
	$db_socket = initSocket();
	$receiverID = $_GET['tmp'];
	$senderID = $_SESSION['curr_id'];
	$senderName = $_SESSION['curr_user'];
	$message = $_GET['inputValue'];

	echo $message;

	//create a notification for them
	//can send as many messages as they want
	$query = "insert into ".$configValue['DB_NOTIFICATIONS_LIST']." (receiver_id,sender_id,notification_type,sender,message) values (:receiver_id, :sender_id, :notification_type, :sender, :message)";
	$statement = $db_socket->prepare($query);
	$noti_type = 1;
	$statement->bindParam(':receiver_id', $receiverID);
	$statement->bindParam(':sender_id', $senderID);
	$statement->bindParam(':notification_type', $noti_type);
	$statement->bindParam(':sender',$senderName);
	$statement->bindParam(':message', $message);

	$statement->execute();
	
	include 'closedb.php';
?>
