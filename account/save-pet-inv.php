<?php
    /*
     * REST API SPECS
     * GET(user)
     *     The get request should return a team of pets for the specific user. Returns it with JSON like this:
     *     {
     *          [
     *              {object: pet1},
     *              {object: pet2},
     *              {object: pet3},
     *              {object: pet4}
     *          ]
     *     }
     *
     * POST(obj)
     *
     */
    if(isset($_POST)){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        include("../library/server.config.php");
        include_once("../library/opendb.php");

        if(isset($_POST['command'])){
            switch($_POST['command']){
                case "update_both":
                    if(isset($obj['user_id'])){
                        $db_socket = initSocket();
                        $inv_ary = $obj['inv'];
                        $query = "UPDATE ".$configValue['DB_INV_TABLE']." SET slot1=".$inv_ary[0]
                            .", slot2=".$inv_ary[1]
                            .", slot3=".$inv_ary[2]
                            .", slot4=".$inv_ary[3]
                            ." WHERE id=".$obj['user_id'];
                        $statement = $db_socket->prepare($query);
                        $statement->execute();
                        include("../library/closedb.php");
                    }
                    if(isset($obj['pet_id'])){
                        $db_socket = initSocket();
                        $inv_ary = $obj['pet_inv'];
                        $query = "UPDATE ".$configValue['DB_PET_TABLE']." SET hat=".$inv_ary['hat']
                            .", top=".$inv_ary['top']
                            .", bottom=".$inv_ary['bottom']
                            ." WHERE id=".$obj['pet_id'];;
                        $statement = $db_socket->prepare($query);
                        $statement->execute();
                        include("../library/closedb.php");
                    }
                    break;

                default:
                    echo "command not found";
            }

        }
    }

?>