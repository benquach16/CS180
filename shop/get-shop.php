<?php
    //api to get elements in the shop
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $string = file_get_contents("../library/item-types.json");
        $item_json = json_decode($string, true);

        $json["shop_ary"] = [];
        for ($i = 0; $i < count($item_json["items"]); $i++){
            if($item_json["items"][$i]["rarity"] == "common"){
                array_push($json["shop_ary"], $item_json["items"][$i]);
            }
        }
        echo json_encode($json);
    }

    //api call to purchase an item
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $string = file_get_contents("../library/item-types.json");
        $item_json = json_decode($string, true);

        //includes for db/variables
        include ('../library/server.config.php');
        include_once ('../library/opendb.php');

        $db_socket = initSocket();
        $json['error'] = [];

        $target_item = $item_json['items'][$_POST['item_id']];

        if(isset($_POST['user_id'])){
            $price = $target_item['price'];
            //first check if user has enough neo-shekels to purchase
            $query = "SELECT currency FROM ".$configValue['DB_USER_TABLE'].
                " WHERE id=".$_POST['user_id'];
            $statement = $db_socket->prepare($query);
            $statement->execute();

            if($statement->rowCount() == 1){
                $res = $statement->fetchAll();
                if($price > $res[0]['currency']){
                    $diff = $price - $res[0]['currency'];
                    array_push($json['error'], "Not enough neo-shekels! You are short ".$diff.".");
                } else {
                    //make sure there is an empty inv slot
                    $query0 = "SELECT * FROM ".$configValue['DB_INV_TABLE']." WHERE id=".$_POST['user_id'];
                    $stmt0 = $db_socket->prepare($query0);
                    $stmt0->execute();
                    $res0 = $stmt0->fetchAll(PDO::FETCH_NUM);

                    $empty_index = null;
                    for($i = 1; $i < count($res0[0]); $i++){
                        if($res0[0][$i] == 0){
                            $empty_index = $i;
                            break;
                        }
                    }

                    if($empty_index == null){
                        array_push($json['error'], "Not enough inventory slots!");
                    } else{
                        //this whole process should be a SQL transaction, change it later if necessary

                        $balance = $res[0]['currency'] - $price;
                        $query1 = "UPDATE ".$configValue['DB_USER_TABLE']." SET".
                            " currency=". $balance. " WHERE id=".$_POST['user_id'];
                        $stmt1 = $db_socket->prepare($query1);
                        $stmt1->execute();

                        $query2 = "UPDATE ".$configValue['DB_INV_TABLE']." SET".
                            " slot".$empty_index."=". $_POST['item_id'].
                            " WHERE id=". $_POST['user_id'];
                        $stmt2 = $db_socket->prepare($query2);
                        $stmt2->execute();
                    }
                }
            }
            echo json_encode($json);
        }

        include('../library/closedb.php');
    }
?>