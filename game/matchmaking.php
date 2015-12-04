<?php
//Standard connection to php
include ($_SERVER['DOCUMENT_ROOT'].'/library/server.config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/library/opendb.php');
$db_socket = initSocket();

//Get table
$sql = "SELECT id, playerID, petID, peerID FROM matchmaking";
$statement = $db_socket->prepare($sql);
$statement->execute();

//If there is at least one result
if ($statement->rowCount() > 0) {
	
    // output data of each row
	$row = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
    //print_r($row);
	echo "{ \"connType\":\"1\", \"playerID\":\"" . $row["playerID"] . "\", \"petID\":\"" . $row["petID"] . "\", \"peerID\":\"" . $row["peerID"] . "\"}";

    $sql = "DELETE FROM matchmaking WHERE id=" . $row["id"];
	$statement = $db_socket->prepare($sql);
	$statement->execute();
	
} else {
	
	$sql = "INSERT INTO matchmaking (playerID, petID, peerID)
	VALUES (" . $_GET["playerID"] . ", " . $_GET["petID"] . ", " . $_GET["peerID"] . ")";
	$statement = $db_socket->prepare($sql);
	$statement->execute();
	echo "{ \"connType\":\"0\", \"playerID\":\"\", \"petID\":\"\", \"peerID\":\"\"}";
}
$db_socket = null;
?>