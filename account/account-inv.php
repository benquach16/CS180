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
        <div id="row1" class="inv-row"></div>
        <div id="row2" class="inv-row"></div>
        <div id="row3" class="inv-row"></div>
        <div id="row4" class="inv-row"></div>
    </div>

    <script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript">

        var pets_JSON;
        var globalID, canvas, renderer;
        var container_ary = [];
        var pet_inv_ary = [];

        var focus_int;

        var screen_w = 200;
        var screen_h = 200;

        function client_pet_inv(id, hat, top, bottom, base, hat_id, top_id, bottom_id){
            this.pet_id = id;
            this.pet_base = base;

            this.pet_hat = hat_id;
            this.hat_img = hat;

            this.pet_top = top_id;
            this.top_img = top;

            this.pet_bottom = bottom_id;
            this.bottom_img = bottom;
        }

        function client_user_inv(json){
            this.item_ary = [];
            for(var i = 0; i < json.user_inv.length; i++){
                this.item_ary.push(json.user_inv[i]);
            }
        }

        var user_inv;

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
                        //console.log(data);
                    },
                    error: function(xhr){
                        //alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                        //console.log(xhr.responseText);
                        result = jQuery.parseJSON(xhr.responseText);
                    },
                });
                return result;
            }
        });

        function populateUserInv(){
            var test = $.getValues("get-inv.php", "GET", "user_id=<?php echo $_SESSION['curr_id']; ?>", 'application/x-www-form-urlencoded');

            user_inv = new client_user_inv(test);
        }

        function displayUserInv(){
            //get div for display
            var inv_div = $('#inventory');

            for(var i = 1; i <= 4; i++ ){
                for(var j = 0; j < 7; j++){

                    if(user_inv.item_ary[((i - 1)*7) + j] == undefined){
                        //console.log('not exist');
                        var apd_val = "<div id="+i+'_'+j+" class='empty'><img width='50' height='50' class='empty-slot'></div>";

                        $('#row'+i).append(apd_val);
                    } else {
                        var apd_val = "<div id="+i+'_'+j+" ondragover='allowDrop(event)' ondrop='drop_empty(event, this)' ><img id=item"+i+'_'+j+
                            " draggable='true' ondragstart='drag(event)' ondragend='dragend(event)' src="+
                            user_inv.item_ary[((i - 1)*7) + j].img+ " value="+user_inv.item_ary[((i - 1)*7) + j].item_id+" type="+
                            user_inv.item_ary[((i - 1)*7) + j].type+" name='"+
                            user_inv.item_ary[((i - 1)*7) + j].name +"' height='50' width='50'></div>";
                        if(user_inv.item_ary[((i - 1)*7) + j].type == "Empty"){
                            apd_val = "<div id="+i+'_'+j+" class='empty' ondragover='allowDrop(event)' ondrop='drop_empty(event, this)'><img width='50' height='50' class='empty-slot'></div>";
                        }

                        $('#row'+i).append(apd_val);
                    }
                }
            }
        }

        function onInit(){

            // create an new instance of a pixi stage
            for(var i = 0; i < 4; i++){
                container_ary.push( new PIXI.Container(0x66FF99) );
            }

            //get the user inv
            populateUserInv();
            displayUserInv();

            //here use php to get the equip of a pet and populate pet_inv

            focus_int = 0;

            canvas = document.getElementById("testCanv");
            // create a renderer instance.
            renderer = PIXI.autoDetectRenderer(screen_w, screen_h, {view:document.getElementById("testCanv")});

            // add the renderer view element to the DOM
            //document.body.appendChild(renderer.view);
            initAllPets();



            setAllPets();

            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        }

        function initAllPets(){
            pets_JSON = $.getValues("get-pet.php", "GET", "user_id=<?php echo $_SESSION['curr_id']; ?>", 'application/x-www-form-urlencoded').pet_list;

            pet_inv_ary.push (new client_pet_inv(pets_JSON[0].id, pets_JSON[0].hat_img, pets_JSON[0].top_img, pets_JSON[0].bottom_img, pets_JSON[0].base,
                pets_JSON[0].hat_id, pets_JSON[0].top_id, pets_JSON[0].bottom_id));
            pet_inv_ary.push (new client_pet_inv(pets_JSON[1].id, pets_JSON[1].hat_img, pets_JSON[1].top_img, pets_JSON[1].bottom_img, pets_JSON[1].base,
                pets_JSON[1].hat_id, pets_JSON[1].top_id, pets_JSON[1].bottom_id));
            pet_inv_ary.push (new client_pet_inv(pets_JSON[2].id, pets_JSON[2].hat_img, pets_JSON[2].top_img, pets_JSON[2].bottom_img, pets_JSON[2].base,
                pets_JSON[2].hat_id, pets_JSON[2].top_id, pets_JSON[2].bottom_id));
            pet_inv_ary.push (new client_pet_inv(pets_JSON[3].id, pets_JSON[3].hat_img, pets_JSON[3].top_img, pets_JSON[3].bottom_img, pets_JSON[3].base,
                pets_JSON[3].hat_id, pets_JSON[3].top_id, pets_JSON[3].bottom_id));
        }

        function setAllPets(){
            for(var i = 0; i < pet_inv_ary.length; i++){
                setBG(container_ary[i]);
            }

            var pet0 = setPet(container_ary[0], '../' + pet_inv_ary[0].pet_base);
            var pet1 = setPet(container_ary[1], '../' + pet_inv_ary[1].pet_base);
            var pet2 = setPet(container_ary[2], '../' + pet_inv_ary[2].pet_base);
            var pet3 = setPet(container_ary[3], '../' + pet_inv_ary[3].pet_base);

            setUpEquips(pet0, 0);
            setUpEquips(pet1, 1);
            setUpEquips(pet2, 2);
            setUpEquips(pet3, 3);

        }

        function cleanContainer(c){
            for (var i = c.children.length -1; i >=0  ; i--) {
                c.removeChildAt(i);
            };
            setBG(c);
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

        function setEquip(pet, img, index){

            index = typeof index !== 'undefined' ? index : focus_int;

            // create a texture from an image path
            var texture2 = PIXI.Texture.fromImage("../"+img);
            // create a new Sprite using the texture
            var hat = new PIXI.Sprite(texture2);

            // center the sprites anchor point
            hat.anchor.x = pet.anchor.x;
            hat.anchor.y = pet.anchor.y;
            // move the sprite t the center of the screen
            hat.position.x = pet.position.x;
            hat.position.y = pet.position.y;

            container_ary[index].addChild(hat);
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

        function getRemoveAry(inv){
            var return_ary = [];
            console.log(inv);
            if (inv.pet_hat != 0){
                var rItem = {
                    "type" : "Hat",
                    "item_id" : inv.pet_hat,
                    "img" : inv.hat_img,
                    "name" : "placeholder"
                }
                return_ary.push(rItem);
            }
            if (inv.pet_top != 0){
                var rItem = {
                    "type" : "Top",
                    "item_id" : inv.pet_top,
                    "img" : inv.top_img,
                    "name" : "placeholder"
                }
                return_ary.push(rItem);
            }
            if (inv.pet_bottom != 0){
                var rItem = {
                    "type" : "Bottom",
                    "item_id" : inv.pet_bottom,
                    "img" : inv.bottom_img,
                    "name" : "placeholder"
                }
                return_ary.push(rItem);
            }

            return return_ary;
        }

        function getAllEmpty(){
            var empty_ary = [];

            $('#inventory').children().each(function(i){
                $(this).children().each(function(j){
                    if($(this).children('img').hasClass('empty-slot')){
                        var slot_id = {
                            "row" : i+1,
                            "slot" : j
                        };
                        empty_ary.push(slot_id);
                    }
                });
            });

            return empty_ary;
        }

        function removeFromPet(type, index){
            index = typeof index !== 'undefined' ? index : focus_int;
            switch(type){
                case "Hat":
                    pet_inv_ary[index].hat_img = undefined;
                    pet_inv_ary[index].pet_hat = '0';
                    break;
                case "Top":
                    pet_inv_ary[index].top_img = undefined;
                    pet_inv_ary[index].pet_top = '0';
                    break;
                case "Bottom":
                    pet_inv_ary[index].bottom_img = undefined;
                    pet_inv_ary[index].pet_bottom = '0';
                    break;
                default:
                    alert("item type does not exist???");
                    break;
            }
        }

        $("#clean").on("click", function() {
            cancelAnimationFrame(globalID);

            //create ary of items to be removed
            var remove_ary = getRemoveAry(pet_inv_ary[focus_int]);

            var empty_slot_ary = getAllEmpty();

            //check if there are enough empty slots in inv
            if(empty_slot_ary.length <= remove_ary.length){
                alert("Not enough inventory slots!");
                globalID = requestAnimationFrame( function(timestamp){
                    animate(timestamp, container_ary[focus_int]);
                } );
                return;
            } else {
                //here is where we place obj in the inv
                //console.log(user_inv.item_ary);
                //console.log(remove_ary[0]);
                for(var i = 0; i < remove_ary.length; i++){
                    var slot = empty_slot_ary.shift();
                    var new_img = "<img id=item"+slot.row+'_'+slot.slot+
                        " draggable='true' ondragstart='drag(event)' ondragend='dragend(event)' src="+
                        remove_ary[i].img+ " value="+remove_ary[i].item_id+" type="+
                        remove_ary[i].type+" name='"+
                        remove_ary[i].name +"' height='50' width='50'>";
                    var target = $('#' + slot.row + '_' + slot.slot);
                    target.empty();
                    target.append(new_img);
                    removeFromPet(remove_ary[i].type);
                    user_inv.item_ary[((slot.row - 1)*7) + slot.slot] = remove_ary[i];
                }
                var pet = setPet(container_ary[focus_int],  "../"+pet_inv_ary[focus_int].pet_base);

                setUpEquips(pet);
            }

            globalID = requestAnimationFrame( function(timestamp){
                animate(timestamp, container_ary[focus_int]);
            } );
        });

        $("#save").on("click", function() {

            user_inv.user_id = <?php echo $_SESSION['curr_id']; ?> ;
            $.getValues("get-inv.php", "POST", JSON.stringify(user_inv), 'application/json');
            $.getValues("get-pet.php", "POST", JSON.stringify(pet_inv_ary[focus_int]), 'application/json');
        });



        function setUpEquips(pet, index){

            index = typeof index !== 'undefined' ? index : focus_int;

            if(pet_inv_ary[index].pet_hat != "0" ){
                setEquip(pet, pet_inv_ary[index].hat_img, index);
            }
            if(pet_inv_ary[index].pet_top != "0"){
                setEquip(pet, pet_inv_ary[index].top_img, index);
            }
            if(pet_inv_ary[index].pet_bottom != "0"){
                setEquip(pet, pet_inv_ary[index].bottom_img, index);
            }

            //make sure equipment is displayed, pulls from canvas children
        }

        function fillBlankInv(){
            //we need to put a blank inv img in the div that just removed an item
            //this lets the user graphically know the slot is empty
            $('.make-empty').append("<img width='50' height='50' class='empty-slot'>");
            $('.make-empty').attr('class', 'empty');
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

        function updateClientInv(){
            $('#inventory').children().each(function(i){
                $(this).children().each(function(j){
                    var item_slot = $(this).children('img');
                    var slot = user_inv.item_ary[((i)*7) + j];
                    //console.log(slot);

                    if((item_slot.attr('value') == undefined) && slot != undefined){
                        slot.item_id = 0 ;
                        slot.img = "" ;
                        slot.type = "Empty" ;
                        slot.name = "" ;
                    } else if(slot != undefined) {
                        slot.item_id = item_slot.attr('value') ;
                        slot.img = item_slot.attr('src') ;
                        slot.type = item_slot.attr('type') ;
                        slot.name = item_slot.attr('name') ;
                    }
                });
            });
        }

        // DRAG FUNCTIONS

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
            ev.target.parentNode.setAttribute('class', 'make-empty');
        }

        function dragend(ev){
            if(event.dataTransfer.dropEffect == 'none'){
                $('.make-empty').removeAttr('class');
            }
        }

        function drop_empty(ev, t){
            ev.preventDefault();
            $(t).removeAttr('class');
            $(t).empty();
            var data = ev.dataTransfer.getData("text");
            var dragged = document.getElementById(data);
            t.appendChild(dragged);
            //console.log(ev.target);
            updateClientInv();
            fillBlankInv();
        }

        function drop(ev, t) {
            cancelAnimationFrame(globalID);
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            var dragged = document.getElementById(data);
            ev.target.appendChild(dragged);

            //change value of item
            var new_img = document.createElement("IMG");
            new_img.setAttribute('draggable' , true);
            new_img.setAttribute('ondragstart', "drag(event)");
            new_img.setAttribute('ondragend', "dragend(event)");
            new_img.setAttribute('height', 50);
            new_img.setAttribute('width', 50);

            if(document.getElementById(data).getAttribute('type') == "Hat"){
                if(pet_inv_ary[focus_int].pet_hat != 0){
                    var empty_div = document.getElementsByClassName('empty')[0];

                    new_img.setAttribute('id', "item"+empty_div.id);
                    new_img.setAttribute('src', pet_inv_ary[focus_int].hat_img);
                    new_img.setAttribute('value', pet_inv_ary[focus_int].pet_hat);
                    new_img.setAttribute('type', "Hat");

                    $(empty_div).empty();
                    empty_div.appendChild(new_img);
                    empty_div.removeAttribute('class');
                }
                pet_inv_ary[ focus_int].pet_hat = document.getElementById(data).getAttribute('value');
                pet_inv_ary[focus_int].hat_img = document.getElementById(data).getAttribute('src');
            }
            if(document.getElementById(data).getAttribute('type') == "Top"){
                if(pet_inv_ary[focus_int].pet_top != 0){
                    var empty_div = document.getElementsByClassName('empty')[0];

                    new_img.setAttribute('id', "item"+empty_div.id);
                    new_img.setAttribute('src', pet_inv_ary[focus_int].top_img);
                    new_img.setAttribute('value', pet_inv_ary[focus_int].pet_top);
                    new_img.setAttribute('type', "Top");

                    $(empty_div).empty();
                    empty_div.appendChild(new_img);
                    empty_div.removeAttribute('class');
                }
                pet_inv_ary[ focus_int].pet_top = document.getElementById(data).getAttribute('value');
                pet_inv_ary[focus_int].top_img = document.getElementById(data).getAttribute('src');
            }
            if(document.getElementById(data).getAttribute('type') == "Bottom"){
                if(pet_inv_ary[focus_int].pet_bottom != 0){
                    var empty_div = document.getElementsByClassName('empty')[0];

                    new_img.setAttribute('id', "item"+empty_div.id);
                    new_img.setAttribute('src', pet_inv_ary[focus_int].bottom_img);
                    new_img.setAttribute('value', pet_inv_ary[focus_int].pet_bottom);
                    new_img.setAttribute('type', "Bottom");

                    $(empty_div).empty();
                    empty_div.appendChild(new_img);
                    empty_div.removeAttribute('class');
                    console.log(empty_div);
                }
                pet_inv_ary[ focus_int].pet_bottom = document.getElementById(data).getAttribute('value');
                pet_inv_ary[focus_int].bottom_img = document.getElementById(data).getAttribute('src');
            }

            //now update the current inventory
            updateClientInv();
            cleanContainer(container_ary[focus_int]);

            //console.log(pet_inv_ary[focus_int]);
            var pet = setPet(container_ary[focus_int],  "../"+pet_inv_ary[focus_int].pet_base);

            setUpEquips(pet);
            fillBlankInv();

            $(t).empty();

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
