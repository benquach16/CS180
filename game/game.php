<!doctype html> 
<html lang="en"> 
<head> 
	<meta charset="UTF-8" />
    <title>Phaser - Making your first game, part 9</title>
	<script type="text/javascript" src="js/phaser.min.js"></script>
    <style type="text/css">
        body {
            margin: 0;
        }
    </style>
</head>
<body>

<script type="text/javascript">

var game = new Phaser.Game(800, 600, Phaser.AUTO, '', { preload: preload, create: create, update: update });

var matrix_l;
var matrix_r;
var x;
var y;
var l_pressed;
var r_pressed;
var d_pressed;
var u_pressed;

function preload() {

    game.load.image('stage', 'assets/battleStage.png');
	game.load.image('gator_l', 'assets/gator_l.png');
	game.load.image('gator_r', 'assets/gator_r.png');
	game.load.spritesheet('background', 'assets/background.png', 256, 256);
	
	function coord(x_val, y_val)
	{
		this.x = x_val;
		this.y = y_val;
	}
	
	matrix_l = [];
	for(var i = 0; i < 3; i++)
		matrix_l[i] = new Array(3);
		
	matrix_l[0][0] = new coord(70, 450);
	matrix_l[1][0] = new coord(205, 450);
	matrix_l[2][0] = new coord(330, 450);
	matrix_l[0][1] = new coord(70, 380);
	matrix_l[1][1] = new coord(205, 380);
	matrix_l[2][1] = new coord(330, 380);
	matrix_l[0][2] = new coord(70, 310);
	matrix_l[1][2] = new coord(205, 310);
	matrix_l[2][2] = new coord(330, 310);
	
	matrix_r = [];
	for(var i = 0; i < 3; i++)
		matrix_r[i] = new Array(3);
		
	matrix_r[0][0] = new coord(470, 450);
	matrix_r[1][0] = new coord(605, 450);
	matrix_r[2][0] = new coord(730, 450);
	matrix_r[0][1] = new coord(470, 380);
	matrix_r[1][1] = new coord(605, 380);
	matrix_r[2][1] = new coord(730, 380);
	matrix_r[0][2] = new coord(470, 310);
	matrix_r[1][2] = new coord(605, 310);
	matrix_r[2][2] = new coord(730, 310);
	
	x = 0;
	y = 0;
	l_pressed = false;
	r_pressed = false;
	u_pressed = false;
	d_pressed = false;
}

var background;
var player_l;
var cursors;

function create() {

    //  We're going to be using physics, so enable the Arcade Physics system
    game.physics.startSystem(Phaser.Physics.ARCADE);

    //  A simple background for our game
	background = game.add.sprite(0, 0, 'background');
	background.scale.setTo(3.125,2.34);
	
	background.animations.add('loop');
	background.animations.play('loop', 2, true);
	
    var stage = game.add.sprite(0, 368, 'stage');

    //  Scale it to fit the width of the game (the original sprite is 400x32 in size)
    stage.scale.setTo(3.35, 3);
	
    //  This stops it from falling away when you jump on it
    
	//stage.body.immovable = true;

    // The player and its settings
    player_l = game.add.sprite(matrix_r[0][0].x, matrix_r[0][0].y, 'gator_l');
	player_l.anchor.x = 0.5;
	player_l.scale.setTo(2.5, 2.5);
	
    //  We need to enable physics on the player
    //game.physics.arcade.enable(player);
 
    //  Our controls.
    cursors = game.input.keyboard.createCursorKeys();
}

function update() {

    //  Checks to see if the player overlaps with any of the stars, if he does call the collectStar function
    //game.physics.arcade.overlap(player, stars, collectStar, null, this);
	
	console.log(x + ' ' + y);
	
	if (cursors.left.isDown  && !l_pressed)
    {
        if(x > 0)
		{
			x--;
			player_l.x = matrix_r[x][y].x;
		}
    }
	
	if(cursors.right.isDown && !r_pressed)
	{
		if(x < 2)
			{
				x++;
				player_l.x = matrix_r[x][y].x;
			}
	}
	
	if (cursors.up.isDown && !u_pressed)
	{
		if(y < 2)
		{
			y++;
			player_l.y = matrix_r[x][y].y;
		}
	}
	
	if (cursors.down.isDown && !d_pressed)
	{
		if(y > 0)
		{
			y--;
			player_l.y = matrix_r[x][y].y;
		}
	}
	
	l_pressed = cursors.left.isDown;
	
	r_pressed = cursors.right.isDown;
		
	u_pressed = cursors.up.isDown;
		
	d_pressed = cursors.down.isDown;
}

</script>

</body>
</html>