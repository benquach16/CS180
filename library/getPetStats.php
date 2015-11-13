<?php
    //get req to get stats of a pet, need to pass in user and which pet, (user id and 1-4 for pet)
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['user_id'])){
            include ($_SERVER['DOCUMENT_ROOT'].'/library/server.config.php');
            include_once($_SERVER['DOCUMENT_ROOT'].'/library/opendb.php');
            $db_socket = initSocket();

            // get json for pets and items, need these stats
            $item_string = file_get_contents("item-types.json");
            $item_type = json_decode($item_string, true);

            $pet_string = file_get_contents("pet-types.json");
            $pet_type = json_decode($pet_string, true);

            $query = "SELECT type, hat, top, bottom".
                " FROM ". $configValue['DB_PET_TABLE'].
                " WHERE id=( SELECT pet". $_GET['pet_id'].
                " FROM ". $configValue['DB_TEAM_TABLE'].
                " WHERE id=". $_GET['user_id'] .")";
            echo $query;

            $statement = $db_socket->prepare($query);
            $statement->execute();
            if ($statement->rowCount() == 1){
                $pet = $statement->fetchAll(PDO::FETCH_ASSOC);
                $pet_base = $pet_type[ $pet[0]['type'] ]['stats'];

                if($pet[0]['hat'] != 0){
                    $hat_bonus = $item_type['items'][ $pet[0]['hat'] ]['stats'];
                    for($i = 0; $i < count($hat_bonus); $i++ ){
                        foreach ($hat_bonus[$i] as $key => $val) {
                            //echo $key.' '.$val;
                            $pet_base[ $key ] += $val;
                        }
                    }
                }
                echo json_encode($pet_base);
            }
        }
    }
?>