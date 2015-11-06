//NOTE: x and y are upper left coordinatess
var projectileGroup;
var projectiles = [];

//For now, speed is useless for grendages, since they need to follow the arc.
//I doubt this mechanic will need to be changed, but it can be in the future.
function Grenade(x, y, speed, damage, spriteName) // Constructor
{	
	this.gameObject = projectileGroup.create(0,0,spriteName);
	this.spriteName = spriteName;
	this.gridPos = new Coords(x,y);
	this.gameObject.x = grid.at(x,y).x;
	this.gameObject.y = grid.at(x,y).y;
	
	this.bulletFrom = 0;
	this.damage = damage;
	game.physics.arcade.enable([this.gameObject]);
	
    this.gameObject.body.allowRotation = false;
	
    this.width = 1;
	this.height = 1;
	
	this.damageTilesX = [0,1,-1,0,0];
	this.damageTilesY = [0,0,0,-1,1];
	
	this.lobTime = 1000;
	this.lobTimer = 1000;
	
	this.explosionDuration = 250;
	this.explosionTimer = 0;
	
	this.gameObject.anchor.x = 0.5;
	this.gameObject.anchor.y = -0.5;
	projectiles.push(this);
};

function destroyProjectile(index)
{
	//TODO: remove the projectile from projectiles and possibly projectileGroup
	projectiles[index].gameObject.destroy();
	projectiles.splice(index, 1);
};

Grenade.prototype.isFinished = function(index)
{
	//Checks if the Grenade is offscreen, or done exploding.
	//If it is, we can destroy the Grenade.
	if(!this.gameObject.inCamera || (this.lobTimer <= 0 && this.explosionTimer <= 0))
	{
		destroyProjectile(index); 
		return true;
	} 
	return false;
};

Grenade.prototype.setBulletFrom = function(bulletFrom)
{
	this.bulletFrom = bulletFrom;
	this.gameObject.body.velocity = new Phaser.Point(
					this.bulletFrom == TileType.Red ? 400: -400, 
					-950);
};

Grenade.prototype.setSize = function(width, height)
{
    this.width = width;
	this.height = height;
};
//Updates the tiles in which the Grenade is doing damage to.
Grenade.prototype.updateGridPos = function ()
{
	if(this.lobTimer <= 0)
	{
		this.explosionTimer -= game.time.elapsed;
	}
	else
	{
		this.gameObject.body.velocity.y += game.time.elapsed*2;
		this.lobTimer -= game.time.elapsed;
		if(this.lobTimer <= 0)
		{
			this.gridPos.x += 3 * ((this.bulletFrom == TileType.Red) ? 1:-1); 
			this.explosionTimer = this.explosionDuration;
			this.gameObject.kill();
		}
	}
};

Grenade.prototype.updateDamagePositions = function()
{
	var retCoords = [];
	if(this.lobTimer > 0) {return [];}
	for(var i = 0; i < this.damageTilesX.length; i++)
	{
		retCoords.push(new Coords(this.gridPos.x-this.damageTilesX[i], this.gridPos.y-this.damageTilesY[i]));
	}
	return retCoords;
};
