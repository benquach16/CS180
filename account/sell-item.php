<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include ($_SERVER['DOCUMENT_ROOT'].'/library/server.config.php');
    include ($_SERVER['DOCUMENT_ROOT'].'/library/opendb.php');

    $string = file_get_contents("../library/item-types.json");
    $item_type = json_decode($string, true);
    $db_socket = initSocket();

    $get_currency = "SELECT currency FROM ".$configValue['DB_USER_TABLE'].
        " WHERE id=".$_POST['userId'];

    try{
        $statement = $db_socket->prepare($get_currency);
        $statement->execute();
    }catch(PDOException $e) {
        echo 'Connection to database failed: '.$e->getMessage();
    }
    //$result = $statement->fetchAll();
    if($statement->rowCount() == 1){
        $old = $statement->fetchAll()[0][0];

        $new_currency = $old + $item_type['items'][ $_POST['itemId'] ]['price'];
        //echo $new_currency;

        $query = "UPDATE ".$configValue['DB_USER_TABLE'].
            " SET currency=".$new_currency.
            " WHERE id=" .$_POST['userId'];

        $statement = $db_socket->prepare($query);
        $statement->execute();

        $inv_remove = "UPDATE ".$configValue['DB_INV_TABLE'].
            " SET slot".$_POST['slotId']."=0".
            " WHERE id=" .$_POST['userId'];

        $statement = $db_socket->prepare($inv_remove);
        $statement->execute();
    }
    echo json_encode(json_decode("{}"));
}
?>