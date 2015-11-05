{
	this.weapon = [];
	this.health = 100;
	this.armor = 0; 
	this.specialGauge = 0;
	this.deltaSpecial = 0;
	this.curSpecial = 0;
	this.energyGauge = 0;
	this.deltaEnergy = 0;
	this.curEnergy = 0;
	this.immuneTime = 0;
	
	this.standardScale = 2.5;
	
	//Time is in milliseconds, so moveTime and moveDuration must be in milliseconds as well
	this.moveDuration = 250;
	this.moveTime = 0;
	this.nextPos = new Coords(posX, posY);
	this.gridPos = new Coords(posX, posY);
	
	this.gameObject = game.add.sprite(grid.at(posX, posY).x, grid.at(posX, posY).y, spriteName);
	this.gameObject.anchor.x = 0.5;
	
	//Create the player's fade out mask
    this.mask = game.add.graphics(0, 0);
	for(var q = 0; q < 100; q+=1)
	{
		this.mask.drawRect(q,1,q+1,300);
	}
	
	this.mask.x = -9000;
	this.mask.y = -9000;
	
	
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
		this.health -= dmg;
		this.immuneTime = 500;
		
		return true;
	}
	return false;
}

{
	var bullet;
	{
		bullet = new Projectile(this.gridPos.x, this.gridPos.y, "blastRight");
		bullet.setSpeedAndDamage(1000,6);
	}
	{
		bullet = new Projectile(this.gridPos.x, this.gridPos.y, "blastLeft");
		bullet.setSpeedAndDamage(-1000,6);
	}
	bullet.setBulletFrom(this.type);
}

Player.prototype.moveLeft = function()
{
	{
		this.nextPos.x--;
	}
}
{
	{
		this.nextPos.x++;
	}
}
{
	{
		this.nextPos.y++;
	}
}
{
	{
		this.nextPos.y--;
	}
}

Player.prototype.update = function()
{
	{
		
		this.mask.x = this.gameObject.x-100;
		this.mask.y = this.gameObject.y-100;
		this.gameObject.mask = this.mask;
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
		{
			if(this.type == TileType.Red)
			{
				this.gameObject.loadTexture('gatorLeft');
			}
			else if(this.type == TileType.Blue)
			{
				this.gameObject.loadTexture('gatorRight');
			}
			this.gameObject.alpha = 1.0;
		}
	}
}