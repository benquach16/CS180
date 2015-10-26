<?php
    //this php script will echo out html to propely display a
    // table of the current players inventory
    //session_start();
    include ('../library/server.config.php');
    $string = file_get_contents("../library/item-types.json");
    $item_type = json_decode($string, true);
    include_once ('../library/opendb.php');

    $db_socket = initSocket();
    $query = "SELECT * FROM ".$configValue['DB_INV_TABLE']." WHERE id = '". $_SESSION['curr_id'] ."'";

    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() == 1){
        $res = $statement->fetchAll();

        //set up nested for loop to display rows for the inventory. We need a const variable
        //to hold how many variables are held per row.

        //then we divide the max inventory size (another const) and each nested forloop will iterate
        //that many times. there will be inv_max - inv_count trailing empty inventory slots.
        //they will just be table cells with no image but same size of the images in the inventory (perhaps 50x50?)

        echo "<div class='inv-row'>";
        
        //magic numbers are size of inventory(28) and 1, which is the first value sans-id
        for($i = 1; $i < (count($res[0]) / 2); $i++){

            if( $res[0][$i] != 0){
                $img_uri = $item_type['items'][ $res[0][$i] ]['base_img'];
                $name = $item_type['items'][ $res[0][$i] ]['name'];
                $type = $item_type['items'][ $res[0][$i] ]['type'];


                echo "<div><img id='".$res[0][$i].'_'.$i."' src='http://".$_SERVER['HTTP_HOST'].$img_uri.
                    "' draggable='true' ondragstart='drag(event)' class='".$type.
                    " slot' width='50' height='50'></div>";
            } else {
                echo "<div><img width='50' height='50' class='empty-slot'></div>";
            }


        }

        echo "</div>";
    }
?>