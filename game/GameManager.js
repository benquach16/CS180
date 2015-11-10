var game = new Phaser.Game(840, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update }, false, false);

var grid;
var playerLeft;
var playerRight;
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
	game.load.image('gatorLeft', 'assets/gatorIdleLeft.png');
	game.load.image('gatorRight', 'assets/gatorIdleRight.png');
	game.load.image('gatorDamagedLeft', 'assets/gatorDamagedLeft.png');
	game.load.image('gatorDamagedRight', 'assets/gatorDamagedRight.png');
	game.load.image('blastLeft', 'assets/blastLeft.png');
	game.load.image('blastRight', 'assets/blastRight.png');
	game.load.image('blueTile', 'assets/blueTile.png');
	game.load.image('redTile', 'assets/redTile.png');
	game.load.image('yellowTile', 'assets/yellowTile.png');
	game.load.spritesheet('background', 'assets/background.png', 256, 256);
	
	
	//get json from database
	/*game.load.onFileComplete.add(function(key) {
    if (key === 'data') {
      var data = game.cache.getJSON(key);
      // data is now populated with the contents of the JSON file
    }
  }, this);

  game.load.json('data', 'assets/data.json');*/
  
}

function create() {

	grid = new Grid(70, 450, 800, 600, 6, 3);
	
	input = new inputHandler();

    //  We're going to be using physics, so enable the Arcade Physics system
    game.physics.startSystem(Phaser.Physics.ARCADE);

    //  A simple background for our game
	var background = game.add.sprite(0, 0, 'background');
	
	background.scale.setTo(3.35,2.34);
	
	background.animations.add('loop');
	background.animations.play('loop', 2, true);
	
	grid.createGrid();
	
	var weaponsLeft = [];
	weaponsLeft[0] = new Weapon(10, 1000, 250, TileType.Red);
	weaponsLeft[1] = new Weapon(20, 500, 1000, TileType.Red);
	var weaponsRight = [];
	weaponsRight[0] = new Weapon(10, 1000, 250, TileType.Blue);
	weaponsRight[1] = new Weapon(20, 500, 1000, TileType.Blue);
    playerLeft = new Player(0,0, 'gatorLeft', weaponsLeft);
	playerRight = new Player(4, 0, 'gatorRight', weaponsRight);
	projectileGroup = game.add.group();
	projectileGroup.enableBody = true;
	projectileGroup.allowGravity = false;
	healthLeft = new Bar(50, 50, 300, 20, 0xff0000);
	healthRight = new Bar(450, 50, 300, 20, 0x0000ff);
}

function update() {
	
	playerLeft.update();
	playerRight.update();
	grid.tileUpdate();
	for(var i = 0; i < projectiles.length; i++)
	{
		if(projectiles[i].isFinished(i)){continue;}
		else{projectiles[i].updateGridPos();}
		
		var damagePositions = projectiles[i].updateDamagePositions();
		var projectileHit = false;
		for(var j = 0; j < damagePositions.length; j++)
		{
			grid.at(damagePositions[j].x,damagePositions[j].y).gameObject.loadTexture('yellowTile');
			if(damagePositions[j].x == playerLeft.gridPos.x && damagePositions[j].y == playerLeft.gridPos.y && projectiles[i].bulletFrom != TileType.Red)
			{
				if(playerLeft.takeDamage(projectiles[i].damage))
				{
					healthLeft.update(playerLeft.health, playerLeft.fullHealth);
					projectileHit = true;
				}
			}
			else if(damagePositions[j].x == playerRight.gridPos.x && damagePositions[j].y == playerRight.gridPos.y && projectiles[i].bulletFrom != TileType.Blue)
			{
				if(playerRight.takeDamage(projectiles[i].damage))
				{
					healthRight.update(playerRight.health, playerRight.fullHealth);
					projectileHit = true;
				}
			}
		}
		if(projectileHit)
		{
			destroyProjectile(i);
			i--;
		}
	}
}
