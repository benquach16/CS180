<?php
/**
 * Created by PhpStorm.
 * User: Calvin
 * Date: 10/6/2015
 * Time: 10:49 AM
 */
?>
<!doctype html>
<html>
    <head>
        <title>Account Info</title>
    </head>
    <body>

        <?php include('../library/nav-bar.html'); ?>

        <div id="acct-info-container">
            <!-- add html//js for account features-->
            <!-- ability to display character (pet) avatar-->
            <!-- perhaps display character inventory? how do we design this?-->
            <!-- maybe we can store an inventory as a JSON object in mysql-->
            <p>Username: <?php include('../library/getUser.php'); getUser(); echo $_SESSION['curr_id']?> </p>
        </div>

    </body>
</html>
