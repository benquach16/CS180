var TileType = {
	Null: "Null",
    Red : "Red",
    Blue : "Blue",
    Blank : "Blank"
}

function Tile(x_val, y_val, type)
{
	this.x = x_val;
	this.y = y_val;
	//Types:
	//red
	//blue
	//blank (used when neither side owns)
	//null (used when the tile doesn't exist)
	this.type = type;
	//Reset timer. Will reset to the standard color after when it reaches 0.
	this.resetTimer = 0;
};

//This is to be used for the coordinates on the grid, and not the tile's position
//in world space. Although we can used Tile to do the same thing, this helps with
//visualization and keeping track of which one is which.
function Coords(xPos, yPos)
{
	this.x = xPos;
	this.y = yPos;
};
function Grid(offsetX, offsetY, width, height, numTilesX, numTilesY)
{
	this.offsetX = offsetX;
	this.offsetY = offsetY;
	//this.tileWidth = width / numTilesX;
	//this.tileHeight = height / numTilesY;
	this.tileWidth = 130;
	this.tileHeight = 70;
	this.offsetXRight = offsetX + (width / 2);
	this.numTilesX = numTilesX;
	this.numTilesY = numTilesY;
	
	
	this.gridArray = [];
	game.time.events.repeat(Phaser.Timer.SECOND, 10, this.tileUpdate, this);
	
	this.nullTile = new Tile(-1,-1, TileType.Null);
};

Grid.prototype.createGrid = function()
{
	for(var i = 0; i < this.numTilesX; i++)
	{
		this.gridArray[i] = new Array(this.numTilesY);
		for(var j = 0; j < this.numTilesY; j++)
		{
			if(i < 3)
			{
				this.gridArray[i][j] = new Tile(this.offsetX + (this.tileWidth * i), this.offsetY - (this.tileHeight * j), TileType.Red);
			}
			else
			{
				this.gridArray[i][j] = new Tile(this.offsetX + (this.tileWidth * i), this.offsetY - (this.tileHeight * j), TileType.Blue);
			}
		}
	}
};

Grid.prototype.at = function(xPos, yPos)
{
	//console.log("Coords:" + xPos +", "+ yPos);
	if(0 <= xPos && xPos < this.numTilesX && 0 <= yPos && yPos < this.numTilesY)
	{
		return this.gridArray[xPos][yPos];
	}
	else
	{
		//console.log(this.nullTile.type);
		return this.nullTile;
	}
}
Grid.prototype.tileUpdate = function()
{
	for(var i = 0; i < this.numTilesX; i++)
	{
		for(var j = 0; j < this.numTilesY; j++)
		{
			if(this.gridArray[i][j].resetTimer > 0)
			{
				this.gridArray[i][j].resetTimer--;
				if(this.gridArray[i][j].resetTimer == 0)
				{
					if(j < numTilesX/2)
					{
						this.gridArray[i][j].type = TileType.Red;
					}
					else
					{
						this.gridArray[i][j].type = TileType.Blue;
					}
				}
			}
		}
	}
}