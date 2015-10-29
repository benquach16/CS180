var game = new Phaser.Game(800, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update });

var grid;
var playerLeft;
var input;

function inputHandler()
{
	this.gridPosX = 0;
	this.gridPosY = 0;
	this.pressedL = false;
	this.pressedR = false;
	this.pressedD = false;
	this.pressedU = false;
};

function preload() {

    game.load.image('stage', 'assets/battleStage.png');
	game.load.image('gatorLeft', 'assets/gatorLeft.png');
	game.load.image('gatorRight', 'assets/gatorRight.png');
	game.load.spritesheet('background', 'assets/background.png', 256, 256);

}

function create() {

	grid = new Grid(70, 450, 800, 600, 6, 3);
	grid.createGrid();
	
	input = new inputHandler();

    //  We're going to be using physics, so enable the Arcade Physics system
    game.physics.startSystem(Phaser.Physics.ARCADE);

    //  A simple background for our game
	var background = game.add.sprite(0, 0, 'background');
	projectiles = game.add.group();
	projectiles.enableBody = true;
	projectiles.allowGravity = false;
	
	background.scale.setTo(3.125,2.34);
	
	background.animations.add('loop');
	background.animations.play('loop', 2, true);
	
    var stage = game.add.sprite(0, 368, 'stage');

    //  Scale it to fit the width of the game (the original sprite is 400x32 in size)
    stage.scale.setTo(3.35, 3);
	
    // The player and its settings
    playerLeft = new Player(0,0, 'gatorLeft');
	
}

function update() {

    //  Checks to see if the player overlaps with any of the stars, if he does call the collectStar function
    //game.physics.arcade.overlap(player, stars, collectStar, null, this);
	
	playerLeft.update();
	
	//controllerHandler();
}
