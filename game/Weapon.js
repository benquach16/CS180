function Weapon(damage, speed, fireRate, type)
{
	this.type = type;
	this.damage = damage;
	this.speed = speed;
	if(type == TileType.Blue)
	{
		this.speed = -speed;
	}
	this.fireRate = fireRate;
}

Weapon.prototype.shoot = function(x, y)
{
	var bullet;
	if(this.type == TileType.Red)
	{
		if(this.speed < 750)
		{
			bullet = new Grenade(x, y, this.speed, this.damage, "blastRight");
		}
		else
		{
		bullet = new Projectile(x, y, this.speed, this.damage, "blastRight");
		}
		
	}
	else if(this.type == TileType.Blue)
	{
		if(this.speed < 750)
		{
			bullet = new Grenade(x, y, this.speed, this.damage, "blastLeft");
		}
		else
		{
		bullet = new Projectile(x, y, this.speed, this.damage, "blastLeft");
		}
		
	}
	bullet.setBulletFrom(this.type);
	//console.log(bullet.bulletFrom);
}