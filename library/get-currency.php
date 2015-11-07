<?php
    // get req will take in user_id as url encoded,
    // this will return the current currency value of the user
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        //check if user_id has been passed in by get req, otherwise abort
        if(isset($_GET['user_id'])){
            //init global vars and sockets
            include ('../library/server.config.php');
            include_once ('../library/opendb.php');

            //init the db socket
            $db_socket = initSocket();

            //create query string for maria call
            $query = "SELECT currency FROM ". $configValue['DB_USER_TABLE'] .
                " WHERE id=". $_GET['user_id'];

            //set up andexecute query
            $statment = $db_socket->prepare($query);
            $statment->execute();

            //return numeric value of the currency back to client as a json object
            $json['currency'] = $statment->fetchAll(PDO::FETCH_NUM)[0][0];
            echo json_encode($json);

            //destroy socket in its scope
            include('../library/closedb.php');
        }
    }
?>