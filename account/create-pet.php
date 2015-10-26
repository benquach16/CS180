<?php
    session_start();
    //here we should do a check for how many pets a user already has
    include_once ('../library/opendb.php');
    $db_socket = initSocket();

    $query = "SELECT * FROM ". $configValue['DB_TEAM_TABLE'] . " WHERE id = '". $_SESSION['curr_id'] ."'";
    $statement = $db_socket->prepare($query);
    $statement->execute();

    $res = $statement->fetchAll();

    // to check if team is full, we check if last slot on the team is full
    if($res[0][4] != 0){
        header('Location: account-adopt.php?state=party full');
    }
    else{
        echo "lets create a pet";
        $temp_type = "bunny";

        try{
            //make pet
            $query = "INSERT INTO ".$configValue['DB_PET_TABLE']." (`type`, `name`) VALUES (:type, :name)";
            $add_stmt = $db_socket->prepare($query);
            $add_stmt->bindParam(':type', $temp_type);
            $add_stmt->bindParam(':name', $_POST['pet-name']);
            $add_stmt->execute();
            $pet_id = $db_socket->lastInsertId();

            if($res[0][1] == 0){
                $query = addPetQuery("pet1", $pet_id);
                $db_socket->exec($query);
            } else if ($res[0][2] == 0){
                $query = addPetQuery("pet2", $pet_id);
                $db_socket->exec($query);
            } else if ($res[0][3] == 0){
                $query = addPetQuery("pet3", $pet_id);
                $db_socket->exec($query);
            } else if ($res[0][4] == 0){
                $query = addPetQuery("pet4", $pet_id);
                $db_socket->exec($query);
            }

        }catch(PDOException $e) {
            echo 'Connection to database failed: '.$e->getMessage();
        }


        header('Location: account-adopt.php?state=pet added');
    }

    function addPetQuery($pos, $pet_id){
        include('../library/server.config.php');
        return "UPDATE ". $configValue['DB_TEAM_TABLE'] ." SET ".$pos." = ".$pet_id." WHERE id = " . $_SESSION['curr_id'];
    };
?>