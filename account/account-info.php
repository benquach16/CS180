<?php session_start();
?>
<!doctype html>
<html>
    <head>
        <title>Account Info</title>
    </head>
    <body>
        <style>
            .pet-party-display{
                border: solid;
                border-width: 1px;
                border-color: black;
                display: table;
            }
            .pet-party-display > div{
                display: table-row;
            }
            .pet-party-display > div > div{
                display: table-cell;
            }
            .pet-party-display > div > div > p{
                text-align: center;
            }
        </style>

        <?php include('../library/nav-bar.html'); ?>

        <div id="acct-info-container">
            <!-- add html//js for account features-->
            <!-- ability to display character (pet) avatar-->
            <!-- perhaps display character inventory? how do we design this?-->
            <!-- maybe we can store an inventory as a JSON object in mysql-->
            <p>Username: <?php include('../library/getUser.php'); getUser(); ?> </p>
        </div>

        <div class="pet-party-display">
            <div>
                <?php include('get-pet.php'); petInfoSetup();?>
            </div>
        </div>

        <script>

        </script>
    </body>
</html>
