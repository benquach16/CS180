<?php
session_start();
require_once(__DIR__."./server.config.php");
function getUser(){
    include (__DIR__."./opendb.php");

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

function getName(){
    include 'opendb.php';

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