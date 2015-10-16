<?php


function getUser(){
    include(__DIR__."./server.config.php");
    include_once (__DIR__."./opendb.php");

    $db_socket = initSocket();
    $query = "SELECT user FROM ".$configValue['DB_USER_TABLE'].
        " WHERE id = '".$_SESSION['curr_id']."'";
    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() == 1){
        $res = $statement->fetchAll();
        echo $res[0]['user'];
    } else {
        echo session_id().' '.$_SESSION['curr_id'];
    }

    include (__DIR__.'./closedb.php');
    return;
}

//do not use this
function getPets(){
    include_once (__DIR__."./opendb.php");

    $db_socket = initSocket();
    $query = "SELECT  FROM"."";
}

function getName(){
    #currently dont use this function, we need a seperate db other that auth_list to handle
    #non authorization reqlike getting a character name
    include (__DIR__.'opendb.php');

    $db_socket = initSocket();
    $query = "SELECT charname FROM ".$configValue['DB_USER_TABLE'].
        " WHERE id = '".$_SESSION['curr_id']."'";
    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() == 1){
        $res = $statement->fetchAll();
        echo $res[0]['charname'];
    } else {
        echo '{NO ENTRY}';
    }

    include 'closedb.php';
    return ;
}
?>