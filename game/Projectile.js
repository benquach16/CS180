//NOTE: x and y are upper left coordinatess

var projectiles;

function Projectile(x, y, spriteName) // Constructor
{
	this.gameObject = projectiles.create(0,0,spriteName);
	
	this.spriteName = spriteName;
	this.gameObject.x = grid.at(x,y).x;
	this.gameObject.y = grid.at(x,y).y;
	this.bulletFrom = 0;
	this.damage = 0;
    this.gameObject.body.allowRotation = false;
	//this.gameObject.body.immovable = true;
    this.width = 1;
	this.height = 1;
	this.gridPos = new Coords(0,0);
	
	this.damageTilesX = [0];
	this.damageTilesY = [0];
};

Projectile.prototype.setBulletFrom = function(bulletFrom)
{
	this.bulletFrom = bulletFrom;
};

Projectile.prototype.setSpeedAndDamage = function(speed, damage)
{
	game.physics.arcade.enable([this.gameObject]);
	this.gameObject.body.velocity = new Phaser.Point(speed, 0);
	this.damage = damage;
};

Projectile.prototype.setSize = function(width, height)
{
    this.width = width;
	this.height = height;
	
};
//Updates the tiles in which the projectile is doing damage to.
Projectile.prototype.setGridPos = function ()
{
	for(var y = 0; y < 3; i++)
	{
		var prevY = grid[0][0].y + grid.yHeight*(y);
		var curY = grid[0][0].y + grid.yHeight*(y+1);
		
		if(prevY < this.y && this.y < curY)
		{
			this.gridPos.y = y;
			break;
		}
	}
	for(var x = 0; x < 6; x++)
	{
		var prevX = grid[0][0].x + grid.xWidth*(x);
		var curX = grid[0][0].x + grid.xWidth*(x+1);
		
		if(prevX < this.x && this.x < curX)
		{
			this.gridPos.x = x;
			break;
		}
	}
}
Projectile.prototype.updateGridPositions = function()
{
	this.setGridPos();
	var retCoords = [];
	
	for(var i = 0; i < damageTilesX.length; i++)
	{
		retCoords.push(Coords(damageTilesX[i]-this.gridPosX, damageTilesY[i]-this.gridPosY));
	}
	return retCoords;
};
