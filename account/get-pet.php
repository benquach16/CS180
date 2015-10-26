<?php
if(isset($_POST)){
    include ('../library/server.config.php');
    include_once ('../library/opendb.php');

    $string = file_get_contents("../library/pet-types.json");
    $pet_type = json_decode($string, true);

    $strings = file_get_contents("../library/item-types.json");
    $item_type = json_decode($strings, true);

    if(isset($_POST['user_id'])){
        $db_socket = initSocket();
        $query = "SELECT * FROM ".$configValue['DB_TEAM_TABLE']." WHERE id = '". $_POST['user_id'] ."'";

        $statement = $db_socket->prepare($query);
        $statement->execute();
        $json["pet_list"] = array();
        if($statement->rowCount() == 1){
            $res = $statement->fetchAll();

            for($i = 1; $i < 5; $i++){
                $pet_query = "SELECT * FROM ".$configValue['DB_PET_TABLE']." WHERE id = '". $res[0][$i] ."'";

                $pet_stmt = $db_socket->prepare($pet_query);
                $pet_stmt->execute();

                if($pet_stmt->rowCount() == 1){
                    //we have base pet info at this scope; base stats, equip coordinates
                    $pet_res = $pet_stmt->fetchAll();
                    //echo $pet_type[ $pet_res[0]['type'] ]['base_img'];
                    $temp['base'] = $pet_type[ $pet_res[0]['type'] ]['base_img'];
                    $temp['hat'] = $item_type["items"][ $pet_res[0]['hat'] ]['base_img'];
                    $temp['top'] = $item_type["items"][ $pet_res[0]['top'] ]['base_img'];
                    $temp['bottom'] = $item_type["items"][ $pet_res[0]['bottom'] ]['base_img'];

                    array_push($json["pet_list"], $temp);
                }
            }
        }
        echo json_encode($json);
    }
}

function petInfoSetup(){
    include ('../library/server.config.php');
    include_once ('../library/opendb.php');
    $string = file_get_contents("../library/pet-types.json");
    $pet_type = json_decode($string, true);

    $db_socket = initSocket();
    $query = "SELECT * FROM ".$configValue['DB_TEAM_TABLE']." WHERE id = '". $_SESSION['curr_id'] ."'";

    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() == 1){
        //we have pet info in this scope
        $res = $statement->fetchAll();

        for($i = 1; $i < 5; $i++){

            $pet_query = "SELECT * FROM ".$configValue['DB_PET_TABLE']." WHERE id = '". $res[0][$i] ."'";

            $pet_stmt = $db_socket->prepare($pet_query);
            $pet_stmt->execute();

            if($pet_stmt->rowCount() == 1){
                //we have base pet info at this scope; base stats, equip coordinates
                $pet_res = $pet_stmt->fetchAll();
                $img_uri = $pet_type[ $pet_res[0]['type'] ]['base_img'];

                echo "<div class='pet-select'><img src='http://" .$_SERVER['HTTP_HOST'].$img_uri. "' width='100' height='100' />";
                echo "<p>".$pet_res[0]['name']."</p></div>";
            }
        }
    }
    include('../library/closedb.php');
}

?>