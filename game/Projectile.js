//NOTE: x and y are upper left coordinatess

var projectileGroup;
var projectiles = [];

function Projectile(x, y, speed, damage, spriteName) // Constructor
{
	this.gameObject = projectileGroup.create(0,0,spriteName);
	this.spriteName = spriteName;
	this.gameObject.x = grid.at(x,y).x;
	this.gameObject.y = grid.at(x,y).y;
	this.bulletFrom = 0;
	this.damage = damage;
    this.gameObject.body.allowRotation = false;  
	//this.gameObject.body.immovable = true;
    this.width = 1;
	this.height = 1;
	this.gridPos = new Coords(x,y);
	
	this.damageTilesX = [0];
	this.damageTilesY = [0];
	this.gameObject.anchor.x = 0.5;
	this.gameObject.anchor.y = -0.5;
	projectiles.push(this);
	
	game.physics.arcade.enable([this.gameObject]);
	this.gameObject.body.velocity = new Phaser.Point(speed, 0);
};

function destroyProjectile(index)
{
	//TODO: remove the projectile from projectiles and possibly projectileGroup
	projectiles[index].gameObject.destroy();
	projectiles.splice(index, 1);
}

Projectile.prototype.isOffscreen = function(index)
{
	//Checks if the projectile is offscreen.
	//If it is, we can destroy the projectile.
	if(!this.gameObject.inCamera)
	{
		destroyProjectile(index);
		return true;
	}
	return false;
}

Projectile.prototype.setBulletFrom = function(bulletFrom)
{
	this.bulletFrom = bulletFrom;
};

Projectile.prototype.setSpeedAndDamage = function(speed, damage)
{
	this.damage = damage;
};

Projectile.prototype.setSize = function(width, height)
{
    this.width = width;
	this.height = height;
	
};
//Updates the tiles in which the projectile is doing damage to.
Projectile.prototype.updateGridPos = function ()
{
	var prevY = grid.at(this.gridPos.x, this.gridPos.y).y - grid.tileHeight / 2;
	var curY = grid.at(this.gridPos.x, this.gridPos.y).y + grid.tileHeight / 2;
	
	if(!(prevY < this.gameObject.y && this.gameObject.y < curY))
	{
		this.gridPos.y += 1;
	}
	
	var prevX = grid.at(this.gridPos.x, this.gridPos.y).x - grid.tileWidth / 2;
	var curX = grid.at(this.gridPos.x, this.gridPos.y).x + grid.tileWidth / 2;
	
	if(!(prevX < this.gameObject.x && this.gameObject.x < curX))
	{
		if(this.bulletFrom == TileType.Red)
		{
			this.gridPos.x += 1;
		}
		else if(this.bulletFrom == TileType.Blue)
		{
			this.gridPos.x -= 1;
		}
	}
	this.gridPos.x = clamp(this.gridPos.x, 0, grid.numTilesX-1);
	this.gridPos.y = clamp(this.gridPos.y, 0, grid.numTilesY-1);
	
};
Projectile.prototype.updateDamagePositions = function()
{
	var retCoords = [];
	
	for(var i = 0; i < this.damageTilesX.length; i++)
	{
		retCoords.push(new Coords(this.gridPos.x-this.damageTilesX[i], this.gridPos.y-this.damageTilesY[i]));
	}
	return retCoords;
};
