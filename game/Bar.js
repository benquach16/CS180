function Bar(x, y, length, height, color)
{
	this.x = x;
	this.y = y;
	this.color = color;
	this.fullLength = length;
	this.length = length;
	this.height = height;
	
	this.bar = game.add.graphics(0, 0);
	this.bar.beginFill(color);
	this.bar.drawRect(x, y, length, height);
}

Bar.prototype.update = function(health, fullHealth)
{
	this.length = this.fullLength * (health / fullHealth);
	this.bar.clear();
	if(this.length >= 0)
	{
		this.bar.beginFill(this.color);
		this.bar.drawRect(this.x, this.y, this.length, this.height);
	}
}