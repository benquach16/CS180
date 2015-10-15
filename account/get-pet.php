<?php
include_once ('../library/server.config.php');

include_once ('../library/opendb.php');

$db_socket = initSocket();
$query = "SELECT * FROM ".$configValue['DB_PET_TABLE']." WHERE owner = '". $_SESSION['curr_id'] ."'";

$statement = $db_socket->prepare($query);
$statement->execute();

if($statement->rowCount() > 0){
    //we have pet info in this scope
    $res = $statement->fetchAll();

    for($i = 0; $i < $statement->rowCount(); $i++){

        $query = "SELECT * FROM ".$configValue['DB_PET_TYPE']." WHERE type_id = '". $res[$i]['type'] ."'";

        $stmt = $db_socket->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            //we have base pet info at this scope; base stats, equip coordinates
            $rs = $stmt->fetchAll();
            echo "<p>".$rs[0]['type_name'].' '.$res[$i]['name']."</p><br>";
        }
    }
}
?>