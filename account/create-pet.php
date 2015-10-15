<?php
    session_start();
    //here we should do a check for how many pets a user already has
    include_once ('../library/opendb.php');
    $db_socket = initSocket();

    $query = "SELECT * FROM ". $configValue['DB_PET_TABLE'] . " WHERE owner = '". $_SESSION['curr_id'] ."'";
    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() > 3){
        header('Location: account-adopt.php?state=party full');
    }
    else{
        echo "lets create a pet";
        $temp_type = 1;

        try{
            $query = "INSERT INTO `pet_list`(`type`, `owner`, `name`) VALUES (:type, :owner, :name)";
            $add_stmt = $db_socket->prepare($query);
            $add_stmt->bindParam(':type', $temp_type);
            $add_stmt->bindParam(':owner', $_SESSION['curr_id']);
            $add_stmt->bindParam(':name', $_POST['pet-name']);
            $add_stmt->execute();
        }catch(PDOException $e) {
            echo 'Connection to database failed: '.$e->getMessage();
        }


        header('Location: account-adopt.php?state=pet added');
    }
?>