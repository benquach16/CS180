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

/*Bar.prototype.update = function()
{
	this.bar.width = length;
}*/

Bar.prototype.decrease = function(health, fullHealth)
{
	this.length = this.fullLength * (health / fullHealth);
	this.bar.clear();
	this.bar.beginFill(this.color);
	this.bar.drawRect(this.x, this.y, this.length, this.height);
}

Bar.prototype.increase = function(amount, health)
{
	this.length += amount;
	//this.update();
}