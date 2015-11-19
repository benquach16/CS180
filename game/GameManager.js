var game = new Phaser.Game(840, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update }, false, false);

var grid;
var playerLeft;
var playerRight;
var input;

var ConnData = {
	Null: "Null",
    Weapon : "Weapon",
    Move : "Move",
    TakeDamage : "TakeDamage"
}

function recData(data) {
	console.log(data);
	//(string)type, (Projectile)projectile
	//console.log(data.type +", " + data["type"]);
	if(data.type == ConnData.Weapon)
	{
		console.log("Here");
		var enemyWeapon = new Weapon(data.damage, data.speed, data.fireRate, TileType.Blue);
		enemyWeapon.shoot(playerRight.gridPos.x, playerRight.gridPos.y);
	}
	//(ConnData)type, (int)x, (int)y
	else if(data["type"] == ConnData.Move)
	{
		playerRight.nextPos.x = 5 - data["x"];
		playerRight.nextPos.y = data["y"];
		playerRight.moveTimer = playerRight.moveDuration;
		console.log(playerRight.nextPos.x + ", " + playerRight.nextPos.y);
	}
	//(string)type, (int)damage
	else if(data["type"] == ConnData.TakeDamage)
	{
		//In case race conditions happen, force player to not be immune
		playerRight.immuneTimer = 0;
		playerRight.takeDamage(data["damage"]);
		healthRight.update(playerRight.health, playerRight.fullHealth);
	}
};
	
var peerName = "Reciever";
var peer = new Peer(peerName, {key: 'lwjd5qra8257b9'});
var conn;
if(peerName == "Sender") {
    conn = peer.connect("Reciever");
    conn.on('open',function() {
        conn.on('data', function(data) {
            recData(data);
        });
    });
} else {
    peer.on('connection', function(con) {
		conn = con;
		console.log("P2 Connected");
        conn.on('open',function() {
            conn.on('data', function(data) {
                recData(data);
            });
        });
    });
}




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
    playerLeft = new Player(1,1, 'gatorLeft', weaponsLeft);
	playerRight = new Player(4, 1, 'gatorRight', weaponsRight);
	projectileGroup = game.add.group();
	projectileGroup.enableBody = true;
	projectileGroup.allowGravity = false;
	healthLeft = new Bar(50, 50, 300, 20, 0xff0000);
	healthRight = new Bar(450, 50, 300, 20, 0x0000ff);
}

function update() {
	
	//conn.send('hi!');
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
			/*else if(damagePositions[j].x == playerRight.gridPos.x && damagePositions[j].y == playerRight.gridPos.y && projectiles[i].bulletFrom != TileType.Blue)
			{
				if(playerRight.takeDamage(projectiles[i].damage))
				{
					conn.send({type: "TakeDamage", damage: projectiles[i].damage});
					healthRight.update(playerRight.health, playerRight.fullHealth);
					projectileHit = true;
				}
			}*/
		}
		if(projectileHit)
		{
			destroyProjectile(i);
			i--;
		}
	}
}
