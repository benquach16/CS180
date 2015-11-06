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
        <!-- <script src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/library/ajax-call.php'; ?>"></script> -->
        <script src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/library/render.js'; ?>"></script>

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
                        }
                    });
                    return result;
                }
            });

            var renderers = [];
            var containers = [];
            var globalID;

            function populatePetSection(pet_ary){
                var section = $('#pet-section');
                for(var i = 0; i < pet_ary.pet_list.length; i++){
                    var pet = document.createElement('DIV');
                    $(pet).attr('style', 'width: 250px; height: 270; border: solid 1px; border-color: lime;');
                    pet.id = "pet"+i;

                    var canvas = document.createElement('CANVAS');
                    canvas.id = 'canvas' + i;
                    canvas.height = 250;
                    canvas.width = 250;
                    $(pet).append(canvas);

                    var name = document.createElement('P');
                    $(name).attr('style', 'width: 250px; border: solid 1px; border-color: lime');
                    $(name).append(pet_ary.pet_list[i].name);
                    $(pet).append(name);

                    section.append(pet);

                    var container = new PIXI.Container(0x66FF99);
                    containers.push (container);

                    addImg(pet_ary.pet_list[i].base, container, canvas);
                    if(pet_ary.pet_list[i].pet_hat != '0'){
                        addImg(pet_ary.pet_list[i].hat_img, container, canvas);
                    }
                    if(pet_ary.pet_list[i].pet_top != '0'){
                        addImg(pet_ary.pet_list[i].top_img, container, canvas);
                    }
                    if(pet_ary.pet_list[i].pet_bottom != '0'){
                        addImg(pet_ary.pet_list[i].bottom_img, container, canvas);
                    }
                }
            }

            function setupRenderers(){
                $('#pet-section').children().each(function(i){
                    var c = document.getElementById('canvas'+i);
                    renderers.push(new PIXI.autoDetectRenderer(c.width, c.height, {view: c}) );
                });
            }

            function animate(timestamp){
                for(var i = 0; i < renderers.length; i++){
                    renderers[i].render(containers[i]);
                }

                globalID = requestAnimationFrame( function(timestamp){
                    animate(timestamp);
                } );
            }

            function onInit(){
                populatePetSection($.getValues("get-pet.php", "GET", "user_id=<?php echo $_SESSION['curr_id']; ?>", "application/x-www-form-urlencoded"));
                setupRenderers();
                globalID = requestAnimationFrame( function(timestamp){
                    animate(timestamp);
                } );
            }
        </script>
    </body>
</html>
