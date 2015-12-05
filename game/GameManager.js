var game = new Phaser.Game(840, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update }, false, false);

//TODO: get actual curPetID
var curPetID = 1;

var grid;
var playerLeft;
var playerRight;
var gameOver;
var enemyPlayerID = 0;
var enemyPetID = 1;

var ConnData = {
	Null: "Null",
    Weapon : "Weapon",
    Move : "Move",
    TakeDamage : "TakeDamage",
	InitializeConnection : "InitializeConnection"
}

function recievedDataFromPeer(data) {
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
		destroyProjectile(data["index"])
	}
	else if(data["type"] == ConnData.InitializeConnection)
	{
		console.log(data);
		enemyPlayerID = data["playerID"];
		enemyPetID = data["petID"];
		populateItems(playerRight, enemyPlayerID, enemyPetID);
	}
	else if(data["type"] == ConnData.InitializeConnection)
	{
		console.log("=======================================================");
		console.log(data);
		console.log("=======================================================");
		enemyPlayerID = data[playerID];
		enemyPetID = data[petID];
	}
};

//TODO:
//Well, we have to create a peer name, probably should keep it as the PlayerID
var peerName = curPlayerID;
var peer = new Peer(peerName, {key: 'lwjd5qra8257b9'});
var conn;

function populateItems(player, playerID, petID)
{
	console.log(player + ", " + playerID + ", " + petID);
	
	var itemRequest = new XMLHttpRequest();
	itemRequest.onreadystatechange = function() 
	{
		if (itemRequest.readyState == 4 && itemRequest.status == 200) 
		{
			console.log(itemRequest.responseText);
			console.log("PlayerID:" + playerID);
			var petData = JSON.parse(itemRequest.responseText);
			if(petData.hat_img != "None")
			{
				//player.gameObject.addChild(game.make.sprite(0,0, recData.hat_img));
				if(player.type == TileType.Red)
				{
					var sprite = game.make.sprite(60,-8,'blue-head');
					sprite.scale.x = -1;
				}
				else
				{
					var sprite = game.make.sprite(-57,-7,'blue-head');
				}
				player.gameObject.addChild(sprite);
			}
			if(petData.top_img != "None")
			{
				//player.gameObject.addChild(game.make.sprite(0,0, recData.top_img));
				if(player.type == TileType.Red)
				{
					var sprite = game.make.sprite(35,-9,'blue-wheel');
					sprite.scale.x = -1;
				}
				else
				{
					var sprite = game.make.sprite(-33,-9,'blue-wheel');
				}
				player.gameObject.addChild(sprite);
			}
			if(petData.bottom_img != "None")
			{
				player.gameObject.addChild(game.make.sprite(0,0, petData.bottom_img));
			}
		}	
	};	
	itemRequest.open("GET", "../library/getPetStats.php?user_id=" + playerID +"&pet_id=" + petID, true);
	itemRequest.send();
}


function preload() 
{
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
	game.load.image('blue-head', 'assets/blue-head.png');
	game.load.image('blue-wheel', 'assets/blue-wheel.png');
	this.game.stage.scale.pageAlignHorizontally = true;
	this.game.stage.scale.pageAlignVeritcally = true;
}

function reset() 
{	
	if(gameOver)
	{
		playerLeft.reset();
		playerRight.reset();
	}
	
	var weaponsLeft = [];
	weaponsLeft[0] = new Weapon(10, 1000, 250, TileType.Red);
	weaponsLeft[1] = new Weapon(20, 500, 1000, TileType.Red);
	var weaponsRight = [];
	weaponsRight[0] = new Weapon(10, 1000, 250, TileType.Blue);
	weaponsRight[1] = new Weapon(20, 500, 1000, TileType.Blue);
    playerLeft = new Player(0,1, 'gatorLeft', weaponsLeft);
	populateItems(playerLeft, curPlayerID, curPetID);
	playerRight = new Player(5, 1, 'gatorRight', weaponsRight);
	projectileGroup = game.add.group();
	projectileGroup.enableBody = true;
	projectileGroup.allowGravity = false;
	healthLeft = new Bar(50, 50, 300, 20, 0xff0000);
	healthRight = new Bar(450, 50, 300, 20, 0x0000ff);
	
	gameOver = false;
}

function create() {
	game.stage.disableVisibilityChange = true;
	gameOver = false;

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
	populateItems(playerLeft, curPlayerID, curPetID);
	playerRight = new Player(4, 1, 'gatorRight', weaponsRight);
	projectileGroup = game.add.group();
	projectileGroup.enableBody = true;
	projectileGroup.allowGravity = false;
	healthLeft = new Bar(50, 50, 300, 20, 0xff0000);
	healthRight = new Bar(450, 50, 300, 20, 0x0000ff);
	
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (xhttp.readyState == 4 && xhttp.status == 200) 
		{
			var recData = JSON.parse(xhttp.responseText);
			console.log(recData);
			//Assume we are given a JSON Object of format:
			//Peer connection type: (0 == Host, 1 == Client),
			//Peer ID
			
			//If the player has been promoted to a host,
			if(recData.connType == 0)
			{
				peer.on('connection', function(con) {
					conn = con;
					console.log("P2 Connected");
					conn.on('open',function() {
						conn.on('data', function(data) {
							recievedDataFromPeer(data);
						});
					});
				});
			}
			//Else, connect as the client
			else
			{
				conn = peer.connect(recData.peerID);
				conn.on('open',function() {
					var connectionPacket = {};
					console.log("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
					connectionPacket["playerID"] = curPlayerID;
					//TODO: make this the actual petID
					connectionPacket["petID"] = curPetID;
					connectionPacket["type"] = ConnData.InitializeConnection;
					conn.send(connectionPacket);
					console.log("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
					enemyPlayerID = recData["playerID"];
					enemyPetID = recData["petID"];
					populateItems(playerRight, enemyPlayerID, enemyPetID);
					conn.on('data', function(data) {
						recievedDataFromPeer(data);
					});
				});
			}
		}
	};
	//TODO: Make a post call to php to query the database, giving it our PeerID
	xhttp.open("GET", "matchmaking.php?playerID="+curPlayerID+"&petID=1&peerID="+curPlayerID, true);
	xhttp.send();
}

function update() {
	
	//conn.send('hi!');
	playerLeft.update();
	playerRight.update();
	
	grid.tileUpdate();
	if(gameOver)
	{
		playerLeft.disableInput();
	}
	
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
					conn.send({type: ConnData.TakeDamage, damage: projectiles[i].damage, index: i});
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
