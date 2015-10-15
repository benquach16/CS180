<?php session_start();
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
            <p>Username: <?php include('../library/getUser.php'); getUser(); ?> </p>
        </div>

        <div class="pet-party-display">
            <?php include('get-pet.php'); ?>
        </div>

    </body>
</html>
