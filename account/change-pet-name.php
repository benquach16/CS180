<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        include ($_SERVER['DOCUMENT_ROOT'].'/library/server.config.php');
        include ($_SERVER['DOCUMENT_ROOT'].'/library/opendb.php');

        $db_socket = initSocket();

        $query = "UPDATE ".$configValue['DB_PET_TABLE'].
            " SET name='".$_POST['new_name'].
            "' WHERE id=";

        $subquery = "(SELECT pet".$_POST['pet_id'].
            " FROM ".$configValue['DB_TEAM_TABLE'].
            " WHERE id=".$_POST['user_id'].")";

         $query .= $subquery;

        try{
            $statement = $db_socket->prepare($query);
            $statement->execute();
            //var_dump( $statement->fetchAll() );
        }catch(PDOException $e) {
            echo 'Connection to database failed: '.$e->getMessage();
        }
        echo json_encode(json_decode("{}"));
    }

?>