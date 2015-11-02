<?php
    //session_start();
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        //we have a get req so we should retrive and return data about the user inventory
        include ('../library/server.config.php');
        $string = file_get_contents("../library/item-types.json");
        $item_type = json_decode($string, true);
        include_once ('../library/opendb.php');

        $db_socket = initSocket();
        $query = "SELECT * FROM ".$configValue['DB_INV_TABLE']." WHERE id = '". $_GET['user_id'] ."'";

        $statement = $db_socket->prepare($query);
        $statement->execute();

        if($statement->rowCount() == 1) {
            $res = $statement->fetchAll();
            $json["user_inv"] = array();
            //$json["user_id"] = $_GET['user_id'];
            for($i = 1; $i < (count($res[0]) / 2); $i++){

                if( $res[0][$i] != 0){
                    $img_uri = $item_type['items'][ $res[0][$i] ]['base_img'];
                    $name = $item_type['items'][ $res[0][$i] ]['name'];
                    $type = $item_type['items'][ $res[0][$i] ]['type'];
                    $item_id = $res[0][$i];

                    $temp[ "img" ] = $img_uri;
                    $temp[ "name" ] = $name;
                    $temp[ "type" ] = $type;
                    $temp[ "item_id" ] = $item_id;

                    array_push($json["user_inv"], $temp);
                } else {
                    $temp[ "img" ] = '';
                    $temp["type"] = 'Empty';
                    $temp["item_id"] = 0;
                    $temp[ "name" ] = '';
                    array_push($json["user_inv"], $temp);
                }
            }
            echo json_encode($json);
        }
        include('../library/closedb.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //post req to handle a change in inventory

        //grab json from the post req and convert it to php object
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        //includes for db/variables
        include ('../library/server.config.php');
        include_once ('../library/opendb.php');

        //create php object of items from item json
        $string = file_get_contents("../library/item-types.json");
        $item_type = json_decode($string, true);

        //init socket
        $db_socket = initSocket();

        //we retrieve user id from the post data
        //updat the usr inv from person obj
        $query = 'UPDATE '. $configValue['DB_INV_TABLE']. ' SET';

        for($i = 0; $i < 28; $i++){
            $slot = $i+1;
            $query .= ' slot'.$slot.'='. $obj['item_ary'][$i]["item_id"];
            if($i != 27){
                $query .= ',';
            }
        }

        $query .= ' WHERE id ='. $obj["user_id"];

        $statement = $db_socket->prepare($query);
        $statement->execute();


        include('../library/closedb.php');
        echo json_encode($obj);
    }


?>