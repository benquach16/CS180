function Player(posX, posY, spriteName)
{
	this.weapon = [];
	this.fullHealth = 100;
	this.health = 100;
	this.armor = 0; 
	this.damage = 0;
	this.specialGauge = 0;
	this.deltaSpecial = 0;
	this.curSpecial = 0;
	this.energyGauge = 0;
	this.deltaEnergy = 0;
	this.curEnergy = 0;
	this.immuneTime = 0;
	
	this.standardScale = 2.5;
	this.newScale = this.standardScale*1.25;
	
	//Time is in milliseconds, so deltaMove and moveTime must be in milliseconds as well
	this.moveTime = 250;
	this.deltaMove = 0;
	this.nextPos = new Coords(posX, posY);
	this.gridPos = new Coords(posX, posY);
	
	this.gameObject = game.add.sprite(grid.at(posX, posY).x, grid.at(posX, posY).y, spriteName);
	this.gameObject.anchor.x = 0.5;
	this.gameObject.scale.setTo(this.standardScale, this.newScale);
	this.gameObject.anchor.y = (1-(this.standardScale/this.newScale));
	
	//Create the player's fade out mask
    this.mask = game.add.graphics(0, 0);
	this.mask.beginFill(0xffffff);
	for(var q = 0; q < 100; q+=1)
	{
		this.mask.drawRect(q,1,q+1,300);
	}
	
	this.mask.x = -9000;
	this.mask.y = -9000;
	
	//Make this webscale later. For now it's hardcoded.
	this.type = TileType.Red;
	
	if(spriteName == "gatorLeft")
	{
	game.input.keyboard.addKey(Phaser.Keyboard.A).onDown.add(moveLeft, this);
	game.input.keyboard.addKey(Phaser.Keyboard.D).onDown.add(moveRight, this);
	game.input.keyboard.addKey(Phaser.Keyboard.W).onDown.add(moveUp, this);
	game.input.keyboard.addKey(Phaser.Keyboard.S).onDown.add(moveDown, this);
	game.input.keyboard.addKey(Phaser.Keyboard.SHIFT).onDown.add(shootBullet, this);
	}
	
	else
	{
	this.type = TileType.Blue;
	game.input.keyboard.addKey(Phaser.Keyboard.J).onDown.add(moveLeft, this);
	game.input.keyboard.addKey(Phaser.Keyboard.L).onDown.add(moveRight, this);
	game.input.keyboard.addKey(Phaser.Keyboard.I).onDown.add(moveUp, this);
	game.input.keyboard.addKey(Phaser.Keyboard.K).onDown.add(moveDown, this);
	game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR).onDown.add(shootBullet, this);
	}
};

Player.prototype.takeDamage = function(dmg)
{
	if(this.immuneTime <= 0)
	{
		if(this.health <= 0)
		{
			return false;
		}
		if(this.type == "Red")
		{
			this.gameObject.loadTexture('gatorDamagedLeft');
		}
		else if(this.type == "Blue")
		{
			this.gameObject.loadTexture('gatorDamagedRight');
		}
		this.health -= dmg;
		this.immuneTime = 500;
		
		return true;
	}
	return false;
}

function shootBullet()
{
	var bullet;
	if(this.type == "Red")
	{
		bullet = new Projectile(this.gridPos.x, this.gridPos.y, "blastRight");
		bullet.setSpeedAndDamage(1000,6);
	}
	else if(this.type == "Blue")
	{
		bullet = new Projectile(this.gridPos.x, this.gridPos.y, "blastLeft");
		bullet.setSpeedAndDamage(-1000,6);
	}
	bullet.setBulletFrom(this.type);
}
function moveLeft()
{
	if (grid.at(this.gridPos.x-1, this.gridPos.y).type == this.type && this.deltaMove <= 0)
	{
		this.deltaMove = this.moveTime;
		this.nextPos.x--;
	}
}
function moveRight()
{
	if(grid.at(this.gridPos.x+1, this.gridPos.y).type == this.type && this.deltaMove <= 0)
	{
		this.deltaMove = this.moveTime;
		this.nextPos.x++;
	}
}
function moveUp()
{
	if (grid.at(this.gridPos.x, this.gridPos.y+1).type == this.type && this.deltaMove <= 0)
	{
		this.deltaMove = this.moveTime;
		this.nextPos.y++;
	}
}
function moveDown()
{
	if (grid.at(this.gridPos.x, this.gridPos.y-1).type == this.type && this.deltaMove <= 0)
	{
		this.deltaMove = this.moveTime;
		this.nextPos.y--;
	}
}

Player.prototype.update = function()
{
	if(this.deltaMove > 0)
	{
		this.deltaMove-= game.time.elapsed;
		
		this.mask.x = this.gameObject.x-100;
		this.mask.y = this.gameObject.y-100;
		this.gameObject.mask = this.mask;
		if(this.deltaMove <= 0)
		{
			this.gridPos.x = this.nextPos.x;
			this.gridPos.y = this.nextPos.y;
			this.gameObject.x = grid.at(this.gridPos.x, this.gridPos.y).x;
			this.gameObject.y = grid.at(this.gridPos.x, this.gridPos.y).y;
			this.gameObject.mask = null;
			this.mask.x = -9000;
			this.mask.y = -9000;
		}
	}
	if(this.immuneTime > 0)
	{
		this.immuneTime -= game.time.elapsed;
		if((this.immuneTime / 10) % 2 > 1 && this.gameObject.alpha == 1.0)
		{
			this.gameObject.alpha = 0.5;
		}
		else
		{
			this.gameObject.alpha = 1.0;
		}
		
		if(this.immuneTime <= 0)
		{
			if(this.type == "Red")
			{
				this.gameObject.loadTexture('gatorLeft');
			}
			else if(this.type == "Blue")
			{
				this.gameObject.loadTexture('gatorRight');
			}
			this.gameObject.alpha = 1.0;
		}
	}
}