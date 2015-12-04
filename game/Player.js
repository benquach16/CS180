function Player(posX, posY, spriteName, weapons)
{
	this.weapons = weapons;
	this.curWeapon = weapons[0];
	this.fullHealth = 100;
	this.health = 100;
	this.armor = 0; 
	this.specialGauge = 0;
	this.deltaSpecial = 0;
	this.curSpecial = 0;
	this.energyGauge = 0;
	this.deltaEnergy = 0;
	this.curEnergy = 0;
	this.immuneTimer = 0;
	
	this.standardScale = 2.5;
	
	//Time is in milliseconds, so moveTimer and moveDuration must be in milliseconds as well
	this.moveDuration = 250;
	this.moveTimer = 0;
	this.nextPos = new Coords(posX, posY);
	this.gridPos = new Coords(posX, posY);
	
	this.deathDuration = 3000;
	this.deathTimer = 0;
	
	this.reloadDuration = weapons[0].fireRate;
	this.reloadTimer = 0;
	
	this.firingDuration = 100;
	this.firingTimer = 0;
	
	this.gameObject = game.add.sprite(grid.at(posX, posY).x, grid.at(posX, posY).y, spriteName);
	this.gameObject.anchor.x = 0.5;
	this.gameObject.scale.setTo(this.standardScale, this.standardScale);
	this.gameObject.anchor.y = 0;
	
	//Create the player's fade out mask
    this.mask = game.add.graphics(0, 0);
	this.mask.beginFill(0x777777);
	for(var q = 0; q < 100; q+=1)
	{
		this.mask.drawRect(q,1,q+1,300);
	}
	
	this.mask.x = -9000;
	this.mask.y = -9000;
	
	
	if(spriteName == "gatorLeft")
	{
		this.type = TileType.Red;
		game.input.keyboard.addKey(Phaser.Keyboard.A).onDown.add(this.moveLeft, this);
		game.input.keyboard.addKey(Phaser.Keyboard.D).onDown.add(this.moveRight, this);
		game.input.keyboard.addKey(Phaser.Keyboard.W).onDown.add(this.moveUp, this);
		game.input.keyboard.addKey(Phaser.Keyboard.S).onDown.add(this.moveDown, this);
		game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR).onDown.add(this.shootBullet, this);
		game.input.keyboard.addKey(Phaser.Keyboard.F).onDown.add(this.switchWeapon, this);
	}
};

Player.prototype.switchWeapon = function()
{
	if(this.curWeapon == this.weapons[0])
	{
		this.curWeapon = this.weapons[1];
		this.reloadDuration = this.weapons[1].fireRate;
		console.log(this.type + " equipped: Slow Gun");
	}
	else
	{
		this.curWeapon = this.weapons[0];
		this.reloadDuration = this.weapons[0].fireRate;
		console.log(this.type + " equipped: Fast Gun");
	}
}

Player.prototype.deathAnim = function()
{
	this.deathTimer = this.deathDuration;
	if(this.type == TileType.Red)
	{
		this.gameObject.loadTexture('gatorDamagedLeft');
	}
	else if(this.type == TileType.Blue)
	{
		this.gameObject.loadTexture('gatorDamagedRight');
	}
}

Player.prototype.takeDamage = function(dmg)
{
	if(this.immuneTimer <= 0)
	{
		this.health -= dmg;
		if(this.health <= 0)
		{
			this.deathAnim();
			return true;
		}
		if(this.type == TileType.Red)
		{
			this.gameObject.loadTexture('gatorDamagedLeft');
		}
		else if(this.type == TileType.Blue)
		{
			this.gameObject.loadTexture('gatorDamagedRight');
		}
		this.immuneTimer = 500;
		
		return true;
	}
	return false;
}

Player.prototype.shootBullet = function()
{
	if(this.moveTime > 0 || this.reloadTimer > 0){return;}
	
	this.curWeapon.shoot(this.gridPos.x, this.gridPos.y);
	
	conn.send({type:ConnData.Weapon, damage:this.curWeapon.damage, speed:this.curWeapon.speed, fireRate:this.curWeapon.fireRate});

	this.reloadTimer = this.reloadDuration;
	this.firingTimer = this.firingDuration;
	
	/*this.curWeapon.shoot(this.gridPos.x, this.gridPos.y);*/
}

