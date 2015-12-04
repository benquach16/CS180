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
            .pet-party-display > div > div > div > p{
                text-align: center;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pixi.js/3.0.8/pixi.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/library/ajax-call.js'; ?>"></script>
        <script src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/library/render.js'; ?>"></script>

        <?php include('../library/nav-bar.html'); ?>
		<div class = "container center-text">
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
		</div>

        <!-- Modal -->
        <div id="petNameChange" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id='myModalLabel'>Change pet name</h4>
                    </div>
                    <div class="modal-body">
                        <div class='modal-body-inner'>
                            <div class="modal-left">
                                <label for="new-name">
                                    <input id="new-name">
                                </label>
                                <button class="btn btn-default submit-name-change">Change</button>
                            </div>
                            <div class='modal-mid'>&nbsp;</div>
                            <div class='modal-right select-character'>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>


            var renderers = [];
            var containers = [];
            var globalID;

            function populatePetSection(pet_ary){
                var section = $('#pet-section');
                for(var i = 0; i < pet_ary.pet_list.length; i++){
                    var pet = document.createElement('DIV');
                    $(pet).attr('style', 'width: 250px; height: 270; border: solid 1px; border-color: lime;');
                    pet.id = i + 1;

                    var canvas = document.createElement('CANVAS');
                    canvas.id = 'canvas' + i;
                    canvas.height = 250;
                    canvas.width = 250;
                    $(pet).append(canvas);

                    var name_div = document.createElement('DIV');
                    var name = document.createElement('P');
                    $(name).attr('style', 'width: 250px; border: solid 1px; border-color: lime');
                    //$(name).attr('data-toggle', 'modal');
                    //$(name).attr('data-target', '#petNameChange');
                    $(name).addClass('name-change');
                    $(name_div).addClass('name-hold');
                    $(name).append(pet_ary.pet_list[i].name);
                    $(name_div).append(name);
                    $(pet).append(name_div);

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

            $('.pet-party-display').on('click','p.name-change',function(){
                $('#petNameChange').modal('show');
                $('#new-name').attr( 'value', $(this).text() );
                $('#new-name').attr( 'name', $(this).parent().parent().attr('id') );
            });

            $('.submit-name-change').on('click', function(){
                var newName = $('#new-name').val();
                var petId = $('#new-name').attr('name');
                var userId = <?php echo $_SESSION['curr_id']; ?>;
                var input = "new_name="+newName+"&pet_id="+petId+"&user_id="+userId;
                $.getValues("change-pet-name.php", "POST", input, "application/x-www-form-urlencoded");
                $('#'+petId).children('div.name-hold').children('p.name-change').text(newName);
                //console.log($('#'+petId).children('div.name-hold').children('p.name-change').text());
            });

        </script>
    </body>
		<div id="chatbar">
		    <?php include ('../library/chat-bar.html');?>
	    </div>
</html>
