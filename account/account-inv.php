<?php session_start();
?>
<!doctype html>
<html>
<head>
    <title>test</title>

</head>
<body onload="onInit();">
    <?php include('../library/nav-bar.html'); ?>
    <button id="clean">clean</button>
    <!-- store the pet default type somewhere, maybe a div? seems hacky -->
    <div id="drop-target" ondrop="drop(event)" ondragover="allowDrop(event)" style="height:400px; width:400px; position: absolute;">
        <canvas id="testCanv" height="400" width="400"></canvas>
    </div>
    <!-- we want db call to get total number of pets. this should output some button array to choose which is visable-->
    <div id="pet-list">
        <!-- if the pet does not exist, then we output a disabled button-->
    </div>
    <div id="inventory" style="float: right;">
        <!-- do db call here for avilible items, also set a value to know what kind of item it is -->
        <?php include('get-inv.php'); ?>
    </div>

    <script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script type="text/javascript">

        var globalID, canvas, renderer;
        var container0, container1, container2, container3;
        function onInit(){
            // create an new instance of a pixi stage
            container0 = new PIXI.Container(0x66FF99);
            container1 = new PIXI.Container(0x66FF99);
            container2 = new PIXI.Container(0x66FF99);
            container4 = new PIXI.Container(0x66FF99);

            canvas = document.getElementById("testCanv");
            // create a renderer instance.
            renderer = PIXI.autoDetectRenderer(400, 400, {view:document.getElementById("testCanv")});

            // add the renderer view element to the DOM
            //document.body.appendChild(renderer.view);
            setBG(container0);

            //should have db call for the pet type, do it in html
            setBunny(container0);
            globalID = requestAnimationFrame( animate );
        }


        function cleanContainer(){
            for (var i = container0.children.length -1; i >=0  ; i--) {
                container0.removeChildAt(i);
            };
            setBG(container0);
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
            bg.position.x = 200;
            bg.position.y = 200;
            container.addChild(bg);
            return bg;
        }

        function setBunny(container){
            // create a texture from an image path
            var texture = PIXI.Texture.fromImage("../resources/images/bunny_trans.gif");
            // create a new Sprite using the texture
            var bunny = new PIXI.Sprite(texture);

            // center the sprites anchor point
            bunny.anchor.x = 0.5;
            bunny.anchor.y = 0.5;
            // move the sprite t the center of the screen

            var c = $('#testCanv').get(0);
            c.getContext('2d');
            bunny.position.x = c.width / 2;
            bunny.position.y = c.height / 2;
            container.addChild(bunny);
            return bunny;
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

            container0.addChild(hat);
            return "set hat";
        }


        function animate(){
            renderer.render(container0);
            globalID = requestAnimationFrame( animate );
        }

        function findEmptySlot(){
            //find empty slot in inventory
            var inventory = $('#inventory').children('.inv-row');
            inventory.each(function(){
                var emptyCell
                //for each row, check cell if it is empty. return it immediatly because it is the first.
                return emptyCell;
            });
            return null;
        }

        $("#clean").on("click", function() {
            cancelAnimationFrame(globalID);
            cleanContainer();
            $("#testCanv").children().each(function(){
                //this is wrong now, should find highest empty table cell and populate it with the img
                var empty_slot = findEmptySlot();
                //if empty cell is null, skip this because inv is full
                $('#inventory').append(" <img id='"+this.id+"' src='"+this.src+"' draggable='true' ondragstart='drag(event)' class='"+this.classList+"' width='50' height='50' > ");
            });
            $("#testCanv").empty();
            var pet = setBunny(container0);

            //here should be a db call to set pet to clean
            globalID = requestAnimationFrame( animate );
        });

        function setUpEquips(pet){

            //make sure equipment is displayed, pulls from canvas children
            $("#testCanv").children().each(function(){
                setEquip(pet, this.src);
            });
        }

        // DRAG FUNCTIONS

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            cancelAnimationFrame(globalID);
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
            var pet = setBunny(container0);
            setUpEquips(pet);
            globalID = requestAnimationFrame( animate );
        }

        function allowDrop(ev) {
            ev.preventDefault();
        }
    </script>
</body>
</html>
