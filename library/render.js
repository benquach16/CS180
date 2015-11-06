// in order to use these rendering functions, include this script to include pixi
// <script src="https://www.rootcdn.com/libs/pixi.js/3.0.7/pixi.min.js" ></script>

//add a pet img and have the pet get returned
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

//add an equip img to an existing pet
function setEquip(pet, img, container){

    // create a texture from an image path
    var texture = PIXI.Texture.fromImage(img);
    // create a new Sprite using the texture
    var equip = new PIXI.Sprite(texture);

    // center the sprites anchor point
    equip.anchor.x = pet.anchor.x;
    equip.anchor.y = pet.anchor.y;
    // move the sprite t the center of the screen
    equip.position.x = pet.position.x;
    equip.position.y = pet.position.y;

    container.addChild(equip);
    return;
}

//generic add img. doesnt return anything. needs canvas in order to center the img
//will add functionality to renderobject at specific locations
function addImg(img, con, canvas){
    var texture = PIXI.Texture.fromImage("../"+ img);
    // create a new Sprite using the texture
    var img = new PIXI.Sprite(texture);

    // center the sprites anchor point
    img.anchor.x = 0.5;
    img.anchor.y = 0.5;
    // move the sprite t the center of the screen
    img.position.x = canvas.width / 2;
    img.position.y = canvas.height / 2;
    con.addChild(img);
}


