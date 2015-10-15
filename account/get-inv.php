<?php
    //this php script will echo out html to propely display a
    // table of the current players inventory
    //session_start();
    include_once ('../library/server.config.php');

    include_once ('../library/opendb.php');

    $db_socket = initSocket();
    $query = "SELECT * FROM ".$configValue['DB_INV_TABLE']." WHERE owner = '". $_SESSION['curr_id'] ."'";

    $statement = $db_socket->prepare($query);
    $statement->execute();

    if($statement->rowCount() > 0){
        $res = $statement->fetchAll();

        //set up nested for loop to display rows for the inventory. We need a const variable
        //to hold how many variables are held per row.

        //then we divide the max inventory size (another const) and each nested forloop will iterate
        //that many times. there will be inv_max - inv_count trailing empty inventory slots.
        //they will just be table cells with no image but same size of the images in the inventory (perhaps 50x50?)

        echo "<div class='inv-row'>";

        for($i = 0; $i < $statement->rowCount(); $i++){
            echo "<div><img id='".$res[$i]['item_name']."' src='http://".$_SERVER['HTTP_HOST'].$res[$i]['equip_img'].
                    "' draggable='true' ondragstart='drag(event)' class='".$res[$i]['item_type'].
                    "' width='50' height='50'><div>";
        }

        echo "</div>";
    }
?>