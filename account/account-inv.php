<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>test</title>
</head>
<body onload="onInit();">
    <style>
        #inventory{
            border: solid;
            border-color: red;
            border-width: 1px;
            display: table;
            float: right;
        }
        #inventory > div{
            border: solid;
            border-color: blue;
            border-width: 1px;
            display: table-row;
        }
        #inventory > div > div{
            border: solid;
            border-color: green;
            border-width: 1px;
            display: table-cell;
        }
    </style>
    <?php include('../library/nav-bar.html'); ?>
    <button id="clean">clean</button>
    <button id="save">save</button>

    <!-- we want db call to get total number of pets. this should output some button array to choose which is visable-->
    <div id="pet-list">
        <!-- if the pet does not exist, then we output a disabled button-->
        <button id="pet0-btn">0</button>
        <button id="pet1-btn">1</button>
        <button id="pet2-btn">2</button>
        <button id="pet3-btn">3</button>
    </div>

    <!-- store the pet default type somewhere, maybe a div? seems hacky -->
    <div id="drop-target"  style="height:200px; width:200px; position: absolute;">
        <canvas id="testCanv" ondrop="drop(event, this)" ondragover="allowDrop(event)" height="200" width="200"></canvas>
    </div>

    <div id="inventory" >
        <!-- do db call here for avilible items, also set a value to know what kind of item it is -->

    </div>

    <script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript">

        var xhttp = new XMLHttpRequest();

        var pets_JSON;
        var globalID, canvas, renderer;
        var container_ary = [];
        var pet_inv_ary = [];

        var focus_int;

        var screen_w = 200;
        var screen_h = 200;

        var user_inv = client_user_inv(<?php echo $_SESSION['curr_id']; ?>);

        function client_pet_inv(hat, top, bot){
            this.pet_hat = hat;
            this.pet_top = top;
            this.pet_bot = bot;
        }

        function client_user_inv(id){
            this.user_id = id;
            this.row1 = [];
            this.row2 = [];
            this.row3 = [];
            this.row4 = [];
        }

        jQuery.extend({
            getValues: function(url, method, data) {
                var result = null;
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    dataType: 'application/x-www-form-urlencoded',
                    //contentType: 'application/json',
                    async: false,
                    success: function(data) {
                        result = jQuery.parseJSON(data);
                        //console.log(data);
                    },
                    error: function(xhr){
                        //alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                        result = jQuery.parseJSON(xhr.responseText);
                        //console.log(xhr.responseText);
                    },
                });
                return result;
            }
        });

        function onInit(){

            // create an new instance of a pixi stage
            for(var i = 0; i < 4; i++){
                container_ary.push( new PIXI.Container(0x66FF99) );
            }

            //get the user inv
            var test = $.getValues("get-inv.php", "GET", "user_id=1");
            console.log( test );

            //here use php to get the equip of a pet and populate pet_inv

            focus_int = 0;

            canvas = document.getElementById("testCanv");
            // create a renderer instance.
            renderer = PIXI.autoDetectRenderer(screen_w, screen_h, {view:document.getElementById("testCanv")});

            // add the renderer view element to the DOM
            //document.body.appendChild(renderer.view);
            setBG(container_ary[focus_int]);
            setAllPets();

            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        }

        function setAllPets(){
            pets_JSON = $.getValues("get-pet.php", "POST", "user_id=1");
            setPet(container_ary[0], '../' + pets_JSON.pet_list[0].base);
            setPet(container_ary[1], '../' + pets_JSON.pet_list[1].base);
            setPet(container_ary[2], '../' + pets_JSON.pet_list[2].base);
            setPet(container_ary[3], '../' + pets_JSON.pet_list[3].base);

            pet_inv_ary.push (new client_pet_inv(pets_JSON.pet_list[0].hat, pets_JSON.pet_list[0].top, pets_JSON.pet_list[0].bottom));
            pet_inv_ary.push (new client_pet_inv(pets_JSON.pet_list[1].hat, pets_JSON.pet_list[1].top, pets_JSON.pet_list[1].bottom));
            pet_inv_ary.push (new client_pet_inv(pets_JSON.pet_list[2].hat, pets_JSON.pet_list[2].top, pets_JSON.pet_list[2].bottom));
            pet_inv_ary.push (new client_pet_inv(pets_JSON.pet_list[3].hat, pets_JSON.pet_list[3].top, pets_JSON.pet_list[3].bottom));
        }

        function cleanContainer(){
            for (var i = container_ary[focus_int].children.length -1; i >=0  ; i--) {
                container_ary[focus_int].removeChildAt(i);
            };
            console.log(pet_inv_ary[focus_int].pet_hat);
            setBG(container_ary[focus_int]);
        }

        function setBG(container){
            // create a texture from an image path
            var texture = PIXI.Texture.fromImage("../resources/images/park.jpg");
            // create a new Sprite using the texture
            var bg = new PIXI.Sprite(texture);

            // center the sprites anchor point
            bg.anchor.x = 0.5;
            bg.anchor.y = 0.5;
            // move the sprite t the center of the screen
            bg.position.x = screen_w / 2;
            bg.position.y = screen_h / 2;
            container.addChild(bg);
            return bg;
        }

        function setPet(container, img){
            // create a texture from an image path
            var texture = PIXI.Texture.fromImage(img);
            // create a new Sprite using the texture
            var pet = new PIXI.Sprite(texture);

            // center the sprites anchor point
            pet.anchor.x = 0.5;
            pet.anchor.y = 0.5;
            // move the sprite t the center of the screen


            pet.position.x = screen_w / 2;
            pet.position.y = screen_h / 2;
            container.addChild(pet);
            return pet;
        }

        function setEquip(pet, img){

            // create a texture from an image path
            var texture2 = PIXI.Texture.fromImage(img); //"hat_trans.gif"
            // create a new Sprite using the texture
            var hat = new PIXI.Sprite(texture2);

            // center the sprites anchor point
            hat.anchor.x = pet.anchor.x;
            hat.anchor.y = pet.anchor.y;
            // move the sprite t the center of the screen
            hat.position.x = pet.position.x;
            hat.position.y = pet.position.y;

            container_ary[focus_int].addChild(hat);
            return "set hat";
        }


        function animate(timestamp, focus){
            renderer.render(focus);
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, focus);
            } );
        }

        function findEmptySlot(){
            //find empty slot in inventory
            var inventory = $('#inventory').children('.inv-row').children('div');
            var empty_slot = null;
            inventory.each(function(){
                //for each row, check cell if it is empty. return it immediatly because it is the first.

                if($(this).children('img').hasClass('empty-slot')){
                    empty_slot = $(this);
                    return false;
                }
                //return $(this);
            });
            return empty_slot;
        }

        $("#clean").on("click", function() {
            cancelAnimationFrame(globalID);
            cleanContainer();
            $("#testCanv").children().each(function(){
                //this is wrong now, should find highest empty table cell and populate it with the img
                var empty_slot = findEmptySlot();
                //if empty cell is null, skip this because inv is full
                //instead cancel the clean operation because we dont want player to lose items
                if(empty_slot == null){
                    //exit clean,
                    return false;
                }
                //$('#inventory').append(" <img id='"+this.id+"' src='"+this.src+"' draggable='true' ondragstart='drag(event)' class='"+this.classList+"' width='50' height='50' > ");
                //clean the empty slot, it still holds blank 50x50
                empty_slot.empty();

                //append the img again
                empty_slot.append("<img id='"+ this.id + "' src='" + this.src +
                    "' draggable='true' ondragstart='drag(event)' class='" + this.classList +
                    "' width='50' height='50'>");
                //here is where we remove the specific item, dont use empty at end can cause item loss
            });
            $("#testCanv").empty();

            //refresh empty pet img
            var results = $.getValues("get-pet.php", "POST", "user_id=1");

            var pet = setPet(container_ary[focus_int],  "../"+results.pet_list[focus_int].base);

            //here should be a db call to set pet to clean
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        $("#save").on("click", function() {
            //get pet id for the pet in focus, for now we set a hard coded value 1
            var obj_str = "pet_id=" + '1';
            var pet_inv = {
                "hat":0,
                "top":0,
                "bottom":0
            };
            $('#testCanv').children().each(function(){
                //this should be updated to check from the js array instrad of html dom.
                // html dom can be edited and since there isnt a global item list
                // we cant 100% confirma a user has a certain item if they edit in a value

                //for now we use html dom object for information
                switch( $(this).attr('class').split(' ')[0] ){
                    case "Hat":
                        pet_inv.hat =  $(this).attr('id').split('_')[0];
                        break;
                    case "Top":
                        pet_inv.top =  $(this).attr('id').split('_')[0];
                        break;
                    case "Bottom":
                        pet_inv.bottom =  $(this).attr('id').split('_')[0];
                        break;
                }


            });

            var inv_ary = [];
            $('#inventory').children('.inv-row').each( function(){
                $(this).children().children('img').each(function(){
                    if($(this).attr('class') == "empty-slot"){
                        inv_ary.push('0');
                    }else{
                        inv_ary.push( $(this).attr('id').split('_')[0] );
                    }

                });
            });

            var inv_json = {
                "command": "update_both",
                "user_id": <?php echo $_SESSION['curr_id']; ?>,
                "inv" : inv_ary,
                "pet_id": 1,
                "pet_inv": pet_inv
            };

            xhttp.open("POST", "save-pet-inv.php", true);
            xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                    console.log(xhttp.responseText);
                }
            }
            xhttp.setRequestHeader("Content-type", "application/json");
            xhttp.send(JSON.stringify(inv_json));
        });



        function setUpEquips(pet){
            console.log(pet_inv_ary[focus_int]);
            //make sure equipment is displayed, pulls from canvas children
            $("#testCanv").children().each(function(){
                setEquip(pet, this.src);
            });
        }

        function fillBlankInv(){
            //we need to put a blank inv img in the div that just removed an item
            //this lets the user graphically know the slot is empty
            $('.make-empty').append("<img width='50' height='50' class='empty-slot'>");
            $('.make-empty').attr('class', '');
        }

        //pet selection button functions, simply change the pet in focus
        $('#pet0-btn').on('click',function(){
            cancelAnimationFrame(globalID);
            focus_int = 0;
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        $('#pet1-btn').on('click',function(){
            cancelAnimationFrame(globalID);
            focus_int = 1;
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        $('#pet2-btn').on('click',function(){
            cancelAnimationFrame(globalID);
            focus_int = 2;
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        $('#pet3-btn').on('click',function(){
            cancelAnimationFrame(globalID);
            focus_int = 3;
            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        // DRAG FUNCTIONS

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
            ev.target.parentNode.setAttribute('class', 'make-empty');
        }

        function drop(ev, t) {
            cancelAnimationFrame(globalID);
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
            console.log(document.getElementById(data));
            var new_item_type = t.lastChild.classList[0];
            var all_item = t.getElementsByClassName(new_item_type);
            if(all_item.length > 1){
                //console.log(all_item[0].outerHTML);
                var item_remove = all_item[0];
                var empty_slot = findEmptySlot();
                //if empty cell is null, skip this because inv is full
                //instead cancel the clean operation because we dont want player to lose items
                if(empty_slot == null){
                    //exit clean,
                    return false;
                }
                //$('#inventory').append(" <img id='"+this.id+"' src='"+this.src+"' draggable='true' ondragstart='drag(event)' class='"+this.classList+"' width='50' height='50' > ");
                //clean the empty slot, it still holds blank 50x50
                empty_slot.empty();

                //append the img again
                empty_slot.append(item_remove.outerHTML);

                t.removeChild(item_remove);
            }

            pet_inv_ary[focus_int].hat;

            var results = $.getValues("get-pet.php", "POST", "user_id=1");

            var pet = setPet(container_ary[focus_int],  "../"+results.pet_list[focus_int].base);

            setUpEquips(pet);
            fillBlankInv();

            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }


    </script>
</body>
</html>