Player.prototype.moveLeft = function()
{
	if (grid.at(this.gridPos.x-1, this.gridPos.y).type == this.type && this.moveTimer <= 0 && this.firingTimer <= 0)
	{
		this.moveTimer = this.moveDuration;
		this.nextPos.x--;
		conn.send({type:"Move", x:this.nextPos.x, y:this.nextPos.y});
	}
}

Player.prototype.moveRight = function()
{
	if(grid.at(this.gridPos.x+1, this.gridPos.y).type == this.type && this.moveTimer <= 0 && this.firingTimer <= 0)
	{
		this.moveTimer = this.moveDuration;
		this.nextPos.x++;
		conn.send({type:"Move", x:this.nextPos.x, y:this.nextPos.y});
	}
}

Player.prototype.moveUp = function()
{
	if (grid.at(this.gridPos.x, this.gridPos.y+1).type == this.type && this.moveTimer <= 0 && this.firingTimer <= 0)
	{
		this.moveTimer = this.moveDuration;
		this.nextPos.y++;
		conn.send({type:"Move", x:this.nextPos.x, y:this.nextPos.y});
	}
}

Player.prototype.moveDown = function()
{
	if (grid.at(this.gridPos.x, this.gridPos.y-1).type == this.type && this.moveTimer <= 0 && this.firingTimer <= 0)
	{
		this.moveTimer = this.moveDuration;
		this.nextPos.y--;
		conn.send({type:"Move", x:this.nextPos.x, y:this.nextPos.y});
	}
}

Player.prototype.disableInput = function()
{
	game.input.keyboard.removeKey(Phaser.Keyboard.W);
	game.input.keyboard.removeKey(Phaser.Keyboard.A);
	game.input.keyboard.removeKey(Phaser.Keyboard.S);
	game.input.keyboard.removeKey(Phaser.Keyboard.D);
	game.input.keyboard.removeKey(Phaser.Keyboard.F);
	game.input.keyboard.removeKey(Phaser.Keyboard.SPACEBAR);
}

Player.prototype.reset = function()
{
	this.gameObject.x = 99999;
	this.gameObject.y = 99999;
}

Player.prototype.update = function()
{
	this.reloadTimer -= game.time.elapsed;
	this.firingTimer -= game.time.elapsed;
	if(this.deathTimer > 0)
	{
		this.deathTimer -= game.time.elapsed;
		if((this.deathTimer / 10) % 2 > 1 && this.gameObject.alpha == 1.0)
		{
			this.gameObject.alpha = 0.5;
		}
		else
		{
			this.gameObject.alpha = 1.0;
		}
		if(this.deathTimer <= 0)
		{
			this.gameObject.alpha = 0.0;
			//this.gameObject.kill();
			this.gameObject.destroy();
		}
	}
	if(this.moveTimer > 0)
	{
		this.moveTimer-= game.time.elapsed;
		
		this.mask.x = this.gameObject.x-100;
		this.mask.y = this.gameObject.y-100;
		this.gameObject.mask = this.mask;
		
		this.gameObject.scale.setTo(
			this.standardScale*((this.moveTimer/this.moveDuration-1.0)*.125+1.0), 
			this.standardScale*((1.0-this.moveTimer/this.moveDuration)*.125+1.0));
		
		this.gameObject.anchor.y = 1-1/((1-this.moveTimer/this.moveDuration)*.125+1.0);
		
		if(this.moveTimer <= 0) 
		{
			this.gridPos.x = this.nextPos.x;
			this.gridPos.y = this.nextPos.y;
			this.gameObject.x = grid.at(this.gridPos.x, this.gridPos.y).x;
			this.gameObject.y = grid.at(this.gridPos.x, this.gridPos.y).y;
			this.gameObject.mask = null;
			this.mask.x = -9000;
			this.mask.y = -9000;
			this.gameObject.scale.setTo(this.standardScale, this.standardScale);
			this.gameObject.anchor.y = 0;
		}
	}
	if(this.immuneTimer > 0)
	{
		this.immuneTimer -= game.time.elapsed;
		if((this.immuneTimer / 10) % 2 > 1 && this.gameObject.alpha == 1.0)
		{
			this.gameObject.alpha = 0.5;
		}
		else
		{
			this.gameObject.alpha = 1.0;
		}
		
		if(this.immuneTimer <= 0)
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