<?php session_start();
?>
<!doctype html>
<html>
    <head>
        <title>Account Info</title>
    </head>
    <body onload="onInit();">
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
            <div id="pet-section">
            </div>
        </div>

        <script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script>
            jQuery.extend({
                getValues: function(url, method, data, type) {
                    var result = null;
                    $.ajax({
                        url: url,
                        type: method,
                        data: data,
                        dataType: type,
                        //contentType: 'application/json',
                        async: false,
                        success: function(data) {
                            result = jQuery.parseJSON(data);
                        },
                        error: function(xhr){
                            result = jQuery.parseJSON(xhr.responseText);
                        },
                    });
                    return result;
                }
            });

            function populatePetSection(pet_ary){
                var section = $('#pet-section');
                for(var i = 0; i < pet_ary.pet_list.length; i++){
                    var pet = document.createElement('DIV');
                    pet.id = "pet"+i;

                    var img = document.createElement('IMG');
                    img.src = '../'+pet_ary.pet_list[i].base;
                    img.height = 
                    $(pet).append(img);

                    var name = document.createElement('P');
                    $(name).append(pet_ary.pet_list[i].name);
                    $(pet).append(name);

                    section.append(pet);
                }
            }

            function onInit(){
                populatePetSection($.getValues("get-pet.php", "GET", "user_id=<?php echo $_SESSION['curr_id']; ?>", "application/x-www-form-urlencoded"));
            }
        </script>
    </body>
</html>
